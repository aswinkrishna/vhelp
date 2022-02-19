<!--start banner section-->
<section>
  <!--start container fluid-->
  <div class="container-fluid">
    <!--start row-->
    <div class="row how_it_work_banner">
      <h3>
        <?php  
        
       // print_r($articles);
        echo $articles->article_type_desc 
        ?>
      </h3>

            <!--start container-->
      <div class="container">
        <div class="row">
       

         </div>
      </div>
      <!--end container-->
    </div>
    <!--end row-->


  </div>
  <!--end container fluid-->
  
</section>
<!--end banner section-->









<!--start section-->
<section>
    <!--end container fluid-->
    <div class="container-fluid section-repeat">
        <!--start row-->
        <div class="main">
            <!-- <h3 style="display:none"><?php // echo $articles->article_type_desc ?> </h3> -->
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                    <!--start col md 8-->
                     <?php  echo html_entity_decode($articles->articles_desc) ?>                    
                        
                    </div>
                    <!--end col md 8-->
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
<section class="btm-section">
    <!--start container fluid-->
    <div class="container-fluid">
        <!--start row-->
        <div class="row">
            <!--start container-->
            <div class="container">
                <!--start row-->
                <div class="row">
                    <!--start col md 3-->
                    <div class="col-md-3 col-sm-4 bottom-tl">
                        <h3>Trusted by 10K <br>Customers</h3>
                    </div>
                    <!--end col md 3-->
                    
                    <!--start col md 9-->
                    <div class="col-md-9 col-sm-8">
                        <!--start row-->
                        <div class="row">
                            <!--start carocel-->
                            <div id="owl-example-btm" class="owl-carousel row">
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img1.png"/>
                </div>
              </div>
              
              <div class="custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img2.png"/>
                </div>
              </div>
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img3.png"/>

                </div>
              </div>
              
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img4.png"/>
 
                </div>
              </div>
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img1.png"/>
                </div>
              </div>
              
              <div class="custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img2.png"/>
                </div>
              </div>
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img3.png"/>

                </div>
              </div>
              
              
              
              <div class=" custom_mrgn">
                <div class="col-md-12 fff custom content-drop btm-col">
                    <img src="<?php echo base_url();?>frontend_assets/images/carocel/img4.png"/>
 
                </div>
              </div>
</div>     
                            <!--end carocel-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end col md 9-->
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
        
    
    
