function registerFileUploaderChangeHandle(fileuploader)
{
	$(fileuploader).change(function() {
		var file = this.files[0];
		$('#'+$(this).prop('id')+'-label').html(file.name);

		// Hide file upload button and show cancel button
		$('#'+$(this).prop('id')+'-upload-btn').hide();
		$('#'+$(this).prop('id')+'-upload-cancel-btn').show();

		// Send actual upload command
		var url = $(fileuploader).attr('data-url');
		var formdata = new FormData();
		formdata.append('uploadedFile', file);
		$.ajax({
			url:url,
			type:'POST',
			data:formdata,
			processData:false,
			contentType:false,
			cache:false,
			xhr:function(){
				xhr = $.ajaxSettings.xhr();
				if(xhr.upload){
					// update progress bar
					xhr.upload.addEventListener(
					'progress', 
					function(e){
						if (e.lengthComputable)
						{
							var percent=e.loaded/e.total*100;
							percent=percent+"%";
							$('#'+$(fileuploader).prop('id')+'-progressbar').width(percent);

							filename = $('#'+$(fileuploader).prop('id')+'-label').html();
							$('#'+$(fileuploader).prop('id')+'-label').html(filename+" "+e.loaded/1000000+"kb/"+e.total/1000000+"kb");
						}
					}, 
					false); 
				}
				return xhr;
			},
			// handle cancel file upload
			beforeSend:function(){
				$('#'+$(fileuploader).prop('id')+'-upload-cancel-btn').click(function(){
					xhr.abort();
				});
			},
			success:function(html){
				//alert(html);
			}
		});
	})
}

function btnFileUploaderClick(fileuploader){
	registerFileUploaderChangeHandle($('#'+fileuploader));
}
