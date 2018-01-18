<?
/* @var $this Controller*/
?>
<div class="header navbar-fixed-top">
    <div class="container">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <div class="row">
                <div class="logo-box">
                    <a href="<?= Yii::app()->getBaseUrl(true)?>">
                        <img src="<?php echo Yii::app()->theme->baseUrl.'/svg/logo.jpg' ?>">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="mobile-menu-trigger hidden-lg hidden-md hidden-sm" data-toggle="collapse" data-target="#mobile-menu"></div>
                <div class="mobile-search-trigger hidden-lg hidden-md hidden-sm"></div>
                <ul class="nav navbar-nav hidden-xs">
                    <li><a href="<?= $this->createUrl('/lists') ?>">لیست ها</a></li>
                    <li><a href="<?= $this->createUrl('/latest') ?>">تازه ها</a></li>
                    <li><a href="<?= $this->createUrl('/new') ?>">افزودن لیست</a></li>
                    <li><a href="<?= $this->createUrl('/recommended') ?>">پیشنهاد برای شما</a></li>
                    <?php if(!Yii::app()->user->isGuest && Yii::app()->user->type =='user'):?>
                        <li class="user-link"><a href="<?= $this->createUrl('/dashboard')?>"><i class="user-icon"></i><?= Yii::app()->user->first_name.' '.Yii::app()->user->last_name ?></a>
                        <li><a href="<?= $this->createUrl('/dashboard')?>" class="h"><i class="home-icon"></i></a></li>
                        <li><a href="<?= $this->createUrl('/bookmarks')?>" class="s"><i class="star-icon"></i></a></li>
                        <li><a href="<?= $this->createUrl('/notifications')?>" class="e"><i class="envelope-icon"></i></a></li>
                        <li><a href="<?= $this->createUrl('/logout')?>" class="l"><i class="lock-icon"></i></a></li>
                    <?php else:?>
                        <li><a href="#login-modal" data-toggle="modal">ورود</a></li>
                        <li><a href="#join-modal" data-toggle="modal">ثبت نام</a></li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs search-container">
            <div class="row">
                <div class="input-group">
                    <input class="form-control" type="text">
                    <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button"><i class="search-icon"></i></button>
                        </span>
                </div>
            </div>
        </div>
        <form class="hidden-lg hidden-md hidden-sm mobile-search search-container">
            <div class="close-search-container"></div>
            <div class="input-group">
                <input class="form-control" type="text">
                <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button"><i class="search-icon"></i></button>
                    </span>
            </div>
        </form>
        <ul class="nav navbar-nav hidden-lg hidden-md hidden-sm collapse" id="mobile-menu">
            <li><a href="<?= $this->createUrl('/lists') ?>">لیست ها</a></li>
            <li><a href="<?= $this->createUrl('/latest') ?>">تازه ها</a></li>
            <li><a href="<?= $this->createUrl('/new') ?>">افزودن لیست</a></li>
            <li><a href="<?= $this->createUrl('/recommended') ?>">پیشنهاد برای شما</a></li>
            <?php if(!Yii::app()->user->isGuest && Yii::app()->user->type =='user'):?>
                <li><a href="<?= $this->createUrl('/dashboard')?>"><i class="user-icon"></i><?= Yii::app()->user->first_name ?></a>
                <li class="icon-link"><a href="<?= $this->createUrl('/dashboard')?>" class="h"><i class="home-icon"></i></a></li>
                <li class="icon-link"><a href="<?= $this->createUrl('/bookmarks')?>" class="s"><i class="star-icon"></i></a></li>
                <li class="icon-link"><a href="<?= $this->createUrl('/notifications')?>" class="e"><i class="envelope-icon"></i></a></li>
                <li class="icon-link"><a href="<?= $this->createUrl('/logout')?>" class="l"><i class="lock-icon"></i></a></li>
            <?php else:?>
                <li><a href="#login-modal" data-toggle="modal">ورود</a></li>
                <li><a href="#join-modal" data-toggle="modal">ثبت نام</a></li>
            <?php endif;?>
        </ul>
    </div>
</div>