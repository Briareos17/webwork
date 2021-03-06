<?php

class HolidayController extends AdminController 
{
	public function actionIndex()
	{
		$model = $this->createSearchModel('Holiday');
		$provider = $model->search();
		$this->render('index', array(
			'model' => $model,
			'provider' => $provider,
		));
	}
	
	public function actionCreate()
	{
		$model = new Holiday('create');
		if ($this->saveModel($model)) {
			Yii::app()->user->setFlash('message', Yii::t('core.crud', 'Holiday has been created'));
			$this->redirect(array('view', 'id' => $model->id));
		}
		$this->render('create', array(
			'model' => $model,
		));
	}
	
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'Holiday');
		if ($this->saveModel($model)) {
			Yii::app()->user->setFlash('message', Yii::t('core.crud', 'Holiday has been updated'));
			$this->redirect(array('view', 'id' => $model->id));
		}
		$this->render('update', array(
			'model' => $model,
		));
	}
	
	public function actionDelete($id)
	{
		$model = $this->loadModel($id, 'Holiday');
		$model->delete();
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}
	
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Holiday'),
		));
	}

	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete', 
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('create'),
				'roles' => array('create_holiday'),
			),
			array('allow',
				'actions' => array('view', 'index'),
				'roles' => array('view_holiday'),
			),
			array('allow',
				'actions' => array('update'),
				'roles' => array('update_holiday'),
			),
			array('allow',
				'actions' => array('delete'),
				'roles' => array('delete_holiday'),
			),
			array('deny'),
		);
	}
}
