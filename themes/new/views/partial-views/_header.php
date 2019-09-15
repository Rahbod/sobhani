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
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/site_logo.png' ?>"
                     class="siteLogo__image img-fluid" alt="بهترین ها به انتخاب من و تو">
                <span class="d-none d-lg-inline inherit">بهترین ها به انتخاب من و تو</span>
            </a>

            <button id="sidebarCollapse" class="navbar-toggler" type="button">
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
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
                    <li class="nav-item">
                        <?php if (Yii::app()->user->isGuest): ?>
                            <a href="#login-modal" data-toggle="modal" class="nav-link signUp btn-outline-light mr-3">ورود / ثبت نام</a>
                        <?php endif;?>
                        <?php if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'): ?>
                            <div class="dropdown show">
                                <a class="btn dropdown-toggle" href="#"
                                   role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false" style="color: #fff;padding-top: 0;padding-bottom: 0;line-height: 37px;">
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
                        <?php endif;?>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="searchBox">
            <h2 class="-white -h2 mb-3">
                جایی برای
            </h2>
            <h2 class="-white -h2 mb-5">
                شناسایی و معرفی بهترین ها
            </h2>

            <form class="search-form" action="<?= $this->createUrl('/search') ?>" method="get">
                <div class="input-group mb-3 rounded">
                    <input name="term" type="text" class="form-control" placeholder="جستجوی بهترین ..." aria-label="search-box"
                           aria-describedby="search-box">
                    <div class="input-group-prepend">
                    <span class="input-group-text rounded" id="search-box">
                        <button type="submit" class="search-btn"><i class="search-icon"></i></button>
                    </span>
                    </div>
                </div>
            </form>

            <h4 class="-white my-5 -h5">شما نیز میتوانید لیستی از بهترین ها بسازید!</h4>

            <a href="<?= $this->createUrl('/new') ?>" class="btn btn-outline-light rounded searchBox__createListBtn -white">ایجاد لیست</a>
            <?php if(Yii::app()->user->isGuest):?>
                <a href="#login-modal" data-target="#login-modal" data-toggle="modal" class="btn btn-outline-light rounded searchBox__loginBtn -white mr-5">ورود / ثبت نام</a>
            <?php endif;?>
            <div class="scrollDownContainer text-center">
                <span class="scrollDown"></span>
            </div>

        </div>
    </div>
    <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/oval_2.png' ?>" class="header__bottomImage">
</header>