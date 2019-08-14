<?php
/* @var $this UsersPublicController */
/* @var $user Users */
/* @var $lists Lists */
/* @var $recommended CActiveDataProvider */
/* @var $bookmarked UserBookmarks */
$this->breadcrumbs =[
    'داشبورد',
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
$model = UserDetails::model()->findByPk($user->id);
?>
<?php $this->renderPartial('//partial-views/_flashMessage')?>
<section class="userPage section">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <div class="userPage--header d-flex align-items-center">
                    <div class="uploader-container">
                        <img src="<?= $user->userDetails->getAvatar() ?>" alt="<?= $user->userDetails->getShowName() ?>" title="<?= $user->userDetails->getShowName() ?>" class="img-fluid userAvatar">
                        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                            'id' => 'uploaderLogo',
                            'model' => $model,
                            'name' => 'avatar',
                            'containerClass' => 'updateimage uploader',
                            'dictDefaultMessage'=>$user->userDetails->getAttributeLabel('avatar').' را به اینجا بکشید',
                            'maxFiles' => 1,
                            'maxFileSize' => 0.5, //MB
                            'data'=>array('user_id'=>$user->id),
                            'url' => $this->createUrl('upload'),
                            'deleteUrl' => $this->createUrl('deleteUpload'),
                            'acceptedFiles' => '.jpg, .jpeg, .png',
                            'serverFiles' => [],
                            'onSending' => '
                                $(".userinfo").addClass("uploading");
                            ',
                                            'onSuccess' => '
                                var responseObj = JSON.parse(res);
                                if(responseObj.status){
                                    {serverName} = responseObj.fileName;
                                    $(".uploader-message").html("");
                                    //location.reload();
                                }
                                else{
                                    $(".uploader-message").html(responseObj.message);
                                    this.removeFile(file);
                                }
                            ',
                        )); ?>
                        <div class="uploader-message error"></div>
                    </div>
                    <div class="flex-fill">
                        <div class="d-block mb-3">
                            <span class="-h5"><?= $user->userDetails->getShowName() ?></span>
                            <a href="<?php echo Yii::app()->createUrl('profile');?>" class="btn btn-outline-info mr-3">ویرایش پروفایل</a>
                            <a href="<?php echo Yii::app()->createUrl('changePassword');?>" class="btn btn-outline-secondary mr-3">تغییر کلمه عبور</a>
                        </div>
                        <div class="d-block">
                            <small><?= $user->email?></small>
                        </div>

                    </div>
                </div>
                <div class="alert alert-success view-alert d-none">
                    <p>
                        <span></span>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </p>
                </div>
                <div class="userPage--listMenu">
                    <div class="d-flex justify-content-center" style="border-top: 1px solid #dee2e6;">
                        <ul class="text-center nav nav-tabs mx-md-auto border-bottom-0 mb-3 mb-md-0"
                            id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active -fw-400" data-type="lists" id="pills-lists-tab" data-toggle="pill" href="#pills-lists" role="tab" aria-controls="pills-lists" aria-selected="true">
                                    <img class="d-none d-md-inline" src="<?php echo Yii::app()->theme->baseUrl; ?>/media/images/user_pages/lists_icon.png">
                                    لیست ها
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link -fw-400" data-type="saves" id="pills-saves-tab" data-toggle="pill" href="#pills-saves" role="tab" aria-controls="pills-saves" aria-selected="false">
                                    <img class="d-none d-md-inline" src="<?php echo Yii::app()->theme->baseUrl; ?>/media/images/user_pages/saves.png">
                                    ذخیره شده ها
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link -fw-400" data-type="suggestions" id="pills-suggestions-tab" data-toggle="pill" href="#pills-suggestions" role="tab" aria-controls="pills-suggestions" aria-selected="false">
                                    <img class="d-none d-md-inline" src="<?php echo Yii::app()->theme->baseUrl; ?>/media/images/user_pages/suggestions.png">
                                    پیشنهادی
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content bg-white" id="pills-tabContent">
                        <div class="tab-pane fade  show active" id="pills-lists" role="tabpanel" aria-labelledby="pills-lists-tab">
                            <div class="container">
                                <?php if($lists->search()->getTotalItemCount()):?>
                                    <?php $this->widget('zii.widgets.CListView', array(
                                        'dataProvider'=>$lists->search(),
                                        'itemView'=>'_list_item',
                                        'template' => '{items}',
                                    ));?>
                                <?php else:?>
                                    <div style="padding: 20px;">نتیجه ای یافت نشد.</div>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-saves" role="tabpanel" aria-labelledby="pills-saves-tab">
                            <?php if($bookmarked):?>
                                <?php foreach($bookmarked as $item):?>
                                    <?php $this->renderPartial('_bookmarked_list_item', ['data' => $item]);?>
                                <?php endforeach;?>
                            <?php else:?>
                                <div style="padding: 20px;">نتیجه ای یافت نشد.</div>
                            <?php endif;?>
                        </div>
                        <div class="tab-pane fade" id="pills-suggestions" role="tabpanel" aria-labelledby="pills-suggestions-tab">
                            <?php if($recommended->getTotalItemCount()):?>
                                <?php $this->widget('zii.widgets.CListView', array(
                                    'dataProvider'=>$recommended,
                                    'itemView'=>'_recommended_list_item',
                                    'template' => '{items}',
                                ));?>
                            <?php else:?>
                                <div style="padding: 20px;">نتیجه ای یافت نشد.</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
