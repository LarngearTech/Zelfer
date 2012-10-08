<?php

Yii::import('ext.querypath.*');
require_once('QueryPath.php');

class QtiProcessor
{

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
}
