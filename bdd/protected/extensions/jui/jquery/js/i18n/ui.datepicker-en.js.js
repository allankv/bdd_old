/* Brazilian initialisation for the jQuery UI date picker plugin. */
/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
jQuery(function($){
	$.datepicker.regional['en'] = {
		closeText: 'Close',
		prevText: '&#x3c;Last',
		nextText: 'Next&#x3e;',
		currentText: 'Today',
		monthNames: ['January','February','March','April','May','June',
		'July','August','September','October','November','December'],
		monthNamesShort: ['Jan','Fev','Mar','Apr','May','Jun',
		'Jul','Aug','Sep','Oct','Nov','Dec'],
		dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
		dayNamesShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
		dayNamesMin: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['en']);
});


