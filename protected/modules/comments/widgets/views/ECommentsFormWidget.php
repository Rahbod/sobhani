<div class="center-block">
    <?php

    /**
     * @var $newComment Comment
     * @var $form CActiveForm
     */

    //if(Yii::app()->user->type == 'admin' || $this->model->list->user_id == Yii::app()->user->getId()){
        echo CHtml::link(Yii::t($this->_config['translationCategory'] ,'Add Your Comment') ,'#form-' . $newComment->owner_id ,array(
            'class' => 'collapsed add-comment btn btn-outline-info px-5',
            'data-toggle' => 'collapse',
            'style' => "margin-top: 15px;"
        ));
    //}
    ?>
</div>


<div class="comments--formContainer collapse" id="form-<?= $newComment->owner_id ?>">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>$this->id,
        'htmlOptions' => [
            'class'=>'comments--form',
        ],
    )); ?>
        <?php
        echo $form->hiddenField($newComment, 'owner_name');
        echo $form->hiddenField($newComment, 'owner_id');
        echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
        ?>
        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="d-flex">
                    <img class="comments--form__userAvatar" src="<?php echo Yii::app()->theme->baseUrl?>/media/images/public/user_avatar.png">
                    <?php echo $form->textArea($newComment, 'comment_text', array(
                        'cols' => 30,
                        'rows' => 1,
                        'class'=>'form-control comments--form__input',
                        'placeholder' => 'ثبت نظر...'
                    )); ?>
                    <?php echo $form->error($newComment, 'comment_text'); ?>
                </div>
            </div>
            <div class="form-group col-md-12 text-right m-0">
                <?php echo CHtml::button(Yii::t($this->_config['translationCategory'],'Add '.$this->_config['moduleObjectName']), array(
                    'data-url'=>Yii::app()->createAbsoluteUrl($this->postCommentAction),
                    'class'=> 'btn btn-outline-info px-5 comment-submit-form-btn',
                    'style'=> 'margin-right: 55px;',
                )); ?>
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div>




<!--<div class="comment-form collapse" id="form---><?//= $newComment->owner_id ?><!--">-->
<?php //$form=$this->beginWidget('CActiveForm', array(
//        'id'=>$this->id,
//)); ?>
<!--    --><?php //
//        echo $form->hiddenField($newComment, 'owner_name');
//        echo $form->hiddenField($newComment, 'owner_id');
//        echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
//    ?>
<!--    <div class="inputs-container">-->
<!--        <div class="hidden">-->
<!--            --><?php //if(!$newComment->user_name): ?>
<!--                --><?//= $form->textField($newComment,'user_name', array('class'=>'text-field','placeholder' => $newComment->getAttributeLabel('user_name'))); ?>
<!--            --><?php //else: ?>
<!--                --><?//= CHtml::textField('',$newComment->user_name, array('class'=>'text-field','disabled'=>'disabled')); ?>
<!--            --><?php
//            endif;
//            ?>
<!--            --><?//= $form->error($newComment,'user_name'); ?>
<!--        </div>-->
<!--        <div class="hidden">-->
<!--            --><?php //if(!$newComment->user_email): ?>
<!--                --><?//= $form->textField($newComment,'user_email', array('class'=>'text-field','placeholder' => $newComment->getAttributeLabel('user_email'))); ?>
<!--            --><?php //else: ?>
<!--                --><?//= CHtml::textField('',$newComment->user_email, array('class'=>'text-field','disabled'=>'disabled')); ?>
<!--                --><?php
//            endif;
//            ?>
<!--            --><?php //echo $form->error($newComment,'user_email'); ?>
<!--        </div>-->
<!--        <div>-->
<!--            --><?php //echo $form->textArea($newComment, 'comment_text', array('cols' => 60, 'rows' => 5,'class'=>'text-field','placeholder' => 'نظر خود را بنویسید ...')); ?>
<!--            --><?php //echo $form->error($newComment, 'comment_text'); ?>
<!--        </div>-->
<!--        --><?php //if($this->useCaptcha === true && extension_loaded('gd')): ?>
<!--            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
<!--                <div>-->
<!--                    <div class="captcha-box">-->
<!--                        --><?php //$this->widget('CCaptcha', array(
//                            'captchaAction'=>CommentsModule::CAPTCHA_ACTION_ROUTE,
//                            'showRefreshButton' => true
//                        )); ?>
<!--                    </div>-->
<!--                    --><?php //echo $form->textField($newComment,'verifyCode',array('class' => 'form-control','placeholder' => $newComment->getAttributeLabel('verifyCode'))); ?>
<!---->
<!--                </div>-->
<!--                <div class="hint">-->
<!--                    --><?php //echo Yii::t($this->_config['translationCategory'], 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.');?>
<!--                </div>-->
<!--                --><?php //echo $form->error($newComment, 'verifyCode'); ?>
<!--            </div>-->
<!--        --><?php //endif; ?>
<!--        <div class="button-block">-->
<!--            --><?php //echo CHtml::button(Yii::t($this->_config['translationCategory'],'Add '.$this->_config['moduleObjectName']),
//                array('data-url'=>Yii::app()->createAbsoluteUrl($this->postCommentAction),'class'=> 'btn btn-blue pull-left comment-submit-form-btn'));
//            ?>
<!--        </div>-->
<!--    </div>-->
<?php //$this->endWidget(); ?>
<!--</div>-->
