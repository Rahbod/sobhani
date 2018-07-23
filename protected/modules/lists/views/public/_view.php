<?php
/* @var $data Lists */
$path = Yii::getPathOfAlias('webroot').'/uploads/lists/';
$url = Yii::app()->getBaseUrl(true).'/uploads/lists/thumbs/200x200/';
?>
<div class="list-item col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <a href="<?= $data->getViewUrl()?>"><img src="<?= $url.$data->getImage()?>" alt="<?= $data->title ?>" title="<?= $data->title ?>"></a>
    <a href="<?= $data->getViewUrl() ?>"><h3 class="item-title"><?= $data->title ?></h3></a>
</div>
