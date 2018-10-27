<?php
/** @var $form CActiveForm*/
if(!isset($loading_parent) || empty($loading_parent))
    $loading_parent = false;

$model = new UserLoginForm();
Yii::app()->user->returnUrl = Yii::app()->request->url;
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'users-login-modal-form',
    'action' => Yii::app()->createUrl('/mobileLogin'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'htmlOptions'=>array(
        'onsubmit' => 'return false;'
    ),
)); ?>
    <p id="login-error" class="errorMessage text-center"></p>
    <p id="UserLoginForm_authenticate_field_em_" class="errorMessage"></p>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="mobile-form">
            <div>
                <?php echo $form->textField($model, 'mobile', array('class' => 'ltr text-right text-field', 'placeholder' => 'شماره تلفن همراه')); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <button type="submit" name="<?= CHtml::activeName($model, 'login_mode') ?>" value="mobile" data-toggle="tab" data-target="#mobile-verification-form" class="login-submit-btn btn btn-primary">ارسال کد فعالسازی</button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-default" data-toggle="tab" data-target="#username-form">ورود با نام کاربری</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="mobile-verification-form">
            <p>کد تایید به شماره تلفن همراه شما ارسال گردید.</p>
            <div>
                <?php echo $form->textField($model, 'verification_code', array('class' => 'ltr text-right text-field', 'placeholder' => 'کد تایید')); ?>
                <?php echo $form->error($model, 'verification_code'); ?>
            </div>
            <div style="display: block;margin-bottom: 10px">
                <button type="submit" name="<?= CHtml::activeName($model, 'login_mode') ?>" value="mobile-verification" class="login-submit-btn btn btn-primary">ورود</button>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <button type="submit" name="<?= CHtml::activeName($model, 'login_mode') ?>" value="resend-verification" class="login-submit-btn btn btn-default">
                        <i class="icon icon-refresh"></i>
                        ارسال مجدد کد فعالسازی</button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-default" data-toggle="tab" data-target="#username-form">ورود با نام کاربری</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="username-form">
            <div>
                <?php echo $form->textField($model, 'verification_field_value', array('class' => 'ltr text-right text-field', 'placeholder' => 'شماره تلفن همراه / پست الکترونیکی')); ?>
                <?php echo $form->error($model, 'verification_field_value'); ?>
            </div>
            <div>
                <?php echo $form->passwordField($model, 'password', array('class' => 'text-field', 'placeholder' => 'رمز عبور')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-default" data-toggle="tab" data-target="#mobile-form">ورود با شماره تلفن همراه</button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <button type="submit" name="<?= CHtml::activeName($model, 'login_mode') ?>" value="username" class="login-submit-btn btn btn-warning">ورود به حساب کاربری</button>
                </div>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>
<script>
    $(function () {
        $("body").on("click", '.login-submit-btn', function () {
            var $this = $(this),
                loginMode = $this.val(),
                form = $this.parents('form'),
                url = form.attr("action");

            console.log(loginMode);

            $.ajax({
                "type": "POST",
                "url": url + "?ajax=users-login-modal-form&mode="+loginMode,
                "data": form.serialize(),
                "dataType": "json",
                "beforeSend": function () {
                    $("#login-modal .loading-container").show();
                },
                "success": function (data) {
                    form.find("#login-error").html("").removeClass('success error');
                    if (typeof data === "object" && typeof data.status === 'undefined') {
                        $.each(data, function (key, value) {
                            form.find("#" + key + "_em_").show().html(value.toString()).parent().removeClass('success').addClass('error');
                            form.find("#login-error").append("<br>"+value.toString()).addClass('error').show();
                        });
                    }
                    else if (data.status) {
                        if(loginMode === 'username') {
                            window.location = data.url;
                            // $("#"+loginMode+"-form .login-submit-btn").val(data.msg);
                        }else{
                            $("#login-modal .loading-container").hide();
                            $("#mobile-verification-form").tab("toggle");
                        }
                    }
                },
                error: function (data) {
                    $("#login-modal .loading-container").hide();
                    alert(data);
                }
            });
        });
    })
</script>
<?php

