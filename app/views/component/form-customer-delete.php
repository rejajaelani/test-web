<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteCustomerModalLabel">Delete Customer</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this "<span id="nameCustomerDelete"></span>" customer?</p>
                <form action="<?= route('customer/delete') ?>" method="POST" id="customerFormDelete">
                    <input type="number" class="form-control d-none" id="id-delete" name="id">
                    <button type="submit" id="btnSubmitFormDelete" class="btn btn-sm rounded-0 btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>