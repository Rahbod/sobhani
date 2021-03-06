<?php

class ListsPublicController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/inner';
    public $tempPath = 'uploads/temp';
    public $imagePath = 'uploads/lists';
    public $itemImagePath = 'uploads/items';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - view, index, rows, json, search, autoComplete'
        );
    }

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'rows', 'view', 'new', 'update', 'upload', 'delete', 'uploadItem', 'deleteUpload', 'deleteUploadItem',
                'json', 'authJson', 'search', 'autoComplete'
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
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     * @throws CHttpException if list not exists
     */
    public function actionView($id)
    {
        Yii::app()->theme = 'new';
        $model = $this->loadModel($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($model->status != Lists::STATUS_APPROVED && (Yii::app()->user->isGuest || (Yii::app()->user->type !='admin' && $model->user_id != Yii::app()->user->getId())))
            throw new CHttpException(404, 'The requested page does not exist.');
        $criteria = new CDbCriteria();
        $criteria->join = 'LEFT OUTER JOIN `ym_votes` `votes` ON  (`votes`.`item_id` = `itemRel`.`item_id`) LEFT OUTER JOIN `ym_items` `item` ON (`votes`.`item_id` = `item`.`id`)';
        $criteria->condition = '`itemRel`.`list_id` = :itemID AND itemRel.status = :status';
        $criteria->group = 'itemRel.id';
        $criteria->order = 'COUNT(votes.id) DESC';
        $criteria->alias = 'itemRel';
        $criteria->params[':itemID'] = $id;
        $criteria->params[':status'] = ListItemRel::STATUS_ACCEPTED;
        $criteria->index = 'item_id';
        $items = ListItemRel::model()->findAll($criteria);

        $this->keywords = $model->getKeywords();
        $this->description = mb_substr(strip_tags($model->description),0,160,'UTF-8');
        $this->pageTitle = $model->title;

        // get latest news
        $criteria = new CDbCriteria();
        $criteria->addCondition('id <> :id');
        $criteria->addCondition('category_id = :catid');
        $criteria->params = [':id' => $id, ':catid' => $model->category_id];
        $criteria->limit = 10;
        $this->similarProvider = Lists::model()->findAll($criteria);

        Yii::app()->db->createCommand()->update('{{lists}}', array('seen' => (int)$model->seen + 1), 'id = :id', array(':id' => $id));

        if (isset($_POST['title'])) {
            if (!isset($_POST['title']))
                Yii::app()->user->setFlash('failed', 'عنوان نمی تواند خالی باشد.');
            else {
                $tempPath = Yii::getPathOfAlias('webroot') . '/uploads/temp/';
                /* @var Items $item */
                $item = Items::model()->findByAttributes(array('title' => $_POST['title']));
                if ($item === null) {
                    $item = new Items();
                    $item->title = $_POST['title'];
                    $item->status = Items::STATUS_PENDING;
                    @$item->save();
                }
                if ($item) {
                    $rel = new ListItemRel();
                    $rel->item_id = $item->id;
                    $rel->list_id = $model->id;
                    $rel->image = isset($_POST['Lists']['items'][0]['image']) && is_file($tempPath . $_POST['Lists']['items'][0]['image']) ? $_POST['Lists']['items'][0]['image'] : null;
                    $rel->description = isset($_POST['description']) ? $_POST['description'] : null;
                    $rel->user_id = Yii::app()->user->getId();
                    $rel->status = ListItemRel::STATUS_PENDING;

                    $image = new UploadedFiles($this->tempPath, $rel->image, array(
                        'thumbnail' => array(
                            'width' => 150,
                            'height' => 150,
                            'quality' => 50
                        ),
                        'resize' => array(
                            'width' => 400,
                            'height' => 300,
                            'quality' => 60
                        )));

                    if ($rel->save()) {
                        Yii::app()->user->setFlash('success', 'گزینه جدید با موفقیت ثبت شد. این گزینه پس از تایید مدیریت نمایش داده خواهد شد.');
                        $image->move($this->itemImagePath);
                    }else
                        Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داد! لطفا مجددا تلاش کنید.');
                }
            }
        }

        $this->render('view', compact('model', 'items'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionNew()
    {
        //<a href="https://telegram.me/share/url?url=http://as.com" class="telegram-link pull-left"><i></i>اشتراک گذاری در تلگرام</a>
        Yii::app()->theme = 'new';
        $model = new Lists();
        $itemImages = [];
        if (isset($_POST['Lists'])) {
            $model->attributes = $_POST['Lists'];
            $model->user_type = Yii::app()->user->type;
            $model->user_id = Yii::app()->user->getId();
            $image = $model->image ? new UploadedFiles($this->tempPath, $model->image, array(
                'thumbnail' => array(
                    'width' => 400,
                    'height' => 300
                ),
                'resize' => array(
                    'width' => 768,
                    'height' => 480,
                    'quality' => 60
                ))) : [];
            $model->status = isset($_POST['draft']) ? Lists::STATUS_DRAFT : ($model->user_type == 'admin' ? Lists::STATUS_APPROVED : Lists::STATUS_PENDING);

            if ($model->items) {
                foreach ($model->items as $key => $item) {
                    $itemImages[$key] = [];
                    if (isset($item['image']))
                        $itemImages[$key] = new UploadedFiles($this->tempPath, $item['image'], array(
                            'thumbnail' => array(
                                'width' => 150,
                                'height' => 150,
                                'quality' => 50
                            ),
                            'resize' => array(
                                'width' => 400,
                                'height' => 300,
                                'quality' => 60
                            )));
                }
            }

            if ($model->save()) {
                if ($model->image)
                    $image->move($this->imagePath);

                // save item images
                foreach ($model->items as $key => $item) {
                    if ($itemImages[$key] instanceof UploadedFiles)
                        $itemImages[$key]->move($this->itemImagePath);
                }

                Yii::app()->user->setFlash('success', 'لیست شما با موفقیت ثبت شد<br>این لیست پس از تایید کارشناسان بصورت عمومی نمایش داده خواهد شد.');
                $this->redirect(array('/lists/' . $model->id . '/' . str_replace(' ', '-', $model->title)));
            } else
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
        Yii::app()->theme = 'new';
        $model = $this->loadModel($id);

        $image = new UploadedFiles($this->imagePath, ($model->image && is_file(Yii::getPathOfAlias('webroot') . '/uploads/lists/' . $model->image) ? $model->image : false), array(
            'thumbnail' => array(
                'width' => 400,
                'height' => 300
            ),
            'resize' => array(
                'width' => 768,
                'height' => 480,
                'quality' => 60
            )));

        $oldItemImages = [];
        $itemImages = [];
        if ($model->itemRel) {
            foreach ($model->itemRel as $key => $item) {
                $oldItemImages[] = $item->image;
            }
        }

        if (isset($_POST['Lists'])) {
            //
            $oldImage = $model->image;
            $model->attributes = $_POST['Lists'];
            if ($model->items) {
                foreach ($model->items as $key => $item) {
                    if (isset($item['image']) && isset($oldItemImages[$key]) && $oldItemImages[$key] != $item['image'])
                        $itemImages[$key] = new UploadedFiles($this->tempPath, $item['image'], array(
                            'thumbnail' => array(
                                'width' => 150,
                                'height' => 150,
                                'quality' => 50
                            ),
                            'resize' => array(
                                'width' => 400,
                                'height' => 300,
                                'quality' => 60
                            )));
                    else {
                        if (isset($item['image']))
                            $itemImages[$key] = new UploadedFiles($this->tempPath, $item['image'], array(
                                'thumbnail' => array(
                                    'width' => 150,
                                    'height' => 150,
                                    'quality' => 50
                                ),
                                'resize' => array(
                                    'width' => 400,
                                    'height' => 300,
                                    'quality' => 60
                                )));
                        else
                            $itemImages[$key] = [];
                    }
                }
            }

            $model->status = isset($_POST['draft']) ? Lists::STATUS_DRAFT : ($model->user_type == 'admin' ? Lists::STATUS_APPROVED : Lists::STATUS_PENDING);
            if ($model->save()) {
                $image->update($oldImage, $model->image, $this->tempPath);

                // save item images
                foreach ($model->items as $key => $item) {
                    if (isset($itemImages[$key]) && $itemImages[$key] instanceof UploadedFiles)
                        $itemImages[$key]->move($this->itemImagePath);
                }
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد و پس از تایید در سایت قرار خواهد گرفت.');
                $this->refresh();
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }
        if ($model->itemRel) {
            foreach ($model->itemRel as $key => $item) {
                $itemImages[$key] = [];
                if ($item->image)
                    $itemImages[$key] = new UploadedFiles($this->itemImagePath, $item->image, array(
                        'thumbnail' => array(
                            'width' => 150,
                            'height' => 150,
                            'quality' => 50
                        ),
                        'resize' => array(
                            'width' => 400,
                            'height' => 300,
                            'quality' => 60
                        )));
            }
        }

        $items = [];
        foreach($model->items as $item) {
            if ($item['status'] == ListItemRel::STATUS_ACCEPTED)
                $items[] = $item;
        }
        $model->items = $items;

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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //show categories
        Yii::app()->theme = 'new';
        $categories = ListCategories::model()->findAll(array('condition' => 'parent_id IS NULL', 'order' => 'id'));
        $this->render('index', compact('categories'));
    }

    /**
     * Lists all models.
     */
    public function actionRows($type)
    {
        Yii::app()->theme = 'new';
        //$this->layout = 'public';
        switch ($type) {
            case 'recommended':
                $title = 'پیشنهاد ما به شما';
                $lists = $this->getRecommendedLists();
                break;
            case 'popular':
                $title = 'محبوب ترین ها';
                $lists = $this->getPopularLists(-1);
                break;
            default:
            case 'latest':
                $title = 'تازه ها';
                $lists = $this->getLatestListsByID(-1);
                break;
        }
        $this->pageTitle = $title;
        $this->render('list', compact('lists', 'title'));
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
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Lists $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lists-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUploadItem()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $validFlag = true;
            $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';
            if (!is_dir($uploadDir))
                mkdir($uploadDir);

            if (isset($_FILES['Lists'])) {
                $item = array_pop($_FILES['Lists']['name']['items']);
                $temp = array_pop($_FILES['Lists']['tmp_name']['items']);
                $file = $item['image'];
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $filename = Controller::generateRandomString(5) . time();
                while (file_exists($uploadDir . DIRECTORY_SEPARATOR . $filename . '.' . $ext))
                    $filename = Controller::generateRandomString(5) . time();
                $filename = $filename . '.' . $ext;
                $msg = '';
                if ($validFlag) {
                    if (move_uploaded_file($temp['image'], $uploadDir . DIRECTORY_SEPARATOR . $filename)) {
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

    public function actionJson()
    {
        if (!isset($_POST['method']))
            $this->sendJson(['status' => false]);
        switch ($_POST['method']) {
            case 'vote':
                if (!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $data = json_decode(base64_decode($_POST['hash']), true);
                $vote = new Votes();
                $vote->ip = Votes::getRealIp();
                if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'user') {
                    $userID = Yii::app()->user->getId();
                    $vote->user_id = $userID;
                }
                if (Votes::checkVote($data['list_id'], $data['item_id'])) {
                    if ($vote->user_id)
                        Votes::model()->deleteAllByAttributes(['user_id' => $vote->user_id, 'list_id' => $data['list_id'], 'item_id' => $data['item_id']]);
                    else
                        Votes::model()->deleteAllByAttributes(['ip' => $vote->ip, 'list_id' => $data['list_id'], 'item_id' => $data['item_id']]);
                    Votes::removeVoteFromCookie($data['list_id'] . '-' . $data['item_id']);
                }
                $vote->list_id = $data['list_id'];
                $vote->item_id = $data['item_id'];
                $vote->create_date = time();
                Votes::saveVoteInCookie($data['list_id'] . '-' . $data['item_id']);
                $list = Lists::model()->findByPk($data['list_id']);
                $item = Items::model()->findByPk($data['item_id']);
                if (Yii::app()->user->isGuest)
                    $this->createLog('"کاربر مهمان" در لیست "' . CHtml::link($list->title, array('/lists/' . $list->id . '/' . urlencode($list->title))) . '" به گزینه "' . $item->title . '" رای داد', $list->user_id);
                else
                    $this->createLog('"' . CHtml::link(Yii::app()->user->showName, array('/users/public/viewProfile/' . Yii::app()->user->id . '/' . str_replace(' ', '-',Yii::app()->user->showName))) . '" در لیست "' . CHtml::link($list->title, array('/lists/' . $list->id . '/' . urlencode($list->title))) . '" به گزینه "' . $item->title . '" رای داد.', $list->user_id);
                if ($vote->save())
                    $this->sendJson(['status' => true, 'avgs' => Votes::VoteAverages($vote->list_id), 'newAvg' => Votes::VoteAverages($vote->list_id, $vote->item_id), 'message' => 'رای شما با موفقیت ثبت گردید.']);
                else
                    $this->sendJson(['status' => false, 'message' => 'در انجام عملیات مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.']);
                break;

            case 'unvote':
                if (!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $data = json_decode(base64_decode($_POST['hash']), true);

                $vote = new Votes();
                $vote->ip = Votes::getRealIp();
                if (!Yii::app()->user->isGuest && Yii::app()->user->type == 'user') {
                    $userID = Yii::app()->user->getId();
                    $vote->user_id = $userID;
                }

                if (Votes::checkVote($data['list_id'], $data['item_id'])) {
                    if ($vote->user_id)
                        Votes::model()->deleteAllByAttributes(['user_id' => $vote->user_id, 'list_id' => $data['list_id'], 'item_id' => $data['item_id']]);
                    else
                        Votes::model()->deleteAllByAttributes(['ip' => $vote->ip, 'list_id' => $data['list_id'], 'item_id' => $data['item_id']]);
                    Votes::removeVoteFromCookie($data['list_id'] . '-' . $data['item_id']);
                }

                $vote->list_id = $data['list_id'];
                $vote->item_id = $data['item_id'];

                $this->sendJson(['status' => true, 'avgs' => Votes::VoteAverages($vote->list_id), 'newAvg' => Votes::VoteAverages($vote->list_id, $vote->item_id), 'message' => 'رای شما حذف شد.']);
                break;
            default:
                $this->sendJson(['status' => false]);
        }
    }

    public function actionAuthJson()
    {
        if (!isset($_POST['method']))
            $this->sendJson(['status' => false]);
        switch ($_POST['method']) {
            case 'bookmark':
                if (!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $carID = base64_decode($_POST['hash']);
                $userID = Yii::app()->user->getId();
                $parked = UserBookmarks::model()->findByAttributes(['user_id' => $userID, 'list_id' => $carID]);
                if ($parked === null) {
                    $parkModel = new UserBookmarks();
                    $parkModel->list_id = $carID;
                    $parkModel->user_id = $userID;
                    if ($parkModel->save())
                        $this->sendJson(['status' => true, 'message' => 'لیست به علاقه مندی های شما اضافه شد.']);
                    else
                        $this->sendJson(['status' => false, 'message' => 'در انجام عملیات مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.']);
                } else {
                    if ($parked->delete())
                        $this->sendJson(['status' => true, 'message' => 'لیست از علاقه مندی های شما خارج شد.']);
                    else
                        $this->sendJson(['status' => false, 'message' => 'در انجام عملیات مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.']);
                }
                break;
            default:
                $this->sendJson(['status' => false, 'message' => 'خطا در مقادیر.']);
        }
    }

    private function sendJson($response)
    {
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionSearch()
    {
        Yii::app()->theme = 'new';
        $this->layout = '//layouts/inner';
        $title = "همه لیست ها";
        $criteria = new CDbCriteria();
        $criteria->order = 'seen DESC, t.title';
        if (isset($_GET['term']) && !empty($_GET['term'])) {
            $_GET['term'] = trim($_GET['term']);
            $criteria->addCondition('t.status = :status');
            $criteria->addCondition('t.title REGEXP :field OR t.description REGEXP :field OR
						category.title REGEXP :field OR category.description REGEXP :field OR itemObj.title REGEXP :field');
            $criteria->with[] = 'category';
            $criteria->with[] = 'itemObj';
            $criteria->params[':field'] = $_GET['term'];
            $criteria->params[':status'] = Lists::STATUS_APPROVED;
            /* @var Lists[] $list */
            $lists = Lists::model()->findAll($criteria);

            $title = "جستجوی \"{$_GET['term']}\"";
        } else
            $lists = Lists::model()->findAll($criteria);

        $this->pageTitle = $title;
        $this->render('list', compact('lists', 'title'));
    }

    public function actionAutoComplete()
    {
        $query = Yii::app()->request->getQuery('query');

        $criteria = new CDbCriteria();
        $criteria->compare('title', $query, true);
        $items = Items::model()->findAll($criteria);
        $out = array();
        foreach ($items as $item)
            $out[] = array(
                'title' => $item->title,
                'id' => $item->id,
            );
        echo CJSON::encode($out);
    }
}
