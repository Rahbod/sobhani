<?
/* @var $model Lists */
/* @var $items ListItemRel[] */
$itemImagePath = Yii::getPathOfAlias('webroot').'/uploads/items/thumbs/200x200/';
$itemImageUrl = Yii::app()->getBaseUrl(true).'/uploads/items/thumbs/200x200/';
$i = 1;
$voted = Votes::checkVote($model->id);
$voteAvg = Votes::VoteAverages($model->id);
foreach($items as $item):
    $hash = base64_encode(json_encode(['list_id' => $item->list_id, 'item_id' => $item->item_id]));
    ?>
    <div class="form-row">
        <?php if($item->image && is_file($itemImagePath.$item->image)):?>
            <div class="list-view-image">
                <img src="<?= $itemImageUrl.$item->image ?>" alt="<?= $item->item->title ?>" >
            </div>
        <?php endif;?>
        <div>
            <span class="num <?php
            if($i==1) echo 'gold';
            if($i==2) echo 'silver';
            if($i==3) echo 'bronze';
            ?>"><?= $i?></span>
            <h4><?= $item->item->title ?>
            <?php
            if(!$voted)
            echo CHtml::ajaxLink('<i class="icon-check-sign"></i>',array('/lists/public/json'),array(
                'type' => 'POST',
                'dataType' => 'JSON',
                'data' => array('method' => 'vote','hash'=>$hash),
                'beforeSend' => 'js: function(data){
                    $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                }',
                'success' => 'js: function(data){
                    if(data.status){
                        
                        $(".vote-trigger").addClass("active");
                        $(".view-alert").addClass("alert-success").find("span").text(data.message);
                    }
                    else
                        $(".view-alert").addClass("alert-warning").find("span").text(data.message);                     
                    $(".view-alert").removeClass("hidden");
                }'),array('class' => 'vote-trigger pull-left'));
            else
                echo '<span class="vote-trigger active pull-left">%'.$voteAvg[$item->item_id].'</span>';
            ?></h4>
            <div class="text"><?= $item->description ?></div>
        </div>
        <?php
        if(!Yii::app()->user->isGuest)
            $this->widget('comments.widgets.ECommentsListWidget', array(
                'model' => $item,
            ));
        ?>
    </div>
    <?php $i++; ?>
<?php endforeach;?>