<?php

class ActivityController extends AdminController 
{
	public function actionIndex()
	{
		$model = $this->createSearchModel('Activity');
		$provider = $model->search();
		$this->render('index', array(
			'model' => $model,
			'provider' => $provider,
		));
	}
	
	public function actionCreate()
	{
		$model = new Activity('create');
		if ($this->saveModel($model)) {
			if ($this->isAjax()) {
				$this->ajaxSuccess(array(
					'trigger' => 'activity.created',
					'message' => array(
						'title' => Yii::t('core.crud', 'Success'),
						'text' => Yii::t('core.crud', 'Activity has been created'),
					),
				));
			} else {
				Yii::app()->user->setFlash('message', Yii::t('core.crud', 'Activity has been created'));
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		if ($this->isAjax()) {
			$this->layout = 'ajax';
		}
		$this->render('create', array(
			'model' => $model,
		));
	}
	
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'Activity');
		if ($this->saveModel($model)) {
			if ($this->isAjax()) {
				$this->ajaxSuccess(array(
					'trigger' => 'activity.updated',
					'message' => array(
						'title' => Yii::t('core.crud', 'Success'),
						'text' => Yii::t('core.crud', 'Activity has been updated'),
					),
				));
			} else {
				Yii::app()->user->setFlash('message', Yii::t('core.crud', 'Activity has been updated'));
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		if ($this->isAjax()) {
			$this->layout = 'ajax';
		}
		$this->render('update', array(
			'model' => $model,
		));
	}
	
	public function actionDelete($id)
	{
		$model = $this->loadModel($id, 'Activity');
		$model->delete();
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}
	
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Activity'),
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
				'roles' => array('create_activity'),
			),
			array('allow',
				'actions' => array('view', 'index'),
				'roles' => array('view_activity'),
			),
			array('allow',
				'actions' => array('update'),
				'roles' => array('update_activity'),
			),
			array('allow',
				'actions' => array('delete'),
				'roles' => array('delete_activity'),
			),
			array('deny'),
		);
	}
}
