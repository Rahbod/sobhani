<?php
/** @var $this Controller */
/** @var $form CActiveForm */

$model = new UserLoginForm();
Yii::app()->user->returnUrl = Yii::app()->request->url;
?>

<!--New Signup-->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modalHeader">
                <h6 class="-h6 modal-title ">ورود به حساب کاربری</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center modal-description">
                    با استفاده از یکی از روش های زیر وارد حساب کاربری خود شوید.
                </p>
                <div class="d-flex loginWithSocial">
                    <a href="<?= $this->createUrl('/googleLogin') ?>" class="btn btn-outline-danger w-100 gmail">
                        <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/google-plus.svg' ?>" width="31" height="31">
                        حساب گوگل
                    </a>
                    <a href="void:;" class="btn btn-outline-info w-100 mobile" data-toggle="tab" data-target="#modal-register-tab">
                        <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/phone.png' ?>">
                        ثبت نام با موبایل
                    </a>
                </div>
                <?php $this->renderPartial('users.views.public._smsLogin', array('loading_parent' => '#login-modal')) ?>
            </div>
        </div>
    </div>
</div>

<div class="overlay"></div>

<script>
    $(function () {
        $("body").on("click", ".login-submit-btn", function () {
            var $this = $(this),
                loginMode = $this.val(),
                form = $this.parents("form"),
                url = form.attr("action");

            $.ajax({
                "type": "POST",
                "url": url + "?ajax=users-login-modal-form&mode=" + loginMode,
                "data": form.serialize(),
                "dataType": "json",
                "beforeSend": function () {
                    $("#login-modal .loading-container").show();
                },
                "success": function (data) {
                    form.find("#login-error").html("").removeClass("success error");
                    console.log(data);
                    if (typeof data === "object" && typeof data.status === "undefined") {
                        $.each(data, function (key, value) {
                            form.find("#" + key + "_em_").show().html(value.toString()).parent().removeClass("success").addClass("error");
                            form.find("#login-error").append("<br>" + value.toString()).addClass("error").show();
                        });
                        $("#login-modal .loading-container").hide();
                    }
                    else {
                        if (loginMode === "username") {
                            if (data.status) {
                                window.location = data.url;
                                $("#" + loginMode + "-form .login-submit-btn").val(data.message);
                            } else {
                                $("#login-modal .loading-container").hide();
                                form.find("#login-error").html(data.message).addClass("text-danger").removeClass("text-success").show();
                            }
                        } else if (loginMode === "mobile") {
                            $("#login-modal .loading-container").hide();
                            if (data.status) {
                                $("#go-verify").tab("show");
                                $("#mobile-verification-form").find(".text-field").val("").focus();
                                timer(120);
                            } else
                                form.find("#login-error").html(data.message).addClass("text-error").removeClass("text-success").show();
                        } else if (loginMode === "mobile-verification" || loginMode === "resend-verification") {
                            $("#login-modal .loading-container").hide();
                            if (data.status) {
                                if (loginMode === "mobile-verification")
                                    window.location = data.url;
                                if (loginMode === "resend-verification") {
                                    $("#mobile-verification-form").find(".text-field").val("").focus();
                                    $(".resend-btn").addClass("btn-default").removeClass("btn-border-primary");
                                    $(".login-timer").parent().removeClass("danger-login");
                                    timer(120);
                                }
                                form.find("#login-error").html(data.message).addClass("text-success").removeClass("text-error").show();
                            }
                            else
                                form.find("#login-error").html(data.message).addClass("text-error").removeClass("text-success").show();
                        }
                    }
                    setTimeout(function () {
                        form.find("#login-error").fadeOut();
                    }, 5000);
                },
                error: function (err) {
                    $("#login-modal .loading-container").hide();
                    console.log(err);
                }
            });
        }).on("keypress", "#users-login-modal-form input", function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                $(this).parents(".tab-pane").find(".enter-trigger").trigger("click");
                return false;
            }
        });

        var timerInterval = false;

        function timer(counter) {
            clearInterval(timerInterval);
            timerInterval = setInterval(function () {
                counter--;
                $(".login-timer").text(counter);
                if (counter === 0) {
                    clearInterval(timerInterval);
                    $(".resend-btn").removeClass("btn-default").addClass("btn-border-primary");
                    $(".login-timer").parent().addClass("danger-login");
                }
            }, 1000);
        }
    })
</script>