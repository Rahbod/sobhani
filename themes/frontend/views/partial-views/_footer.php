<div class="footer">
    <div class="container">
        <a href="<?= Yii::app()->getBaseUrl(true)?>">
            <img src="<?= Yii::app()->theme->baseUrl ?>/svg/logo-gray.svg" class="logo">
        </a>
        <ul class="list-unstyled">
            <li>
                <span><a href="<?= $this->createAbsoluteUrl('/terms') ?>">شرایط</a></span>
                | <span><a href="<?= $this->createAbsoluteUrl('/faq') ?>">سوالات متداول</a></span>
                | <span><a href="<?= $this->createAbsoluteUrl('/about') ?>">درباره</a></span>
                | <span><a href="<?= $this->createAbsoluteUrl('/contactUs') ?>">تماس</a></span>
            </li>
            <li>کلیه حقوق برای 10 بهترین محفوظ است.</li>
        </ul>
        <ul class="navbar-social">
            <li>
                <a href="<?= $this->socialLinks['facebook']?>">
                    <i class="facebook-icon"></i>
                </a>
            </li>
<!--            <li>-->
<!--                <a href="--><?//= $this->socialLinks['google']?><!--">-->
<!--                    <i class="google-icon"></i>-->
<!--                </a>-->
<!--            </li>-->
            <li>
                <a href="<?= $this->socialLinks['telegram']?>">
                    <i class="telegram-icon"></i>
                </a>
            </li>
        </ul>
    </div>
</div>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109783708-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-109783708-1');
</script>