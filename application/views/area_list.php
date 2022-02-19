            <?php 
            if(count($result)>0)
            {
             foreach($result as $rows)
             {
            ?>
             <li>
              <label class="choose_srev"><?php echo $rows->area_name ?>
              <input type="checkbox" id="area_chk<?php echo $rows->area_id ?>" for="<?php echo $rows->area_name ?>" class="areaChkBox" name="chk_area[]"  value="<?php echo $rows->area_id ?>">
              <span class="checkserv"></span>
            </label></li>
            <?php
             }
            }else{
            ?> 
                <li>
                    <label class="choose_srev">No area avilable</label>
                </li>
            <?php
            }
            ?>