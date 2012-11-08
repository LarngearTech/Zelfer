function registerFileUploaderChangeHandle(fileuploader){
	$(fileuploader).change(function(){
		var file = this.files[0];
		$('#'+$(this).prop('id')+'-label').html(file.name);
		$(':submit').click(function(){alert("hello");});
	})
}

function btnFileUploaderClick(fileuploader){
	registerFileUploaderChangeHandle($('#'+fileuploader));
}
