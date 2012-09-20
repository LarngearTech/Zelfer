<?php
echo CHtml::link(
// image to be linked
CHtml::image($thumbnailUrl, CHtml::encode('Course thumbnail: '.$courseName), array(
'height' => '180',
)).
'<h5>'.CHtml::encode($courseName).'</h5>
<p>'.CHtml::encode($courseShortDescription).'</p>',
// url to course/view?id=course_id
$courseUrl,
// class for tag a href
array('class' => $css)
);
?>
