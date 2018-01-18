<?php
/* @var $data Lists */
$path = Yii::getPathOfAlias('webroot').'/uploads/lists/';
$url = Yii::app()->getBaseUrl(true).'/uploads/lists/thumbs/200x200/';
?>
<div class="list-item col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <a href="<?= $data->getViewUrl()?>">
        <?php if($data->image && is_file($path.$data->image)): ?><img src="<?= $url.$data->image?>"><?php else: ?><img src="<?= Yii::app()->theme->baseUrl.'/image/no-image.png' ?>"><?php endif; ?>
        <?= $data->title ?>
    </a>
</div>
