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
      <h1><i class="fa fa-edit"></i> Provider</h1>
      <!--          <p>Sample forms</p>-->
    </div>
    <!--        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>-->
  </div>
  <?php

  $ser = array();
  foreach ($pro_services as $sr) {
    $ser[]   = $sr->service_type_id;
  }

  $selectedArea = array();

  foreach ($selected_area as $key => $value) {
    $selectedArea[] = $value->area_id;
  }

  // print_r($ser);
  $label = "registration";
  $saveButtonName  = "Add";
  if ($id > 0) {
    $label = "Updation";
    $saveButtonName  = "Update";
  }
  ?>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Provider <?php echo $label; ?></h3>
        <div class="tile-body">
          <form name="item" id="userForm" method="post" enctype="multipart/form-data" autocomplete="off">
            <?php

            if ($id > 0) {

              $row     =        $user_basic[0];
              $row2    =        $user_details[0];

            ?>
              <input type="hidden" class="form-control boxed" placeholder="" name="txt_user_id" value="<?php echo $id; ?>">
            <?php

            }

            ?>
            <div class="row">
              <input type="hidden" name="company_type" id="company_type1" value="1">
              <?php /*
              <div class="col-md-12">
                <label>
                  <input type="radio" name="company_type" id="company_type1" value="1" class="radioCommapnyType" <?php echo $row2->company_type != 2 ? 'checked' : '' ?>><span class="label-text">Company</span>
                </label>&nbsp;&nbsp;
                <label>
                  <input type="radio" name="company_type" id="company_type2" value="2" class="radioCommapnyType" <?php echo $row2->company_type == 2 ? 'checked' : '' ?>><span class="label-text">Freelancer</span>
                </label>
              </div>
              */ ?>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">First Name</label>
                  <input class="form-control" type="text" placeholder="Enter first name" maxlength="40" id="txt_first_name" name="txt_first_name" value="<?php echo $row->user_first_name != '' ? $row->user_first_name : '' ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Last Name</label>
                  <input class="form-control" type="text" placeholder="Enter last name" maxlength="30" id="txt_last_name" name="txt_last_name" value="<?php echo $row->user_last_name != '' ? $row->user_last_name : '' ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <input class="form-control" type="text" placeholder="Enter company name" maxlength="100" id="txt_company_name" name="txt_company_name" value="<?php echo $row2->company_name != '' ? $row2->company_name : '' ?>">
                </div>
              </div>
              <?php /*
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Location</label>
                  <input class="form-control autocomplete" type="text" placeholder="Select location" maxlength="1000" id="txt_location" name="txt_location" value="<?php echo $row2->location != '' ? $row2->location : '' ?>">
                  <input type="hidden" id="txt_longitude" name="txt_longitude" value="<?php echo $row2->longitude != '' ? $row2->longitude : '' ?>">
                  <input type="hidden" id="txt_lattitude" name="txt_lattitude" value="<?php echo $row2->lattitude != '' ? $row2->lattitude : '' ?>">
                </div>
              </div>
              */ ?>
            </div>
            <input type="hidden" value="<?php echo ($id > 0) ? 0 : 1; ?>" name="save_password" id="save_password">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email id</label>
                  <input class="form-control" type="text" placeholder="Enter email id" maxlength="60" id="txt_email" name="txt_email" <?php echo $id > 0 ? 'readonly' : '' ?> value="<?php echo $row->user_email != '' ? $row->user_email : '' ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Password</label>
                  <?php if($id): ?>
                    <span style="cursor: pointer;float: right;font-weight: bold;" class="changePassword">Change Password</span>
                  <?php endif; ?>
                  <?php $display = ($id==0 ? '' : 'none'); ?>
                  <i class="fa fa-eye" id="displayPassword" style="display: <?=$display?>"></i>
                  <input class="form-control" type="password" placeholder="Enter password" maxlength="20" <?php echo $id > 0 ? 'readonly' : '' ?> id="txt_password" name="txt_password" value="<?php echo $row->user_password != '' ? '00#sd123s' : '' ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Country</label>
                  <select class="form-control" id="select_country" name="select_country">
                    <option value="">Select</option>
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
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">City</label>
                  <select class="form-control" id="select_city" name="select_city">
                    <option value="">Select</option>
                    <?php
                    if ($id > 0 && $row->country_id > 0) {

                      $con['city_country_id']                   =       $row->country_id;
                      $con['city_status']                            =       1;
                      $con['city_language_code']           =       1;
                      $city                                                      =      $this->M_admin->getCitiesCondition($con);
                      if (count($city) > 0) {
                        foreach ($city as $cities) {
                    ?>
                          <option value="<?php echo $cities->city_id ?>" <?php echo $row->city_id == $cities->city_id ? 'selected' : '' ?>><?php echo $cities->city_name ?></option>
                    <?php

                        }
                      }
                    }
                    ?>

                  </select>
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Dial Code</label>
                  <input class="form-control" type="text" placeholder="Dial code" maxlength="5" id="txt_dial" name="txt_dial" readonly value="<?php echo $row->user_dial_code != '' ? $row->user_dial_code : '' ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Phone</label>
                  <input class="form-control" type="text" placeholder="Enter phone number" maxlength="10" id="txt_phone" name="txt_phone" value="<?php echo $row->user_phone != '' ? $row->user_phone : '' ?>">
                </div>
              </div>
              <div class="col-md-6" style="display:none;">
                <div class="form-group">
                  <label class="control-label">Document Type</label>
                  <select class="form-control" id="select_document_type" name="select_document_type">
                    <option value="">Select</option>
                    <option value="1" <?php echo $row2->document_type == 1 ? 'selected' : 'selected' ?>>Trade License</option>
                    <option value="2" <?php echo $row2->document_type == 2 ? 'selected' : '' ?>>Emirates Id</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6" style="display:none;">
                <div class="form-group">
                  <label class="control-label">Document No</label>
                  <input class="form-control" type="text" placeholder="Enter document no" maxlength="100" id="txt_doc_no" name="txt_doc_no" value="<?php echo $row2->document_number != '' ? $row2->document_number : '111111' ?>">
                </div>
              </div>




              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Profile picture (jpg/jpeg/png Max 20MB)</label>
                  <input class="form-control" type="file" id="txt_profile" name="txt_profile">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">

                  <img src="<?php echo $row->user_image != "" ? base_url() . 'uploads/user/' . $row->user_image : base_url() . 'images/placeholder.jpg'; ?>" class="previewImage" id="imagePreview">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Select Service Type</label>
                  <select class="form-control demoSelect" name="txt_service_type[]" multiple="multiple">
                    <optgroup label="Select Service Type">
                      <?php
                      if (count($service_type) > 0) {
                        foreach ($service_type as $rows2) {
                      ?>
                          <option value="<?php echo $rows2->service_type_id ?>" <?php echo in_array($rows2->service_type_id, $ser) ? "selected" : "" ?>><?php echo $rows2->service_type_name ?></option>
                      <?php
                        }
                      }
                      ?>
                    </optgroup>
                  </select>
                </div>
              </div>
              <?php
                    if ($row2->company_type == 2) {
                    ?>
                <style>
                  .tradeLicenceSection {
                    display: none;
                  }
                </style>
              <?php
                    }
              ?>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Select Area</label>
                  <select class="form-control demoSelect" name="txt_area[]" multiple="multiple">
                    <optgroup label="Select Area">
                      <?php
                      if (count($area_list) > 0) {
                        foreach ($area_list as $rows) {
                      ?>
                          <option value="<?php echo $rows->area_id ?>" <?php echo in_array($rows->area_id, $selectedArea) ? "selected" : "" ?>><?php echo $rows->area_name ?></option>
                      <?php
                        }
                      }
                      ?>
                    </optgroup>
                  </select>
                </div>
              </div>

              <div class="col-md-6 tradeLicenceSection">
                <div class="form-group">
                  <label class="control-label">Upload Trade license</label>
                  <input class="form-control" type="file" id="txt_doc" name="txt_doc">
                  <p>Accept pdf/doc/jpg/jpeg/png only (Max 20MB)</p>
                </div>
              </div>
              <div class="col-md-3 tradeLicenceSection">
                <div class="form-group">
                  <?php
                  if ($row2->document_name != "") {
                  ?>
                    <a target="_blank" href="<?php echo base_url() . 'uploads/user/' . $row2->document_name; ?>" class="previewImage">View document</a>

                  <?php
                  }
                  ?>
                </div>
              </div>
          </form>
        </div>
        <div class="tile-footer">
          <button class="btn btn-primary" type="button" id="btnRegister"><i class="fa fa-fw fa-lg fa-check-circle"></i><?php echo $saveButtonName; ?></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="javascript:void(0)" id="cancelBtn"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
          <span id="registerLoader"></span>
        </div>
      </div>
    </div>


  </div>
