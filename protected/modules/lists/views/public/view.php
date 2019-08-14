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
                            echo CHtml::ajaxLink('<img src="'.Yii::app()->theme->baseUrl.'/media/images/public/icon-1.png">',array('/lists/public/authJson'),array(
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
                            ),array(
                                'title' => 'افزودن به علاقه مندی ها',
                                'class' => 'cardHeader__leftImage'.($favorite?' active':''),
                            ));
                        else:
                            echo CHtml::link('<img src="'.Yii::app()->theme->baseUrl.'/media/images/public/icon-1.png">','#', array(
                                'class' => 'cardHeader__leftImage',
                                'data-toggle' => 'modal',
                                'data-target' => '#login-modal',
                                'title' => 'افزودن به علاقه مندی ها',
                            ));
                        endif; ?>
                    </div>
                    <img class="card-img-bottom" src="<?= Yii::app()->baseUrl.'/uploads/lists/thumbs/400x300/'.$model->getImage()?>" alt="<?= $model->title ?>" title="<?= $model->title ?>">
                    <div class="card-body">
                        <a href="void:;" class="d-flex align-items-center mb-4">
                            <img  width="51" height="51" class="ml-3" src="<?= $model->user->userDetails->getAvatar()?>" alt="">
                            <div class="flex-fill">
                                <p class="pb-1 listView--rightBox -subTitle"><?= $model->user->userDetails->getShowName()?></p>
                                <p class="m-0 listView--rightBox -listNumber"><?php echo count($model->user->lists)?> لیست</p>
                            </div>

                        </a>
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
            <div class="col-md-4 order-1">
                <div class="listView--leftBox">
                    <!-- <div class="listView--leftBox listView--leftBox--reports mb-3">
                        <h5 class="-h5 mb-3 pb-3 listView--leftBox -title">آمار و جزئیات</h5>
                        <ul class="list">
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <img class="ml-4" src="./assets/media/images/public/label_53866.png" alt="">
                                    </div>
                                    <div class="flex-fill">
                                        <a href="void:;" class="tags">
                                            شمال ایران
                                        </a>
                                        <a href="void:;" class="tags">
                                            تفریح و سرگرمی
                                        </a>
                                        <a href="void:;" class="tags">
                                            مسافرت
                                        </a>
                                        <a href="void:;" class="tags">
                                            گردشگری
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <p>
                                    <img class="ml-4" src="./assets/media/images/public/eye.png" alt="">
                                    <span>1258</span>
                                    <span>مشاهده</span>
                                </p>
                            </li>
                            <li class="mb-3">
                                <p>
                                    <img class="ml-4" src="./assets/media/images/public/check.png" alt="">
                                    <span>27</span>
                                    <span>رای ثبت شده</span>
                                </p>
                            </li>
                            <li class="mb-3">
                                <p>
                                    <img class="ml-4" src="./assets/media/images/public/user.png" alt="">
                                    <span>38</span>
                                    <span>نفر شرکت کننده</span>
                                </p>
                            </li>
                            <li class="">
                                <p>
                                    <img class="ml-4" src="./assets/media/images/public/mark.png" alt="">
                                    <span>56</span>
                                    <span>ذخیره سازی</span>
                                </p>
                            </li>
                        </ul>
                    </div> -->
                    <div class="listView--leftBox--related mb-3">
                        <h5 class="-h5 mb-3 pb-3 listView--leftBox -title">لیست های مرتبط</h5>
                        <div class="listView--leftBox--item">
                            <?php foreach ($this->similarProvider as $item): ?>
                                <a href="<?= $model->getViewUrl() ?>">
                                    <div class="d-flex">
                                        <div>
                                            <img src="<?= Yii::app()->getBaseUrl(true) . '/uploads/lists/thumbs/400x300/'. $item->getImage() ?>" alt="<?= $item->title ?>">
                                        </div>
                                        <div class="flex-fill listView--leftBox--related--descriptionsContainer">
                                            <p><?= $item->title ?></p>
                                            <p class="text-muted"><?= $item->seen ?>&nbsp;بازدید</p>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 order-4 order-md-2">
                <div class="listView--section2 d-flex mb-3 pb-3">
                    <div class="row">
                        <?php $this->renderPartial('_items',compact('items', 'model')); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-3 order-md-3">
                <div class="listView--leftBox mb-3">
                    <div class="listView--leftBox--related listView--leftBox--newest">
                        <h5 class="-h5 mb-3 pb-3 listView--leftBox -title">جدیدترین لیست ها</h5>
                        <div class="listView--leftBox--item">
                            <?php foreach($this->getLatestListsByID() as $list): ?>
                                <a href="<?= $list->getViewUrl() ?>">
                                    <div class="d-flex">
                                        <div>
                                            <img src="<?= Yii::app()->getBaseUrl(true) . '/uploads/lists/thumbs/400x300/'. $list->getImage() ?>" alt="<?= $list->title ?>">
                                        </div>
                                    </div>
                                 </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
