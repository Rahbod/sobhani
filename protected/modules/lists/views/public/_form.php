<?php
/* @var $this ListsPublicController */
/* @var $model Lists */
/* @var $form CActiveForm */

$parents = ListCategories::getParents();
$sortedCategories = [];
foreach ($parents as $parentID => $parent){
    $sortedCategories[$parentID] = $parent;
    foreach (ListCategories::model()->findAll() as $category){
        if($category->parent_id == $parentID)
            $sortedCategories[$category->id] = $category->fullTitle;
    }
}
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'lists-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    )
)); ?>

<?php if(Yii::app()->user->hasFlash('failed')):?>
    <div class="alert alert-danger">
        <?php echo $form->errorSummary($model)?>
    </div>
    <?php Yii::app()->user->getFlash('failed');?>
<?php else:?>
    <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
<?php endif;?>

    <h1>ایجاد لیست بهترین ها</h1>
<h5 style="font-weight: normal">- هر لیست باید  حداقل ۳ و حداکثر ۱۰ گزینه داشته باشد.</h5>
<h5 style="font-weight: normal">- لیست ایجاد شده توسط شما پس از تایید کارشناسان به صورت عمومی نمایش داده خواهد شد.</h5>



    <div class="add-list-form">
        <div class="form-row">
            <?php echo $form->textField($model,'title',array('class'=>'transparent-input', 'placeholder' => 'عنوان لیست')); ?>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
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
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <?php echo $form->textArea($model,'description',array('placeholder'=>'توضیحات...')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <?= $form->label($model, 'category_id')?>
                    <?= $form->dropDownList($model, 'category_id', $sortedCategories, array('class'=>'form-control'))?>
                </div>
            </div>
        </div>
	    <?= $form->error($model, 'items')?>
        <?php
        for($i = 0; $i < (count($model->items) < 10 ? 10 : count($model->items)); $i++):
            ?>
            <div class="form-row">
                <span class="num <?php
                if($i==0) echo 'gold';
                if($i==1) echo 'silver';
                if($i==2) echo 'bronze';
                ?>"><?= $i+1?></span>
                <div class="input-container">
                    <?= CHtml::textField("Lists[items][{$i}][title]", isset($model->items[$i]['title'])?$model->items[$i]['title']:'', array('class' => 'transparent-input item-title', 'placeholder' => "عنوان گزینه")) ?>
                </div>
                <div class="row">
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
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <?= CHtml::textArea("Lists[items][{$i}][description]", isset($model->items[$i]['description'])?$model->items[$i]['description']:'', array('class' => 'form-control', 'placeholder' => "نظر...")) ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">
                            لینک های مرتبط
                        </label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dynamic-container" data-item-id="<?= $i ?>">
                        <div class="dynamic-box">
                            <?php
                            $k = 0;
                            $links = isset($model->items[$i]['links'])?$model->items[$i]['links']:null;

                            if($links):?>
                                <?php foreach($links as $link):?>
                                    <div class="dynamic-field input-group">
                                        <div class="dynamic-label">
                                            <?= CHtml::textField("Lists[items][{$i}][links][$k][title]",$link->title,array('class'=>'form-control', 'placeholder' => 'عنوان لینک')); ?>
                                        </div>
                                        <div class="dynamic-input">
                                            <?= CHtml::textField("Lists[items][{$i}][links][$k][value]",$link->url,array('class'=>'form-control', 'placeholder' => 'آدرس لینک')); ?>
                                        </div>
                                    </div>
                                    <?php $k++ ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="dynamic-field input-group">
                                <div class="dynamic-label">
                                    <?= CHtml::textField("Lists[items][{$i}][links][$k][title]","",array('class'=>'form-control', 'placeholder' => 'عنوان لینک')); ?>
                                </div>
                                <div class="dynamic-input">
                                    <?= CHtml::textField("Lists[items][{$i}][links][$k][value]","http://",array('class'=>'form-control', 'placeholder' => 'آدرس لینک')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="operation-links">
                            <a class="icon icon-plus add-dynamic-field-trigger"></a>
                            <a class="icon icon-trash remove-dynamic-field-trigger"></a>
                        </div>
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
');

Yii::app()->clientScript->registerScript('dynamic-fields','
    var $dynamicFieldsNum = [];   
    $(".dynamic-container").each(function(){
        $dynamicFieldsNum[$(this).data("item-id")] = $(this).find(".dynamic-field").length;
    });
    
    $("body").on("click", ".add-dynamic-field-trigger", function () {
        var container = $(this).parents(".dynamic-container");
        var box = container.find(".dynamic-box");
        var itemid = container.data("item-id");
        var fnum = $dynamicFieldsNum[itemid];
        
        fnum++;
        box.append("<div class=\'dynamic-field input-group\'>" +
            "<div class=\'dynamic-label\'>" +
                "<input type=\'text\' name=\'Lists[items]["+itemid+"][links]["+fnum+"][title]"+"\' class=\'form-control\' placeholder=\'عنوان لینک\' >" +
            "</div>" +
            "<div class=\'dynamic-input\'>" +
                "<input type=\'text\' name=\'Lists[items]["+itemid+"][links]["+fnum+"][value]"+"\' class=\'form-control\' placeholder=\'آدرس لینک\' value=\'http://\'>" +
            "</div> " +
        "</div>");
        
        $dynamicFieldsNum[container.data("item-id")] = fnum;
    }).on("click", ".remove-dynamic-field-trigger", function () {
        var container = $(this).parents(".dynamic-container");
        var box = container.find(".dynamic-box");
        var itemid = container.data("item-id");
        var fnum = $dynamicFieldsNum[itemid];
        
        if(fnum > 1){
            box.find(".dynamic-field:last-child").remove();
            fnum--;
        }else{
            box.find(".dynamic-field .dynamic-label input").val("");
            box.find(".dynamic-field .dynamic-input input").val("http://");
        }
        $dynamicFieldsNum[container.data("item-id")] = fnum;
    });
');