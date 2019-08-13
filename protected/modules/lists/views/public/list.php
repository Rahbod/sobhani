<?php
/* @var $list Lists[] */
/* @var $title string */
$this->breadcrumbs = array(
    'همه لیست ها' => array('/lists')
);
?>
<section class="createList section">
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="createList_header">
                    <h4 class="-h4 mb-5"><?= $title ?></h4>
                </div>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id' => 'book-list',
                    'dataProvider' => new CArrayDataProvider($lists, array('pagination' => array('pageSize' => 20))),
                    'itemView' => 'lists.views.public._view',
                    'template' => '{items} {pager}',
                    'itemsCssClass' => 'row',
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
                )); ?>
            </div>
        </div>
    </div>
</section>






<!-- <h2><?= $title ?></h2>
<div class="recommend">
    <?php $this->widget('zii.widgets.CListView', array(
        'id' => 'book-list',
        'dataProvider' => new CArrayDataProvider($lists, array('pagination' => array('pageSize' => 20))),
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
    )); ?>
</div> -->