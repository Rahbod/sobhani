<?php

/**
 * This is the model class for table "{{votes}}".
 *
 * The followings are the available columns in table '{{votes}}':
 * @property string $id
 * @property string $list_id
 * @property string $item_id
 * @property string $user_id
 * @property string $ip
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Lists $list
 * @property Items $item
 */
class Votes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{votes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('list_id, item_id, ip', 'required'),
			array('list_id, item_id, user_id', 'length', 'max' => 10),
			array('ip', 'length', 'max' => 255),
			array('create_date', 'length', 'max' => 20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, list_id, item_id, user_id, ip, create_date', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'list' => array(self::BELONGS_TO, 'Lists', 'list_id'),
			'item' => array(self::BELONGS_TO, 'Items', 'item_id'),
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
			'item_id' => 'آیتم',
			'user_id' => 'کاربر',
			'ip' => 'آی پی',
			'create_date' => 'تاریخ ثبت',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('list_id', $this->list_id, true);
		$criteria->compare('item_id', $this->item_id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('ip', $this->ip, true);
		$criteria->compare('create_date', $this->create_date, true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Votes the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public static function getRealIp()
	{
		if(!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public static function saveVoteInCookie($hash)
	{
		$cookie = Yii::app()->request->cookies->contains('VT')?Yii::app()->request->cookies['VT']:null;

		if(is_null($cookie)){
			$votes = base64_encode(CJSON::encode(array($hash)));
			$newCookie = new CHttpCookie('VT', $votes);
			$newCookie->domain = '';
			$newCookie->expire = time() + (60 * 60 * 24 * 365);
			$newCookie->path = '/';
			$newCookie->secure = false;
			$newCookie->httpOnly = false;
			Yii::app()->request->cookies['VT'] = $newCookie;
		}else{
			$votes = CJSON::decode(base64_decode($cookie->value));
			if(!in_array($hash, $votes)){
				array_push($votes, $hash);
				$votes = base64_encode(CJSON::encode($votes));
				Yii::app()->request->cookies['VT'] = new CHttpCookie('VT', $votes);
			}
		}
	}

	public static function checkVoteInCookie($hash)
	{
		$cookie = Yii::app()->request->cookies->contains('VT')?Yii::app()->request->cookies['VT']:null;
		if(!is_null($cookie)){
			$votes = CJSON::decode(base64_decode($cookie->value));
			if(in_array($hash, $votes))
				return true;
		}
		return false;
	}

	public static function checkVote($listID, $itemID)
	{
		if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'){
			$userID = Yii::app()->user->getId();
			return Votes::model()->countByAttributes(['user_id' => $userID, 'list_id' => $listID, 'item_id' => $itemID]);
		}else
			return Votes::checkVoteInCookie($listID.'-'.$itemID);
	}

	public static function VoteAverages($listID)
	{
		$total = Votes::model()->countByAttributes(['list_id' => $listID]);
		$percents = [];
		foreach(ListItemRel::model()->findAllByAttributes(['list_id' => $listID], array('order' => 'item_id')) as $item){
			$c = Votes::model()->countByAttributes(['list_id' => $listID, 'item_id' => $item->item_id]);
			$percents[$item->item_id] = $c == 0?0:(int)($c / $total * 100);
		}
		return $percents;
	}
}