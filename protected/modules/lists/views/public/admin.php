<?php
/* @var $this ListsPublicController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن Lists', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت Lists</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن Lists</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>        
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'lists-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped',
                'template' => '{summary} {pager} {items} {pager}',
                'ajaxUpdate' => true,
                'afterAjaxUpdate' => "function(id, data){
                    $('html, body').animate({
                    scrollTop: ($('#'+id).offset().top-130)
                    },1000,'easeOutCubic');
                }",
                'pager' => array(
                    'header' => '',
                    'firstPageLabel' => '<<',
                    'lastPageLabel' => '>>',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'cssFile' => false,
                    'htmlOptions' => array(
                        'class' => 'pagination pagination-sm',
                    ),
                ),
                'pagerCssClass' => 'blank',
                'columns'=>array(
            		'id',
		'title',
		'image',
		'description',
		'user_id',
		'category_id',
		/*
		'create_date',
		'seen',
		'status',
		*/
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>