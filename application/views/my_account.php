<?php
//print_r($user_details);
//exit;
?>
<style>
   .pac-container{
        z-index: 9999999999;
}
.swal-modal {
     z-index: 9999999999;
}

.swal-modal {
     z-index: 9999999999;
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
.error{
    color:red;    
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
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
                <li><a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon1.png"/></span>  <span>Dash Board</span></a></li>
                <li><a class="nav-link" id="job-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon2.png"/></span>  <span>Job request</span></a></li>
                <!--<li><a class="nav-link" id="quto-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon3.png"/></span>  <span>Quotations</span></a></li>-->
                <!--<li><a class="nav-link" id="myrating-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon4.png"/></span>  <span>My Ratings	</span></a></li>-->
                <li><a class="nav-link" id="staff" data-toggle="tab" href="#tab11" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon3.png"/></span>  <span>Staff</span></a></li>
                <!--<li><a class="nav-link" id="transaction-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon5.png"/></span>  <span>Transaction Summary</span></a></li>-->
               <!-- <li><a class="nav-link" id="report-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon6.png"/></span>  <span>Report	</span></a></li>-->
                <li><a class="nav-link" id="settings-tab" data-toggle="tab" href="#tab7" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon7.png"/></span>  <span>My Profile</span></a></li>
                <!--<li><a class="nav-link" id="report-tab" data-toggle="tab" href="#tab8" id="eq_report-tab" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon6.png"/></span>  <span>Report  </span></a>-->
                <!--  <ul class="submenu">-->
                <!--    <li><a class="nav-link" id="eq_report-tab" data-toggle="tab" href="#tab8" role="tab" aria-controls="contact" aria-selected="false"></span>  <span>EQ Recommended report	</span></a></li>-->
                <!--    <li><a class="nav-link" id="quot_report-tab" data-toggle="tab" href="#tab9" role="tab" aria-controls="contact" aria-selected="false"></span>  <span>Quotation report	</span></a></li>-->
                <!--  </ul>-->
                <!--</li>-->
                <li><a class="nav-link" id="eq_report-tab" data-toggle="tab" href="#tab8" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon6.png"/></span></span>  <span>Request report	</span></a></li>
                <li><a class="nav-link" id="settings-tab" data-toggle="tab" href="#tab10" role="tab" aria-controls="contact" aria-selected="false"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon7.png"/></span>  <span>Change Password</span></a></li>
                <li><a class="nav-link" href="<?php echo base_url()?>website/User/logout"><span><img src="<?php echo base_url();?>frontend_assets/images/menu-icons/icon8.png"/></span>  <span>Logout	</span></a></li>
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
  <div class="tab-pane tab_padd fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">
      <h3>Dashboard</h3>
      <!--start row-->
      <div class="row margin_none">
          <!--end col md 6-->
          <div class="col-md-6 col-sm-12">
              <!--start row-->
              <div class="row colms" id="barChart" style="height: 103%;">
                  <!--<h3><span><img src="<?php echo base_url();?>frontend_assets/images/content-icon/icon-1.png"/></span> Monthly Job Request &amp; Quotations</h3>
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
                      <li><a href="#" id="pending_job" ><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side1.png"/></span> <span>Pending Job Request </span> <span><?php echo $this->M_user->getPendingJobRequest(); ?></span></a></li>
                      <li><a href="#" id="confirmed" class="yello"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side2.png"/></span> <span>Accepted Job Request </span> <span><?php echo $this->M_user->getTotalAcceptedrequest(); ?></span>       </a></li>
                      <li><a href="#" id="staff_assigned" class="green"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side3.png"/></span> <span></span>Staff Assigned<span><?php echo $this->M_user->getTotalStaffAssigned(); ?></span>       </a></li>
                      <li><a href="#" id="ongoing" class="green"><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side3.png"/></span> <span>On going Jobs</span> <span><?php echo $this->M_user->getTotalOnGoingJobs(); ?></span>       </a></li>
                      <li><a href="#" id="completed_job" ><span><img src="<?php echo base_url();?>frontend_assets/images/icons/side1.png"/></span> <span>Completed Job Request </span> <span><?php echo $this->M_user->getTotalJobCompleted(); ?></span>       </a></li>
                      
                      
                  </ul>
              </div>
              <!--end row-->
          </div>
          <!--end col md 6-->          
          
          
      </div>
      
      <div class="row margin_none next_row">
          <!--end col md 6-->
          <div class="col-md-12 col-sm-12 padd-ctrls" style="display: none;">
              <!--start row-->
              <div class="row colms table-responsive">
                  <h3><span><img src="<?php echo base_url();?>frontend_assets/images/content-icon/icon-2.png"/></span> Recent Quotation List</h3>
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
      if(count($job_list)>0)
      {
      foreach($job_list as $rows){
        //   print_r($job_list);
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
           <tr><td colspan="6" style="text-align: center";>No results found</td></tr>
          <?php
          
      }
    ?>
    
        
   
  </tbody>
</table>
                  
              </div>
              <!--end row-->
          </div>
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
      <th>Status</th>
      <th >Service Date & Time</th>
      <!--<th >Validity Date & Time</th>-->
    </tr>
  </thead>
  <tbody>
    <?php 
    //   print_r($job_list);
    //   echo count($request_list);
      if(count($request_list)>0)
      {
      foreach($request_list as $key=> $rows){
          
      $img = $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png"; 
        $status_code = $rows->job_request_status;
        if($status_code == 0 )
            $status = "Pending";
        else if($status_code == 1 )
            $status = "Accepted";
        else if($status_code == 3 )
            $status = "Staff assigned";
        else if($status_code == 4)
            $status = "On going";
        else if($status_code == 5 )
            $status = "Completed";
        else 
            $status  = "cancelled";
          
      ?>
    <tr>
      <td><?php echo $rows->job_request_display_id ?></td>
      <td><span><img src="<?php echo $img;?>"/></span></td>
      <td><?php echo $rows->user_first_name ?> <?php echo $rows->user_last_name ?></td>
      <td><?php echo $rows->service_type_name ?></td>
      <td><?=$status?></td>
      <td><?php echo date("d-m-Y",strtotime($rows->job_validity_date)) ?> <?php echo date("h i A",strtotime($rows->job_validity_time)) ?></td> 
      <!--<td><?php echo $rows->job_date!=""?date("d-m-Y",strtotime($rows->job_date)):"" ?> <?php echo $rows->job_time!=""?date("h i A",strtotime($rows->job_time)):"NA" ?></td>-->
    </tr>
    <?php }
      }
      else
      {
          ?>
           <tr><td colspan="6" style="text-align:center;">No results found</td></tr>
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
  
  
  
  <div class="tab-pane tab_padd_top_bottom fade" id="tab2" role="tabpanel" aria-labelledby="profile-tab">
     <div class="job_list">
      <!--start row-->
      <div class="row margin_none">
          <!--start col md 6-->
          <div class="col-md-7 col-sm-6">
              <h3>Job Request List</h3>
              
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
    <option value="confirmed">Accepted</option>
    <option value="staff_assigned">Staff Assigned</option>
    <option value="ongoing">Ongoing</option>
    <option value="completed">Completed</option>
  </select>
              </div>
                  <div class="col-md-2 col-sm-3 form-group">
 <input class="form-control datePickerJob" id="from_date" placeholder="Starting date">
    
              </div>
                <div class="col-md-2 col-sm-3 form-group">
 <input class="form-control datePickerJob" id="to_date" placeholder="End date">
    
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
      <th scope="col" style="width:46%;">Description</th>
    
      <th scope="col" style="width:12%; text-align:center;">Date</th>
      <th scope="col" style="width:12%; text-align:center;">Status</th>
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
          <!--start col md 6-->
          <div class="col-md-7 col-sm-6">
              <h3>Quotations</h3>
          </div>
          <!--end col-md 6-->
          
          
          <!--start col md 6-->
          <div class="col-md-12 col-sm-12">
              <!--start row-->
              <form class="row job_search">
              <!--start col md 7-->
              <div class="col-md-3 col-sm-6 form-group">
                  <aside>
                      <span><input class="form-control" type="text" placeholder="Search" id="searchQuotation"></span>
                      <span><button type="button" id="btnSearchQtn"><img src="<?php echo base_url();?>frontend_assets/images/icons/search-job.png"/></button></span>
                  </aside>
                  
              </div>
              <!--end col md 7-->
              
              <!--start col md 5-->
              <div class="col-md-2 col-sm-3 form-group">
  <select class="form-control" id="quotationOrder">
    <option value="newest">Sort by</option>
    <option value="newest">Newest</option>
    <option value="oldest">Oldest</option>
  </select>
  
              </div>
                <div class="col-md-2 col-sm-3 form-group">
  <select class="form-control" id="quotation_status">
      <option value="">Status</option>
    <option value="pending">Pending</option>
    <option value="cancelled">Cancelled</option>
    <option value="confirmed">Confirmed</option>
  </select>
  
              </div>
               <div class="col-md-2 col-sm-3 form-group">
 <input class="form-control datePickerJob" id="from_date_q" placeholder="Starting date">
    
              </div>
                <div class="col-md-2 col-sm-3 form-group">
 <input class="form-control datePickerJob" id="to_date_q" Placeholder="Ending date">
    
              </div>
            <div class="col-md-1 col-sm-3 form-group">
 <button type="button" class="btn btn-primary" id="resetQuotFilters">Reset</button>
    
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
      <th scope="col" style="width:46%;">Description </th>
    
      <th scope="col" style="width:12%; text-align:center;">Date</th>
      <th scope="col" style="width:12%; text-align:center;">Status</th>
      <th scope="col" style="text-align:center; border-right:0 !important;">Action</th>
    </tr>
  </thead>
  <tbody id="jobQuotationSpan">
    
   
    
    

  </tbody>
</table>
      </div>
          <!--end row-->
      </div>
      <!--end col md 12-->
    </div>
  <div class="quotation_detail" style="display: none" id="qutationDetailDIv">

    <div id="map3" style="height: 250px;"></div>

    </div>
  
  </div>
  
  <div class="tab-pane tab_padd fade" id="tab11" role="tabpanel" aria-labelledby="contact-tab">
    <div class="job_list" id="staff_list">
      <!--start row-->
      <div class="row margin_none">
          <!--start col md 6-->
          <div class="col-md-7 col-sm-6">
              <h3>Staff List</h3>
          </div>
          <!--end col-md 6-->
          
          <div class="col-md-5">
            <button class="btn btn-primary float-right" onclick="addEditForm();">Add Staff</button>
          </div>
          <!--start col md 6-->
          <div class="col-md-12 col-sm-12">
              <!--start row-->
              <form class="row job_search">
              <!--start col md 7-->
              <div class="col-md-3 col-sm-6 form-group">
                  <aside style="display: none;"> 
                      <span><input class="form-control" type="text" placeholder="Search" id="searchQuotation"></span>
                      <span><button type="button" id="btnSearchQtn"><img src="<?php echo base_url();?>frontend_assets/images/icons/search-job.png"/></button></span>
                  </aside>
                  
              </div>
              <!--end col md 7-->
              
              <!--start col md 5-->
      
                <div class="col-md-2 col-sm-3 form-group">
  
  
              </div>
               <div class="col-md-2 col-sm-3 form-group">
    
              </div>
                <div class="col-md-2 col-sm-3 form-group">
    
              </div>
            <div class="col-md-1 col-sm-3 form-group">
              <!-- <button type="button" class="btn btn-primary" id="resetQuotFilters">Reset</button> -->
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
      <th scope="col" style="width:2%;">#</th>
      <th scope="col" style="width:10%;">Image</th>
      <th scope="col" style="width:15%;">Name</th>
      <th scope="col" style="width:12%;">Country</th>
      <th scope="col" style="width:15%;">Mobile Number</th>
      <th scope="col" style="width:15%;">Email</th>
      <th scope="col" style="width:12%; ">Status</th>  
      <th scope="col" style="text-align:center; border-right:0 !important;">Action</th>
    </tr>
  </thead>
  <tbody id="staffList">

  </tbody>
</table>
      </div>
          <!--end row-->
      </div>
      <!--end col md 12-->
    </div>
  <div class="quotation_detail" style="display: none" id="addStaff">
    

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
          <a href="website/Request/exportTransaction"><button type="button" class="btn btn-primary btn-lg export">Export to Excel</button></a>
          <div class="table-responsive">
          <table class="table  table-bordered transaction_table">
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
    <?php
     if(count($trans_details) > 0)
                                 {
                                    
                                      foreach($trans_details as $rows)
                                      {
    ?>
    <tr>
      <td><?php echo $rows->package_purchase_serial!=""?$rows->package_purchase_serial:"";?></td>
      <td><?php echo $rows->packages_name_arabic!="" && $languageCode==2?$rows->packages_name_arabic:$rows->packages_name;?></td>
      <td><?php echo date("d-m-Y h i A",strtotime($rows->package_purchase_date)) ?></td>
      <td><?php echo $rows->packages_price>0?(string)$rows->packages_price:""; ?></td>
      <td>175</td>
    </tr>
    <?php
                                      }
                                 }
    ?>
  </tbody>
</table>
</div>
      </div>
  </div>
  
   <div class="tab-pane tab_padd fade" id="tab8" role="tabpanel" aria-labelledby="contact-tab">
      <div class="transaction">
          <h3>Job request report</h3>

           <div class="row">
             <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-5"><input class="form-control datePickerJob" id="from_date_q_report" placeholder="Start Date" ></div>
                <div class="col-sm-5"><input class="form-control datePickerJob"  placeholder="End Date" id="to_date_q_report" ></div>
                <div class="col-sm-2"><a href="#"><button type="button" class="btn btn-primary btn-lg export" id="jobReportSearch">Submit</button></a></div>
                 </div>
               </div>
             <div class="col-sm-3">
              <div class="row">
             <div class="col-sm-12"><a href="javascript:void(0)"><button type="button" class="btn btn-primary btn-lg exportBtn exportJobReport">Export to Excel</button></a></div>
           </div></div></div>
          <div class="table-responsive">
          <table class="table  table-bordered transaction_table">
  <thead>
    <tr>
      <th scope="col">Job number</th>
      <th scope="col">Service type</th>
      <th scope="col">Location</th>
      <th scope="col">Service date</th>
      <th scope="col">Service time</th>
      <th scope="col">Price</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody id="eqReport">
    
  </tbody>
</table>
</div>
      </div>
  </div>
   <div class="tab-pane tab_padd fade" id="tab9" role="tabpanel" aria-labelledby="contact-tab">
      <div class="transaction">
          <h3>Quotation report</h3>

           <div class="row">
             <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-5"><input class="form-control datePickerJob" id="from_date_qu_report" placeholder="Start Date" ></div>
                <div class="col-sm-5"><input class="form-control datePickerJob"  placeholder="End Date" id="to_date_qu_report" ></div>
                <div class="col-sm-2"><a href="#"><button type="button" class="btn btn-primary btn-lg export" id="quoReportSearch">Submit</button></a></div>
                 </div>
               </div>
             <div class="col-sm-3">
              <div class="row">
             <div class="col-sm-12"><a href="javascript:void(0)"><button type="button" class="btn btn-primary btn-lg exportBtn exportQuotReport">Export to Excel</button></a></div>
           </div></div></div>
          <div class="table-responsive">
          <table class="table  table-bordered transaction_table">
  <thead>
    <tr>
      <th scope="col">Job number</th>
      <th scope="col">Service type</th>
      <th scope="col">Location</th>
      <th scope="col">Validity date</th>
      <th scope="col">Validity time</th>
      <th scope="col">Price</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody  id="quotReport">
    
  </tbody>
</table>
</div>
      </div>
  </div>
  <div class="tab-pane tab_padd fade" id="tab6" role="tabpanel" aria-labelledby="contact-tab"><h1>Report</h1></div>
  
 
  
  <div class="tab-pane tab_padd fade" id="tab7" role="tabpanel" aria-labelledby="contact-tab">
      <form id="prfile_form">
      <div class="settings">
          <h3>Edit Profile</h3>
          <div class="row">
              <div class="col-md-12" style="display:none;">
                  <div class="vendor_type">
                      <span>Vendor Type</span>
                      <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input radioCommapnyType" <?php echo $user_details->company_type==1?"checked":"" ?>  value="1">
                          <label class="custom-control-label" for="customRadioInline1">Company</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input radioCommapnyType" <?php echo $user_details->company_type==2?"checked":"" ?>  value="2">
                          <label class="custom-control-label" for="customRadioInline2">Freelancer</label>
                        </div>
                  </div>
              </div>
              <input type="hidden" value="<?=$user_details->company_type?>">
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
                            <label for="exampleFormControlInput1">Company Name </label>
                            <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" placeholder="Company Name" value="<?php echo $user_details->company_name ?>" maxlength="100">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Email address</label>
                            <input type="email" class="form-control" id="txt_email" placeholder="name@example.com" value="<?php echo $user_details->user_email ?>" readonly>
                          </div>
                      </div>
                       <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Country</label>
                            <select class="form-control"  id="select_country"  name="select_country">
                                    <option value="">Select Country</option>
                                    <?php
                                    if(count($country_list)>0)
                                    {
                                        foreach($country_list as $rows)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows->country_id ?>" data-foo="<?php echo $rows->country_dial_code; ?>"  <?php echo $user_details->country_id==$rows->country_id?'selected':'' ?>><?php  echo $rows->country_name ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </select>
                          </div>
                      </div>
                      
                      <div class="col-md-2">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Dial Code</label>
                            <input type="text" class="form-control" id="txt_dial_code" name="txt_dial_code" placeholder="Mobile Number" value="<?php echo $user_details->user_dial_code ?>" readonly>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Mobile Number</label>
                            <input type="text" class="form-control" id="txt_phone" name="txt_phone" placeholder="Mobile Number" value="<?php echo $user_details->user_phone ?>" maxlength="13">
                          </div>
                      </div>
                       <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">City</label>
                             <select class="form-control" id="select_city"  name="select_city">
                                    <option value="">Select City</option>
                                    <?php
                                    if($user_details->country_id>0)
                                    {
                                     $language  =   $this->session->userdata("language")>0? $this->session->userdata("language"):1;
                                     $cn['city_country_id'] = $user_details->country_id;
                                     $cn['city_status']     = 1;
                                     $cn['city_language_code']     = $language;
                                     $result    =   $this->M_common->getCities($cn);
                                   
                                   
                                    if(count($result)>0)
                                    {
                                        foreach($result as $rows)
                                        {
                                    ?>
                                            <option value="<?php  echo $rows->city_id ?>"   <?php echo $user_details->city_id==$rows->city_id?'selected':'' ?>><?php  echo $rows->city_name ?></option>
                                    <?php
                                        }
                                    }
                                    }
                                     
                                    ?>
                                    </select>
                          </div>
                      </div>
                      <?php
                        if($user_details->company_type==2)
                        {
                            ?>
                            <style>
                                .tradeLicenceSection
                                {
                                    display:none;
                                }
                            </style>
                        <?php    
                        }
                        ?>
                        
                        <!--<div class="col-md-6">-->
                        <!--  <div class="form-group">-->
                        <!--    <label for="exampleFormControlInput1">Area</label>-->
                        <!--    <select class="form-control" id="select_area"  name="select_area">-->
                        <!--        <option value="<?=$user_details->area_id?>" selected><?=$user_details->area_name?></option>-->
                        <!--    </select>-->
                            
                        <!--  </div>-->
                        <!--</div>-->
                      
                      <div class="col-md-6 tradeLicenceSection">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Trade License(Max Size 20 MB)</label>
                            <div class="trade_li">
                            <div class="custom-file trade_license">
                                <input type="file" class="custom-file-input" id="inputGroupFile02" name="txt_trade_lice">
                                <label class="custom-file-label upload_file_size" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02" id="labelUploadDoc"><?php echo $user_details->document_name;?></label>
                            </div>
                            <span class="doc_type">
                               <a target="_blank" href="<?php echo $user_details->document_name!=""?base_url()."uploads/user/".$user_details->document_name:""; ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/view-file.png" /></i><span><?php //echo $user_details->document_name;?></span></a>
                            </span></div>
                            <input type="hidden" name="doc_error">
                          </div>
                      </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Company Profile(Max Size 20 MB)</label>
                            <div class="trade_li">
                            <div class="custom-file trade_license">
                                <input type="file" class="custom-file-input" id="inputGroupFile05" name="txt_company_frofile">
                                <label class="custom-file-label" for="inputGroupFile05" aria-describedby="inputGroupFileAddon02" id="labelUploadCompProf"><?php echo $user_details->profile_document;?></label>
                            </div>
                            <?php if($user_details->profile_document!="")
                            {
                            ?>
                            <span class="doc_type">
                               <a target="_blank" href="<?php echo $user_details->profile_document!=""?base_url()."uploads/user/".$user_details->profile_document:""; ?>"><i><img src="<?php echo base_url();?>frontend_assets/images/icons/view-file.png" /></i><span><?php //echo $user_details->document_name;?></span></a>
                            </span>
                            <?php
                            }
                            ?>
                            </div>
                            <input type="hidden" name="doc_error">
                          </div>
                      </div>
                       <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Website url</label>
                            <input type="text" class="form-control" name="txt_web_url" placeholder="Website url" value="<?php echo $user_details->website_url ?>" >
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="profile_pic">
                        <label>Profile Photo(Max Size 20 MB)</label>
                        <div class="image_wrap">
                            <img src="<?php echo $user_details->user_image!=""?base_url()."uploads/user/".$user_details->user_image:base_url()."images/user_dummy.png"; ?>" id="profileImage" name="profile_error" />
<!--                            <span>Update Photo -->
                            <label class="Pic_upload" for="file">
                              <input type="file" class="upload" id="file" aria-label="File example">
                              <span class="file-custom">Update Photo </span>
                            </label>
<!--                            </span>-->
                        </div>
                        <input type="hidden" name="file">
                  </div>
              </div>
          </div>
          
        <div class="service_pro">
            <h4>Service Providing Areas</h4>
            <div class="row">
                <?php
                    foreach($provider_area as $value){
                ?>
                    <div class="col-md-3 updateService"><span class="selected" data-id="96"><?=$value->area_name?></span></div>
                <?php
                    }
                ?>
            </div>
        </div>
        
        <div class="service_pro">
            <h4>Services Providing</h4>
            <div class="row">
                
                <?php
                
$providerServiceType =  $provider_service_type->array_agg;
$providerServiceType=str_replace('{',"",$providerServiceType);
$providerServiceType=str_replace('}',"",$providerServiceType);
$providerServiceType=str_replace('"',"",$providerServiceType);
$providerArray = explode(",",$providerServiceType);
$providerArray =array_filter($providerArray);
                //$providerArray
              //  print_r($providerArray);
                ?>
                <?php
                if(count($service_type)>0)
                {
                    foreach($service_type as $rows)
                    {
                ?>
                    <div class="col-md-3 updateService"><span <?php echo in_array($rows->service_type_id,$providerArray)?'class="selected reselectService"':'class="reselectService"'?> data-id="<?php echo $rows->service_type_id;?>"><?php echo $rows->service_type_name; ?></span></div>
                <?php
                    }
                }
                ?>
                <input type="hidden" name="txt_service_type">
            </div>
          </div>
          <div class="location_wrap">
              <div class="form-group">
                            <label for="exampleFormControlInput1">Location</label>
                            <input type="text" class="form-control" id="pickup-input2" name="pickup-input2" placeholder="Location" value="<?php echo $user_details->location ?>">
                            <input type="hidden" class="form-control" id="pickup-lattitude2" name="pickup-lattitude2" placeholder="Type Your Location" value="<?php echo $user_details->lattitude ?>">
                            <input type="hidden" class="form-control" id="pickup-longittude2" name="pickup-longittude2" placeholder="Type Your Location" value="<?php echo $user_details->longitude ?>">
                          </div>
                          
                        <div id="map2" style="height: 250px;"></div>
          </div>
          
       
          <div class="action">
              <button type="button" class="btn btn-primary btn-lg" id="saveSettings">Save Changes</button>
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






<!-- Modal -->
<div class="modal fade Service_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Choose your Services and Location</h5>
<!--
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
-->
      </div>
      <div class="modal-body">
          <div class="service_pro">
              <label id="resultSpan" class="error"></label>
            <div class="row">
                <?php
           
                //$providerArray
                ?>
               <?php
                if(count($service_type)>0)
                {
                    foreach($service_type as $rows)
                    {
                ?>
                    <div class="col-md-3 primary_setting"><span class="setServiceType" data-id="<?php echo $rows->service_type_id; ?>"><?php echo $rows->service_type_name; ?></span></div>
                <?php
                    }
                }
                ?>
                 <span id="primaryServiceTypeError" class="error" style="background: #bb3632;border-color:#bb3632"></span>
            </div>
          </div>
          <div class="location_wrap">
              <div class="form-group">
                            <label for="exampleFormControlInput1">Your Location</label>
                            <input type="text" class="form-control" id="pickup-input" name="pickup-input" placeholder="Type Your Location" value="Al Karama, Dubai, UAE">
                            <input type="hidden" class="form-control" id="pickup-lattitude" name="pickup-lattitude" placeholder="Type Your Location" value="">
                            <input type="hidden" class="form-control" id="pickup-longittude" name="pickup-longittude" placeholder="Type Your Location" value="">
                            <span id="primaryLocationError" class="error"></span>
                          </div>
                          
                        <div id="map4" style="height: 250px;"></div>
                       
          </div>
                         <div class="col-md-12">
                             <div class="row btm-cover-panel">
                                 <button type="button" class="btn btn-primary btn-lg" id="btnPrimarySettings">Save Settings</button>
                             </div>
                            
                         </div>
      </div>
<!--
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
-->
    </div>
  </div>
</div>




<div class="modal fade show" id="packages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: none; padding-right: 16px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header min-packages">
        <h3 id="packages">packages</h3>
        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body modal-padd-none">
        <!--start row-->
        <div class="row">
            <div class="col-md-12 wrapper-lab">
                <?php if(count($packages)>0){
                foreach($packages as $rows)
                {
                
                ?>
                
               <label class="custom-control fill-checkbox">
			      <input type="checkbox" class="fill-control-input packagesCheckBox" value="<?php echo $rows->packages_id;  ?>" name="packages" <?php echo $user_details->package_id==$rows->packages_id?"checked":"" ?>>
			      <span class="fill-control-indicator"></span>
			      <span class="fill-control-description"><?php echo $this->session->userdata("language")==2 && $rows->packages_name_arabic!=""?$rows->packages_name_arabic:$rows->packages_name; ?></span>
		       </label>
		       <p><span></span> Participate in <?php echo $rows->packages_quotaion_limit;  ?> Quotations</p>
		       
		       
		       <hr>
		       <?php }
                }
		       ?>
		       
		       
               
		       
		       
		       <button class="upgrade" id="upgradePackage">Upgrade Now!</button>
            </div>
        </div>
        <!--end row-->
      </div>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade provider_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" id="detailDiv">
    
  </div>
</div>

 

<input type="hidden" id="tempItemId">
<input type="hidden" id="tempType" >
<input type="hidden" id="tempTypeFor">



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
  <?php 
  if(count($providerArray)<=0)
  {
  ?>
  $('#exampleModalCenter').modal({backdrop: 'static', keyboard: false})
  <?php
  }
  ?>
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
     
      
//      
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
     /* var map, infoWindow;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map3'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 6
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }
*/
      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
      
      
      
      
      

                         
                          
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
                                        url: '<?php echo base_url();?>website/Request/loadJobRequests',
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
                          var job_status =  $("#job_status").val();
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
      loadJobRequests();
      loadJobQuotations();
      loadRatings();
      initMap();
      loadJobReport();
      loadQutationReport();
});
     $(document).delegate("#jobOrder,#job_status,#from_date,#to_date","change",function(e)
     {
          loadJobRequests();
     });
     
     $("#jobSearch").on("keyup change", function(e) {
        loadJobRequests();
    })
     
    $(document).delegate("#btnSearch","click",function(e)
     {
          loadJobRequests();
     });
     
    function deleteStaff(staffId){
        swal({
          title: "Are you sure?",
          text: "Do you want to change the status ?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
               $.ajax({
                url: '<?php echo base_url();?>website/User/deleteUser',
                type: 'POST',
                data: {staff_id : staffId},
                success: function (data) {       
    			      
                    if(data){
                        swal("Staff deleted successfully");
                    }else{
                        swal("Failed to delete staff");
                    }
                }
            });
            }
        });
            
     }

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
             $.ajax({
                url: '<?php echo base_url();?>website/Request/changeStatus',
                type: 'POST',
                data: {itemId:itemId,action:action,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                success: function (data) 
    			  {       
    			      if(data>=1)
    			      {
    			          swal("status has been changed");
    			          loadJobRequests();
    			          loadJobQuotations();
    			          var lastViewed = sessionStorage.getItem("lastView");
                          $("#"+lastViewed).trigger("click");
                          sessionStorage.removeItem("lastView");
    			      }
    			     else if(data==-1)
    			      {
    			          swal("Job  already cancelled");
    			          loadJobRequests();
    			          loadJobQuotations();
    			      }
    			      else if(data==-2)
    			      {
    			          swal("Job  already confirmed");
    			          loadJobRequests();
    			          loadJobQuotations();
    			      }
    			       else if(data==-3)
    			      {
    			          swal("Job  already cancelled for the provider");
    			          loadJobRequests();
    			          loadJobQuotations();
    			      }
    			       else if(data==-4)
    			      {
    			          swal("Job  already confirmed for the provider");
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
            var typeFor        =   $(this).attr("for");
            
            $('#tempItemId').val(itemId);
            $('#tempType').val(type);
            $('#tempTypeFor').val(typeFor);
            
            viewDetails(itemId,type,typeFor);
          
      });
      
      
      function viewDetails(itemId,type,typeFor){
          
          sessionStorage.removeItem("lastView");
            sessionStorage.setItem("lastView", $(this).attr("id"));
            
            
           // alert(sessionStorage.getItem("lastView"));
            //return false;
           
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
                     initMap();    
                 }
            });

      }
      
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
                                        url: '<?php echo base_url();?>website/Request/loadJobQuotations',
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
                       
                          swal("Price Marked Successfully!");
                          var lastViewed = sessionStorage.getItem("lastView");
                          $("#"+lastViewed).trigger("click");
                          //sessionStorage.removeItem("lastView");
                          loadJobQuotations();   
                          $("#formMarkPrice")[0].reset();
                          $("#txt_price").val("");
                    }
                     else if(data['status']==-5)
    			      {
    			          swal("price already marked");
    			          loadJobQuotations();
    			          $("#formMarkPrice")[0].reset();
                          $("#txt_price").val("");
    			      }
                    else if(data['status']==-1)
    			      {
    			          swal("Job  already cancelled");
    			          loadJobQuotations();
    			          $("#formMarkPrice")[0].reset();
                          $("#txt_price").val("");
    			      }
    			      else if(data['status']==-2)
    			      {
    			          swal("Job  already confirmed");
    			          loadJobQuotations();
    			          $("#formMarkPrice")[0].reset();
                          $("#txt_price").val("");
    			      }
    			       else if(data['status']==-3)
    			      {
    			          swal("Job  already cancelled for the provider");
    			          loadJobQuotations();
    			          $("#formMarkPrice")[0].reset();
                          $("#txt_price").val("");
    			      }
    			       else if(data['status']==-4)
    			      {
    			          swal("Job  already confirmed for the provider");
    			          loadJobQuotations();
    			          $("#formMarkPrice")[0].reset();
                          $("#txt_price").val("");
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
   $(document).delegate("#inputGroupFile05","change",function(e)
     {
         fileName     = $('#inputGroupFile05').val();    
        // alert(fileName);
         $("#labelUploadCompProf").html(fileName);
 });      
 
 var map4 = null;
   function initMap() {
       
                             //alert();
                             var myLatLng = {lat: 25.2487086, lng: 55.3047496};
                             var lat = 25.0711436;
                              lng = 55.2440753;
                              $("#pickup-lattitude").val(lat);
                              $("#pickup-longittude").val(lng);
                             latlng = new google.maps.LatLng(lat, lng);
                             image = '<?php echo base_url();?>frontend_assets/images/icons/map_pin.png';
                             var map3 = new google.maps.Map(document.getElementById('map3'), {
                              zoom: 17,
                              disableDefaultUI: true,
                              center: myLatLng
                            });
                              
                             var map4 = new google.maps.Map(document.getElementById('map4'), {
                              center: new google.maps.LatLng(lat, lng),           
            zoom: 15,           
            disableDefaultUI: true,
            scaleControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP  
                            });  
                            
                            map2 = new google.maps.Map(document.getElementById('map2'), {
                              center: new google.maps.LatLng(lat, lng),           
            zoom: 15,           
            disableDefaultUI: true,
            scaleControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP  
                            });  
                            // Try HTML5 geolocation.
                           
                            marker = new google.maps.Marker({
            position: latlng,
            map: map4,
            draggable: true,
            animation: google.maps.Animation.DROP,
           // icon: image
         });   
          marker2 = new google.maps.Marker({
            position: latlng,
            map: map2,
            draggable: true,
            animation: google.maps.Animation.DROP,
           // icon: image
         });   
          var input = document.getElementById('pickup-input');    
          var input2 = document.getElementById('pickup-input2');    
        // alert(input);
            var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ["geocode"]
    });     
      var autocomplete2 = new google.maps.places.Autocomplete(input2, {
        types: ["geocode"]
    });     
    autocomplete.bindTo('bounds', map4);
    autocomplete2.bindTo('bounds', map2);
     var infowindow = new google.maps.InfoWindow(); 
     google.maps.event.addListener(autocomplete, 'place_changed', function() {
          //alert();
        infowindow.close();
        var place = autocomplete.getPlace();
        if (place.geometry.viewport) {
            map4.fitBounds(place.geometry.viewport);
        } else {
            map4.setCenter(place.geometry.location);
            
        }
        moveMarker(place.name, place.geometry.location);
        document.getElementById("pickup-longittude").value=place.geometry.location.lng();
	    document.getElementById("pickup-lattitude").value=place.geometry.location.lat();
    });
     google.maps.event.addListener(autocomplete2, 'place_changed', function() {
          //alert();
        infowindow.close();
        var place = autocomplete2.getPlace();
        if (place.geometry.viewport) {
            map2.fitBounds(place.geometry.viewport);
        } else {
            map2.setCenter(place.geometry.location);
            
        }
        moveMarker(place.name, place.geometry.location);
        document.getElementById("pickup-longittude2").value=place.geometry.location.lng();
	    document.getElementById("pickup-lattitude2").value=place.geometry.location.lat();
    });
      google.maps.event.addListener(marker, 'dragend', function() {
          //alert();
          var infowindow = new google.maps.InfoWindow(); 
    var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#pickup-input').val(results[0].formatted_address);
                   $('#pickup-lattitude').val(marker.getPosition().lat());
                    $('#pickup-longittude').val(marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
//                    infowindow.open(map, marker);
                    infoWindow.close();
                    map.setCenter(marker.getPosition());
                    ShowNext();
                }
            }
        });
    });
     google.maps.event.addListener(marker2, 'dragend', function() {
          //alert();
          var infowindow = new google.maps.InfoWindow(); 
    var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'latLng': marker2.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#pickup-input2').val(results[0].formatted_address);
                   $('#pickup-lattitude2').val(marker2.getPosition().lat());
                    $('#pickup-longittude2').val(marker2.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
//                    infowindow.open(map, marker);
                    infoWindow.close();
                    map.setCenter(marker2.getPosition());
                    ShowNext();
                }
            }
        });
    });
     function moveMarker(placeName, latlng){
        marker.setIcon(image);
       
     }
                           
                          }    
                          function loadRatings()
                          {
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: '<?php echo base_url();?>website/Request/loadRatings',
                                        type: 'POST',
                                        data: {'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			      //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#ratingDiv").html(data);
                                                loadRatingLoop();
                                                 
                                         }
                                    });
                          }
                            $("#ratingDiv").on("click", ".pagination a", function (e) 
            {
                
                         e.preventDefault();
                         csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: $(this).attr("href"),
                                        type: 'POST',
                                        data: {'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			      //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#ratingDiv").html(data);
                                                 loadRatingLoop();
                                         }
                                    });
                         
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
         swal("Please conatct Vhelp with your trade license to add or remove services");
         return false;
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
                                                        location.reload();
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
          }	,
          txt_company_name: 
          {
            required: true ,
            maxlength: 100
          }	,
           select_country: 
          {
            required: true,
            number:true
          },
          'select_city': 
          {
            required: true,
            number:true
          },
          txt_phone: 
          {
            required: true,
            maxlength: 12,
            number: true
          }	,
           "pickup-input2": 
          {
            required: true,
            maxlength: 500
          }	
          <?php if($user_details->document_name=="") 
          {
              ?>
          ,
          txt_trade_lice:
          {
              required: '#customRadioInline1:checked' 
          }
          <?php
          }
          ?>
        },
       
        messages: 
        {
       
         },
     submitHandler: function ()
        {
			
			  mappedItems =    $( ".updateService > .selected" ).map(function() {
    return $(this).attr("data-id");
              }).get().join();
              
            if(mappedItems=="")
            {
                
            }
            	profile_image = $('#file').get(0).files[0];
                trade_license = $('#inputGroupFile02').get(0).files[0];
               company_profile = $('#inputGroupFile05').get(0).files[0];
                var formData = new FormData($("#prfile_form")[0]);
                
                formData.append('mappedItems', mappedItems);
                formData.append("profile_image", profile_image);
                formData.append("trade_license", trade_license);
                formData.append("company_profile", company_profile);
                csrf_value  =   getCookie('csrf_cookie_name');  
                formData.append( "<?php echo $this->security->get_csrf_token_name();?>", csrf_value );
                
                     $.ajax({
             url: '<?php echo base_url();?>website/User/updateProviderProfile',
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
        text: 'Monthly Job request'
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

    }]
}); 

