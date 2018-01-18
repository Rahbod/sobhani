<?php
/* @var $this ListsPublicController */
/* @var $model Lists */
$this->breadcrumbs = array(
	$model->category->title => array('/lists/category/'.$model->category_id),
	$model->title
);

$favorite = UserBookmarks::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'list_id' => $model->id])?true:false;
?>
<div class="alert alert-success view-alert hidden">
	<p>
		<span></span>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</p>
</div>
<div class="list-item-view">
	<h2><?= $model->title ?></h2>
	<?php if($model->user_type == 'user'):?>
	<div class="user-image">
		<img src="<?= $model->user->userDetails->getAvatar() ?>">
		<small><?= $model->user->userDetails?$model->user->userDetails->getShowName():$model->user->email ?></small>
	</div>
	<?php endif; ?>
	<p><?= $model->description ?></p>

	<h3>
		ده برترین
		<?php
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
		),array('class' => 'favorite pull-left'.($favorite?' active':'')));
		?>
	</h3>
</div>
