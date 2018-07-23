<?php
$scl = SiteSetting::getOption('social_links')?:null;
if($scl):
$scl = CJSON::decode($scl, false);
//$tw = $scl->twitter;
$fb = $scl->facebook;
$tl = $scl->telegram;
$in = $scl->instagram;
$gl = $scl->google;
?>
<div class="social-networks">
    <div class="social-icons">
        <?php if($tl): ?><a target="_blank" class="pull-left" href="<?= $tl; ?>"><span class="svg-icons telegram-icon grayscale"></span></a><?php endif; ?>
        <?php if($fb): ?><a target="_blank" class="pull-left" href="<?= $fb; ?>"><span class="svg-icons facebook-icon grayscale"></span></a><?php endif; ?>
        <?php if($in): ?><a target="_blank" class="pull-left" href="<?= $in; ?>"><span class="svg-icons instagram-icon grayscale"></span></a><?php endif; ?>
        <?php if($gl): ?><a target="_blank" class="pull-left" href="<?= $gl; ?>"><span class="svg-icons google-icon grayscale"></span></a><?php endif; ?>
    </div>
</div>
<?php
endif;