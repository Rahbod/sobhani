<?php
/* @var $this ListsManageController */
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
	<?= $form->errorSummary($model); ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderLogo',
			'model' => $model,
			'name' => 'image',
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

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id', CHtml::listData(ListCategories::model()->findAll(), 'id', 'title'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', $model->statusLabels ,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="well">
		<?= $form->error($model, 'items')?>
		<?php
		for($i = 0; $i < (count($model->items) < 10 ? 10 : count($model->items)); $i++):
		?>
			<div class="form-group">
				<span class="num bronze">آیتم <?= $i+1?></span>
				<div class="input-container">
					<?= CHtml::textField("Lists[items][{$i}][title]", isset($model->items[$i]['title'])?$model->items[$i]['title']:'', array('class' => 'form-control', 'placeholder' => "عنوان آیتم ".($i+1))) ?>
				</div>
				<div class="form-group row" style="margin-top: 5px">

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
                            'id' => "uploaderImage{$i}",
                            'name' => "Lists[items][{$i}][image]",
                            'maxFiles' => 1,
                            'maxFileSize' => 0.5, //MB
                            'url' => $this->createUrl('uploadItem'),
                            'deleteUrl' => $this->createUrl('deleteUploadItem'),
                            'acceptedFiles' => '.jpg, .jpeg, .png',
                            'serverFiles' => $itemImages && isset($itemImages[$i])?$itemImages[$i]:[],
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
                            <a class="fa fa-plus add-dynamic-field-trigger"></a>
                            <a class="fa fa-trash remove-dynamic-field-trigger"></a>
                        </div>
                    </div>
				</div>
			</div>
			<hr>
		<?php
		endfor;
		?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>


<?php

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
Yii::app()->clientScript->registerCss('dynamic-fields','
    
.dynamic-container{
    position: relative;
}
.dynamic-container .dynamic-box{
    display: block;
    width: 100%;
    padding-right: 30px;
}
.dynamic-container .dynamic-field{
    white-space: nowrap;
    display: block;
    overflow: hidden;
    vertical-align: top;
    margin-bottom: 2px;
}
.dynamic-container .dynamic-input,
.dynamic-container .dynamic-label{
    display: table-cell;
    width: 1%;
    padding: 0 2px;
}
.dynamic-container .operation-links{
    position: absolute;
    right: 15px;
    top: 10px;
}
.dynamic-box input{
    border:none;
}
.dynamic-box .dynamic-input input{
    direction: ltr !important;
}
hr{
    border-style: dashed;
    border-color:#999
}
');