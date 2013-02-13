<?php foreach ($ingroupusers as $user): ?>
	<?php echo $user['fullname']; ?>
	<br />
<?php endforeach; ?>
		<input type="text" data-provide="typeahead" data-source='[<?php echo '"'.implode('","', $otherusers).'"';?>]' data-items="4">	