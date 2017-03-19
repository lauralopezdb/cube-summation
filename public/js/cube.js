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
	       	if (typeof(data) == 'object') {
	       		operate(data);
	       	} else {
	       		$('textarea[name="outputText"]')[0].value = '';
	        	$("#errorMessage").html(data);
	       	}
       }
    });
}

function operate(data) {
	$.ajax({
       type:'POST',
       url:'/process-test-cases',
       data: { 'testCases': data },
       success:function(result){
       		$("#errorMessage").html('');
       		$('textarea[name="outputText"]')[0].value = result.join("\n");
       }
	});	
}