<style>
  label.error {
    color: #fff !important;
    margin: -5px 15px;
    position: absolute;
    font-size: 10px;

  }

.cmt-row.procedure-section {
    display:none;
}
/*.cmt-row.portfolio_row-section{*/
/*    padding:45px 0;*/
/*}*/
  .search-choice {
    width: auto !important;
  }

  .btn-group.multi {
    width: 100%
    display: block;
  }

  .multiselect {
    background: #fff !important;
    color: #000 !important;
  }

  .multiselect-container {
    height: 150px;
    overflow-y: scroll;
  }

  .multiselect-container>li {
    padding: 0 !important;
    margin: 0 !important;
  }

  .multiselect-container>li>a>label {
    padding: 3px 10px 3px 10px !important;
    color: #000;
    display: inline-flex;
  }

  .multiselect-container>li>a>label>input[type=checkbox] {
    /*// margin-bottom: -1px !important;*/
    width: auto;
    padding: 0px;
    height: auto;
    /*// margin-right: 5px;*/
    margin: 5px;
  }

  .dropdown-toggle.crettt::after {
    float: right;
    vertical-align: middle;
    margin-top: 20px;
  }

  .btn-group {
    width: 100%;
  }

  .multiselect-container>li>a {
    text-decoration: none;
  }
