<?php

$this->pageHeading = Yii::t('core.crud', 'Rate Information');

$this->breadcrumbs = array(
	Yii::t('core.crud', 'Rates') => Yii::app()->user->checkAccess('view_rate') ? array('index') : false, 
);

$this->menu = array(
	array(
		'label' => '<i class="glyphicon glyphicon-plus"></i>', 
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Create Rate'), 
			'class' => 'btn btn-default',
		),
		'url' => array('create'),
		'visible' => Yii::app()->user->checkAccess('create_rate'),
	),
	array(
		'label' => '<i class="glyphicon glyphicon-list-alt"></i>', 
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Manage Rates'), 
			'class' => 'btn btn-default',
		),
		'url' => array('index'),
		'visible' => Yii::app()->user->checkAccess('view_rate'),
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
				'label' => '<i class="glyphicon glyphicon-pencil"></i> ' . Yii::t('core.crud', 'Update Rate'), 
				'url' => array('update', 'id' => $model->id),
				'visible' => Yii::app()->user->checkAccess('update_rate'),
			),
			array(
				'label' => '<i class="glyphicon glyphicon-trash"></i> ' . Yii::t('core.crud', 'Delete Rate'), 
				'url' => '#', 
				'linkOptions' => array(
					'submit' => array('delete', 'id' => $model->id),
					'confirm' => Yii::t('core.crud', 'Are you sure you want to delete this rate?'),
				),
				'visible' => Yii::app()->user->checkAccess('delete_rate'),
			),
		),
	),
);

?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo CHtml::encode($model->name); ?></h3>
	</div>
	<?php $this->widget('DetailView', array(
		'data' => $model,		
		'attributes' => array(
			'description:ntext',
			'power:number',
		),
	)); ?>
	<div class="panel-footer foot-details">
		<?php echo Yii::t('rate', 'Created by'); ?>
		<?php echo CHtml::encode($model->created_by); ?>,
		<?php echo Yii::app()->format->formatDatetime($model->time_created); ?>
	</div>
</div>

<?php if (count($rates = $model->getCompleteMatrix())): ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo Yii::t('activityRate', 'Hour Rates'); ?></h3>
	</div>
	
	<table class="table table-striped table-bordered table-condensed detailed-view">
		<tbody>
			<?php foreach ($rates as $rate): ?>
				<tr>
					<th><?php echo CHtml::encode($rate->activity->name); ?></th>
					<td><?php echo Yii::app()->format->formatMoney($rate->hour_rate); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>
