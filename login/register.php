<?php
$title = 'Register';
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';

if (isset($_SESSION['user'])) {
    header('Location: home/');
    exit();
}

?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger mt-5" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="verif_register.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
