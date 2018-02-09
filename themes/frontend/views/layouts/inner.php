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
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css');
    $cs->registerCssFile($baseUrl.'/css/responsive-theme.css');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.js', CClientScript::POS_END);
    ?>
</head>
<body>
<div class="page inner">
    <?php $this->renderPartial('//partial-views/_header');?>
    <div class="content">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 left-side">
                <div class="context">
                    <?php $this->renderPartial('//partial-views/_breadcrumb');?>
                    <?php echo $content;?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right-side"><?php $this->renderPartial('//partial-views/_right_col');?></div>
        </div>
    </div>
    <?php $this->renderPartial('//partial-views/_footer');?>
    <?php $this->renderPartial('//partial-views/_login_popup');?>
</div>
</body>
</html>