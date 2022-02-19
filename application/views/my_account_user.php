<style>
   .pac-container{
        z-index: 9999999999;
}
.swal-modal {
     z-index: 9999999999;
}
.modal-dialog.modal-lg{
  max-width: 920px;
}
.vendorlist{

}
.vendorlist table span img{
  height: 50px;
  object-fit: contain;
}
.vendorlist table button{
  border: none;
    border-radius: 3px;
    color: #fff;
    font-size: 14px;
    padding: 5px 1px;
    padding-right: 8px;
    margin: 0px 1px;
}
.vendorlist table button img{
    width: 15px;
    height: 15px;
    object-fit: contain;
    transform: translateY(-2px) translateX(3px);
}
.vendorlist table td.action{
  display: flex;
}

</style>

<!--start banner section-->
<section>
  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="row my-accound_banner">
        <div class="container">
           <h3>My Account</h3>

        </div>

    </div>
    <!--end row-->


  </div>
  <!--end container fluid-->
  
</section>
<!--end banner section-->




<!--start section-->
<section>
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row">
            
            <!--start col md 4-->
            <div class="col-md-2 col-sm-3 side_bar">
                <!--start row-->
                <div class="row side_bar_inner">
                    <div class="col-md-12 my-account-wall">
                        <?php
                        ?>
                        <?php $img = $user_details->user_image!=""?base_url()."uploads/user/".$user_details->user_image:base_url()."images/user_dummy.png"; ?>
                        <span><img src="<?php echo $img;?>"/></span>
                        <h3><?php echo $user_details->user_first_name." ".$user_details->user_last_name ?></h3>
                    </div>
                    
            <ul class="nav side_list_nav" id="myTab" role="tablist">
                <!--<li><a class="nav-link " id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon1.png"/></span>  <span>Dash Board</span></a></li>-->
                <li><a class="nav-link active" id="job-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon2.png"/></span>  <span>Job Request List</span></a></li>
               <li><a class="nav-link" id="address_list" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon3.png"/></span>  <span>Address List</span></a></li> 
                <!--<li><a class="nav-link" id="myrating-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon4.png"/></span>  <span>My Ratings </span></a></li>
                <li><a class="nav-link" id="transaction-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon5.png"/></span>  <span>Transaction Summery</span></a></li>-->
                <li><a class="nav-link" id="report-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/wallet-small.png"/></span>  <span>Wallet  </span></a></li>
                <li><a class="nav-link" id="settings-tab" data-toggle="tab" href="#tab7" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/profile.png"/></span>  <span>Profile</span></a></li>
                <li><a class="nav-link" id="settings-tab" data-toggle="tab" href="#tab10" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon7.png"/></span>  <span>Change Password</span></a></li>
                <li><a class="nav-link signOut"  href="<?php echo base_url()?>website/User/logout"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon8.png"/></span>  <span>Logout  </span></a></li>
            </ul>
                </div>
                <!--end row-->
            </div>
            <!--end col md 4-->
            
            
          
            
            <!--start col md 8-->
            <div class="col-md-10 col-sm-9 out-bg">
                <!--start row-->
                <div class="row wrapper_cover">
                    <!--start col md 12-->
                    <div class="col-md-12 col-sm-12 min_cover_pannel tab-content" id="myTabContent">
                        
                        
                        <!--start tab-->
        
<div class="tab-content" id="myTabContent">
    
<!--start dash board-->    
  <div class="tab-pane tab_padd fade " id="tab1" role="tabpanel" aria-labelledby="home-tab">
      <h3>Dashboard</h3>
      <!--start row-->
      <div class="row margin_none">
          <!--end col md 6-->
          <div class="col-md-6 col-sm-12">
              <!--start row-->
              <div class="row colms" id="barChart" style="height: 103%;">
                 <!-- <h3><span><img src="<?php echo base_url();?>frontend_assets/images/content-icon/icon-1.png"/></span> Monthly Job Request &amp; Quotations</h3>
                  <img src="<?php echo base_url();?>frontend_assets/images/content-img/chart.png"/>-->
              </div>
              <!--end row-->
          </div>
          <!--end col md 6-->
          
          
          <!--end col md 6-->
          <div class="col-md-6 col-sm-12 ">
              <!--start row-->
              <div class="row colms list-flow">
                  <ul>
                      <!-- <li><a href="#"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side1.png"/></span> <span>Total Quotations request </span> <span><?php echo $this->M_user->getTotalQutationParticipatedUser(); ?></span>       </a></li>
                      <li><a href="#" class="yello"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side2.png"/></span> <span>Quotation Pending </span> <span><?php echo $this->M_user->getTotalQutationPendingUser(); ?></span>       </a></li> -->
                      <li><a href="#" class="green"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side3.png"/></span> <span>Total Job Request </span> <span><?php echo $this->M_user->getTotalQutationPendingJobrequestUser(); ?></span>       </a></li>
                      <!--<li><a href="#" class="red"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side4.png"/></span> <span>Current Package</span> <span>Free</span>       </a></li>-->
                  </ul>
              </div>
              <!--end row-->
          </div>
          <!--end col md 6-->          
          
          
      </div>
      
      <div class="row margin_none next_row">
          <!--end col md 6-->
          
          
          
          <!--end col md 6-->
