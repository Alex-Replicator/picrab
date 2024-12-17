<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Главная') ?></title>
</head>
<body>
<?= $renderModule('header') ?>
<main>
    <?= $content ?? '' ?>
</main>
<?= $renderModule('footer') ?>
</body>
</html>