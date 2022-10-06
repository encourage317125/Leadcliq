@extends('layouts.bootstrap')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/vendors/jquery.datetimepicker.css')}}"/ >
<link rel="stylesheet" href="{{asset('js/vendors/validator/css/bootstrapValidator.min.css')}}">
 <style>
.wizard .nav-tabs li{margin-bottom: 20px}
.wizard .nav-tabs li a{padding: 10px;color: #2A6496;  border:none;}
.wizard .nav-tabs li a:hover{background:none; border:none;}
.wizard .nav-tabs li a .number{background-color: #EEE;display: inline-block;text-align: center !important;font-size: 16px;font-weight: 300;padding: 11px 15px 13px 15px;margin-right: 10px;height: 45px;width: 45px;-webkit-border-radius: 50% !important;-moz-border-radius: 50% !important;border-radius: 50% !important;}
.wizard .nav-tabs li.active a {color: #F66C06;}
.wizard .nav-tabs li.active a .number{background-color: #F66C06;color: #FFF;}
.paging{list-style: none; margin-top: 10px; padding-left: 0}
.paging li{float:left;}
.paging .next, .paging .finish{float: right}
.wizard .btn-group{width:100%;}
.wizard .btn-default{background-color: #F69B06; margin:auto 20%; padding:15px;}
.wizard .btn-group>.btn:first-child:not(:last-child){border-radius: 4px}
.wizard .btn-group>.btn:last-child:not(:first-child){border-radius: 4px}
.wizard .btn-default:first-child{margin-left: 20%; border-radius: 4px}
.wizard .btn-default.active{background-color: #F67706}
.wizard .btn-default.active label {color: #FFF;}
.wizard #sell_for{display:none; margin:10px;}
.error{color:red;}
</style>
@stop

@section('content')
{{Former::vertical_open()->method('PUT')->action(route('apptshares.update',$apptshare->id))->role('form')->id('apptshareform')}}
{{Former::populate($apptshare)}}
@include('apptshares.form')
@stop

@section('scripts')
<script src="{{asset('js/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{asset('js/vendors/jquery.datetimepicker.js')}}"></script>
<script src="{{asset('js/vendors/validator/js/jquery.validate.min.js')}}"></script>
<script>
$('[name="sell_for"]').change(function(){
	option = $(this).val();	
	console.log(option);
	if(option == 'money')
	{
		$('#sell-money').show();
		$('#sell-points').hide();
	}
	else{
		$('#sell-money').hide();
		$('#sell-points').show();
	}
});

$(document).ready(function()
{
	if('{{(isset($apptshare)?$apptshare->sell_for:'')}}' == 'money')
	{
		$('#sell-money').show();
		$('#sell-points').hide();
	}
	else{
		$('#sell-money').hide();
		$('#sell-points').show();
	}
	$('.datetimepicker').datetimepicker({
        format: 'm/d/Y h:i A',
        minDate:0,
        minTime: 0
      });

	var $validator = $("#apptshareform").validate({
		  rules: 
		  {
		  	title: {
		  		required: true,
		  		minlength: 3
		  	},
		  	appt_datetime: {
		  		required: true,
		  		date: true
		  	},
		  	bid_datetime :{
		  		required: true,
		  		date: true
		  	},
		  	address:{
		  		required:true
		  	},
		  	zip:{
		  		required:true,
		  		minlength:5
		  	},
		  	gen_address_info:{
		  		required: true
		  	},
		  	special_address_info:{
		  		required: true
		  	},
		  	manager_name:{
		  		required: true,
		  		minlength: 3
		  	},
		  	manager_title:{
		  		required: true,
		  		minlength: 3
		  	},
		  	company_size:{
		  		required: true
		  	},
		  	industry:{
		  		required: true
		  	},
		  	project_size:{
		  		required: true
		  	},
		  	meeting_description:{
		  		required: true
		  	},
		  	sell_for:{
		  		required: true
		  	},


		  }
		});
 
});
$('#apptsharewizard').bootstrapWizard({
	'tabClass': 'nav nav-tabs',
	'onInit' : function(tab, navigation, index){
		var total = navigation.find('li').length;
		navigation.find('li').css('width',100/total+'%');
	},
	'onNext': function(tab, navigation, index) {
		var $valid = $("#apptshareform").valid();
		if(!$valid) 
		{
			$validator.focusInvalid();
			return false;
		}
	},
	onTabClick: function(tab, navigation, index) 
	{
		alert('Use next field to navigate');
		return false;
	},
	onTabShow: function(tab, navigation, index) 
	{
		var $total = navigation.find('li').length;
		var $current = index+1;
		var $percent = Math.round($current/$total*10000)/100;

		$('#apptsharewizard').find('.progress-bar').css({width:$percent+'%'}).attr('aria-valuenow',$percent).find('.sr-only').text($percent+'% Complete');
		
		// If it's the last tab then hide the last button and show the finish instead
		if($current == 1){
			$('#apptsharewizard').find('.paging .previous').hide();
		}else{
			$('#apptsharewizard').find('.paging .previous').show();
		}
		if($current >= $total) {
			$('#apptsharewizard').find('.paging .next').hide();
			$('#apptsharewizard').find('.paging .finish').show();
			$('#apptsharewizard').find('.paging .finish').removeClass('disabled');
		} else {
			$('#apptsharewizard').find('.paging .next').show();
			$('#apptsharewizard').find('.paging .finish').hide();					
		}
		
	}
		});
$('a#add-checkpoint').click(function()
{
	i = $('#checkpoints').children().length;
	console.log(i);
	checkpoint = '<div id="checkpoint-'+i+'" class="checkpoint">	<b class="container"><em>Check Point '+i+':</em></b>	<div class="row">	<div class="col-sm-8">	<input placeholder="Enter checkpoint title" class="form-control" name="checkpoint_'+i+'_title" type="text">	</div>	<div class="col-sm-4">	<input placeholder="Checkpoint price" class="form-control" name="checkpoint_'+i+'_amount" type="text">	</div>	</div>	<div class="clear">&nbsp;</div>	<div class="form-group">	<textarea placeholder="Enter checkpoint description" class="form-control" name="checkpoint_'+i+'_description" cols="50" rows="10"></textarea>	</div>	</div>';

	$('a#add-checkpoint').before(checkpoint);
	$(this).attr('href','#checkpoint-'+i);	
});

$('[name="pay_option"]').change(function(){
	option = $(this).val();
	console.log(option+' selected');
	if(option == "one_price")
	{
		$('#checkpoints').hide();
		$('#price').show();
	}
	else
	{
		$('#checkpoints').show();		
		$('#price').hide();
	}
});
</script>

@stop