<?php

$this->pageHeading = Yii::t('core.crud', 'Manage Users');

$this->breadcrumbs = array(
	Yii::t('core.crud', 'Users'), 
);

$this->menu = array(
	array(
		'label' => '<i class="glyphicon glyphicon-plus"></i>', 
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Create User'), 
			'class' => 'btn btn-default',
		), 
		'url' => array('create'),
		'visible' => Yii::app()->user->checkAccess('create_user'),
	),
	array(
		'label' => '<i class="glyphicon glyphicon-search"></i>', 
		'url' => '#',
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Search'), 
			'class' => 'search-button btn btn-default',
			'data-toggle' => 'search-form',
		),
	),
);

?>

<div class="panel panel-default search-form" style="display: none;">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo Yii::t('core.crud', 'Search'); ?></h3>
	</div>
	<div class="panel-body">
		<?php $this->renderPartial('_search',array(
			'model' => $model,
		)); ?>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $this->pageHeading; ?></h3>
	</div>
	<?php $this->widget('GridView', array(
		'id' => 'user-grid',
		'dataProvider' => $provider,
		'columns' => array(
			array('class' => 'LinkColumn', 'name' => 'real_name'),
			'username',
			'email',
			array('name' => 'status', 'value' => '$data->getStatusName()'),
			array('name' => 'role', 'value' => '$data->getRoleName()'),
			'rate',
			array(
				'class' => 'ButtonColumn',
				'deleteConfirmation' => Yii::t('core.crud', 'Are you sure you want to delete this user?'),
				'template' => '{view}'.
					(Yii::app()->user->checkAccess('update_user') ? ' {update}' : '').
					(Yii::app()->user->checkAccess('delete_user') ? ' {delete}' : ''),
			),
		),
	)); ?>
</div>
