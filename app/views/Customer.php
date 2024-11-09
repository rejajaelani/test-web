<?php
$controller = new CustomerController();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$customers = $controller->listCustomers($page, $search);

?>

<?php
$title = "Customer - Test Web";
$pageActive = "customer";
include 'layouts/header.php';
?>

<div class="content">
    <h2 class="mb-5">Customer Management</h2>

    <!-- Form Search -->
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search Customer Name..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <!-- Alert -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-sm alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']['text']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>


    <!-- Button Add Customer -->
    <button class="btnAddCustomer btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addEditCustomerModal"><i class="bi bi-person-fill-add"></i>&nbsp;Add Customer</button>

    <!-- Table Customer -->
    <table class="table table-responsive table-striped table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php if (empty($customers)): ?>
            <tr>
                <td colspan="6" style="text-align: center;">Customer is empty</td>
            </tr>
        <?php else: ?>
            <?php
            $index = 1;
            foreach ($customers as $customer):
            ?>
                <tr>
                    <td><?= $index ?></td>
                    <td>
                        <a href="#" type="button" class="btnDetailCustomer" data-bs-toggle="modal" data-bs-target="#detailCustomerModal" data-id="<?= $customer['id'] ?>">
                            <?= htmlspecialchars($customer['name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($customer['email']) ?></td>
                    <td><?= htmlspecialchars($customer['phone']) ?></td>
                    <td>
                        <button class="btnEditCustomer btn btn-sm btn-primary" style="border-radius: 50%;" title="Edit Customer <?= htmlspecialchars($customer['name']) ?>" data-bs-toggle="modal" data-bs-target="#addEditCustomerModal" data-id="<?= $customer['id'] ?>"><i class="bi bi-pencil-square"></i></button>

                        <button class="btnDeleteCustomer btn btn-sm btn-danger" style="border-radius: 50%;" title="Delete Customer <?= htmlspecialchars($customer['name']) ?>" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal" data-id="<?= $customer['id'] ?>" data-name="<?= htmlspecialchars($customer['name']) ?>"><i class="bi bi-trash3-fill"></i></button>
                    </td>
                </tr>
            <?php
                $index++;
            endforeach;
            ?>
        <?php endif; ?>
    </table>

    <!-- Link Pagenation -->
    <div>
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>" class="btn btn-sm btn-secondary">Prev</a>
        <?php endif; ?>
        <?php if (count($customers) >= 5): ?>
            <a href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>" class="btn btn-sm btn-primary">Next</a>
        <?php endif; ?>
    </div>

    <?php include 'component/btn-logout-content.php'; ?>

</div>

<!-- Modal Detail Customer -->
<?php include 'component/form-customer-detail.php'; ?>

<!-- Modal Add Edit Customer -->
<?php include 'component/form-customer-add-edit.php'; ?>

<!-- Modal Delete Customer -->
<?php include 'component/form-customer-delete.php'; ?>

<?php include 'layouts/script.php'; ?>
<script>
    $('.btnDetailCustomer').click(function() {
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: '<?= route('customer/API?id=') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#detailName').text(data.name);
                $('#detailEmail').text(data.email);
                $('#detailPhone').text(data.phone);
                $('#detailAddress').text(data.address);
                $('#detailCreated').text(formatDateTime(data.created_at));
                $('#detailCreatedBy').text(data.created_by);
                $('#detailUpdated').text(data.updated_at != null && data.updated_at != "" ? formatDateTime(data.updated_at) : "-");
                $('#detailUpdatedBy').text(data.updated_by != null && data.updated_by != "" ? data.updated_by : "-");
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });

    $('.btnAddCustomer').click(function() {
        $('#customerForm').attr('action', '<?= route('customer/add') ?>');
        $('#addEditCustomerModalLabel').text("Add Customer");
        $('#btnSubmitForm').text("Save");

        // Reset Form Customer
        $('#id').val("");
        $('#name').val("");
        $('#email').val("");
        $('#phone').val("");
        $('#address').val("");
    });

    $('.btnEditCustomer').click(function() {
        var id = $(this).data('id');
        $('#customerForm').attr('action', '<?= route('customer/edit') ?>');

        $.ajax({
            url: '<?= route('customer/API?id=') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });

        $('#addEditCustomerModalLabel').text("Edit Customer");
        $('#btnSubmitForm').text("Save Changes");
    });

    $('.btnDeleteCustomer').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#id-delete').val(id);
        $('#nameCustomerDelete').text(name);
    });
</script>
<?php include 'layouts/footer.php'; ?>