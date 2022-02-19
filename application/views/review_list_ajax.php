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
            
           