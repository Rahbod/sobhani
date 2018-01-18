<?php
/* @var $this ListsPublicController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'خانه' => array('/'),
	'افزودن لیست',
);
?>
<?php $this->renderPartial('_form', compact('model', 'itemImages', 'image')); ?>	</div>