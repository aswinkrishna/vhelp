<?php
class M_chat extends CI_Model 
{
     function initiateChat($data)
    {
        
            $sql    = "select chat_id from chat where ( reciever_id=".$data['sender_id']." and sender_id=".$data['reciever_id'].") or ( reciever_id=".$data['reciever_id']." and sender_id=".$data['sender_id'].")";
            $rs     = $this->db->query($sql);
            $result =  $rs->row();
            $chatId = $result->chat_id; 
        
                if($chatId>0)
				{
					return $chatId;
				}
				else
				{
				        $this->db->insert('chat',$data);

                        $this->db->last_query();

				return	$insertId = $this->db->insert_id();
				    
				}
    }
    function getNameAndImage($userId)
    {
           $sql            =  " select user_first_name, user_last_name,user_image as image,fcm_token  from user_table where user_id=".$userId."  limit 1  ";
           $rs             =  $this->db->query($sql);
           return  $result =  $rs->row();
    }
     function checkAlreadyChatted($data)
    {
            $sql           = "select chat_id from chat where ( reciever_id=".$data['sender_id']." and sender_id=".$data['reciever_id'].") or ( reciever_id=".$data['reciever_id']." and sender_id=".$data['sender_id'].")";
            $rs            = $this->db->query($sql);
            $result        = $rs->row();
            return $chatId = $result->chat_id; 
        
        
    }
    
    
}
?>