</main>
<script type="text/javascript" src="<?php echo base_url() ?>admin_assets/js/plugins/select2.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHFZ49O5XuPD9RR-s0grdzBoV4wAZxJB8&libraries=places&sensor=false"></script>
<script>
  loadMultiSelect();

  function initialize2() {

    //  alert();

    var acInputs = document.getElementsByClassName("autocomplete");

    for (var i = 0; i < acInputs.length; i++) {
      j = i + 1;


      var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
      autocomplete.inputId = acInputs[i].id;

      google.maps.event.addListener(autocomplete, 'place_changed', function() {

        // document.getElementById("log").innerHTML = 'You used input with id ' + this.inputId;
        var place = autocomplete.getPlace();
        //alert(place.name+place.geometry.location.lat()+place.geometry.location.lng());

        document.getElementById("txt_longitude").value = place.geometry.location.lng();
        document.getElementById("txt_lattitude").value = place.geometry.location.lat();


      });
    }
  }
  initialize2();
  $(document).delegate("#btnRegister", "click", function(e) {
    $("#userForm").submit();
  });
  $(document).delegate("#cancelBtn", "click", function(e) {
    //alert();
    $("#userForm")[0].reset();
  });

  var validator = $("#userForm").validate(
    //alert();
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
        'txt_service_type[]': {
          required: true,
        },
        'txt_area[]':{
            required: true,
        }
        <?php

        if ($row2->document_name == "") {
        ?>,
          txt_doc: {
            required: '#company_type1:checked'
          }
        <?php
        }
        ?>

      },
      messages: {

      },
      submitHandler: function() {

        $(".errorSpan1").html("");
        $("#btnRegister").attr("disabled", "disabled");
        $("#registerLoader").html("<img src='<?php echo base_url(); ?>frontend_assets/images/loader-new.gif' width='100' height='100' style='float:none'>");
        $(".errorSpan1").html();
        dataString = $('#userForm').serialize();
        var formData = new FormData($("#userForm")[0]);
        csrf_value = getCookie('csrf_cookie_name');
        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', csrf_value);

        $.ajax({
          url: '<?php echo base_url(); ?>admin/C_admin/saveProvider',
          type: 'POST',
          data: formData,
          async: true,
          success: function(data) {

            $("#registerLoader").html("");
            $('#btnRegister').prop("disabled", false);
            data = jQuery.parseJSON(data);
            // console.log(data['status']);


            if (data['status'] == 1) {

              swal("Well done!", "Saved Successfully!", "success");
              window.location = "<?php echo base_url(); ?>admin/provider_list";

            } else if (data['status'] == 3) {
              swal("Sorry!", "Email id already exists", "error");
            } else if (data['status'] == 0) {
              if (data['errors'] !== "") {
                $.each(data['errors'], function(key, value) {
                  console.log(key);
                  console.log(value);
                  //$('input[name='+key+']').addClass('is-invalid');

                  $('<span class="error errorSpan1">' + value + '</span>').insertAfter('[name="' + key + '"]');

                });
              } else {
                swal("Sorry!", "Failed to save! Try again later", "error");
              }


            } else {

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
  $(document).delegate("#select_country", "change", function(e) {

    var selected = $(this).find('option:selected');
    var dialCode = selected.data('foo');
    $("#txt_dial").val(dialCode);
    csrf_value = getCookie('csrf_cookie_name');

    $.ajax({
      url: '<?php echo base_url(); ?>admin/C_admin/loadCityDropDown',
      type: 'POST',
      data: {
        countryId: $(this).val(),
        '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_value
      },
      success: function(data) {

        $("#select_city").html(data);

      }
    });

  });
  $("#txt_profile").change(function() {
    readURL(this, 'imagePreview');
  });
  $("#txt_doc").change(function() {
    readURL(this, 'imagePreview2');
  });

  function loadMultiSelect() {
    $('.demoSelect').select2();
  }
  $(document).delegate(".radioCommapnyType", "click", function(e) {

    if ($(this).val() == 2) {
      $(".tradeLicenceSection").css("display", "none");
    } else {
      $(".tradeLicenceSection").css("display", "block");
    }
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
    
    $('.changePassword').click(function(){
    $('input#save_password').val(1);
    $('input#txt_password').val('');
    $('input#txt_password').attr('readonly',false);
    $('#displayPassword').show();
  });
</script>