<?php
/* @var $this ListsManageController */
/* @var $itemRel ListItemRel */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$itemRel->item->title,
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $itemRel->item->title; ?></h3>
    </div>
    <div class="box-body">
        <?php if($itemRel->image):?>
            <div class="form-group">
                <label>تصویر</label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="width: 300px;height: auto;display: inline-block;margin-bottom: 15px">
                        <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/items/'.$itemRel->image ?>" style="width: 100%;height: auto;display: inline-block" alt="<?= $itemRel->item->title ?>" title="<?= $itemRel->item->title ?>">
                    </div>
                </div>
            </div>
        <?php endif;?>

        <div class="form-group">
            <label>عنوان</label>
            <div><?= $itemRel->item->title ?></div>
        </div>

        <div class="form-group">
            <label>ایجاد کننده</label>
            <div><?= $itemRel->user->userDetails->getShowName() ?></div>
        </div>

        <div class="form-group">
            <label>وضعیت</label>
            <div><?= $itemRel->statusLabels[$itemRel->status] ?></div>
        </div>

        <div class="form-group">
            <label>توضیحات</label>
            <div><?= strip_tags($itemRel->description) ?></div>
            <br>
        </div>
    </div>
</div>
