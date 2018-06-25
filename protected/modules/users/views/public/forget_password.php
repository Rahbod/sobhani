<?php
/* @var $this UsersPublicController */
$this->breadcrumbs = array(
    'خانه' => array('/'),
    'بازیابی کلمه عبور'
);
?>
<h2>بازیابی کلمه عبور</h2>
<div class="recommend row">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <?php echo CHtml::beginForm(Yii::app()->createUrl('/users/public/forgetPassword'), 'post', array(
            'id'=>'forget-password-form',
        ));?>

        <?php $this->renderPartial('//partial-views/_flashMessage');?>
        <p>کلمه عبور خود را فراموش کرده اید؟<br>
            لطفا پست الکترونیک خود را وارد کنید.
        </p>
        <div class="form-group">
            <?php echo CHtml::textField('UsersForgetPassword[email]', '',array('placeholder'=>'پست الکترونیکی', 'class' => 'form-control')); ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton('ارسال', array('class'=>'btn btn-info pull-left'));?>
        </div>
        <?php CHtml::endForm(); ?>

        <p><a href="<?php echo $this->createUrl('/login');?>" class="pull-right">ورود به حساب کاربری</a></p>
    </div>
</div>