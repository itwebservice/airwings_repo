<?php 
class enquiry_master{

///////////////////////***Enquiry Master Save start*********//////////////
function enquiry_master_save(){

  $login_id = $_POST["login_id"]; 
  $enquiry_type = $_POST['enquiry_type'];
  $enquiry = $_POST['enquiry'];
  $name = $_POST["name"]; 
  $mobile_no = $_POST["mobile_no"]; 
  $landline_no = $_POST["landline_no"];
  $email_id = $_POST["email_id"];
  $location = $_POST["location"];
  $assigned_emp_id = $_POST['assigned_emp_id'];
  $enquiry_specification = $_POST["enquiry_specification"]; 
  $enquiry_date = $_POST["enquiry_date"]; 
  $followup_date = $_POST["followup_date"];
  $reference_id = $_POST['reference_id'];
  $enquiry_content = $_POST['enquiry_content'];
  $branch_admin_id = $_POST['branch_admin_id'];
  $financial_year_id = $_POST['financial_year_id'];
  $enquiry_content = json_encode($enquiry_content);
  
  if($financial_year_id == ''){
    echo "error--Sorry! Add Financial year first then take enquiry.";
    exit;
  }
  
    $sq_max_id = mysql_fetch_assoc(mysql_query("select max(enquiry_id) as max from enquiry_master"));
    $enquiry_id = $sq_max_id['max']+1;

    $enquiry_date = date("Y-m-d", strtotime($enquiry_date));
    $followup_date = date("Y-m-d H:i", strtotime($followup_date));

    $name = addslashes($name);
    $enquiry_specification = addslashes($enquiry_specification);
    $sq_enquiry = mysql_query("insert into enquiry_master (enquiry_id, login_id,branch_admin_id,financial_year_id, enquiry_type,enquiry, name, mobile_no, landline_no, email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content ) values ('$enquiry_id', '$login_id', '$branch_admin_id','$financial_year_id', '$enquiry_type','$enquiry', '$name', '$mobile_no', '$landline_no', '$email_id','$location', '$assigned_emp_id', '$enquiry_specification', '$enquiry_date', '$followup_date', '$reference_id', '$enquiry_content')");

    $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
    $entry_id = $sq_max['max'] + 1;

    $sq_followup = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '$followup_date','$enquiry', '$enquiry_date')");
    $sq_entryid = mysql_query("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id'");

    if(!$sq_enquiry){
      echo "error--Enquiry Information Not Saved.";
      exit;
    }  
    else{
      $this->send_enquiry_mail($enquiry_id, $email_id, $name, $tour_name, $enquiry_specification,$assigned_emp_id,$mobile_no);
      $this->send_sms_enquiry_master($enquiry_id, $mobile_no,$name);
      echo $enquiry_type." Enquiry has been successfully saved.";
    }  

  }

///////////////////////***Enquiry Master Save end*********//////////////
function send_sms_enquiry_master($enquiry_id, $mobile_no,$name)
{
   global $app_contact_no,$app_website,$app_name,$app_email_id;
   $message = "Dear ".$name.", Thank you for showing your interest in ".$app_name.". Your enquiry number is ".$enquiry_id.". Our Tour Expert will contact you in 24hrs. For more login to ".$app_website.". Contact : ".$app_contact_no." mail us ".$app_email_id.".";
   global $model;
   $model->send_message($mobile_no, $message);
   
}
///////////////////////***Enquiry Email send start*********//////////////
function send_enquiry_mail($enquiry_id, $email_id, $name, $tour_name, $enquiry_specification,$assigned_emp_id,$mobile_no)
{
  global $app_name;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
  $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$assigned_emp_id'"));
  $ass_email_id = $sq_emp['email_id'];
  $ass_emp = $sq_emp['first_name'].' '.$sq_emp['last_name'];
  $ass_mobile = $sq_emp['mobile_no'];
  $content = '
    <tr>
      <td>
        <table style="padding:0 30px">
            <tr>
              <td>
                <table style="width:100%">
                  <tr>
                    <td>
                      <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                          <span style="font-weight:bold">Enquiry ID</span> : <span>'.$enquiry_id.'</span>
                      </span>    
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                          <span style="font-weight:bold">Enquiry handle By</span> : <span>'.$ass_emp.'</span>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                          <span style="font-weight:bold">Mobile No</span> : <span>'.$ass_mobile.'</span>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                          <span style="font-weight:bold">Email ID</span> : <span>'.$ass_email_id.'</span>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                          <span style="font-weight:bold">Specification</span> : <span>'.$enquiry_specification.'</span> 
                      </span>    
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p style="margin: 0;line-height: 24px;">Look out for exciting deals in your inbox!.<br>
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
      </td>
    </tr>
  ';

  $subject = 'Enquiry Acknowledgment (Enquiry ID : '.$enquiry_id.' ).';

  global $model;

  $this->send_emp_enquiry_mail($enquiry_id,$assigned_emp_id,$name);
  $model->app_email_send('4',$email_id, $content,$subject,'1');

}
///////////////////////***Enquiry Email send end*********//////////////


