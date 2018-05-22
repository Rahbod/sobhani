<?php
/* @var $this AdminsDashboardController*/
/* @var $statistics []*/
/* @var CActiveDataProvider $newItemsProvider */
$permissions = [
    'contact' => false,
    'pendingCars' => false,
    'dealerRequests' => false,
    'carReports' => false,
    'statistics' => false,
];
if(Yii::app()->user->roles == 'admin'){
    $permissions['contact'] = true;
    $permissions['pendingCars'] = true;
    $permissions['dealerRequests'] = true;
    $permissions['carReports'] = true;
    $permissions['statistics'] = true;
}
?>
<div class="row boxed-statistics">
    <!--Cars Statistics-->
    
</div>
<div class="row">
    <section class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <!--Statistics-->
        <?php
        if($permissions['statistics']):
            ?>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title" >آمار بازدیدکنندگان</h3>
                </div>
                <div class="box-body">
                    <p>
                        افراد آنلاین : <?php echo Yii::app()->userCounter->getOnline(); ?><br />
                        بازدید امروز : <?php echo Yii::app()->userCounter->getToday(); ?><br />
                        بازدید دیروز : <?php echo Yii::app()->userCounter->getYesterday(); ?><br />
                        تعداد کل بازدید ها : <?php echo Yii::app()->userCounter->getTotal(); ?><br />
                        بیشترین بازدید : <?php echo Yii::app()->userCounter->getMaximal(); ?><br />
                    </p>
                </div>
            </div>
            <?php
        endif;
        ?>
    </section>

    <section class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title" >گزینه های جدید</h3>
            </div>
            <div class="box-body">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'admins-grid',
                    'dataProvider'=>$newItemsProvider,
                    'itemsCssClass'=>'table table-striped',
                    'columns'=>array(
                        array(
                            'name' => 'item_id',
                            'value' => function($data){
                                $link = Yii::app()->controller->createUrl('/lists/manage/showItem').'/'.$data->id;
                                return '<a href="'.$link.'">'.$data->item->title.'</a>';
                            },
                            'type' => 'raw'
                        ),
                        array(
                            'name' => 'list_id',
                            'value' => '$data->list->title'
                        ),
                        array(
                            'header'=>'عملیات',
                            'value' => function($data){
                                $confirmLink = Yii::app()->controller->createUrl('/lists/manage/confirmItem').'/'.$data->id;
                                $updateLink = Yii::app()->controller->createUrl('/lists/manage/update').'?id='.$data->list_id;
                                $deleteLink = Yii::app()->controller->createUrl('/lists/manage/deleteItem').'/'.$data->id;
                                return '<a href="'.$confirmLink.'" class="btn btn-xs btn-success">تایید</a> <a href="'.$updateLink.'" class="btn btn-xs btn-success">ویرایش</a> <a href="'.$deleteLink.'" class="btn btn-xs btn-danger">حذف</a>';
                            },
                            'type' => 'raw'
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </section>
</div>
