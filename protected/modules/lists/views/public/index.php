<?php
/* @var $this ListsPublicController */
/* @var $categories ListCategories[] */
?>
<section class="createList section">
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="createList_header">
                    <h4 class="-h4 mb-5">دسته بندی</h4>
                </div>
                <div class="category-row">
                    <?php foreach($categories as $category):?>
                        <a class="catod" href="<?= $this->createUrl('/lists/category/'.$category->id.'/'.str_replace(' ', '-', $category->title)) ?>">
                            <b><?= $category->title ?></b>
                            <span><?= $category->description ?></span>
                        </a>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</section>