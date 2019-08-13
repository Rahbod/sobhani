<?php
/* @var $this UsersPublicController */
/* @var $model UserNotifications */

$this->breadcrumbs = array(
    'داشبورد' => array('/dashboard'),
    'اطلاعیه ها'
);
?>
<section class="createList section">
    <div class="container">
        <h4 class="-h4">اطلاعیه ها</h4>
        <ul class="notification-list">
            <?php foreach($model as $notification):?>
                <li class="<?php echo ($notification->seen==0)?'unseen':'';?>">
                    <span class="date"><?php echo JalaliDate::date('d F Y - H:i', $notification->date);?></span>
                    <?php echo $notification->message;?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</section>