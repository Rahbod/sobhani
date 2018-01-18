<?php
/* @var $this SiteController */
/* @var $model Pages */
$this->pageTitle=$model->title;
$this->pageHeader=$model->title;
$this->breadcrumbs=array(
    'خانه' => array('/'),
    $model->title,
);
?>
<h2><?= $model->title ?></h2>
<div class="page-text" dir="auto"><?php
    $purifier=new CHtmlPurifier();
    echo $purifier->purify($model->summary);
    ?>
</div>