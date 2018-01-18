<?php
/* @var $this ListsPublicController */
/* @var $categories ListCategories[] */
?>
<div class="category-row">
<?php foreach($categories as $category):?>
    <a class="catod" href="<?= $this->createUrl('/lists/category/'.$category->id) ?>">
        <b><?= $category->title ?></b>
        <span><?= $category->description ?></span>
    </a>
<?php endforeach; ?>
</div>