///////////////////////***Enquiry Assighned Email send start*********//////////////
function send_emp_enquiry_mail($enquiry_id, $assigned_emp_id,$name)
{
  global $app_name;
  $sq_enquiry_details = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
  $Cust_name = $sq_enquiry_details['name'];
  $enquiry_type = $sq_enquiry_details['enquiry_type'];
  $assigned_emp_id = $sq_enquiry_details['assigned_emp_id'];

  $sq_ass_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$assigned_emp_id'"));
  $emp_name = $sq_ass_emp['first_name'].' '.$sq_ass_emp['last_name'];
  $ass_email_id = $sq_ass_emp['email_id'];
  $content = '
      <tr><td><strong>Please Find below Enquiry details:-</strong></td></tr>
      <tr>
        <td>
          <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
              <strong>Enquiry ID</strong> : <span>'.$enquiry_id.'</span>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
              <strong>Customer Name</strong> : <span>'.$Cust_name.'</span>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
              <strong>Mobile No</strong> : <span>'.$sq_enquiry_details['mobile_no'].'</span>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
              <strong>Email ID</strong> : <span>'.$sq_enquiry_details['email_id'].'</span>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
              <strong>Followup Time</strong> : <span>'.get_datetime_user($sq_enquiry_details['followup_date']).'</span> 
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
              <strong>Enquiry Type</strong> : <span>'.$enquiry_type.'</span>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <table style="padding:0 30px">
              <tr>
                <td colspan="2">
                  <a style="font-weight:500;font-size:14px;display:block;color:#ffffff;background:#009898;text-decoration:none;padding:5px 10px;border-radius:25px;width:95px;text-align:center" href="'.BASE_URL.'" target="_blank">Details</a>
                </td>
              </tr> 
          </table>
        </td>
      </tr>
  ';

 $subject = 'Enquiry Assignment : ( Enquiry ID : '.$enquiry_id. ' , Customer Name : '.$name. ' )';

  global $model;
   $model->app_email_send('5',$ass_email_id, $content,$subject,'1');
}
///////////////////////***Enquiry Master Update start*********//////////////
function enquiry_master_update()
{
  $enquiry_id = $_POST["enquiry_id"]; 
  $enquiry= $_POST["enquiry"]; 
  $mobile_no = $_POST["mobile_no"]; 
  $email_id = $_POST["email_id"];
  $location = $_POST["location"];
  $landline_no = $_POST["landline_no"];
  $enquiry_date = $_POST['enquiry_date'];
  $followup_date = $_POST['followup_date'];
  $reference_id = $_POST['reference'];
  $enquiry_content = $_POST['enquiry_content'];
  $enquiry_content = json_encode($enquiry_content);
  $enquiry_specification = $_POST['enquiry_specification'];
  $assigned_emp_id = $_POST['assigned_emp_id'];
  $name = $_POST['name'];
  
  $enquiry_date = date('Y-m-d', strtotime($enquiry_date));
  $followup_date = date('Y-m-d H:i', strtotime($followup_date));

  $name = addslashes($name);
  $enquiry_specification = addslashes($enquiry_specification);
  $sq_enquiry = mysql_query("update enquiry_master set name='$name', mobile_no='$mobile_no',landline_no = '$landline_no', email_id='$email_id',location='$location', enquiry = '$enquiry', enquiry_date='$enquiry_date', followup_date='$followup_date', reference_id='$reference_id', enquiry_content='$enquiry_content', enquiry_specification='$enquiry_specification', assigned_emp_id ='$assigned_emp_id' where enquiry_id='$enquiry_id'");

  if(!$sq_enquiry){
    echo "error--Enquiry Information Not Updated.";
    exit;
  }  
  else{
    $this->send_enquiry_mail($enquiry_id, $email_id, $name, $tour_name, $enquiry_specification,$assigned_emp_id,$mobile_no);
    $this->send_emp_enquiry_mail($enquiry_id,$assigned_emp_id);

    echo "Enquiry has been successfully updated.";
  }
}
///////////////////////***Enquiry Master Update end*********//////////////


