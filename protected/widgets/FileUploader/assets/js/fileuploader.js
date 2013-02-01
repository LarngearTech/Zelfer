function fileUploaderChangeHandler(fileuploader){
	var file = $('#'+fileuploader).prop('files')[0];
	var prefix = '#'+$('#'+fileuploader).prop('id');
	$(prefix+'-label').html(file.name);

	// Hide file upload button and show cancel button
	$(prefix+'-upload-btn').hide();
	$(prefix+'-upload-cancel-btn').show();
	$(prefix+'-progressbar-container').removeClass('progress-success');
	$(prefix+'-progressbar-container').addClass('progress-info active');

	// Send actual upload command
	var url=$('#'+fileuploader).attr('data-url');
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
						$(prefix+'-progressbar').width(percent);

						filename = $(prefix+'-label').html();
						$(prefix+'-label').html(filename+" "+e.loaded/1000000+"kb/"+e.total/1000000+"kb");
					}
				}, 
				false); 

				// loadend
				xhr.upload.addEventListener(
				'loadend',
				function(e){
					$(prefix+'-progressbar').width('100%');
					$(prefix+'-progressbar-container').removeClass('progress-info active');
					$(prefix+'-progressbar-container').addClass('progress-success');

					$(prefix+'-upload-cancel-btn').hide();
					//$(prefix+'-delete-btn').show();
					$(prefix+'-done-btn').show();
				},
				false
				);
			}
			return xhr;
		},
		// handle cancel file upload
		beforeSend:function(){
			//var id = $(fileuploader).prop('id');
			$(prefix).replaceWith($(prefix).val("").clone(true));
			$(prefix+'-upload-cancel-btn').click(function(){
				xhr.abort();
				$(prefix+'-upload-cancel-btn').hide();
				$(prefix+'-upload-btn').show();
				$(prefix+'-progressbar').width(0);
				$(prefix+'-label').html($(prefix+'-label').attr('data-placeholder'));
			});
		},
	});
}

function doneUploadedFile(doneUrl, successHandler)
{
	$.ajax({
		url:doneUploadUrl,
		type:'POST',
		dataType:'html',
		success:successHandler
	});
}

function deleteUploadedFile(fileuploader)
{
	var prefix = '#'+fileuploader;
	$(prefix+'-upload-btn').show();
	$(prefix+'-upload-cancel-btn').hide();
	$(prefix+'-delete-btn').hide();
	$(prefix+'-label').html($(prefix+'-label').attr('data-placeholder'));
	$(prefix+'-progressbar').width('0%');
	$(prefix+'-progressbar-container').removeClass('progress-sucess');
	$(prefix+'-progressbar-container').addClass('progress-info active');

	$(prefix).replaceWith($(prefix).val("").clone(true));

	$.ajax({
		url:$('#'+fileuploader).attr('data-deleteUrl'),
		type:'POST',
		dataType:'html',
		success:function(){
		}
	});
}
