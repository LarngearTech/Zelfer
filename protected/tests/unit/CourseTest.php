<?php
class CourseTest extends CDbTestCase
{
	public $fixtures = array(
		'courses' => 'Course',
	);

	public function testGetThumbnailUrl()
	{
		$retrievedCourse = $this->courses('course1');
		$courseId = $retrievedCourse->id;
		$this->assertEquals('/asset/thumbnail/'.$courseId, $retrievedCourse->thumbnailUrl);
	}

	public function testGetEncodingPath()
	{
		$retrievedCourse = $this->courses('course1');
		$courseId = $retrievedCourse->id;
		$this->assertEquals('/asset/encoding/'.$courseId, $retrievedCourse->encodingPath);
	}

	public function testGetStreamingPath()
	{
		$retrievedCourse = $this->courses('course1');
		$courseId = $retrievedCourse->id;
		$this->assertEquals('/asset/streaming/'.$courseId, $retrievedCourse->streamingPath);

	}
}