Yii::app()->clientScript->registerCss('iconSize', '.uploader-container .uploader{display: none;} .userAvatar{cursor:pointer;}');
Yii::app()->clientScript->registerScript('clickOnUserAvatar', '
$(".userAvatar").click(function(){
    $(".uploader-container .dropzone.single").trigger("click");
});
$(".btn-delete-list").click(function(){
    if(confirm("آیا از حذف این لیست مطمئن هستید؟"))
        return true;
    return false;
});
');?>
<script>
    var article;
    $(function () {
        $('body').on("click",".remove-bookmark", function () {
            article = $(this).parents(".list-item");
        });
    })
</script>















<!--<div class="userinfo">-->
<!--    <div class="uploader-container">-->
<!---->
<!--    </div>-->
<!--    <div class="user-image">-->
<!---->
<!--    </div>-->
<!--    <strong></strong>-->
<!--    <div class="description"></div>-->
<!--</div>-->
<!--<h3>لیست های من</h3>-->
<!--<div class="contentmod">-->
<!--    <div class="contentmod1">-->
<!--        <div class="table-responsive">-->
<!--        --><?php //$this->widget('zii.widgets.grid.CGridView', array(
//            'id'=>'lists-grid',
//            'dataProvider'=>$lists->search(),
//            //'filter'=>$model,
//            'itemsCssClass'=>'table table-striped',
//            'template' => '{summary} {pager} {items} {pager}',
//            'ajaxUpdate' => true,
//            'afterAjaxUpdate' => "function(id, data){
//                    $('html, body').animate({
//                    scrollTop: ($('#'+id).offset().top-130)
//                    },1000,'easeOutCubic');
//                }",
//            'pager' => array(
//                'header' => '',
//                'firstPageLabel' => '<<',
//                'lastPageLabel' => '>>',
//                'prevPageLabel' => '<',
//                'nextPageLabel' => '>',
//                'cssFile' => false,
//                'htmlOptions' => array(
//                    'class' => 'pagination pagination-sm',
//                ),
//            ),
//            'pagerCssClass' => 'blank',
//            'columns'=>array(
//                array(
//                    'name' => 'title',
//                    'value' => function($data){
//                        return CHtml::link($data->title, 'lists/'.$data->id.'/'.str_replace(' ', '-', $data->title));
//                    },
//                    'type' => 'raw'
//                ),
//                array(
//                    'name' => 'create_date',
//                    'value' => function($data){
//                        return $data->create_date?JalaliDate::date('Y/m/d H:i', $data->create_date):'---';
//                    }
//                ),
//                array(
//                    'name' => 'category_id',
//                    'value' => function($data){
//                        return $data->category?$data->category->title:'---';
//                    }
//                ),
//                array(
//                    'name' => 'seen',
//                    'value' => function($data){
//                        return $data->seen;
//                    }
//                ),
//                array(
//                    'name' => 'status',
//                    'value' => function($data){
//                        $class = $data->status == Lists::STATUS_APPROVED?'success':($data->status == Lists::STATUS_PENDING?'primary':'danger');
//                        if($data->status == Lists::STATUS_DRAFT)
//                            $class = 'info';
//                        return '<span class="label label-'.$class.'">'.$data->statusLabels[$data->status].'</span>';
//                    },
//                    'type' => 'raw'
//                ),
////                array(
////                    'header'=>'عملیات',
////                    'value' => function($data){
////                        $link = Yii::app()->controller->createUrl('changeStatus').'/'.$data->id;
////                        return '<a href="'.$link.'" class="btn btn-xs btn-success">تغییر وضعیت</a>';
////                    },
////                    'type' => 'raw'
////                ),
//                array(
//                    'class'=>'CButtonColumn',
//                    'template' => '{delete}  {update}',
//                    'buttons' => array(
//                        'update' => array(
//                            'url' => 'Yii::app()->createUrl("lists/public/update/".$data->id)',
//                            'imageUrl'=>Yii::app()->baseUrl."/themes/frontend/svg/pen_edit.svg" ,
//                        ),
//                        'delete' => array(
//                            'url' => 'Yii::app()->createUrl("lists/public/delete/".$data->id)',
//                            'imageUrl'=>Yii::app()->baseUrl."/themes/frontend/svg/delete_icon.svg",
//                        )
//                    )
//                ),
//            ),
//        )); ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->