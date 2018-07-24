<?php

class AdminsDashboardController extends Controller
{
    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index'
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - index', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        Yii::app()->getModule('contact');
        Yii::app()->getModule('lists');
        Yii::app()->getModule('comments');

        $commentCriteria = new CDbCriteria();
        $commentCriteria->compare('t.status', Comment::STATUS_NOT_APPROWED);

        $messagesCriteria = new CDbCriteria();
        $messagesCriteria->compare('t.seen', 0);

        $statistics = [
            'comments' => Comment::model()->count($commentCriteria),
            'messages' => ContactMessages::model()->count($messagesCriteria),
        ];

        $criteria = new CDbCriteria();
        $criteria->addCondition('status = :status');
        $criteria->params[':status'] = ListItemRel::STATUS_PENDING;
        $newItemsProvider = new CActiveDataProvider('ListItemRel', ['criteria' => $criteria]);


        $lists = new Lists('search');
        $lists->unsetAttributes();  // clear any default values
        if (isset($_GET['Lists']))
            $lists->attributes = $_GET['Lists'];

        $this->render('index', compact('statistics', 'newItemsProvider', 'lists'));
    }
}