<?php $this->layout('template::1col', ['title' => $title]) ?>

<?php $this->start('page') ?>
<div class="content">
<h1>Cookie Policy</h1>
<p>At Slimonade Front, we believe in being clear and open about how we collect and use data related to you. In the spirit of transparency, this policy provides detailed information about how and when we use cookies. This cookie policy applies to any LinkedIn product or service that links to this policy or incorporates it by reference.</p>
<p>What Are Cookies</p>
<p>As is common practice with almost all professional websites this site uses cookies, which are tiny files that are downloaded to your computer, to improve your experience. This page describes what information they gather, how we use it and why we sometimes need to store these cookies. We will also share how you can prevent these cookies from being stored however this may downgrade or ‘break’ certain elements of the sites functionality.</p>
<p>How We Use Cookies</p>
<p>We make use of cookies to help manage the site and your visitor experience. These cookies may be used to collect analytics of ‘non-personal’ visitor activity outlines, manage user logins and personal preferences, provide relevant or timely information to you or offer focused advertisements.</p>
<p>Third Party Cookies</p>
<p>Google Recatpcha, Analytics uses cookie for there purpose. To make user experience easy and secure. It help us understand visitors needs also.</p>
<p><a href="<?= $this->getUrl('main_index') ?>">back to home</a></p>
<p>This page response speed - <span id="time"></span> seconds<script>var n = performance.now() / 1000;n=n.toFixed(4);document.querySelector('#time').innerText=n;</script></p>
</div>
<?php $this->stop() ?>
