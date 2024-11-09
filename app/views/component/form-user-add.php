<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route('user/add') ?>" method="POST" id="userForm">
                    <input type="number" class="form-control d-none" id="id" name="id">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" aria-label="Select Customer" name="role" id="role" required>
                            <option selected></option>
                            <option value="0">System</option>
                            <option value="1">Admin</option>
                            <option value="2">Reguler</option>
                        </select>
                    </div>
                    <button type="submit" id="btnSubmitForm" class="btn btn-sm rounded-0 btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>