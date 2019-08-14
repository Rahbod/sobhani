<!--New Signup-->

<?php
$app=Yii::app();
$baseUrl = $app->getBaseUrl();
$themeBaseUrl = $app->theme->baseUrl;
?>

<div class="modal modal-center fade" id="login-modal" tabindex="-1"
     role="dialog" aria-labelledby="login-modal"
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
                <ul class="nav nav-pills nav-justified px-0 loginWithSocial">
                    <li class="nav-item ml-4">
                        <a data-toggle="pill" href="#email" class="btn btn-outline-danger w-100 gmail active">
                            <img src="<?= $themeBaseUrl . '/assets/media/images/public/at-sign.png' ?> " width="31"
                                 height="31" alt="">
                        ایمیل/نام کاربری
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="pill" href="#mobile" class="btn btn-outline-info w-100 mobile">
                            <img src="<?= $themeBaseUrl . '/assets/media/images/public/phone.png' ?>" alt="">
                            شماره تلفن همراه
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="email">
                        <div class="d-flex loginNormal">
                            <hr class="w-50">
                            <p class="mx-3" style="white-space: nowrap;">ورود با نام کاربری یا ایمیل </p>
                            <hr class="w-50">
                        </div>
                        <form action="">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="email" class="form-control" placeholder="ایمیل یا نام کاربری خود را وارد نمایید.">
                                </div>
                                <div class="form-group col-12">
                                    <input type="password" class="form-control" placeholder="گذرواژه">
                                </div>
                                <div class="form-group col-12">
                                    <a href="void:;" class="forgotPassword">
                                        فراموشی گذرواژه
                                    </a>
                                </div>

                                <div class="form-group col-lg-12 mb-0">
                                    <button class="btn btn-info form-control">ورود</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane container fade" id="mobile">
                        <div class="d-flex loginNormal">
                            <hr class="w-50">
                            <p class="mx-3" style="white-space: nowrap;">شماره تلفن همراه</p>
                            <hr class="w-50">
                        </div>
                        <form action="">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input name="phone" type="text" class="form-control" placeholder="شماره همراه">
                                </div>

                                <div class="form-group col-lg-12 mb-0">
                                    <button class="btn btn-info form-control">ارسال کد تایید</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modalFooter pt-0">
                <div class="d-flex loginNormal">
                    <hr class="w-50">
                    <p class="mx-3" style="white-space: nowrap;">ورود با </p>
                    <hr class="w-50">
                </div>

                <div class="socials">
                    <a href="#email" class="btn btn-outline-danger w-100 gmail active">
                        <img src="<?= $themeBaseUrl . '/assets/media/images/public/google-plus.svg' ?> " width="31"
                             height="31" alt="">
                        حساب گوگل
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
