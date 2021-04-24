<?php
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='excursion/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="exc_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="min-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Excursion</h4>
      </div>
      <div class="modal-body">

      	<form id="frm_exc_save" name="frm_exc_save">
        
	        <div class="panel panel-default panel-body fieldset">
	        	<legend>Customer Details</legend>

	        	<div class="row">
	        		<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_sm_xs">
	        			<select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" onchange="customer_info_load()">
	        				<?php get_new_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
	        			</select>
	        		</div>
	        		<div id="new_cust_div"></div>
	        		<div id="cust_details">	        
	        		<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_sm_xs">
	                  <input type="text" id="email_id" name="email_id" title="Email Id" placeholder="Email ID" title="Email ID" readonly>
	                </div>		
	        		<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_sm_xs">
	                  <input type="text" id="mobile_no" name="mobile_no" title="Mobile Number" placeholder="Mobile No" title="Mobile No" readonly>
	                </div>  
	                <div class="col-md-3 col-sm-4 col-xs-12">
	                  <input type="text" id="company_name" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
	                </div> 
	                <div class="col-md-3 col-sm-4 col-xs-12">
	                  <input type="text" id="credit_amount" class="hidden" name="credit_amount" placeholder="Credit Note Balance" title="Credit Note Balance" readonly>
	                </div> 
	                </div>
	        	</div>

	        </div>

	        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
	        	<legend>Excursion Details</legend>
				
				 <div class="row mg_bt_10">
	                <div class="col-xs-12 text-right text_center_xs">
	                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_exc_booking')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
	                    <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_exc_booking');calculate_exc_expense('tbl_dynamic_exc_booking')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
	                </div>
	            </div>    	            
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="table-responsive">
	                    <?php $offset = ""; ?>
	                    <table id="tbl_dynamic_exc_booking" name="tbl_dynamic_exc_booking" class="table table-bordered no-marg pd_bt_51">
	                       <?php include_once('exc_tbl.php'); ?>
	                    </table>
	                    </div>
	                </div>
	            </div>        


	        </div>

	        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
	        	<legend>Costing Details</legend>

	        	<div class="row mg_bt_10">
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
		        		<input type="text" id="exc_issue_amount" name="exc_issue_amount" placeholder="*Amount" title="Amount" onchange="calculate_total_amount();validate_balance(this.id)">
		        	</div>
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		        		<input type="text" name="service_charge" id="service_charge" placeholder="*Service Charge" title="Service Charge" onchange="calculate_total_amount();validate_balance(this.id)">
		        	</div>	
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	                  <select name="taxation_type" id="taxation_type" title="Taxation Type">
	                    <?php get_taxation_type_dropdown($setup_country_id) ?>
	                  </select>
	                </div>
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<select name="taxation_id" id="taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'service_tax', 'calculate_total_amount');"><?php get_taxation_dropdown(); ?>
				        </select>
				        <input type="hidden" id="service_tax" name="service_tax" value="0">
	        		</div>	        		
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				        <input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="*Tax Amount" title="Tax Amount" readonly>
	        		</div>	
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	        			<input type="text" name="exc_total_cost" id="exc_total_cost" class="amount_feild_highlight text-right" placeholder="Net Total" title="Net Total" readonly>
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	        			<input type="text" name="due_date" id="due_date" placeholder="Due Date" title="Due Date" value="<?= date('d-m-Y') ?>">
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	        			<input type="text" name="balance_date" id="balance_date" value="<?= date('d-m-Y') ?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id)">
	        		</div>
	        	</div> 

	        </div>

	        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
	        	<legend>Advance Details</legend>
				
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input type="text" id="payment_date" name="payment_date" placeholder="Date" title="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id');validate_balance(this.id)">
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<select name="payment_mode" id="payment_mode" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
							<?php get_payment_mode_dropdown(); ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input type="text" id="bank_name" name="bank_name" onchange="fname_validate(this.id)" placeholder="Bank Name" class="bank_suggest" title="Bank Name" readonly>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id)" placeholder="Cheque No/ID" title="Cheque No/ID" readonly>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
			            <select name="bank_id" id="bank_id" title="Select Bank" disabled>
			              <?php get_bank_dropdown(); ?>
			            </select>
			        </div>
				</div>
		        <div class="row">
		          <div class="col-md-9 col-sm-9">
		           <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
		         </div>
		        </div>

	        </div>

	        <div class="row text-center">
	        	<div class="col-md-12">
	        		<button id="btn_exc_master_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
	        	</div>
	        </div>

        </form>


      </div>  
    </div>
  </div>
