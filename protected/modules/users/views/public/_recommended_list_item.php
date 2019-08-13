<?php
/* @var $this UsersPublicController */
/* @var $data Lists */

$url = Yii::app()->getBaseUrl(true).'/uploads/lists/thumbs/200x200/';
?>
<div class="col-12">
    <div class="container-fluid px-0 -opacity">
        <div class="row">
            <div class="col-md-4 px-0 px-md-3 pt-md-3">
                <div class="tab-content__imageContainer">
                    <img class="img-fluid" src="<?= $url . $data->getImage() ?>" alt="<?= $data->title ?>">
                    <div class="tab-content__categoryContainer">
                        <a href="#" class="tab-content__category"><?php echo $data->category->title?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 px-0 px-md-3 pt-md-3">
                <div class="">
                    <a href="<?php $data->getViewUrl()?>" class="-h5 tab-content__title"><?= $data->title ?></a>
                </div>
                <p class="tab-content__publishedDate -fw-400"><?php echo JalaliDate::differenceTime($data->create_date)?></p>
                <div class="reports mb-4">
                    <ul class="list-unstyled p-0 m-0">
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/check.png">
                                <?= count($data->votes)?> رای
                            </a>
                        </li>
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/user.png">
                                <?= $data->getVotedUsersCount()?> شرکت کننده
                            </a>
                        </li>
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/eye.png">
                                <?= $data->seen?> مشاهده
                            </a>
                        </li>
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/label_53866.png">
                                <?= count($data->bookmarks)?> ذخیره سازی
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <hr class="">
            </div>
        </div>
    </div>
</div>