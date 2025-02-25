<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD System Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js "></script>
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
                                <div class="col-md-8"><button type="button" class="btn btn-primary addUser">
                                        Add
                                    </button>
                                </div>
                                <div class="col-6 col-md-4">
                                    <form>
                                        <div class="input-group mb-3">
                                            <select class="form-select d-inline w-auto" id="selectBox">
                                                <option value="default">--Please Select--</option>
                                                <option value="set_active">Set active</option>
                                                <option value="set_not_active">Set not active</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                            <button class="btn btn-success col-2 applySelectAction">OK</button>
                                        </div>
                                    </form>
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
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Option</th>
                                    </tr>
                                </thead>
                                <tbody class="user_data"></tbody>
                            </table>
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
                        <div class="form-check form-switch">
                            <label for="">Status</label>
                            <input class="form-check-input status" type="checkbox" id="clearInput">
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleRole">Role</label>
                            <select class="form-control role" id="clearInput">
                                <option>admin</option>
                                <option>user</option>
                            </select>
                            <span class="error error_role text-danger"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="clear" class="btn btn-success save_user_data">Save Data</button>
                        </div>
                    </form>
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
                    <h4>Are you sure you want to delete this user ?</h4>
                    <input type="hidden" class="form-control delete_id" name="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger deleteUser">Delete</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>