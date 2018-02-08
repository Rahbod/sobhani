<?php
/* @var $this UsersPublicController */
/* @var $model Lists*/

$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'لیست های من',
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>
<h2>لیست های من</h2>
<div class="recommend">
    <?php $this->renderPartial('//partial-views/_flashMessage');?>
    <div class="table-responsive">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'lists-grid',
            'dataProvider'=>$model->search(),
            //'filter'=>$model,
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
                array(
                    'name' => 'title',
                    'value' => function($data){
                        return CHtml::a($data->title, array('/lists/'.$data->id));
                    },
                    'type' => 'raw'
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
                        if($data->status == Lists::STATUS_DRAFT)
                            $class = 'info';
                        return '<span class="label label-'.$class.'">'.$data->statusLabels[$data->status].'</span>';
                    },
                    'type' => 'raw'
                ),
//                array(
//                    'header'=>'عملیات',
//                    'value' => function($data){
//                        $link = Yii::app()->controller->createUrl('changeStatus').'/'.$data->id;
//                        return '<a href="'.$link.'" class="btn btn-xs btn-success">تغییر وضعیت</a>';
//                    },
//                    'type' => 'raw'
//                ),
                array(
                    'class'=>'CButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'update' => array(
                            'url' => '$data->viewUrl',
                            'visible' => '$data->status == 1',
                            'imageUrl' => Yii::app()->baseUrl.'/themes/frontend/svg/trash.svg'
                        )
                    )
                ),
            ),
        )); ?>
    </div>
</div>