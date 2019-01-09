//Theme Options
var themeElements = {
	submitButton: '.submit-button',
};

//Loaded
jQuery(document).ready(function($) {
	//Submit Button
	$(themeElements.submitButton).not('.disabled').click(function() {
		var form=$($(this).attr('href'));
		
		if(!form.length || !form.is('form')) {
			form=$(this).parent();
			while(!form.is('form')) {
				form=form.parent();
			}
		}
			
		form.submit();		
		return false;
	});
	$("#all_day input").click(function(){
		if($('#all_day input').prop('checked')){			
			$('#enddate_date input').attr('disabled', 'true');
			$('#endtime_time input').attr('disabled', 'true');
		}else{
			$('#enddate_date input').removeAttr('disabled');
			$('#endtime_time input').removeAttr('disabled');
		}
	});
	if($("#all_day input").prop('checked')){
		$('#enddate_date input').attr('disabled', 'true');
		$('#endtime_time input').attr('disabled', 'true');

	}
	
});