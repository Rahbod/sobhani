<?
/* @var $model Lists */
/* @var $items ListItemRel[] */
$itemImagePath = Yii::getPathOfAlias('webroot').'/uploads/items/thumbs/200x200/';
$itemImageUrl = Yii::app()->getBaseUrl(true).'/uploads/items/thumbs/200x200/';
$i = 1;
$voteAvg = Votes::VoteAverages($model->id);
Yii::app()->clientScript->registerScript('target', '
    var target = null;
    $(".vote-trigger").click(function(){
        target = $(this);
        $(this).addClass("loading");
    });
');
foreach($items as $item):
    $voted = Votes::checkVote($model->id, $item->item_id);
    $hash = base64_encode(json_encode(['list_id' => $item->list_id, 'item_id' => $item->item_id]));
    ?>
    <div class="form-row">
        <div class="item-title <?php if($item->image && is_file($itemImagePath.$item->image)) echo 'with-pic' ?>">
            <span class="num <?php
            if($i==1) echo 'gold';
            if($i==2) echo 'silver';
            if($i==3) echo 'bronze';
            ?>"><?= $i?></span>
            <h4><?= $item->item->title ?>
            <?php
            if(!$voted) {
                echo CHtml::ajaxLink('<i class="icon-check-sign"></i>', array('/lists/public/json'), array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'data' => array('method' => 'vote', 'hash' => $hash),
                    'beforeSend' => 'js: function(data){
                    $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                    if(target.hasClass("gray"))
                        return false;
                }',
                'success' => 'js: function(data){
                    target.removeClass("loading");
                    if(data.status){
                        target.parent().find(".vote-trigger.active.pull-left").text("%"+data.newAvg);
                        target.addClass("gray");
                        $(".view-alert").addClass("alert-success").find("span").text(data.message);
                    }
                    else
                        $(".view-alert").addClass("alert-warning").find("span").text(data.message);                     
                    $(".view-alert").removeClass("hidden");
                }'), array('class' => 'vote-trigger pull-left'));
                echo '<span class="vote-trigger active pull-left" style="margin-left: 15px;line-height: 46px;">%' . $voteAvg[$item->item_id] . '</span>';
            } else
                echo '<span class="vote-trigger active pull-left">%'.$voteAvg[$item->item_id].'</span>';
            ?></h4>
        </div>
        <?php if($item->image && is_file($itemImagePath.$item->image)):?>
            <div class="list-view-image">
                <img src="<?= $itemImageUrl.$item->image ?>" alt="<?= $item->item->title ?>" >
            </div>
        <?php endif;?>
        <div class="text"><?= $item->description ?></div>
        <?php
        //if(!Yii::app()->user->isGuest)
            $this->widget('comments.widgets.ECommentsListWidget', array(
                'model' => $item,
            ));
        ?>
    </div>
    <?php $i++; ?>
<?php endforeach;?>