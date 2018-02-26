<?php
/* @var $form CActiveForm */
if(!isset($loading_parent) || empty($loading_parent))
    $loading_parent = false;
?>

<?php
$model = new Users;
$model->scenario = 'register';
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'users-register-modal-form',
    'action' => array('/users/public/register'),
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
                    "url":"'.CHtml::normalizeUrl(array("/users/public/register/?ajax=users-register-modal-form")).'",
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
                            $("#register-success").html(data.msg);
                            $("#register-error").html("");
                            document.getElementById("users-register-modal-form").reset();
                            if(typeof data.url != \'undefined\')
                                window.location = data.url;
                        }
                        else
                            $("#register-error").html(data.msg);
                        $("#users-register-modal-form .captcha a").click();    
                        $("#users-register-modal-form #Users_verifyCode").val("");
                        '.($loading_parent?'$("'.$loading_parent.' .loading-container").hide();':'').'
                    },
                });
            }else
            {
                $("#users-register-modal-form .captcha a").click();    
                $("#users-register-modal-form #Users_verifyCode").val(""); 
            }
        }'
))); ?>
<p id="register-error" class="errorMessage"></p>
<p id="register-success" class="text-success"></p>
<div>
    <?php echo $form->emailField($model,'email',array('class'=>"text-field ltr text-right",'placeholder'=>$model->getAttributeLabel('email')));?>
    <?php echo $form->error($model,'email'); ?>
</div>
<div>
    <?php echo $form->textField($model,'mobile',array('class'=>"text-field ltr text-right",'placeholder'=>$model->getAttributeLabel('mobile')));?>
    <?php echo $form->error($model,'mobile'); ?>
</div>
<div>
    <?php echo $form->passwordField($model,'password',array('class'=>"text-field",'placeholder'=>$model->getAttributeLabel('password')));?>
    <?php echo $form->error($model,'password'); ?>
</div>
<div>
    <?php echo $form->passwordField($model,'repeatPassword',array('class'=>"text-field",'placeholder'=>$model->getAttributeLabel('repeatPassword')));?>
    <?php echo $form->error($model,'repeatPassword'); ?>
</div>
<div>
    <?php echo $form->textField($model, 'verifyCode',array('class'=>"text-field",'placeholder'=>$model->getAttributeLabel('verifyCode'))); ?>
    <?php echo $form->error($model,'verifyCode'); ?>
</div>
<div class="text-nowrap captcha">
    <?php $this->widget('CCaptcha',array(
        'captchaAction' => '/users/public/captcha',
    )); ?>
    <i class="refresh"></i>
</div>
<!--<p class="text-center">با کلیک کردن بر روی ادامه شما موافقت می کنید که --><?//= Yii::app()->name?><!-- اجازه ارسال یک ایمیل تأیید به آدرس ارائه شده در بالا را بدهند.</p>-->
<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <button type="submit" class="btn btn-primary">
ساخت حساب کاربری
    </button>
</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('refreshClick', '
$(".captcha .refresh").click(function(){
    $(this).parent().find("a").trigger("click");
});
');?>
