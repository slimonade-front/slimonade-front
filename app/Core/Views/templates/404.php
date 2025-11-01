<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?=$this->section('before-head')?>
<?php $this->insert('common::head', ['title' => $title, 'description' => $description, 'keyword' => $keyword, 'headBefore' => $headBefore . $this->section('before-head'), 'headAfter' => $headAfter . $this->section('after-head')]) ?>
<?=$this->section('after-head')?>
<body>
<noscript>
JavaScript disable notice:
This website uses JavaScript as browser client process. Will not working if JavaScript is not enabled.
</noscript>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<div id="page" class="col-md-12">
    <?= $bodyBefore . $this->section('before-body') ?>
<?php if ($this->section('page')): ?>
<?=$this->section('page')?>
<?php else: ?>
<h1>oops! 404 Page Not Found</h1>
The page your are looking for does not exits. Take me to <a href="<?=ROOT_URL?>">homepage</a>.
                    <p>It&#039;s fine you can start from homepage to create new short url</p>
<?php endif ?>
    <?= $bodyAfter . $this->section('after-body') ?>
<div class="cookie-notice display-5" style="width: 400px;border: 1px solid #444;border-radius: 5px;padding: 20px;margin:20px;position: fixed; bottom: 5px; right: 5px; background: #ECDB54;">
    This website uses cookies to ensure you get the best experience on our website <a href="<?= $this->getUrl('main_cookie_policy') ?>">More info</a>
    </div>
</div>
<?=$this->section('before-foot')?>
<?php $this->insert('common::foot', ['footBefore' => $footBefore . $this->section('before-foot'), 'footAfter' => $footAfter . $this->section('after-foot')]) ?>
</body>
</html>
