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
<section class="createList section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 mx-auto">
                <div class="createList_header">
                    <h4 class="-h4"><?php echo ($model->scenario != 'update') ? 'ایجاد لیست بهترین ها' : 'ویرایش لیست'?></h4>
                    <p class="mb-1 mt-4">
                        - هر لیست باید حداقل 3 و حداکثر 10 گزینه داشته باشد.
                    </p>
                    <p class="mb-5">
                        - لیست ایجاد شده توسط شما پس از تایید کارشناسان به صورت عمومی نمایش داده خواهد
                        شد.
                    </p>
                </div>
                <div class="formContainer">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'lists-form',
                        'enableAjaxValidation'=>false,
                        'enableClientValidation'=>true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true
                        )
                    )); ?>
                        <div class="step_1 steps">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="steps--titleContainer d-flex">
                                        <h2 class="pb-3 steps__header">
                                            مشخصات اصلی لیست
                                        </h2>
                                        <div class="flex-grow-1 border-bottom"></div>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-3">
                                    <div class="mainPhoto">
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
                                </div>
                                <div class="col-md-9 pr-3">
                                    <div class="form-group">
                                        <?php echo $form->textField($model,'title',array(
                                            'class'=>'form-control',
                                            'placeholder' => 'عنوان...',
                                            'id' => 'name',
                                        )); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->textArea($model,'description',array(
                                            'placeholder'=>'توضیحات...',
                                            'rows'=>8,
                                            'cols'=>30,
                                            'id'=>'description',
                                            'class'=>'form-control',
                                        )); ?>

                                    </div>
                                    <div class="form-group">
                                        <?= $form->dropDownList($model, 'category_id', $sortedCategories, array(
                                            'class'=>'form-control',
                                            'id'=>'category',
                                            'prompt'=>'انتخاب دسته...',
                                        ))?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="steps--titleContainer d-flex">
                                    <h2 class="pb-3 steps__header">افزودن گزینه ها</h2>
                                    <div class="flex-grow-1 border-bottom"></div>
                                </div>
                            </div>
                        </div>
                        <?= $form->error($model, 'items')?>
                        <?php for($i = 0; $i < (count($model->items) < 10 ? 10 : count($model->items)); $i++): ?>
                            <div class="step_2 steps <?php if($i != 0 and $model->scenario != 'update'):?>d-none<?php endif;?>" id="item-<?= $i?>">
                                <div class="form-row">
                                    <div class="col-md-3 pl-3">
                                        <div class="mainPhoto">
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
                                    <div class="col-md-9 pr-3">
                                        <div class="form-group">
                                            <?= CHtml::textField("Lists[items][{$i}][title]", isset($model->items[$i]['title'])?$model->items[$i]['title']:'', array(
                                                'class' => 'form-control',
                                                'placeholder' => "عنوان گزینه...",
                                            )) ?>
                                        </div>
                                        <div class="form-group">
                                            <?= CHtml::textArea("Lists[items][{$i}][description]", isset($model->items[$i]['description'])?$model->items[$i]['description']:'', array(
                                                'class' => 'form-control',
                                                'placeholder' => "توضیحات...",
                                                'cols' => 30,
                                                'rows' => 8,
                                            )) ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-12">
                                                    <h6 class="mt-3">لینک های مرتبط</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dynamic-container" data-item-id="<?= $i ?>">
                                            <div class="form-group dynamic-box">
                                                <?php
                                                $k = 0;
                                                $links = isset($model->items[$i]['links'])?$model->items[$i]['links']:null;

                                                if($links):?>
                                                    <?php foreach($links as $link):?>
                                                        <div class="dynamic-field form-row">
                                                            <div class="dynamic-label col-md-6">
                                                                <?= CHtml::textField("Lists[items][{$i}][links][$k][title]",$link->title,array('class'=>'form-control', 'placeholder' => 'عنوان لینک...')); ?>
                                                            </div>
                                                            <div class="dynamic-input col-md-6">
                                                                <?= CHtml::textField("Lists[items][{$i}][links][$k][value]",$link->url,array('class'=>'form-control', 'placeholder' => 'http://...', 'dir'=>'ltr')); ?>
                                                            </div>
                                                        </div>
                                                        <?php $k++ ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                <div class="dynamic-field form-row">
                                                    <div class="dynamic-label col-md-6">
                                                        <?= CHtml::textField("Lists[items][{$i}][links][$k][title]","",array('class'=>'form-control', 'placeholder' => 'عنوان لینک...')); ?>
                                                    </div>
                                                    <div class="dynamic-input col-md-6">
                                                        <?= CHtml::textField("Lists[items][{$i}][links][$k][value]",'',array('class'=>'form-control', 'placeholder' => 'http://...', 'dir'=>'ltr')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="#" class="removeLastLink -text-blue remove-dynamic-field-trigger"><i class="icon-trash"></i></a>
                                                <a href="#" class="addNextLink -text-blue add-dynamic-field-trigger">
                                                    <i class="icon-plus"></i>
                                                    افزودن لینک بعدی
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endfor;?>
                        <div class="step_3 steps">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="addNextOptionButton">
                                        <a href="#" class="-text-blue add-new-item-trigger" data-num="1">
                                            <i class="icon-plus"></i>
                                        افزودن گزینه بعدی
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php echo CHtml::submitButton($model->isNewRecord ? 'ایجاد لیست' : 'ویرایش لیست',array('class' => 'btn btn-outline-info ml-4 createList__btn', 'name' => 'publish')); ?>
                                    <?php echo CHtml::submitButton('ذخیره به عنوان پیشنویس',array('class' => 'btn btn-outline-dark createList__save', 'name' => 'draft')); ?>
                                </div>
                            </div>
                        </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</section>





<?php /*$form=$this->beginWidget('CActiveForm', array(
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
<?php $this->endWidget(); */?>
<?php /*Yii::app()->clientScript->registerScript('autocomplete', '
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
');*/

Yii::app()->clientScript->registerScript('dynamic-fields','
    var $dynamicFieldsNum = [];   
    $(".dynamic-container").each(function(){
        $dynamicFieldsNum[$(this).data("item-id")] = $(this).find(".dynamic-field").length;
    });
    
    $("body").on("click", ".add-dynamic-field-trigger", function (e) {
        e.preventDefault();
        var container = $(this).parents(".dynamic-container");
        var box = container.find(".dynamic-box");
        var itemid = container.data("item-id");
        var fnum = $dynamicFieldsNum[itemid];
        
        fnum++;

        box.append("<div class=\'dynamic-field form-row\'>" +
            "<div class=\'dynamic-label col-md-6\'>" +
                "<input type=\'text\' name=\'Lists[items]["+itemid+"][links]["+fnum+"][title]"+"\' class=\'form-control\' placeholder=\'عنوان لینک\' >" +
            "</div>" +
            "<div class=\'dynamic-input col-md-6\'>" +
                "<input type=\'text\' name=\'Lists[items]["+itemid+"][links]["+fnum+"][value]"+"\' class=\'form-control\' placeholder=\'http://...\' dir=\'ltr\'>" +
            "</div> " +
        "</div>");
        
        $dynamicFieldsNum[container.data("item-id")] = fnum;
    }).on("click", ".remove-dynamic-field-trigger", function (e) {
        e.preventDefault();
        var container = $(this).parents(".dynamic-container");
        var box = container.find(".dynamic-box");
        var itemid = container.data("item-id");
        var fnum = $dynamicFieldsNum[itemid];
        
        if(fnum > 1){
            box.find(".dynamic-field:last-child").remove();
            fnum--;
        }else{
            box.find(".dynamic-field .dynamic-label input").val("");
            box.find(".dynamic-field .dynamic-input input").val("");
        }
        $dynamicFieldsNum[container.data("item-id")] = fnum;
    }).on("click", ".add-new-item-trigger", function (e) {
        e.preventDefault();
        var num = $(this).data("num");
        if(num < 10){
            $("#item-"+num).removeClass("d-none");
            $(this).data("num", num+1);
            if(num == 9)
                $(this).addClass("d-none");
        }
    });
');