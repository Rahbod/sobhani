<div class="footer">
    <div class="container">
        <a href="<?= Yii::app()->getBaseUrl(true)?>">
            <img src="<?= Yii::app()->theme->baseUrl ?>/svg/logo.jpg" class="logo">
        </a>
        <ul class="list-unstyled">
            <li>
                <span><a href="<?= $this->createAbsoluteUrl('/terms') ?>">شرایط</a></span>
                | <span><a href="<?= $this->createAbsoluteUrl('/faq') ?>">سوالات متداول</a></span>
                | <span><a href="<?= $this->createAbsoluteUrl('/about') ?>">درباره ما</a></span>
            </li>
            <li>&copy; TheTopTens 2005-2017 &reg; کلیه حقوق محفوظ است.</li>
        </ul>
        <ul class="navbar-social">
            <li>
                <a href="<?= $this->socialLinks['facebook']?>">
                    <i class="facebook-icon"></i>
                </a>
            </li>
            <li>
                <a href="<?= $this->socialLinks['google']?>">
                    <i class="google-icon"></i>
                </a>
            </li>
            <li>
                <a href="<?= $this->socialLinks['telegram']?>">
                    <i class="telegram-icon"></i>
                </a>
            </li>
        </ul>
    </div>
</div>