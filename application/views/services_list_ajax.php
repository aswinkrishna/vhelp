<?php
if(count($result)>0)
{
    foreach($result as $rows)
    {
         $image = ($rows->service_type_thumbnail!=""? base_url()."uploads/service_type/".$rows->service_type_thumbnail:"");
         $urlCategoryName  =  $rows->service_type_name;
         $string = str_replace(' ', '-', $urlCategoryName); 
         $urlCategoryName = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
         $urlCategoryName  = strtolower($urlCategoryName);
         
         $sub_service     = $this->M_common->getSubServices($rows->service_type_id);
?>
 <div class="cmt-box-col-wrapper col-lg-3 col-6">
        <!-- featured-imagebox -->
        <div class="featured-imagebox featured-imagebox-services style1">
            <?php
                if($sub_service){
            ?>
                <a href="<?=base_url('sub_services/').$rows->service_type_id?>">
            <?php
                }else{
            ?>
                <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($rows->service_type_id); ?>">
            <?php
                }
            ?>
            <div class="featured-content">
                <div class="cmt-icon cmt-icon_element-onlytxt cmt-icon_element-color-skincolor cmt-icon_element-size-lg">
                <img src="<?= $image; ?>" alt="">
                </div>
                <div class="featured-title">
                    <h5><?php  echo substr($rows->service_type_name,0,19);?><?php echo strlen($rows->service_type_name)>19?"...":""?></h5>
                </div> 
            </div>
            </a>
        </div><!-- featured-imagebox end -->
    </div>
    <?php /* ?>
    <div class="col-md-3">
        <div class="col-md-12 fff custom content-drop padding-none">
            <a href="<?php  echo base_url();?>request/<?php echo $urlCategoryName;?>?sid=<?php  echo $this->common_functions->encryptId($rows->service_type_id); ?>">
             <div class="min-cover">
                  <div class="title-cover"><h4><?php  echo $rows->service_type_name;?></h4></div>
                   <img src="<?php echo $image;?>">
                    
             </div>
              </a>
        </div>
    </div><!--end col-1-5-->
    */ ?>
    
    
<?php
    }
}
else
{
    echo "No results found";
}
?>
<?php

if(isset($links) && $links!="")
{
     echo $links;
     
 }
?>