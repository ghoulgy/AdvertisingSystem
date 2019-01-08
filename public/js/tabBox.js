$(function() {
    $('#service-provider-link').click(function(e) {
		$("#service-provider-form").delay(100).fadeIn(100);
 		$("#demand-form").fadeOut(100);
		$('#demand-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	$('#demand-form-link').click(function(e) {
		$("#demand-form").delay(100).fadeIn(100);
 		$("#service-provider-form").fadeOut(100);
		$('#service-provider-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
});
