<?php

class UsersPublicController extends Controller
{
    public $avatarPath = 'uploads/users';

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'dashboard',
                'logout',
                'changePassword',
                'verify',
                'forgetPassword',
                'recoverPassword',
                'authCallback',
                'transactions',
                'index',
                'ResendVerification',
                'profile',
                'upload',
                'deleteUpload',
                'viewProfile',
                'login',
                'captcha',
                'lists',
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess + dashboard, setting, transactions, upgradePlan, buyPlan',
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x7e55a1,
                'height' => 36,
                'minLength' => 7,
                'maxLength' => 7,
                'padding' => 0,
                'offset' => -1,
                'testLimit' => 1
            ),
            'upload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'uploadDir' => '/uploads/users/avatar',
                'attribute' => 'avatar',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('jpg','jpeg','png')
                ),
                'insert' => true,
                'module' => 'users',
                'modelName' => 'UserDetails',
                'findAttributes' => 'array("user_id" => $_POST["user_id"])',
                'scenario' => 'upload_photo',
                'storeMode' => 'field',
                'afterSaveActions' => array(
                    'resize' => array('width'=>500,'height'=>500)
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'UserDetails',
                'attribute' => 'avatar',
                'uploadDir' => '/uploads/users/avatar',
                'storedMode' => 'field'
            ),
        );
    }

    /**
     * Logout Action
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        Yii::app()->user->setState('clinic',null);
        $this->redirect(Yii::app()->createAbsoluteUrl('//'));
    }

    /**
     * Dashboard Action
     */
    public function actionDashboard()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        /* @var $user Users */
        $user = Users::model()->findByPk(Yii::app()->user->id);

        $lists = new Lists('search');
        $lists->unsetAttributes();
        if(isset($_GET['Lists']))
            $lists->attributes = $_GET['Lists'];
        $lists->user_type = 'user';
        $lists->user_id = $user->id;

        $this->pageTitle = 'پروفایل من';
        $this->render('dashboard', compact('user', 'lists'));
    }

    /**
     * Change password
     */
    public function actionChangePassword()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = Users::model()->findByPk(Yii::app()->user->getId());
        $this->pageTitle = 'تغییر کلمه عبور';
        $this->pageHeader = 'تغییر کلمه عبور';
        $this->pageDescription = 'جهت تغییر کلمه عبور فرم زیر را تکمیل فرمایید.';
        $model->setScenario('change_password');

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->password = $_POST['Users']['newPassword'];
                $model->password = $model->encrypt($model->password);
                if ($model->save(false)) {
                    Yii::app()->user->setFlash('success', 'کلمه عبور با موفقیت تغییر یافت.');
                    $this->redirect($this->createUrl('/dashboard'));
                } else
                    Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

        $this->render('change_password', array(
            'model' => $model,
        ));
    }

    /**
     * Change profile data
     */
    public function actionProfile()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';

        /* @var $user Users */
        $user = Users::model()->findByPk(Yii::app()->user->id);
        $this->pageTitle = 'پروفایل من';
        $this->pageHeader = 'تغییر مشخصات پروفایل';
        $this->pageDescription = 'جهت تغییر اطلاعات حساب کاربری خود فرم زیر را پر کنید.';

        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
        $avatarDIR = Yii::getPathOfAlias("webroot") . '/uploads/users/avatar/';
        if(!is_dir($avatarDIR))
            mkdir($avatarDIR);
        $avatarUrl = Yii::app()->createAbsoluteUrl('/uploads/users/avatar');

        /* @var $model UserDetails */
        $model = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));

        $this->performAjaxValidation($model);

        $avatar = array();
        if (!is_null($model->avatar))
            $avatar = array(
                'name' => $model->avatar,
                'src' => $avatarUrl . '/' . $model->avatar,
                'size' => strpos($model->avatar, 'https://') === 0 ? null : filesize($avatarDIR . $model->avatar),
                'serverName' => $model->avatar
            );

        if (isset($_POST['UserDetails'])) {
            unset($_POST['UserDetails']['user_id']);

            $avatarFlag = false;
            if (isset($_POST['UserDetails']['avatar']) && file_exists($tmpDIR . $_POST['UserDetails']['avatar']) && $_POST['UserDetails']['avatar'] != $model->avatar) {
                $file = $_POST['UserDetails']['avatar'];
                $avatar = array(array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file
                ));
                $avatarFlag = true;
            }

            $model->attributes = $_POST['UserDetails'];
            if ($model->save()) {
                if ($avatarFlag) {
                    @rename($tmpDIR . $model->avatar, $avatarDIR . $model->avatar);
                    Yii::app()->user->setState('avatar', $model->avatar);
                }

                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->refresh();
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('profile', array(
            'model' => $model,
            'avatar' => $avatar,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewProfile($id)
    {
        if(Yii::app()->user->getId() == $id)
            $this->redirect(['/dashboard']);

        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';

        $model = Users::model()->findByPk($id);

        $lists = new Lists('search');
        $lists->unsetAttributes();
        if(isset($_GET['Lists']))
            $lists->attributes = $_GET['Lists'];
        $lists->user_type = 'user';
        $lists->user_id = $model->id;
        $lists->status = Lists::STATUS_APPROVED;

        $this->render('view-profile', array(
            'model' => $model,
            'lists' => $lists,
        ));
    }

    /**
     * Verify email
     */
    public function actionVerify()
    {
        if (!Yii::app()->user->isGuest and Yii::app()->user->type != 'admin')
            $this->redirect($this->createAbsoluteUrl('//'));
        else if (!Yii::app()->user->isGuest and Yii::app()->user->type == 'admin')
            Yii::app()->user->logout(false);

        $token = Yii::app()->request->getQuery('token');
        $model = Users::model()->find('verification_token=:token', array(':token' => $token));
        if ($model) {
            if ($model->status == 'pending') {
                if (time() <= (double)$model->create_date + 259200) {
                    $model->updateByPk($model->id, array('status' => 'active'));
                    Yii::app()->user->setFlash('success', 'حساب کاربری شما فعال گردید.');
                    $login = new UserLoginForm('OAuth');
                    $login->verification_field_value = $model->email;
                    $login->OAuth = true;
                    if ($login->validate() && $login->login(true) === true)
                        $this->redirect(array('/dashboard'));
                    $this->redirect($this->createUrl('/login'));
                } else {
                    Yii::app()->user->setFlash('failed', 'لینک فعال سازی منقضی شده و نامعتبر می باشد. لطفا مجددا ثبت نام کنید.');
                    $this->redirect($this->createUrl('/login'));
                }
            } elseif ($model->status == 'active') {
                Yii::app()->user->setFlash('failed', 'این حساب کاربری قبلا فعال شده است.');
                $this->redirect($this->createUrl('/login'));
            } else {
                Yii::app()->user->setFlash('failed', 'امکان فعال سازی این کاربر وجود ندارد. لطفا مجددا ثبت نام کنید.');
                $this->redirect($this->createUrl('/login'));
            }
        } else {
            Yii::app()->user->setFlash('failed', 'لینک فعال سازی نامعتبر می باشد.');
            $this->redirect($this->createUrl('/login'));
        }
    }

    /**
     * Forget password
     */
    public function actionForgetPassword()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        if (!Yii::app()->user->isGuest and Yii::app()->user->type != 'admin')
            $this->redirect($this->createAbsoluteUrl('//'));
        else if (!Yii::app()->user->isGuest and Yii::app()->user->type == 'admin')
            Yii::app()->user->logout(false);

        $model = new UsersForgetPassword;
        if (isset($_POST['UsersForgetPassword'])) {
            $model->attributes = $_POST['UsersForgetPassword'];
            if ($model->isRegistereduser()) {
                $model = Users::model()->find("`email`=:email", array(":email" => $model->email));
                if ($model->status == 'active') {
                    if ($model->change_password_request_count != 3) {
                        $token = md5($model->id . '#' . $model->password . '#' . $model->email . '#' . $model->create_date . '#' . time());
                        $count = intval($model->change_password_request_count);
                        $model->updateByPk($model->id, array('verification_token' => $token, 'change_password_request_count' => $count + 1));
                        $message = '<div style="color: #2d2d2d;font-size: 14px;text-align: right;">با سلام<br>بنا به درخواست شما جهت تغییر کلمه عبور لینک زیر خدمتتان ارسال گردیده است.</div>';
                        $message .= '<div style="text-align: right;font-size: 9pt;">';
                        $message .= '<a href="' . Yii::app()->getBaseUrl(true) . '/users/public/recoverPassword/token/' . $token . '">' . Yii::app()->getBaseUrl(true) . '/users/public/recoverPassword/token/' . $token . '</a>';
                        $message .= '</div>';
                        $message .= '<div style="font-size: 8pt;color: #888;text-align: right;">اگر شخص دیگری غیر از شما این درخواست را صادر نموده است، یا شما کلمه عبور خود را به یاد آورده‌اید و دیگر نیازی به تغییر آن ندارید، کلمه عبور قبلی/موجود شما همچنان فعال می‌باشد و می توانید از طریق <a href="' . ((strpos($_SERVER['SERVER_PROTOCOL'], 'https')) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/login">این صفحه</a> وارد حساب کاربری خود شوید.</div>';
                        $result = Mailer::mail($model->email, 'درخواست تغییر کلمه عبور در ' . Yii::app()->name, $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP']);
                        if ($result) {
                            if (isset($_GET['ajax'])) {
                                echo CJSON::encode(array('state' => 1, 'url' => Yii::app()->baseUrl,  'msg' => 'ایمیل بازیابی رمز عبور به پست الکترونیکی شما ارسال شد. لطفا Inbox و Spam پست الکترونیکی خود را چک کنید.'));
                                Yii::app()->end();
                            } else {
                                Yii::app()->user->setFlash('success', 'ایمیل بازیابی رمز عبور به پست الکترونیکی شما ارسال شد. لطفا Inbox و Spam پست الکترونیکی خود را چک کنید.');
                                $this->refresh();
                            }
                        } else
                        {
                            if (isset($_GET['ajax'])) {
                                echo CJSON::encode(array('state' => 0, 'msg' => 'در ارسال ایمیل مشکلی ایجاد شده است، لطفاً مجددا تلاش کنید.'));
                                Yii::app()->end();
                            } else {
                                Yii::app()->user->setFlash('failed', 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                                $this->refresh();
                            }
                        }
                    } else
                    {
                        if (isset($_GET['ajax'])) {
                            echo CJSON::encode(array('state' => 0, 'msg' => 'بیش از 3 بار نمی توانید درخواست تغییر کلمه عبور بدهید.'));
                            Yii::app()->end();
                        } else {
                            Yii::app()->user->setFlash('failed', 'بیش از 3 بار نمی توانید درخواست تغییر کلمه عبور بدهید.');
                            $this->refresh();
                        }
                    }
                } elseif ($model->status == 'pending')
                    $msg = 'این حساب کاربری هنوز فعال نشده است.';
                elseif ($model->status == 'blocked')
                    $msg = 'این حساب کاربری مسدود می باشد.';
                elseif ($model->status == 'deleted')
                    $msg = 'این حساب کاربری حذف شده است.';
            } else
                $msg = $model->getErrors('email');
            if (isset($_GET['ajax'])) {
                echo CJSON::encode(array('state' => 0, 'msg' => $msg));
                Yii::app()->end();
            } else
                Yii::app()->user->setFlash('failed', $msg);
        }

        if (!isset($_GET['ajax']))
            $this->render('forget_password');
    }

    /**
     * Change password
     */
    public function actionRecoverPassword()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';

        if (!Yii::app()->user->isGuest and Yii::app()->user->type != 'admin')
            $this->redirect($this->createAbsoluteUrl('//'));
        else if (!Yii::app()->user->isGuest and Yii::app()->user->type == 'admin')
            Yii::app()->user->logout(false);

        $token = Yii::app()->request->getQuery('token');
        $model = Users::model()->find('verification_token=:token', array(':token' => $token));

//        if (!$model)
//            $this->redirect($this->createAbsoluteUrl('//'));
//        elseif ($model->change_password_request_count == 0)
//            $this->redirect($this->createAbsoluteUrl('//'));

        $model->setScenario('recover_password');

        $this->performAjaxValidation($model);

        if ($model->status == 'active') {
            if (isset($_POST['Users'])) {
                $model->password = $_POST['Users']['password'];
                $model->repeatPassword = $_POST['Users']['repeatPassword'];
                $model->setScenario('recover-password');
                if($model->validate()){
                    $model->verification_token = null;
                    $model->change_password_request_count = 0;
                    $model->password = $model->encrypt($model->password);
                    if($model->save(false)){
                        Yii::app()->user->setFlash('success', 'کلمه عبور با موفقیت تغییر یافت.');
                        $this->redirect($this->createUrl('/login'));
                    }else
                        Yii::app()->user->setFlash('failed', 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                }
            }

            $this->render('recover_password', array(
                'model' => $model
            ));
        } else
            $this->redirect($this->createAbsoluteUrl('//'));
    }
    

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGoogleLogin()
    {
        if(isset($_GET['return-url']))
            Yii::app()->user->returnUrl = $_GET['return-url'];
        $googleAuth = new GoogleOAuth();
        $model = new UserLoginForm('OAuth');
        $googleAuth->login($model);
    }
    
    public function actionLogin()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';

        if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'user')
            $this->redirect($this->createAbsoluteUrl('//'));

        $model = new UserLoginForm;
        // Login codes
        if (isset($_GET['ajax']) && ($_GET['ajax'] === 'users-login-modal-form' || $_GET['ajax'] === 'users-login-form')) {
            $errors = CActiveForm::validate($model);
            if (CJSON::decode($errors)) {
                echo $errors;
                Yii::app()->end();
            }
        }
        // collect user input data
        if (isset($_POST['UserLoginForm'])) {
            $model->attributes = $_POST['UserLoginForm'];
            if(isset($_POST['returnUrl']))
                Yii::app()->user->returnUrl = $_POST['returnUrl'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                if (Yii::app()->user->returnUrl != Yii::app()->request->baseUrl . '/' &&
                    Yii::app()->user->returnUrl != 'logout')
                    $redirect = Yii::app()->user->returnUrl;
                else
                    $redirect = $this->createUrl('/dashboard');
                if (isset($_GET['ajax'])) {
                    echo CJSON::encode(array('status' => true, 'url' => $redirect, 'msg' => 'در حال انتقال ...'));
                    Yii::app()->end();
                } else
                    $this->redirect($redirect);
            } else
                $model->password = '';
        }
        // End of login codes
        if (!isset($_GET['ajax']))
            $this->render('login', array(
                'model' => $model,
            ));
    }

    public function actionRegister()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';

        $model = new Users('create');

        if (isset($_GET['ajax']) && $_GET['ajax'] === 'users-register-modal-form') {
            $errors = CActiveForm::validate($model);
            if (CJSON::decode($errors)) {
                echo $errors;
                Yii::app()->end();
            }
        }

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->status = 'pending';
            $model->create_date = time();
            $pwd = $model->password;
            $username = $model->email;
            if ($model->save()) {
                $token = md5($model->id . '#' . $model->password . '#' . $model->email . '#' . $model->create_date);
                $model->updateByPk($model->id, array('verification_token' => $token));
                $message = '<div style="color: #2d2d2d;font-size: 14px;text-align: right;">با سلام<br>برای فعال کردن حساب کاربری خود در ' . Yii::app()->name . ' بر روی لینک زیر کلیک کنید:</div>';
                $message .= '<div style="text-align: right;font-size: 9pt;">';
                $message .= '<a href="' . Yii::app()->getBaseUrl(true) . '/users/public/verify/token/' . $token . '">' . Yii::app()->getBaseUrl(true) . '/users/public/verify/token/' . $token . '</a>';
                $message .= '</div>';
                $message .= '<div style="font-size: 8pt;color: #888;text-align: right;">این لینک فقط 3 روز اعتبار دارد.</div>';
                Mailer::mail($model->email, 'ثبت نام در ' . Yii::app()->name, $message, Yii::app()->params['noReplyEmail'],Yii::app()->params['SMTP']);
                // Send Sms
                $siteName = Yii::app()->name;
                $message = "ثبت نام شما در سایت {$siteName} با موفقیت انجام شد.
نام کاربری: {$username}
کلمه عبور: {$pwd}";
                $phone = $model->userDetails->mobile;
//                if($phone)
//                    Notify::SendSms($message, $phone);
                if (isset($_GET['ajax'])) {
                    echo CJSON::encode(array('status' => true, 'msg' => 'ایمیل فعال سازی به پست الکترونیکی شما ارسال شد. لطفا Inbox و Spam پست الکترونیکی خود را چک کنید.'));
                    Yii::app()->end();
                } else
                    Yii::app()->user->setFlash('register-success', 'ایمیل فعال سازی به پست الکترونیکی شما ارسال شد. لطفا Inbox و Spam پست الکترونیکی خود را چک کنید.');
            } else {
                if (isset($_GET['ajax'])) {
                    echo CJSON::encode(array('status' => false, 'msg' => 'متاسفانه در ثبت نام مشکلی بوجود آمده است. لطفا مجددا سعی کنید.'));
                    Yii::app()->end();
                } else
                    Yii::app()->user->setFlash('register-failed', 'متاسفانه در ثبت نام مشکلی بوجود آمده است. لطفا مجددا سعی کنید.');
            }
        }

//        if (!isset($_GET['ajax']))
//            $this->render('register', array(
//                'model' => $model,
//            ));
    }

    public function actionResendVerification()
    {
        $email = Yii::app()->request->getQuery('email');
        if (!is_null($email)) {
            $model = Users::model()->find('email = :email', array(':email' => $email));
            $token = md5($model->id . '#' . $model->password . '#' . $model->email . '#' . $model->create_date);
            $model->updateByPk($model->id, array('verification_token' => $token));
            $message = '<div style="color: #2d2d2d;font-size: 14px;text-align: right;">با سلام<br>برای فعال کردن حساب کاربری خود در ' . Yii::app()->name . ' بر روی لینک زیر کلیک کنید:</div>';
            $message .= '<div style="text-align: right;font-size: 9pt;">';
            $message .= '<a href="' . Yii::app()->getBaseUrl(true) . '/users/public/verify/token/' . $token . '">' . Yii::app()->getBaseUrl(true) . '/users/public/verify/token/' . $token . '</a>';
            $message .= '</div>';
            $message .= '<div style="font-size: 8pt;color: #888;text-align: right;">این لینک فقط 3 روز اعتبار دارد.</div>';
            Mailer::mail($model->email, 'ثبت نام در ' . Yii::app()->name, $message, Yii::app()->params['noReplyEmail'],Yii::app()->params['SMTP']);
            Yii::app()->user->setFlash('success', 'ایمیل فعال سازی به پست الکترونیکی شما ارسال شد. لطفا Inbox و Spam پست الکترونیکی خود را چک کنید.');
            $this->redirect(array('/login'));
        } else
            $this->redirect(array('/site'));
    }

    /**
     * List all notifications
     */
    public function actionNotifications()
    {
        $this->layout = '//layouts/inner';
        Yii::app()->theme = 'frontend';
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=:user_id');
        $criteria->order = 'id DESC';
        $criteria->params = array(
            ':user_id' => Yii::app()->user->getId()
        );
        $model = UserNotifications::model()->findAll($criteria);
        UserNotifications::model()->updateAll(array('seen' => '1'), 'user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
        $this->render('notifications', array(
            'model' => $model
        ));
    }

    /**
     * List all bookmarked
     */
    public function actionBookmarks()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';

        $user = Users::model()->findByPk(Yii::app()->user->getId());
        /* @var $user Users */

        $this->render('bookmarks', array(
            'bookmarks' => $user->bookmarks
        ));
    }

    public function actionLists()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';

        $user = Users::model()->findByPk(Yii::app()->user->getId());
        /* @var $user Users */

        $model = new Lists('search');
        $model->unsetAttributes();
        if(isset($_GET['Lists']))
            $model->attributes = $_GET['Lists'];
        $model->user_type = 'user';
        $model->user_id = $user->id;

        $this->render('lists', array(
            'model' => $model
        ));
    }
}