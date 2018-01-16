<?php
/* @var $this ListsPublicController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن Lists</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', compact('model', 'itemImages', 'image')); ?>	</div>
</div>