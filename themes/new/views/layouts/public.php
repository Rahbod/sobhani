<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="fa_ir">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#158BFF" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Yii::app()->request->csrfToken ?>" />
    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <link rel="alternate" href="10behtarin.com" hreflang="fa" />
    <title><?= (!empty($this->pageTitle)?$this->pageTitle.' | ':'').$this->siteName ?></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran-fa-num.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
//    Yii::app()->clientScript->registerCoreScript('jquery.ui');
//    $cssCoreUrl = $cs->getCoreScriptUrl();
//    $cs->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/js/vendors/owl-carousel/owl.carousel.min.css');
    $cs->registerCssFile($baseUrl.'/js/vendors/owl-carousel/owl.theme.default.min.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/js/vendors/icomoon/style.css');
    $cs->registerCssFile($baseUrl.'/css/iran-sans-fa-num.css');
    $cs->registerCssFile($baseUrl.'/css/global.css');
    $cs->registerCssFile($baseUrl.'/css/sidebar.css');
    $cs->registerCssFile($baseUrl.'/css/responsive.css');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/vendors/owl-carousel/owl.carousel.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/global.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/index.js', CClientScript::POS_END);
    ?>
</head>
<body class="position-relative">
<div class="page">
    <?php $this->renderPartial('//partial-views/_header');?>
    <main class="main">
        <?php echo $content;?>
    </main>
    <?php $this->renderPartial('//partial-views/_footer');?>
    <?php $this->renderPartial('//partial-views/_login_popup');?>
</div>
</body>
</html>