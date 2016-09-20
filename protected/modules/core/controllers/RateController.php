<?php

class RateController extends AdminController 
{
	public function actionIndex()
	{
		$model = $this->createSearchModel('Rate');
		$provider = $model->search();
		$this->render('index', array(
			'model' => $model,
			'provider' => $provider,
		));
	}
	
	public function actionCreate()
	{
		$model = new Rate('create');
		if ($this->saveModel($model)) {
			Yii::app()->user->setFlash('message', Yii::t('core.crud', 'Rate has been created'));
			$this->redirect(array('view', 'id' => $model->id));
		}
		$this->render('create', array(
			'model' => $model,
		));
	}
	
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'Rate');
		if ($this->saveModel($model)) {
			Yii::app()->user->setFlash('message', Yii::t('core.crud', 'Rate has been updated'));
			$this->redirect(array('view', 'id' => $model->id));
		}
		$this->render('update', array(
			'model' => $model,
		));
	}
	
	public function actionDelete($id)
	{
		$model = $this->loadModel($id, 'Rate');
		$model->delete();
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}
	
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Rate'),
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
				'roles' => array('create_rate'),
			),
			array('allow',
				'actions' => array('view', 'index'),
				'roles' => array('view_rate'),
			),
			array('allow',
				'actions' => array('update'),
				'roles' => array('update_rate'),
			),
			array('allow',
				'actions' => array('delete'),
				'roles' => array('delete_rate'),
			),
			array('deny'),
		);
	}
}
