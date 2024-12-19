<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="/index.php?id=1">PiCrab</a>

        <div class="collapse navbar-collapse" id="navbarHeader">
            <?php echo $renderModule('menu'); ?>
        </div>
        <?php echo $renderModule('auth', 'logoutAuthLink'); ?>
        <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
            <div class="me-3">
                <span class="fw-medium">Alex</span>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm">Выйти</button>
        </div>
    </div>
</nav>