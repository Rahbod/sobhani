<?php
/**
 * @var $this Controller
 * @var $cs CClientScript
 * @var $baseUrl string
 * @var $slider Lists[]
 * @var $lastEvents UserNotifications[]
 */
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl . '/css/owl.carousel.css');
$cs->registerCssFile($baseUrl . '/css/owl.theme.default.min.css');
$cs->registerScriptFile($baseUrl . '/js/owl.carousel.min.js');
$listPath = Yii::getPathOfAlias('webroot') . '/uploads/lists/thumbs/200x200/';
$listUrl = Yii::app()->getBaseUrl(true) . '/uploads/lists/thumbs/200x200/';

$listItemPath = Yii::getPathOfAlias('webroot') . '/uploads/items/thumbs/150x150/';
$listItemUrl = Yii::app()->getBaseUrl(true) . '/uploads/items/thumbs/150x150/';
?>
<div class="slider">
    <h1><?= Controller::parseNumbers(number_format($count)) ?>&nbsp;لیست از بهترین ها براساس رای شما</h1>
    <div class="is-carousel" data-items="7" data-item-selector="thumbnail-container" data-margin="10" data-dots="1"
         data-nav="1" data-mouse-drag="1"
         data-responsive='{"1920":{"items":"7"},"1200":{"items":"6"},"992":{"items":"5"},"768":{"items":"3"},"480":{"items":"2"},"0":{"items":"1"}}'>
        <?php
        foreach ($slider as $item):
            ?>
            <div class="thumbnail-container">
                <div class="thumbnail">
                    <a href="<?= $this->createUrl('/lists/' . $item->id . '/' . str_replace(' ', '-', $item->title)) ?>" title="<?= $item->title ?>">
                        <img src="<?= $listUrl . $item->getImage() ?>" alt="<?= $item->title ?>" title="<?= $item->title ?>">
                        <div class="overlay">
                            <h3><?= $item->title ?></h3>
                        </div>
                    </a>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="box-search">

        <?php echo CHtml::beginForm(array('/search'), 'get'); ?>
        <div class="input-group">
            <?php echo CHtml::textField('term', isset($_GET['term']) ? $_GET['term'] : '', array('class' => 'form-control', 'placeHolder' => 'جستجوی بهترین ...')) ?>
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="submit">
                    <i class="glyphicon"></i>
                </button>
            </span>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 left-side">
            <div class="context" style="min-height: 145px;">
                <div class="newlist add-new-masoud" style="min-height: 145px;margin-bottom: 0;padding-left: 15px;">
                    <i>"۱۰ بهترین" مکانی برای معرفی و انتخاب بهترین ها</i>
                    <h2><strong>
                        <a class="typewrite" data-period="1000" data-type='[
                        "محبوبترین باشگاه های فوتبال...",
                        "دیدنی ترین مکان های گردشگری استان...",
                        "۱۰ برترین آهنگ خواننده معروف...",
                        "برترین فیلم های کارگردان بزرگ سینما...",
                        "۵ بهترین خواننده پاپ دهه ۶۰...",
                        "بهترین اپلیکشن های ویرایش تصاویر...",
                        "معتبرترین شرکتهای ارائه دهنده..."
                        ]'>
                            <span class="wrap"></span>
                        </a>
                    </strong></h2>
                    <span>شما نیز می توانید لیست دلخواه خود را ایجاد کنید:</span>
                    <div style="margin-top: 20px;"><a href="/new" class="btn btn-info btn-lg">ایجاد لیستی از بهترین ها</a></div>
                    <script>
                        var TxtType = function(el, toRotate, period) {
                            this.toRotate = toRotate;
                            this.el = el;
                            this.loopNum = 0;
                            this.period = parseInt(period, 10) || 2000;
                            this.txt = '';
                            this.tick();
                            this.isDeleting = false;
                        };

                        TxtType.prototype.tick = function() {
                            var i = this.loopNum % this.toRotate.length;
                            var fullTxt = this.toRotate[i];

                            if (this.isDeleting) {
                                this.txt = fullTxt.substring(0, this.txt.length - 1);
                            } else {
                                this.txt = fullTxt.substring(0, this.txt.length + 1);
                            }

                            this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

                            var that = this;
                            var delta = 200 - Math.random() * 100;

                            if (this.isDeleting) { delta /= 2; }

                            if (!this.isDeleting && this.txt === fullTxt) {
                                delta = this.period;
                                this.isDeleting = true;
                            } else if (this.isDeleting && this.txt === '') {
                                this.isDeleting = false;
                                this.loopNum++;
                                delta = 500;
                            }

                            setTimeout(function() {
                                that.tick();
                            }, delta);
                        };

                        window.onload = function() {
                            var elements = document.getElementsByClassName('typewrite');
                            for (var i=0; i<elements.length; i++) {
                                var toRotate = elements[i].getAttribute('data-type');
                                var period = elements[i].getAttribute('data-period');
                                if (toRotate) {
                                    new TxtType(elements[i], JSON.parse(toRotate), period);
                                }
                            }
                            // INJECT CSS
                            var css = document.createElement("style");
                            css.type = "text/css";
                            css.innerHTML = ".typewrite > .wrap { border-left: 0.08em solid #888485}";
                            document.body.appendChild(css);
                        };
                    </script>
                </div>
            </div>
            <div class="context">
                <?php foreach ($this->getLatestLists(1) as $list): ?>
                    <div class="newlist">
                        <div class="multiimage">
                            <?php
                            $itemRel = $list->itemRel;
                            $item = $itemRel[0];
                            $i = 0;
                            while ($i < 3):
                                if ($item):
                                    if ($item->image && is_file($listItemPath . $item->image)):
                                        ?>
                                        <img src="<?= $listItemUrl . $item->image ?>"  alt="<?= $item->item->title ?>" title="<?= $item->item->title ?>">
                                    <?php
                                    endif;
                                endif;
                                $i++;
                                $item = isset($itemRel[$i]) ? $itemRel[$i] : null;
                            endwhile;
                            ?>
                        </div>
                        <i>لیست جدید</i>
                        <h2><strong><a href="<?= $this->createUrl('/lists/' . $list->id . '/' . str_replace(' ', '-', $list->title)) ?>"><?= $list->title ?></a></strong></h2>
                        <ol type="1">
                            <?php
                            $voteAvg = Votes::VoteAverages($list->id);
                            arsort($voteAvg);
                            ?>
                            <?php $i = 0;foreach($voteAvg as $key => $value):?>
                                <?php if($i < 3):?>
                                    <?php foreach($list->itemRel as $item):?>
                                        <?php if($item->item_id == $key):?>
                                            <li><?= $item->item->title ?></li>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                <?php endif;?>
                                <?php $i++?>
                            <?php endforeach;?>
                        </ol>
                        <b class="member list-item-view">
                            <?php if ($list->user_type == 'user'): ?>
                                <div class="user-image">
                                    <a href="<?= Yii::app()->createUrl('/users/public/viewProfile/' . $list->user->id . '/' . str_replace(' ', '-', $list->user->userDetails->getShowName())) ?>">
                                        <img class="asrc" src="<?= $list->user->userDetails->getAvatar() ?>"  alt="<?= $list->user->userDetails ? $list->user->userDetails->getShowName() : $list->user->email ?>" title="<?= $list->user->userDetails ? $list->user->userDetails->getShowName() : $list->user->email ?>">
                                        <small><?= $list->user->userDetails ? $list->user->userDetails->getShowName() : $list->user->email ?></small>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </b>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="events">
                <h2>در حال رخ دادن</h2>
                <input type="hidden" id="last-id" value="<?= $lastEvents[0]->id?>">
                <table id="feed" itemscope="5">
                    <tbody>
                    <?php foreach($lastEvents as $event):?>
                        <tr>
                            <td><i class="icon-check-sign"></i></td>
                            <td><?= $event->message?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="specials">
                <h2>لیست های ویژه</h2>
                <?php foreach ($this->getSpecialLists(6) as $list): ?>
                    <div class="feature-item">
                        <a href="<?= $list->getViewUrl() ?>"><img src="<?= $listUrl . $list->getImage() ?>" alt="<?= $list->title ?>" title="<?= $list->title ?>"></a>
                        <a href="<?= $list->getViewUrl() ?>"><h3 class="item-title"><?= $list->title ?></h3></a>
                        <p>
                            <?php
                            $txt = strip_tags($list->description);
                            echo mb_substr($txt, 0, 80, "UTF-8").(mb_strlen($txt)>80?"...":"");
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 right-side">
            <?php $this->renderPartial('//partial-views/_right_col'); ?>
            <div class="tren">
                <h4>ده لیست برتر</h4>
                <?php foreach ($this->getTopListBySeen() as $item): ?>
                    <div class="trending">
                        <a href="<?= $item->getViewUrl() ?>" title="<?= $item->title ?>"><img src="<?= $listUrl . $item->getImage() ?>" alt="<?= $item->title ?>" title="<?= $item->title ?>">
                        <?= $item->title ?></a>
                        <br>
                          <?= $item->seen ?>&nbsp;بازدید
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerScript("events", "
setInterval(function(){
    $.ajax({
        url: '".$this->createUrl('getLastEvents')."',
        type: 'POST',
        dataType: 'JSON',
        data: {lastID: $('.events #last-id').val()},
        success: function(data){
            if(data.status){
                for(i=0;i < data.items.length;i++){
                    $('.events table tr:last-child').remove();
                    $('.events table tbody').prepend('<tr><td><i class=\"icon-check-sign\"></i></td><td>'+data.items[i]+'</td></tr>');
                    $('.events #last-id').val(data.lastID);
                }
            }
        }
    });
}, 60000);
");?>