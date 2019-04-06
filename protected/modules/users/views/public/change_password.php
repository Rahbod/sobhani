<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $form CActiveForm */
$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور',
];
?>

<div class="content-box white-bg">
    <div class="center-box">
        <?php $this->renderPartial('//partial-views/_flashMessage');?>
        <?php $this->renderPartial('//partial-views/_loading');?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form action="<?= $this->createUrl('/users/public/sendSmsVerification') ?>" method="get" onsubmit="return false;">
                            <button type="submit" class="btn btn-primary submit-btn" style="margin-top: 25px; padding: 6px 50px">دریافت کد فعالسازی</button>
                        </form>
                        <p id="error-span" class="text-center" style="font-size: 11px"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'users-form',
                    'action' => Yii::app()->createUrl('/users/public/changePassword'),
                    'htmlOptions' => array('class' => 'inline-form'),
                    'enableAjaxValidation'=>false,
                )); ?>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 relative">
                        <span class="login-timer" style="line-height: 22px; font-size: 14px"></span>
                        <?php echo $form->labelEx($model,'oldPassword'); ?>
                        <?php echo $form->passwordField($model,'oldPassword',array('placeholder'=>$model->getAttributeLabel('oldPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'', 'id'=>'oldPass')); ?>
                        <?php echo $form->error($model,'oldPassword'); ?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo $form->labelEx($model,'newPassword'); ?>
                        <?php echo $form->passwordField($model,'newPassword',array('placeholder'=>$model->getAttributeLabel('newPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                        <?php echo $form->error($model,'newPassword'); ?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo $form->labelEx($model,'repeatPassword'); ?>
                        <?php echo $form->passwordField($model,'repeatPassword',array('placeholder'=>$model->getAttributeLabel('repeatPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
                        <?php echo $form->error($model,'repeatPassword'); ?>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php echo CHtml::submitButton('تغییر کلمه عبور',array('class'=>'btn btn-success')); ?>
                    </div>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        $("body").on("click", ".submit-btn", function () {
            var $this = $(this),
                form = $this.parents("form"),
                url = form.attr("action");

            $.ajax({
                "type": "POST",
                "url": url,
                "dataType": "json",
                "beforeSend": function () {
                    $(".center-box .loading-container").show();
                },
                "success": function (data) {
                    form.find("#error-span").html("").removeClass("success error");
                    $(".center-box .loading-container").hide();
                    if (data.status) {
                        $("#oldPass").val("").trigger("focus");
                        $(".center-box .login-timer").parent().removeClass("danger-login");
                        timer(120);
                        form.find("#error-span").html(data.message).addClass("text-success").removeClass("text-error").show();
                    }
                    else
                        form.find("#error-span").html(data.message).addClass("text-error").removeClass("text-success").show();
                    setTimeout(function () {
                        form.find("#error-span").fadeOut();
                    }, 5000);
                },
                error: function (err) {
                    $(".center-box .loading-container").hide();
                    console.log(err);
                }
            });
        });

        var timerIntervalPage = false;

        function timer(counter) {
            clearInterval(timerIntervalPage);
            timerIntervalPage = setInterval(function () {
                counter--;
                $(".center-box .login-timer").text(counter);
                if (counter === 0) {
                    clearInterval(timerIntervalPage);
                    $(".center-box .login-timer").text("").parent().addClass("danger-login");
                }
            }, 1000);
        }
    })
</script>