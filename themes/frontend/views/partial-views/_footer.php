<footer class="footer">
    <div class="footerContainer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a class="d-block" title="<?= Yii::app()->name ?>"
                       href="<?= Yii::app()->getBaseUrl(true) ?>">
                        <img src="<?= Yii::app()->theme->baseUrl . '/assets/media/images/public/site_logo.png' ?> "
                             class="siteLogo__image img-fluid"
                             alt="<?= Yii::app()->name ?>">
                    </a>
                </div>
                <div class="col-12">
                    <div class="d-block d-md-flex justify-content-between">
                        <div class="pull-right h-100 mb-3 mb-md-0">
                            <a class="d-block footer_logoTitle"
                               href="<?= Yii::app()->getBaseUrl(true) ?>" style="margin-top: 10px;">
                                <?= Yii::app()->name ?>
                            </a>
                            <ul class="clearfix p-0 footer_menu">
                                <li><a href="<?= $this->createAbsoluteUrl('/lists') ?>">لیست ها</a></li>
                                <li><a href="<?= $this->createAbsoluteUrl('/about') ?>">در باره</a></li>
                                <li><a href="<?= $this->createAbsoluteUrl('/terms') ?>">قوانین و شرایط</a></li>
                                <li><a href="<?= $this->createAbsoluteUrl('/contact') ?>">تماس</a></li>
                            </ul>
                        </div>
                        <div class="pull-left">
                            <?php $this->renderPartial("//partial-views/_socials"); ?>

                            <p class="footer_copyRight">تمامی حقوق مادی و معنوی این سایت محفوظ است</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center" style="background: #292828;">
        <div class="container">
            <a style="color: #e2e2e2; font-weight: 400;" href="http://rahbod.com" target="_blank"
               title="طراحی و پیاده سازی شده توسط گروه برنامه نویسی رهبد" class="rahbod">
                طراحی و پیاده سازی شده توسط گروه برنامه نویسی رهبد
                <img width="100" height="40" src="<?= Yii::app()->theme->baseUrl . '/svg/rahbod.svg' ?>" alt="Rahbod"
                     title="Rahbod">
            </a>
        </div>
    </div>
</footer>


<!---->
<!--<div style="position:absolute;opacity: 0;width: 0;height: 0;visibility: hidden;">-->
<!--    <div id="histats_counter"></div>-->
<!--    <script type="text/javascript">var _Hasync = _Hasync || [];-->
<!--        _Hasync.push(['Histats.start', '1,4042275,4,511,95,18,00000000']);-->
<!--        _Hasync.push(['Histats.fasi', '1']);-->
<!--        _Hasync.push(['Histats.track_hits', '']);-->
<!--        (function () {-->
<!--            var hs = document.createElement('script');-->
<!--            hs.type = 'text/javascript';-->
<!--            hs.async = true;-->
<!--            hs.src = ('//s10.histats.com/js15_as.js');-->
<!--            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);-->
<!--        })();-->
<!--    </script>-->
<!--    <noscript><a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?4042275&101" alt="" border="0"></a>-->
<!--    </noscript>-->
<!--</div>-->

<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109783708-1"></script>-->
<!--<script>-->
<!--    window.dataLayer = window.dataLayer || [];-->
<!---->
<!--    function gtag() {-->
<!--        dataLayer.push(arguments);-->
<!--    }-->
<!---->
<!--    gtag('js', new Date());-->
<!---->
<!--    gtag('config', 'UA-109783708-1');-->
<!--</script>-->
