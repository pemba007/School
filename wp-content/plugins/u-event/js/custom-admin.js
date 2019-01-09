jQuery(document).ready(function($) {
	$("#all_day input").click(function(){
		if($('#all_day input').prop('checked')){			
			$('#u-enddate #u-enddate-cmb-field-0-time').attr('disabled', 'true');
			$('#u-startdate #u-startdate-cmb-field-0-time').attr('disabled', 'true');
			$('#u-enddate #u-enddate-cmb-field-0-time').val('');
			$('#u-startdate #u-startdate-cmb-field-0-time').val('');
		}else{
			$('#u-enddate #u-enddate-cmb-field-0-time').removeAttr('disabled');
			$('#u-startdate #u-startdate-cmb-field-0-time').removeAttr('disabled');
		}
	});
	if($("#all_day input").prop('checked')){
		$('#u-enddate #u-enddate-cmb-field-0-time').attr('disabled', 'true');
		$('#u-startdate #u-startdate-cmb-field-0-time').attr('disabled', 'true');
		$('#u-enddate #u-enddate-cmb-field-0-time').val('');
		$('#u-startdate #u-startdate-cmb-field-0-time').val('');
	}
	
});