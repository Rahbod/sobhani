<?php
/* @var $this ListsPublicController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'داشبورد'=>array('/dashboard'),
	$model->title=>array('view','id'=>$model->id, 'title' => str_replace(' ', '-', $model->title)),
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
<!--        <h3 class="box-title">ویرایش --><?php //echo $model->title; ?><!--</h3>-->
        <? /*<a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">حذف کتاب</a>*/?>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', compact('model', 'itemImages', 'image')); ?>    </div>
</div>
