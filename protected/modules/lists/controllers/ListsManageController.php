<?php

class ListsManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	public $tempPath = 'uploads/temp';
	public $imagePath = 'uploads/lists';
	public $itemImagePath = 'uploads/items';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess', // perform access control for CRUD operations
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
				'index', 'create', 'update', 'admin', 'delete', 'upload', 'deleteUpload', 'uploadItem', 'deleteUploadItem', 'changeStatus'
			)
		);
	}


	public function actions()
	{
		return array(
			'upload' => array( // list image upload
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'image',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('png', 'jpg', 'jpeg')
				)
			),
			'deleteUpload' => array( // delete list image uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'Lists',
				'attribute' => 'image',
				'uploadDir' => '/uploads/lists/',
				'storedMode' => 'field'
			),
			'deleteUploadItem' => array( // delete item image uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'ListItemRel',
				'attribute' => 'image',
				'uploadDir' => '/uploads/items/',
				'storedMode' => 'field'
			)
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Lists;

		$itemImages = [];
		if(isset($_POST['Lists'])){
			$model->attributes = $_POST['Lists'];
			$model->user_type = "admin";
			$model->user_id = Yii::app()->user->getId();
			$model->status = Lists::STATUS_APPROVED;
			$image = $model->image?new UploadedFiles($this->tempPath, $model->image, array(
				'thumbnail' => array(
					'width' => 200,
					'height' => 200
				),
				'resize' => array(
					'width' => 600,
					'height' => 400
				))):[];
			if($model->items){
				foreach($model->items as $key => $item){
					$itemImages[$key] = [];
					if(isset($item['image']))
						$itemImages[$key] = new UploadedFiles($this->tempPath, $item['image'], array(
							'thumbnail' => array(
								'width' => 200,
								'height' => 200
							),
							'resize' => array(
								'width' => 600,
								'height' => 400
							)));
				}
			}

			if($model->save()){
				$image->move($this->imagePath);

				// save item images
				foreach($model->items as $key => $item){
					if($itemImages[$key] instanceof UploadedFiles)
						$itemImages[$key]->move($this->itemImagePath);
				}

				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}
		$this->render('create', compact('model', 'itemImages', 'image'));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$image = new UploadedFiles($this->imagePath, ($model->image && is_file(Yii::getPathOfAlias('webroot').'/uploads/lists/'.$model->image)?$model->image:false), array(
			'thumbnail' => array(
				'width' => 200,
				'height' => 200
			),
			'resize' => array(
				'width' => 600,
				'height' => 400
			)));

		$oldItemImages = [];
		$itemImages = [];
		if($model->itemRel){
			foreach($model->itemRel as $key => $item){
				$oldItemImages[] = $item->image;
			}
		}

		if(isset($_POST['Lists'])){
			//
			$oldImage = $model->image;
			$model->attributes = $_POST['Lists'];
			if($model->items){
				foreach($model->items as $key => $item){
					if(isset($item['image']) && $oldItemImages[$key] != $item['image'])
						$itemImages[$key] = new UploadedFiles($this->tempPath, $item['image'], array(
							'thumbnail' => array(
								'width' => 200,
								'height' => 200
							),
							'resize' => array(
								'width' => 600,
								'height' => 400
							)));
					else
						$itemImages[$key] = [];
				}
			}
			$model->status = Lists::STATUS_APPROVED;
			if($model->save()){
				$image->update($oldImage,$model->image,$this->tempPath);

				// save item images
				foreach($model->items as $key => $item){
					if(isset($itemImages[$key]) && $itemImages[$key] instanceof UploadedFiles)
						$itemImages[$key]->move($this->itemImagePath);
				}
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}
		if($model->itemRel){
			foreach($model->itemRel as $key => $item){
				$itemImages[$key] = [];
				if($item->image)
					$itemImages[$key] = new UploadedFiles($this->itemImagePath, $item->image, array(
						'thumbnail' => array(
							'width' => 200,
							'height' => 200
						),
						'resize' => array(
							'width' => 600,
							'height' => 400
						)));
			}
		}
		$this->render('update', compact('model', 'itemImages', 'image'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

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
		$model = new Lists('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lists']))
			$model->attributes = $_GET['Lists'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lists the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Lists::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Lists $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'lists-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionUploadItem()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$validFlag = true;
			$uploadDir = Yii::getPathOfAlias("webroot").'/uploads/temp';
			if (!is_dir($uploadDir))
				mkdir($uploadDir);

			if (isset($_FILES['Lists'])) {
				$item = array_pop($_FILES['Lists']['name']['items']);
				$temp = array_pop($_FILES['Lists']['tmp_name']['items']);
				$file = $item['image'];
				$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				$filename = Controller::generateRandomString(5).time();
				while (file_exists($uploadDir.DIRECTORY_SEPARATOR.$filename.'.'.$ext))
					$filename = Controller::generateRandomString(5).time();
				$filename = $filename.'.'.$ext;
				$msg = '';
				if ($validFlag) {
					if (move_uploaded_file($temp['image'], $uploadDir.DIRECTORY_SEPARATOR.$filename)) {
						$response = ['status' => true, 'fileName' => $filename];
					} else
						$response = ['status' => false, 'message' => 'در عملیات آپلود فایل خطایی رخ داده است.'];
				} else
					$response = ['status' => false, 'message' => $msg];
			} else
				$response = ['status' => false, 'message' => 'فایلی ارسال نشده است.'];
			echo CJSON::encode($response);
			Yii::app()->end();
		}
	}

	public function actionChangeStatus($id)
	{
		$model = $this->loadModel($id);
		$model->scenario = 'change_status';
		if(isset($_POST['Lists'])){
			if(!key_exists($_POST['Lists']['status'], $model->statusLabels))
				unset($_POST['Lists']['status']);
			$model->attributes = $_POST['Lists'];
			if($model->save()){
				$this->createLog('لیست "'.$model->title.'" توسط مدیر سایت تایید شد.', $model->user_id);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('change_status', compact('model'));
	}
}

