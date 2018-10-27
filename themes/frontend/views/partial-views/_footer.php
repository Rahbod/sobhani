<div class="footer">
    <div class="container">
        <a href="<?= Yii::app()->getBaseUrl(true)?>">
            <img src="<?= Yii::app()->theme->baseUrl."/svg/logo-gray.svg" ?>" class="logo" alt="<?= Yii::app()->name ?>" title="<?= Yii::app()->name ?>">
        </a>
        <ul class="list-unstyled">
            <li>
                <span><a href="<?= $this->createAbsoluteUrl('/terms') ?>">شرایط</a></span>
                | <span><a href="<?= $this->createAbsoluteUrl('/about') ?>">درباره</a></span>
                | <span><a href="<?= $this->createAbsoluteUrl('/contact') ?>">تماس</a></span>
            </li>
            <li>کلیه حقوق برای 10 بهترین محفوظ است.</li>
        </ul>
        <?php $this->renderPartial("//partial-views/_socials"); ?>
        <div class="rahbod-container">
            <a href="http://rahbod.com" target="_blank" title="طراحی و پیاده سازی شده توسط رهبد" class="rahbod">
                <img src="<?= Yii::app()->baseUrl.'/themes/frontend/svg/rahbod.svg'?>"  alt="Rahbod" title="Rahbod">
            </a>
        </div>
    </div>
    <div style="position:absolute;opacity: 0;width: 0;height: 0;visibility: hidden;">
        <div id="histats_counter"></div>
<!--        <script type="text/javascript">var _Hasync= _Hasync|| [];-->
<!--            _Hasync.push(['Histats.start', '1,4042275,4,511,95,18,00000000']);-->
<!--            _Hasync.push(['Histats.fasi', '1']);-->
<!--            _Hasync.push(['Histats.track_hits', '']);-->
<!--            (function() {-->
<!--                var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;-->
<!--                hs.src = ('//s10.histats.com/js15_as.js');-->
<!--                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);-->
<!--            })();-->
<!--        </script>-->
        <!--    <noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4042275&101" alt="" border="0"></a></noscript>-->
    </div>
</div>
<!---->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109783708-1"></script>-->
<!--<script>-->
<!--    window.dataLayer = window.dataLayer || [];-->
<!--    function gtag(){dataLayer.push(arguments);}-->
<!--    gtag('js', new Date());-->
<!---->
<!--    gtag('config', 'UA-109783708-1');-->
<!--</script>-->