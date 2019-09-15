<?
/* @var $this Controller */
?>
<nav id="sidebar">
    <!--    <div id="dismiss">-->
    <!--        <i class="fas fa-arrow-left"></i>-->
    <!--    </div>-->
    <div class="sidebar-header">
        <img src="<?php echo Yii::app()->theme->baseUrl;?>/media/images/public/site_logo.png" class="siteLogo__image" alt="10 بهترین">
        <p>بهترین ها به انتخاب من و تو</p>
    </div>

    <ul class="list-unstyled components">
        <li>
            <a class="menu-item" href="<?= $this->createUrl('/latest') ?>">تازه ها</a>
        </li>
        <li>
            <a class="menu-item" href="<?= $this->createUrl('/popular') ?>">محبوب ترین ها</a>
        </li>
        <li>
            <a class="menu-item" href="<?= $this->createUrl('/lists') ?>">دسته بندی</a>
        </li>
        <li>
            <a class="menu-item" href="<?= $this->createUrl('/new') ?>">ایجاد لیست</a>
        </li>

        <?php if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'): ?>
            <li>
                <div class="d-flex">
                    <a href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false" class="flex-fill menu-item"><?= Yii::app()->user->showName ?></a>
                    <a class="submenu" href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false"></a>
                </div>
                <ul class="collapse list-unstyled" id="homeSubmenu2">
                    <li><a class="menu-item" href="<?= $this->createUrl('/dashboard') ?>">داشبورد</a></li>
                    <li><a class="menu-item" href="<?= $this->createUrl('/profile') ?>">ویرایش پروفایل</a></li>
                    <li><a class="menu-item" href="<?= $this->createUrl('/changePassword') ?>">تغییر کلمه عبور</a></li>
                    <li><a class="menu-item" href="<?= $this->createUrl('/new') ?>">ایجاد لیست جدید</a></li>
                    <li>
                        <a class="menu-item" href="<?= $this->createUrl('/notifications') ?>">اطلاعیه
                            ها <?php if ($this->userNotifications != 0 and Yii::app()->request->pathInfo != 'notifications'): ?>
                                <span class="badge" style="left: 15px;"><?= $this->userNotifications ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li><a class="menu-item" href="<?= $this->createUrl('/bookmarks') ?>">لیست های ذخیره شده</a></li>
                    <li><a class="menu-item" href="<?= $this->createUrl('/recommended') ?>">لیست های پیشنهادی</a></li>
                    <li><a class="menu-item" href="<?= $this->createUrl('/logout') ?>">خروج</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li>
                <a href="#login-modal" data-toggle="modal" class="menu-item">
                    ورود / ثبت نام
                </a>
            </li>
        <?php endif; ?>
    </ul>

</nav>
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= $this->createUrl('/home') ?>">
                <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/site_logo.png' ?>" class="siteLogo__image" alt="بهترین ها به انتخاب من و تو">
            </a>
<!--            <button class="navbar-toggler" type="button" data-toggle="collapse"-->
<!--                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"-->
<!--                    aria-expanded="false" aria-label="Toggle navigation">-->
<!--                <span class="navbar-toggler-icon"></span>-->
<!--            </button>-->
            <button id="sidebarCollapse" class="navbar-toggler" type="button">
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
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
                                    <img src="<?= Yii::app()->user->avatar ?>" class="mr-3 img-fluid user-image rounded-circle" alt="">
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
                                    <a class="dropdown-item" href="<?= $this->createUrl('/bookmarks') ?>">لیست های ذخیره شده</a>
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