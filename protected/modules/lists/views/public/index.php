<?php
/* @var $this ListsPublicController */
/* @var $categories ListCategories[] */
?>
<?php foreach($categories as $category):?>
    <a class="catod" href="<?= $this->createUrl('/lists/'.$category->id) ?>">
        <b><?= $category->title ?></b>
        <span><?= $category->description ?></span>
    </a>
<?php endforeach; ?>
