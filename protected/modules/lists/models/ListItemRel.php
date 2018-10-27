<?php

/**
 * This is the model class for table "{{list_item_rel}}".
 *
 * The followings are the available columns in table '{{list_item_rel}}':
 * @property string $id
 * @property string $list_id
 * @property string $item_id
 * @property string $description
 * @property string $image
 * @property string $user_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Lists $list
 * @property Items $item
 * @property Votes[] $votes
 * @property ItemRelLinks[] $links
 * @property Users $user
 * @property Comment $comments
 */
class ListItemRel extends CActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_DELETED = 2;

	public $statusLabels = [
		self::STATUS_PENDING => 'در انتظار تایید',
		self::STATUS_ACCEPTED => 'تایید شده',
		self::STATUS_DELETED => 'حذف شده',
	];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{list_item_rel}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('list_id, item_id', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
			array('list_id, item_id, user_id', 'length', 'max'=>10),
			array('image', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, list_id, item_id, description, image, user_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        Yii::app()->getModule('comments');
		return array(
			'list' => array(self::BELONGS_TO, 'Lists', 'list_id'),
			'item' => array(self::BELONGS_TO, 'Items', 'item_id'),
			'votes' => array(self::HAS_MANY, 'Votes', 'item_id', 'on' => '`votes`.`item_id` = `itemRel`.`item_id`', 'with'=>'item', 'group' => 'itemRel.id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'owner_id', 'on' => '`comments`.`owner_name` = :className', 'params'=>array(":className" => get_class($this))),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'links' => array(self::HAS_MANY, 'ItemRelLinks', 'item_rel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'list_id' => 'لیست',
			'item_id' => 'گزینه',
			'description' => 'Description',
			'image' => 'Image',
            'user_id' => 'User',
            'status' => 'Status',
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
		$criteria->compare('list_id',$this->list_id,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('status',$this->status);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ListItemRel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
