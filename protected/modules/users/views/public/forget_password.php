<?php
/* @var $this UsersPublicController */
$this->breadcrumbs = array(
    'خانه' => array('/'),
    'بازیابی کلمه عبور'
);
?>
<section class="createList section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 mx-auto">
                <div class="createList_header">
                    <h4 class="-h4">بازیابی کلمه عبور</h4>
                    <p class="mb-5 mt-4">لطفا پست الکترونیکی خود را وارد کنید.</p>
                </div>
                <div class="formContainer">
                    <?php echo CHtml::beginForm(Yii::app()->createUrl('/users/public/forgetPassword'), 'post', array(
                        'id'=>'forget-password-form',
                    ));?>

                        <?php $this->renderPartial('//partial-views/_flashMessage');?>

                        <p>جهت بازیابی کلمه عبور پست الکترونیکی خود را وارد کنید.</p>

                        <div class="form-group">
                            <?php echo CHtml::textField('UsersForgetPassword[email]', '',array('placeholder'=>'پست الکترونیکی', 'class' => 'form-control')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::submitButton('ارسال', array('class'=>'btn btn-outline-success'));?>
                            <a href="<?php echo $this->createUrl('/login');?>" class="btn btn-outline-info pull-left">ورود به حساب کاربری</a>
                        </div>
                    <?php CHtml::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
</section>