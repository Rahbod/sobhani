<?php

class ListsCategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - view', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	* @return array actions type list
	*/
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'view', 'index', 'create', 'update', 'admin', 'delete'
			)
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ListCategories;

		if(isset($_POST['ListCategories']))
		{
			$model->attributes=$_POST['ListCategories'];
			$model->parent_id = empty($model->parent_id)?null:$model->parent_id;
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;لیست شما با موفقیت ثبت شد. این لیست پس از تایید کارشناسان بصورت عمومی نمایش داده خواهد شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['ListCategories']))
		{
			$model->attributes=$_POST['ListCategories'];
            $model->parent_id = empty($model->parent_id)?null:$model->parent_id;
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$imagePath = Yii::getPathOfAlias('webroot') . '/uploads/lists/';
		$itemImagePath = Yii::getPathOfAlias('webroot') . '/uploads/items/';
		$model = $this->loadModel($id);
		if($model->lists)
			foreach($model->lists as $list){
				@unlink($imagePath . $list->image);
				foreach($list->itemRel as $rel)
					@unlink($itemImagePath . $rel->image);
			}
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ListCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ListCategories']))
			$model->attributes=$_GET['ListCategories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ListCategories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ListCategories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ListCategories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='list-categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionView($id){
		Yii::app()->theme = 'new';
		$this->layout = '//layouts/inner';
		$model = $this->loadModel($id);
		$this->keywords = $model->getKeywords();
		$this->render('view', compact('model'));
	}
}
