<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD System Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<style>
    .status-dot.active {
        color: green;
    }

    .status-dot.inactive {
        color: gray;
    }
</style>

<body>
    <div class="m-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <form>
                                        <div class="input-group mb-3">
                                            <select class="form-select d-inline w-auto selectBox">
                                                <option value="">--Please Select--</option>
                                                <option value="set_active">Set active</option>
                                                <option value="set_not_active">Set not active</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                            <button class="btn btn-success col-2 applySelectAction">OK</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-primary float-end addUser">Add User</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" class="check_all" onchange="checkAll(this)">
                                        </th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Option</th>
                                    </tr>
                                </thead>
                                <tbody class="user_table">
                                    <?php
                                    require 'includes/db.php';

                                    $fetch = mysqli_query($db, "SELECT * FROM users");
                                    $users = mysqli_fetch_all($fetch, MYSQLI_ASSOC);

                                    foreach ($users as $user) { ?>
                                        <tr>
                                            <td class="user_id" style="display:none"><?= $user["id"] ?></td>
                                            <td>
                                                <input type="checkbox" class="user_check" value="<?= $user["id"] ?>">
                                            </td>
                                            <td class="name"><?= $user["firstname"] . " " . $user["lastname"] ?></td>
                                            <td><span class="status-dot <?= $user["status"] ?>">●</span></td>
                                            <td><?= $user["role"] ?></td>
                                            <td>
                                                <a href="#" class="btn btn-warning btn-sm editUser"><i
                                                        class="bi bi-pencil"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm deleteUser"><i
                                                        class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="container my-4">
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <form>
                                        <div class="input-group mb-3">
                                            <select class="form-select d-inline w-auto selectBox">
                                                <option value="">--Please Select--</option>
                                                <option value="set_active">Set active</option>
                                                <option value="set_not_active">Set not active</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                            <button class="btn btn-success col-2 applySelectAction">OK</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-primary float-end addUser">Add User</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userModalLabel">Add User Data</h1>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" class="form-control user_id">
                        <div class="form-group mb-3">
                            <label for="">First Name</label>
                            <input type="text" class="form-control firstname" id="clearInput"
                                placeholder="Enter First Name" required>
                            <span class="error error_firstname text-danger"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Last Name</label>
                            <input type="text" class="form-control lastname" id="clearInput"
                                placeholder="Enter Last Name" required>
                            <span class="error error_lastname text-danger"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input status" type="checkbox" id="clearInput">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleRole">Role</label>
                            <select class="form-select role" id="clearInput">
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                            <span class="error error_role text-danger"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="clear" class="btn btn-success save_user_data">Save Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteUserLabel">Delete User Data</h1>
                </div>
                <div class="modal-body">
                    <h4 class="deleteMessage"></h4>
                    <input type="hidden" class="form-control delete_id" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger executeUser">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warningModalLabel">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="warningMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="warningdeleteMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger actionDeleteUser">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>