$('.packagesCheckBox').click(function () 
{
    
                 checkedState = $(this).attr('checked');
                  $('.packagesCheckBox').each(function () 
                  {
                      $(this).prop('checked', false);
                  });
                  $(this).prop('checked', "checked");
});
 $(document).delegate("#upgradePackage","click",function(e)
{
    
    current_package_id   = $(".packagesCheckBox:checked").val();
    
    //alert(current_package_id);
                csrf_value                 =   getCookie('csrf_cookie_name');   
                
                                         $.ajax({
                                        url:'<?php echo base_url();?>website/User/upgradePackage',
                                        type: 'POST',
                                        data: {current_package_id:current_package_id,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {
                            			       $("#packages").modal("hide");
                            			       if(data==1)
                            			       {
                            			           swal("Packages has been upgraded");
                            			       }
                            			       else
                            			       {
                            			            swal("Cannot upgrade packages");
                            			       }
                                          }
                                    });
        
 });
$(document).delegate(".radioCommapnyType","click",function(e)
     {
     
         if($(this).val()==2)
         {
             $(".tradeLicenceSection").css("display","none");
         }
         else
         {
             $(".tradeLicenceSection").css("display","block");
         }
        
       
     });
     
     
     $(document).delegate('#pending_job','click',function(){
        $('#job_status').val('pending').attr("selected", "selected");
        $('#job-tab').trigger("click");
     });
     
     $(document).delegate('#completed_job','click',function(){
        $('#job_status').val('completed').attr("selected", "selected");
        $('#job-tab').trigger("click");
     });
     
     $(document).delegate('#confirmed','click',function(){
        $('#job_status').val('confirmed').attr("selected", "selected");
        $('#job-tab').trigger("click");
     });
     
     $(document).delegate('#ongoing','click',function(){
        $('#job_status').val('ongoing').attr("selected", "selected");
        $('#job-tab').trigger("click");
     });
     
     $(document).delegate('#staff_assigned','click',function(){
        $('#job_status').val('staff_assigned').attr("selected", "selected");
        $('#job-tab').trigger("click");
     });
     
     
     
     $(document).delegate("#job-tab","click",function(e)
     {
          sessionStorage.removeItem("lastView");
          loadJobRequests();
     });
      $(document).delegate("#quto-tab","click",function(e)
     {    sessionStorage.removeItem("lastView");
          loadJobQuotations();
     });
     $(document).delegate("#select_country","change",function(e)
    {
	
         var selected = $(this).find('option:selected');
         var dialCode = '+'+selected.data('foo'); 
          $("#txt_dial_code").val(dialCode);
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
  
            $(document).ready(function(){
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
     $("#from_date_q_report").datepicker({
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        //minDate: 0,
        onSelect: function(selected) {
          $("#to_date_q_report").datepicker("option","minDate", selected);
          loadJobQuotations();
        }
    });
    $("#to_date_q_report").datepicker({ 
        numberOfMonths: 1,
         dateFormat: "yy-mm-dd",
        onSelect: function(selected) {
           $("#from_date_q").datepicker("option","maxDate", selected),
           loadJobQuotations();
        }
    });  
     $("#from_date_qu_report").datepicker({
        numberOfMonths: 1,
        dateFormat: "yy-mm-dd",
        //minDate: 0,
        onSelect: function(selected) {
          $("#to_date_q_report").datepicker("option","minDate", selected);
          loadJobQuotations();
        }
    });
    $("#to_date_qu_report").datepicker({ 
        numberOfMonths: 1,
         dateFormat: "yy-mm-dd",
        onSelect: function(selected) {
           $("#from_date_q").datepicker("option","maxDate", selected),
           loadJobQuotations();
        }
    });  
});
 function getProviderDetails(providerId)
     {
              csrf_value                 =   getCookie('csrf_cookie_name');    
      
         
          $.ajax({
            url: '<?php echo base_url();?>website/Request/getProviderDetails',
            type: 'POST',
            data: {providerId:providerId,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
            success: function (data) 
			  {           
                  $("#exampleModalCenter").modal("show");
                  $("#detailDiv").html(data);
                  loadRating();
                  loadRatingLoop();
             }
        });
     }
     
    $('#eq_report-tab').click(function(){
        loadJobReport();
    });
     
     function loadJobReport()
     {
                                      // alert();
                                      //var jobOrder  = $("#jobOrder").val();
                                      //var jobSearch = $("#jobSearch").val();
                                      // var job_status = $("#job_status").val();
                                      var from_date = $("#from_date_q_report").val();
                                      var to_date   = $("#to_date_q_report").val();
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: '<?php echo base_url();?>website/Request/loadJobRequestsReport',
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			        //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#eqReport").html(data);
                                                // initMap();
                                         }
                                    });
     }
    $(document).delegate("#jobReportSearch","click",function(e)
     {
      
     loadJobReport();
     });
     
      $("#eqReport").on("click", ".pagination a", function (e) 
            {
                
                          e.preventDefault();
                          csrf_value                 =   getCookie('csrf_cookie_name');   
                          var from_date = $("#from_date_q_report").val();
                          var to_date   = $("#to_date_q_report").val();
                                         $.ajax({
                                        url: $(this).attr("href"),
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			         //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                 $("#eqReport").html(data);
                                                // loadRatingLoop();
                                         }
                                    });
                         
            });
    $(document).delegate(".exportJobReport","click",function(e)
     {
      
     var from_date = $("#from_date_q_report").val();
     var to_date   = $("#to_date_q_report").val();
      window.location="<?php echo base_url() ?>website/Request/printJobReport?fd="+from_date+"&td="+to_date+"";
      
     }); 
     
     function loadQutationReport()
     {
                                      // alert();
                                      //var jobOrder  = $("#jobOrder").val();
                                      //var jobSearch = $("#jobSearch").val();
                                      // var job_status = $("#job_status").val();
                                      var from_date = $("#from_date_qu_report").val();
                                      var to_date   = $("#to_date_qu_report").val();
                                       csrf_value                 =   getCookie('csrf_cookie_name');   
                                         $.ajax({
                                        url: '<?php echo base_url();?>website/Request/loadQuotationRequestsReport',
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			        //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                $("#quotReport").html(data);
                                                // initMap();
                                         }
                                    });
     }
    $(document).delegate("#quoReportSearch","click",function(e)
     {
      
     loadQutationReport();
     });
     
      $("#quotReport").on("click", ".pagination a", function (e) 
            {
                
                          e.preventDefault();
                          csrf_value                 =   getCookie('csrf_cookie_name');   
                          var from_date = $("#from_date_qu_report").val();
                          var to_date   = $("#to_date_qu_report").val();
                                         $.ajax({
                                        url: $(this).attr("href"),
                                        type: 'POST',
                                        data: {from_date:from_date,to_date:to_date,'<?php echo $this->security->get_csrf_token_name();?>':csrf_value},
                                        success: function (data) 
                            			  {       
                            			         //  alert(data);
                                                // data =  jQuery.parseJSON(data);
                                                 $("#quotReport").html(data);
                                                // loadRatingLoop();
                                         }
                                    });
                         
            });
    $(document).delegate(".exportQuotReport","click",function(e)
     {
      
     var from_date = $("#from_date_qu_report").val();
     var to_date   = $("#to_date_qu_report").val();
      window.location="<?php echo base_url() ?>website/Request/printQuotReport?fd="+from_date+"&td="+to_date+"";
      
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
          }	,
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
   function moveMarkerDetails(markerName, latlng) 
            {
                infowindow = null;
                markerName.setIcon(null);
                markerName.setPosition(latlng);
                // infowindow.setContent(placeName);
           }
    
    
    $(document).delegate("#staff","click",function(e){    
      sessionStorage.removeItem("lastView");
      loadStaffList();   
    });
    
    function addEditForm(id){
    // alert(id);
    $('#staff_list').hide();
    $.ajax({
      url : '<?=base_url()?>website/Request/getAddEditForm',
      type: 'POST',
      data:{id:id},  
      success: function(data){
        $('#addStaff').html(data);
        $('#addStaff').show();
      },
    });
  }

  function loadStaffList(){
    $.ajax({
      url : '<?=base_url()?>website/Request/getStaffList',
      type: 'POST',
      data:{},  
      success: function(data){
        $('#staffList').html(data);
      },
    });
  }

  $("#staffList").on("click", ".pagination a", function (e) {
    e.preventDefault();
    $.ajax({
      url : $(this).attr("href"),
      type: 'POST',
      data:{},  
      success: function(data){
        $('#staffList').html(data);
      },
    });
  });
       
  $('#home-tab').click(function(){
     location.reload();
  });
</script>
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI&callback=initMap"></script>-->

<!--<script src="https://maps.google.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI&libraries=places&language=en&sensor=false"></script>-->

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCHFZ49O5XuPD9RR-s0grdzBoV4wAZxJB8&v=weekly&libraries=places&callback=initMap" async defer></script>
  </body>
</html>