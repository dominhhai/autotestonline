$(document).ready(function(){
	var yearNow = new Date().getFullYear() -10;
	var yearLast = parseInt(yearNow) + 110;
	jQuery(function($){
		$.datepicker.regional['ja'] = {
			closeText: '閉じる',
			prevText: '&#x3c;前',
			nextText: '次&#x3e;',
			currentText: '今日',
			monthNames: ['1月','2月','3月','4月','5月','6月',
			'7月','8月','9月','10月','11月','12月'],
			monthNamesShort: ['1月','2月','3月','4月','5月','6月',
			'7月','8月','9月','10月','11月','12月'],
			dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
			dayNamesShort: ['日','月','火','水','木','金','土'],
			dayNamesMin: ['日','月','火','水','木','金','土'],
			weekHeader: '週',
			dateFormat: 'yy-mm-dd',
			firstDay: 0,
			isRTL: false,
			showMonthAfterYear: true,
			yearSuffix: '年',
			yearRange: yearNow +":"+ yearLast,
			changeMonth: true,
			changeYear: true};
		$.datepicker.setDefaults($.datepicker.regional['ja']);
	});
	$('.datepicker').attr('readonly', true);
	$( "#mindate" ).datepicker({
		onSelect: function( selectedDate ) {
			$( "#maxdate" ).datepicker( "option", "minDate", selectedDate );
		}, 
	});
	$( "#maxdate" ).datepicker({
		onSelect: function( selectedDate ) {
			$( "#mindate" ).datepicker( "option", "maxDate", selectedDate );
		}, 
	});
}
);