<?php

$this->pageHeading = Yii::t('core.crud', 'Application Entity Information');

$this->breadcrumbs = array(
	Yii::t('core.crud', 'Projects') => Yii::app()->user->checkAccess('view_project') ? array('project/index') : false, 
	CHtml::encode($model->application->project->name) => Yii::app()->user->checkAccess('view_project', array('project' => $model->application->project)) ? array('project/view', 'id' => $model->application->project->id) : false, 
	CHtml::encode($model->application->name) => Yii::app()->user->checkAccess('view_application', array('application' => $model->application)) ? array('application/view', 'id' => $model->application->id) : false, 
	Yii::t('core.crud', 'Application Entities') => Yii::app()->user->checkAccess('design_application', array('application' => $model->application)) ? array('index', 'application' => $model->application->id) : false, 
	CHtml::encode($model->name)
);

$this->menu = array(
	array(
		'label' => '<i class="glyphicon glyphicon-plus"></i>', 
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Create Application Entity'), 
			'class' => 'btn btn-default',
		),
		'url' => array('create', 'application' => $model->application->id),
		'visible' => Yii::app()->user->checkAccess('design_application', array('application' => $model->application)),
	),
	array(
		'label' => '<i class="glyphicon glyphicon-list-alt"></i>', 
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Manage Application Entities'), 
			'class' => 'btn btn-default',
		),
		'url' => array('index', 'application' => $model->application->id),
		'visible' => Yii::app()->user->checkAccess('design_application', array('application' => $model->application)),
	),
	array(
		'label' => '<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>', 
		'linkOptions' => array(
			'class' => 'btn btn-default dropdown-toggle',
			'data-toggle' => 'dropdown',
		),
		'itemOptions' => array(
			'class' => 'dropdown',
		),
		'items' => array(
			array(
				'label' => '<i class="glyphicon glyphicon-pencil"></i> ' . Yii::t('core.crud', 'Update Application Entity'), 
				'url' => array('update', 'id' => $model->id),
				'visible' => Yii::app()->user->checkAccess('design_application', array('application' => $model->application)),
			),
			array(
				'label' => '<i class="glyphicon glyphicon-file"></i> ' . Yii::t('core.crud', 'Copy as Template'), 
				'url' => array('copyAsTemplate', 'id' => $model->id),
				'visible' => Yii::app()->user->checkAccess('create_entity_template'),
			),
			array(
				'label' => '<i class="glyphicon glyphicon-star"></i> ' . Yii::t('core.crud', 'Engage expert mode'), 
				'url' => '#',
				'linkOptions' => array(
					'submit' => array('expertMode', 'id' => $model->id),
					'confirm' => Yii::t('core.crud', 'Are you sure you want to use expert mode? You will not be able to switch back to GUI mode!'),
				),
				'visible' => $model->expert_mode == 0 && Yii::app()->user->checkAccess('design_application'),
			),
			array(
				'label' => '<i class="glyphicon glyphicon-trash"></i> ' . Yii::t('core.crud', 'Delete Application Entity'), 
				'url' => '#', 
				'linkOptions' => array(
					'submit' => array('delete', 'id' => $model->id),
					'confirm' => Yii::t('core.crud', 'Are you sure you want to delete this application entity?'),
				),
				'visible' => Yii::app()->user->checkAccess('design_application', array('application' => $model->application)),
			),
		),
	),
);

?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo CHtml::encode($model->name); ?></h3>
	</div>
	<?php if ($model->expert_mode == 1): ?>
		<div class="panel-body">
			<pre><?php echo CHtml::encode($model->plain_source); ?></pre>
		</div>
	<?php else: ?>
		<?php $this->renderPartial('_view', array(
			'model' => $model,
		)); ?>
	<?php endif; ?>
	<div class="panel-footer foot-details">
		<?php echo Yii::t('activity', 'Created by'); ?>
		<?php echo CHtml::encode($model->created_by); ?>,
		<?php echo Yii::app()->format->formatDatetime($model->time_created); ?>
	</div>
</div>
