$(document).ready(function (e) {
  getUserData();

  // open add or edit modal window
  $(document).on("click", ".addUser", function () {
    $("#userModalLabel").text("Add User Data");
    $(".save_user_data")
      .text("Save Data")
      .removeClass("update_user_data")
      .addClass("add_user_data");

    $(".firstname").val("");
    $(".lastname").val("");
    $(".status").val("");
    $(".role").val("");

    $(".error").text("");

    $("#userModal").modal("show");
  });

  // select action for user
  $(".applySelectAction").click(function (e) {
    e.preventDefault();

    let selectedUsers = $(".user_check:checked").map(function () {
        return $(this).val();
    }).get();

    let action = $("#selectBox").val();

    if (!selectedUsers.length && !action) {
        alert("Please, select users and action");
        return;
    }
    if (!selectedUsers.length) {
      alert("Please, select users");
      return;
    }
    if (!action) {
      alert("Please, select action");
      return;
    }

    $.ajax({
        type: "POST",
        url: 'includes/select_action.php', 
        data: {
            'action_click_btn': true,
            'user_id': selectedUsers,
            'operation': action,
        },
        success: function(response) {
            if (response.status) {
                getUserData();
                //$("#selectBox").val("default");
            } else {
                alert("Помилка: " + response.error.message);
            }
        }
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
        'add_user_btn': true,
        'firstname': firstname,
        'lastname': lastname,
        'status': status,
        'role': role,
      },
      success: function (response) {
        if (response.success) {
          $("#userModal").modal("hide");
          getUserData();
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
        'click_edit_btn': true,
        'user_id': user_id,
      },
      success: function (response) {
        $.each(response, function (key, value) {
          $(".user_id").val(value["id"]);
          $(".firstname").val(value["firstname"]);
          $(".lastname").val(value["lastname"]);
          $(".status").prop(value["status"]);
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
        'update_user_btn': true,
        'user_id': user_id,
        'firstname': firstname,
        'lastname': lastname,
        'status': status,
        'role': role,
      },
      success: function (response) {
        if (response.success) {
          $("#userModal").modal("hide");
          $(".user_data").html("");
          getUserData();
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

    $(".delete_id").val(user_id);
    $("#deleteUser").modal("show");

    $(".deleteUser").click(function (e) {
      e.preventDefault();

      let delete_id = $(".delete_id").val();

      $.ajax({
        type: "POST",
        url: "includes/delete_user.php",
        data: {
          'click_delete_btn': true,
          'delete_id': delete_id,
        },
        success: function (response) {
          $("#deleteUser").modal("hide");
          $(".user_data").html("");
          getUserData();
        },
      });
    });
  });
});

function getUserData() {
  $.ajax({
    type: "GET",
    url: "includes/fetch.php",
    success: function (response) {
      $(".user_data").html("");
      $.each(response.users, function (key, value) {
        $(".user_data").append(`
          <tr>
              <td class="user_id" style="display:none">${value["id"]}</td>
              <td>
                  <input type="checkbox" class="user_check" value="${value["id"]}">
              </td>
              <td>${value["firstname"]}</td>
              <td>${value["lastname"]}</td>
              <td><span class="status-dot ${value["status"]}">●</span></td>
              <td>${value["role"]}</td>
              <td>
                  <a href="#" class="btn btn-warning btn-sm editUser"><i class="bi bi-pencil"></i></a>
                  <a href="#" class="btn btn-danger btn-sm deleteUser"><i class="bi bi-trash"></i></a>
              </td>
          </tr>
        `);
      });

      // updating checkbox status "Select All"
      $(".user_check").on("change", function () {
        if (!$(this).prop("checked")) {
          $(".check_all").prop("checked", false);
        } else if ($(".user_check:checked").length === $(".user_check").length) {
          $(".check_all").prop("checked", true);
        }
      });
      if ($(".user_check:checked").length === $(".user_check").length) {
        $(".check_all").prop("checked", true);
      } else {
        $(".check_all").prop("checked", false);
      }
    },
  });
}
// all checkbox
function checkAll(myCheckBox) {
  $(".user_check").prop("checked", myCheckBox.checked);
}
