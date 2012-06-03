<?php
class CourseTest extends CDbTestCase
{
	public $fixtures = array(
		'courses' => 'Course',
	);

	public function testGetThumbnailUrl()
	{
		$retrievedCourse = $this->courses('course1');
		$this->assertTrue($retrievedCourse instanceof Course);
		$courseId = $retrievedCourse->id;
		$this->assertEquals('/asset/thumbnail/'.$courseId, $retrievedCourse->thumbnailUrl);
	}

	/*public function testGetEncodingPath()
	{

	}

	public function testGetStreamingPath()
	{

	}*/
}