<div class="col-md-12 col-sm-12 padd-ctrls">
              <!--start row-->
              <div class="row colms table-responsive">
                  <h3><span><img src="<?php echo base_url();?>frontend_assets/images/content-icon/icon-3.png"/></span>Recent Job Request List</h3>
                  <table class="table table-striped">
  <thead>
    <tr>
      <th>Job number</th>
      <th >Customer Image</th>
      <th>Customer Name</th>
      <th >Service Type</th>
      <th >Service Date & Time</th>
      <th >Validity Date & Time</th>
    </tr>
  </thead>
  <tbody>
     <?php 
      //print_r($job_list);
      if(count($request_list)>0)
      {
      foreach($request_list as $rows){
          
      $img = $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png";     
          
      ?>
    <tr>
      <td><?php echo $rows->job_request_display_id ?></td>
      <td><span><img src="<?php echo $img;?>"/></span></td>
      <td><?php echo $rows->user_first_name ?> <?php echo $rows->user_last_name ?></td>
      <td><?php echo $rows->service_type_name ?></td>
      <td><?php echo date("d-m-Y",strtotime($rows->job_validity_date)) ?> <?php echo date("h i A",strtotime($rows->job_validity_time)) ?></td> 
      <td><?php echo $rows->job_date!=""?date("d-m-Y",strtotime($rows->job_date)):"" ?> <?php echo $rows->job_time!=""?date("h i A",strtotime($rows->job_time)):"NA" ?></td>
    </tr>
    <?php }
      }
      else
      {
          ?>
           <tr><td colspan="6">No results found</td></tr>
          <?php
          
      }
    ?>
    
   
  </tbody>
</table>
                  
              </div>
              <!--end row-->
          </div>
          <!--end col md 6-->          
          
          
      </div>
      <!--end row-->
  </div>
<!--end dash board-->
  
  
  
  <div class="tab-pane tab_padd_top_bottom fade show active" id="tab2" role="tabpanel" aria-labelledby="profile-tab">
     <div class="job_list">
      <!--start row-->
      <div class="row margin_none">
          <!--start col md 6-->
          <div class="col-md-7 col-sm-6">
              <h3>Job List </h3>
              
          </div>
          <!--end col-md 6-->
          
          
         <!--start col md 6-->
          <div class="col-md-12 col-sm-12">
              <!--start row-->
              <form class="row job_search">
              <!--start col md 7-->
              <div class="col-md-3 col-sm-6 form-group">
                  <aside>
                      <span><input class="form-control" type="text" placeholder="Search" id="jobSearch"></span>
                      <span><button type="button" id="btnSearch"><img src="<?php echo base_url();?>frontend_assets/images/icons/search-job.png"/></button></span>
                  </aside>
                  
              </div>
              <!--end col md 7-->
              
              <!--start col md 5-->
              <div class="col-md-2 col-sm-3 form-group">
  <select class="form-control" id="jobOrder">
    <option value="newest">Sort by</option>
    <option value="newest">Newest</option>
    <option value="oldest">Oldest</option>
   
  </select>
              </div>
               <div class="col-md-2 col-sm-3 form-group">
 <select class="form-control" id="job_status">
      <option value="">Status</option>
    <option value="pending">Pending</option>
    <option value="cancelled">Cancelled</option>
    <option value="confirmed">Confirmed</option>
  </select>
              </div>
              
            <div class="col-md-2 col-sm-3 form-group">
 <input class="form-control datePickerJob" id="from_date" placeholder="Starting date">
    
              </div>
                <div class="col-md-2 col-sm-3 form-group">
 <input class="form-control datePickerJob" id="to_date" placeholder="Ending date">
    
              </div>
              <div class="col-md-1 col-sm-3 form-group">
 <button type="button" class="btn btn-primary" id="resetEqFilters">Reset</button>
    
              </div>   
              <!--end col md 5-->
              </form>
              <!--end row-->
          </div>
          <!--end col-md 6--> 
          
          
      </div>
      <!--end row-->

      <!--start col md 12-->
      <div class="col-md-12 padd_none">
          <!--start row-->
                <div class="table-responsive">
          
          <table class="table my_table">
  <thead>
    <tr>
      <th scope="col" style="width:70%;">Description </th>
    
     <!-- <th scope="col" style="width:12%; text-align:center;">Date</th>-->
      <!--<th scope="col" style="width:12%; text-align:center;">Approval status</th>-->
      <th scope="col" style="width:12%; text-align:center;">Job Status</th>
      <th scope="col" style="text-align:center; border-right:0 !important;">Action</th>
    </tr>
  </thead>
  <tbody id="jobRequestSpan">
    

  </tbody>
</table>
      </div>
          <!--end row-->
      </div>
      <!--end col md 12-->
    </div>
    <div class="quotation_detail" style="display: none" id="requestDetailDIv">

   <div id="map3" style="height: 250px;"></div>
    </div>
  </div>
  
  
  
  <div class="tab-pane tab_padd fade" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
   <div class="job_list">
      <!--start row-->
      <div class="row margin_none">

          <div class="col-md-7">
              <h3>Address List</h3>
          </div>
          
          <div class="col-md-5">
            <a class="btn btn-primary address-button fa-edit" for="0" href="#" id="addNewAddress" data-target="#addressBook"><i class="fa fa-plus"></i> Add New</a>
          </div>
            
          <div id="user_address_list" style="width:100%;">
              
          </div>

    </div>
  </div>
  </div>
  
  
  <div class="tab-pane tab_padd fade" id="tab4" role="tabpanel" aria-labelledby="contact-tab">
     <div class="my_ratings">
          <h3>My Ratings</h3>
          <div class="list">
              <div class="row" id="ratingDiv">
                 
              </div>
          </div>
     </div>
  </div>
  
  <div class="tab-pane tab_padd fade" id="tab5" role="tabpanel" aria-labelledby="contact-tab">
      <div class="transaction">
          <h3>Transaction Summary</h3>
          <button type="button" class="btn btn-primary btn-lg export">Export to Excel</button>
          <table class="table  table-bordered">
  <thead>
    <tr>
      <th scope="col">Serial Number</th>
      <th scope="col">Package Name</th>
      <th scope="col">Purchase Date &amp; Time </th>
      <th scope="col">Amount</th>
      <th scope="col">VAT</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>34567</td>
      <td>Platinum</td>
      <td>05-06-2019     10:30AM</td>
      <td>3600</td>
      <td>175</td>
    </tr>
    <tr>
      <td>34567</td>
      <td>Platinum</td>
      <td>05-06-2019     10:30AM</td>
      <td>3600</td>
      <td>175</td>
    </tr>
    <tr>
      <td>34567</td>
      <td>Platinum</td>
      <td>05-06-2019     10:30AM</td>
      <td>3600</td>
      <td>175</td>
    </tr>
    <tr>
      <td>34567</td>
      <td>Platinum</td>
      <td>05-06-2019     10:30AM</td>
      <td>3600</td>
      <td>175</td>
    </tr>
  </tbody>
