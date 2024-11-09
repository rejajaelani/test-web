<?php
$controller = new OrderController();
$controller2 = new CustomerController();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$orders = $controller->listOrders($page, $search);
$customers = $controller2->listAllCustomers($page, $search);

?>

<?php
$title = "Order - Test Web";
$pageActive = "order";
include 'layouts/header.php';
?>

<div class="content">
    <h2 class="mb-5">Order Management</h2>

    <!-- Form Search -->
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search Order Name..." value="<?= htmlspecialchars($search) ?>">
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


    <!-- Button Add Order -->
    <button class="btnAddOrder btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addEditOrderModal"><i class="bi bi-person-fill-add"></i>&nbsp;Add Order</button>

    <!-- Table Order -->
    <table class="table table-responsive table-striped table-bordered">
        <tr>
            <th>No</th>
            <th>Name Order</th>
            <th>Customer Name</th>
            <th>Created Date</th>
            <th>Actions</th>
        </tr>
        <?php if (empty($orders)): ?>
            <tr>
                <td colspan="6" style="text-align: center;">Order is empty</td>
            </tr>
        <?php else: ?>
            <?php
            $index = 1;
            foreach ($orders as $order):
            ?>
                <tr>
                    <td><?= $index ?></td>
                    <td>
                        <a href="#" type="button" class="btnDetailOrder" data-bs-toggle="modal" data-bs-target="#detailOrderModal" data-id="<?= $order['id'] ?>">
                            <?= htmlspecialchars($order['name_order']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($order['name']) ?></td>
                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                    <td>
                        <button class="btnEditOrder btn btn-sm btn-primary" style="border-radius: 50%;" title="Edit Order <?= htmlspecialchars($order['name_order']) ?>" data-bs-toggle="modal" data-bs-target="#addEditOrderModal" data-id="<?= $order['id'] ?>"><i class="bi bi-pencil-square"></i></button>

                        <button class="btnDeleteOrder btn btn-sm btn-danger" style="border-radius: 50%;" title="Delete Order <?= htmlspecialchars($order['name_order']) ?>" data-bs-toggle="modal" data-bs-target="#deleteOrderModal" data-id="<?= $order['id'] ?>" data-name="<?= htmlspecialchars($order['name_order']) ?>"><i class="bi bi-trash3-fill"></i></button>
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
        <?php if (count($orders) >= 5): ?>
            <a href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>" class="btn btn-sm btn-primary">Next</a>
        <?php endif; ?>
    </div>

    <?php include 'component/btn-logout-content.php'; ?>

</div>

<!-- Modal Detail Order -->
<?php include 'component/form-order-detail.php'; ?>

<!-- Modal Add Edit Order -->
<div class="modal fade" id="addEditOrderModal" tabindex="-1" aria-labelledby="addEditOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditOrderModalLabel">Add Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route('order/add') ?>" method="POST" id="orderForm">
                    <input type="number" class="form-control d-none" id="id" name="id">
                    <div class="mb-3">
                        <label for="name_order" class="form-label">Name Order</label>
                        <input type="text" class="form-control" id="name_order" name="name_order" required>
                    </div>
                    <div class="mb-3">
                        <label for="idCustomer" class="form-label">Customer Name</label>
                        <select class="form-select" aria-label="Select Customer" name="id_customer" id="idCustomer" required>
                            <option selected></option>
                            <?php
                            foreach ($customers as $customer):
                            ?>
                                <option value="<?= $customer['id']; ?>"><?= htmlspecialchars($customer['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="orderStartDate">Order Start</label>
                        <input type="text" class="form-control" id="orderStartDate" name="order_start" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="mb-3">
                        <label for="orderEndDate">Order End</label>
                        <input type="text" class="form-control" id="orderEndDate" name="order_end" placeholder="YYYY-MM-DD">
                    </div>
                    <button type="submit" id="btnSubmitForm" class="btn btn-sm rounded-0 btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Order -->
<?php include 'component/form-order-delete.php'; ?>

<?php include 'layouts/script.php'; ?>
<script>
    $('.btnDetailOrder').click(function() {
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: '<?= route('order/API?id=') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                console.log(data);

                $('#detailNameOrder').text(data.name_order);
                $('#detailCustomerName').text(data.customer_name);
                $('#detailNotes').text(data.notes);
                $('#detailOrderStart').text(formatDate(data.order_start));
                $('#detailOrderEnd').text(formatDate(data.order_end));
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

    $('.btnAddOrder').click(function() {
        $('#orderForm').attr('action', '<?= route('order/add') ?>');
        $('#addEditOrderModalLabel').text("Add Order");
        $('#btnSubmitForm').text("Save");

        // Reset Form Order
        $('#id').val("");
        $('#name_order').val("");
        $('#idCustomer').val("");
        $('#notes').val("");
        $('#orderStartDate').val("");
        $('#orderEndDate').val("");
    });

    $('.btnEditOrder').click(function() {
        var id = $(this).data('id');

        $('#orderForm').attr('action', '<?= route('order/edit') ?>');

        $.ajax({
            url: '<?= route('order/API?id=') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.id);
                $('#name_order').val(data.name_order);
                console.log(data.id_customer);
                $('#idCustomer').val(data.id_customer);
                $('#notes').val(data.notes);
                $('#orderStartDate').val(data.order_start);
                $('#orderEndDate').val(data.order_end);
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });

        $('#addEditOrderModalLabel').text("Edit Order");
        $('#btnSubmitForm').text("Save Changes");
    });

    $('.btnDeleteOrder').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#id-delete').val(id);
        $('#nameOrderDelete').text(name);
    });

    // Inisialisasi Datepicker
    $(document).ready(function() {
        $('#orderStartDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
    $(document).ready(function() {
        $('#orderEndDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<?php include 'layouts/footer.php'; ?>