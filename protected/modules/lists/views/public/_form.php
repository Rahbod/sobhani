<?php
/* @var $this ListsPublicController */
/* @var $model Lists */
/* @var $form CActiveForm */
?>


<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lists-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>
    <h1>ایجاد لیست بهترین ها</h1>
<h5>- هر لیست باید  حداقل ۳ و حداکثر ۱۰ گزینه داشته باشد.</h5>
<h5>- لیست ایجاد شده توسط شما پس از تایید کارشناسان به صورت عمومی نمایش داده خواهد شد.</h5>



    <div class="add-list-form">
        <?php echo $form->errorSummary($model)?>
        <div class="form-row">
            <?php echo $form->textField($model,'title',array('class'=>'transparent-input', 'placeholder' => 'عنوان لیست')); ?>
            <?php echo $form->textArea($model,'description',array('placeholder'=>'توضیحات...')); ?>
            <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                'id' => 'uploaderLogo',
                'model' => $model,
                'name' => 'image',
                'containerClass' => 'uploader',
                'maxFiles' => 1,
                'maxFileSize' => 0.5, //MB
                'url' => $this->createUrl('upload'),
                'deleteUrl' => $this->createUrl('deleteUpload'),
                'acceptedFiles' => '.jpg, .jpeg, .png',
                'serverFiles' => isset($image)?$image:[],
                'onSuccess' => '
                    var responseObj = JSON.parse(res);
                    if(responseObj.status){
                        {serverName} = responseObj.fileName;
                        $(".uploader-message").html("");
                    }
                    else{
                        $(".uploader-message").html(responseObj.message);
                        this.removeFile(file);
                    }
                ',
            )); ?>
            <?php echo $form->error($model,'image'); ?>
            <div class="uploader-message error"></div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <?= $form->label($model, 'category_id')?>
                    <?= $form->dropDownList($model, 'category_id', CHtml::listData(ListCategories::model()->findAll(), 'id', 'fullTitle'), array('class'=>'form-control'))?>
                </div>
            </div>
        </div>
	    <?= $form->error($model, 'items')?>
        <?php
        for($i = 0; $i < 10; $i++):
            ?>
            <div class="form-row">
                <span class="num <?php
                if($i==0) echo 'gold';
                if($i==1) echo 'silver';
                if($i==2) echo 'bronze';
                ?>"><?= $i+1?></span>
                <div class="input-container">
                    <?= CHtml::textField("Lists[items][{$i}][title]", isset($model->items[$i]['title'])?$model->items[$i]['title']:'', array('class' => 'transparent-input item-title', 'placeholder' => "گزینه")) ?>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <?= CHtml::textArea("Lists[items][{$i}][description]", isset($model->items[$i]['description'])?$model->items[$i]['description']:'', array('class' => 'form-control', 'placeholder' => "نظر...")) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                            'id' => "uploaderImage{$i}",
                            'name' => "Lists[items][{$i}][image]",
                            'maxFiles' => 1,
                            'maxFileSize' => 0.5, //MB
                            'url' => $this->createUrl('uploadItem'),
                            'deleteUrl' => $this->createUrl('deleteUploadItem'),
                            'acceptedFiles' => '.jpg, .jpeg, .png',
                            'containerClass' => 'uploader',
                            'serverFiles' => isset($itemImages) && isset($itemImages[$i])?$itemImages[$i]:[],
                            'onSuccess' => "
                                    var responseObj = JSON.parse(res);
                                    if(responseObj.status){
                                        {serverName} = responseObj.fileName;
                                        $(\".uploader-message-{$i}\").html(\"\");
                                    }
                                    else{
                                        $(\".uploader-message-{$i}\").html(responseObj.message);
                                        this.removeFile(file);
                                    }
                                ",
                        )); ?>
                        <div class="uploader-message-<?= $i ?> error"></div>
                    </div>
                </div>
            </div>
            <?php
        endfor;
        ?>
        <div class="form-row last">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ایجاد لیست' : 'ویرایش لیست',array('class' => 'btn btn-blue', 'name' => 'publish')); ?>
            <?php echo CHtml::submitButton('ذخیره پیشنویس',array('class' => 'btn btn-gray', 'name' => 'draft')); ?>
        </div>
</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('autocomplete', '
$(".item-title").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "'.$this->createUrl('autoComplete').'",
            data: { query: request.term },
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                var transformed = $.map(data, function (el) {
                    return {
                        label: el.title,
                        id: el.id
                    };
                });
                response(transformed);
            },
            error: function () {
                response([]);
            }
        });
    }
});
');?>
