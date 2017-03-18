function validate() {
	var inputText = $('textarea[name="inputText"]')[0].value;
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$.ajax({
       type:'POST',
       url:'/validate-input',
       data: { 'inputText': inputText },
       success:function(data){
       	if (Array.isArray(data)) {
       		//Send test cases
       	} else {
        	$("#errorMessage").html(data);
       	}
       	console.log(data);
       }
    });
}