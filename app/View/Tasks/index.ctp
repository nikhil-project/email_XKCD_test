<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form id="task_form" name="task_form">
					<div class="col-md-6">
						<div class="form-group">
							<p>Enter Your Name : </p>
							<input type="text" name ="u_name" id="u_name" class="form-control" placeholder="Name">
							<input type="hidden" name="token" id="token" value = "<?php echo $this->Session->read('token'); ?>">
						</div>
					</div>
					<div class="col-md-6">	
						<div class="form-group">
							<p>Please Enter Your Email Here : </p>
							<input type="email" id="email_id" name="email_id" class="form-control" placeholder="username@domain.com">
							<!-- <span id="msg" class="btn-danger" style="display:none;">This field cannot be empty</span> -->
						</div>
					</div>
					<div class="col-md-6">
						<button type="button" id="submit_form" class="btn btn-primary">Submit</button>  
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>

<!-- The Modal -->
<div class="modal" id="myModal">
<div class="modal-dialog">
  <div class="modal-content">
  
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Success</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    
    <!-- Modal body -->
    <div class="modal-body">
      We have sent an One Time Passsword to the registered Email.Please Verify your email by entering the otp.
      	<form id ="validate_otp">
	      <input type="text" class="form-control" name="otp" id ="otp"> 
	      <input type="hidden" id='latest_code_id' value ="">
	      <button type= "button" id="otp_submit" class="btn btn-primary">Submit</button>
	  	</form>
    </div>
    
    <!-- Modal footer -->
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    
  </div>
</div>
</div>

<div class="modal" id="myModal1">
<div class="modal-dialog">
  <div class="modal-content">
  
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Success</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    
    <!-- Modal body -->
    <div class="modal-body">
      <span id="return_msg"></span>
    </div>
    
    <!-- Modal footer -->
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    
  </div>
</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
	});
	$(document).on('click','#submit_form',function(){
		var validator;
		validator = $('#task_form').validate({
			rules : {
				'email_id' : {
					'required': true,
                	'email': true
				},
				'u_name' : {
					'required' : true
				}
			}
		});

		var name = $('#u_name').val();
		var email = $('#email_id').val();
		var token = $('#token').val();
		var x = validator.form();
		if(x){
			 $.ajax({
		        url: "<?php echo $this->Html->url(array('controller'=>'tasks','action'=>'save_data')); ?>",
		        type: "post",
		        cache:false,
		        data: {name : name, email: email, token:token},
		        // data: values,
		        success: function (response) {
		        	console.log(response); 
		        	$('#myModal').modal();
		        	$('#latest_code_id').val(response);
		        	$('#u_name').val('');
		        	$('#email_id').val('');
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
		    });
		}
	});

	$(document).on('click','#otp_submit',function(){
		var otp = $('#otp').val();
		var code_id = $('#latest_code_id').val();
		$.ajax({
	        url: "<?php echo $this->Html->url(array('controller'=>'tasks','action'=>'verify_otp')); ?>",
	        type: "post",
	        cache:false,
	        data: {otp : otp, code_id : code_id},
	        // data: values,
	        success: function (response) {
	        	$('#myModal').hide();
	        	$('#myModal1').modal();
	        	$('#return_msg').text(response);
	        	$('#otp').val('');
	        	if(response == 'Verified'){
	        		send_image(code_id);
	        		setTimeout(function(){ location.reload(); }, 5000);
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });
	});

	function send_image(otp_code_id = ''){
		var code_id = otp_code_id;
		$.ajax({
	        url: "<?php echo $this->Html->url(array('controller'=>'tasks','action'=>'send_xkcd_image')); ?>",
	        type: "post",
	        cache:false,
	        data: {code_id : code_id},
	        success: function (response) {
	        	console.log(response);
	        	setTimeout(function(){ location.reload(); }, 5000);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	           console.log(textStatus, errorThrown);
	        }
	    });
	}
</script>
