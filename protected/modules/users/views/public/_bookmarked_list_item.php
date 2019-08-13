<?php
/* @var $this UsersPublicController */
/* @var $data UserBookmarks */

$url = Yii::app()->getBaseUrl(true).'/uploads/lists/thumbs/200x200/';
$list = $data->list;
?>
<div class="col-12 list-item">
    <div class="container-fluid px-0 -opacity">
        <div class="row">
            <div class="col-md-4 px-0 px-md-3 pt-md-3">
                <div class="tab-content__imageContainer">
                    <img class="img-fluid" src="<?= $url . $list->getImage() ?>" alt="<?= $list->title ?>">
                    <div class="tab-content__categoryContainer">
                        <a href="#" class="tab-content__category"><?php echo $list->category->title?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 px-0 px-md-3 pt-md-3">
                <div class="">
                    <a href="<?php $list->getViewUrl()?>" class="-h5 tab-content__title"><?= $list->title ?></a>
                </div>
                <p class="tab-content__publishedDate -fw-400"><?php echo JalaliDate::differenceTime($list->create_date)?></p>
                <div class="reports mb-4">
                    <ul class="list-unstyled p-0 m-0">
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/check.png">
                                <?= count($list->votes)?> رای
                            </a>
                        </li>
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/user.png">
                                <?= $list->getVotedUsersCount()?> شرکت کننده
                            </a>
                        </li>
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/eye.png">
                                <?= $list->seen?> مشاهده
                            </a>
                        </li>
                        <li class="mb-3">
                            <a class="ml-3 -fw-400">
                                <img class="ml-1" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/label_53866.png">
                                <?= count($list->bookmarks)?> ذخیره سازی
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content--buttons">
                    <?php echo CHtml::ajaxLink('حذف از علایق',array('/lists/public/authJson'),array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'data' => array('method' => 'bookmark','hash'=>base64_encode($list->id)),
                        'beforeSend' => 'js: function(data){
                            $(".view-alert").addClass("d-none").removeClass("alert-success alert-warning").find("span").text("");
                        }',
                        'success' => 'js: function(data){
                            article.find(\'.loading-container\').show();
                            if(data.status){
                                article.remove();
                                $(".view-alert").addClass("alert-success").find("span").text(data.message);
                            }
                            else{
                                $(".view-alert").addClass("alert-warning").find("span").text(data.message);
                            }
                            $(".view-alert").removeClass("d-none");
                        }'
                    ),array('class' => 'remove-bookmark btn btn-outline-danger -fw-400')); ?>
                </div>
            </div>
            <div class="col-12">
                <hr class="">
            </div>
        </div>
    </div>
</div>