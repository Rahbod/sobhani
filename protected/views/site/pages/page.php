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
<section class="createList section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 mx-auto">
                <div class="createList_header">
                    <h4 class="-h4 mb-5"><?= $model->title ?></h4>
                </div>
                <div class="text-justify" dir="auto">
                    <?php $purifier=new CHtmlPurifier();
                    echo $purifier->purify($model->summary); ?>
                </div>
            </div>
        </div>
    </div>
</section>