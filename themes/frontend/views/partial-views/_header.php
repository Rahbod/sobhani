<?
/* @var $this Controller*/
?>
<div class="header navbar-fixed-top">
    <div class="container">
        <div class="col-lg-2 col-md-1 col-sm-6 col-xs-6">
            <div class="row">
                <div class="logo-box">
                    <a href="<?= Yii::app()->getBaseUrl(true)?>">
                        <img src="<?php echo Yii::app()->theme->baseUrl.'/svg/logo.svg' ?>" alt="<?= Yii::app()->name ?>" title="<?= Yii::app()->name ?>">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-9 col-sm-6 col-xs-6">
            <div class="row">
                <div class="mobile-menu-trigger hidden-lg hidden-md" data-toggle="collapse" data-target="#mobile-menu"></div>
                <div class="mobile-search-trigger hidden-lg hidden-md"></div>
                <ul class="nav navbar-nav hidden-sm hidden-xs menu">
                    <li><a href="<?= $this->createUrl('/lists') ?>">لیست ها</a></li>
                    <li><a href="<?= $this->createUrl('/latest') ?>">تازه ها</a></li>
                    <li><a href="<?= $this->createUrl('/new') ?>">افزودن لیست</a></li>
                    <?php if(!Yii::app()->user->isGuest && Yii::app()->user->type =='user'):?>
                        <li><a href="<?= $this->createUrl('/recommended') ?>">پیشنهاد برای شما</a></li>
                        <li  class="user-link"><a title="<?= Yii::app()->user->showName ?>" href="<?= $this->createUrl('/dashboard')?>"><i class="user-icon"></i><?= Yii::app()->user->showName ?></a>
                        <li><a href="<?= $this->createUrl('/dashboard')?>" class="h"><i class="home-icon"></i></a></li>
                        <li><a href="<?= $this->createUrl('/bookmarks')?>" class="s" title="علاقه مندی ها"><i class="star-icon"></i></a></li>
                        <li><a href="<?= $this->createUrl('/notifications')?>" class="e" title="پیام ها"><i class="envelope-icon"></i><?php if($this->userNotifications != 0 and Yii::app()->request->pathInfo != 'notifications'):?><span class="notification-count"><?= $this->userNotifications?></span><?php endif;?></a></li>
                        <li><a href="<?= $this->createUrl('/logout')?>" class="l" title="خروج"><i class="logout-icon"></i></a></li>
                    <?php else:?>
<!--                        <li><a href="#login-modal" data-toggle="modal">ورود</a></li>-->
<!--                        <li><a href="#join-modal" data-toggle="modal">ثبت نام</a></li>-->
                        <li><a href="#login-modal" data-toggle="modal">ورود/ثبت نام</a></li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-md-2 hidden-sm hidden-xs search-container">
            <?php echo CHtml::beginForm(array('/search'),'get'); ?>
            <div class="row">
                <div class="input-group">
                    <?php echo CHtml::textField('term',isset($_GET['term'])?$_GET['term']:'', array('class' => 'form-control')) ?>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit"><i class="search-icon"></i></button>
                    </span>
                </div>
            </div>
            <?php echo CHtml::endForm(); ?>
        </div>
        <?php echo CHtml::beginForm(array('/search'),'get',array('class' => 'hidden-lg hidden-md mobile-search search-container')); ?>
            <div class="close-search-container"></div>
            <div class="input-group">
                <?php echo CHtml::textField('term',isset($_GET['term'])?$_GET['term']:'', array('class' => 'form-control')) ?>
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit"><i class="search-icon"></i></button>
                </span>
            </div>
        <?php echo CHtml::endForm(); ?>
        <ul class="nav navbar-nav hidden-lg hidden-md collapse" id="mobile-menu">
            <li><a href="<?= $this->createUrl('/lists') ?>">لیست ها</a></li>
            <li><a href="<?= $this->createUrl('/latest') ?>">تازه ها</a></li>
            <li><a href="<?= $this->createUrl('/new') ?>">افزودن لیست</a></li>
            <?php if(!Yii::app()->user->isGuest && Yii::app()->user->type =='user'):?>
                <li><a href="<?= $this->createUrl('/recommended') ?>">پیشنهاد برای شما</a></li>
                <li><a href="<?= $this->createUrl('/dashboard')?>"><i class="user-icon"></i><?= Yii::app()->user->showName ?></a>
                <li class="icon-link"><a href="<?= $this->createUrl('/dashboard')?>" class="h"><i class="home-icon"></i></a></li>
                <li class="icon-link"><a href="<?= $this->createUrl('/bookmarks')?>" class="s"><i class="star-icon"></i></a></li>
                <li class="icon-link"><a href="<?= $this->createUrl('/notifications')?>" class="e"><i class="envelope-icon"></i><?php if($this->userNotifications != 0):?><span class="notification-count"><?= $this->userNotifications?></span><?php endif;?></a></li>
                <li class="icon-link"><a href="<?= $this->createUrl('/logout')?>" class="l"><i class="lock-icon"></i></a></li>
            <?php else:?>
                <li><a href="#login-modal" data-toggle="modal">ورود</a></li>
                <li><a href="#join-modal" data-toggle="modal">ثبت نام</a></li>
            <?php endif;?>
        </ul>
    </div>
</div>