</style>
<!--start banner section-->
<section>
  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="vendor_banner row">

      <div class="col-md-8 vendor-min-texts">
        <h3>It’s time to grow your business.</h3>
        <h5>Join a community of professionals and reach out to customers instantly.</h5>
      </div>
      <!--start vendor form-->
      <div class="vendor_form col-md-4 vendor_form_controller_media_one">
        <h3>Register as Vendor</h3>
        <form id="providerForm" enctype="multipart/form-data" autocomplete="off" method="post">
          <ul>
            <!--<div class="custom-control allredy_have">-->
            <!--  <label for="Company">-->
            <!--    <input class="select_radiobtn" type="radio" id="company_type1" name="company_type" checked="checked" value="1" class="form-control" id="Company">Company &nbsp; &nbsp; &nbsp; </label>-->
            <!--  <label for="Freelancer">-->
            <!--    <input class="select_radiobtn" type="radio" name="company_type" class="form-control" value="2" id="Freelancer">Freelancer &nbsp;</label>-->
            <!--</div>-->
            <input type="hidden" name ="company_type" value="1">
            <li class="form-group">
              <input type="text" class="form-control" maxlength="100" id="txt_company_name" name="txt_company_name" placeholder="Company Name">
            </li>

            <li class="form-group">
              <input type="text" class="form-control" maxlength="100" id="txt_first_name" name="txt_first_name" placeholder="First Name">
            </li>

            <li class="form-group">
              <input type="text" class="form-control" maxlength="100" id="txt_last_name" name="txt_last_name" placeholder="Last Name">
            </li>

            <li class="form-group">
              <input type="email" class="form-control" maxlength="100" id="txt_email" name="txt_email" placeholder="Email Address">
            </li>
            <li class="form-group password-eye-wrapper">
              <input type="password" class="form-control" id="txt_password" name="txt_password" placeholder="Password" maxlength="20">
              <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
            </li>
            
            
            
            
            <li class="form-group">
              <select class="form-control" id="select_country" name="select_country">
                <option value="">Select Country</option>
                <?php
                if (count($country_list) > 0) {
                  foreach ($country_list as $rows) {
                ?>
                    <option value="<?php echo $rows->country_id ?>" data-foo="<?php echo $rows->country_dial_code; ?>" <?php echo $row->country_id == $rows->country_id ? 'selected' : '' ?>><?php echo $rows->country_name ?></option>
                <?php
                  }
                }
                ?>

              </select>
            </li>
            <li class="form-group nuber-text">
              <select class="form-control" id="select_city" name="select_city">
                <option value="">Select City</option>
              </select>
            </li>

            <li class="form-group nuber-text">
              <input type="text" class="form-control" maxlength="5" name="txt_dial" id="txt_dial_code" readonly placeholder="Dial code" style="width:30%;float: left;border-radius: 50px 0 0 50px;">
              <input type="number" class="form-control" maxlength="15" id="txt_phone" name="txt_phone" placeholder="Mobile Phone" style="width:70%;border-radius: 0px 50px 50px 0px;">
            </li>
            <!-- <li class="form-group">-->
            <!--  <input type="text" class="form-control" id="txt_service" name="txt_service" placeholder="Choose a Service" data-toggle="modal" data-target="#Services_modal">-->
            <!--</li>-->
            <!--<span id="errNm5" class="error"></span>-->
            
            <li class="form-group comboTreeSelection">
            <input type="text" id="justAnInputBox1" placeholder="Choose a Service" value="" autocomplete="off"/>
            <input type="hidden" id="txt_service" name="txt_service">
            </li>
            <!--<span id="errNm5" class="error"></span>-->

            <li class="form-group">
              <input type="text" class="form-control" id="txt_area" name="txt_area" placeholder="Choose a area" data-toggle="modal" data-target="#area_modal">
            </li>
            <span id="errNm5" class="error"></span>
            

            <input type="hidden" id="select_document_type" name="select_document_type" value="1">
            <input type="hidden" id="txt_doc_no" name="txt_doc_no" value="1">

            <li id="liFileUpload">
              <div class="custom-upload">
                <div class="file-upload">
                  <div class="file-select">
                    <div class="file-select-button" id="fileName">Upload</div>
                    <div class="file-select-name" id="noFile">Trade License</div>
                    <input type="file" id="txt_doc" name="txt_doc" data-error="#errNm4">

                  </div>
                </div>
                <span id="errNm4"></span>
              </div>
            </li>


            <li class="form-group">
              <div class="ml-5 mr-5 cmt-bgcolor-skincolor">
                <button id="btnRegisterProvider" class="submit cmt-btn cmt-btn-size-md  cmt-btn-shape-round cmt-btn-style-fill cmt-btn-color-dark w-100" type="submit" id="appoinmentBtn">Submit Your Request <span id="registerLoader2"></span></button>
              </div>

            </li>
            <li class="allredy_have">
              Already have an account ? <a href="<?=base_url()?>vendor-login">Log in to continue </a>
            </li>

          </ul>
        </form>

      </div>



      <!-- Choose Services Modal -->
      <div class="modal fade services_modal" id="Services_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><img src="<?php echo base_url(); ?>frontend_assets/images/logo/logo.png" alt="" class="logo"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body service_pannel">
              <h3>Choose Services</h3>
              <div class="search_wrap">
                <div class="form-group">
                  <span class="icon"><i class="fa fa-search"></i></span>
                  <input type="text" class="form-control" id="txt_search_services" placeholder="Search Services..." onkeyup="loadRegistrationServiceType();">
                </div>
              </div>
              <ul class="Services_list" id="reg_service_type">

              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <!-- <button type="button" class="btn btn-submit">Submit</button>-->
            </div>

          </div>
        </div>
      </div>


    </div>

    <div class="modal fade area_modal" id="area_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><img src="<?php echo base_url(); ?>frontend_assets/images/logo/logo.png" alt="" class="logo"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body service_pannel">
              <h3>Choose area</h3>
              <div class="search_wrap">
                <div class="form-group">
                  <span class="icon"><i class="fa fa-search"></i></span>
                  <input type="text" class="form-control" id="txt_search_area" placeholder="Search area..." onkeyup="loadArea();">
                </div>
              </div>
              <ul class="area_list Services_list" id="area_list">

              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <!-- <button type="button" class="btn btn-submit">Submit</button>-->
            </div>

          </div>
        </div>
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
      <!--start container-->
      <div class="container">
        <!--start row-->
        <div class="row min_form">



          <!--start vendor form-->

          <!--end vendor form-->





        </div>
        <!--end row-->
      </div>
      <!--end container-->
    </div>
    <!--end row-->
  </div>
  <!--end container fluid-->
</section>
<!--end section-->


