<?php header('Content-type: text/html; charset=utf-8'); ?>
<!doctype html>
<!--
               __              _ __
   ____ ____  / /___  ______  (_) /__
  / __ `/ _ \/ __/ / / / __ \/ / //_/
 / /_/ /  __/ /_/ /_/ / / / / / , |
 \__, /\___/\__/\__,_/_/ /_/_/_/|_|
/____/

getunik.com - we make the web a better place.
We are looking for you! Check getunik.com/jobs.

-->
<html lang="<?php echo $site->language()->code() ?>" class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">

	<link rel="canonical" href="<?php echo $page->url() ?>">
	<meta name="description" content="<?php echo strip_tags($page->metaDescription()->value()); ?>">
	<meta name="keywords" content="<?php echo strip_tags($page->metaKeywords()->value()); ?>">
	<?php if (!$site->author()->isEmpty()): ?>
		<meta name="author" content="<?php echo strip_tags($site->author()->value()) ?>">
	<?php endif ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Facebook / using generic app_id -->
	<?php if (!$site->facebookAppId()->isEmpty()): ?>
		<meta property="fb:app_id" content="<?php echo $site->facebookAppId()->value(); ?>"/>
	<?php endif ?>
	<meta property="og:locale"
		  content="<?php echo a::get(c::get('facebookLanguage', []), $site->language()->code()); ?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo strip_tags($page->title()->value()); ?>">
	<meta property="og:description" content="<?php echo strip_tags($page->metaDescription()->value()); ?>">
	<meta property="og:url" content="<?php echo $page->url(); ?>">
	<meta property="og:site_name" content="<?php echo strip_tags($site->title()->value()); ?>">
	<?php if ($socialImage = $page->socialImage()->toFile()): ?>
		<meta property="og:image" content="<?php echo thumb($socialImage, [
			'width' => 1200,
			'height' => 628,
			'crop' => true,
			'quality' => 100,
		])->url(); ?>">
	<?php endif ?>

	<!-- Twitter -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:description" content="<?php strip_tags($page->metaDescription()->value()); ?>">
	<meta name="twitter:title" content="<?php echo strip_tags($page->title()->value()); ?>">
	<?php if ($socialImage = $page->socialImage()->toFile()): ?>
		<meta property="twitter:image:src" content="<?php echo thumb($socialImage, [
			'width' => 1200,
			'height' => 628,
			'crop' => true,
			'quality' => 100,
		])->url(); ?>">
	<?php endif ?>

	<!-- CSS -->
	<?php echo css('assets/css/styles.min.css') ?>

	<link rel="icon" href="<?php echo kirby()->urls()->assets() ?>/images/favicon.ico"/>

	<title><?php echo strip_tags($site->title()->value()); ?>
		| <?php echo strip_tags($page->title()->value()); ?></title>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php echo dataLayer(); ?>
	<!-- Google Tag Manager -->
	<?php if (!$site->gtmId()->isEmpty()): ?>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?php echo $site->gtmId()->value(); ?>');</script>
	<?php endif ?>

	<?php echo kirbyjs($page); ?>
</head>
<body class="<?php echo classes([
	'env-' . ENVIRONMENT,
	'template-' . preg_replace('/\./', '--', $page->template()),
	'debug' => c::get('debug'),
]); ?>">

	<!-- Google Tag Manager (noscript) -->
	<?php if (!$site->gtmId()->isEmpty()): ?>
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $site->gtmId()->value(); ?>"
						  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<?php endif ?>
