<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="fa_ir">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#158BFF"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/media/images/public/fav_icon.png">
    <meta name="csrf-token" content="<?= Yii::app()->request->csrfToken ?>"/>
    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description ?> ">
    <link rel="alternate" href="10behtarin.com" hreflang="fa"/>
    <title><?= (!empty($this->pageTitle) ? $this->pageTitle . ' | ' : '') . $this->siteName ?></title>

    <?php

    $baseUrl = Yii::app()->baseUrl;
    $themeBaseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    $cssCoreUrl = $cs->getCoreScriptUrl();
    $cs->registerCssFile($themeBaseUrl . '/assets/css/bootstrap.min.css');
    $cs->registerCssFile($themeBaseUrl . '/assets/js/vendors/owl-carousel/owl.carousel.min.css');
    $cs->registerCssFile($themeBaseUrl . '/assets/js/vendors/owl-carousel/owl.theme.default.min.css');
    $cs->registerCssFile($themeBaseUrl . '/assets/css/font-awesome.css');
    $cs->registerCssFile($themeBaseUrl . '/assets/js/vendors/icomoon/style.css');
    $cs->registerCssFile($themeBaseUrl . '/assets/css/iran-sans-fa-num.css');
    $cs->registerCssFile($themeBaseUrl . '/assets/css/global.css');
    $cs->registerCssFile($themeBaseUrl . '/assets/css/responsive.css');

    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile($themeBaseUrl . '/assets/js/bootstrap.min.js');
    $cs->registerScriptFile($themeBaseUrl . '/assets/js/vendors/owl-carousel/owl.carousel.min.js');
    $cs->registerScriptFile($themeBaseUrl . '/assets/js/global.js');
    ?>
</head>
<body>
<?php $this->renderPartial('//partial-views/_header'); ?>

<main class="main">
    <?php echo $content; ?>
</main>
<?php $this->renderPartial('//partial-views/_footer'); ?>
<?php $this->renderPartial('//partial-views/_login_popup'); ?>
<?php $this->renderPartial('//partial-views/_register_popup'); ?>
</body>
</html>