///////////////////////***Enquiry status update start*********//////////////
function enquiry_status_update($enquiry_id)
{
  $sq = mysql_query("update enquiry_master set status='Done' where enquiry_id='$enquiry_id'");
  if(!$sq){
    echo "Sorry, Status not updated.";
    exit;
  }
  else{
    echo "Enquiry has been successfully updated.";
    exit;
  }

}
///////////////////////***Enquiry status update end*********//////////////


///////////////////////***Enquiry status update start*********//////////////
function enquiry_status_disable($enquiry_id)
{
  $sq = mysql_query("update enquiry_master set status='Disabled' where enquiry_id='$enquiry_id'");
  if(!$sq){
    echo "Sorry, Not Disabled.";
    exit;
  }
  else{
    echo "Enquiry has been successfully disabled.";
    exit;
  }
}
///////////////////////***Enquiry status update end*********//////////////

///////////////////////***Enquiry followup save start*********//////////////
public function followup_reply_save()
{
  $enquiry_id = $_POST['enquiry_id'];
  $followup_reply = $_POST['followup_reply'];
  $followup_date = $_POST['followup_date'];
  $followup_type = $_POST['followup_type'];
  $followup_status = $_POST['followup_status'];
  $followup_stage = $_POST['followup_stage'];

  $followup_stage = ($followup_status == 'Converted' && $followup_stage == '') ? 'Strong' : $followup_stage;
  $followup_stage = ($followup_status == 'Dropped' && $followup_stage == '') ? 'Cold' : $followup_stage;

  
  $followup_reply = addslashes($followup_reply);
  $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
  $entry_id = $sq_max['max'];

  $created_at = date('Y-m-d H:i:s');
  $followup_date = date('Y-m-d H:i:s', strtotime($followup_date));

  $sq_entery_count = mysql_fetch_assoc(mysql_query("select * from enquiry_master_entries where enquiry_id='$enquiry_id'"));
  $name = $sq_entery_count['name'];

  if($sq_entery_count['followup_reply']!=""){
    $sq_followup = mysql_query("update enquiry_master_entries set status='False' where enquiry_id='$enquiry_id'");
  }

  if($sq_entery_count['followup_reply']==""){
    $sq_followup = mysql_query("update enquiry_master_entries set followup_reply='$followup_reply',followup_date='$followup_date',followup_type='$followup_type',followup_status='$followup_status', created_at='$created_at', followup_stage='$followup_stage' where enquiry_id='$enquiry_id'");
  }
  else
  {
    $entry_id1 = $sq_max['max'] + 1;
    $sq_followup_add = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply, followup_status, followup_type, followup_date, followup_stage, created_at) values('$entry_id1', '$enquiry_id', '$followup_reply', '$followup_status','$followup_type', '$followup_date', '$followup_stage', '$created_at')");
    
    
    $sq_entryids = mysql_query("update enquiry_master set entry_id='$entry_id1' where enquiry_id='$enquiry_id'");
  }
  if($sq_followup_add or $sq_followup){

    if($followup_status=="Converted"){
       $this->send_enquiry_coverted_mail($enquiry_id);
       $sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
       $name = $sq_enq['name'];
      $this->enquiry_converted_sms_send($enquiry_id,$name);
    }

    echo "Followup has been successfully saved";
    exit;

  }
  else{
    echo "error--Followup not saved successfully!";
    exit;
  }

}
///////////////////////***Enquiry followup save end*********//////////////

///////////////////////***Enquiry converted sms send start*********//////////////
public function enquiry_converted_sms_send($enquiry_id,$name)
{
  global $app_contact_no,$app_name;
  $sq_enquiry = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
  $mobile_no = $sq_enquiry['mobile_no'];
  $assigned_emp_id = $sq_enquiry['assigned_emp_id'];
  $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$assigned_emp_id'"));
  $first_name = $sq_emp['first_name'];
  $last_name = $sq_emp['last_name']; 

  $message = "Dear ".$name.", Thanks for choose a trip with ".$app_name.". Your relationship manager is ".$first_name." ".$last_name."";
  global $model;

  $model->send_message($mobile_no, $message);
}
///////////////////////***Enquiry converted sms send end*********//////////////

