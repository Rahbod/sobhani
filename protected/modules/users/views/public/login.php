<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    'خانه' => array('/'),
    'ورود به حساب کاربری'
);
?>
<h2>ورود به حساب کاربری</h2>
<div class="recommend">
    <?php
    $loading_parent = '.recommend';
    ?>
    <div class="button-box">
        <?php
        $this->renderPartial('//partial-views/_loading');
        $this->renderPartial('//partial-views/_flashMessage');
        $this->renderPartial('//partial-views/_flashMessage', array('prefix' => 'login-'));
        ?>
        <p>عضو سایت هستید؟<br>
            برای ثبت آگهی خود لطفا وارد شوید
        </p>
        <?php
        $model = new UserLoginForm();
        Yii::app()->user->returnUrl = Yii::app()->request->url;
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'users-login-form',
            'action' => Yii::app()->createUrl('/login'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions'=>array(
                'onsubmit' => 'return false;'
            ),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate'=>'js:function(form,data,hasError){
                    if(!hasError){
                        $.ajax({
                            "type":"POST",
                            "url":"'.CHtml::normalizeUrl(array("/login/?ajax=users-login-form")).'",
                            "data":form.serialize(),
                            "dataType" : "json",
                            "beforeSend":function(){
                                '.($loading_parent?'$("'.$loading_parent.' .loading-container").show();':'').'    
                            },
                            "success":function(data){
                                if (typeof data === "object" && typeof data.status === \'undefined\') {
                                    $.each(data, function (key, value) {
                                        form.find("#" + key + "_em_").show().html(value.toString()).parent().removeClass(\'success\').addClass(\'error\');
                                    });
                                }
                                else if(data.status)
                                {
                                    window.location = data.url;
                                    $("#login-submit-btn").val(data.msg);
                                }
                                else
                                    $("#login-error").html(data.msg);
                                '.($loading_parent?'$("'.$loading_parent.' .loading-container").hide();':'').'
                            },
                        });
                    }
                }'
            )
        )); ?>
        <p id="login-error" class="errorMessage"></p>
        <p id="UserLoginForm_authenticate_field_em_" class="errorMessage"></p>
        <div class="form-group">
            <?php echo $form->textField($model, 'verification_field_value', array('class' => 'ltr text-right form-control', 'placeholder' => 'شماره موبایل / پست الکترونیکی')); ?>
            <?php echo $form->error($model, 'verification_field_value'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'رمز عبور')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div class="form-group text-right">
            <?= $form->checkBox($model,'rememberMe',array('id'=>'remember-me', 'class' => 'form-control')); ?><?= CHtml::label('مرا به خاطر بسپار','remember-me',array('class'=>'text-gray')) ?>
        </div>

        <button type="submit" class="btn btn-success pull-left" id="login-submit-btn">
            ورود به حساب کاربری
        </button>
        <?php $this->endWidget(); ?>
        <a href="<?= $this->createUrl('/forgetPassword') ?>" class="gray-link pull-right text-left">رمز عبور خود را فراموش کرده ام!</a>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('clear-inputs', '
    setTimeout(function(){
        $(".form-control").val("");
    }, 100);
',CClientScript::POS_LOAD);