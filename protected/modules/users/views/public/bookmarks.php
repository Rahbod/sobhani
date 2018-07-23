<?php
/* @var $this UsersPublicController */
/* @var $bookmarks UserBookmarks[] */

$path = Yii::getPathOfAlias('webroot').'/uploads/lists/';
$url = Yii::app()->getBaseUrl(true).'/uploads/lists/thumbs/200x200/';
$this->breadcrumbs = array(
    'داشبورد' => array('/dashboard'),
    'علاقه مندی ها'
);
?>
<h2>علاقه مندی ها</h2>
<div class="recommend">
    <div class="alert alert-success view-alert hidden">
        <p>
            <span>خودرو با موفقیت از پارکینگ شما خارج شد.</span>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </p>
    </div>
    <?php foreach($bookmarks as $data): $data = $data->list;?>
        <div class="list-item col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="<?= $data->getViewUrl()?>">
                <?php if($data->image && is_file($path.$data->image)): ?><img src="<?= $url.$data->image?>" alt="<?= $data->title ?>" title="<?= $data->title ?>"><?php else: ?><img src="<?= Yii::app()->theme->baseUrl.'/image/no-image.png' ?>" alt="<?= $data->title ?>" title="<?= $data->title ?>"><?php endif; ?>
                <?= $data->title ?>
            </a>
            <div>
                <?php
                echo CHtml::ajaxLink('<small>حذف از علایق</small>',array('/lists/public/authJson'),array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'data' => array('method' => 'bookmark','hash'=>base64_encode($data->id)),
                    'beforeSend' => 'js: function(data){
                        $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                    }',
                    'success' => 'js: function(data){
                        article.find(\'.loading-container\').show();
                        if(data.status){
                            article.remove();
                            $(".view-alert").addClass("alert-success").find("span").text(data.message);
                        }
                        else{
                            $(".view-alert").addClass("alert-warning").find("span").text(data.message);  
                        }
                        $(".view-alert").removeClass("hidden");
                    }'
                ),array('class' => 'remove-bookmark text-danger'));
                ?>
            </div>
        </div>
    <?php endforeach;?>
</div>

<script>
    var article;
    $(function () {
        $('body').on("click",".remove-bookmark", function () {
            article = $(this).parents(".list-item");
        });
    })
</script>