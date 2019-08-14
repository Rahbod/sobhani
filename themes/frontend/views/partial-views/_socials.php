<?php
$scl = SiteSetting::getOption('social_links') ?: null;
if ($scl):
    $scl = CJSON::decode($scl, false);
    $tw = $scl->twitter;
    $fb = $scl->facebook;
    $tl = $scl->telegram;
    ?>

    <div class="footer__social social">
        <?php if ($tl): ?>
        <a target="_blank" class="" href="<?= $tl; ?>">
                <img src="<?= Yii::app()->theme->baseUrl.'/assets/media/images/public/_telegram_1021226.png'?>"
                     alt="<?= Yii::app()->name ?>">
            </a><?php endif; ?>

        <?php if ($tw): ?>
        <a target="_blank" class="" href="<?= $tw; ?>">
            <img src="<?= Yii::app()->theme->baseUrl.'/assets/media/images/public/twitter-(1).png'?>"
                 alt="<?= Yii::app()->name ?>">
            </a><?php endif; ?>

        <?php if ($fb): ?>
        <a target="_blank" class="" href="<?= $fb; ?>">
            <img src="<?= Yii::app()->theme->baseUrl.'/assets/media/images/public/facebook-logo-button.png'?>"
                 alt="<?= Yii::app()->name ?>">
            </a><?php endif; ?>

    </div>

    <?php
endif;