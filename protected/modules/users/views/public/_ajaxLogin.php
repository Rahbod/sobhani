<?php
if(!isset($loading_parent) || empty($loading_parent))
    $loading_parent = false;

$model = new UserLoginForm();
Yii::app()->user->returnUrl = Yii::app()->request->url;
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'users-login-modal-form',
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
                    "url":"'.CHtml::normalizeUrl(array("/login/?ajax=users-login-modal-form")).'",
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
    <div>
        <?php echo $form->textField($model, 'verification_field_value', array('class' => 'ltr text-right text-field', 'placeholder' => 'شماره موبایل / پست الکترونیکی')); ?>
        <?php echo $form->error($model, 'verification_field_value'); ?>
    </div>
    <?php echo $form->passwordField($model, 'password', array('class' => 'text-field', 'placeholder' => 'رمز عبور')); ?>
    <?php echo $form->error($model, 'password'); ?>

<!--    <div class="form-group text-right">-->
<!--        --><?//= $form->checkBox($model,'rememberMe',array('id'=>'remember-me', 'class' => 'form-control')); ?>
<!--        --><?//= CHtml::label('مرا به خاطر بسپار','remember-me',array('class'=>'text-gray')) ?>
<!--    </div>-->
    <div class="form-group text-right">
        <a href="<?= $this->createUrl('/forgetPassword') ?>" class="gray-link text-left">رمز عبور خود را فراموش کرده ام!</a>
    </div>
    <button type="submit" class="btn btn-warning" id="login-submit-btn">ورود به حساب کاربری</button>
    <button class="btn btn-link" data-dismiss="modal" data-toggle="modal" data-target="#join-modal">ایجاد حساب کاربری</button>
<?php $this->endWidget(); ?>