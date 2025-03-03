$(document).ready(function (e) {
  // open add or edit modal window
  $(document).on("click", ".addUser", function () {
    $("#userModalLabel").text("Add User Data");
    $(".save_user_data")
      .text("Save Data")
      .removeClass("update_user_data")
      .addClass("add_user_data");

    $(".firstname").val("");
    $(".lastname").val("");
    $(".status").prop("checked", false);
    $(".role").val("");

    $(".error").text("");

    $("#userModal").modal("show");
  });

  // select action for user
  $(document).on("click", ".applySelectAction", function (e) {
    e.preventDefault();

    let selectUsers = $(".user_check:checked").map(function () {
        return $(this).val();
      }).get();

    let action = $(this).closest("div").find(".selectBox").val();

    if (!selectUsers.length && !action) {
      $(".warningMessage").text("Please, select users and action");
      $("#warningModal").modal("show");
      return;
    }
    if (!selectUsers.length) {
      $(".warningMessage").text("Please, select users");
      $("#warningModal").modal("show");
      return;
    }
    if (!action) {
      $(".warningMessage").text("Please, select action");
      $("#warningModal").modal("show");
      return;
    }
    if (action === "delete") {
      $(".warningdeleteMessage").text(
        "Are you sure you want to delete this user(s) ?"
      );
      $("#deleteModal").modal("show");

      $(".actionDeleteUser").data("users", selectUsers);
      return;
    }

    $.ajax({
      type: "POST",
      url: "includes/select_action.php",
      data: {
        action_click_btn: true,
        user_id: selectUsers,
        operation: action,
      },
      success: function (response) {
        if (response.status) {
          selectUsers.forEach(function (userId) {
            $("tr").each(function () {
              if ($(this).find(".user_id").text() == userId) {
                let statusDot = $(this).find(".status-dot");
                if (action === "set_active") {
                  statusDot.removeClass("inactive").addClass("active");
                } else {
                  statusDot.removeClass("active").addClass("inactive");
                }
              }
            });
          });
        }
        $(".user_check:checked").prop("checked", false);
        if (!$(this).prop("checked")) {
          $(".check_all").prop("checked", false);
        }
      },
    });
  });
  // select delete users
  $(document).on("click", ".actionDeleteUser", function (e) {
    e.preventDefault();
    let usersToDelete = $(this).data("users");

    $.ajax({
      type: "POST",
      url: "includes/select_action.php",
      data: {
        action_click_btn: true,
        user_id: usersToDelete,
        operation: "delete",
      },
      success: function (response) {
        if (response.status) {
          $("#deleteModal").modal("hide");
          usersToDelete.forEach(function (userId) {
            $("tr").each(function () {
              if ($(this).find(".user_id").text() == userId) {
                $(this).remove();
              }
            });
          });
        }
      },
    });
  });

  // add user
  $(document).on("click", ".add_user_data", function (e) {
    e.preventDefault();

    let firstname = $(".firstname").val();
    let lastname = $(".lastname").val();
    let status = $(".status").prop("checked") ? "active" : "inactive";
    let role = $(".role").val();

    $.ajax({
      type: "POST",
      url: "includes/add_user.php",
      data: {
        add_user_btn: true,
        firstname: firstname,
        lastname: lastname,
        status: status,
        role: role,
      },
      success: function (response) {
        if (response.success) {
          $("#userModal").modal("hide");
          let newUser = `
          <tr>
              <td class="user_id" style="display:none">${response.user_id}</td>
              <td>
                  <input type="checkbox" class="user_check" value="${response.user_id}">
              </td>
              <td class="name">${response.firstname} ${response.lastname}</td>
              <td><span class="status-dot ${response.status}">●</span></td>
              <td>${response.role}</td>
              <td>
                  <a href="#" class="btn btn-warning btn-sm editUser"><i class="bi bi-pencil"></i></a>
                  <a href="#" class="btn btn-danger btn-sm deleteUser"><i class="bi bi-trash"></i></a>
              </td>
          </tr>
          `;
          $(".user_table").append(newUser);

          if ($(".check_all").prop("checked")) {
            $(".user_table").find(".user_check").prop("checked", true);
          }
          updateCheckAll();
        } else {
          $(".error_firstname").text(response.errors.firstname);
          $(".error_lastname").text(response.errors.lastname);
          $(".error_role").text(response.errors.role);
        }
      },
    });
  });

  // edit user
  $(document).on("click", ".editUser", function () {
    let user_id = $(this).closest("tr").find(".user_id").text();

    $.ajax({
      type: "POST",
      url: "includes/edit_user.php",
      data: {
        click_edit_btn: true,
        user_id: user_id,
      },
      success: function (response) {
        $.each(response, function (key, value) {
          $(".user_id").val(value["id"]);
          $(".firstname").val(value["firstname"]);
          $(".lastname").val(value["lastname"]);
          $(".status").prop("checked", value["status"] === "active");
          $(".role").val(value["role"]);

          $(".error").text("");
        });

        $("#userModalLabel").text("Edit User Data");
        $(".save_user_data")
          .text("Update Data")
          .removeClass("add_user_data")
          .addClass("update_user_data");

        $("#userModal").modal("show");
      },
    });
  });

  // update user
  $(document).on("click", ".update_user_data", function (e) {
    e.preventDefault();

    let user_id = $(".user_id").val();
    let firstname = $(".firstname").val();
    let lastname = $(".lastname").val();
    let status = $(".status").prop("checked") ? "active" : "inactive";
    let role = $(".role").val();

    $.ajax({
      type: "POST",
      url: "includes/update_user.php",
      data: {
        update_user_btn: true,
        user_id: user_id,
        firstname: firstname,
        lastname: lastname,
        status: status,
        role: role,
      },
      success: function (response) {
        if (response.success) {
          $("#userModal").modal("hide");
          let edit = $("tr").filter(function () {
            return $(this).find(".user_id").text() == user_id;
          });
          let isChecked = edit.find(".user_check").prop("checked");

          let userUpdate = `
            <tr>
                <td class="user_id" style="display:none">${response.user_id}</td>
                <td>
                    <input type="checkbox" class="user_check" value="${response.user_id}" ${isChecked ? "checked" : ""}>
                </td>
                <td class="name">${response.firstname} ${response.lastname}</td>
                <td><span class="status-dot ${response.status}">●</span></td>
                <td>${response.role}</td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm editUser"><i class="bi bi-pencil"></i></a>
                    <a href="#" class="btn btn-danger btn-sm deleteUser"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
          `;

          edit.replaceWith(userUpdate);
          updateCheckAll();
        } else {
          $(".error_firstname").text(response.errors.firstname);
          $(".error_lastname").text(response.errors.lastname);
        }
      },
    });
  });

  // delete user
  $(document).on("click", ".deleteUser", function () {
    let user_id = $(this).closest("tr").find(".user_id").text();
    let name = $(this).closest("tr").find(".name").text();

    $(".delete_id").val(user_id);
    $(".deleteMessage").text(`Are you sure to delete user's ${name} ?`);
    $("#deleteUser").modal("show");
  });
  $(document).on("click", ".executeUser", function (e) {
    e.preventDefault();

    let delete_id = $(".delete_id").val();

    $.ajax({
      type: "POST",
      url: "includes/delete_user.php",
      data: {
        click_delete_btn: true,
        delete_id: delete_id,
      },
      success: function (response) {
        let result = JSON.parse(response);

        if (result.status) {
          $("tr").each(function () {
            let row_id = $(this).find(".user_id").text();
            if (row_id == delete_id) {
              $(this).remove();
            }
          });
        }
        $("#deleteUser").modal("hide");
      },
    });
  });
});

// all checkbox
function checkAll(myCheckBox) {
  $(".user_check").prop("checked", myCheckBox.checked);
}
function updateCheckAll() {
  $(".check_all").prop(
    "checked",
    $(".user_check:checked").length === $(".user_check").length
  );
}
$(document).on("change", ".user_check", function () {
  updateCheckAll();
});

$(".check_all").on("change", function () {
  checkAll(this);
  updateCheckAll();
});

updateCheckAll();

// fix Blocked aria-hidden
document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("hide.bs.modal", function (event) {
    if (document.activeElement) {
      document.activeElement.blur();
    }
  });
});
