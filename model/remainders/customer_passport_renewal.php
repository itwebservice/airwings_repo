<?php

include_once('../model.php');
global $model;
 
	$today=date('Y-m-d');
	$exp_date = date('Y-m-d', strtotime('+7 days', strtotime($today)));

		//FIT Passenger
		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'fit_customer_passport_renewal' and date='$today' and status='Done'"));
		if($sq_count==0)
		{
			$sq_pass = mysql_query("SELECT * from package_travelers_details where passport_expiry_date='$exp_date' and status!='Cancel'");
			while($row_pass=mysql_fetch_assoc($sq_pass))
			{
				$sq_booking = mysql_fetch_assoc(mysql_query("SELECT * from package_tour_booking_master where booking_id='$row_pass[booking_id]'"));
				$sq_customer = mysql_fetch_assoc(mysql_query("SELECT * from customer_master where customer_id='$sq_booking[customer_id]'"));
				$email_id = $sq_customer['email_id'];
				$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				$pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];

					send_email($email_id,$row_pass['passport_expiry_date'],$cust_name,$pass_name);
			}
			$row=mysql_query("SELECT max(id) as max from remainder_status");
		 	$value=mysql_fetch_assoc($row);
		 	$max=$value['max']+1;
			$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','fit_customer_passport_renewal','$today','Done')");
		}

		// GIT Passenger
		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'git_customer_passport_renewal' and date='$today' and status='Done'"));
		if($sq_count==0)
		{
		$sq_pass = mysql_query("SELECT * from travelers_details where passport_expiry_date='$exp_date' and status!='Cancel'");
			while($row_pass=mysql_fetch_assoc($sq_pass))
			{
				$sq_booking = mysql_fetch_assoc(mysql_query("SELECT * from tourwise_traveler_details where traveler_group_id='$row_pass[traveler_group_id]'"));
				$sq_customer = mysql_fetch_assoc(mysql_query("SELECT * from customer_master where customer_id='$sq_booking[customer_id]'"));
				$email_id = $sq_customer['email_id'];
				$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				$pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];
				send_email($email_id,$row_pass['passport_expiry_date'],$cust_name,$pass_name);
			}			
			$row=mysql_query("SELECT max(id) as max from remainder_status");
			$value=mysql_fetch_assoc($row);
			$max=$value['max']+1;
			$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','git_customer_passport_renewal','$today','Done')");
		}

		//FLight Passenger
		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'flight_customer_passport_renewal' and date='$today' and status='Done'"));
		if($sq_count==0)
		{
			$sq_pass = mysql_query("SELECT * from ticket_master_entries where passport_expiry_date='$exp_date' and status!='Cancel'");
			while($row_pass=mysql_fetch_assoc($sq_pass))
			{
				$sq_booking = mysql_fetch_assoc(mysql_query("SELECT * from ticket_master where ticket_id='$row_pass[ticket_id]'"));
				$sq_customer = mysql_fetch_assoc(mysql_query("SELECT * from customer_master where customer_id='$sq_booking[customer_id]'"));
				$email_id = $sq_customer['email_id'];
				$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				$pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];

				send_email($email_id,$row_pass['passport_expiry_date'],$cust_name,$pass_name);
			}			
			$row=mysql_query("SELECT max(id) as max from remainder_status");
			 $value=mysql_fetch_assoc($row);
			 $max=$value['max']+1;
			$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','flight_customer_passport_renewal','$today','Done')");
		}

		//Visa Passenger
		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'visa_customer_passport_renewal' and date='$today' and status='Done'"));
		if($sq_count==0)
		{
			$sq_pass = mysql_query("SELECT * from visa_master_entries where expiry_date='$exp_date' and status!='Cancel'");
			while($row_pass=mysql_fetch_assoc($sq_pass))
			{
				$sq_booking = mysql_fetch_assoc(mysql_query("SELECT * from visa_master where visa_id='$row_pass[visa_id]'"));
				$sq_customer = mysql_fetch_assoc(mysql_query("SELECT * from customer_master where customer_id='$sq_booking[customer_id]'"));
				$email_id = $sq_customer['email_id'];
				$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				$pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];

				send_email($email_id,$row_pass['expiry_date'],$cust_name,$pass_name);
			}
			$row=mysql_query("SELECT max(id) as max from remainder_status");
			 $value=mysql_fetch_assoc($row);
			 $max=$value['max']+1;
			$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','visa_customer_passport_renewal','$today','Done')");
		}

function send_email($email_id,$expiry_date,$cust_name,$pass_name)
{
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;

	$content1 .= '
		<tr>
			<td>
				<table style="background:#fff;color:#22262e;font-size:13px;width:100%;margin-bottom:20px">					
					<tr>
						<td style="padding-left:10px;border-bottom:1px solid #eee"><span style="font-weight:600;color:#3c3c3c">Passenger</span> : '.$pass_name.'
						</td>
					</tr>
					<tr>
						<td style="padding-left:10px;border-bottom:1px solid #eee"><span style="font-weight:600;color:#3c3c3c">Expiry Date</span> : '.get_date_user($expiry_date).'
						</td>
					</tr>
				</table>
			</td>
		</tr>
		';
	global $model;
	$model->app_email_send('70',$email_id, $content1,'1');
}
?>