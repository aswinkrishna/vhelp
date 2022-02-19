<div class="site-main">
	<section class="cmt-row services-section bg-img1 clearfix">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 m-auto">

					<!-- section title -->
					<div class="section-title title-style-center_text">
						<div class="title-header">
							<h2 class="title"><?php echo $this->session->userdata("language")==2?$labels->home_labels_arabic1:$labels->home_labels1; ?></h2>
						</div>
						<!-- <div class="title-desc">Discover the best services nearest to you</div> -->
					</div><!-- section title end -->

				</div>
			</div>
			<div class="row">
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
						<div class="cmt-box-col-wrapper col-lg-3 col-6">
							<!-- featured-imagebox -->
							<div class="featured-imagebox featured-imagebox-services style1">
								<?php
								if($rows->is_sub){
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
						<?php } } ?>
				</div>
			</div>
		</section>
	</div>