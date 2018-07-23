<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $lists Lists */

$purifier=new CHtmlPurifier();
?>

<div class="profile">
    <div class="info">
        <img src="<?php echo $model->userDetails->getAvatar();?>" alt="<?= $model->userDetails->getShowName() ?>" title="<?= $model->userDetails->getShowName() ?>">
        <div class="text">
            <h1><?php echo $model->userDetails->getShowName();?></h1>
            <small><span><?php echo $model->email;?></span><span>تاریخ عضویت: <?php echo JalaliDate::date('d F Y', $model->create_date);?></span></small>
        </div>
    </div>
    <h3>لیست های <?php echo $model->userDetails->getShowName();?></h3>
    <div class="contentmod">
        <div class="contentmod1">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'lists-grid',
                'dataProvider'=>$lists->search(),
                //'filter'=>$model,
                'itemsCssClass'=>'table table-striped',
                'template' => '{items} {pager}',
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
                    array(
                        'name' => 'title',
                        'value' => function($data){
                            return CHtml::link($data->title, array('/lists/'.$data->id.'/'.str_replace(' ', '-', $data->title)));
                        },
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'category_id',
                        'value' => function($data){
                            return $data->category?$data->category->title:'---';
                        }
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>