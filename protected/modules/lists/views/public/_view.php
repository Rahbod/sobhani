<?php
/* @var $data Lists */
$path = Yii::getPathOfAlias('webroot').'/uploads/lists/';
$url = Yii::app()->getBaseUrl(true).'/uploads/lists/thumbs/200x200/';
?>
<div class="col-sm-6 col-md-4 col-md-3 list-thumbnail">
    <div class="card">
        <div class="card-header favoriteList--leftBox__footer">
            <?php if ($data->user): ?>
                <a href="<?= $data->getViewUrl() ?>"
                   class="favoriteList--leftBox__footer_link">
                    <img class="favoriteList--leftBox__footer_userAvatar"
                         src="<?= $data->user->userDetails->getAvatar() ?>" alt="">
                    <div class="d-inline-block">
                        <h6 class="favoriteList--leftBox__footer_userName -h6"><?= $data->user->userDetails->getShowName() ?></h6>
                        <p class="m-0"><?= $data->user->getListCount(true) ?> لیست</p>
                    </div>
                    <img class="favoriteList--leftBox__footer_listImage"
                         src="<?= Yii::app()->theme->baseUrl . '/media/images/public/icon-1.png' ?>"
                         alt="bookmark">
                </a>
            <?php else: ?>
                <a href="<?= $data->getViewUrl() ?>" class="favoriteList--leftBox__footer_link">
                    <img class="favoriteList--leftBox__footer_userAvatar"
                         src="<?= Yii::app()->theme->baseUrl . '/media/images/public/user_avatar.png' ?>"
                         alt="">
                    <div class="d-inline-block">
                        <h6 class="favoriteList--leftBox__footer_userName -h6">
                            ناشناس</h6>
                    </div>
                    <img class="favoriteList--leftBox__footer_listImage"
                         src="<?= Yii::app()->theme->baseUrl . '/media/images/public/icon-1.png' ?>"
                         alt="bookmark">
                </a>
            <?php endif; ?>
        </div>
        <a href="<?= $data->getViewUrl() ?>">
            <img class="card-img-top" src="<?= $url . $data->getImage() ?>" alt="<?= $data->title ?>">
        </a>
        <div class="card-body">
            <a href="<?= $data->getViewUrl() ?>">
                <h5 class="favoriteList--leftBox_title card-title"><?= $data->title ?></h5>
            </a>
            <p class="favoriteList--leftBox_text card-text"><?= Controller::cutText($data->description) ?></p>
            <p class="card-text text-left">
                <small class="text-muted"><?= JalaliDate::differenceTime($data->update_date) ?></small>
            </p>
        </div>
    </div>
</div>