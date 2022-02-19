<style type="text/css">
  #displayPassword
  {
    position: absolute;
    margin: 40px 0px 0px 410px;
    cursor: pointer;
  }
</style>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i>Manage Wallet</h1>

        </div>

      </div>
     <?php  
           
            $label                        = "";
            $saveButtonName  = "Add Money To Wallet";
                      
               ?>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">WALLET DETAILS
                <br/> <br/> <?php  echo $user_basic->user_first_name.$user_basic->user_last_name; ?>
                    
                </h3>
               <p><b><span id="balance"><?= $user_basic->wallet_balance ?></span> ( <?= $this->config->item('currency') ?>)</b></p>
               <p>Wallet Balance</p>
            <div class="tile-body">
                <form name="walletForm"  id="walletForm" method="post" enctype="multipart/form-data" autocomplete="off">
                    
               
                   <div class="row">
                     <div class="col-md-6">
                                 <div class="form-group">
                                <label class="control-label">Enter Amount to be added in wallet ( <?=CURRENCY_CODE?> )</label>
                                <input class="form-control" type="text" placeholder="Enter Amount" maxlength="40" id="txt_amount"  name="txt_amount"/>
                                <input type="hidden" class="form-control boxed" placeholder="" id="user_token" name="txt_user_id" value="<?php echo $user_basic->user_id; ?>"> 
                                 </div> 
                        </div>
                      
                   </div>
                  
              </form>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php  echo $saveButtonName;?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
             <span id="registerLoader"></span>
            </div>
          </div>
        </div>
        <h4>LAST TRANSACTION</h4>
        <table class="table table-striped table-bordered table-hover" id="sampleTable">
            <thead>
            <tr>
                <td>Description</td>
                <td>Credit</td>
                <td>Debit</td>
                
              
            </tr>
            </thead>
            <tbody>
        <?php 

            if(!empty($wallet_log)) {

                foreach ($wallet_log as $key => $value) { 
                    if($value->status ==2) {
                        $debit = $this->config->item('currency')." ".$value->amount;
                        $credit = '';
                    } else {
                        $debit = '';
                        $credit = $this->config->item('currency')." ".$value->amount;
                    }
                    ?>
                   <tr>
                       <td>Transaction ID:  <?php echo $value->transaction_id?>
                       <p><?php echo date('M d,Y h:i A',strtotime($value->created_at)); ?></p>
                      </td>
                      <td><?=  $credit ?></td>
                      <td><?=  $debit ?></td>
                      
                      
                      
                    </tr>
                    <?php
                    
                }
            } else {
                echo '<tr>
                <td colspan="3" align="center">No transaction found</td>               
              
            </tr>';
            }
        ?>
    </tbody>
   </table>
        
      </div>
    </main>
<script>         

  $(document).delegate("#btnRegister","click",function(e)
    {
        $("#walletForm").submit();
    });
 $(document).delegate("#cancelBtn","click",function(e)
    {
        alert();
        $("#walletForm")[0].reset();
    });

       var validator=$("#walletForm").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          
            
         txt_amount: 
          {
            required: true,
            number:true
          },
     
          
      
        },
        messages: 
        {
          
        },
        submitHandler: function ()
        {
                $(".errorSpan1").html("");                 
                $("#btnRegister").attr("disabled", "disabled");
                $("#registerLoader").html("<img src='<?php echo base_url();?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");   
                $(".errorSpan1").html();
              
                var formData = new FormData($("#walletForm")[0]);
                 csrf_value  =   getCookie('csrf_cookie_name');        
                 formData.append('<?php echo $this->security->get_csrf_token_name();?>',csrf_value);
                 
               // alert('Saving amount');
                     $.ajax({
             url: '<?php echo base_url();?>admin/C_admin/saveWallet',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   
                    $("#registerLoader").html("");
                    $('#btnRegister').prop("disabled", false);
                     data =  jQuery.parseJSON(data);
                     console.log(data['status']);

                    
                    if(data['status']==1)
                    {
                       
                        $('#balance').html(data['balance']);
                        $("#sampleTable tbody").prepend(data['cols']);
                          swal("Well done!", "Saved Successfully!", "success");
                          $('#txt_amount').val('');
                          //window.location="<?php echo base_url(); ?>admin/user_list";
                              
                    }
                    else if(data['status']==3)
                    {
                             swal("Sorry!", "Email id already exists", "error");
                    }
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== ""){
                            $.each(data['errors'], function(key, value) {console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                             $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');

                            });                          
                          }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          }


                    }
                    else
                    {
                              
                          swal("Sorry!", "Failed to save! Try again later", "error");


                    }

                  
                   
             },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
 });  
 $(document).delegate("#select_country","change",function(e)
    {
  
         var selected = $(this).find('option:selected');
         var dialCode = selected.data('foo'); 
          $("#txt_dial").val(dialCode);
         csrf_value  =   getCookie('csrf_cookie_name');        
         
          $.ajax({
            url: '<?php echo base_url();?>admin/C_admin/loadCityDropDown',
            type: 'POST',
            data: {countryId:$(this).val(),'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
      {
       
         $("#select_city").html(data);
        
                                                                 }
        });
      
    });
    $("#txt_profile").change(function() {
  readURL(this,'imagePreview');
});

    $('#displayPassword').click(function(){
      var myClass = $(this).attr('class');
      if(myClass=='fa fa-eye'){
        $(this).attr('class','fa fa-eye-slash');
        $('#txt_password').attr('type','text');
      }
      else{
        $(this).attr('class','fa fa-eye');
        $('#txt_password').attr('type','password');
      }
    });

  $('input#txt_phone').keypress(function(e){
    if(this.value.length < 2 && e.which == 48)
    {
      return false;
    }
  });
  
  $('.changePassword').click(function(){
    $('input#save_password').val(1);
    $('input#txt_password').val('');
    $('input#txt_password').attr('readonly',false);
    $('#displayPassword').show();
  });
 </script>