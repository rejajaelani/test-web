<div class="side-bar">
    <h4 style="opacity: 0.5;">TEST-WEB</h4>
    <ul class="list-menu">
        <li>
            <a href="<?= route('dashboard') ?>" class="list <?= $pageActive === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-house-fill"></i>&nbsp;
                Dashboard
            </a>
        </li>
        <li>
            <a href="<?= route('customer') ?>" class="list <?= $pageActive === 'customer' ? 'active' : '' ?>">
                <i class="bi bi-person-lines-fill"></i>&nbsp;
                Customer Management
            </a>
        </li>
        <li>
            <a href="<?= route('order') ?>" class="list <?= $pageActive === 'order' ? 'active' : '' ?>">
                <i class="bi bi-cart-fill"></i>&nbsp;
                Order Management
            </a>
        </li>
        <?php if ($_SESSION['user']['role'] === 0 || $_SESSION['user']['role'] === 1): ?>
            <li>
                <a href="<?= route('user') ?>" class="list <?= $pageActive === 'user' ? 'active' : '' ?>">
                    <i class="bi bi-person-fill-lock"></i>&nbsp;
                    User Management
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>