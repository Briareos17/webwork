<?php

$this->pageHeading = Yii::t('core.crud', 'New Holiday');

$this->breadcrumbs = array(
	Yii::t('core.crud', 'Holidays') => Yii::app()->user->checkAccess('view_holiday') ? array('index') : false, 
	Yii::t('core.crud', 'Create'),
);

$this->menu = array(
	array(
		'label' => '<i class="glyphicon glyphicon-list-alt"></i>', 
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Manage Holidays'), 
			'class' => 'btn btn-default',
		),
		'url' => array('index'),
		'visible' => Yii::app()->user->checkAccess('view_holiday'),
	),
);

?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $this->pageHeading; ?></h3>
	</div>
	<div class="panel-body">
		<?php $this->renderPartial('_form', array(
			'model' => $model,
		)); ?>
	</div>
</div>
