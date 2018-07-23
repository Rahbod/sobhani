<?php
/* @var $this UsersPublicController */
/* @var $user Users */
/* @var $lists Lists*/
$this->breadcrumbs =[
    'داشبورد',
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
$model = UserDetails::model()->findByPk($user->id);
?>
<div class="userinfo">
    <div class="uploader-container">
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
                    location.reload();
                }
                else{
                    $(".uploader-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
        )); ?>
<!--    --><?php //echo $form->error($model,'image'); ?>
        <div class="uploader-message error"></div>
    </div>
    <div class="user-image">
        <img src="<?= $user->userDetails->getAvatar() ?>" alt="<?= $user->userDetails->getShowName() ?>" title="<?= $user->userDetails->getShowName() ?>">>
    </div>
    <strong><?= $user->userDetails->getShowName() ?></strong>
    <div class="description"><?= $user->email?></div>
</div>
<h3>لیست های من</h3>
<div class="contentmod">
    <div class="contentmod1">
        <div class="table-responsive">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'lists-grid',
            'dataProvider'=>$lists->search(),
            //'filter'=>$model,
            'itemsCssClass'=>'table table-striped',
            'template' => '{summary} {pager} {items} {pager}',
            'ajaxUpdate' => true,
            'afterAjaxUpdate' => "function(id, data){
                    $('html, body').animate({
                    scrollTop: ($('#'+id).offset().top-130)
                    },1000,'easeOutCubic');
                }",
            'pager' => array(
                'header' => '',
                'firstPageLabel' => '<<',
                'lastPageLabel' => '>>',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'cssFile' => false,
                'htmlOptions' => array(
                    'class' => 'pagination pagination-sm',
                ),
            ),
            'pagerCssClass' => 'blank',
            'columns'=>array(
                array(
                    'name' => 'title',
                    'value' => function($data){
                        return CHtml::link($data->title, 'lists/'.$data->id.'/'.str_replace(' ', '-', $data->title));
                    },
                    'type' => 'raw'
                ),
                array(
                    'name' => 'create_date',
                    'value' => function($data){
                        return $data->create_date?JalaliDate::date('Y/m/d H:i', $data->create_date):'---';
                    }
                ),
                array(
                    'name' => 'category_id',
                    'value' => function($data){
                        return $data->category?$data->category->title:'---';
                    }
                ),
                array(
                    'name' => 'seen',
                    'value' => function($data){
                        return $data->seen;
                    }
                ),
                array(
                    'name' => 'status',
                    'value' => function($data){
                        $class = $data->status == Lists::STATUS_APPROVED?'success':($data->status == Lists::STATUS_PENDING?'primary':'danger');
                        if($data->status == Lists::STATUS_DRAFT)
                            $class = 'info';
                        return '<span class="label label-'.$class.'">'.$data->statusLabels[$data->status].'</span>';
                    },
                    'type' => 'raw'
                ),
//                array(
//                    'header'=>'عملیات',
//                    'value' => function($data){
//                        $link = Yii::app()->controller->createUrl('changeStatus').'/'.$data->id;
//                        return '<a href="'.$link.'" class="btn btn-xs btn-success">تغییر وضعیت</a>';
//                    },
//                    'type' => 'raw'
//                ),
                array(
                    'class'=>'CButtonColumn',
                    'template' => '{delete}  {update}',
                    'buttons' => array(
                        'update' => array(
                            'url' => 'Yii::app()->createUrl("lists/public/update/".$data->id)',
                            'imageUrl'=>Yii::app()->baseUrl."/themes/frontend/svg/pen_edit.svg" ,
                        ),
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("lists/public/delete/".$data->id)',
                            'imageUrl'=>Yii::app()->baseUrl."/themes/frontend/svg/delete_icon.svg",
                        )
                    )
                ),
            ),
        )); ?>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerCss('iconSize', '.button-column img{width:15px;}');
Yii::app()->clientScript->registerScript('clickOnUserAvatar', '
$(".userinfo .user-image").click(function(){
    $(".uploader-container .dropzone.single").trigger("click");
});
');?>