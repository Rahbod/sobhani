<div id="join-modal" class="modal fade" role="dialog" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="close-icon"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= Yii::app()->createUrl('/register')?>">
                    <input class="text-field" type="text" name="Users[username]" placeholder="نام کاربری">
                    <input class="text-field" type="password" name="Users[password]" placeholder="رمز عبور">
                    <input class="text-field" type="password" name="Users[repeatPassword]" placeholder="تکرار رمز عبور">
                    <input class="text-field" type="email" name="Users[email]" placeholder="ایمیل">
                    <button class="btn btn-primary" type="submit"  value="ادامه">ادامه</button>
                    <p class="text-center">با کلیک کردن بر روی ادامه شما موافقت می کنید که <?= Yii::app()->name?> اجازه ارسال یک ایمیل تأیید به آدرس ارائه شده در بالا را بدهند.</p>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="login-modal" class="modal fade" role="dialog" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">
                    <i class="close-icon"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input class="text-field" type="text"  placeholder="نام کاربری">
                    <input class="text-field" type="password" placeholder="رمز عبور">
                    <button class="btn btn-warning" type="submit">ورود</button>
                    <button class="btn btn-link">ایجاد حساب کاربری</button>
                </form>
            </div>
        </div>
    </div>
</div>