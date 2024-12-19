<!DOCTYPE html>
<html lang="ru">
<head>
    <?php echo $modules['meta']->render($renderer, null, [
        'pageContent' => $pageContent,
        'db' => $db
    ]); ?>
</head>
<body class="bg-light">
<div class="wrapper mt-5 container bg-white border shadow">
    <?php echo $modules['header']->render($renderer, null, [
        'pageContent' => $pageContent,
        'db' => $db
    ]); ?>
    <div class="">
        <div class="row">
            <?php echo $modules['sidebar']->render($renderer, null, [
                'pageContent' => $pageContent,
                'db' => $db
            ]); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white">
                <div class="content mt-4">
                    <?=$content?>
                </div>
            </main>
        </div>
    </div>
    <?php echo $modules['footer']->render($renderer, null, [
        'pageContent' => $pageContent,
        'db' => $db
    ]); ?>
</div>
<?php echo $modules['meta']->footer($renderer, null, [
    'pageContent' => $pageContent,
    'db' => $db
]); ?>
</body>
</html>
