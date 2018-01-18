<?php
/* @var $this ListsManageController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن لیست', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت لیست</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن لیست</a>
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
                    'title',
                    array(
                        'name' => 'user_type',
                        'value' => function($data){
                            return $data->user_type == 'admin'?'مدیر':'کاربر';
                        }
                    ),
                    array(
                        'name' => 'user_id',
                        'value' => function($data){
                            if($data->user_type == 'user')
                                return $data->user->email;
                            return $data->admin->username;
                        }
                    ),
                    array(
                        'name' => 'create_date',
                        'value' => function($data){
                            return $data->create_date?JalaliDate::date('Y/m/d H:i', $data->create_date):'---';
                        }
                    ),
                    array(
                        'name' => 'category_id',
                        'value' => function($data){
                            return $data->category?$data->category->title:'---';
                        }
                    ),
                    array(
                        'name' => 'seen',
                        'value' => function($data){
                            return $data->seen;
                        }
                    ),
                    array(
                        'name' => 'status',
                        'value' => function($data){
                            $class = $data->status == Lists::STATUS_APPROVED?'success':($data->status == Lists::STATUS_PENDING?'primary':'danger');
                            return '<span class="label label-'.$class.'">'.$data->statusLabels[$data->status].'</span>';
                        },
                        'type' => 'raw'
                    ),
                    array(
                        'header'=>'عملیات',
                        'value' => function($data){
                            $link = Yii::app()->controller->createUrl('changeStatus').'/'.$data->id;
                            return '<a href="'.$link.'" class="btn btn-xs btn-success">تغییر وضعیت</a>';
                        },
                        'type' => 'raw'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>