<section>

  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="row">


      <!--start vendor form-->
      <!-- <div class="vendor_form-mobile col-md-12 vendor-m-display" style="height:auto;">
            <h3>Become a vendor</h3>
            <form id="providerForm" enctype="multipart/form-data" autocomplete="off" method="post">
               <ul>
        <div class="custom-control allredy_have">
                <label for="Company">
           <input class="select_radiobtn-1" type="radio" name="company_type" checked="checked" value="1" class="form-control" id="Company">Company &nbsp; &nbsp; &nbsp;  </label>

                <label for="Freelancer">
           <input class="select_radiobtn-1" type="radio" name="company_type" class="form-control" value="2" id="Freelancer">Freelancer &nbsp;</label>
               </div>
      
                <li class="form-group">
                    <input type="text" class="form-control"  maxlength="100" id="txt_company_name"  name="txt_company_name"  placeholder="Company Name">
                </li>
                
                <li class="form-group">
                    <input type="text" class="form-control" maxlength="100" id="txt_first_name"  name="txt_first_name"  placeholder="First Name">
                </li>                
                
                <li class="form-group">
                    <input type="text" class="form-control"  maxlength="100" id="txt_last_name"  name="txt_last_name" placeholder="Last Name">
                </li>
                
                <li class="form-group">
                    <input type="email" class="form-control" maxlength="100" id="txt_email" name="txt_email"  placeholder="Email Address">
                </li>  
                <li class="form-group">
                    <input type="password" class="form-control" id="txt_password" name="txt_password" placeholder="Password" maxlength="20">
                </li>
                <li class="form-group">
                   <select class="form-control"  id="select_country"  name="select_country">
                                    <option value="">Select Country</option>
                                    <?php
                                    if (count($country_list) > 0) {
                                      foreach ($country_list as $rows) {
                                    ?>
                                            <option value="<?php echo $rows->country_id ?>" data-foo="<?php echo $rows->country_dial_code; ?>"  <?php echo $row->country_id == $rows->country_id ? 'selected' : '' ?>><?php echo $rows->country_name ?></option>
                                    <?php
                                      }
                                    }
                                    ?>
                                    
                                </select>
                </li>
                 <li class="form-group nuber-text" >
                     <select class="form-control" id="select_city"  name="select_city">
                                    <option value="">Select City</option>
                     </select>
                </li>
                <li class="form-group nuber-text">
                        <input type="number" value="971" class="form-control" maxlength="5"  name="txt_dial" readonly  placeholder="Dial code" style="width:26%;float: left;border-radius: 5px 0 0 5px;" >
                    <input type="number" class="form-control" maxlength="15"  id="txt_phone" name="txt_phone"  placeholder="Mobile Phone" style="width:74%;border-radius: 0px 5px 5px 0px;">
                </li>
                
                <input type="hidden"    name="select_document_type" value="1">
                <input type="hidden"     name="txt_doc_no" value="1"> 
<li id="liFileUpload">
<div class="custom-upload">
<div class="file-upload">
  <div class="file-select">
    <div class="file-select-button" id="fileName">Upload</div>
    <div class="file-select-name" id="noFile">Trade License</div> 
    <input type="file"  id="txt_doc" name="txt_doc"> 
  </div>
</div> 
</div> 
</li>
                
                
                <li class="form-group">
                    <button  id="btnRegisterProvider" type="button">Start Registration</button>
                </li>                  
                <li class="allredy_have">
                  Already have an account ? <a href="#" data-toggle="modal" data-target="#exampleModal">Log in to continue </a> 
                </li>
                
            </ul> 
            </form>
            
        </div> -->

    </div>
    <!--end row-->


  </div>
  <!--end container fluid-->




