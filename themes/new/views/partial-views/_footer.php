<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a class="d-block" href="#">
                    <img src="<?= Yii::app()->theme->baseUrl.'/media/images/public/site_logo.png' ?>"
                         class="siteLogo__image img-fluid" alt="بهترین ها به انتخاب من و تو">
                </a>
            </div>
            <div class="col-12">
                <div class="d-block d-md-flex justify-content-between">
                    <div class="pull-right h-100 mb-3 mb-md-0">
                        <a class="mt-2 d-block footer_logoTitle" href="#">
                            بهترین ها به انتخاب من و تو
                        </a>
                        <ul class="clearfix p-0 footer_menu">
                            <li><a href="<?= $this->createUrl('/lists') ?>">لیست ها</a></li>
                            <li><a href="<?= $this->createUrl('/about') ?>">در باره</a></li>
                            <li><a href="<?= $this->createUrl('/terms') ?>">قوانین و شرایط</a></li>
                            <li><a href="<?= $this->createUrl('/contact') ?>">تماس</a></li>
                        </ul>
                    </div>
                    <div class="pull-left">
                        <div class="footer__social social">
                            <a href="void:;"><img src="<?= Yii::app()->theme->baseUrl.'/media/images/public/_telegram_1021226.png' ?>" alt=""></a>
                            <a href="void:;"><img src="<?= Yii::app()->theme->baseUrl.'/media/images/public/twitter-(1).png' ?>" alt=""></a>
                            <a href="void:;"><img src="<?= Yii::app()->theme->baseUrl.'/media/images/public/facebook-logo-button.png' ?>" alt=""></a>
                        </div>
                        <p class="footer_copyRight">تمامی حقوق مادی و معنوی این سایت محفوظ است</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>