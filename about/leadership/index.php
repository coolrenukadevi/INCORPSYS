<?php
require_once __DIR__.'/../../includes/config.php';
$page=['slug'=>'about/leadership','h1'=>'Leadership','title'=>'Leadership | INCORPSYS','description'=>'Meet the leadership team of INCORPSYS (Incorporation System): the directors and chief executive behind the company.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'About','slug'=>'about'],['name'=>'Leadership','slug'=>'about/leadership']];
$eyebrow='About';$lead='The people responsible for INCORPSYS and the way it works.';
ob_start();?>
<h2>Our leadership team</h2>
<?=team_grid()?>
<h2>Accountable for how we work</h2>
<p>The leadership team is responsible for INCORPSYS's services and for the standards behind this website: official sources first, no invented fees, timelines or approval promises, and clear corrections when something changes. <a href="/about/methodology/">Read our methodology</a>.</p>
<?php $body=ob_get_clean(); include __DIR__.'/../../partials/simple-page.php';
