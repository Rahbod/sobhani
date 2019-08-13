<?php
/* @var $this ListsCategoryController */
/* @var $model ListCategories */

if ($model->parent) {
    $this->breadcrumbs = array(
        'همه لیست ها' => array('/lists'),
        $model->parent->title => array('/lists/category/' . $model->parent->id . '/' . $model->parent->title),
        $model->title
    );
} else {
    $this->breadcrumbs = array(
        'همه لیست ها' => array('/lists'),
        $model->title
    );
}

?>
<section class="createList section">
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="createList_header">
                    <h4 class="-h4 mb-5"><?=  $model->title ?></h4>
                </div>
                <?php if($model->childs):?>
                    <div class="category-row" style="margin-bottom: 50px;overflow:hidden;margin-top: 25px;">
                        <?php foreach ($model->childs as $category): ?>
                            <a class="catod"
                               href="<?= $this->createUrl('/lists/category/' . $category->id . '/' . str_replace(' ', '-', $category->title)) ?>">
                                <b><?= $category->title ?></b>
                                <span><?= $category->description ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif;?>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id' => 'book-list',
                    'dataProvider' => new CArrayDataProvider($model->approvedLists, array('pagination' => array('pageSize' => 20))),
                    'itemView' => 'lists.views.public._view',
                    'template' => '{items} {pager}',
                    'ajaxUpdate' => true,
                    'itemsCssClass' => 'row',
                    'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => '.list-item',
                        'listViewId' => 'book-list',
                        'header' => '',
                        'loaderText' => 'در حال دریافت ...',
                        'options' => array('history' => true, 'triggerPageTreshold' => 2, 'trigger' => 'بارگذاری بیشتر ...'),
                    ),
                    'afterAjaxUpdate' => "function(id, data) {
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
                ));?>
            </div>
        </div>
    </div>
</section>