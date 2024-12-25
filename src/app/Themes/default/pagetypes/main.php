<!DOCTYPE html>
<html lang="ru">
<head>
    <?php echo $modules['meta']->render(); ?>
</head>
<body class="bg-light">
<div class="wrapper mt-5 container bg-white border shadow">
    <?php echo $modules['header']->render(); ?>
    <div class="">
        <div class="row">
            <?php echo $modules['sidebar']->render(); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white">
                <div class="content mt-4">
                    <?php if (isset($modules['FormConstructor'])): ?>
                        <?php echo $modules['FormConstructor']->render(); ?>
                    <?php else: ?>
                        <!-- Вы можете что-то вывести, если FormConstructor недоступен -->
                        <p class="text-muted">Модуль FormConstructor не загружен для этой страницы.</p>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <?php echo $modules['footer']->render(); ?>
</div>
<?php echo $modules['meta']->footer(); ?>
</body>
</html>
