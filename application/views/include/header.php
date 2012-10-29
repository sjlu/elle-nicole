<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Liz Jamora, founder of Elle Nicole Studios, is an art director, graphic/web designer and photographer." />
   <meta name="keywords" content="photography, art direction, design, ux-design" />
   <meta name="author" content="Liz Jamora">

   <title>Elle Nicole Studios</title>

   <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script> -->
   <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.9.0/lodash.min.js"></script> -->
	<script src="<?= base_url('assets/js/app.js') ?>"></script>
</head>
<body>

   <div id="navigation">
      <img src="<?= base_url('assets/img/logo.png') ?>" alt="logo" />
      <ul>
         <? foreach ($nav as $item): ?>
            <li><a <? if (is_active($item)): ?>class="active"<? endif; ?> href="<?= site_url($item) ?>"><?= $item ?></a></li>
         <? endforeach; ?>
      </ul>
   </div>