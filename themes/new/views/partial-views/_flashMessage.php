<?php
if(!isset($prefix))
    $prefix = '';
?>

<?php if(Yii::app()->user->hasFlash($prefix.'success')):?>
    <div class="alert alert-success view-flash">
        <p>
            <span><?php echo Yii::app()->user->getFlash($prefix.'success');?></span>
        </p>
    </div>
<?php elseif(Yii::app()->user->hasFlash($prefix.'failed')):?>
    <div class="alert alert-danger view-flash">
        <p>
            <span><?php echo Yii::app()->user->getFlash($prefix.'failed');?></span>
        </p>
    </div>
<?php elseif(Yii::app()->user->hasFlash($prefix.'warning')):?>
    <div class="alert alert-warning view-flash">
        <p>
            <span><?php echo Yii::app()->user->getFlash($prefix.'warning');?></span>
        </p>
    </div>
<?php endif;?>
<?php
//Yii::app()->clientScript->registerScript('flash-hide', "
//    setTimeout(function(){
//        $('.view-flash').fadeOut(function(){
//            $('.view-flash').remove();
//        });
//    }, 5000);
//", CClientScript::POS_READY);