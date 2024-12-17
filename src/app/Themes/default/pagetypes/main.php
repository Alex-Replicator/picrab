<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?=$title?></title>
</head>
<body class="bg-light">
<div class="container-fluid p-0">
    <?php echo $renderModule('header'); ?>
    <div class="container mt-4">
        <?php echo $content ?? ''; ?>
    </div>
    <?php echo $renderModule('footer'); ?>
</div>
</body>
</html>