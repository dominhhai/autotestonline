index=1;
total = parseInt($('#total').text());
$(document).ready(function(){
	$('#next').click(function(){
		if(index<total){
			var tmp='#content'+index;
			$(tmp).hide();
			index=index+1;
			var tmp='#content'+index;
			$(tmp).show();
                        if(index == total)
                            {
                                $('#next').hide();
                            }
		}
	});
	$('.listquestion').change(function(){
		var tmp = parseInt($('.listquestion').val());
		if(tmp!=0)
		{
			$('#content'+index).hide();
			index = tmp;
			$('#content'+index).show();
                        if(index == total) $('#next').hide();
                        else $('#next').show();
		}
	});
});
function countdown() {
    var m = $('.min');
    var s = $('.sec');  
    if(m.length == 0 && parseInt(s.html()) <= 0) {
        $('.login-date').html('Timer Complete.');
        document.testForm.submit();return false; 
    }
    if(parseInt(s.html()) <= 0) {
        m.html(parseInt(m.html()-1));   
        s.html(60);
    }
    if(parseInt(m.html()) <= 0) {
        $('.login-date').html('TIME: <span class="sec">59</span> seconds.'); 
    }
    s.html(parseInt(s.html()-1));
}
function countup() {
    var t=parseInt($('#testtime'+index).val());
    $('#testtime'+index).val(t+1);
    $('.testtimeview'+index).html(t+1);
}
setInterval('countdown()',1000);
setInterval('countup()',1000);
