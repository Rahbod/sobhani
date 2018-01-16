<?php
/* @var $this ListsManageController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن لیست',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن لیست</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', compact('model', 'itemImages', 'image')); ?>	</div>
</div>