<?php foreach ($users as $user): ?>
	<?php echo $user['fullname']; ?>
	<br />
<?php endforeach; ?>
		<input type="text" data-provide="typeahead" data-source='["aaaa", "aba", "aac"]' data-items="4">	