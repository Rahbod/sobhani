<?
/* @var $this Controller */
?>
<nav id="sidebar">
    <!--    <div id="dismiss">-->
    <!--        <i class="fas fa-arrow-left"></i>-->
    <!--    </div>-->
    <div class="sidebar-header">
        <h4 class="-h4">10 بهترین</h4>
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
                    <a href="<?= $this->createUrl('/dashboard') ?>" class="flex-fill menu-item">سعید سبحانی</a>
                    <a class="submenu" href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false"></a>
                </div>
                <ul class="collapse list-unstyled" id="homeSubmenu2">
                    <li>
                        <a class="menu-item" href="<?= $this->createUrl('/new') ?>">ایجاد لیست جدید</a>
                    </li>
                    <li>
                        <a class="menu-item" href="<?= $this->createUrl('/notifications') ?>">اطلاعیه
                            ها <?php if ($this->userNotifications != 0 and Yii::app()->request->pathInfo != 'notifications'): ?>
                                <span class="notification-count"><?= $this->userNotifications ?></span><?php endif; ?>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item" href="<?= $this->createUrl('/my-lists') ?>">لیست های من</a>
                    </li>
                    <li>
                        <a class="menu-item" href="<?= $this->createUrl('/bookmarks') ?>">لیست های ذخیره شده</a>
                    </li>
                    <li>
                        <a class="menu-item" href="<?= $this->createUrl('/recommended') ?>">لیست های پیشنهادی</a>
                    </li>
                    <li>
                        <a class="menu-item" href="<?= $this->createUrl('/logout') ?>">خروج</a>
                    </li>
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

                        <a href="#login-modal" data-toggle="modal" class="nav-link signUp btn-outline-light mr-3">
                            ورود / ثبت نام
                        </a>
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

            <a href="<?= $this->createUrl('/new') ?>"
               class="btn btn-outline-light rounded searchBox__createListBtn -white">ایجاد لیست</a>
            <a href="#login-modal" data-target="#login-modal" data-toggle="modal"
               class="btn btn-outline-light rounded searchBox__loginBtn -white mr-5">ورود / ثبت نام</a>
            <div class="scrollDownContainer text-center">
                <span class="scrollDown"></span>
            </div>

        </div>
    </div>
    <img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/oval_2.png' ?>" class="header__bottomImage">
</header>