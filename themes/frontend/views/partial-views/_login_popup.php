<div id="join-modal" class="modal fade" role="dialog" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>ساخت حساب کاربری
                    <button class="close" type="button" data-dismiss="modal">
                        <i class="close-icon"></i>
                    </button>
                </h4>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('//partial-views/_loading') ?>
                <a href="<?= $this->createUrl('/googleLogin') ?>" class="btn-red text-center" id="google-login-btn"><i class="google-icon"></i>ورود یا ثبت نام با گوگل</a>
                <div class="text-center">یا</div>
                <?php $this->renderPartial('users.views.public._ajaxRegister', array('loading_parent' => '#join-modal')) ?>
            </div>
        </div>
    </div>
</div>
<div id="login-modal" class="modal fade" role="dialog" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>ورود
                    <button class="close" type="button" data-dismiss="modal">
                        <i class="close-icon"></i>
                    </button>
                </h4>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('//partial-views/_loading') ?>
                <a href="<?= $this->createUrl('/googleLogin') ?>" class="btn-red text-center" id="google-login-btn"><i class="google-icon"></i>ورود یا ثبت نام با گوگل</a>
                <div class="text-center">یا</div>
                <?php $this->renderPartial('users.views.public._ajaxLogin', array('loading_parent' => '#login-modal')) ?>
            </div>
        </div>
    </div>
</div>