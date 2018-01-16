<?php
/* @var $this ListsManageController */
/* @var $model Lists */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'تغییر وضعیت',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">تغییر وضعیت لیست <?php echo $model->title; ?></h3>
        <a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">حذف لیست</a>
    </div>
    <div class="box-body">
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

        <div class="well">
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

            <div class="form-group buttons">
                <?php echo CHtml::submitButton('ثبت',array('class' => 'btn btn-success')); ?>
            </div>

        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'image'); ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div style="width: 300px;height: auto;display: inline-block;margin-bottom: 15px">
                    <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/lists/'.$model->image ?>" style="width: 100%;height: auto;display: inline-block">
                </div>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'title'); ?>
            <div><?= $model->title ?></div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'description'); ?>
            <div><?= strip_tags($model->description) ?></div>
            <br>
        </div>
        <div class="well">
            <?php
            for($i = 0; $i < 10; $i++):
                ?>
                <div class="form-group">
                    <div class="input-container">
                        <b><?= "عنوان آیتم ".($i+1) ?>: </b>
                        <?= $model->items[$i]['title'] ?>
                    </div>
                    <div class="form-group row" style="margin-top: 5px">
                        <?php if(!empty($model->items[$i]['description'])): ?>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <b>توضیحات: </b><p><?= $model->items[$i]['description'] ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if(isset($model->items[$i]['image'])):?>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div style="width: 300px;height: auto;display: inline-block;margin-bottom: 15px">
                                    <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/items/'.$model->items[$i]['image']?>" style="width: 100%;height: auto;display: inline-block">
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <hr>
                <?php
            endfor;
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