</table>
      </div>
  </div>
   
  <div class="tab-pane tab_padd fade" id="tab6" role="tabpanel" aria-labelledby="contact-tab">

    <section class="my-wallet">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="wallet-details">

                    <div class="wallet-details-img">
                      <img src="<?php echo base_url();?>frontend_assets/images/wallet.png" alt="">
                    </div>

                    <div class="wallet-details-contents">
                        <h2>Wallet Details</h2>
                        <h5><?= $this->config->item('currency') ?> <?= number_format($user_details->wallet_balance) ?> <span></span></h5>
                        <h6>Your Wallet Balance</h6>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>


    <section class="my-wallet-table">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Last Transaction</h2>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">Description</th>
                            <th scope="col">Credit</th>
                            <th scope="col">Debit</th>
                            
                            
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
                      <th scope="row">Transaction ID :  <span><?php echo $value->transaction_id?></span>
                       <p><?php echo date('M d,Y h:i',strtotime($value->created_at)); ?></p>
                      </th>
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
            </div>
        </div>
    </section>




  
  
  </div>
  
 
  
  <div class="tab-pane tab_padd fade" id="tab7" role="tabpanel" aria-labelledby="contact-tab">
      <form id="prfile_form">
      <div class="settings">
          <h3>Edit Profile</h3>
          <div class="row">
            
              <div class="col-md-9">
                  <div class="row">
                     <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">First Name</label>
                            <input type="text" class="form-control" id="user_first_name" name="user_first_name" placeholder="First Name" value="<?php echo $user_details->user_first_name ?>" maxlength="100">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Last Name</label>
                            <input type="text" class="form-control" id="user_last_name" name="user_last_name" placeholder="Last Name" value="<?php echo $user_details->user_last_name ?>" maxlength="100">
                          </div>
                      </div>
                   
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Email address</label>
                            <input type="email" class="form-control" id="txt_email" placeholder="name@example.com" value="<?php echo $user_details->user_email ?>" readonly>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Dial code</label>
                            <select class="form-control" id="txt_dial_code" name="txt_dial_code" >
                            <?php
                               foreach($country_list as $key=>$value){
                                    $dial_code = '+'.$value->country_dial_code;
                                    if($dial_code == $user_details->user_dial_code)
                                        $selected = "selected";
                                    else
                                        $selected = "";
                            ?>
                                <option value="<?=$dial_code?>" <?=$selected?>><?=$dial_code?></option>
                            <?php
                               }
                            ?>
                            </select>
                            <!--<input type="text" class="form-control" id="txt_dial_code" name="txt_dial_code" placeholder="Mobile Number" value="<?php echo $user_details->user_dial_code!=''?$user_details->user_dial_code:'971' ?>" >-->
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Mobile Number</label>
                            <input type="text" class="form-control" id="txt_phone" name="txt_phone" placeholder="Mobile Number" value="<?php echo $user_details->user_phone ?>" maxlength="13">
                          </div>
                      </div>
                      <!--<div class="col-md-6">-->
                      <!--    <div class="form-group">-->
                      <!--      <label for="exampleFormControlInput1">Company name</label>-->
                      <!--      <input type="text" class="form-control" name="txt_company" placeholder="Company name" value="<?php echo $user_details->user_company_name ?>" >-->
                      <!--    </div>-->
                      <!--</div>-->
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="profile_pic">
                        <label>Profile Photo</label>
                        <div class="image_wrap">
                            <img src="<?php echo $user_details->user_image!=""?base_url()."uploads/user/".$user_details->user_image:base_url()."images/user_dummy.png"; ?>" id="profileImage" name="profile_error" />
<!--                            <span>Update Photo -->
                            <label class="Pic_upload" for="file">
                              <input type="file" class="upload" id="file" aria-label="File example">
                              <span class="file-custom">Update Photo </span>
                            </label>
<!--                            </span>-->
                        </div>
                  </div>
              </div>
          </div>
          
          <div class="action text-left">
              <button type="button" class="btn btn-primary btn-lg" id="saveSettings">Save Changes</button>
          </div>
          
          <!--<h3>Address Book</h3>-->
          <!--<a class="btn btn-primary fa-edit" href="javascript:void()" id="addNewAddress" data-target="#addressBook"><i class="fa fa-plus"></i> Add New</a>-->
            
            <div class="address-wrapper-stored" id = "addressList">
               
           </div>
      </div>
  </form>
  </div>
  <div class="tab-pane tab_padd fade" id="tab10" role="tabpanel" aria-labelledby="contact-tab">
      <form id="formChangePwd">
      <div class="settings">
          <h3>Change Password</h3>
          <div class="row">
              <div class="col-md-12">
                   
          <div class="password">
              <label for="exampleFormControlInput1">Change Password</label>
              <div class="row">
                     <div class="col-md-4">
                          <div class="form-group">
                            <input type="password" class="form-control" id="txt_current_pwd" name="txt_current_pwd" placeholder="Current Password" value="" autocomplete="off">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <input type="password" class="form-control" id="txt_new_pwd" name="txt_new_pwd" placeholder="New Password" value="" autocomplete="off">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <input type="password" class="form-control" id="txt_confirm_pwd" name="txt_confirm_pwd" placeholder="Re-Enter Password" value="" autocomplete="off">
                          </div>
                      </div>
                </div>
          </div>
          <div class="action">
              <button type="button" class="btn btn-primary btn-lg" id="btnChangePwd">Save Changes</button>
          </div>
            </div>
        </div>
      </form>
     </div>
</div>
</div>
                        <!--end tab-->
                      
                        

                        
                        
                        
                    </div>
                    <!--end col md 12-->
                </div>
                <!--end row-->
            </div>
            <!--end col md 8-->

        </div>
        <!--end row-->
    </div>
    <!--end container fluid-->
</section>
<!--end section-->







