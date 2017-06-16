

<!-- start AllTabMenuPor1 Select JavaScript Files -->
// tab
$('#AllTabMenuPor1 a:first').tab('show');

//for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
//save the latest tab; use cookies if you like 'em better:
localStorage.setItem('selectedTab', $(e.target).attr('id'));
});

//go to the latest tab, if it exists:
var selectedTab = localStorage.getItem('selectedTab');
if (selectedTab) {
  $('#'+selectedTab).tab('show');
}

<!-- end AllTabMenuPor1 Select JavaScript Files -->



<!-- start InnerTablist1 Select JavaScript Files -->
// tab
$('#InnerTablist1 a:first').tab('show');

//for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
//save the latest tab; use cookies if you like 'em better:
localStorage.setItem('selectedTab', $(e.target).attr('id'));
});

//go to the latest tab, if it exists:
var selectedTab = localStorage.getItem('selectedTab');
if (selectedTab) {
  $('#'+selectedTab).tab('show');
}

<!-- end InnerTablist1 Select JavaScript Files -->



<!-- start InnerTablist1 Select JavaScript Files -->
// tab
$('#CategoryInnerTabPor1 a:last').tab('show');

//for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
//save the latest tab; use cookies if you like 'em better:
localStorage.setItem('selectedTab', $(e.target).attr('id'));
});

//go to the latest tab, if it exists:
var selectedTab = localStorage.getItem('selectedTab');
if (selectedTab) {
  $('#'+selectedTab).tab('show');
}

<!-- end InnerTablist1 Select JavaScript Files -->


<!-- start InnerTablist1 Select JavaScript Files -->
// tab
$('#CalendarInnerTabPor1 a:last').tab('show');

//for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
//save the latest tab; use cookies if you like 'em better:
localStorage.setItem('selectedTab', $(e.target).attr('id'));
});

//go to the latest tab, if it exists:
var selectedTab = localStorage.getItem('selectedTab');
if (selectedTab) {
  $('#'+selectedTab).tab('show');
}


<!-- end InnerTablist1 Select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI10CBAll1").change(function () {
    $("#TabInfo10Part2 #ITPor1 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI10CBAll2").change(function () {
    $("#TabInfo10Part2 #ITPor2 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI10CBAll3").change(function () {
    $("#TabInfo10Part2 #ITPor3 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI10CBAll4").change(function () {
    $("#TabInfo10Part2 #ITPor4 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI10CBAll5").change(function () {
    $("#TabInfo10Part2 #ITPor5 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->


<!-- start ContentListing Checkbox All select JavaScript Files -->
$("#ContentSelect").change(function () {
    $("#content-listing #main-listing .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end ContentListing Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Select Option Value -->

$(function() {
	jcf.replaceAll();
});

<!-- end InnerTablist1 Select Option Value -->


<!-- start Date Picker format -->

$(document).ready(function () {
		
		$('#datepicker').datepicker({
			format: "dd-mm-yyyy"
		});  
	});

<!-- end Date Picker format -->

<!-- start Date Picker format -->

//$(document).ready(function () {
//		
//		$('#datepicker1').datepicker({
//			format: "dd-mm-yyyy"
//		});  
//	});
<!-- end Date Picker format -->

<!-- start Date Picker format -->

$(document).ready(function () {
		
		$('#datepicker2').datepicker({
			format: "dd-mm-yyyy"
		});  
	});

<!-- end Date Picker format -->



<!-- start Date Picker format -->

$(document).ready(function () {
		
		$('#datepicker3').datepicker({
			format: "dd-mm-yyyy"
		});  
	});

<!-- end Date Picker format -->

<!-- start Date Picker format -->

$(document).ready(function () {
		
		$('#datepicker4').datepicker({
			format: "dd-mm-yyyy"
		});  
	});

<!-- end Date Picker format -->

<!-- Start Time Picker  -->

$(document).ready(function () {
	$('#ClnTimePick').timepicki();
	$('#ClnTimePick1').timepicki();
	$('#ClnTimePick2').timepicki();
	$('#ClnTimePick3').timepicki();
});
<!-- End Time Picker  -->

/* Start CountDown */

$('#CountDown1').countdown({
			date: '12/24/2015 23:59:59',
			offset: -8,
			day: 'Day',
			days: 'Days'
		}, function () {
			//alert('Done!');
		});

/* End CountDown */



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI12CBAll1").change(function () {
    $("#TabInfo12Part2 #ITcPor1 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI12CBAll2").change(function () {
    $("#TabInfo12Part2 #ITcPor2 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI12CBAll3").change(function () {
    $("#TabInfo12Part2 #ITcPor3 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI12CBAll4").change(function () {
    $("#TabInfo12Part2 #ITcPor4 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->



<!-- start InnerTablist1 Checkbox All select JavaScript Files -->
$("#TI12CBAll5").change(function () {
    $("#TabInfo12Part2 #ITcPor5 .table input:checkbox").prop('checked', $(this).prop("checked"));
});

<!-- end InnerTablist1 Checkbox All select JavaScript Files -->