</section>
<!--start section-->
<section style="display: none;">
  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="row main">
      <h3>Expand your business with us</h3>
      <!--start container-->
      <div class="container">
        <!--start row-->
        <div class="row">
          <!--start col md 4-->
          <div class="col-md-4 vendor_pannel">
            <img src="<?php echo base_url(); ?>frontend_assets/images/icons/vendor1.png" />
            <h4>Get instant access to real leads</h4>
            <p>
              Now, manage your leads pipeline at a single place.
              Get numerous service requests instantly.
              Get hired.
            </p>

          </div>
          <!--end col md 4-->


          <!--start col md 4-->
          <div class="col-md-4 vendor_pannel">
            <img src="<?php echo base_url(); ?>frontend_assets/images/icons/vendor2.png" />
            <h4>Get connected to customers quickly</h4>
            <p>
              Give your business the boost it deserves.
              Get connected with millions of customers immediately.
              Over a million verified customer requests awaits you.
            </p>

          </div>
          <!--end col md 4-->


          <!--start col md 4-->
          <div class="col-md-4 vendor_pannel">
            <img src="<?php echo base_url(); ?>frontend_assets/images/icons/vendor3.png" />
            <h4>Build online presence for your business</h4>
            <p>
              Keep your web presence and online profile up-to-date.
              Chat with customers, display your professional details.
              Get hired.
            </p>

          </div>
          <!--end col md 4-->



        </div>
        <!--end row-->
      </div>
      <!--end container-->
    </div>
    <!--end row-->
  </div>
  <!--end container fluid-->
</section>
<!--end section-->








<!--start section-->
<?php $this->load->view('how_is_it_work'); ?>

<!--end section-->

<?php
$language                                  = $this->session->userdata("language") > 0 ? $this->session->userdata("language") : 1;
$con3['testimonial_status']  = 1;
$con2['service_type_status']                                   =  1;
$con2['service_type_language_code']                  =  $language;
$popular_cate                                                            =   $this->M_common->getServiceTypes($con2);
$testimonial                                                                =   $this->M_common->getTestimonials($con3);
?>

<?php /*
<!--sgtart section-->
<section>
    <!--start container fluid-->
    <div class="container-fluid min_services popular_service">
        <!--start row-->
        <div class="row main">
            <h3>Popular Services </h3>
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row padd-left">
          <div id="owl-example" class="owl-carousel row">
              
              
              <?php
                        if(count($popular_cate) > 0)
                        {
                            foreach ($popular_cate as $rows)
                                    
                        {
                                $image = ($rows->service_type_thumbnail!=""? base_url()."uploads/service_type/".$rows->service_type_thumbnail:"");
                                $urlCategoryName  =  $rows->service_type_name;
                                $string = str_replace(' ', '-', $urlCategoryName); 
                                $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                                $urlCategoryName  = strtolower($urlCategoryName);
                        ?>
                        <div class=" custom_mrgn">
               <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($rows->service_type_id); ?>">
                <div class="col-md-12 fff custom content-drop">
                    <div class="min-cover">
                        <div class="title-cover"><h4><?php  echo $rows->service_type_name;?></h4></div>
                    
                    <img src="<?php echo$image;?>"/>
                    </div>
                </div></a>
              </div>
              
              <?php
                        }
                        }
                        ?>
              
              
</div>

<a href="<?php echo base_url()?>services_list" class="cmt-btn cmt-btn-size-md cmt-btn-shape-round cmt-btn-style-fill cmt-icon-btn-right cmt-btn-color-dark">More Services</a>
                </div>
                <!--end row-->
                
         
            </div>
            <!--end container-->
        </div>
        <!--end row-->
        
    </div>
    <!--end container fluid-->
</section>
<!--end section-->

*/ ?>


