<div>
	<table id='instructorTable'>
		<tr><td><?php echo CHtml::label('Instructor Name', false) ?></td></tr>
	</table>
	<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'instructor-form',
						'enableAjaxValidation'=>false,
						'htmlOptions' => array('enctype' => 'multipart/form-data',
								'onsubmit'=>'return submitForm();',)
	)); ?>
		<input type="hidden" id="instructorId"/>
		<?php echo CHtml::label('Instructors'.'<span class="required">*</span>', false) ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'id'	=> 'instructor',
							'name'	=> 'instructor',
							'source'=> $this->createUrl('course/instructorList'),
							'options'=>array(
									'showAnim'=>'fold',
									'select'=>"js: function(event, ui) {
											$('#instructorId').val(ui.item.id);
										}",
     									'change'=>"js: function(event, ui) {
											$('#instructor').val('');
											$('#instructorId').val('');
										}"
									),
							'htmlOptions'=>array('size'=>60,
									'maxlength'=>255,
									'autocomplete'=>'off'),
        	    ));
		?>
		<?php
			echo CHtml::button("Add instructor", array('onclick'=>'addInstructor()'));
			echo CHtml::submitButton("Save");
		?>
	<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
function addInstructor()
{
	if ($('#instructorId').val() != "")
	{
		table = document.getElementById('instructorTable');
		newRow = table.insertRow(table.rows.length);
		
		// First column instructor's name
		nameCell = newRow.insertCell(0);
		nameCell.innerHTML = $('#instructor').val();
	
		// Second column provides a button to delete instructor
		idCell = newRow.insertCell(1);
		// Create button
		delButton = document.createElement("button");
		delButton.id = $('#instructorId').val();
		// Add caption
		delButtonCaption = document.createTextNode("Delete");
		delButton.appendChild(delButtonCaption);
		// Add event listener
		el = document.createAttribute("onclick");
		el.nodeValue = "deleteInstructor("+$('#instructorId').val()+")";
		delButton.setAttributeNode(el);

		idCell.appendChild(delButton);

	}
}

function deleteInstructor(instructorId)
{
	table = document.getElementById('instructorTable');
	rowCount = table.rows.length;
	for (i = 1;i < rowCount;i++)
	{
		// Compare instructorId and id of delete button
		if (table.rows[i].cells[1].childNodes[0].id == instructorId)
		{
			table.deleteRow(i);
			break;
		}
	}
}

function submitForm()
{
	table = document.getElementById('instructorTable');
	rowCount = table.rows.length;
	for (i = 1;i < rowCount;i++)
	{
		instructorId = table.rows[i].cells[1].childNodes[0].id;
		
		// Create hidden element
		ele = document.createElement("input");
		ele.type	=	"hidden";
		ele.name	=	"instructorIdList["+(i-1)+"]";
		ele.value	=	instructorId;

		document.forms['instructor-form'].appendChild(ele);
	}
	return true;
}

</script>
