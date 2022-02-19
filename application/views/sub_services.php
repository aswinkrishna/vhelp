    <?php
        $service        = $service_type[0]->service_type_name;
        $baner_image    = $this->M_common->getbanerImages($service_type[0]->service_type_id);
        // print_r($baner_image);
    ?>
    
    <style type="text/css">
        .no-color{
            color: #6f6f6f !important;

        }
    </style>


    
    <section class="sub-service-banner">
        <div class="container-fluid">
            <div class="row">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <?php
                        foreach($baner_image as $key=>$value){
                            if($key == 0 )
                                $active = "active";
                            else
                                $active = "";
                            $image = 'uploads/service_type/'.$value->image;
                            if(file_exists($image) && is_file($image))
                                $image = base_url().$image;
                            else
                                $image = base_url().'uploads/banner-dummy.jpg';
                    ?>
                    <div class="carousel-item <?=$active?>">
                      <img src="<?=$image?>" class="" alt="">
                      <div class="carousel-caption d-none d-md-block">
                        <div class="col-lg-12">
                            <div class="page-title-heading">
                                <h2 class="title">Services</h2>
                            </div>
                            <div class="breadcrumb-wrapper">
                                <span>
                                    <a title="Homepage" href="<?=base_url()?>">Home</a>
                                </span>
                                <span><a href="#"><?=$service?></a></span>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    <?php
                        }
                    ?>
                    
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div>
        </div>
    </section>
    
    
    

        <!-- page-title -->
        <!--<div class="cmt-page-title-row cmt-bgimage-yes cmt-bg cmt-bgcolor-darkgrey" style="background:url(<?=$image?>); display:none">-->
        <!--    <div class="cmt-row-wrapper-bg-layer cmt-bg-layer"></div>-->
        <!--    <div class="cmt-page-title-row-inner">-->
        <!--        <div class="container">-->
        <!--            <div class="row align-items-center text-center">-->
        <!--                <div class="col-lg-12">-->
        <!--                    <div class="page-title-heading">-->
        <!--                        <h2 class="title">Services</h2>-->
        <!--                    </div>-->
        <!--                    <div class="breadcrumb-wrapper">-->
        <!--                        <span>-->
        <!--                            <a title="Homepage" href="<?=base_url()?>">Home</a>-->
        <!--                        </span>-->
        <!--                        <span><a href="#"><?=$service?></a></span>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>                    -->
        <!--</div>-->
        <!-- page-title end-->

    <section class="sub-categories">
  <div class="container">
        <div class="row">
            <?php
                foreach($sub_service_list as $key => $value){
                    $image   = 'uploads/service_type/'.$value->service_type_icon;
                    if(file_exists($image) && is_file($image))
                        $image = base_url().$image;
                    else
                        $image = '';
                        
                    $urlCategoryName  =  $value->service_type_name;
                    $string = str_replace(' ', '-', $urlCategoryName); 
                    $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
                    $urlCategoryName  = strtolower($urlCategoryName);
            ?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($value->service_type_id); ?>" class="services-wraper" style="background: url('<?=$image?>');">
                        <div class="services-content">
                        <p><?=$value->service_type_name?></p>
                        <i class="fa fa-long-arrow-right"></i>
                      </div>
                   </a>
                </div>
            <?php
                }
            ?>
        </div>
      </div>
</section>

<?php
    if($h_data){
?>
<section class="how-it-works">
  <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-12">
            <h4>How It's Works</h4>
            <ul>
                <?php
                    foreach($h_data as $key=> $value){
                        $image = 'uploads/service_type/'.$value->image;
                        if(file_exists($image) && is_file($image))
                            $image = base_url().$image;
                        else
                            $image = base_url().'template/images/howitworks-1.png';
                ?>
                    <li>
                      <img src="<?=$image; ?>"/>
                      <h3><?=$value->title?></h3>
                      <p><?=$value->decription?></p>
                    </li>
                <?php
                    }
                ?>
              </ul>
        </div>
        
        
        
        <!--<div class="col-md-4">-->
        <!--    <div class="caricature-call-center">-->
        <!--        <img src="https://dxb.co.com/vhelp2/frontend_assets/images/icons/call-center.png">-->
        <!--    </div>-->
        <!--</div>-->
        
        
      </div>
   </div>
</section>

<?php
    }
?>

<?php
    if($service_details->service_type_desc){
?>

<section class="service-location">
   <div class="container">
      <div class="row">
        <div class="col-md-12">
        <div class="service-location-area">
            <?=$service_details->service_type_desc?>
        </div>    
        </div>
    </div>
  </div>
</section>

<?php
    }
?>

<?php
    if($rating) {
?>
<div class="reviews-section">
    <div class="container">
        <div class=top-sec>
            <h4>Customer Reviews</h4>
            <?php
                if($rating->rating == 0 ){
                    $class ="no-color";
                    $rating = 5;
                }
                else{
                    $class = "";
                    $rating = $rating->rating;
                }
            ?>
            <h2><i class="fa fa-star <?=$class?>" aria-hidden="true"></i><?=$rating?></h2>
            <p><?=$rating->rated_users?> Total ratings</p>
        </div>
        <div class="list-reviews" >
            <ul id="reviews-list">
                <?php
                    foreach($rating_list as $key=>$value){
                        $image = "uploads/user/".$value->user_image;
                        if(file_exists($image) && is_file($image))
                            $image = base_url().$image;
                        else
                            $image = base_url().'uploads/user_dummy.png';
                        
                ?>
                    <li class="item">
                        <div class="top-bar">
                            <img class="user-pic" src="<?=$image?>">
                            <div>
                                <p class="name"><?=$value->user_first_name.' '.$value->user_last_name?></p>
                                <span><i class="fa fa-star" aria-hidden="true"></i><?=$value->user_rating?></span>
                            </div>
                        </div>
                        <div class="content">
                            <h4><?=ucfirst($value->title)?></h4>
                            <p><?=$value->feedback?></p>
                        </div>
                    </li>
                <?php
                    }
                ?>
            </ul>
            
            <div class="col-md-12 text-center" style="display:none;" id="spinner">
                <div class="spinner-border text-success" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
            </div>

            
            <?php
                if($rating->rated_users > 8){
            ?>  <div id="more">
                    <a href="#" class="review-btn cmt-btn cmt-btn-shape-round cmt-btn-style-fill cmt-btn-color-dark" id="viewMore" for="1">View More</a>
                </div>
            <?php
                }
            ?>
            
        </div>
        
        <br>
    </div>
</div>
<?php
    }
?>


<script>
    $('#viewMore').click(function(e){
        $('#spinner').show();
        var page = $(this).attr('for');
        var service_type_id = '<?=$service_type_id?>';
        $.ajax({
           url: '<?=base_url()?>welcome/getReviewsList',
           type: 'POST',
           data: {page:page,service_type_id:service_type_id},
           success : function(data){
               data = JSON.parse(data);
            //   $('#viewMore').remove();
            
                setTimeout(function () {
                  $('#spinner').hide();
                    $('#reviews-list').append(data['result']).fadeIn(1000);
               
                    if(data['next'] > 0 ) 
                        $('#viewMore').attr('for',data['next']);
                    else
                        $('#viewMore').remove();
                }, 2500);
               
           } 
        });
        
        return false;
    });

</script>

