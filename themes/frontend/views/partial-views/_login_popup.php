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
                <?php $this->renderPartial('users.views.public._ajaxLogin', array('loading_parent' => '#login-modal')) ?>
            </div>
        </div>
    </div>
</div>