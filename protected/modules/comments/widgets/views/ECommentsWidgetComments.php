<?php if(count($comments) > 0):?>
    <div class="comments--list">
        <?php foreach($comments as $key => $comment): ?>
            <div class="comments--item clearfix" id="comment-<?php echo $comment->comment_id; ?>">
                <h6 class=""><?php echo CHtml::encode($comment->comment_text);?></h6>
                <span class="text-muted"><?php echo $comment->userName;?></span>
                <span class="text-muted"><?php echo JalaliDate::differenceTime($comment->create_time);?></span>
<!--                <a href="void:;" title="like" class="like">-->
<!--                    54-->
<!--                    <i class="icon-heart"></i>-->
<!--                </a>-->
                <?php if($this->adminMode === true):
                    if(Yii::app()->user->type == 'admin' || $this->model->list->user_id == Yii::app()->user->getId()):
                        ?>
                        <div class="admin-panel">
                            <?php if($this->_config['premoderate'] === true && ($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROWED)) {
                                echo CHtml::link(Yii::t($this->_config['translationCategory'], 'approve'), Yii::app()->urlManager->createUrl(
                                    CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                                ), array('class'=>'text-success approve'));
                            }?>
                            <?php echo CHtml::link(Yii::t($this->_config['translationCategory'], 'delete'), Yii::app()->urlManager->createUrl(
                                CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                            ), array('class'=>'text-danger delete'));?>
                        </div>
                    <?php endif;
                endif;
                ?>
                <?php
                if($this->adminMode === true && $this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
                {
                    if(Yii::app()->user->type == 'admin' || $this->model->list->user_id == Yii::app()->user->getId()){
                        echo CHtml::link(Yii::t($this->_config['translationCategory'] ,'Reply') ,'#reply-' . $comment->comment_id ,array(
                            'data-comment-id' => $comment->comment_id ,
                            'class' => 'btn btn-info collapsed add-comment' ,
                            'data-toggle' => 'collapse' ,
                            'data-parent' => '#comment-' . $comment->comment_id
                        ));
                        echo "<div class='comment-form comment-form-outer collapse' id='reply-" . $comment->comment_id . "'>";
                        echo '<div class="loading-container"><div class="overly"></div><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
                        $this->widget('comments.widgets.ECommentsFormWidget' ,array(
                            'model' => $this->model ,
                        ));
                        echo "</div>";
                    }
                }
                ?>
                <?php if(count($comment->childs) > 0 && $this->allowSubcommenting === true) $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));?>
            </div>
        <?php endforeach; ?>
    </div>






<!--    <ul class="comments-list">-->
<!--        --><?php //foreach($comments as $key => $comment):
//            ?>
<!--            <li id="comment---><?php //echo $comment->comment_id; ?><!--">-->
<!--                <i class="icon icon-quote-right" aria-hidden="true"></i>-->
<!--                <div class="comment-text">-->
<!--                    <div class="text">-->
<!--                        <div><p dir="auto">--><?php //echo CHtml::encode($comment->comment_text);?><!--</p></div>-->
<!--                    </div>-->
<!--                    <div class="meta">-->
<!--                        <span class="pull-right">--><?php //echo $comment->userName;?><!--</span>-->
<!--                        <span class="pull-left">--><?php //echo JalaliDate::differenceTime($comment->create_time);?><!--</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                --><?php //if($this->adminMode === true):
//                        if(Yii::app()->user->type == 'admin' || $this->model->list->user_id == Yii::app()->user->getId()):
//                            ?>
<!--                            <div class="admin-panel">-->
<!--                                --><?php //if($this->_config['premoderate'] === true && ($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROWED)) {
//                                    echo CHtml::link(Yii::t($this->_config['translationCategory'], 'approve'), Yii::app()->urlManager->createUrl(
//                                        CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
//                                    ), array('class'=>'text-success approve'));
//                                }?>
<!--                                --><?php //echo CHtml::link(Yii::t($this->_config['translationCategory'], 'delete'), Yii::app()->urlManager->createUrl(
//                                    CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
//                                ), array('class'=>'text-danger delete'));?>
<!--                            </div>-->
<!--                        --><?php //endif;
//                endif;
//                ?>
<!--                --><?php
//                    if($this->adminMode === true && $this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
//                    {
//                        if(Yii::app()->user->type == 'admin' || $this->model->list->user_id == Yii::app()->user->getId()){
//                            echo CHtml::link(Yii::t($this->_config['translationCategory'] ,'Reply') ,'#reply-' . $comment->comment_id ,array(
//                                'data-comment-id' => $comment->comment_id ,
//                                'class' => 'btn btn-info collapsed add-comment' ,
//                                'data-toggle' => 'collapse' ,
//                                'data-parent' => '#comment-' . $comment->comment_id
//                            ));
//                            echo "<div class='comment-form comment-form-outer collapse' id='reply-" . $comment->comment_id . "'>";
//                            echo '<div class="loading-container"><div class="overly"></div><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
//                            $this->widget('comments.widgets.ECommentsFormWidget' ,array(
//                                'model' => $this->model ,
//                            ));
//                            echo "</div>";
//                        }
//                    }
//                ?>
<!--                --><?php //if(count($comment->childs) > 0 && $this->allowSubcommenting === true) $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));?>
<!--            </li>-->
<!--        --><?php
//        endforeach;
//        ?>
<!--    </ul>-->
<?php endif;
?>
<script>
function checkRtl( character ) {
    var RTL = ['ا','ب','پ','ت','س','ج','چ','ح','خ','د','ذ','ر','ز','ژ','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ک','گ','ل','م','ن','و','ه','ی'];
    return RTL.indexOf( character ) > -1;
}

function checkChar( character ) {
    if (character.match(/\s/) || character.match(/[0-9-!@#$%^&()_+|~=`{}\[\]:";\'<>?,.\/]/))
        return true;
    else
        return false;
}
var pTags = $(".comments-list").find("p");
pTags.each(function(){
    var firstChar = $(this).text().trim().substr(1,1);
    var $i=3;
    while(checkChar(firstChar) && $i < $(this).text().trim().length)
    {
        firstChar = $(this).text().trim().substr($i,1);
        console.log(firstChar);
        $i++;
    }
    if( checkRtl(firstChar) ) {
        $(this).removeClass("ltr").addClass("rtl");
    } else {
        $(this).removeClass("rtl").addClass("ltr");
    }
});
</script>

