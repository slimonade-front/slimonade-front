<?php $this->layout('template::1col', ['title' => $title]) ?>

<?php $this->start('page') ?>
<div class="content">
    <img alt="" src="<?= $assets->getAssetPath('Main::images/404-image-slim.jpg') ?>"/>
    <h1>oops! 404 Page Not Found</h1>
    The page your are looking for does not exits. Take me to <a href="<?=ROOT_URL?>">homepage</a>.
    <p>It&#039;s fine you can start from homepage to create new short url</p>
    <ul>
        <li>Template Engine support</li>
        <li>Dynamic links - images, CSS</li>
        <li>You can easily change the 404 template using built-in obsever event</li>
        <li>Add images and custom sections</li>
        <li>This page response speed - <span id="time"></span> seconds<script>var n = performance.now() / 1000;n=n.toFixed(4);document.querySelector('#time').innerText=n;</script></li>
    </ul>
</div>
<?php $this->stop() ?>
