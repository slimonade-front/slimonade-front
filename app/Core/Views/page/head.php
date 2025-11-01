<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->e($title) ?></title>
    <meta name="description" content="<?= $this->e($description) ?>">
    <meta name="keyword" content="<?= $this->e($keyword) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $headBefore ?>

    <link rel="stylesheet" type="text/css" href="<?php echo $assets->getAssetPath('Core::bootstrap/dist/css/bootstrap.min.css') ?>" crossorigin="anonymous">

    <script type="text/javascript">
    window.config = <?php echo json_encode(['base_url' => $this->getUrl('main_index')]) ?>;
    </script>
    <?= $headAfter ?>
</head>
