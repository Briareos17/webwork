<?php

class Invoice extends CActiveRecord  
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return '{{invoice}}';
	}
	
	public function attributeLabels()
	{
		return array(
			'amount' => Yii::t('invoice', 'Amount'),
			'comments' => Yii::t('invoice', 'Comments'),
			'created_by_id' => Yii::t('invoice', 'Created by'),
			'created_by' => Yii::t('invoice', 'Created by'),
			'draft' => Yii::t('invoice', 'Draft'),
			'from_id' => Yii::t('invoice', 'From'),
			'from' => Yii::t('invoice', 'From'),
			'id' => Yii::t('invoice', 'Number'),
			'number' => Yii::t('invoice', 'Number'),
			'items' => Yii::t('invoice', 'Items'),
			'payd' => Yii::t('invoice', 'Payd'),
			'project_id' => Yii::t('invoice', 'Project'),
			'project' => Yii::t('invoice', 'Project'),
			'time_created' => Yii::t('invoice', 'Date Created'),
			'to_id' => Yii::t('invoice', 'To'),
			'to' => Yii::t('invoice', 'To'),
		);
	}
	
	public function rules()
	{
		return array(
			array('	comments', 
					'length', 'max' => 16000, 'on' => 'create, update'),
			array(' from_id,
					project_id,
					to_id',
					'safe', 'on' => 'create, update'),
			array('	draft', 
					'required', 'on' => 'update'),
			array('	draft', 
					'boolean', 'on' => 'update'),
		);
	}
	
	public function relations()
	{
		return array(
			'amount' => array(self::STAT, 'InvoiceItem', 'invoice_id', 'select' => 'SUM(value)'),
			'created_by' => array(self::BELONGS_TO, 'User', 'created_by_id'),
			'from' => array(self::BELONGS_TO, 'User', 'from_id'),
			'items' => array(self::HAS_MANY, 'InvoiceItem', 'invoice_id'),
			'payd' => array(self::STAT, 'Payment', 'invoice_id', 'select' => 'SUM(amount)'),
			'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
			'to' => array(self::BELONGS_TO, 'User', 'to_id'),
		);
	}
	
	public function behaviors()
	{
		return array(
			array(
				'class' => 'StampBehavior',
				'create_time_attribute' => 'time_created',
				'created_by_attribute' => 'created_by',
			),
			array(
				'class' => 'RelationBehavior',
				'attributes' => array(
					'created_by',
					'from',
					'items' => array(
						'cascadeDelete' => true,
						'quickDelete' => true,
					),
					'project',
					'to',
				),
			),
		);
	}
	
	public function search($params=array())
	{
		$criteria = new CDbCriteria($params);
		$criteria->alias = 'invoice';
		$criteria->with = array('project', 'from', 'to');
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'invoice.time_created DESC',
				'attributes' => array(
					'project' => array(
						'asc' => 'project.name',
						'desc' => 'project.name DESC',
					),
					'from' => array(
						'asc' => 'from.real_name, from.username',
						'desc' => 'from.real_name DESC, from.username DESC',
					),
					'to' => array(
						'asc' => 'to.real_name, to.username',
						'desc' => 'to.real_name DESC, to.username DESC',
					),
					'*',
				),
			),
		));
	}
	
	public function getItems($params=array())
	{
		$model = new InvoiceItem('search');
		$model->unsetAttributes();
		$criteria = new CDbCriteria($params);
		$criteria->compare('invoiceitem.invoice_id', $this->id);
		$provider = $model->search($criteria);
		$provider->pagination = false;
		return $provider;
	}
	
	public function getNumber()
	{
		return sprintf('#%05d', $this->id);
	}
	
	public function __toString()
	{
		return $this->getNumber();
	}
}