<div class="modal fade bd-example-modal-lg vendorlist show" id="VendorList" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="padding-right: 16px; display: none;" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding-bottom: 0">
        <h5 class="modal-title" id="exampleModalCenterTitle">Vendor List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="respondedVendors">
        
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade provider_pop" id="ProviderDetailModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" id="detailDiv">
    
  </div>
</div>



 




 <div id="stop" class="scrollTop">
    <span><a href=""><i class="fas fa-angle-up"></i></a></span>
  </div>
  
  
  


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
<!--    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyCY-KEoe5yBMSV7t6FVJtvS27j9h6qp-wo'></script>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>frontend_assets/css/jquery-ui.theme.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

  <script>
   sessionStorage.removeItem("lastView");
 // alert(<?php echo count($providerArray);?>);
 
  $(function() {
  $("#bars li .bar").each( function( key, bar ) {
    var percentage = $(this).data('percentage');
    
    $(this).animate({
      'height' : percentage + '%'
    }, 1000);
  });
});

      
 $(function () {
      $(".rateYo").rateYo({
        rating: 4.5,
        readOnly: true,
        starWidth: "15px",
        normalFill: "#e0e0e0",
        ratedFill: "#fac917"
      });
 });
      
      
      $('#from_date').change(function(){
          loadJobRequests();
      });
      
      $('#to_date').change(function(){
          loadJobRequests();
      });

                         
                          
                          function loadJobRequests()
                          {
                             // alert();
                                
                                      var jobOrder  = $("#jobOrder").val();
                                      var jobSearch = $("#jobSearch").val();
                                       var job_status = $("#job_status").val();
                                        var from_date = $("#from_date").val();
                                      var to_date   = $("#to_date").val();
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: '<?php echo base_url();?>website/Request/loadJobRequestsUser',
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,quotation_status:job_status,search_key:jobSearch,jobOrder:jobOrder,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                                    {       
                                        //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#jobRequestSpan").html(data);
                                                // initMap();
                                         }
                                    });
                          }
            $("#jobRequestSpan").on("click", ".pagination a", function (e) 
            {
                         e.preventDefault();
                         var jobOrder  = $("#jobOrder").val();
                         var jobSearch = $("#jobSearch").val();
                          var job_status = $("#job_status").val(); 
                          var from_date = $("#from_date").val();
                                      var to_date   = $("#to_date").val();
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: $(this).attr("href"),
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,quotation_status:job_status,search_key:jobSearch,jobOrder:jobOrder,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                                    {       
                                        //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#jobRequestSpan").html(data);
                                                // initMap();
                                         }
                                    });
                         
                         
            });
                          $( document ).ready(function() {
                              
         
    $("#from_date").datepicker({
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        //minDate: 0,
        onSelect: function(selected) {
          $("#to_date").datepicker("option","minDate", selected);
          loadJobRequests();
        }
    });
    $("#to_date").datepicker({ 
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        onSelect: function(selected) {
           $("#from_date").datepicker("option","maxDate", selected),
           loadJobRequests();
        }
    });  
     $("#from_date_q").datepicker({
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        //minDate: 0,
        onSelect: function(selected) {
          $("#to_date_q").datepicker("option","minDate", selected);
          loadJobQuotations();
        }
    });
    $("#to_date_q").datepicker({ 
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        onSelect: function(selected) {
           $("#from_date_q").datepicker("option","maxDate", selected),
           loadJobQuotations();
        }
    });                       
                              
      loadJobRequests();
      loadJobQuotations();
     // loadRatings();
    //   initMap();
});
     $(document).delegate("#jobOrder,#job_status","change",function(e)
     {
          loadJobRequests();
     });
    $(document).delegate("#btnSearch","click",function(e)
     {
          loadJobRequests();
     });
      $(document).delegate(".changeStatus","click",function(e)
     {
         
           
         
         swal({
  title: "Are you sure?",
  text: "Do you want to change the status ?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) { 
  
  
  
  csrf_value      =   getCookie('csrf_cookie_name');   
            var itemId      =   $(this).attr("for");
            var action      =   $(this).attr("data-id");
            var provider    =   $(this).attr("data-foo");
             $.ajax({
                url: '<?php echo base_url();?>website/Request/changeStatusUser',
                type: 'POST',
                data: {provider:provider,itemId:itemId,action:action,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                success: function (data) 
            {       
                if(data>=1)
                {
                   // swal("status has been changed");
                   $("#VendorList").modal("hide");
                    loadJobRequests();
                    loadJobQuotations();
                    var lastViewed = sessionStorage.getItem("lastView");
                          $("#"+lastViewed).trigger("click");
                          //sessionStorage.removeItem("lastView");
                }
                else if(data==-1)
                {
                    swal("Job  already cancelled");
                    $("#VendorList").modal("hide");
                    loadJobRequests();
                    loadJobQuotations();
                }
                else if(data==-2)
                {
                    swal("Job  already confirmed");
                    $("#VendorList").modal("hide");
                    loadJobRequests();
                    loadJobQuotations();
                }
                 else if(data==-3)
                {
                    swal("Job  already cancelled for the provider");
                    $("#VendorList").modal("hide");
                    loadJobRequests();
                    loadJobQuotations();
                }
                 else if(data==-4)
                {
                    swal("Job  already confirmed for the provider");
                    $("#VendorList").modal("hide");
                    loadJobRequests();
                    loadJobQuotations();
                }
                else
                {
                     swal("Failed to change the status");
                }
                      
                         
                 }
            });
           
          
   
  } else {
      
   
  }
});

return false;
            
     });
      $(document).delegate(".view","click",function(e)
     {
           csrf_value       =   getCookie('csrf_cookie_name');   
            var itemId      =   $(this).attr("for");
            var type        =   $(this).attr("data-id");
            
            sessionStorage.removeItem("lastView");
            sessionStorage.setItem("lastView", $(this).attr("id"));
           
             $.ajax({
                url: '<?php echo base_url();?>website/Request/detailView',
                type: 'POST',
                data: {itemId:itemId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                success: function (data) 
            {   
                
               $(".quotation_detail").html("");
               if(type==1)
               {
                  $("#qutationDetailDIv").html(data);
               }
               else if(type==2)
               {
                   $("#requestDetailDIv").html(data);
               }
                     $('.job_list').hide();
                     $('.quotation_detail').show();  
                    //  initMap();    
                 }
            });
         
          
      });
      $('.nav-link').click(function(){
          
          $('.quotation_detail').hide();
          $('.job_list').show();
      });
        function loadJobQuotations()
                          {
                             // alert();
                                
                                      var jobOrder  = $("#quotationOrder").val();
                                      var jobSearch = $("#searchQuotation").val();
                                      var quotation_status = $("#quotation_status").val();
                                      var from_date = $("#from_date_q").val();
                                      var to_date   = $("#to_date_q").val();
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: '<?php echo base_url();?>website/Request/loadJobQuotationsUser',
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,quotation_status:quotation_status,search_key:jobSearch,jobOrder:jobOrder,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                                    {       
                                        //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#jobQuotationSpan").html(data);
                                                 
                                         }
                                    });
                          }
             $("#jobQuotationSpan").on("click", ".pagination a", function (e) 
            {
                         e.preventDefault();
                         var jobOrder  = $("#quotationOrder").val();
                         var jobSearch = $("#searchQuotation").val();
                        var quotation_status = $("#quotation_status").val();
                        var from_date = $("#from_date_q").val();
                         var to_date   = $("#to_date_q").val();
                        
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: $(this).attr("href"),
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,quotation_status:quotation_status,search_key:jobSearch,jobOrder:jobOrder,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                                    {       
                                        //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#jobQuotationSpan").html(data);
                                                 
                                         }
                                    });
                         
                         
            });
            
            
             $(document).delegate("#btnMarkPrice","click",function(e)
     {
                         //e.preventDefault();
                          dataString = $('#formMarkPrice').serialize();
                         // alert(dataString);
                 var formData = new FormData($("#formMarkPrice")[0]);
                 csrf_value  =   getCookie('csrf_cookie_name'); 
                 jobRequestId = $(this).attr("for");
                 formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                 formData.append( "jobRequestId", jobRequestId );
                    $.ajax({
             url: '<?php echo base_url();?>website/Request/markPrice',
             type: 'POST',
             data: formData,
             async: true,
             success: function (data) 
                {
                   
                  data =  jQuery.parseJSON(data);
              if(data['status']==1)
                    {
                       
                          swal("Well done!", "Price Marked Successfully!", "success");
                          loadJobQuotations();     
                    }                 
                    else if(data['status']==0)
                    {
                          if(data['errors'] !== "")
                          {
                            $.each(data['errors'], function(key, value) {
                                //console.log(key); console.log(value);
                                //$('input[name='+key+']').addClass('is-invalid');

                             $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '#fileDiv');

                            });                          
                          }else{    
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          }


                    }
                    else if(data['status']<0)
                    {    
                           swal("Sorry!", "Price already marked", "error");
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
                                  
          
      });
        $(document).delegate("#inputGroupFile02","change",function(e)
     {
         fileName     = $('#inputGroupFile02').val();        
         $("#labelUploadDoc").html(fileName);
 });      
 
 
                         
            
        $(document).delegate("#quotationOrder,#quotation_status","change",function(e)
     {
         loadJobQuotations();
     });       
       $(document).delegate("#btnSearchQtn","click",function(e)
     {
         loadJobQuotations();
     }); 
        $(document).delegate("#jobOrder","change",function(e)
     {
         loadJobRequests();
     });       
       $(document).delegate("#btnSearch","click",function(e)
     {
         loadJobRequests();
     }); 
     function loadRatingLoop()
     {
          $('.rateYoLoop').each(function() {
          rating = $(this).attr("data-rating");
          $(this).rateYo({
           
            rating: rating,
             readOnly: true,
                starWidth: "15px",
                normalFill: "#e0e0e0",
                ratedFill: "#fac917"
           });
         });

     }
       $(document).delegate(".setServiceType,.reselectService","click",function(e)
     {
         $(this).toggleClass("selected");
     }); 
     
        $(document).delegate("#btnPrimarySettings","click",function(e)
     {
         
            //e.preventDefault();
         
            lattitude    =   $("#pickup-lattitude").val();
            longittude   =   $("#pickup-longittude").val();
             location_name     =   $("#pickup-input").val();
            //alert();
           //return false;
           mappedItems =    $( ".primary_setting > .selected" ).map(function() {
    return $(this).attr("data-id");
              }).get().join();
              
              error = 0;
             $("#primaryServiceTypeError").html("");
             $("#primaryLocationError").html("");
             if(mappedItems=="")
             {
                 $("#primaryServiceTypeError").html("Please select atleast one service type");
                  
                error=1; 
             }
              if(location_name=="")
             {
                  $("#primaryLocationError").html("Please select a location");
                  error=1;  
             }
            // alert(error);
            // return false;
             if(error==0)
             {
                                        csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url:'<?php echo base_url();?>website/Request/savePrimarySettings',
                                        type: 'POST',
                                        data: {mappedItems:mappedItems,location_name:location_name,lattitude:lattitude,longittude:longittude,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                                    { 
                                       loadJobQuotations(); 
                                         data =  jQuery.parseJSON(data);
                                         
                                         
                                         if(data['status']==1)
                                                    {
                                                        $("#exampleModalCenter").modal("hide");
                                                        swal("Settings has been saved");
                                                        return false;
                                                    }
                                                      if(data['status']==0)
                                                    {
                                                       
                                                        if(data['errors'] !== "")
                                                              {
                                                                            $.each(data['errors'], function(key, value) 
                                                                            {
                                                                              
                                                                                 $( '#'+key ).html(value);
                                                                                
                                                
                                                                            });   
                                                                
                                                                 
                                                              }else
                                                              { 
                                                                  alert();
                                                                  
                                                                $("#resultSpan").text("Failed to save,try again later");
                                                             
                                                              }

                                                    }
                                               
                                         }
                                    });
             }
             else
             {
                 return false;
             }
     }); 
     function readURLProfile(input) {
        

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#profileImage').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}    
       $(document).delegate("#file","change",function(e)
{
         
         readURLProfile(this);
 });
   $(document).delegate("#saveSettings","click",function(e)
{
         $("#prfile_form").submit();
        
 });
 
  
 
   var validator=$("#prfile_form").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          user_first_name: 
          {
            required: true,
            maxlength: 100,
            lettersonly:true,
            
          }, 
          user_last_name: 
          {
            required: true ,
            maxlength: 100
          } ,
          txt_phone: 
          {
            required: true,
            maxlength: 12,
            number: true
          } ,
           "pickup-input2": 
          {
            required: true,
            maxlength: 500
          }/* ,
           "pickup-input4": 
          {
            required: true,
            maxlength: 500
          }*//* ,
           "pickup-input5": 
          {
            required: true,
            maxlength: 500
          } */
        },
       
        messages: 
        {
       
         },
     submitHandler: function ()
        {
      
    
              profile_image = $('#file').get(0).files[0];
               
               
                var formData = new FormData($("#prfile_form")[0]);
                
                //formData.append('mappedItems', mappedItems);
                formData.append("profile_image", profile_image);
               // formData.append("trade_license", trade_license);
                csrf_value  =   getCookie('csrf_cookie_name');  
                formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                
                     $.ajax({
             url: '<?php echo base_url();?>website/User/updateUserProfile',
             type: 'POST',
             data: formData,
             async: false,
             success: function (data) 
                {
                    $(".errorSpan1").html("");
                     data =  jQuery.parseJSON(data);
                    if(data['status']==1)
                    {
                        swal("Profile has been updated successfully");
                        // location.reload();
                    }else if(data['status']==2){
                        $('#otpId').val(data['otp_id']);
                        $('#verifyOtp')[0].reset();
                        $('#otpModal').modal({backdrop: 'static', keyboard: false}) 
                    }
                    else
                    {
                         
                        if(data['errors'] !== "")
                          {
                            $.each(data['errors'], function(key, value) 
                            {
                              
                                 $( '<span class="error errorSpan1">'+value+'</span>' ).insertAfter( '[name="'+key+'"]');
                                

                            });   
                            
                            
                          }else
                          {    
                           
                           swal("Sorry!", "Failed to save! Try again later", "error");
                          
                          }
                    }
               },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
 });  
   Highcharts.chart('barChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Job request details'
    },
    subtitle: {
       // text: 'Source: WorldClimate.com'
    },
    xAxis: {
        <?php
        $monthArray['01'] ="Jan";
        $monthArray['02'] ="Feb";
        $monthArray['03'] ="Mar";
        $monthArray['04'] ="Apr";
        $monthArray['05'] ="May";
        $monthArray['06'] ="Jun";
        $monthArray['07'] ="Jul";
        $monthArray['08'] ="Aug";
        $monthArray['09'] ="Sep";
        $monthArray['10'] ="Oct";
        $monthArray['11'] ="Nov";
        $monthArray['12'] ="Dec";
        ?>
        categories: [
            <?php
            $k =1;
            foreach($monthArray as $rows)
            {
                
                echo "'".$rows."'";
                if($k!=count($monthArray))
                {
                    echo ",";
                }
                ?>
            
            <?php
            $k++;
            }
            ?>
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Requests'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} Nos</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    credits: {
      enabled: false
  },
    series: [{
        name: 'Jobs',
        data: [
            <?php 
            $result         =   $this->M_user->monthWiseCount(2); 
           // print_r($result);
            $k =1;
            foreach($monthArray as $key=>$rows)
            {
                
                echo $result[$key]>0?$result[$key]:"0";
                if($k!=count($monthArray))
                {
                    echo ",";
                }
                ?>
            
            <?php
            $k++;
            }
            ?>
           // 49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4
            ],
        color: '#438eca'

     },
     // {
    //     name: 'Quotations',
    //     data: [
    //         <?php 
    //         $result         =   $this->M_user->monthWiseCount(1);  
    //        // print_r($result);
    //         $k =1;
    //         foreach($monthArray as $key=>$rows)
    //         {
                
    //             echo $result[$key]>0?$result[$key]:"0";
    //             if($k!=count($monthArray))
    //             {
    //                 echo ",";
    //             }
    //             ?>
            
    //         <?php
    //         $k++;
    //         }
    //         ?>
    //         //83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3
    //         ],
    //     color: '#ff1203' 

    // }
    ]
});  
 $(document).delegate(".viewOffers","click",function(e)
{
                    $("#respondedVendors").html("");
                    var jobRequestId = $(this).attr("for");
     
                     csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url:'<?php echo base_url();?>website/Request/viewOffers',
                                        type: 'POST',
                                        data: {jobRequestId:jobRequestId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                                    {
                                        $("#respondedVendors").html(data);
                                        $("#VendorList").modal("show");
                                          }
                                    });
    // alert(jobRequestId);
        
        
 });
 $(document).delegate("#job-tab","click",function(e)
     {
          sessionStorage.removeItem("lastView");
          loadJobRequests();
     });
      $(document).delegate("#quto-tab","click",function(e)
     {
          sessionStorage.removeItem("lastView");
          loadJobQuotations();
     });
     function getProviderDetails(providerId)
     {
              csrf_value                 =   getCookie('csrf_cookie_name');    
              option =1;
           
          $.ajax({
            url: '<?php echo base_url();?>website/Request/getProviderDetails',
            type: 'POST',
            data: {option:option,providerId:providerId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
        {   
            $("#exampleModalCenterTitle").modal("hide");
                  $("#ProviderDetailModalCenter").modal("show");
                  $("#detailDiv").html(data);
                  loadRating();
                  loadRatingLoop();
             }
        });
     }
     function loadRating()
{
//     $(".rateYo").rateYo({
//        rating: 4.5,
//        readOnly: true,
//        starWidth: "15px",
//        normalFill: "#e0e0e0",
//        ratedFill: "#fac917"
//      });
      $(".rateYo1").rateYo({
        rating: 0,
        starWidth: "25px",
        normalFill: "#e0e0e0",
        ratedFill: "#fac917"
      }).on("rateyo.change", function (e, data) {
                var rating = data.rating;
                $(this).find(".rateval").remove();
                $(this).append("<span class='rateval'>"+rating+"</span>");
              });
 }
      function loadRatingLoop()
     {
         $('.rateYoLoop').each(function() {
        rating = $(this).attr("data-rating");
  $(this).rateYo({
   
    rating: rating,
     readOnly: true,
        starWidth: "15px",
        normalFill: "#e0e0e0",
        ratedFill: "#fac917"
  });
});
     }
 function loadRatingLoop2()
     {
         $('.rateYoLoop2').each(function() {
        rating = $(this).attr("data-rating");
  $(this).rateYo({
   
    rating: rating,
     readOnly: true,
        starWidth: "15px",
        normalFill: "#e0e0e0",
        ratedFill: "#fac917"
  });
});

     }
     
       $(document).delegate("#btnAddRating","click",function(e)
    {
           var user_id = '<?php echo $this->session->userdata("eq_user_id");?>';
           if(user_id<=0)
           {
               $("#exampleModal").modal("show");
           }
            var txt_feedback = $("#txt_feedback").val();
            var rateval  = $(".rateval").text();
            var providerId  = $("#txt_provider").val();
          //  alert(rateval);
        
            error=0;
            if(txt_feedback=="")
            {
                $("#error_txt_feedback").html("Enter a feedback");
                error=1;
            }
            else
            {
                $("#error_txt_feedback").html("");
            }
               if(rateval<=0)
            {
                $("#error_txt_rating").html("Select a rating");
                error=1;
            }
            else
            {
                $("#error_txt_rating").html("");
            }
            
            if(error==0)
            {
                  csrf_value                 =   getCookie('csrf_cookie_name');   
                  $.ajax({
            url: '<?php echo base_url();?>website/Request/addRating',
            type: 'POST',
            data: {txt_feedback:txt_feedback,rateval:rateval,providerId:providerId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
        {       
                                                                         data =  jQuery.parseJSON(data);
                                                                        
                                                                          if(data['status']==1)
                                                                            {
                                                                                  $(".error").html("");// clear all errors
                                                                                   getProviderDetails(providerId);
                                                                             }
                                                                             else if(data['status']==3)
                                                                             {
                                                                                 $("#exampleModalCenter").modal("hide"); 
                                                                                 swal("You already rated this provider");
                                                                             }
                                                                             else
                                                                             {
                                                                                 $("#exampleModalCenter").modal("hide"); 
                                                                                   swal("Something went wrong, try again later");
                                                                             }
                                                                 }
        });
            }
     });
      $(document).delegate("#btnChangePwd","click",function(e)
     {
        $("#formChangePwd").submit();
     }); 
     var validator=$("#formChangePwd").validate(
            //alert();
        {
           ignore: [],
        rules: 
        {
          
          txt_current_pwd: 
          {
            required: true,
            maxlength: 20
            
          }, 
          txt_new_pwd: 
          {
            required: true ,
            minlength: 8,
            maxlength:20 ,
            passwordCheck:true
          } ,
          txt_confirm_pwd: 
          {
            required: true ,
            maxlength: 20,
            equalTo: "#txt_new_pwd"
          } 
        },
       
        messages: 
        {
       
         },
     submitHandler: function ()
        {
    
                var formData = new FormData($("#formChangePwd")[0]);
                
               
                csrf_value  =   getCookie('csrf_cookie_name');  
                formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                
                     $.ajax({
             url: '<?php echo base_url();?>website/User/changePassword',
             type: 'POST',
             data: formData,
             async: false,
             success: function (data) 
                {
                    $(".errorSpan1").html("");
                    $("#formChangePwd")[0].reset();
                    // data =  jQuery.parseJSON(data);
                    if(data==1)
                    {
                        swal("Password has been updated successfully");
                        
                    }
                    else if(data<0)
                    {
                         swal("Old password not matching");
                    }
                    else
                    {
                      swal("Sorry!", "Failed to update password ! try again later", "error");
                    }
               },
             cache: false,
             contentType: false,
             processData: false
         });

                     return false;
      
        
                }
       
 });  
 $(document).delegate("#resetEqFilters","click",function(e)
     {
      
      $("#jobSearch").val("");
      $("#jobOrder").val("newest");
      $("#job_status").val("");
      $("#from_date").val("");
      $("#to_date").val("");
      loadJobRequests();
     }); 
  $(document).delegate("#resetQuotFilters","click",function(e)
     {
      
      $("#searchQuotation").val("");
      $("#quotationOrder").val("newest");
      $("#quotation_status").val("");
      $("#from_date_q").val("");
      $("#to_date_q").val("");
      loadJobQuotations();
     }); 
</script>
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI&callback=initMap"></script>-->

<!--<script src="https://maps.google.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI&libraries=places&language=en&sensor=false"></script>-->

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCHFZ49O5XuPD9RR-s0grdzBoV4wAZxJB8&v=weekly&libraries=places&callback=initMap" async defer></script>
  </body>
</html>


<script>
    
    // $('#addNewAddress').click(function(){
    //     $('#formDynamicAddress').trigger("reset");
    //     $('#addressBook').modal('show'); 
    //     return false;
    // });
    
    $('body').on('change', '#country', function(e) {
        // country_code = '+'+$("#country option:selected").attr("for");
        // // $('#dial_code').val(country_code);
        country_id = $('#country').val();
        
        if(country_id > 0 )
            getCityList(country_id);
        else{
            html = "<option value=''>Choose Country</option>";
            $('#city').html(html);
            html = "<option value=''>Choose City</option>";
            $('#area').html(html);
        }
        $('#city').trigger("change");
    });

    function getCityList(country_id){
        // alert(country_id);
        $.ajax({
             url: '<?php echo base_url();?>website/Request/getCityListByCountryId',
             type: 'POST',
             data: {country_id:country_id},
             success: function (data){
                $('#city').html(data);
                $('#city').trigger("change");
            }
        });
    }
    
  
    
    $('body').on('change', '#city', function(e) {
        city_id = $('#city').val();
        
        if(city_id > 0 ){
            $.ajax({
                 url: '<?php echo base_url();?>website/Request/getAreaByCityId',
                 type: 'POST',
                 data: {city_id:city_id},
                 success: function (data){
                    $('#area').html(data);
                }
            });
        }else{
            html = "<option value=''>Choose City</option>";
            $('#area').html(html);
        }
    });
    
    
    // $('#settings-tab').click(function(){
    //     getAddressList();
    // });
    
    function getAddressList(){

        $.ajax({

            url: '<?php echo base_url();?>website/Request/getUserAddressList_ajax',
            type: 'POST',
            data: {},
            async: true,
            success: function (data){
                $('#user_address_list').html(data);
                // console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    
    $(document).delegate(".editAddress","click",function(e){
        id = $(this).attr("for");
        // alert(id);
        $.ajax({
 
            url: '<?php echo base_url();?>website/Request/getUserAddressDetails',
            type: 'POST',
            data: {id:id},
            success: function (data){
               $('#formDynamicAddress').html(data);
            }
        });
        $('#addressBook').modal('show'); 
}); 
    
    
    $('#address_list').click(function(){
        getAddressList();
    });
    
   
    
    $('#addNewAddress').click(function(){
        $('#formDynamicAddress').trigger("reset");
         id = 0;//$(this).attr("for");
        // alert(id);
            $.ajax({
     
                url: '<?php echo base_url();?>website/Request/getUserAddressDetails',
                type: 'POST',
                data: {id:id},
                success: function (data){
                   $('#formDynamicAddress').html(data);
                }
            });
            $('#addressBook').modal('show'); 

    });
    
     $('.signOut').click(function(){
            signOut();
        });
        
        function signOut() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                // alert('signout');
            });
        }
</script>


<div class="modal fade provider_pop" id="addressBook" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog update-address modal-dialog-centered modal-dialog-scrollable" role="document" id="">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addressBookTitle">Add Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    </div>
      <div class="modal-body">
        <div class="container-fluid" id="dynamicAddressForm">
            <form id="formDynamicAddress" action="#" class="row" method="post">
               <div class="col-lg-6">
                     <div class="form-group">
                             <label>Address Type</label>
                            <div class="custom-control d-flex p-0">
              <label for="Company">
                <input class="select_radiobtn" type="radio" name="address_type" value="1" checked="checked">Home &nbsp; &nbsp; &nbsp; </label>
                <label for="Freelancer">
                <input class="select_radiobtn" type="radio" name="address_type" value="2" >Office &nbsp;</label>
                
                <label for="Freelancer">
                <input class="select_radiobtn" type="radio" name="address_type" value="3">Other &nbsp;</label>
            </div>
                         </div>
    
    
    
                     <div class="location_wrap">
                       <div class="form-group">
                            <label for="exampleFormControlInput1" id="addressTypeLabel" style="color:#0e688d"><i class="far fa-check-circle"></i> Home</label>
                            <input type="text" class="form-control" id="pickup-input2" name="pickup-input2" placeholder="Location" value="<?php echo $homeLocation ?>">
                            <input type="hidden" class="form-control" id="pickup-lattitude2" name="pickup-lattitude2" value="<?php echo $homeLattitude ?>">
                            <input type="hidden" class="form-control" id="pickup-longittude2" name="pickup-longittude2" placeholder="Type Your Location" value="<?php echo $homeLongitude ?>">
                            <input type="hidden" class="form-control" id="selected_address_type" name="selected_address_type"  value="1">
                          </div>
                          
                        <div id="map2" style="height: 250px;"></div>
                      
                     </div>
       </div>
       
                  <div class="col-lg-6">
            
             <div class="row">
                       <div class="col-md-6">
                    <div class="form-group">
                             <label>First Name</label>
                             <input class="form-control" placeholder="First Name" name="first_name" id="first_name">
                         </div>
                         
               </div>
            
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Last Name</label>
                             <input class="form-control" placeholder="Last Name" name="last_name">
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Email Address</label>
                             <input class="form-control" placeholder="Email addresss" name ="email">
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Mobile Number</label>
                           <div class="form-group nuber-text">
                                 <input type="text" class="form-control" id="dial_code" name="dial_code" style="width:30%;float: left;padding:0" readonly>
             
              <input type="number" class="form-control" placeholder="Mobile Phone" id="user_phone" name="user_phone" style="width:70%;">
            </div>
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Country</label>
                             <select class="form-control" name="country" id="country">
                                <option>Choose country...</option>
                            <?php
                                foreach ($country_list as $key => $value) {
                                    if($value->country_id == $address_details->user_adresses_country)
                                        $selected = "selected";
                                    else
                                        $selected = "";
                            ?>
                             <option value="<?=$value->country_id?>" for="<?=$value->country_dial_code?>" <?=$selected?>><?=$value->country_name?></option>
                            <?php
                                }
                            ?>
                         </select>
                         </div>
               </div>
               <div class="col-md-6">
                    <div class="form-group">
                             <label>City</label>
                         <select class="form-control" name="city" id="city">
                             <option value="">Choose country first</option>
                         </select>
                         </div>
               </div>
               
               <div class="col-md-6">
                    <div class="form-group">
                             <label>Area</label>
                         <select class="form-control" name="area" id="area">
                             <option value="">Choose city first</option>
                         </select>
                         </div>
               </div>
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building Name</label>
                        <input class="form-control" placeholder="" name="building_name" city="building_name">         
                    </div>
               </div>
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Street Name</label>
                        <input class="form-control" name="street_name" id="street_name" placeholder="">
                    </div>
               </div>
             
               
           
           
               <div class="col-md-12 text-center">
                    <input type="submit"  class="btn btn-primary mt-2" value="SAVE" id="addressSaveBtn">
               </div>
                  </div>
        </div>
             
              
            </form>   
        </div>         
    </div>
     
    </div>
  </div>
</div>
</div>