<?
/* @var $this Controller */
?>
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= $this->createUrl('/') ?>">
                <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/site_logo.png' ?>" class="siteLogo__image" alt="بهترین ها به انتخاب من و تو">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav navbar-right ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->createUrl('/latest') ?>">تازه ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->createUrl('/popular') ?>">محبوب ترین ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->createUrl('/lists') ?>">دسته بندی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->createUrl('/new') ?>">ایجاد لیست</a>
                    </li>
                    <?php if (Yii::app()->user->isGuest): ?>
                        <li class="nav-item">
                            <a href="#login-modal" data-toggle="modal" class="nav-link">ورود / ثبت نام</a>
                        </li>
                    <?php endif;?>
                </ul>
                <?php if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'): ?>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="dropdown show">
                                <a class="btn dropdown-toggle" href="#"
                                   role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <span><?= Yii::app()->user->showName ?></span>
                                    <img src="<?= Yii::app()->user->avatar ?>" class="mr-3 img-fluid user-image" alt="">
                                    <?php if ($this->userNotifications != 0 and Yii::app()->request->pathInfo != 'notifications'): ?>
                                        <span class="badge"><?= $this->userNotifications ?></span>
                                    <?php endif; ?>
                                </a>

                                <div class="dropdown-menu text-right p-3" aria-labelledby="dropdownMenuLink">
                                    <div class="arrow"></div>
                                    <a class="dropdown-item" href="<?= $this->createUrl('/dashboard') ?>">
                                        <p class="mb-1"><?= Yii::app()->user->showName ?></p>
                                    </a>
                                    <a class="dropdown-item" href="<?= $this->createUrl('/profile') ?>">
                                        <p class="mb-1">ویرایش پروفایل</p>
                                    </a>
                                    <a class="dropdown-item" href="<?= $this->createUrl('/changePassword') ?>">
                                        <p class="mb-1">تغییر کلمه عبور</p>
                                    </a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="<?= $this->createUrl('/new') ?>">ایجاد لیست جدید</a>
                                    <a class="dropdown-item" href="<?= $this->createUrl('/notifications') ?>">
                                        اطلاعیه ها
                                        <?php if ($this->userNotifications != 0 and Yii::app()->request->pathInfo != 'notifications'): ?>
                                            <span class="badge"><?= $this->userNotifications ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <a class="dropdown-item" href="<?= $this->createUrl('/recommended') ?>">لیست های پیشنهادی</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= $this->createUrl('/logout') ?>">خروج</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                <?php endif;?>
            </div>
        </div>
    </nav>
</header>