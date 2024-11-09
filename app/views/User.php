<?php
$controller = new UserController();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$users = $controller->listUsers($page, $search);

?>

<?php
$title = "User - Test Web";
$pageActive = "user";
include 'layouts/header.php';
?>

<div class="content">
    <h2 class="mb-5">User Management</h2>

    <!-- Form Search -->
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search User Name..." value="<?= htmlspecialchars($search) ?>">
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


    <!-- Button Add User -->
    <button class="btnAddUser btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-person-fill-add"></i>&nbsp;Add User</button>

    <!-- Table User -->
    <table class="table table-responsive table-striped table-bordered">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php if (empty($users)): ?>
            <tr>
                <td colspan="6" style="text-align: center;">User is empty</td>
            </tr>
        <?php else: ?>
            <?php
            $index = 1;
            foreach ($users as $user):
            ?>
                <tr>
                    <td><?= $index ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td>
                        <button class="btnDeleteUser btn btn-sm btn-danger" style="border-radius: 50%;" title="Delete User <?= htmlspecialchars($user['username']) ?>" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="<?= $user['id'] ?>" data-name="<?= htmlspecialchars($user['username']) ?>"><i class="bi bi-trash3-fill"></i></button>
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
        <?php if (count($users) >= 5): ?>
            <a href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>" class="btn btn-sm btn-primary">Next</a>
        <?php endif; ?>
    </div>

    <?php include 'component/btn-logout-content.php'; ?>

</div>

<!-- Modal Add User -->
<?php include 'component/form-user-add.php'; ?>

<!-- Modal Delete User -->
<?php include 'component/form-user-delete.php'; ?>

<?php include 'layouts/script.php'; ?>
<script>
    $('.btnAdduser').click(function() {
        $('#userForm').attr('action', '<?= route('user/add') ?>');
        $('#addUserModalLabel').text("Add User");
        $('#btnSubmitForm').text("Save");

        // Reset Form user
        $('#id').val("");
        $('#username').val("");
        $('#password').val("");
        $('#role').val("");
    });

    $('.btnDeleteUser').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#id-delete').val(id);
        $('#nameUserDelete').text(name);
    });
</script>
<?php include 'layouts/footer.php'; ?>