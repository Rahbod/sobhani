<?php
$scl = SiteSetting::getOption('social_links')?:null;
if($scl):
$scl = CJSON::decode($scl, false);
$tw = $scl->twitter;
$fb = $scl->facebook;
$tl = $scl->telegram;
?>
<div class="footer__social social">
    <?php if($tl): ?><a href="<?= $tl?>"><img src="<?= Yii::app()->theme->baseUrl.'/media/images/public/_telegram_1021226.png' ?>"></a><?php endif;?>
    <?php if($tw): ?><a href="<?= $tw?>"><img src="<?= Yii::app()->theme->baseUrl.'/media/images/public/twitter-(1).png' ?>"></a><?php endif;?>
    <?php if($fb): ?><a href="<?= $fb?>"><img src="<?= Yii::app()->theme->baseUrl.'/media/images/public/facebook-logo-button.png' ?>"></a><?php endif;?>
</div>
<?php
endif;