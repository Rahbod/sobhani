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
