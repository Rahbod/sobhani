<?php
/* @var $this UsersPublicController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
/* @var $avatar array */

$this->breadcrumbs =[
    'خانه' => array('/'),
    'بازیابی کلمه عبور',
];
?>
<h2>تغییر کلمه عبور</h2>
<p>لطفا کلمه عبور جدید را وارد کنید.</p>
<?php $this->renderPartial('//partial-views/_flashMessage');?>
<div class="recommend">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'users-form',
        'focus'=>array($model,'password'),
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
//            'beforeValidate' => "js:function(form) {
//                $('.loading-container').fadeIn();
//                return true;
//            }",
//            'afterValidate' => "js:function(form) {
//                $('.loading-container').stop().hide();
//                return true;
//            }",
        ),
    )); ?>

    <div class="alert alert-success hidden" id="message"></div>

    <div class="form-group">
        <?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'کلمه عبور','value' => '')); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->passwordField($model,'repeatPassword',array('class'=>'form-control','placeholder'=>'تکرار کلمه عبور')); ?>
        <?php echo $form->error($model,'repeatPassword'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::SubmitButton('ثبت', array('class'=>'btn btn-info pull-left'));?>
    </div>
    <?php $this->endWidget(); ?>

    <p><a href="<?php echo $this->createUrl('/login');?>" class="pull-right">ورود به حساب کاربری</a></p>

    <div class="loading-container">
        <div class="overly"></div>
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>