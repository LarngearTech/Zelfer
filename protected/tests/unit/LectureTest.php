<?php
class LectureTest extends CDbTestCase
{
	public $fixtures = array(
		'lectures' => 'Lecture',
	);

	public function testGetEncodingPath()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		$this->assertEquals('/asset/encoding/'.$lectureId, $retrievedLecture->encodingPath);
	}

	public function testGetStreamingPath()
	{
		$retrievedLecture = $this->lectures('lecture1');
		$lectureId = $retrievedLecture->id;
		$this->assertEquals('/asset/streaming/'.$lectureId, $retrievedLecture->streamingPath);
	}
}
