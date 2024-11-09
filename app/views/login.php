<?php
$title = "Login - Test Web";
$pageActive = 'login';
include 'layouts/header.php';
?>

<section class="container-fluid" style="width: 100vw;height: 100vh;background-color: #E8F0FE;">
    <div class="row w-100 h-100 d-flex" style="justify-content: center;align-items: center;">
        <div class="col-3" style="height: center;">
            <div class="card border-0">
                <div class="card-header border-0">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <form action="<?= route('login-process') ?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label"><i class="bi bi-person-fill"></i>&nbsp;Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Jhon Example">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="bi bi-key-fill"></i>&nbsp;Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" aria-describedby="password-show">
                                <span class="input-group-text border-0" id="password-show" style="cursor: pointer;"><i id="icon-show-password" class="bi-eye-slash-fill"></i></span>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'layouts/script.php'; ?>
<script>
    $('#password-show').click(function() {
        const passwordInput = $('#password');
        const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
        passwordInput.attr('type', type);

        const iconPasswordShow = $('#icon-show-password');
        const typeClass = iconPasswordShow.hasClass('bi-eye-slash-fill') ? iconPasswordShow.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill') : iconPasswordShow.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
    });
</script>
<?php include 'layouts/footer.php'; ?>