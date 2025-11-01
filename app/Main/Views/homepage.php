<?php
//phpcs:ignore
?>
<?php $this->layout('template::1col', ['title' => $title]) ?>

<?php $this->start('page') ?>
<div class="content">
    <div class="row">
        <h1>Welcome to Slimonade Framework</h1>
    </div>
    <h2>Why to use it:</h2>
    <div class="row">
        <ul>
            <li>NO CORE FILES MODIFY REQUIRED</li>
            <li>High performace</li>
            <li>Minimal to its core</li>
            <li><strong>Zero-Down Deployment</strong> powered by <a href="https://github.com/dg/ftp-deployment/" target="_blank">FAST FTP Deployment</a> ( nette.org)</li>
            <li><strong>Custom 404 Error Page</strong> - <a href="/error">Click here</a></li>
            <li>Bootstrap CSS - BUILD and WATCHER To Purge Unwanted CSS Rule</li>
            <li>Response speed - <a href="speed-test" target="_blank">speed-test</a></li>
            <li>This page response speed - <span id="time"></span> seconds<script>var n = performance.now() / 1000;n=n.toFixed(4);document.querySelector('#time').innerText=n;</script></li>
            <li>In-built amazing features</li>
            <li>New features are added</li>
            <li>Caddy & Nginx support</li>
            <li>PHP INFO - <a href="https://slimonade-front.lovestoblog.com/phpinfo.php" target="_blank">CLICK HERE</a></li>
        </ul>
    </div>
    <h2>Tech Stack:</h2>
    <div class="row">
        <ul>
            <li><strong>PHP - Of course</strong>
                <ul>
                    <li>Fast Router</li>
                    <li>Template Engine</li>
                    <li>No Cache Yet Fast</li>
                    <li>Helper Functions</li>
                    <li>Event Oberver</li>
                    <li>Event Oberver</li>
                </ul>
            </li>
            <li>HTML</li>
            <li>JS - Lemonade JS</li>
            <li>CSS - Bootstap / Tailwind CSS</li>
        </ul>
    </div>
</div>
<?php $this->stop() ?>
