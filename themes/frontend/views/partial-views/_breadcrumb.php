<?php
/* @var $this Controller */
?>
<div class="">
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
//        'homeLink' => '<li class="breadcrumb-item">'.CHtml::link(Yii::app()->name, Yii::app()->homeUrl).'</li>',
        'homeLink' => false,
        'htmlOptions'=>array('class'=>'breadcrumb'),
        'tagName' => 'ul',
        'activeLinkTemplate' => '<li class="breadcrumb-item"><a href="{url}">{label}</a></li>',
        'inactiveLinkTemplate' => '<li class="breadcrumb-item"><span>{label}</span></li>',
        'separator' => ''
    )); ?>
</div>
