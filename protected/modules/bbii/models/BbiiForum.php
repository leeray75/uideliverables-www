<?php

/**
 * This is the model class for table "bbii_forum".
 *
 * The followings are the available columns in table 'bbii_forum':
 * @property string $id
 * @property string $cat_id
 * @property string $name
 * @property string $subtitle
 * @property integer $type
 * @property integer $public
 * @property integer $moderated
 * @property integer $locked
 * @property integer $sort
 * @property integer $num_posts
 * @property integer $num_topics
 * @property integer $last_post_id
 */
class BbiiForum extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BbiiForum the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bbii_forum';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('type, public, locked, moderated, sort, num_posts, num_topics, last_post_id', 'numerical', 'integerOnly'=>true),
			array('name', 'unique'),
			array('cat_id', 'length', 'max'=>10),
			array('name, subtitle', 'length', 'max'=>255),
			array('type', 'validateType'),
			array('cat_id, subtitle', 'default', 'value' => null),
			array('public', 'default', 'value' => 1),
			array('locked', 'default', 'value' => 0),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cat_id, name, subtitle, type, sort, num_posts, num_topics, last_post_id, last_post_time', 'safe', 'on'=>'search'),
		);
	}
	
	public function validateType($attr, $params) {
		if($this->type == 0 && !empty($this->cat_id)) {
			$this->addError('cat_id', Yii::t('bbii', 'A category cannot be assigned to a category.'));
		}
		if($this->type == 1 && empty($this->cat_id)) {
			$this->addError('cat_id', Yii::t('bbii', 'A forum needs to be assigned to a category.'));
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'lastPost' => array(self::BELONGS_TO, 'BbiiPost', 'last_post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cat_id' => Yii::t('bbii', 'Category'),
			'name' => Yii::t('bbii', 'Name'),
			'subtitle' => Yii::t('bbii', 'Subtitle'),
			'type' => Yii::t('bbii', 'Type'),
			'public' => Yii::t('bbii', 'Public'),
			'locked' => Yii::t('bbii', 'Locked'),
			'moderated' => Yii::t('bbii', 'Moderated'),
			'sort' => 'Sort',
			'num_posts' => Yii::t('bbii', 'posts'),
			'num_topics' => Yii::t('bbii', 'topics'),
			'last_post_id' => 'Last Post',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cat_id',$this->cat_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('subtitle',$this->subtitle,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('num_posts',$this->num_posts);
		$criteria->compare('num_topics',$this->num_topics);
		$criteria->compare('last_post_id',$this->last_post_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function scopes() {
		return array(
			'categories' => array(
				'condition' => 'type = 0',
				'order' => 'sort',
			),
			'category' => array(
				'condition' => 'type = 0',
			),
			'forum' => array(
				'condition' => 'type = 1',
			),
			'public' => array(
				'condition' => 'public = 1',
			),
			'sorted' => array(
				'order' => 'sort',
			),
		);
	}
}