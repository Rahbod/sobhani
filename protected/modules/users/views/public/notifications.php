<?php
/* @var $this UsersPublicController */
/* @var $model UserNotifications */

$this->breadcrumbs = array(
    'داشبورد' => array('/dashboard'),
    'اطلاعیه ها'
);
?>
<h2>اطلاعیه ها</h2>
<ul class="notification-list">
    <?php foreach($model as $notification):?>
        <li class="<?php echo ($notification->seen==0)?'unseen':'';?>">
            <span class="date"><?php echo JalaliDate::date('d F Y - H:i', $notification->date);?></span>
            <?php echo $notification->message;?>
        </li>
    <?php endforeach;?>
</ul>