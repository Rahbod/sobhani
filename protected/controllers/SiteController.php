<?php

class SiteController extends Controller
{
    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'index',
                'error',
                'contact',
                'about',
                'terms',
                'contactUs',
                'help',
                'testMail'
            )
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&views=FileName
            'page' => array(
                'class' => 'CViewAction',
            )
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        Yii::app()->theme = "frontend";
        $this->layout = "public";

        $criteria = new CDbCriteria();
        $criteria->compare('status', Lists::STATUS_APPROVED);
        $criteria->order = 'seen DESC';
        $criteria->limit = 10;
        $slider = Lists::model()->findAll($criteria);
        $count = Lists::model()->count($criteria);

        $lastEvents = UserNotifications::model()->findAll(['limit' => 5, 'order' => 'id DESC']);

        $this->render('index', compact('slider', 'count', 'lastEvents'));
    }

    public function actionGetLastEvents()
    {
        if (isset($_POST['lastID'])) {
            $lastID = $_POST['lastID'];
            /* @var UserNotifications[] $events */
            $criteria = new CDbCriteria();
            $criteria->limit = 5;
            $criteria->order = 'id DESC';
            $criteria->addCondition('id > :lastID');
            $criteria->params[':lastID'] = $lastID;
            $events = UserNotifications::model()->findAll($criteria);
            if ($events) {
                $items = [];
                foreach ($events as $event)
                    $items[] = $event->message;
                echo CJSON::encode([
                    'status' => true,
                    'items' => $items,
                    'lastID' => $events[0]->id,
                ]);
                Yii::app()->end();
            }
            echo CJSON::encode([
                'status' => false
            ]);
            Yii::app()->end();
        }
        return null;
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/error';
        if($error = Yii::app()->errorHandler->error){
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionAbout()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = Pages::model()->findByPk(1);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionTerms()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = Pages::model()->findByPk(3);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionContactUs()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = Pages::model()->findByPk(5);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionHelp()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = Pages::model()->findByPk(2);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionFaq()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = Pages::model()->findByPk(4);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionTestMail()
    {
        Yii::app()->theme = 'frontend';
        $this->layout ='xxx';
        $this->render('//layouts/_mail_theme');
    }
}