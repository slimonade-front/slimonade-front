<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->e($title) ?></title>
    <meta name="description" content="<?= $this->e($description) ?>">
    <meta name="keyword" content="<?= $this->e($keyword) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="dns-prefetch" href="<?= ROOT_URL ?>">
    <link rel="prerender" href="<?= $this->getUrl('shrt_index') ?>">
    <?= $headBefore ?>

    <link rel="stylesheet" href="<?= $assets->getAssetPath('Main::dist/css/bootstrap.min.css') ?>" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $this->getAssets()->getAssetPath('Main::styles.css') ?>">
    <?= $headAfter ?>
    <script src="<?php echo $assets->getAssetPath('Core::js/lemonade.min.js') ?>" crossorigin="anonymous"></script>
    <?php ?>

    <script>
    window.config = <?= json_encode(['base_url' => $this->getUrl('main_index')]) ?>;
    </script>
</head>
