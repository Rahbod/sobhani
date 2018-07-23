<?php
/* @var $this ListsPublicController */
/* @var $model Lists */
/* @var $items ListItemRel[] */
$this->breadcrumbs = array(
    'همه لیست ها' => array('/lists'),
	$model->category->title => array('/lists/category/'.$model->category_id.'/'.str_replace(' ', '-', $model->category->title))
);
$favorite = !Yii::app()->user->isGuest?(UserBookmarks::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'list_id' => $model->id])?true:false):false;
$this->pageTitle = $model->title;
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
<div class="alert alert-success view-alert hidden">
	<p>
		<span></span>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</p>
</div>
<div class="list-item-view">
    <div class="image-box">
        <img src="<?= Yii::app()->baseUrl.'/uploads/lists/thumbs/200x200/'.$model->getImage()?>" class="image" alt="<?= $model->title ?>" title="<?= $model->title ?>">
        <h2><?= $model->title ?></h2>
        <?php if($model->user_type == 'user'):?>
        <div class="user-image">
            <img src="<?= $model->user->userDetails->getAvatar() ?>" alt="<?= $model->user->userDetails?$model->user->userDetails->getShowName():$model->user->email ?>" title="<?= $model->user->userDetails?$model->user->userDetails->getShowName():$model->user->email ?>">
            <small><?= $model->user->userDetails ? CHtml::link($model->user->userDetails->getShowName(),array('/users/public/viewProfile/'.$model->user->id.'/'.str_replace(' ', '-', $model->user->userDetails->getShowName()))):$model->user->email ?></small>
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
        <div>
		    <?php $this->renderPartial('_items',compact('items', 'model')); ?>
        </div>
        <?php if(!Yii::app()->user->isGuest):?>
            <button type="button" class="btn btn-blue add-new-item" data-toggle="collapse" data-target="#add-new-item-form"><i class="glyphicon glyphicon-plus"></i>افزودن گزینه جدید</button>
            <div class="collapse" id="add-new-item-form">
                <?= CHtml::beginForm('', 'post', array('class' => 'add-list-form'));?>
                    <div class="form-row">
                        <div class="container-fluid">
                            <span class="num"><?= count($items) + 1?></span>
                            <div class="input-container">
                                <?= CHtml::textField('title', null, array('class' => 'transparent-input item-title', 'placeholder' => 'عنوان'));?>
                            </div>
                        </div>
                        <div class="fix-overflow">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <?= CHtml::textArea("description", null, array('class' => 'form-control', 'placeholder' => "نظر...")) ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                                    'id' => "uploaderImage",
                                    'name' => "Lists[items][0][image]",
                                    'maxFiles' => 1,
                                    'maxFileSize' => 0.5, //MB
                                    'url' => $this->createUrl('uploadItem'),
                                    'deleteUrl' => $this->createUrl('deleteUploadItem'),
                                    'acceptedFiles' => '.jpg, .jpeg, .png',
                                    'containerClass' => 'uploader',
                                    'serverFiles' => [],
                                    'onSuccess' => "
                                        var responseObj = JSON.parse(res);
                                        if(responseObj.status){
                                            {serverName} = responseObj.fileName;
                                            $(\".uploader-message\").html(\"\");
                                        }
                                        else{
                                            $(\".uploader-message\").html(responseObj.message);
                                            this.removeFile(file);
                                        }
                                    ",
                                )); ?>
                                <div class="uploader-message error"></div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <?= CHtml::submitButton('ثبت' ,array('class' => 'btn btn-blue', 'name' => 'publish')); ?>
                        </div>
                    </div>
                <?= CHtml::endForm();?>
            </div>
        <?php else:?>
            <a class="btn btn-blue add-new-item" data-toggle="modal" href="#login-modal"><i class="glyphicon glyphicon-plus"></i>افزودن گزینه جدید</a>
        <?php endif;?>
	</div>
</div>