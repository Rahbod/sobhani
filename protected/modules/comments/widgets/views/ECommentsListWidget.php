<div class="comment-widget <?= Yii::app()->language != 'fa_ir' ? 'en' : '' ?>" id="<?php echo $this->id ?>">
    <?php
    echo '<div class="comment-form-outer" id="comment-form" >';
    if ($this->showPopupForm === true) {
        if ($this->registeredOnly === false || Yii::app()->user->isGuest === false) {
            echo '<div class="loading-container"><div class="overly"></div><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
            echo "<div class='comment-form' id=\"addCommentDialog-{$this->id}\">";
            $this->widget('comments.widgets.ECommentsFormWidget', array(
                'model' => $this->model,
            ));
            echo "</div>";
        }
    }
    if ($this->registeredOnly === true && Yii::app()->user->isGuest === true) {
        // @todo change login and signup links
        Yii::app()->user->returnUrl = Yii::app()->request->url;
        echo '&nbsp;<a href=" #login-modal" class="btn btn-outline-info px-5" style="margin-top: 15px;" data-toggle="modal">' . Yii::t($this->_config['translationCategory'], 'Add Your Comment') . '</a>';
    }
    echo "</div>";
    echo '<div class="comments-list-outer mt-4">';
    $this->render('ECommentsWidgetComments', array('newComment' => $newComment, 'comments' => $comments));
    echo '</div>';
    ?>
</div>
