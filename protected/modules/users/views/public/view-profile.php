<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $lists Lists */

$purifier=new CHtmlPurifier();
?>
<section class="userPage section">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <div class="userPage--header d-flex align-items-center">
                    <div class="uploader-container">
                        <img src="<?= $model->userDetails->getAvatar() ?>" alt="<?= $model->userDetails->getShowName() ?>" title="<?= $model->userDetails->getShowName() ?>" class="img-fluid userAvatar">
                    </div>
                    <div class="flex-fill">
                        <div class="d-block mb-3">
                            <span class="-h5"><?= $model->userDetails->getShowName() ?></span>
                        </div>
                        <div class="d-block">
                            <small><?= $model->email?></small>
                        </div>
                    </div>
                </div>
                <div class="userPage--listMenu">
                    <div class="d-flex justify-content-center" style="border-top: 1px solid #dee2e6;">
                        <ul class="text-center nav nav-tabs mx-md-auto border-bottom-0 mb-3 mb-md-0"
                            id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active -fw-400" data-type="lists" id="pills-lists-tab" data-toggle="pill" href="#pills-lists" role="tab" aria-controls="pills-lists" aria-selected="true">
                                    <img class="d-none d-md-inline" src="<?php echo Yii::app()->theme->baseUrl; ?>/media/images/user_pages/lists_icon.png">
                                    لیست ها
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content bg-white" id="pills-tabContent">
                        <div class="tab-pane fade  show active" id="pills-lists" role="tabpanel" aria-labelledby="pills-lists-tab">
                            <div class="container">
                                <?php if($lists->search()->getTotalItemCount()):?>
                                    <?php $this->widget('zii.widgets.CListView', array(
                                        'dataProvider'=>$lists->search(),
                                        'itemView'=>'_list_item',
                                        'template' => '{items}',
                                    ));?>
                                <?php else:?>
                                    <div style="padding: 20px;">نتیجه ای یافت نشد.</div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>






<!-- <div class="profile">
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
</div> -->