///////////////////////***Enquiry converted mail send start*********//////////////
function send_enquiry_coverted_mail($enquiry_id)
{
  global $app_name,$app_email_id,$backoffice_email_id;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

   $sq_enquiry_details = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
   $Cust_name = $sq_enquiry_details['name'];
   $enquiry_type = $sq_enquiry_details['enquiry_type'];
   $assigned_emp_id = $sq_enquiry_details['assigned_emp_id'];

   $sq_ass_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$assigned_emp_id'"));
   $emp_name = $sq_ass_emp['first_name'].' '.$sq_ass_emp['last_name'];

  $content = '
  <table style="padding:0 30px">
    <tr>
      <td>
        <table style="width:100%">
          <tr><td><strong>Please Find below Enquiry details:-</strong></td></tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <strong>Enquiry ID</strong> : <span>'.$enquiry_id.'</span>
              </span>
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <strong>Customer Name</strong> : <span>'.$Cust_name.'</span>
              </span>
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <strong>Mobile No</strong> : <span>'.$sq_enquiry_details['mobile_no'].'</span>
              </span>
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <strong>Email ID</strong> : <span>'.$sq_enquiry_details['email_id'].'</span>
              </span>
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <strong>User Name</strong> : <span>'.$emp_name.'</span> 
              </span>
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <strong>Enquiry Type</strong> : <span>'.$enquiry_type.'</span>
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  ';
  $subject = 'The new lead converted successfully! ( Enquiry ID : '.$enquiry_id.' , Customer Name : '.$Cust_name.' )';
  global $model;

  $model->app_email_send('10',$app_email_id, $content,$subject,'1');

}
///////////////////////***Enquiry coverted mail send end*********//////////////

