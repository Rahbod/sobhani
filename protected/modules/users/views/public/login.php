<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    'خانه' => array('/'),
    'ورود به حساب کاربری'
);
?>
    <section class="createList section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 mx-auto">
                    <div class="createList_header">
                        <h4 class="-h4">ورود به حساب کاربری</h4>
                        <p class="mb-5 mt-4">اطلاعات کاربری خود را وارد کنید.</p>
                    </div>
                    <div class="formContainer">
                        <?php
                        $loading_parent = '.recommend';
                        ?>
                        <div class="button-box">
                            <?php
                            $this->renderPartial('//partial-views/_loading');
                            $this->renderPartial('//partial-views/_flashMessage');
                            $this->renderPartial('//partial-views/_flashMessage', array('prefix' => 'login-'));
                            ?>
                            <?php
                            $model = new UserLoginForm();
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
                                                "url":"'.CHtml::normalizeUrl(array("/mobileLogin/?ajax=users-login-form&mode=username")).'",
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
                                                        $("#login-submit-btn").val(data.message);
                                                    }
                                                    else
                                                        $("#login-error").html(data.message);
                                                    '.($loading_parent?'$("'.$loading_parent.' .loading-container").hide();':'').'
                                                },
                                            });
                                        }
                                    }'
                                )
                            )); ?>
                            <p id="login-error" class="errorMessage"></p>
                            <p id="UserLoginForm_authenticate_field_em_" class="errorMessage"></p>

                            <a href="<?= $this->createUrl('/googleLogin?return-url='.Yii::app()->user->returnUrl) ?>" class="btn btn-outline-danger w-100 gmail" id="google-login-btn">
                                <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/google-plus.svg' ?>" width="31" height="31">
                                ورود یا ثبت نام با گوگل
                            </a>
                            <div class="text-center mb-4 mt-4">یا</div>

                            <?php echo CHtml::hiddenField('returnUrl', Yii::app()->user->returnUrl) ?>
                            <div class="form-group">
                                <?php echo $form->textField($model, 'verification_field_value', array('class' => 'ltr text-right form-control', 'placeholder' => 'شماره موبایل / پست الکترونیکی')); ?>
                                <?php echo $form->error($model, 'verification_field_value'); ?>
                            </div>

                            <div class="form-group">
                                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'رمز عبور')); ?>
                                <?php echo $form->error($model, 'password'); ?>
                            </div>

                            <div class="form-group text-right">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <?= $form->checkBox($model,'rememberMe',array('id'=>'remember-me', 'class' => 'ml-1')); ?><?= CHtml::label('مرا به خاطر بسپار','remember-me',array('class'=>'text-gray')) ?>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <a href="<?= $this->createUrl('/forgetPassword') ?>" class="gray-link pull-left text-left">رمز عبور خود را فراموش کرده ام!</a>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-success" id="login-submit-btn">ورود به حساب کاربری</button>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
Yii::app()->clientScript->registerScript('clear-inputs', '
    setTimeout(function(){
        $(".form-control").val("");
    }, 100);
',CClientScript::POS_LOAD);