<?php
$this->breadcrumbs=array(
	Yii::t('site', 'Courses') => array('index'),
	$model->name,
);
?>

<h1><?php echo CHtml::encode($model->name); ?></h1>
<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->instructors[0]->fullname); 
	$numIns = count($model->instructors);
	if ($numIns == 2)
	{
		echo ' '.Yii::t('site', 'and').' '.CHtml::encode($model->instructors[1]->fullname);
	}
	else if ($numIns > 2)
	{
		echo ' '.Yii::t('site', 'and {numIns} others.', array(
			'{numIns}' => $numIns
		));
	}?>
</h3>
<br/>
<div id="course-syllabus">
	<?php
	// create contents for the lecture tab 
	$this->widget('ext.slidetoggle.ESlidetoggle', array(
		'itemSelector' => 'ul.collapsible',
		'collapsed' => 'ul.collapsible',
		'titleSelector' => 'ul.collapsible .caption',
	));
	$lecturesTabContent = '';
	$chapIdx = 0;
	foreach ($chapters as $chapter)
	{
		$chapIdx++;
		$lecturesTabContent .= '<ul class="collapsible"><span class="caption" style="margin-left:-1.5em;">'.Yii::t('site', 'Chapter').' '.$chapIdx.' '.CHtml::encode($chapter->name).'</span>';

		// create a lecture list
		$lectIdx = 0;
		foreach ($chapter->lectures as $lecture)
		{
			$lecturesTabContent .= '<li>'.CHtml::encode($lecture->name).'</li>';
		}
		$lecturesTabContent .= '</ul>';
	}

// create contant of the lecture tab
$lecturesTab = array(
	'label' => 'Lecture',
	'content' => $lecturesTabContent,
	'active' => true,
);

// create contents of the problem set tab
$problemSetsTab = array(
	'label' => 'Problem Set',
	'content' => 'problemset',
);

// create course tabs including lecture and problem set tabs.
$courseTabs = array($lecturesTab, $problemSetsTab);
$this->widget('bootstrap.widgets.BootTabbable', array(
	'type'=>'tabs',
	'placement' => 'top',
	'tabs' => $courseTabs,
));
?>
</div>
