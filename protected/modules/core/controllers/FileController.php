<?php

class FileController extends AdminController 
{
	public function actionIndex()
	{
		$model = $this->createSearchModel('File');
		$provider = $model->search();
		$this->render('index', array(
			'model' => $model,
			'provider' => $provider,
		));
	}
	
	public function actionCreate()
	{
		if (isset($_POST['uploading'])) {
			$result = File::model()->processUploading('file');
			$n = 0;
			$ids = array();
			foreach ($result as $file => $status) {
				if (is_object($status)) {
					Yii::app()->user->setFlash("message m$n", Yii::t('core.crud', 'File "{file}" loaded successfully', array(
						'{file}' => $file,
					)));
					$ids[] = $status->id;
				} else {
					Yii::app()->user->setFlash("error e$n", Yii::t('core.crud', 'Error while uploading "{file}": {reason}', array(
						'{file}' => $file, 
						'{reason}' => $status,
					)));
				}
				$n++;
			}
			$category_id = Yii::app()->request->getPost('category', 0);
			if ($category_id > 0 && count($ids)) {
				File::model()->updateByPk($ids, array(
					'category_id' => $category_id,
				));
			}
			$this->refresh();
		}
		$this->render('create');
	}
	
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'File');
		if ($this->saveModel($model)) {
			$this->redirect(array('view', 'id' => $model->id));
		}
		$this->render('update', array(
			'model' => $model,
		));
	}
	
	public function actionDelete($id)
	{
		$model = $this->loadModel($id, 'File');
		$model->delete();
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}
	
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id, 'File'),
		));
	}
	
	public function actionDownload($id)
	{
		$model = $this->loadModel($id, 'File');
		$path = File::getUploadPath() . '/' . $model->path;
		if (!is_readable($path)) {
			throw new CHttpException(404, 'Not Found');
		}
		header_remove("Pragma");
		header_remove("Expires");
		header("Content-Type: " . $model->mime);
		header("Content-Length: " . $model->size);
		if ($model->getIsImage()) {
			header("Content-Disposition: inline");
		} else {
			header("Content-Disposition: attachment; filename=" . $model->title);
		}
		header("Cache-Control: max-age=8640000");
		header("Last-Modified: " . date('r', $model->update_time));
		header("ETag: " . md5($path));
		if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') == 0) {
			readfile($path);
		}
		exit;
	}
	
	public function actionImagePickerDialog($w, $h)
	{
		$model = $this->createSearchModel('File');
		$criteria = new CDbCriteria();
		$criteria->addInCondition('mime', $model->getValidImageTypes());
		$provider = $model->search($criteria);
		$provider->pagination = array(
			'pageSize' => 9,
		);
		$this->renderPartial('imagePickerDialog', array(
			'model' => $model,
			'provider' => $provider,
			'w' => $w,
			'h' => $h,
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
				'roles' => array('create_file'),
			),
			array('allow',
				'actions' => array('view', 'index', 'imagePickerDialog'),
				'roles' => array('view_file'),
			),
			array('allow',
				'actions' => array('update'),
				'roles' => array('update_file'),
			),
			array('allow',
				'actions' => array('delete'),
				'roles' => array('delete_file'),
			),
			array('allow',
				'actions' => array('download'),
				'users' => array('@'),
			),
			array('deny'),
		);
	}
}
