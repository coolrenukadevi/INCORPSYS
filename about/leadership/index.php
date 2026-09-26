<?php
require_once __DIR__.'/../../includes/config.php';
$page=['slug'=>'about/leadership','h1'=>'Leadership','title'=>'Leadership | INCORPSYS','description'=>'Meet the leadership team of INCORPSYS (Incorporation System): the directors and chief executive behind the company.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'About','slug'=>'about'],['name'=>'Leadership','slug'=>'about/leadership']];
$eyebrow='About';$lead='The people responsible for INCORPSYS and the way it works.';
$faqs=[['q'=>'Who leads INCORPSYS?','a'=>'INCORPSYS is led by its Directors, Anisha Bharti and Renuka Devi, and its Chief Executive Officer, V.K Anand.'],['q'=>'What is the leadership team responsible for?','a'=>'INCORPSYS\'s services and the standards behind this website: official sources first, no invented fees, timelines or approval promises, and clear corrections when something changes.'],['q'=>'How can I contact the leadership team?','a'=>'Use the Contact page or email hello@incorpsys.com and your message will be routed to the right person.']];
ob_start();?>
<h2>Our leadership team</h2>
<?=team_grid()?>
<h2>Accountable for how we work</h2>
<p>The leadership team is responsible for INCORPSYS's services and for the standards behind this website: official sources first, no invented fees, timelines or approval promises, and clear corrections when something changes. <a href="/about/methodology/">Read our methodology</a>.</p>
<h2>Standards the team is accountable for</h2>
<ul>
  <li>Every regulatory statement comes from the authority that controls it, with a link and the date it was checked.</li>
  <li>No invented fees, processing times or approval promises; unconfirmed values are marked as not yet verified.</li>
  <li>Authority requirements are kept separate from bank and service-provider requests.</li>
  <li>Filings are prepared under our <a href="/legal/filing-quality-commitment/">Filing Quality Commitment</a>, and services are governed by our <a href="/legal/service-terms/">Service Terms</a>.</li>
  <li>Confirmed errors are corrected and the page's verification date is updated.</li>
</ul>
<?php $body=ob_get_clean(); include __DIR__.'/../../partials/simple-page.php';
