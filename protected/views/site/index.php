<?php
/**
 * @var $this Controller
 * @var $cs CClientScript
 * @var $baseUrl string
 * @var $slider Tags[]
 */
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
$cs->registerCssFile($baseUrl.'/css/owl.theme.default.min.css');
$cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js');





?>
<div class="slider">
    <h1>128،699 ده فهرست برتر برای همه چیز تحت (و از جمله) خورشید است.</h1>
    <div class="is-carousel" data-items="7" data-item-selector="thumbnail-container" data-margin="10" data-dots="1" data-nav="0" data-mouse-drag="1" data-responsive='{"1920":{"items":"7"},"1200":{"items":"6"},"992":{"items":"5"},"768":{"items":"3"},"480":{"items":"2"},"0":{"items":"1"}}'>
        <?php
        foreach ($slider as $item):
        ?>
        <div class="thumbnail-container">
            <div class="thumbnail">
                <a href="#">
                    <?= $item->title ?>
                    <img src="<?= $baseUrl ?>/image/actors.jpg">
                </a>
            </div>
        </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="box-search">
        <form>
            <div class="input-group">
                <input id="search" type="text" class="form-control" name="search" maxlength="100" placeholder="اشتیاق شما چیست؟">
                <span class="input-group-addon"><i class="glyphicon"></i></span>
            </div>
        </form>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right-side">
            <div class="context">
                <ul class="nav nav-pills" id="pills-first">
                    <li class="active"><a data-toggle="tab" href="#home">ویژه</a></li>
                    <li class=""><a data-toggle="tab" href="#menu1">محبوب</a></li>
                    <li class=""><a data-toggle="tab" href="#menu2">آخرین</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <a href="#"> بهترین فیلم ها با بودجه کمتر از 5 میلیون دلار</a>
                        <a href="#"> اشتباهات صحنه در فیلم های معروف</a>
                        <a href="#">بهترین برندهای دوچرخه کوهستان</a>
                        <a href="#">بازی های ویدئویی 2017</a>
                        <a href="#">بهترین آهنگ های سال 2017</a>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <a href="#">بازی های ویدئویی 2017</a>
                        <a href="#">بهترین آهنگ های سال 2017</a>
                        <a href="#"> بهترین فیلم ها با بودجه کمتر از 5 میلیون دلار</a>
                        <a href="#"> اشتباهات صحنه در فیلم های معروف</a>
                        <a href="#">بهترین برندهای دوچرخه کوهستان</a>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <a href="#"> اشتباهات صحنه در فیلم های معروف</a>
                        <a href="#">بازی های ویدئویی 2017</a>
                        <a href="#"> بهترین فیلم ها با بودجه کمتر از 5 میلیون دلار</a>
                        <a href="#">بهترین آهنگ های سال 2017</a>
                        <a href="#">بهترین برندهای دوچرخه کوهستان</a>
                    </div>
                </div>
            </div>
            <div class="tren">
                <h4>ده فهرست برتر</h4>

                <div class="trending">
                    <img src="image/702.jpg">
                    <a href="#">بزرگترین افراد تمام وقت</a>
                    <br>
                    4596 تعامل اخیر
                </div>
                <div class="trending">
                    <img src="image/994.jpg">
                    <a href="#">بزرگترین رهبران تمام وقت</a>
                    <br>
                    215 تعامل اخیر
                </div>
                <div class="trending">
                    <img src="svg/logo32.jpg">
                    <a href="#">بزرگترین افراد هندی در تمام دوران</a>
                    <br>
                    60 تعامل اخیر
                </div>
                <div class="trending">
                    <img src="svg/logo32.jpg">
                    <a href="#">بیشترین صداهای آواز منحصر به فرد</a>
                    <br>
                    65 تعامل اخیر
                </div>
                <div class="trending">
                    <img src="image/51XZ2KNKZWL._SL160_.jpg">
                    <a href="#">بزرگترین افراد تمام وقت</a>
                    <br>
                    4596 تعامل اخیر
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 left-side">
            <div class="context">
                <div class="newlist">
                    <div class="multiimage">
                        <img src="image/1.jpg">
                        <img src="image/2.jpg">
                        <img src="image/3.jpg">
                    </div>
                    <i>لیست جدید</i>
                    <strong>
                        <a href="#">10 بازی ویدئویی که باید در یک نمایش تلویزیونی ساخته شوند</a>
                    </strong>
                    <ol type="1">
                        <li>نظارت</li>
                        <li>سرجام</li>
                        <li>بایوشاک</li>
                    </ol>
                    <b class="member">
                        <a>
                            <img class="asrc" src="https://avatars.thetoptens.com/sm/masoncarr2244.png">
                            masoud gharagozlo1370
                        </a>
                    </b>
                </div>
            </div>
            <h3>در حال رخ دادن</h3>
            <table id="feed" itemscope="5">
                <tbody>
                <tr feedid="36974454" style="display: table-row; opacity: 1;">
                    <td><img src="image/51XZ2KNKZWL._SL160_.jpg"></td>
                    <td> رای دادن به <b>هریما</b>در لیستی از<a>قویترین مبارز</a></td>
                </tr>
                <tr feedid="36974455" style="display: table-row; opacity: 1;">
                    <td><i class="g"></i></td>
                    <td> نظر جدید در مورد  <b> بهمن</b> در فهرست <a> بهترین برندهای سیگار </a>
                        <br>&quot من بهمن دوودووال را دوست دارم چون کوچک است.</td>
                </tr>
                <tr feedid="36974456" style="display: table-row; opacity: 1;">
                    <td><img src="image/702.jpg"></td>
                    <td> رای دادن به <b>گورو ناناک</b>در فهرست <a href="#">بزرگترین افراد تمام وقت</a></td>
                </tr>
                <tr feedid="36974457" style="display: table-row; opacity: 1;">
                    <td><img src="image/994.jpg"></td>
                    <td>  رای دادن به <b>لورنس</b>در لیست <a href="#">بهترین رقصنده های هندی</a></td>
                </tr>
                <tr feedid="36974458" style="display: table-row; opacity: 1;">
                    <td><i class="g"></i></td>
                    <td>  رای دادن به <b> اش</b> در لیستی از <a href="#">ده شخصیت خنده دار محبوب</a></td>
                </tr>
                </tbody>
            </table>
            <h3>لیست های ویژه</h3>
            <div class="feature-item">
                <img src="image/online.jpg">
                <p>
                    <b><a href="#">نکاتی برای توقف امن آنلاین</a></b>
                    طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.
                </p>
            </div>
            <div class="feature-item">
                <img src="image/essay-writing.jpg">
                <p>
                    <b><a href="#">بهترین خدمات نوشتن مقاله</a></b>
                    طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.
                </p>
            </div>
            <br class="all">
            <div class="feature-item">
                <img src="image/call-of-duty.jpg">
                <p>
                    <b><a href="#">بهترین بازی Call of Duty</a></b>
                    طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.
                </p>
            </div>
            <div class="feature-item">
                <img src="image/car-insurance.jpg">
                <p>
                    <b><a href="#">بهترین شرکت های بیمه خودرو</a></b>
                    طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.
                </p>
            </div>
            <br class="all">
            <div class="feature-item">
                <img src="image/home-security.jpg">
                <p>
                    <b><a href="#">بهترین شرکت های سیستم امنیتی خانه</a></b>
                    طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود.
                </p>
            </div>
        </div>
    </div>
</div>