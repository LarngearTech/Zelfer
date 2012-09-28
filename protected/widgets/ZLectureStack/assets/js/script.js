$(document).ready(function() {
	$("a.accordion-body .chapter").click(function(e) {
		alert(this.id);
	});
	$(".playbutton").click(function(e) {
		ajaxUrl = "<?php echo $this->createUrl("course/changeVideo") ?>";
		$.ajax({
			url : ajaxUrl,
			data : {
					videoId : this.id
					},
			dataType : "html",
			success : function(html){$("#lecture-content-wrapper").html(html);}
		});
	});
});