</div>


<script>
$('#payment_date, #due_date,#balance_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#customer_id').select2();

$(function(){

$('#frm_exc_save').validate({
	rules:{
			customer_id: { required: true },
			exc_issue_amount: { required: true, number: true },
			service_charge :{ required : true, number:true },
			taxation_id :{ required : true, number:true },
			taxation_type : { required : true },
			service_tax :{ required : true, number:true },
			service_tax_subtotal :{ required : true, number:true },
			exc_total_cost :{ required : true, number:true },
			balance_date:{ required : true },

			payment_date : { required : true },
			payment_amount : { required : true },
			payment_mode : { required : true },
			bank_name : { required : function(){  if($('#payment_mode').val()!="Cash" && $('#payment_amount').val() != '0'){ return true; }else{ return false; }  }  },
            transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
            bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },  
            //due_date : { required : true },   
	},
	submitHandler:function(form){
			var base_url = $('#base_url').val();	
			var customer_id = $('#customer_id').val();
			var first_name = $('#cust_first_name').val();
		    var cust_middle_name = $('#cust_middle_name').val();
		    var cust_last_name = $('#cust_last_name').val();
		    var gender = $('#cust_gender').val();
		    var birth_date = $('#cust_birth_date').val();
		    var age = $('#cust_age').val();
		   	var contact_no = $('#cust_contact_no').val();
		    var email_id = $('#cust_email_id').val();
		    var address = $('#cust_address1').val();
		    var address2 = $('#cust_address2').val();
		    var city = $('#city').val();
		    var service_tax_no = $('#cust_service_tax_no').val();  
		    var landline_no = $('#cust_landline_no').val();
		    var alt_email_id = $('#cust_alt_email_id').val();
		    var company_name = $('#corpo_company_name').val();
		    var cust_type = $('#cust_type').val();
		    var state = $('#cust_state').val();
			var active_flag = 'Active';
			var branch_admin_id = $('#branch_admin_id1').val();
	      	var credit_amount = $('#credit_amount').val();
		     var country = $('#country').val();
	      	
	      	//New Customer save
			if(customer_id == '0'){
			    $.ajax({
			        type: 'post',
			        url: base_url+'controller/customer_master/customer_save.php',
			        data:{ first_name : first_name, middle_name : cust_middle_name, last_name : cust_last_name, gender : gender, birth_date : birth_date, age : age, contact_no : contact_no, email_id : email_id, address : address,address2 : address2,city:city,  active_flag : active_flag ,service_tax_no : service_tax_no, landline_no : landline_no, alt_email_id : alt_email_id,company_name : company_name, cust_type : cust_type,state : state, branch_admin_id : branch_admin_id,country:country},
			        success: function(result){
			        }
			    });
			}

			var emp_id = $('#emp_id').val();
			var exc_issue_amount = $('#exc_issue_amount').val();	
			var service_charge = $('#service_charge').val();
			var taxation_type = $('#taxation_type').val();
			var taxation_id = $('#taxation_id').val();
			var service_tax = $('#service_tax').val();
			var service_tax_subtotal = $('#service_tax_subtotal').val();
			var exc_total_cost = $('#exc_total_cost').val();
			var due_date = $('#due_date').val();
			var balance_date = $('#balance_date').val();

			var payment_date = $('#payment_date').val();
			var payment_amount = $('#payment_amount').val();
			var payment_mode = $('#payment_mode').val();
			var bank_name = $('#bank_name').val();
			var transaction_id = $('#transaction_id').val();	
			var bank_id = $('#bank_id').val();	

			if(parseFloat(taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; }
			
			var exc_date_arr = new Array();
			var city_id_arr = new Array();
			var exc_name_arr = new Array();
			var total_adult_arr = new Array();
			var total_child_arr = new Array();
			var adult_cost_arr = new Array();
			var child_cost_arr = new Array();
			var total_amt_arr = new Array();

			if(credit_amount != ''){ 
	        	if(parseFloat(payment_amount) > parseFloat(credit_amount)) { error_msg_alert('Low Credit note balance'); return false; }
	        }
	        
	        var table = document.getElementById("tbl_dynamic_exc_booking");
	        var rowCount = table.rows.length;
	        
	        for(var i=0; i<rowCount; i++)
	        {
	          var row = table.rows[i];
	           if(rowCount == 1){
	            if(!row.cells[0].childNodes[0].checked){
	           		error_msg_alert("Atleast one Excursion is required!");
	           		return false;
	            }
	          } 
	          if(row.cells[0].childNodes[0].checked)
	          {
				  var exc_date = row.cells[2].childNodes[0].value;
				  var city_id = row.cells[3].childNodes[0].value;
				  var exc_name = row.cells[4].childNodes[0].value;
				  var total_adult = row.cells[5].childNodes[0].value;
				  var total_child = row.cells[6].childNodes[0].value;
				  var adult_cost = row.cells[7].childNodes[0].value;
				  var child_cost = row.cells[8].childNodes[0].value;
				  var total_amt = row.cells[9].childNodes[0].value;

	              var msg = "";

				  if(exc_date==""){ msg +="Excursion Date is required in row:"+(i+1)+"<br>"; }
				  if(city_id==""){ msg +="City name is required in row:"+(i+1)+"<br>"; }
				  if(exc_name==""){ msg +="Excursion Name is required in row:"+(i+1)+"<br>"; }
				  if(total_adult==""){ msg +="Total Adult is required in row:"+(i+1)+"<br>"; }
				  if(total_child==""){ msg +="Total Children is required in row:"+(i+1)+"<br>"; }

	              if(msg!=""){
	                error_msg_alert(msg);
	                return false;
	              }

				  exc_date_arr.push(exc_date);
				  city_id_arr.push(city_id);
				  exc_name_arr.push(exc_name);
				  total_adult_arr.push(total_adult);
				  total_child_arr.push(total_child);
				  adult_cost_arr.push(adult_cost);
				  child_cost_arr.push(child_cost);
				  total_amt_arr.push(total_amt);             

	          }      
	        }
				//Validation for booking and payment date in login financial year
				var check_date1 = $('#balance_date').val();
				$('#btn_exc_master_save').button('loading');
				$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
					if(data !== 'valid'){
						error_msg_alert("The Booking date does not match between selected Financial year.");
						$('#btn_exc_master_save').button('reset');
						return false;
					}else{
						var payment_date = $('#payment_date').val();
						$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
						if(data !== 'valid'){
							error_msg_alert("The Payment date does not match between selected Financial year.");
							$('#btn_exc_master_save').button('reset');
							return false;
						}
						else{
							$('#btn_exc_master_save').button('loading');

							$.ajax({
								type: 'post',
								url: base_url+'controller/excursion/exc_master_save.php',
								data:{ emp_id : emp_id, customer_id : customer_id, exc_issue_amount : exc_issue_amount, service_charge : service_charge, taxation_type : taxation_type, taxation_id : taxation_id, service_tax : service_tax, service_tax_subtotal : service_tax_subtotal, exc_total_cost : exc_total_cost, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, due_date : due_date,balance_date : balance_date,exc_date_arr : exc_date_arr,city_id_arr : city_id_arr,exc_name_arr : exc_name_arr, total_adult_arr : total_adult_arr,total_child_arr : total_child_arr,adult_cost_arr : adult_cost_arr,child_cost_arr : child_cost_arr,total_amt_arr : total_amt_arr, branch_admin_id : branch_admin_id},
								success: function(result){
									$('#btn_exc_master_save').button('reset');
									var msg = result.split('-');
									
									if(msg[0]=='error'){
										msg_alert(result);
									}
									else{
										msg_alert(result);
										reset_form('frm_exc_save');
										$('#exc_save_modal').modal('hide');	
										exc_customer_list_reflect();
									}
									
								}
							});
							}
						});
					}
				});
	}
});

});
</script>