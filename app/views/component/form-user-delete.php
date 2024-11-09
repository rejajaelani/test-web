<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteUserModalLabel">Delete Order</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this "<span id="nameUserDelete"></span>" user?</p>
                <form action="<?= route('user/delete') ?>" method="POST" id="userFormDelete">
                    <input type="number" class="form-control d-none" id="id-delete" name="id">
                    <button type="submit" id="btnSubmitFormDelete" class="btn btn-sm rounded-0 btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>