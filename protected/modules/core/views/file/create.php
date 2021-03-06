<?php

$this->pageHeading = Yii::t('core.crud', 'File Uploading');

$this->breadcrumbs = array(
	Yii::t('core.crud', 'Files') => Yii::app()->user->checkAccess('view_file') ? array('index') : false, 
	Yii::t('core.crud', 'Upload'),
);

$this->menu = array(
	array(
		'label' => '<i class="glyphicon glyphicon-list-alt"></i>', 
		'linkOptions' => array(
			'title' => Yii::t('core.crud', 'Manage Files'), 
			'class' => 'btn btn-default',
		),
		'url' => array('index'),
		'visible' => Yii::app()->user->checkAccess('view_file'),
	),
);

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $this->pageHeading; ?></h3>
	</div>
	<div class="panel-body">
		<div class="form-content">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id' => 'article-form',
				'htmlOptions' => array(
					'class'=>'form-horizontal',
					'enctype'=>'multipart/form-data',
				),
				'enableClientValidation' => false,
			)); ?>
			
			<div class="form-group">
				<?php echo CHtml::label(Yii::t('file', 'Category'), 'category', array('class'=>'col-sm-3 control-label')); ?>
				<div class="col-sm-9">
					<?php echo CHtml::dropdownList('category', '', FileCategory::getList(), array(
						'class' => 'form-control',
						'prompt' => Yii::t('file', 'Without Category'),
					)); ?>
				</div>
			</div>
			
			<div class="form-group">
				<?php echo CHtml::label(Yii::t('core.crud', 'Choose Files'), 'file', array('class'=>'col-sm-3 control-label')); ?>
				<div class="col-sm-9">
					<?php echo CHtml::fileField('file[]', '', array(
						'multiple' => 'multiple',
						'id' => 'file',
					)); ?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<?php echo CHtml::submitButton(Yii::t('core.crud', 'Upload'), array('class'=>'btn btn-primary', 'name' => 'uploading')); ?>
				</div>
			</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
