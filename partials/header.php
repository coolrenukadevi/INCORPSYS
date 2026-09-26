<?php
$page=$page??[];
$title=$page['title']??DEFAULT_TITLE;
$description=$page['description']??DEFAULT_DESCRIPTION;
$canonical=page_url($page['slug']??'');
$robots=($noindex??false)?'noindex,follow':'index,follow,max-image-preview:large';
$ogImage=url('assets/img/og-default.png');
$nav=require __DIR__.'/../content/navigation.php';
$current=path_url($page['slug']??'');
?><!DOCTYPE html>
<html lang="en" class="no-js"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<script><?=JS_FLAG_SCRIPT?></script>
<title><?=e($title)?></title>
<meta name="description" content="<?=e($description)?>"><meta name="robots" content="<?=e($robots)?>"><?php if(!($noindex??false)):?><link rel="canonical" href="<?=e($canonical)?>"><?php endif;?>
<link rel="preload" href="<?=e(asset('fonts/inter-var-latin.woff2'))?>" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?=e(asset('css/site.css'))?>">
<link rel="icon" href="/favicon.ico" sizes="48x48"><link rel="icon" href="<?=e(asset('icons/favicon.svg'))?>" type="image/svg+xml"><link rel="icon" href="<?=e(asset('icons/favicon-32.png'))?>" type="image/png" sizes="32x32"><link rel="apple-touch-icon" href="<?=e(asset('icons/apple-touch-icon.png'))?>"><link rel="manifest" href="/manifest.webmanifest"><meta name="theme-color" content="#071A33">
<meta property="og:type" content="website"><meta property="og:site_name" content="INCORPSYS"><meta property="og:title" content="<?=e($title)?>"><meta property="og:description" content="<?=e($description)?>"><meta property="og:url" content="<?=e($canonical)?>"><meta property="og:image" content="<?=e($ogImage)?>"><meta property="og:image:width" content="1200"><meta property="og:image:height" content="630"><meta property="og:image:alt" content="INCORPSYS — Build your business beyond borders"><meta name="twitter:card" content="summary_large_image"><meta name="twitter:site" content="@incorpsys"><meta name="twitter:title" content="<?=e($title)?>"><meta name="twitter:description" content="<?=e($description)?>"><meta name="twitter:image" content="<?=e($ogImage)?>">
</head><body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header" id="site-header">
  <div class="utility"><div class="container utility-in">
    <ul class="utility-links utility-account" aria-label="Account">
      <li><a href="/login/"<?=$current==='/login/'?' aria-current="page"':''?>><?=icon('log-in')?>Login</a></li>
      <li><a class="utility-cta" href="/signup/"<?=$current==='/signup/'?' aria-current="page"':''?>>Sign Up</a></li>
    </ul>
    <p class="utility-context"><?=e(SITE_POSITIONING)?></p>
    <ul class="utility-links" aria-label="Contact">
      <li><a href="<?=e(wa_url())?>" target="_blank" rel="noopener"><?=icon('message-circle')?>WhatsApp</a></li>
    </ul>
  </div></div>
  <div class="masthead"><div class="container masthead-in">
    <a class="logo" href="/" aria-label="INCORPSYS home"><picture><source type="image/webp" srcset="<?=e(asset('img/logo-48.webp'))?> 239w, <?=e(asset('img/logo-96.webp'))?> 479w, <?=e(asset('img/logo-144.webp'))?> 718w" sizes="(max-width: 640px) 170px, 220px"><img src="<?=e(asset('img/logo-96.png'))?>" srcset="<?=e(asset('img/logo-96.png'))?> 479w, <?=e(asset('img/logo-144.png'))?> 718w" sizes="(max-width: 640px) 170px, 220px" alt="INCORPSYS — Global Company Incorporation" width="220" height="44" fetchpriority="high"></picture></a>
    <nav class="primary-nav" id="primary-nav" aria-label="Primary">
      <ul class="nav-list">
        <?php foreach($nav as $id=>$menu): if(isset($menu['url'])):?>
        <li class="nav-item"><a class="nav-link" href="<?=e($menu['url'])?>"<?=$current===$menu['url']?' aria-current="page"':''?>><?=e($menu['label'])?></a></li>
        <?php continue; endif; $cols=count($menu['cols']);?>
        <li class="nav-item">
          <button class="nav-trigger" type="button" aria-expanded="false" aria-controls="mega-<?=e($id)?>"><?=e($menu['label'])?><?=icon('chevron-down')?></button>
          <div class="mega" id="mega-<?=e($id)?>"><div class="container mega-intro"><p><b><?=e($menu['label'])?></b><span><?=e($menu['intro'])?></span></p></div><div class="container mega-in mega-cols-<?=$cols?>">
            <?php foreach($menu['cols'] as $col):?><div>
              <p class="mega-title"><?=e($col['title'])?></p>
              <ul class="mega-list"><?php foreach($col['links'] as $l):?><li><a href="<?=e($l['url'])?>"<?=$current===$l['url']?' aria-current="page"':''?>><?=icon($col['icon'])?><span><b><?=e($l['label'])?></b><small><?=e($l['desc'])?></small></span></a></li><?php endforeach;?></ul>
              <?php if(!empty($menu['all'])&&$col===end($menu['cols'])):?><a class="mega-all" href="<?=e($menu['all']['url'])?>"><?=e($menu['all']['label'])?><?=icon('arrow-right')?></a><?php endif;?>
            </div><?php endforeach;?>
            <div class="mega-feature"><b><?=e($menu['feature']['title'])?></b><p><?=e($menu['feature']['text'])?></p><a class="btn btn-on-dark btn-sm" href="<?=e($menu['feature']['url'])?>"><?=e($menu['feature']['cta'])?><?=icon('arrow-right')?></a></div>
          </div></div>
        </li>
        <?php endforeach;?>
      </ul>
      <div class="nav-mobile-only">
        <a class="btn btn-cta btn-block" href="/get-started/">Enquiry Now<?=icon('arrow-right')?></a>
      </div>
    </nav>
    <div class="header-actions">
      <a class="btn btn-cta btn-sm header-cta" href="/get-started/">Enquiry Now<?=icon('arrow-right')?></a>
      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav"><span class="icon-open"><?=icon('menu')?></span><span class="icon-close"><?=icon('x')?></span><span class="visually-hidden">Menu</span></button>
    </div>
  </div></div>
</header>
