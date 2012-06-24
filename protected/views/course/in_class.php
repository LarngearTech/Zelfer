<?php
$this->breadcrumbs = array(
	Yii::t('site', 'Courses') => array('index'),
	$model->name,
);
?>

<h1><?php echo CHtml::encode($model->name); ?></h1>
<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->courseInstructorsShortString);?></h3>

<br/>
<div id="course-syllabus">
	<?php
	// create contents for the lecture tab 
	$chapIdx = 0;
	$lecturesTabContent = '<div class="accordion" id="chapter-accordion">';
	foreach ($chapters as $chapter)
	{
		$chapIdx++;
		$lecturesTabContent .= '
			<div class="accordion-group">
				<div class="accordion-heading">
					<h4><a class="accordion-toggle" data-toggle="collapse" data-parent="#chapter-accordion" href="#chapter'.$chapIdx.'-collapse">
						'.Yii::t('site', 'Chapter').' '.$chapIdx.' '.CHtml::encode($chapter->name).'
					</a></h4>
				</div>
				<div id="chapter'.$chapIdx.'-collapse" class="accordion-body collapse'.(($chapIdx == 1)?' in':'').'">
					<div class="accordion-inner">
						<ul>';
		// create a lecture list
		foreach ($chapter->lectures as $lecture)
		{
			$lecturesTabContent .= 
				'<li class="lecture">
					<div class="lecture-name">
						<h4><a href="#">'.CHtml::encode($lecture->name).'
						<img src="'.Yii::app()->baseUrl.'/images/play.png" class="icon play"></a></h4>
					</div>
					<div class="lecture-items well">
						<a href="#"><img src="'.Yii::app()->baseUrl.'/images/slide.png" class="icon material"></a>
						<a href="#"><img src="'.Yii::app()->baseUrl.'/images/video.png" class="icon material"></a>
					</div>	
				</li>';
		}
		$lecturesTabContent .= '</ul>
					</div>
				</div>
			</div>
		';
	}
	$lecturesTabContent .= '</div>'; 

// create course tabs including lecture and problem set tabs.
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
		'id' => 'problemset',
	));
	echo 'Problem set';
	$this->endWidget();
$this->endWidget();
?>
</div>
