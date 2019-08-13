<?
/* @var $model Lists */
/* @var $items ListItemRel[] */
$itemImagePath = Yii::getPathOfAlias('webroot').'/uploads/items/thumbs/150x150/';
$itemImageUrl = Yii::app()->getBaseUrl(true).'/uploads/items/thumbs/150x150/';
$i = 1;
$voteAvg = Votes::VoteAverages($model->id);
Yii::app()->clientScript->registerScript('target', '
    var target = null;
    $(".vote-trigger").click(function(){
        target = $(this);
    });
');
arsort($voteAvg, SORT_DESC);
foreach($voteAvg as $itemID => $avg):
    if(!isset($items[$itemID]))
        continue;
    $item = $items[$itemID];
    $voted = Votes::checkVote($model->id, $item->item_id);
    $hash = base64_encode(json_encode(['list_id' => $item->list_id, 'item_id' => $item->item_id]));
    ?>
    <div class="col-md-12 mb-3">
        <div class="container-fluid px-0 -shadow">
            <div class="row">
                <?php if($item->image && is_file($itemImagePath.$item->image)):?>
                    <div class="col-md-4 pl-md-0 text-center PB-3 pb-md-0">
                        <div class="h-100 bg-white pt-md-3 pr-md-3">
                            <img class="listView--section2__image mb-3 mb-md-0" src="<?= $itemImageUrl.$item->image ?>" alt="<?= $item->item->title ?>" title="<?= $item->item->title ?>">
                        </div>
                    </div>
                <?php endif;?>
                <div class="col-md-8 pr-md-0">
                    <div class="group--item p-3 bg-white">
                        <div class="align-items-center">
                            <div class="d-inline-block listView--section2--number">
                                <img class=" pl-2" src="<?= Yii::app()->theme->baseUrl?>/media/images/public/rounded-star.png">
                                <span><?= $i?></span>
                            </div>
                            <h4 class="-h4 listView--section2__title d-inline-block flex-fill"><?= $item->item->title ?></h4>
                            <div class="text-left mt-3 mt-md-0 clearfix position-relative d-flex align-items-center">
                                <div class="flex-fill">
                                    <?php
                                    // vote btn
                                    echo CHtml::ajaxLink('<img src="'.Yii::app()->theme->baseUrl.'/media/images/public/check_2.png">ثبت رای', array('/lists/public/json'), array(
                                        'type' => 'POST',
                                        'dataType' => 'JSON',
                                        'data' => array('method' => 'vote', 'hash' => $hash),
                                        'beforeSend' => 'js: function(data){
                                            if(target.hasClass("loading"))
                                                return false;
                                            target.addClass("loading");
                                            $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                                        }',
                                        'success' => 'js: function(data){
                                            target.removeClass("loading");
                                            if(data.status){
                                                target.parent().find(".vote-trigger.active.pull-left").text("%"+data.newAvg);
                                                // target.toggleClass("gray").data("method", "unvote").find("i").toggleClass("icon-check-sign icon-remove-sign");
                                                target.addClass("hidden");
                                                target.parent().find(".un-vote-btn").removeClass("hidden");
                                                $(".view-alert").addClass("alert-success").find("span").text(data.message);
                                            }
                                            else
                                                $(".view-alert").addClass("alert-warning").find("span").text(data.message);
                                            $(".view-alert").removeClass("hidden");
                                        }'
                                    ), array(
                                        'class' => 'btn btn-outline-info listView--section2__vote float-left '.($voted?" d-none":"")
                                    ));

                                    // un vote btn
                                    echo CHtml::ajaxLink('<i class="icon-remove-sign"></i>', array('/lists/public/json'), array(
                                        'type' => 'POST',
                                        'dataType' => 'JSON',
                                        'data' => array('method' => 'unvote', 'hash' => $hash),
                                        'beforeSend' => 'js: function(data){
                                            if(target.hasClass("loading"))
                                                return false;
                                            target.addClass("loading");
                                            $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                                        }',
                                        'success' => 'js: function(data){
                                            target.removeClass("loading");
                                            if(data.status){
                                                target.parent().find(".vote-trigger.active.pull-left").text("%"+data.newAvg);
                    //                                target.toggleClass("gray").data("method", "vote").find("i").toggleClass("icon-check-sign icon-remove-sign");
                                                target.addClass("hidden");
                                                target.parent().find(".vote-btn").removeClass("hidden");
                                                $(".view-alert").addClass("alert-success").find("span").text(data.message);
                                            }
                                            else
                                                $(".view-alert").addClass("alert-warning").find("span").text(data.message);
                                            $(".view-alert").removeClass("hidden");
                                        }'
                                    ), array(
                                        'class' => 'un-vote-btn vote-trigger pull-left gray'.(!$voted?" d-none":"")
                                    ));
                                    ?>
                                </div>
                                <!--<div class="c100 p50 big float-left ml-3">-->
                                <!--<span>50%</span>-->
                                <!--<div class="slice">-->
                                <!--<div class="bar"></div>-->
                                <!--<div class="fill"></div>-->
                                <!--</div>-->
                                <!--</div>-->

                                <div class="progress yellow float-left ml-3">
                                    <span class="progress-left">
                                        <span class="progress-bar"></span>
                                    </span>
                                        <span class="progress-right">
                                        <span class="progress-bar"></span>
                                    </span>
                                    <div class="progress-value"><?= $voted?$avg:$voteAvg[$item->item_id]?>%</div>
                                </div>

                            </div>
                        </div>
                        <div class="comments mt-0 mt-md-3 pt-3 pb-0">
                            <p><?= $item->description ?></p>
                            <!--Items Related Links-->
                            <?php if($item->links):?>
                                <div class="referenceSites mb-4">
                                    <ul class="list-unstyled p-0 m-0">
                                        <?php foreach ($item->links as $link): ?>
                                            <li class="">
                                                <a class="referenceSites--link" href="<?= $link->url ?>" target="_blank" rel="nofollow"><?= $link->title ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif;?>

                            <!--Comments-->
                            <?php $this->widget('comments.widgets.ECommentsListWidget', array('model' => $item)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>























    <!-- <div class="form-row">
        <div class="item-title <?php if($item->image && is_file($itemImagePath.$item->image)) echo 'with-pic' ?>" style="margin-bottom: 10px; display: block">
            <span style="margin-top: 5px" class="num <?php
            if($i==1) echo 'gold';
            if($i==2) echo 'silver';
            if($i==3) echo 'bronze';
            ?>"><?= $i?></span>
            <h4>
                <?php
                // vote btn
                echo CHtml::ajaxLink('<i class="icon-check-sign"></i>', array('/lists/public/json'), array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'data' => array('method' => 'vote', 'hash' => $hash),
                    'beforeSend' => 'js: function(data){
                        if(target.hasClass("loading"))
                            return false;
                        target.addClass("loading");
                        $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                    }',
                    'success' => 'js: function(data){
                        target.removeClass("loading");
                        if(data.status){
                            target.parent().find(".vote-trigger.active.pull-left").text("%"+data.newAvg);
//                                target.toggleClass("gray").data("method", "unvote").find("i").toggleClass("icon-check-sign icon-remove-sign");
                            target.addClass("hidden");
                            target.parent().find(".un-vote-btn").removeClass("hidden");
                            $(".view-alert").addClass("alert-success").find("span").text(data.message);
                        }
                        else
                            $(".view-alert").addClass("alert-warning").find("span").text(data.message);
                        $(".view-alert").removeClass("hidden");
                    }'), array('class' => 'vote-btn vote-trigger pull-left'.($voted?" hidden":"")));
                // un vote btn
                echo CHtml::ajaxLink('<i class="icon-remove-sign"></i>', array('/lists/public/json'), array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'data' => array('method' => 'unvote', 'hash' => $hash),
                    'beforeSend' => 'js: function(data){
                        if(target.hasClass("loading"))
                            return false;
                        target.addClass("loading");
                        $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                    }',
                    'success' => 'js: function(data){
                        target.removeClass("loading");
                        if(data.status){
                            target.parent().find(".vote-trigger.active.pull-left").text("%"+data.newAvg);
//                                target.toggleClass("gray").data("method", "vote").find("i").toggleClass("icon-check-sign icon-remove-sign");
                            target.addClass("hidden");
                            target.parent().find(".vote-btn").removeClass("hidden");
                            $(".view-alert").addClass("alert-success").find("span").text(data.message);
                        }
                        else
                            $(".view-alert").addClass("alert-warning").find("span").text(data.message);
                        $(".view-alert").removeClass("hidden");
                    }'), array('class' => 'un-vote-btn vote-trigger pull-left gray'.(!$voted?" hidden":"")));
                echo '<span class="vote-trigger active pull-left" style="margin-left: 10px;line-height: 46px;">%' . ($voted?$avg:$voteAvg[$item->item_id]) . '</span>';
                ?>
                <div class="text-right"><?= $item->item->title ?></div>
            </h4>
        </div>
        <?php if($item->image && is_file($itemImagePath.$item->image)):?>
            <div class="list-view-image">
                <img src="<?= $itemImageUrl.$item->image ?>" alt="<?= $item->item->title ?>" title="<?= $item->item->title ?>">
            </div>
        <?php endif;?>
        <div class="text">
            <div class="pre-line">
                <?= $item->description ?>
            </div>

            <?php if($item->links):?>
                <div class="list-view-links">
                    <b>لینک های مرتبط</b>
                    <ul class="list-unstyled">
                        <?php foreach ($item->links as $link): ?>
                            <li><a href="<?= $link->url ?>" target="_blank" rel="nofollow"><i class="icon icon-link"></i><?= $link->title ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif;?>
        </div>
        <?php //$this->widget('comments.widgets.ECommentsListWidget', array('model' => $item)); ?>
    </div> -->
    <?php $i++; ?>
<?php endforeach;?>