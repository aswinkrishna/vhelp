<?php 
class Vendor_model extends CI_Model
{

	public function get_user_by_email($email, $lang_code = 1)
	{
        return $this->db->select("user_table.*, country_name, city_name")
                        ->from("user_table")
                        ->join("country", "country.country_id = user_table.country_id and country.country_language_code = {$lang_code} ", "left")
                        ->join("city", "city.city_id = user_table.city_id and city.city_language_code = {$lang_code} ", "left")
                        ->where("user_email", $email)
                        ->get()
                        ->row();
    }

    public function update_user($data, $user_id)
    {
        $this->db->where("user_id", $user_id)->update("user_table", $data);
        return $this->db->affected_rows();
    }

    public function get_user($condition, $lang_code = 1) {

        $data= $this->db->select("user_table.*, country_name, city_name")
                        ->from("user_table")
                        ->join("country", "country.country_id = user_table.country_id and country.country_language_code = {$lang_code} ", "left")
                        ->join("city", "city.city_id = user_table.city_id and city.city_language_code = {$lang_code} ", "left")
                        ->where($condition)
                        ->get()
                        ->row();
        return $data;
    }

    public function getServiceRequestsByCondition($condition=[],$limit=0, $offset=0, $order_by='assign_job_provider_id desc')
    {
    	if(!empty($condition))
    		$this->db->where($condition);

    	$this->db->select('*');
    	$this->db->join('job_request jr','jr.job_request_id=ajp.job_request_id','inner');
    	$this->db->join('user_table ut','ut.user_id=jr.user_id','inner');
    	
    	if($limit && $offset)
    		$this->db->limit($limit, $offset);
    	else if($limit)
    		$this->db->limit($limit);

    	if($order_by)
    		$this->db->order_by($order_by);

    	return $this->db->get('assign_job_provider ajp');
    }
}