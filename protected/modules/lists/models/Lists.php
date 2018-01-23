<?php

/**
 * This is the model class for table "{{lists}}".
 *
 * The followings are the available columns in table '{{lists}}':
 * @property string $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property string $user_type
 * @property string $user_id
 * @property string $category_id
 * @property string $create_date
 * @property string $seen
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Admins $admin
 * @property ListCategories $category
 * @property Items[] $itemObj
 * @property ListItemRel[] $itemRel
 * @property Users[] $bookmarks
 */
class Lists extends CActiveRecord
{
	const STATUS_PENDING = 0;
	const STATUS_APPROVED = 1;
	const STATUS_DRAFT = 2;
	const STATUS_REFUSED = 3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lists}}';
	}

    public $items = null;
    public $statusLabels = array(
        self::STATUS_PENDING => 'در انتظار بررسی',
        self::STATUS_APPROVED => 'تایید شده',
        self::STATUS_DRAFT => 'پیشنویس',
        self::STATUS_REFUSED => 'رد شده',
    );

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, image', 'required'),
			array('title', 'length', 'max'=>255),
			array('image', 'length', 'max'=>512),
			array('user_id, category_id, seen', 'length', 'max'=>10),
			array('create_date, user_type', 'length', 'max'=>20),
			array('status', 'length', 'max'=>1),
			array('status', 'default', 'value'=>self::STATUS_PENDING),
			array('seen', 'default', 'value'=>0),
			array('create_date', 'default', 'value'=>time()),
			array('items, description', 'safe'),
			array('items', 'checkItems', 'except' => 'change_status'),
			array('category_id', 'required', 'on' => 'change_status'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, image, description, user_type, user_id, category_id, create_date, seen, status', 'safe', 'on'=>'search'),
		);
	}

    public function checkItems($attribute)
	{
		if(!$this->items)
			$this->addError($attribute, 'آیتم ها نمی توانند خالی باشند.');
		else if(count($this->items) < 10)
			$this->addError($attribute, 'تمام آیتم ها را پر کنید.');
		else
			foreach($this->{$attribute} as $key => $item){
				$c = $key +1;
				if(!isset($item['title']) || empty($item['title'])){
					$this->addError($attribute, "عنوان آیتم {$c} نمی تواند خالی باشد.");
					break;
				}
			}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'ListCategories', 'category_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'admin' => array(self::BELONGS_TO, 'Admins', 'user_id'),
			'itemObj' => array(self::MANY_MANY, 'Items', '{{list_item_rel}}(list_id, item_id)'),
			'itemRel' => array(self::HAS_MANY, 'ListItemRel', 'list_id', 'order' => 'id'),
			'bookmarks' => array(self::MANY_MANY, 'Users', '{{user_bookmarks}}(list_id, user_id)'),
		);
	}

    /**
     * @return Users|Admins
     */
    public function getUser(){
        if($this->user_type == 'user')
            return Users::model()->findByPk($this->user_id);
        return Admins::model()->findByPk($this->user_id);
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'image' => 'تصویر',
			'description' => 'توضیحات',
			'user_type' => 'نوع کاربر',
			'user_id' => 'کاربر',
			'category_id' => 'دسته بندی',
			'create_date' => 'تاریخ ثبت',
			'seen' => 'بازدید',
			'status' => 'وضعیت',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
        $criteria->compare('user_type',$this->user_type);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('seen',$this->seen,true);
		$criteria->compare('status',$this->status,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lists the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function afterSave()
    {
        $tempPath = Yii::getPathOfAlias('webroot').'/uploads/temp/';
        if($this->items){
			ListItemRel::model()->deleteAllByAttributes(array('list_id' => $this->id));
            foreach($this->items as $item){
                $model = Items::model()->findByAttributes(array('title' => $item['title']));
                if($model === null){
                    $model = new Items();
                    $model->title = $item['title'];
                    $model->status = $this->user_type=='admin'?Items::STATUS_APPROVED:Items::STATUS_PENDING;
                    @$model->save();
                }
                if($model){
                    $rel = new ListItemRel();
                    $rel->item_id = $model->id;
                    $rel->list_id = $this->id;
                    $rel->image = isset($item['image']) && is_file($tempPath . $item['image'])?$item['image']:null;
                    $rel->description = isset($item['description'])?$item['description']:null;
                    @$rel->save();
                }
            }
        }
		
		if($this->scenario == 'change_status'){
			if($this->status == Lists::STATUS_APPROVED){
				$ids = CHtml::listData($this->itemObj, 'id', 'id');
				$criteria = new CDbCriteria();
				$criteria->addInCondition('id', $ids);
				Items::model()->updateAll(array('status' => Lists::STATUS_APPROVED), $criteria);
			}
		}
		
        parent::afterSave();
    }
	
	protected function afterFind()
	{
		parent::afterFind();
		$this->items = [];
		if($this->itemRel)
			foreach($this->itemRel as $item){
				$this->items[] = array(
					'title' => $item->item->title,
					'description' => $item->description,
					'image' => $item->image,
				);
			}
	}

	public function getViewUrl()
	{
		return Yii::app()->createUrl('/lists/'.$this->id);
	}
}
