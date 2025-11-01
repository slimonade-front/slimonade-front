<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php $this->insert('common::head', ['title' => $title, 'description' => $description, 'keyword' => $keyword, 'headBefore' => $headBefore . $this->section('before-head'), 'headAfter' => $headAfter . $this->section('after-head')]) ?>
<body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<div id="page" class="col-md-12">
    <div class="row">
        <div class="content col-md-10">
            <?= $bodyBefore . $this->section('before-body') ?>
            <?= $this->section('page') ?>
            <?= $bodyAfter . $this->section('after-body') ?>
        </div>
        <div class="col-md-2">
            <?= $this->section('right') ?>
        </div>
    </div>
</div>
<?php $this->insert('common::foot', ['footBefore' => $footBefore . $this->section('before-foot'), 'footAfter' => $footAfter . $this->section('after-foot')]) ?>
</body>
</html>
