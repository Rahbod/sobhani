<?php
/* @var $this ListsCategoryController */
/* @var $model ListCategories */
/* @var $form CActiveForm */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?><?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'list-categories-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_id', ListCategories::getParents(), array('class' => 'form-control', 'prompt' => 'بدون والد')) ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

<!--    <div class="form-group">-->
<!--        --><?php //echo $form->labelEx($model,'formTags'); ?>
<!--        --><?php
//        $this->widget("ext.tagIt.tagIt",array(
//            'model' => $model,
//            'attribute' => 'formTags',
//            'suggestType' => 'json',
//            'suggestUrl' => Yii::app()->createUrl('/tags/list'),
//            'data' => $model->formTags
//        ));
//        ?>
<!--        --><?php //echo $form->error($model,'formTags'); ?>
<!--    </div>-->

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
