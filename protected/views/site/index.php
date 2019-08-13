<?php
/**
 * @var $this Controller
 * @var $cs CClientScript
 * @var $baseUrl string
 * @var $slider Lists[]
 * @var $newLists Lists[]
 * @var $lastEvents UserNotifications[]
 * @var $statistics []
 */

$listPath = Yii::getPathOfAlias('webroot') . '/uploads/lists/thumbs/200x200/';
$listUrl = Yii::app()->getBaseUrl(true) . '/uploads/lists/thumbs/200x200/';

$listItemPath = Yii::getPathOfAlias('webroot') . '/uploads/items/thumbs/150x150/';
$listItemUrl = Yii::app()->getBaseUrl(true) . '/uploads/items/thumbs/150x150/';
?>

    <section class="favoriteList section">
        <div class="sectionHeader">
            <div class="sectionHeader__container">
                <h4 class="sectionTitle -h4">محبوبترین لیست ها</h4>
                <span class="borderBottom"></span>
            </div>
        </div>
        <div class="sectionBody">
            <div class="sectionBody__container">
                <div class="sliderItem owl-carousel owl-theme">
                    <?php foreach ($slider as $item): ?>
                        <a href="<?= $item->getViewUrl() ?>" class="sliderItem__link" title="<?= $item->title ?>">
                            <img class="sliderItem__title"
                                 src="<?= $listUrl . $item->getImage() ?>" alt="<?= $item->title ?>"/>
                            <h5 class="-h5 sliderItem__title">
                                <?= $item->title ?>
                            </h5>
                            <!--                            <p class="sliderItem__description">-->
                            <!--                                --><? //= $item->short_title ?>
                            <!--                            </p>-->
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="sectionFooter">
            <div class="sectionFooter__container">
                <a href="<?= $this->createUrl('/popular') ?>" class="btn btn-outline-info moreBtn">نمایش همه لیست های
                    محبوب</a>
            </div>
        </div>
    </section>

    <section class="newestList section">
        <div class="container">
            <div class="sectionHeader">
                <div class="sectionHeader__container">
                    <h4 class="sectionTitle -h4">جدیدترین لیست ها</h4>
                    <span class="borderBottom"></span>
                </div>
            </div>
            <div class="sectionBody">
                <div class="sectionBody__container">
                    <div class="container-fluid">
                        <?php
                        $list = $newLists[0];
                        unset($newLists[0]);
                        ?>
                        <div class="row" style="margin-bottom: 65px;">
                            <div class="col-sm-8 col-lg-8 pl-sm-0">
                                <div class="favoriteList--rightBox">
                                    <a href="<?= $list->getViewUrl() ?>">
                                        <img src="<?= $listUrl . $list->getImage() ?>" class="img-fluid" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4 pr-sm-0">
                                <div class="favoriteList--leftBox">
                                    <h5 class="favoriteList--leftBox_title"><?= $list->title ?></h5>

                                    <div class="favoriteList--leftBox__descriptions">
                                        <p class="favoriteList--leftBox_text"><?= Controller::cutText($list->description) ?></p>
                                        <ul class="favoriteList--leftBox_list">
                                            <li class="position-relative"><a
                                                        href="void:;"><?= $list->itemObj[0]->title ?></a></li>
                                            <li class="position-relative"><a
                                                        href="void:;"><?= $list->itemObj[1]->title ?></a></li>
                                            <li class="position-relative"><a
                                                        href="void:;"><?= $list->itemObj[2]->title ?></a></li>
                                            <li class="position-relative"><a href="void:;">نمایش سایر گزینه ها</a></li>
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="favoriteList--leftBox__footer">
                                        <a href="void:;" class="favoriteList--leftBox__footer_link">
                                            <img class="favoriteList--leftBox__footer_userAvatar"
                                                 src="<?= $list->user->userDetails->getAvatar() ?>" alt="">
                                            <div class="d-inline-block">
                                                <h6 class="favoriteList--leftBox__footer_userName -h6"><?= $list->user->userDetails->getShowName() ?></h6>
                                                <p class="m-0"><?= $list->user->getListCount(true) ?> لیست</p>
                                            </div>
                                            <img class="favoriteList--leftBox__footer_listImage"
                                                 src="<?= Yii::app()->theme->baseUrl . '/media/images/public/icon-1.png' ?>"
                                                 alt="bookmark">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row home-page-list">
                            <?php foreach ($newLists as $list): ?>
                                <div class="col-sm-6 col-md-4 col-md-3 list-thumbnail ">
                                    <div class="card">
                                        <div class="card-header favoriteList--leftBox__footer">
                                            <?php if ($list->user): ?>
                                                <a href="<?= $list->getViewUrl() ?>" class="favoriteList--leftBox__footer_link">
                                                    <img class="favoriteList--leftBox__footer_userAvatar"
                                                         src="<?= $list->user->userDetails->getAvatar() ?>" alt="">
                                                    <div class="d-inline-block">
                                                        <h6 class="favoriteList--leftBox__footer_userName -h6"><?= $list->user->userDetails->getShowName() ?></h6>
                                                        <p class="m-0"><?= $list->user->getListCount(true) ?> لیست</p>
                                                    </div>
                                                    <img class="favoriteList--leftBox__footer_listImage"
                                                         src="<?= Yii::app()->theme->baseUrl . '/media/images/public/icon-1.png' ?>"
                                                         alt="bookmark">
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= $list->getViewUrl() ?>" class="favoriteList--leftBox__footer_link">
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
                                        <a href="<?= $list->getViewUrl() ?>">
                                            <img class="card-img-top" src="<?= $listUrl . $list->getImage() ?>" alt="<?= $list->title ?>">
                                        </a>
                                        <div class="card-body">
                                            <a href="<?= $list->getViewUrl() ?>">
                                                <h5 class="favoriteList--leftBox_title card-title"><?= $list->title ?></h5>
                                            </a>
                                            <p class="favoriteList--leftBox_text card-text"><?= Controller::cutText($list->description) ?></p>
                                            <p class="card-text text-left">
                                                <small class="text-muted"><?= JalaliDate::differenceTime($list->update_date) ?></small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sectionFooter">
                <div class="sectionFooter__container">
                    <a href="<?= $this->createUrl('/latest') ?>" class="btn btn-outline-info moreBtn">نمایش همه لیست های
                        اخیر</a>
                </div>
            </div>
        </div>
    </section>

    <section class="whatsUpHere section">
        <div class="container">
            <div class="sectionHeader">
                <div class="sectionHeader__container">
                    <h4 class="sectionTitle -h4">اینجا چه خبره؟!</h4>
                    <span class="borderBottom"></span>
                </div>
            </div>
            <div class="sectionBody">
                <div class="sectionBody__container">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 col-lg-6">
                                <div class="whatsUpHere--rightBox">
                                    <h5 class="favoriteList--leftBox_title">10 بهترین شهر ایران برای گردشگری ، شرح این
                                        متن به شکل کامل</h5>
                                    <div class="favoriteList--leftBox__descriptions">
                                        <p class="favoriteList--leftBox_text pre-line">
                                            وبسایت 10 بهترین با هدف شناسایی و مفرفی بهترین ها در زمینه های مختبف بر اساس
                                            نظرات و آرای مردمی ایجاد شده است.

                                            هر فردی میتواند با عضویت در وبسایت لیست دلخواه خود را ایجاد کند و آن را به
                                            نظرسنجی و رای گیری عمومی بگذارد.افراد میتوانند به گزینه (های ) دلخواهشان رای
                                            دهند با نظر خود را در مورد آن گزینه اعلام کنند.

                                            رفته رفته با مشارکت بیشتر کاربران وبسایت 10 بهترین به مرجعی کامل از بهترین
                                            شخصیت ها ، شرکتها ،موسسات ، برنامه های تلویزیونی ، مکان های گردشگری و ..
                                            تبدیل خواهد شد.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-6">
                                <div class="text-center">
                                    <video class="img-fluid" controls poster="./assets/media/images/home/slider/p-2.png">
                                        <source src="./assets/media/videos/360.mp4" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="latestEvents section">
        <div class="container">
            <div class="sectionHeader">
                <div class="sectionHeader__container">
                    <h4 class="sectionTitle -h4">رویدادهای اخیر</h4>
                    <span class="borderBottom"></span>
                    <input type="hidden" id="last-id" value="<?= $lastEvents[0]->id ?>">
                </div>
            </div>
            <div class="sectionBody">
                <div class="sectionBody__container">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <ul class="list-unstyled p-0 latestEvents__lists">
                                    <?php foreach ($lastEvents as $event): ?>
                                        <li>
                                            <div class="d-flex align-items-center align-items-lg-baseline">
                                                <div>
                                                    <?php if ($event->user): ?>
                                                        <a href="void:;" class="-text-blue"><img src="<?= $event->user->userDetails->getAvatar() ?>"></a>
                                                    <?php else: ?>
                                                        <a href="void:;" class="-text-blue"><img src="<?= Yii::app()->theme->baseUrl . '/media/images/public/user_avatar.png' ?>"></a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex-fill"><?= $event->message ?></div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="reports section">
        <div class="container">
            <div class="sectionHeader">
                <div class="sectionHeader__container">
                    <h4 class="sectionTitle -h4">آمار</h4>
                    <span class="borderBottom"></span>
                </div>
            </div>
            <div class="sectionBody">
                <div class="sectionBody__container">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-4 col-lg-4">
                                <div class="reports__itemContainer text-center mb-5 mb-md-0">
                                    <a class="list">
                                        <div class="greyCircle">
                                            <img class="img-fluid"
                                                 src="<?= Yii::app()->theme->baseUrl . '/media/images/home/list_2.png' ?>"
                                                 alt="">
                                        </div>
                                        <div class="counter--container">
                                            <h2 class="-h2 counter"><?= $statistics['lists'] ?></h2>
                                            <p class="">لیست ایجاد شده</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4">
                                <div class="reports__itemContainer text-center mb-5 mb-md-0">
                                    <a class="user">
                                        <img class="img-fluid"
                                             src="<?= Yii::app()->theme->baseUrl . '/media/images/home/user_2.png' ?>"
                                             alt="">
                                        <div class="counter--container">
                                            <h2 class="-h2 counter"><?= $statistics['users'] ?></h2>
                                            <p class="">کاربر شرکت کننده</p>
                                        </div>
                                    </a>

                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4">
                                <div class="reports__itemContainer text-center mb-5 mb-md-0">
                                    <a class="vote">
                                        <img class="img-fluid"
                                             src="<?= Yii::app()->theme->baseUrl . '/media/images/home/vote_2.png' ?>"
                                             alt="">
                                        <div class="counter--container">
                                            <h2 class="-h2 counter"><?= $statistics['votes'] ?></h2>
                                            <p class="">رای ثبت شده</p>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="searchBoxFooter section">
        <form class="search-form" action="<?= $this->createUrl('/search') ?>" method="get">
            <div class="input-group rounded">
                <input name="term" type="text" class="form-control" placeholder="جستجوی بهترین ..."
                       aria-label="search-box"
                       aria-describedby="search-box">
                <div class="input-group-prepend">
                <span class="input-group-text" id="footer-search-box">
                    <button type="submit" class="search-btn"><i class="search-icon"></i></button>
                </span>
                </div>
            </div>
        </form>
    </section>

<?php //Yii::app()->clientScript->registerScript("events", "
//setInterval(function(){
//    $.ajax({
//        url: '" . $this->createUrl('getLastEvents') . "',
//        type: 'POST',
//        dataType: 'JSON',
//        data: {lastID: $('.events #last-id').val()},
//        success: function(data){
//            if(data.status){
//                for(i=0;i < data.items.length;i++){
//                    $('.events table tr:last-child').remove();
//                    $('.events table tbody').prepend('<tr><td><i class=\"icon-check-sign\"></i></td><td>'+data.items[i]+'</td></tr>');
//                    $('.events #last-id').val(data.lastID);
//                }
//            }
//        }
//    });
//}, 60000);
//"); ?>