<!-- portfolio_row-section end -->
<section class="cmt-row portfolio_row-section clearfix">
  <div class="container-fluid p-0">
    <div class="row cmt-boxes-spacing-5px slick_slider ml_10 mr_10" data-slick='{"slidesToShow": 5, "slidesToScroll": 5, "arrows":false, "autoplay":false, "infinite":true}'>
      <?php
      if (count($popular_cate) > 0) {
        foreach ($popular_cate as $rows) {
          $image = ($rows->service_type_banner_image != "" ? base_url() . "uploads/service_type/" . $rows->service_type_banner_image : "");
          $urlCategoryName  =  $rows->service_type_name;
          $string = str_replace(' ', '-', $urlCategoryName);
          $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
          $urlCategoryName  = strtolower($urlCategoryName);
          $desc = $rows->service_type_desc;
          $desc = strlen($desc) > 20 ? substr($desc, 0, 20) . '...' : ''

      ?>
          <div class="cmt-box-col-wrapper col-lg-4 col-md-4 col-sm-6">
            <!-- featured-imagebox -->
            <div class="featured-imagebox featured-imagebox-portfolio style1">
              <!-- cmt-box-view-overlay -->
              <div class="cmt-box-view-overlay">
                <!-- featured-thumbnail -->
                <div class="featured-thumbnail">
                  <a href="<?php echo base_url(); ?>request/<?php echo $urlCategoryName; ?>?sid=<?php echo $this->common_functions->encryptId($rows->service_type_id); ?>">
                    <img class="img-fluid" src="<?= $image; ?>" alt="image">
                  </a>
                </div><!-- featured-thumbnail end-->
                <div class="featured-content">
                  <div class="featured-desc">
                    <!-- <p><?= $desc; ?></p> -->
                  </div>
                  <div class="featured-title">
                    <h5><a href="<?php echo base_url(); ?>request/<?php echo $urlCategoryName; ?>?sid=<?php echo $this->common_functions->encryptId($rows->service_type_id); ?>"><?= $rows->service_type_name; ?></a></h5>
                  </div>
                  <a class="cmt-btn cmt-btn-size-sm cmt-btn-shape-round cmt-btn-style-fill cmt-btn-color-skincolor" href="<?php echo base_url(); ?>request/<?php echo $urlCategoryName; ?>?sid=<?php echo $this->common_functions->encryptId($rows->service_type_id); ?>">Read More</a>
                </div>
              </div><!-- cmt-box-view-overlay end-->
            </div><!-- featured-imagebox -->
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="pt-35 pb-40 res-991-pb-15">
          <!-- section title -->
          <div class="section-title d-lg-flex">
            <div class="title-header w-100">
              <h2 class="title">Stay Safe Stay Home</h2>
              <p>Service Professionals in your doorsteps</p>
            </div>
            <div class="title-desc w-100 pl-50 res-991-pl-0">
              <p>VHELP provides a platform that allows skilled and experienced professionals to connect with users looking for specific services.</p>
            </div>
          </div>
          <!-- section title end -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- portfolio_row-section end -->













<!--start section-->
<section class="light-bg-for-services" style="display: none;">
  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="row main">
      <h3 class="padd-controler">What Vendor Say About Us</h3>
      <!--start container-->
      <div class="container">
        <!--start row-->
        <div class="row padd-left">
          <div id="owl-example3" class="owl-carousel row">
            <?php
            if (count($testimonial) > 0) {
              foreach ($testimonial as $rows) {
                $image = ($rows->profile_image != "" ? base_url() . "uploads/user/" . $rows->profile_image : "");

            ?>
                <div class=" custom_mrgn">
                  <div class="col-md-12 fff custom">
                    <div class="wrapper_fluid">
                      <aside><img src="<?php echo $image; ?>" /></aside>
                      <p>
                        <?php echo $rows->testimonial_arabic != "" && $this->session->userdata("language") == 2 ? $rows->testimonial_arabic : $rows->testimonial ?>
                      </p>
                      <div class="bottom_underline">
                        <aside></aside>
                      </div>

                      <h4><?php echo $rows->first_name . " " . $rows->last_name ?></h4>
                      <h5><?php echo $rows->designation_arabic != "" && $this->session->userdata("language") == 2 ? $rows->designation_arabic : $rows->designation ?></h5>
                    </div>

                  </div>
                </div>
            <?php
              }
            }
            ?>


          </div>
        </div>
        <!--end row-->
      </div>
      <!--end container-->
    </div>
    <!--end row-->
  </div>
  <!--end container fluid-->
</section>
<!--end section-->

<script>

    



  $(function() {


    loadRegistrationServiceType();
    loadArea();
    jQuery.validator.addMethod("checkServiceType", function(value, element) {

      var count = $(".serviceChkBox:checked").length;

      if (count <= 0) {
        return false;
      } else {
        return true;
      };


    }, "This field is required");

    
    jQuery.validator.addMethod("checkArea", function(value, element) {

      var count = $(".areaChkBox:checked").length;

      if (count <= 0) {
        return false;
      } else {
        return true;
      };


    }, "This field is required");    

  });
  $(document).delegate("#btnRegisterProvider", "click", function(e) {
    // $("#errNm5").html("");
    var count = $(".serviceChkBox:checked").length;

    if (count <= 0) {
      //$("#errNm5").html("This field is required.");
      //return false;
    }
    $("#providerForm").submit();
  });
  var validator = $("#providerForm").validate(
    //  alert();
    {

      ignore: [],
      rules: {

        txt_first_name: {
          required: true,
          maxlength: 100,
          lettersonly: true,

        },
        txt_last_name: {
          required: true,
          maxlength: 100,
          lettersonly: true,
        },
        txt_company_name: {
          required: true,
          maxlength: 200,
          specialChars: true,
        },
        txt_location: {
          required: true,
          maxlength: 1000
        },
        txt_email: {
          required: true,
          email: true,
          maxlength: 100,
        },

        select_country: {
          required: true,
          number: true
        },
        txt_password: {
          required: true,
          minlength: 8,
          maxlength: 20,
          passwordCheck: true
        },
        'select_city': {
          required: true,
          number: true
        },
        'txt_phone': {
          required: true,
          minlength: 5,
          maxlength: 10,
          number: true
        },
        'select_document_type': {
          required: true,
          number: true
        },
        'txt_doc_no': {
          required: true,
          maxlength: 100,
          specialChars: true,
        },
        'txt_service': {
        //   checkServiceType: true,
            required: true,
        },
        'txt_area' : {
          checkArea : true,
        },

        txt_doc: {
          required: true,//'#company_type1:checked'
        }


      },
      messages: {

      },
      errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function() {
        $("#errNm5").html("");
        // var count = $(".serviceChkBox:checked").length;

        // if (count <= 0) {
        //   $("#errNm5").html("<p style='color:#fff'> select any services<p>");
        //   return false;
        // }

        $(".errorSpan1").html("");
        $("#btnRegisterProvider").attr("disabled", "disabled");
        $("#registerLoader2").html("<img src='<?php echo base_url(); ?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
        $(".errorSpan1").html();
        dataString = $('#providerForm').serialize();
        var formData = new FormData($("#providerForm")[0]);
        csrf_value = getCookie('csrf_cookie_name');
        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', csrf_value);

        mappedItems = $(".serviceChkBox:checked").map(function() {
          return $(this).val();
        }).get().join();

        mappedAreaItems = $(".areaChkBox:checked").map(function() {
          return $(this).val();
        }).get().join();

        formData.append('mappedItems', mappedItems);
        formData.append('mappedAreaItems',mappedAreaItems);

        $.ajax({
          url: '<?php echo base_url(); ?>website/User/saveProvider',
          type: 'POST',
          data: formData,
          async: true,
          success: function(data) {

            $("#registerLoader2").html("");
            $('#btnRegisterProvider').prop("disabled", false);
            data = jQuery.parseJSON(data);
            // console.log(data['status']);


            if (data['status'] == 1) {
              $("#providerForm")[0].reset();
              swal("Your registration has been completed successfully");
              $("#noFile").html("");
              $(".serviceChkBox").prop("checked", false);

            } else if (data['status'] == 3) {
              swal("Sorry!", "Email id already exists", "error");
            } else if (data['status'] == 0) {
              if (data['errors'] !== "") {
                $.each(data['errors'], function(key, value) {
                  $('<span class="error errorSpan1">' + value + '</span>').insertAfter('[name="' + key + '"]');
                });
              } else {
                swal("Sorry!", "Failed to register! Try again later", "error");
              }


            } else {

              swal("Sorry!", "Failed to register! Try again later", "error");


            }



          },
          cache: false,
          contentType: false,
          processData: false
        });

        return false;


      }

    });
  $(document).delegate("#select_country", "change", function(e) {

    var selected = $(this).find('option:selected');  
    var dialCode = selected.data('foo');
    csrf_value = getCookie('csrf_cookie_name');
    var countryid = $(this).val();

    // alert(dialCode);
    if(countryid > 0 ){
        
        $("#txt_dial_code").val('+'+dialCode);
        
        $.ajax({
          url: '<?php echo base_url(); ?>admin/C_admin/loadCityDropDown',
          type: 'POST',
          data: {
            countryId: countryid,
            '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_value
          },
          success: function(data) {
    
            $("#select_city").html(data);
    
          }
        });
  }else{
    $("#txt_dial_code").val('');
  }

  });
  $(document).delegate("#txt_doc", "change", function(e) {
    var fileName = e.target.files[0].name;
    //alert(fileName);
    //return false;
    ////fileName     = $(this).val();   
    fileName = fileName.replace(/[\x00-\x1F\x7F-\x9F]/g, "");
    // console.log(fileName);
    //fileNme = fileName.split("\");
    ///alert(fileNme);
    // alert(fileName.replace(/[^a-zA-Z ]/g, ""));
    if (fileName != "") {
      $("#noFile").text(fileName);
      document.getElementById("noFile").innerHTML = fileName;
    } else {
      $("#noFile").html("temp_path");
    }
  });

  $(document).delegate(".select_radiobtn", "click", function(e) {
    $('label.error').html('');
    $('label.error').remove();
    if ($(this).val() == 2) {
      $("#liFileUpload").css("display", "none");
    } else {
      $("#liFileUpload").css("display", "block");
    }


  });
  //   $(document).delegate(".select_radiobtn-1","click",function(e)
  //  {
  //     $('label.error').html('');
  //      $('label.error').remove();
  //      if($(this).val()==2)
  //      {
  //          $("#liFileUpload").css("display","none");
  //      }
  //      else
  //      {
  //          $("#liFileUpload").css("display","block");
  //      }


  //  });

  function loadRegistrationServiceType() {
    txt_search_services = $("#txt_search_services").val();
    csrf_value = getCookie('csrf_cookie_name');



    $.ajax({
      url: '<?php echo base_url(); ?>website/User/searchServices',
      type: 'POST',
      data: {
        txt_search_services: txt_search_services,
        '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_value
      },
      success: function(data) {

        $("#reg_service_type").html(data);

      }
    });

  }


  function loadArea(){
    txt_search_area = $("#txt_search_area").val();

    $.ajax({
      url : "<?=base_url()?>website/User/getAreaList",
      type: "POST",
      data: {txt_search_area :txt_search_area  },
      success : function(data){
        $('#area_list').html(data);
      }
    });
  }

  $(document).delegate(".serviceChkBox", "click", function(e) {
    $("#txt_service").val("");
    mappedItems = $(".serviceChkBox:checked").map(function() {
      return $(this).attr("for");
    }).get().join();
    if (mappedItems != "" && mappedItems != null) {
      $("#txt_service").val(mappedItems);
    } else {
      placeholder = "Choose a Service";
      $("#txt_service").attr("placeholder", placeholder);
      $("#txt_service").val("");
    }
  });
    
    
    $('#txt_area').click(function(){
       $('#txt_search_area').val(''); 
       loadArea();
    });
    
  $(document).delegate(".areaChkBox", "click", function(e) {
    $("#txt_area").val("");
    mappedAreaItems = $(".areaChkBox:checked").map(function() {
        
      return $(this).attr("for");
    }).get().join();
    if (mappedAreaItems != "" && mappedAreaItems != null) {
      $("#txt_area").val(mappedAreaItems);
    } else {
      placeholder = "Choose a area";
      $("#txt_area").attr("placeholder", placeholder);
      $("#txt_area").val("");
    }
  });

</script>


