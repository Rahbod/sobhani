<?php
/**
 * @var $this Controller
 * @var $cs CClientScript
 * @var $baseUrl string
 * @var $slider Lists[]
 */
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
$cs->registerCssFile($baseUrl.'/css/owl.theme.default.min.css');
$cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js');
$listPath=Yii::getPathOfAlias('webroot').'/uploads/lists/thumbs/200x200/';
$listUrl=Yii::app()->getBaseUrl(true).'/uploads/lists/thumbs/200x200/';

$listItemPath=Yii::getPathOfAlias('webroot').'/uploads/items/thumbs/200x200/';
$listItemUrl=Yii::app()->getBaseUrl(true).'/uploads/items/thumbs/200x200/';
?>
<div class="slider">
    <h1><?= Controller::parseNumbers(number_format($count)) ?> ده فهرست برتر برای همه چیز تحت (و از جمله) خورشید است.</h1>
    <div class="is-carousel" data-items="7" data-item-selector="thumbnail-container" data-margin="10" data-dots="1" data-nav="0" data-mouse-drag="1" data-responsive='{"1920":{"items":"7"},"1200":{"items":"6"},"992":{"items":"5"},"768":{"items":"3"},"480":{"items":"2"},"0":{"items":"1"}}'>
        <?php
        foreach ($slider as $item):
        ?>
        <div class="thumbnail-container">
            <div class="thumbnail">
                <a href="<?= $this->createUrl('/lists/'.$item->id.'/'.str_replace(' ', '-', $item->title)) ?>">
                    <img src="<?= $listUrl.$item->image ?>">
                    <div class="overlay">
                        <h3><?= $item->title ?></h3>
                    </div>
                </a>
            </div>
        </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="box-search">
        <form>
            <div class="input-group">
                <input id="search" type="text" class="form-control" name="search" maxlength="100" placeholder="اشتیاق شما چیست؟">
                <span class="input-group-addon"><i class="glyphicon"></i></span>
            </div>
        </form>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 left-side">
            <div class="context">
                <?php foreach($this->getLatestLists(1) as $list):?>
                    <div class="newlist">
                        <div class="multiimage">
                            <?php
                            $itemRel = $list->itemRel;
                            ?>
                            <?php
                            $i = 0;
                            $item = $itemRel[0];
                            while($i<3 || $item == null):
                                if($item->image && is_file($listItemPath.$item->image)):
                                ?>
                                    <img src="<?= $listItemUrl.$item->image ?>">
                                <?php
                                endif;
                                $i++;
                                $item = isset($itemRel[$i])?$itemRel[$i]:null;
                            endwhile;
                            ?>
                        </div>
                        <i>لیست جدید</i>
                        <strong>
                            <a href="<?=$this->createUrl('/lists/'.$list->id.'/'.str_replace(' ', '-', $list->title))?>"><?= $list->title ?></a>
                        </strong>
                        <ol type="1">
                            <li><?= $list->itemRel[0]->item->title ?></li>
                            <li><?= $list->itemRel[1]->item->title ?></li>
                            <li><?= $list->itemRel[2]->item->title ?></li>
                        </ol>
                        <b class="member list-item-view">
                            <?php if($list->user_type == 'user'):?>
                                <div class="user-image">
                                    <a href="<?= Yii::app()->createUrl('/users/public/viewProfile/'.$list->user->id.'/'.str_replace(' ', '-', $list->user->userDetails->getShowName()))?>">
                                        <img class="asrc" src="<?= $list->user->userDetails->getAvatar() ?>">
                                        <small><?= $list->user->userDetails?$list->user->userDetails->getShowName():$list->user->email ?></small>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </b>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- <div class="events">
                <h3>در حال رخ دادن</h3>
                <table id="feed" itemscope="5">
                    <tbody>
                    <tr feedid="36974454" style="display: table-row; opacity: 1;">
                        <td><img src="image/51XZ2KNKZWL._SL160_.jpg"></td>
                        <td> رای دادن به <b>هریما</b>در لیستی از<a>قویترین مبارز</a></td>
                    </tr>
                    <tr feedid="36974455" style="display: table-row; opacity: 1;">
                        <td><i class="g"></i></td>
                        <td> نظر جدید در مورد  <b> بهمن</b> در فهرست <a> بهترین برندهای سیگار </a>
                            <br>&quot من بهمن دوودووال را دوست دارم چون کوچک است.</td>
                    </tr>
                    <tr feedid="36974456" style="display: table-row; opacity: 1;">
                        <td><img src="image/702.jpg"></td>
                        <td> رای دادن به <b>گورو ناناک</b>در فهرست <a href="#">بزرگترین افراد تمام وقت</a></td>
                    </tr>
                    <tr feedid="36974457" style="display: table-row; opacity: 1;">
                        <td><img src="image/994.jpg"></td>
                        <td>  رای دادن به <b>لورنس</b>در لیست <a href="#">بهترین رقصنده های هندی</a></td>
                    </tr>
                    <tr feedid="36974458" style="display: table-row; opacity: 1;">
                        <td><i class="g"></i></td>
                        <td>  رای دادن به <b> اش</b> در لیستی از <a href="#">ده شخصیت خنده دار محبوب</a></td>
                    </tr>
                    </tbody>
                </table>
            </div> -->
            <div class="specials">
                <h3>لیست های ویژه</h3>
                <?php foreach($this->getSpecialLists(6) as $list):?>
                    <div class="feature-item">
                        <img src="<?= $listUrl.$list->image ?>">
                        <p>
                            <b><a href="<?= $list->getViewUrl() ?>"><?= $list->title ?></a></b>
                            <?php
                            echo mb_substr(strip_tags($list->description),0,100);
                            ?>
                        </p>
                    </div>
                <?php endforeach;?>

            </div>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right-side">
            <?php $this->renderPartial('//partial-views/_right_col');?>
            <div class="tren">
                <h4>ده فهرست برتر</h4>
                <?php foreach($this->getTopLists() as $item): ?>
                    <div class="trending">
                        <img src="<?= $listUrl.$item->image ?>">
                        <a href="<?=$item->getViewUrl() ?>"><?= $item->title ?></a>
                        <br>
                        4596 تعامل اخیر
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>