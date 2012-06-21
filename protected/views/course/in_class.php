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
	$lecturesTabContent .= '<div class="accordion" id="chapter-accordion">';
	foreach ($chapters as $chapter)
	{
		$chapIdx++;
		/*$lecturesTabContent .= '<ul class="collapsible"><span class="caption" style="margin-left:-1.5em;">'.Yii::t('site', 'Chapter').' '.$chapIdx.' '.CHtml::encode($chapter->name).'</span>';

		// create a lecture list
		$lectIdx = 0;
		foreach ($chapter->lectures as $lecture)
		{
			$lecturesTabContent .= '<li>'.CHtml::encode($lecture->name).'</li>';
		}
		$lecturesTabContent .= '</ul>';*/
		$lecturesTabContent .= '
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#chapter-accordion" href="#chapter'.$chapIdx.'-collapse">
						'.Yii::t('site', 'Chapter').' '.$chapIdx.' '.CHtml::encode($chapter->name).'
						</a>
					</div>
					<div id="chapter'.$chapIdx.'-collapse" class="accordion-body collapse">
						<div class="accordion-inner">
							test
						</div>
					</div>
				</div>
		';
	}

// create contant of the lecture tab
$lecturesTab = array(
	'label' => 'Lecture',
	'content' => $lecturesTabContent,
	'active' => true,
);

$problemSetsTab = array(
	'label' => 'Problem Set',
	'content' => 'problemset',
);

// create course tabs including lecture and problem set tabs.
$courseTabs = array($lecturesTab, $problemSetsTab);
$this->widget('EBootstrapTabNavigation', array(
	'items' => array(
		array('label' => 'Lecture', 'url' => '#lecture', 'active' => true),
		array('label' => 'Problem Set', 'url' => '#problemset'),
	),
));

$this->beginWidget('EBootstrapTabContentWrapper');
	$this->beginWidget('EBootstrapTabContent', array(
		'active' => true,
		'id' => 'lecture',
	));
	echo $lecturesTabContent;
	$this->endWidget();
	$this->beginWidget('EBootstrapTabContent', array(
		'active' => true,
		'id' => 'problemset',
	));
	echo 'Problem set';
	$this->endWidget();
$this->endWidget();
?>
</div>
