<?php
/* @var $this UsersPublicController */
/* @var $user Users */
$this->breadcrumbs =[
    'داشبورد',
    'لیست های من' => array('/my-lists'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
$model = UserDetails::model()->findByPk($user->id);
?>
<div class="userinfo">
    <div class="uploader-container pull-left">
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
        <img src="<?= $user->userDetails->getAvatar() ?>">
    </div>
    <strong><?= $user->userDetails->getShowName() ?></strong>
    <div class="description"><?= $user->email?></div>
</div>
<h3>جدیدترین نظرات</h3>
<div class="contentmod">
<!--    --><?php
//    if($user->lists)
//    ?>
    <div class="contentmod1">کاربر هنوز هیچ نظر قابل مشاهده را اضافه نکرده است.</div>
</div>