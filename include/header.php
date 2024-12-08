<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Logo and Brand -->
        <a class="navbar-brand" href="/home/">
            <img src="/img/static/logo.png" alt="Logo" width="40" class="d-inline-block align-text-center">
            Spoticlone
        </a>

        <!-- Hamburger menu for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/home/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Browse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Playlists</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Radio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Premium</a>
                </li>
            </ul>

            <!-- Login/Register buttons -->
            <?php
            if (isset($_SESSION['username'])) { ?>
                <div class="d-flex">
                    <a href="/profile/" class="btn btn-success me-2">Profile</a>
                    <a href="/login/logout.php" class="btn btn-outline-light">Logout</a>
                </div>
            <?php } else { ?>
                <div class="d-flex">
                    <a href="/login/login.php" class="btn btn-outline-light me-2">Login</a>
                    <a href="/login/register.php" class="btn btn-success">Register</a>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
