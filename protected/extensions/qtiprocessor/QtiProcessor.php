<?php

Yii::import('ext.querypath.*');
require_once('QueryPath.php');

class QtiProcessor
{

	public $XMLNS = "http://www.imsglobal.org/xsd/imsqti_v2p1";
	public $XMLNS_XSI = "http://www.w3.org/2001/XMLSchema-instance";
	public $XSI_SCHEMALOCATION = "http://www.imsglobal.org/xsd/imsqti_v2p1 http://www.imsglobal.org/xsd/imsqti_v2p1.xsd";

	/**
	 * Parse QTI file in XML format to an array of items
	 */
	function parseAssessmentItems($file)
	{
		$items = array();

		foreach (qp($file, 'assessmentItem') as $item)
		{
			$new_item = array();

			// item's title and type
			$title = $item->attr('title');
			$type = $item->attr('identifier');

			// item's correct answers
			$answers = array();
			$correctValues = $item->find('responseDeclaration>correctResponse>value');
			foreach ($correctValues as $value)
			{
				$answers[] = $value->text();
			}

			$new_item['title'] = $title;
			$new_item['type'] = $type;
			$new_item['answers'] = $answers;

			// Handle multiple choice questions:
			if (strtolower($type) == 'choice' or strtolower($type) == 'choicemultiple')
			{
				$choiceInteraction = $item->parent('assessmentItem')->find('itemBody>choiceInteraction');
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
				$new_item['shuffle'] = $shuffle;
				$new_item['maxChoices'] = $maxChoices;
				$new_item['prompt'] = $prompt;
				$new_item['choices'] = $choices;
			}
			// Store questions
			$items[] = $new_item;
		}
		return $items;
	}

	/**
	 * Create QTI XML from items
	 */
	function createQtiXmlItem($item)
	{
		$qp = qp()->append('<assessmentItem></assessmentItem>');
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
		print htmlspecialchars($qp->top()->xml());
	}

	function appendChoiceInteraction($qp, $prompt, $choices, $shuffle, $maxChoices)
	{
		$qp = $qp->find('itemBody')
					->append('<choiceInteraction responseIdentifier="RESPONSE" shuffle="'.$shuffle.'" maxChoices="'.$maxChoices.'"></choiceInteraction>')
					->children('choiceInteraction')
					->append('<prompt>'.$prompt.'</prompt>');
		foreach ($choices as $choice)
		{
			$qp = $qp->append('<simpleChoice identifier="'.$choice['value'].'" fixed="false">'.$choice['text'].'</simpleChoice>');
		}
		return $qp;
	}
}