public function enquiry_csv_save()
{
    $enq_csv_dir = $_POST['obj'];
    $branch_admin_id=$_SESSION['branch_admin_id'];
    $financial_year_id=$_SESSION['financial_year_id'];
    $flag = true;

    $enq_csv_dir = explode('uploads', $enq_csv_dir);
    $enq_csv_dir = BASE_URL.'uploads'.$enq_csv_dir[1];

    begin_t();
    $unprocessedArray=array();
    $arrResult  = array();
    $validCount=0;
    $invalidCount=0;
    $count = 1;
    $created_at = date('Y-m-d');

    $handle = fopen($enq_csv_dir, "r");
    if(empty($handle) === false) {
        while(($data = fgetcsv($handle, ",")) !== FALSE){
          if($count == 1) { $count++; continue; }

            if($count>0){
                
                $sq_max_id =  mysql_fetch_assoc(mysql_query("select max(enquiry_id) as max from enquiry_master"));
                $enquiry_id = $sq_max_id['max']+1;

                $login_id = $_SESSION['login_id'];
                $enquiry_type = "Package Booking";
                $name = $data[0];
                $mobile_no = $data[1];
                $landline_no = $data[2];
                $email_id = $data[3];
                $enquiry_date = $data[14];
                $followup_date = $data[15];
                $reference_id = $data[16];
                $assigned_emp_id =  $data[17];
                $enquiry = $data[18];
                $enquiry_specification = $data[19];
                $tour_name=$data[4];
                $location = $data[20];
                $enquiry_content = array(
                  array('name'=>'tour_name', 'value'=>$data[4]),
                  array('name'=>'travel_from_date', 'value'=>$data[5]),
                  array('name'=>'travel_to_date', 'value'=>$data[6]),
                  array('name'=>'budget', 'value'=>$data[7]),
                  array('name'=>'total_adult', 'value'=>$data[8]),
                  array('name'=>'total_children', 'value'=>$data[9]),
                  array('name'=>'total_infant', 'value'=>$data[10]),
                  array('name'=>'total_members', 'value'=>$data[11]),
                  array('name'=>'children_without_bed', 'value'=>$data[12]),
                  array('name'=>'children_with_bed', 'value'=>$data[13]),
                  array('name'=>'hotel_type', 'value'=>$data[21])
                );
                $enquiry_content = json_encode($enquiry_content);

                $enquiry_date1 = date('Y-m-d', strtotime($enquiry_date));
                $followup_date1 = date('Y-m-d H:i', strtotime($followup_date));
                $sq_fin = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id='$financial_year_id'"));
                
                if($enquiry_date1 >= $sq_fin['from_date'] && $enquiry_date1 <= $sq_fin['to_date']){
                  
                  if(preg_match('/^[0-9 \s]{6,20}+$/', $mobile_no) && preg_match('/^[0-9]*$/', $assigned_emp_id) && !empty($enquiry)  && !empty($assigned_emp_id) && !empty($reference_id) && !empty($name) && !empty($data[4]) && !empty($followup_date) && !empty($data[5])){

                      $validCount++;
                      $query = "insert into enquiry_master (enquiry_id, login_id, branch_admin_id,financial_year_id, enquiry_type, enquiry, name, mobile_no,landline_no, email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content) values ('$enquiry_id', '$login_id', '$branch_admin_id','$financial_year_id', '$enquiry_type', '$enquiry', '$name', '$mobile_no', '$landline_no', '$email_id','$location', '$assigned_emp_id', '$enquiry_specification', '$enquiry_date1', '$followup_date1', '$reference_id', '$enquiry_content')";
                        $sq_enquiry = mysql_query($query);

                      $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
                      $entry_id = $sq_max['max'] + 1;

                      $sq_followup = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '$followup_date1', '$enquiry', '$enquiry_date1')");
                      
                      $sq_entryicsv = mysql_query("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id'");

                      if(!$sq_enquiry){
                        echo "error--Enquiry Information Not Saved.";
                      }
                      else{
                        $this->send_enquiry_mail($enquiry_id, $email_id, $name, $tour_name, $enquiry_specification,$assigned_emp_id,$mobile_no);
                        if($mobile_no != ''){
                          $this->send_sms_enquiry_master($enquiry_id, $mobile_no,$name);
                        }
                      }  
                  }
                  else{
                      $invalidCount++;
                      array_push($unprocessedArray, $data);
                  }
                }
                else{
                    $invalidCount++;
                    array_push($unprocessedArray, $data);
                }
            }            
            $count++;
          }
       
        fclose($handle);
        if(isset($unprocessedArray) && !empty($unprocessedArray))
        {
          //print_r($unprocessedArray); die;
          $filePath='../../download/unprocessed_enquiry_records'.$created_at.'.csv';
          $save = preg_replace('/(\/+)/','/',$filePath);
          //echo $save;
          $downloadurl='../../../download/unprocessed_enquiry_records'.$created_at.'.csv';
          //echo $downloadurl;
          header("Content-type: text/csv ; charset:utf-8");
          header("Content-Disposition: attachment; filename=file.csv");
          header("Pragma: no-cache");
          header("Expires: 0");
            $output = fopen($save, "w");  
            fputcsv($output, array('Customer Name' , 'Contact No' , 'Whatsapp No' , 'Gmail Id', 'Interested Tour' , 'Travel From Date' , 'Travel To Date' , 'Budget' , 'Total Adults' , 'Total Childerns' , 'Total Infant' , 'Total Passangers' , 'Children Without Bed' ,'Children With Bed' , 'Enquiry Date' , 'Followup Date' , 'Reference' , 'Assigned Emp Id' , 'Enquiry Type' , 'Other Specification'));
          
           foreach($unprocessedArray as $row)
           {
             fputcsv($output, $row);  
           }
            
          fclose($output); 
          //print_r($downloadurl);
          echo "<script> window.location ='$downloadurl'; </script>";  
        } 
    }

    if($flag){
      commit_t();
      if($validCount>0)
      {
          echo  $validCount." records successfully imported<br>
          ".$invalidCount." records are failed.";
      }
      else
      {
        echo "No Enquiries imported"; 
      }
      exit;
    }
    else{
      rollback_t();
      exit;
    }

}


function enq_form_send(){
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
  $email_id = $_POST['email_id'];
  $mobile_no = $_POST['mobile_no'];
  $content = '             
    <tr>
      <td>
        <table style="width:100%">
          <tr>
              <td>
                <a style="font-weight:500;font-size:14px;display:block;color:#ffffff;background:#009898;text-decoration:none;padding:5px 10px;border-radius:25px;width: 95px;text-align: center;" href="'.BASE_URL.'model/attractions_offers_enquiry/tour_enquiry.php">Tour Details</a>
              </td> 
          </tr>
          <tr>
              <td colspan="2">
                Feel free to let us know if require more details.
              </td>
          </tr>
        </table>
      </td>
    </tr>
  ';

  global $model;
  $message = "Please provide general information of your tour enquiry to prepare best proposal & organise services . Use this link :- ".BASE_URL.'model/attractions_offers_enquiry/tour_enquiry.php' ;
 
  $model->send_message($mobile_no, $message);
  $subject = "Tour Enquiry Information......";

  // $model->app_email_master($email_id, $content, $subject,'1');
  $model->app_email_send('6',$email_id, $content,$subject,'1');
  echo "Enquiry Form has been successfully sent.";
}

}

?>