            <?php 
            if(count($result)>0)
            {
             foreach($result as $rows)
             {
            ?>
             <li>
              <label class="choose_srev"><?php echo $rows->service_type_name ?>
              <input type="checkbox" id="service_chk<?php echo $rows->service_type_id ?>" for="<?php echo $rows->service_type_name ?>" class="serviceChkBox" name="chk_service_type[]"  value="<?php echo $rows->service_type_id ?>">
              <span class="checkserv"></span>
            </label></li>
            <?php
             }
            }
            ?>