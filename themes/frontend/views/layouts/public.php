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
    <title><?= (!empty($this->pageTitle)?$this->pageTitle.' | ':'').$this->siteName ?></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $cssCoreUrl = $cs->getCoreScriptUrl();
    $cs->registerCssFile($cssCoreUrl . '/jui/css/base/jquery-ui.css');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl.'/css/fontiran.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css?3.3');
    $cs->registerCssFile($baseUrl.'/css/responsive-theme.css?3.3');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.nicescroll.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.js?3.3', CClientScript::POS_END);
    ?>
</head>
<body>
<?php $this->renderPartial('//partial-views/_header');?>
<?php echo $content;?>
<?php $this->renderPartial('//partial-views/_login_popup');?>
<?php $this->renderPartial('//partial-views/_footer');?>
</body>
</html>