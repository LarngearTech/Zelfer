<?php

Yii::import('ext.querypath.*');
require_once('QueryPath.php');

class QtiProcessor
{

	public $XMLNS = "http://www.imsglobal.org/xsd/imsqti_v2p1";
	public $XMLNS_XSI = "http://www.w3.org/2001/XMLSchema-instance";
	public $XSI_SCHEMALOCATION = "http://www.imsglobal.org/xsd/imsqti_v2p1 http://www.imsglobal.org/xsd/imsqti_v2p1.xsd";

	/**
	 * Parse one AssessmentItem from QTI XML.
	 */
	function parseAssessmentItem($file)
	{
		$qp = qp($file, 'assessmentItem');
		$item = array();
		$item['title'] = $qp->attr('title');
		$item['type'] = $qp->attr('identifier');
		$answers = array();
		$correctValues = $qp->find('responseDeclaration>correctResponse>value');
		foreach ($correctValues as $value)
		{
			$answers[] = $value->text();
		}
		$item['answers'] = $answers;

		$type = strtolower($item['type']);
		// Handle multiple choice questions:
		if ($type == 'choice' or $type == 'choicemultiple')
		{
			$choiceInteraction = $qp->parent('assessmentItem')->find('itemBody>choiceInteraction');
			$shuffle = $choiceInteraction->attr('shuffle');
			$maxChoices = $choiceInteraction->attr('maxChoices');
			$prompt = $choiceInteraction->find('prompt')->text();
			$choices = array();

			// First, get all answers and loop through them.
			$simpleChoices = $choiceInteraction->parent('choiceInteraction')->find('simpleChoice');
			foreach ($simpleChoices as $simpleChoice) {

				$text = $simpleChoice->text();
				$value = $simpleChoice->attr('identifier');

				$choices[] = array(
				'text' => $text,
				'value' => $value,
				);
			}
			// Store choices
			$item['shuffle'] = $shuffle;
			$item['maxChoices'] = $maxChoices;
			$item['prompt'] = $prompt;
			$item['choices'] = $choices;
		}
		else if ($type == 'extendedText')
		{
			$extendedTextInteraction = $qp->parent('assessmentItem')->find('itemBody>extendedTextInteraction');
			$ansLen = $extendedTextInteraction->attr('expectedLength');
			$prequestion = $extendedTextInteraction->find('p')->text();
			$imageUrl = $extendedTextInteraction->find('img')->attr('src');
			$prompt = $extendedTextInteraction->find('prompt')->text();
			
			// Store data
			$item['prequestion'] = $prequestion;
			$item['imageUrl'] = $imageUrl;
			$item['prompt'] = $prompt;
			$item['ansLen'] = $ansLen;
		}
		return $item;
	}

	/**
	 * Create QTI XML from items
	 */
	function createQtiXmlItem($item)
	{
		$qp = qp()->append('<assessmentItem identifier="'.$item['type'].'" title="'.$item['title'].'"></assessmentItem>');
		$type = strtolower($item['type']);
		// type: select one choice
		if ($type == 'choice')
		{
			$qp->find(':root')
				->append('<responseDeclaration identifier="RESPONSE" cardicality="single" baseType="identifier"></responseDeclaration>')
				->children('responseDeclaration')
				->append('<correctResponse></correctResponse>')
				->children('correctResponse')
				->append('<value>'.$item['answers'][0].'</value>');
			$qp->find(':root')->append('<itemBody></itemBody>');
			$qp = $this->appendChoiceInteraction($qp, $item['prompt'], $item['choices'], $item['shuffle'], $item['maxChoices']);
		}
		// type: select multiple choices
		else if ($type == 'choicemultiple')
		{
			$qp->find(':root')
				->append('<responseDeclaration identifier="RESPONSE" cardicality="multiple" baseType="identifier"></responseDeclaration>')
				->children('responseDeclaration')
				->append('<correctResponse></correctResponse>')
				->children('correctResponse');
			foreach ($item['answers'] as $answer)
			{
				$qp->append('<value>'.$answer.'</value>');
			}
			$qp->find(':root')->append('<itemBody></itemBody>');
			$qp = $this->appendChoiceInteraction($qp, $item['prompt'], $item['choices'], $item['shuffle'], $item['maxChoices']);
		}
		// type: fill shot text in-line in the paragraph (note: not done)
		else if ($type == 'textentry')
		{
			$qp->find(':root')
				->append('<responseDeclaration identifier="RESPONSE" cardicality="single" baseType="string"></responseDeclaration>')
				->children('responseDeclaration')
				->append('<correctResponse></correctResponse>')
				->children('correctResponse')
				->append('<value>'.$item['answers'][0].'</value>');
			$qp->find(':root')->append('<itemBody></itemBody>');
			$qp = $this->appendTextEntryInteraction($qp);
		} 
		// type: fill text answer after the paragraph/question
		else if ($type == 'extendedtext')
		{
			$qp->find(':root')
				->append('<responseDeclaration identifier="RESPONSE" cardicality="single" baseType="string"></responseDeclaration>')
				->children('responseDeclaration')
				->append('<correctResponse></correctResponse>')
				->children('correctResponse')
				->append('<value>'.$item['answers'][0].'</value>');
			$qp->find(':root')->append('<itemBody></itemBody>');
			
			// Set default value if not specified
			$item['prequestion'] = array_key_exists('prequestion', $item) ? $item['prequestion'] : '';
			$item['imageUrl'] = array_key_exists('imageUrl', $item) ? $item['imageUrl'] : '';
			$item['prompt'] = array_key_exists('prompt', $item) ? $item['prompt'] : '';
			$item['ansLen'] = array_key_exists('ansLen', $item) ? $item['ansLen'] : 50;

			$qp = $this->appendExtendedTextInteraction($qp, $item['prequestion'], $item['imageUrl'], $item['prompt'], $item['ansLen']);
		}
		return $qp->top()->xml();
	}

	function appendChoiceInteraction($qp, $prompt, $choices, $shuffle, $maxChoices)
	{
		$qp = $qp->find('itemBody')
					->append('<choiceInteraction responseIdentifier="RESPONSE" shuffle="'.$shuffle.'" maxChoices="'.$maxChoices.'"></choiceInteraction>')
					->children('choiceInteraction')
					->append('<prompt>'.$prompt.'</prompt>');
		foreach ($choices as $value => $text)
		{
			$qp = $qp->append('<simpleChoice identifier="'.$value.'" fixed="false">'.$text.'</simpleChoice>');
		}
		return $qp;
	}

	function appendTextEntryInteraction($qp)
	{
	}

	function appendExtendedTextInteraction($qp, $prequestion, $imageUrl, $prompt, $ansLen)
	{
		$qp = $qp->find('itemBody')
				->append('<p>'.$prequestion.'</p>');
		if ($imageUrl != '')
		{
			$qp = $qp->find('itemBody')
				->append('<img src="'.$imageUrl.'" />');
		}
		$qp = $qp->find('itemBody')
				->append('<extendedTextInteraction responseIdentifier="RESPONSE" expectedLength="'.$ansLen.'"></extendedTextInteraction>')
				->children('extendedTextInteraction')
				->append('<prompt>'.$prompt.'</prompt>');
		return $qp;
	}
}