<!--            <div class="col-md-8 order-4 order-md-2">-->
<!--            </div>-->
<!--            <div class="col-md-4 order-3 order-md-3">-->
<!--            </div>-->
            <div class="col-md-8 order-4 order-md-4">
                <?php if(!Yii::app()->user->isGuest):?>
                    <button type="button" style="margin-bottom: 15px;" class="btn btn-info px-5 add-new-item" data-toggle="collapse" data-target="#add-new-item-form">افزودن گزینه جدید</button>
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










<?php //$this->renderPartial("//partial-views/_flashMessage"); ?>
<!--<div class="alert alert-success view-alert hidden">-->
<!--	<p>-->
<!--		<span></span>-->
<!--		<button type="button" class="close" data-dismiss="alert">&times;</button>-->
<!--	</p>-->
<!--</div>-->
<!--<div class="list-item-view">-->
<!--    <div class="image-box">-->
<!--        <img src="--><?//= Yii::app()->baseUrl.'/uploads/lists/thumbs/400x300/'.$model->getImage()?><!--" class="image" alt="--><?//= $model->title ?><!--" title="--><?//= $model->title ?><!--">-->
<!--        <h2>--><?//= $model->title ?><!--</h2>-->
<!--        --><?php //if($model->user_type == 'user'):?>
<!--        <div class="user-image">-->
<!--            <img src="--><?//= $model->user->userDetails->getAvatar() ?><!--" alt="--><?//= $model->user->userDetails?$model->user->userDetails->getShowName():$model->user->email ?><!--" title="--><?//= $model->user->userDetails?$model->user->userDetails->getShowName():$model->user->email ?><!--">-->
<!--            <small>--><?//= $model->user->userDetails ? CHtml::link($model->user->userDetails->getShowName(),array('/users/public/viewProfile/'.$model->user->id.'/'.str_replace(' ', '-', $model->user->userDetails->getShowName()))):$model->user->email ?><!--</small>-->
<!--        </div>-->
<!--        --><?php //endif; ?>
<!--        <div class="text">--><?//= $model->description ?><!--</div>-->
<!--    </div>-->
<!--	<h2>-->
<!--		ده بهترین-->
<!--        <a target="_blank" href="https://telegram.me/share/url?url=--><?//= Yii::app()->createAbsoluteUrl('/lists/'.$model->id.'/'.str_replace(' ', '-', $model->title))?><!--" class="telegram-link gray pull-left" title="اشتراک گذاری در تلگرام"><i></i></a>-->
<!--		--><?php
//		if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):
//			echo CHtml::ajaxLink('<i class="star-icon"></i>',array('/lists/public/authJson'),array(
//				'type' => 'POST',
//				'dataType' => 'JSON',
//				'data' => array('method' => 'bookmark','hash'=>base64_encode($model->id)),
//				'beforeSend' => 'js: function(data){
//					$(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
//				}',
//				'success' => 'js: function(data){
//					if(data.status){
//						if($(".favorite").hasClass("active"))
//							$(".favorite").removeClass("active");
//						else
//							$(".favorite").addClass("active");
//						$(".view-alert").addClass("alert-success").find("span").text(data.message);
//					}
//					else{
//						$(".view-alert").addClass("alert-warning").find("span").text(data.message);
//					}
//					$(".view-alert").removeClass("hidden");
//				}'
//			),array('title' => 'افزودن به علاقه مندی ها', 'class' => 'favorite pull-left'.($favorite?' active':'')));
//		else:
//			echo CHtml::link('<i class="star-icon"></i>','#',
//				array('class' => 'favorite pull-left', 'data-toggle' => 'modal', 'data-target' => '#login-modal', 'title' => 'افزودن به علاقه مندی ها'));
//		endif;
//		?>
<!--	</h2>-->
<!--	<div class="add-list-form items-list">-->
<!--        <div>-->
<!--		    --><?php //$this->renderPartial('_items',compact('items', 'model')); ?>
<!--        </div>-->
<!--        --><?php //if(!Yii::app()->user->isGuest):?>
<!--            <button type="button" class="btn btn-blue add-new-item" data-toggle="collapse" data-target="#add-new-item-form"><i class="glyphicon glyphicon-plus"></i>افزودن گزینه جدید</button>-->
<!--            <div class="collapse" id="add-new-item-form">-->
<!--                --><?//= CHtml::beginForm('', 'post', array('class' => 'add-list-form'));?>
<!--                    <div class="form-row">-->
<!--                        <div class="container-fluid">-->
<!--                            <span class="num">--><?//= count($items) + 1?><!--</span>-->
<!--                            <div class="input-container">-->
<!--                                --><?//= CHtml::textField('title', null, array('class' => 'transparent-input item-title', 'placeholder' => 'عنوان'));?>
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="fix-overflow">-->
<!--                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">-->
<!--                                --><?//= CHtml::textArea("description", null, array('class' => 'form-control', 'placeholder' => "نظر...")) ?>
<!--                            </div>-->
<!--                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">-->
<!--                                --><?php //$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
//                                    'id' => "uploaderImage",
//                                    'name' => "Lists[items][0][image]",
//                                    'maxFiles' => 1,
//                                    'maxFileSize' => 0.5, //MB
//                                    'url' => $this->createUrl('uploadItem'),
//                                    'deleteUrl' => $this->createUrl('deleteUploadItem'),
//                                    'acceptedFiles' => '.jpg, .jpeg, .png',
//                                    'containerClass' => 'uploader',
//                                    'serverFiles' => [],
//                                    'onSuccess' => "
//                                        var responseObj = JSON.parse(res);
//                                        if(responseObj.status){
//                                            {serverName} = responseObj.fileName;
//                                            $(\".uploader-message\").html(\"\");
//                                        }
//                                        else{
//                                            $(\".uploader-message\").html(responseObj.message);
//                                            this.removeFile(file);
//                                        }
//                                    ",
//                                )); ?>
<!--                                <div class="uploader-message error"></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="container-fluid">-->
<!--                            --><?//= CHtml::submitButton('ثبت' ,array('class' => 'btn btn-blue', 'name' => 'publish')); ?>
<!--                        </div>-->
<!--                    </div>-->
<!--                --><?//= CHtml::endForm();?>
<!--            </div>-->
<!--        --><?php //else:?>
<!--            <a class="btn btn-blue add-new-item" data-toggle="modal" href="#login-modal"><i class="glyphicon glyphicon-plus"></i>افزودن گزینه جدید</a>-->
<!--        --><?php //endif;?>
<!---->
<!--        <div class="new-list-box">-->
<!--            <p class="text-center">شما نیز میتوانید لیست دلخواه خود را ایجاد کنید.</p>-->
<!--            <p class="text-center">-->
<!--                <a class="btn btn-orange btn-custom" href="--><?//= $this->createUrl('/new') ?><!--" title="ایجاد لیستی از بهترین ها">ایجاد لیستی از بهترین ها</a>-->
<!--            </p>-->
<!--        </div>-->
<!--	</div>-->
<!--</div>-->