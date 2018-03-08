<?php
/* @var $this UsersPublicController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
/* @var $avatar array */

$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات',
    'کلمه عبور' => array('/changePassword'),
];
?>
<!--<h2>تغییر مشخصات کاربری</h2>-->
<div class="recommend">
    <?php $this->renderPartial('//partial-views/_flashMessage');?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'users-form',
        'htmlOptions' => array('class' => 'inline-form'),
        'enableAjaxValidation'=>true,
    )); ?>

    <div class="row">
<!--        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">-->
<!--            --><?php //$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
//                'id' => 'avatar-uploader',
//                'model' => $model,
//                'name' => 'avatar',
//                'maxFiles' => 1,
//                'maxFileSize' => 1, //MB
//                'containerClass' => 'uploader',
//                'url' => Yii::app()->createUrl('/users/public/upload'),
//                'deleteUrl' => Yii::app()->createUrl('/users/public/deleteUpload'),
//                'acceptedFiles' => '.jpg, .jpeg, .png',
//                'serverFiles' => $avatar,
//                'onSuccess' => '
//                var responseObj = JSON.parse(res);
//                if(responseObj.status){
//                    {serverName} = responseObj.fileName;
//                    $(".uploader-message").html("");
//                }
//                else{
//                    $(".uploader-message").html(responseObj.message);
//                    this.removeFile(file);
//                }
//            ',
//            )); ?>
<!--            <div class="uploader-message error"></div>-->
<!--            --><?php //echo $form->error($model,'avatar'); ?>
<!--        </div>-->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 profile-left-side">
            <div class="form-group">
                <?php echo $form->textField($model,'first_name',array('placeholder'=>$model->getAttributeLabel('first_name').' *','class'=>'form-control','maxlength'=>50)); ?>
                <?php echo $form->error($model,'first_name'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->textField($model,'last_name',array('placeholder'=>$model->getAttributeLabel('last_name').' *','class'=>'form-control','maxlength'=>50)); ?>
                <?php echo $form->error($model,'last_name'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->textField($model,'mobile',array('placeholder'=>$model->getAttributeLabel('mobile').' *','class'=>'form-control','maxlength'=>11)); ?>
                <?php echo $form->error($model,'mobile'); ?>
            </div>
            <div class="form-group">
                <?php echo CHtml::submitButton('ذخیره',array('class'=>'btn btn-success pull-left')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>