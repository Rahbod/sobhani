<?php
/* @var $this ListsCategoryController */
/* @var $model ListCategories */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست ListCategories', 'url'=>array('index')),
	array('label'=>'افزودن ListCategories', 'url'=>array('create')),
	array('label'=>'ویرایش ListCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف ListCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت ListCategories', 'url'=>array('admin')),
);
?>

<h1>نمایش ListCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'description',
	),
)); ?>
