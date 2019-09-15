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

Yii::app()->getClientScript()->registerCssFile(Yii::app()->theme->baseUrl.'/css/jQuery-plugin-progressbar.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jQuery-plugin-progressbar.js', CClientScript::POS_END);
Yii::app()->getClientScript()->registerScript('loading', '$(".progress-bar2").loading();');
?>
<section class="listView section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-0">
                <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
                <div class="card">
                    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
//                        'homeLink' => '<li class="breadcrumb-item">'.CHtml::link(Yii::app()->name, Yii::app()->homeUrl).'</li>',
                        'homeLink' => false,
                        'htmlOptions'=>array('class'=>'breadcrumb'),
                        'tagName' => 'ul',
                        'activeLinkTemplate' => '<li class="breadcrumb-item"><a href="{url}">{label}</a></li>',
                        'inactiveLinkTemplate' => '<li class="breadcrumb-item"><span>{label}</span></li>',
                        'separator' => ''
                    )); ?>
                    <div class="card-header">
                        <h5 class="-h5 mb-3 listView--rightBox -title"><?= $model->title ?></h5>
                        <?php if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):
                            echo CHtml::ajaxLink('<i class="far fa-bookmark bookmark-link-icon"></i>',array('/lists/public/authJson'),array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'data' => array('method' => 'bookmark','hash'=>base64_encode($model->id)),
                                'beforeSend' => 'js: function(data){
                                    $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                                }',
                                'success' => 'js: function(data){
                                    if(data.status){
                                        if($(".bookmark-link").hasClass("active")){
                                            $(".bookmark-link").removeClass("active");
                                            $(".bookmark-link .fa-bookmark").removeClass("fas").addClass("far");
                                        }else{
                                            $(".bookmark-link").addClass("active");
                                            $(".bookmark-link .fa-bookmark").addClass("fas").removeClass("far");
                                        }
                                        $(".view-alert").addClass("alert-success").find("span").text(data.message);
                                    }
                                    else{
                                        $(".view-alert").addClass("alert-warning").find("span").text(data.message);
                                    }
                                    $(".view-alert").removeClass("hidden");
                                }'
                            ),array(
                                'title' => 'افزودن به علاقه مندی ها',
                                'class' => 'cardHeader__leftImage bookmark-link'.($favorite?' active':''),
                            ));
                        else:
                            echo CHtml::link('<i class="far fa-bookmark bookmark-link-icon"></i>','#', array(
                                'class' => 'cardHeader__leftImage',
                                'data-toggle' => 'modal',
                                'data-target' => '#login-modal',
                                'title' => 'افزودن به علاقه مندی ها',
                            ));
                        endif; ?>
                    </div>
                    <img class="card-img-bottom" src="<?= Yii::app()->baseUrl.'/uploads/lists/'.$model->getImage()?>" alt="<?= $model->title ?>" title="<?= $model->title ?>">
                    <div class="card-body">
                        <?php if($model->user):?>
                            <a href="<?php echo $this->createUrl('/users/public/viewProfile/'.$model->user_id.'/'.urlencode($model->user->userDetails->getShowName()))?>" class="d-flex align-items-center mb-4">
                                <img  width="51" height="51" class="ml-3" src="<?= $model->user->userDetails->getAvatar()?>" alt="">
                                <div class="flex-fill">
                                    <p class="pb-1 listView--rightBox -subTitle"><?= $model->user->userDetails->getShowName()?></p>
                                    <p class="m-0 listView--rightBox -listNumber"><?php echo count($model->user->lists)?> لیست</p>
                                </div>
                            </a>
                        <?php endif;?>
                        <p class="card-text mb-0 listView--rightBox -description"><?= $model->description ?></p>

                    </div>
                    <div class="card-footer mb-3">
                        <span class="ml-2 listView--rightBox -share">اشتراک گذاری :</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $model->getViewUrl(true) ?>" target="_blank"><img src="<?= Yii::app()->theme->baseUrl?>/media/images/public/facebook.png" alt="facebook"></a>
                        <a href="http://twitter.com/share?url=<?= $model->getViewUrl(true) ?>"><img src="<?= Yii::app()->theme->baseUrl?>/media/images/public/twitter.png" alt="twitter"></a>
                        <a href="https://telegram.me/share/url?url=<?= $model->getViewUrl(true) ?>"><img src="<?= Yii::app()->theme->baseUrl?>/media/images/public/telegram.png" alt="telegram"></a>
                    </div>
                </div>
                <div class="listView--section2 d-flex mb-3 pb-3">
                    <div class="row">
                        <?php $this->renderPartial('_items',compact('items', 'model')); ?>
                    </div>
                </div>
            </div>

            <?php $this->renderPartial('_view_left_column',['model' => $model, 'showOnMobile' => false]); ?>
        </div>
        <div class="row">
            <div class="col-md-8 order-4 order-md-4">
                <?php if(!Yii::app()->user->isGuest):?>
                    <button type="button" class="btn btn-info px-5 add-new-item" data-toggle="collapse" data-target="#add-new-item-form">افزودن گزینه جدید</button>
                    <div class="step_3 steps p-3 mb-3 bg-white -shadow collapse" id="add-new-item-form">
                        <?= CHtml::beginForm('', 'post', array('class' => 'add-list-form'));?>
                            <div class="step_2 steps">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="steps--titleContainer d-flex">
                                            <h2 class="pb-3 steps__header">افزودن گزینه جدید</h2>
                                            <div class="flex-grow-1 border-bottom"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pl-md-3">
                                        <div class="mainPhoto mb-3 mb-md-0">
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
                                    <div class="col-md-9 pr-md-3">
                                        <div class="form-group">
                                            <?= CHtml::textField('title', null, array(
                                                'class' => 'form-control item-title',
                                                'placeholder' => 'عنوان گزینه...',
                                                'id' => 'option__title',
                                            ));?>
                                        </div>
                                        <div class="form-group">
                                            <?= CHtml::textArea("description", null, array(
                                                'class' => 'form-control',
                                                'placeholder' => "توضیحات...",
                                                'id' => "option__description",
                                                'cols' => 30,
                                                'rows' => 5,
                                            )) ?>
                                        </div>
                                        <div class="form-group text-right">
                                            <?= CHtml::submitButton('افزودن گزینه' ,array('class' => 'btn btn-outline-info addNextLink px-5', 'name' => 'publish')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?= CHtml::endForm();?>
                    </div>
                <?php else:?>
                    <a class="btn btn-info px-5 add-new-item my-3" data-toggle="modal" href="#login-modal"><i class="glyphicon glyphicon-plus"></i>افزودن گزینه جدید</a>
                <?php endif;?>
            </div>
        </div>

        <div class="row">
            <?php $this->renderPartial('_view_left_column',['model' => $model]); ?>
        </div>

        <div class="row">
            <div class="col-md-8 order-3">
                <div class="">
                    <span class="ml-2">اشتراک گذاری :</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $model->getViewUrl(true) ?>" target="_blank"><img src="<?= Yii::app()->theme->baseUrl?>/media/images/public/facebook.png" alt="facebook"></a>
                    <a href="http://twitter.com/share?url=<?= $model->getViewUrl(true) ?>"><img src="<?= Yii::app()->theme->baseUrl?>/media/images/public/twitter.png" alt="twitter"></a>
                    <a href="https://telegram.me/share/url?url=<?= $model->getViewUrl(true) ?>"><img src="<?= Yii::app()->theme->baseUrl?>/media/images/public/telegram.png" alt="telegram"></a>
                </div>
            </div>
        </div>
    </div>
</section>