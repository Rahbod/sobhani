<?php
/**
 * @var $showOnMobile boolean
 */

if(!isset($showOnMobile))
    $showOnMobile = true;
?>
<div class="col-md-4 order-1 <?php if($showOnMobile):?>d-block d-sm-none<?php else:?>d-none d-sm-block<?php endif;?>">
    <div class="listView--leftBox listView--leftBox--reports mb-3">
        <h5 class="-h5 mb-3 pb-3 listView--leftBox -title">آمار و جزئیات</h5>
        <ul class="list">
            <li class="mb-3">
                <p>
                    <i class="fas fa-eye ml-4"></i>
                    <span><?php echo number_format($model->seen)?></span>
                    <span>مشاهده</span>
                </p>
            </li>
            <?php if($model->getVoteCount()):?>
                <li class="mb-3">
                    <p>
                        <i class="fas fa-check-square ml-4"></i>
                        <span><?php echo number_format($model->getVoteCount())?></span>
                        <span>رای ثبت شده</span>
                    </p>
                </li>
            <?php endif;?>
            <?php if($model->getVotedUsersCount()):?>
                <li class="mb-3">
                    <p>
                        <i class="fas fa-user ml-4"></i>
                        <span><?php echo number_format($model->getVotedUsersCount())?></span>
                        <span>نفر شرکت کننده</span>
                    </p>
                </li>
            <?php endif;?>
            <?php if($model->getBookmarkedCount()):?>
                <li class="">
                    <p>
                        <i class="fas fa-bookmark ml-4"></i>
                        <span><?php echo number_format($model->getBookmarkedCount())?></span>
                        <span>ذخیره سازی</span>
                    </p>
                </li>
            <?php endif;?>
        </ul>
    </div>
    <?php if($this->similarProvider):?>
        <div class="listView--leftBox">
            <div class="listView--leftBox--related mb-3">
                <h5 class="-h5 mb-3 pb-3 listView--leftBox -title">لیست های مرتبط</h5>
                <div class="listView--leftBox--item">
                    <?php foreach ($this->similarProvider as $item): ?>
                        <a href="<?= $item->getViewUrl() ?>">
                            <div class="d-flex">
                                <div>
                                    <img src="<?= Yii::app()->getBaseUrl(true) . '/uploads/lists/thumbs/400x300/'. $item->getImage() ?>" alt="<?= $item->title ?>">
                                </div>
                                <div class="flex-fill listView--leftBox--related--descriptionsContainer">
                                    <p><?= $item->title ?></p>
                                    <p class="text-muted"><?= $item->seen ?>&nbsp;بازدید</p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif;?>
    <div class="listView--leftBox mb-3">
        <div class="listView--leftBox--related listView--leftBox--newest">
            <h5 class="-h5 mb-3 pb-3 listView--leftBox -title">جدیدترین لیست ها</h5>
            <div class="listView--leftBox--item">
                <?php foreach($this->getLatestListsByID() as $list): ?>
                    <a href="<?= $list->getViewUrl() ?>">
                        <div class="d-flex">
                            <div>
                                <img src="<?= Yii::app()->getBaseUrl(true) . '/uploads/lists/thumbs/400x300/'. $list->getImage() ?>" alt="<?= $list->title ?>">
                            </div>
                            <div class="flex-fill listView--leftBox--related--descriptionsContainer">
                                <p><?= $list->title ?></p>
                                <p class="text-muted"><?= $list->seen ?>&nbsp;بازدید</p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>