<?php 
class M_job_admin extends CI_Model 
{
    
    function getRefuseReason()
    {
               $sql = "select * from refuse_reason  WHERE 	refuse_reason_status=1 ";                       
               $rs = $this->db->query($sql);
               return  $result  =   $rs->result();
    }
    
}
