<header>
    <div class="p-0 bg-white border-bottom">
        <div class="row bg-white">
            <div class="col-lg-2 d-flex align-items-center p-3">
                <a class="navbar-brand align-items-center" href="/">
                    <img src="<?=$themeAssets;?>images/logo.webp" width="40" height="40" class="d-inline-block rounded-4 align-top" alt="Logo">
                    <span class="fw-medium fs-3">PiCrab</span>
                </a>
            </div>
            <div class="col-md-9 col-lg-10 d-md p-3">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <?php echo $modules['menu']->render(); ?>
                        <div class="d-flex align-items-center">
                            <?php echo $modules['auth']->logoutAuthLink(); ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
