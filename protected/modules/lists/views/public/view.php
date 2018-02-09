<?php
/* @var $this ListsPublicController */
/* @var $model Lists */
$this->breadcrumbs = array(
	$model->category->title => array('/lists/category/'.$model->category_id),
);
$favorite = UserBookmarks::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'list_id' => $model->id])?true:false;
$this->pageTitle = $model->title;
?>
<div class="alert alert-success view-alert hidden">
	<p>
		<span></span>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</p>
</div>
<div class="list-item-view">
    <div class="image-box">
        <img src="<?= Yii::app()->baseUrl.'/uploads/lists/thumbs/200x200/'.$model->getImage()?>" class="image">
        <h2><?= $model->title ?></h2>
        <?php if($model->user_type == 'user'):?>
        <div class="user-image">
            <img src="<?= $model->user->userDetails->getAvatar() ?>">
            <small><?= $model->user->userDetails?$model->user->userDetails->getShowName():$model->user->email ?></small>
        </div>
        <?php endif; ?>
        <div class="text"><?= $model->description ?></div>
    </div>

	<h3>
		ده بهترین
        <a target="_blank" href="https://telegram.me/share/url?url=<?= Yii::app()->createAbsoluteUrl('/lists/'.$model->id.'/'.str_replace(' ', '-', $model->title))?>" class="telegram-link gray pull-left" title="اشتراک گذاری در تلگرام"><i></i></a>
		<?php
		if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):
			echo CHtml::ajaxLink('<i class="star-icon"></i>',array('/lists/public/authJson'),array(
				'type' => 'POST',
				'dataType' => 'JSON',
				'data' => array('method' => 'bookmark','hash'=>base64_encode($model->id)),
				'beforeSend' => 'js: function(data){
					$(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
				}',
				'success' => 'js: function(data){
					if(data.status){
						if($(".favorite").hasClass("active"))
							$(".favorite").removeClass("active");
						else
							$(".favorite").addClass("active");
						$(".view-alert").addClass("alert-success").find("span").text(data.message);
					}
					else{
						$(".view-alert").addClass("alert-warning").find("span").text(data.message); 
					}   
					$(".view-alert").removeClass("hidden");
				}'
			),array('title' => 'افزودن به علاقه مندی ها', 'class' => 'favorite pull-left'.($favorite?' active':'')));
		else:
			echo CHtml::link('<i class="star-icon"></i>','#',
				array('class' => 'favorite pull-left', 'data-toggle' => 'modal', 'data-target' => '#login-modal', 'title' => 'افزودن به علاقه مندی ها'));
		endif;
		?>
	</h3>
	<div class="add-list-form items-list">
		<?php
		$items = $model->itemRel;
		$this->renderPartial('_items',compact('items', 'model'))
		?>
	</div>
</div>