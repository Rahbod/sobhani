<?
/* @var $this Controller*/
?>
<div class="context">
    <ul class="nav nav-pills" id="pills-first">
        <li class="active"><a data-toggle="tab" href="#home">ویژه</a></li>
        <li class=""><a data-toggle="tab" href="#menu1">محبوب</a></li>
        <li class=""><a data-toggle="tab" href="#menu2">آخرین</a></li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <?php foreach($this->getSpecialLists() as $list): ?>
                <a href="<?= $list->getViewUrl() ?>"><?= $list->title ?></a>
            <?php endforeach; ?>
        </div>
        <div id="menu1" class="tab-pane fade">
            <?php foreach($this->getPopularLists() as $list): ?>
                <a href="<?= $list->getViewUrl() ?>"><?= $list->title ?></a>
            <?php endforeach; ?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <?php foreach($this->getLatestLists() as $list): ?>
                <a href="<?= $list->getViewUrl() ?>"><?= $list->title ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>