<?
/* @var $this Controller */
$app = Yii::app();
$user = $app->user;
?>

<header class="header">
    <div class="container">

        <!--        --><? //= var_dump($app);exit;?>

        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" title="<?= $app->name ?>" href="<?= $app->getBaseUrl(true) ?>">
                <img src="<?php echo $app->theme->baseUrl . '/assets/media/images/public/site_logo.png' ?>"
                     class="siteLogo__image img-fluid" alt="<?= $app->name ?>">
                <span class="d-none d-lg-inline" style="font-size: inherit;color: inherit;font-weight: inherit;"> بهترین ها به انتخاب من و تو</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <!--<span class="navbar-toggler-icon"></span>-->
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->createUrl('/latest') ?>">تازها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->createUrl('/lists') ?>">دسته بندی</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->createUrl('/new') ?>">ایجاد لیست</a>
                    </li>
                    <?php if (!$user->isGuest && $user->type == 'user'): ?>
                        <li class="nav-item">
                            <div class="dropdown show">
                                <a title="<?= $user->showName ?>" class="btn dropdown-toggle"
                                   href="<?= $this->createUrl('/dashboard') ?>"
                                   role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <span style="font-size: inherit!important;"><?= $user->showName ?></span>
                                    <img src="<?php $user->image ?>"
                                         class="d-none d-md-inline mr-3 img-fluid"
                                         alt="title="<?= $user->showName ?>">
                                    <?php if ($this->userNotifications != 0 and $app->request->pathInfo != 'notifications'): ?>
                                        <span class="badge"><?= $this->userNotifications ?></span>
                                    <?php endif; ?>
                                </a>

                                <div class="dropdown-menu text-right p-3" aria-labelledby="dropdownMenuLink">
                                    <div class="arrow"></div>
                                    <a class="dropdown-item" href="<?= $this->createUrl('/dashboard') ?>">
                                        <p class="mb-1"><?php $user->showName ?></p>
                                        <p class="mb-1 editProfileBtn">
                                            ویرایش پروفایل
                                        </p>
                                    </a>
                                    <div class="dropdown-divider"></div>

                                    <a title="پیشنهاد برای شما" class="dropdown-item"
                                       href="<?php $this->createUrl('/recommended') ?>">پیشنهادبرای شما</a>
                                    <a title="اطلاعیه ها" class="dropdown-item"
                                       href="<?= $this->createUrl('/notifications') ?>">
                                        اطلاعیه ها<span class="badge">14</span>
                                    </a>
                                    <a title="لیست های من" class="dropdown-item"
                                       href="<?= $this->createUrl('/my_lists') ?>">لیست های من</a>
                                    <a title="لیست های ذخیره شده" class="dropdown-item"
                                       href="<?= $this->createUrl('/stored_lists') ?>">لیست های ذخیره شده</a>
                                    <a title="لیست های پیشنهادی" class="dropdown-item"
                                       href="<?= $this->createUrl('/suggested_lists') ?>">لیست های پیشنهادی</a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item"
                                       href="<?php echo Yii::app()->createUrl('/logout') ?>">خروج</a>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <div class="btn-group d-none d-md-inline-flex" dir="ltr" role="group"
                                 aria-label="Basic example">
                                <a class="nav-link signUp btn-outline-light" href="#register-modal" data-toggle="modal"
                                   title="عضویت">عضویت</a>
                                <a class="nav-link signIn btn-outline-light mr-3" href="#login-modal"
                                   data-toggle="modal"
                                   style="border-left: 1px solid rgba(255,255,255,0.3);" title="ورود">ورود</a>
                            </div>
                        </li>
                    <?php endif; ?>

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

            <?php echo CHtml::beginForm(array('/search'), 'get', ['class' => 'search-form']); ?>
            <!--            <form class="search-form">-->
            <div class="input-group mb-3 rounded">
                <?php echo CHtml::textField('search-box', isset($_GET['term']) ? $_GET['term'] : '',
                    array('class' => 'form-control', 'placeHolder' => 'جستجوی بهترین ...')) ?>

                <!--                    <input type="text" class="form-control" placeholder="جستجوی بهترین ..." aria-label="search-box"-->
                <!--                           aria-describedby="search-box">-->
                <div class="input-group-prepend">
                    <span class="input-group-text rounded" id="">
                        <button type="submit" class="search-btn">
                            <i class="search-icon"></i>
                        </button>
                    </span>
                </div>
            </div>
            <!--            </form>-->
            <?php echo CHtml::endForm(); ?>

            <h4 class="-white my-5 -h5">شما نیز میتوانید لیستی از بهترین ها بسازید!</h4>

            <a href="<?= $this->createUrl('/new') ?>" title="ایجاد لیست"
               class="btn btn-outline-light rounded searchBox__createListBtn -white">ایجاد لیست</a>

<!--            <div class="btn-group searchBox__loginBtn -white mr-5" dir="ltr" role="group"-->
<!--                 aria-label="Basic example">-->
<!--                <a class="nav-link signUp btn-outline-light" href="#register-modal" data-toggle="modal"-->
<!--                   title="عضویت">عضویت</a>-->
<!--                <a class="nav-link signIn btn-outline-light mr-3" href="#login-modal"-->
<!--                   data-toggle="modal"-->
<!--                   style="border-left: 1px solid rgba(255,255,255,0.3);" title="ورود">ورود</a>-->
<!--            </div>-->

            <div class="scrollDownContainer text-center">
                <span class="scrollDown"></span>
            </div>

        </div>
    </div>
    <img src="<?= Yii::app()->theme->baseUrl . '/assets/media/images/public/oval_2.png' ?> "
         class="header__bottomImage">
</header>
