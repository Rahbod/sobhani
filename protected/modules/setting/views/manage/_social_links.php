<?php
/* @var $this SettingManageController */
/* @var $model SiteSetting */
$social_links = false;
if($model->value)
    $social_links = CJSON::decode($model->value);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">تنظیمات عمومی</h3>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('//partial-views/_flashMessage')?>
        <?
        $form = $this->beginWidget('CActiveForm',array(
            'id'=> 'general-setting',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="form-group">
            <?php echo CHtml::label('لینک فیسبوک',''); ?>
            <?php echo CHtml::textField("SiteSetting[social_links][facebook]",($social_links && isset($social_links['facebook'])?$social_links['facebook']:''),array('size'=>60,'class'=>'form-control text-left ltr')); ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('لینک تلگرام',''); ?>
            <?php echo CHtml::textField("SiteSetting[social_links][telegram]",($social_links && isset($social_links['telegram'])?$social_links['telegram']:''),array('size'=>60,'class'=>'form-control text-left ltr')); ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('لینک گوگل',''); ?>
            <?php echo CHtml::textField("SiteSetting[social_links][google]",($social_links && isset($social_links['google'])?$social_links['google']:''),array('size'=>60,'class'=>'form-control text-left ltr')); ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('لینک اینستاگرام',''); ?>
            <?php echo CHtml::textField("SiteSetting[social_links][instagram]",($social_links && isset($social_links['instagram'])?$social_links['instagram']:''),array('size'=>60,'class'=>'form-control text-left ltr')); ?>
        </div>

        <div class="form-group buttons">
            <?php echo CHtml::submitButton('ذخیره',array('class' => 'btn btn-success')); ?>
        </div>
        <?
        $this->endWidget();
        ?>
    </div>
</div>