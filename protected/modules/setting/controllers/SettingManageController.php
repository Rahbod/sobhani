<?php

class SettingManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $defaultAction = 'changeSetting';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'gatewaySetting',
				'changeSetting',
                'socialLinks'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess',
		);
	}

	/**
	 * Change site setting
	 */
    public function actionChangeSetting()
    {
        if(isset($_POST['SiteSetting'])){
            foreach($_POST['SiteSetting'] as $name => $value){
                if($name == 'keywords'){
                    $value = explode(',', $value);
                    SiteSetting::setOption($name, CJSON::encode($value));
                }else
                    SiteSetting::setOption($name, $value);
            }
            Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
            $this->refresh();
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('name NOT REGEXP \'\\([^\\)]*gateway_.*\\)\'');
        $model = SiteSetting::model()->findAll($criteria);
        $this->render('_general', array(
            'model' => $model
        ));
    }

    /**
	 * Change site setting
	 */
    public function actionSocialLinks(){
        $model = SiteSetting::getOption('social_links', false);
        if(isset($_POST['SiteSetting'])){
            foreach($_POST['SiteSetting']['social_links'] as $key => $link){
                if($link == '')
                    unset($_POST['SiteSetting']['social_links'][$key]);
                elseif(!preg_match("~^(?:f|ht)tps?://~i", $link))
                    $_POST['SiteSetting']['social_links'][$key] = 'http://' . $_POST['SiteSetting']['social_links'][$key];
            }
            if($_POST['SiteSetting']['social_links'])
                $social_links = CJSON::encode($_POST['SiteSetting']['social_links']);
            else
                $social_links = null;
            SiteSetting::setOption('social_links', $social_links, 'شبکه های اجتماعی');
            Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
            $this->refresh();
        }
        $this->render('_social_links',array(
            'model'=>$model
        ));
    }

    /**
     * Change gateway setting
     */
    public function actionGatewaySetting()
    {
        $gateway_active = SiteSetting::getOption('gateway_active', false);
        $gateway_variables = SiteSetting::getOption('gateway_variables', false);
        if(isset($_POST['SiteSetting'])){
            SiteSetting::setOption('gateway_active', $_POST['SiteSetting']['gateway_active']);
            SiteSetting::setOption('gateway_variables', CJSON::encode($_POST['SiteSetting']['gateway_variables']));
            Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
            $this->refresh();
        }
        $this->render('_gateway', array(
            'gateway_active' => $gateway_active,
            'gateway_variables' => $gateway_variables
        ));
    }
}
