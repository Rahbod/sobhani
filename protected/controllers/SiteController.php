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


        $criteria = new CDbCriteria();
        $criteria->addCondition(new CDbExpression("id NOT IN(SELECT id from ym_user_notifications where message like '%لیست شما%' OR message like '%مدیر%')"));
        $criteria->order = "id DESC";
        $criteria->limit = 5;
        $lastEvents = UserNotifications::model()->findAll($criteria);

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

    public function actionContact()
    {
        Yii::import('pages.models.*');
        Yii::app()->getModule('contact');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = new ContactForm();
        $page = Pages::model()->findByPk(5);
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            $contactModel = new ContactMessages();
            $contactModel->attributes = $_POST['ContactForm'];
            $dep = ContactDepartment::model()->findByPk($contactModel->department_id);
            if ($model->validate() && $contactModel->save()) {
                $siteName = Yii::app()->name;
                $subject = 'وبسايت 10 بهترین - پیغام در بخش ' . $dep->title . ($model->subject && !empty($model->subject) ? ' - ' . $model->subject : '');
                $body = "<div style='padding:15px;white-space: pre-line'>"
                    . "<p>متن پیام:</p>"
                    . "<p>" . $model->body . "</p>"
                    . "<p>"
                    . "<strong>نام فرستنده : </strong>" . $model->name . "<br>"
                    . "<strong>شماره تماس : </strong>" . $model->tel
                    . "</p><br><br>
                    <p>"
                    . "<strong>برای ارسال پاسخ روی لینک زیر کلیک کنید: </strong><br>" .
                    CHtml::link(Yii::app()->createAbsoluteUrl('/contact/messages/view?id=' . $contactModel->id),
                        Yii::app()->createAbsoluteUrl('/contact/messages/view?id=' . $contactModel->id), array(
                            'style' => 'color:#1aa4de;font-size:12px'
                        ))
                    . "</p>
                    <hr>
                    <span style='font-size:10px'>
                    ارسال شده توسط وبسايت {$siteName}
                    </span>
                    </div>                  
                    ";
                $receivers = [];
                $receivers[] = SiteSetting::getOption('master_email');
                foreach ($contactModel->department->receivers as $receiver)
                    $receivers[] = $receiver->email;
                Mailer::mail($receivers, $subject, $body, $model->email);
                Yii::app()->user->setFlash('success', 'باتشکر. پیغام شما با موفقیت ارسال شد.');
                $this->refresh();
            }
        }

        $this->render('contact', array('model' => $model,'page' => $page));
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