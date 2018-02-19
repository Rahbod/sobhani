<?php
/* @var $this ListsCategoryController */
/* @var $model ListCategories */
$this->breadcrumbs = array(
	'همه لیست ها' => array('/lists'),
	$model->title
);
?>
<h2><?= $model->title ?></h2>
<div class="category-row" style="margin-bottom: 50px;overflow:hidden;margin-top: 25px;">
    <?php foreach($model->childs as $category):?>
        <a class="catod" href="<?= $this->createUrl('/lists/category/'.$category->id.'/'.str_replace(' ', '-', $category->title)) ?>">
            <b><?= $category->title ?></b>
            <span><?= $category->description ?></span>
        </a>
    <?php endforeach; ?>
</div>
<div class="recommend">
	<?php
	$this->widget('zii.widgets.CListView', array(
		'id' => 'book-list',
		'dataProvider' => new CArrayDataProvider($model->approvedLists, array('pagination' => array('pageSize' => 20))),
		'itemView' => 'lists.views.public._view',
		'template' => '{items} {pager}',
		'ajaxUpdate' => true,
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager',
			'rowSelector'=>'.list-item',
			'listViewId' => 'book-list',
			'header' => '',
			'loaderText'=>'در حال دریافت ...',
			'options' => array('history' => true, 'triggerPageTreshold' => 2, 'trigger'=>'بارگذاری بیشتر ...'),
		),
		'afterAjaxUpdate'=>"function(id, data) {
			$.ias({
				'history': true,
				'triggerPageTreshold': 2,
				'trigger': 'بارگذاری بیشتر ...',
				'container': '#book-list',
				'item': '.list-item',
				'pagination': '#book-list .pager',
				'next': '#book-list .next:not(.disabled):not(.hidden) a',
				'loader': 'در حال دریافت ...'
			});
		}",
	));
	?>
</div>
