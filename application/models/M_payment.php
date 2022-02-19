<?php
class M_payment extends CI_Model
{
 

// StoredProcedure
function get_all($table)
{
	$query = $this->db->get($table);
	return $query->result_array();
}
  function get_all_from_where($table,$data)
{
	$query = $this->db->get_where($table, $data);
	return $query->result_array();
}
function get_from_where($table,$data)
{
  $query = $this->db->get_where($table, $data);
  return $query->result();
}
  function get_one($table,$data)
{
  $query = $this->db->get_where($table, $data);
  return $query->row_array();
}
function update_where($table,$where,$data)
{ 
  $this->db->where($where);
  $query=$this->db->update($table,$data); 
  return $query;
}
function multipledelete($table,$data)
{
if (!empty($data)) {
  $this->db->where_in('id', $data);
  $query=$this->db->delete($table);
  return $query;
}
}
function delete_where($table,$data)
{
  $query=$this->db->delete($table, $data); 
  return $query;
}
  
function insert_to($table, $data)
{ 
  $this->db->insert($table, $data); 
  return $this->db->insert_id();
}
function join_two($table1,$table2,$condition,$where)
{
  $this->db->select('*');
  $this->db->from($table1);
  $this->db->join($table2, $condition);
  $this->db->where($where); 
  $query = $this->db->get();
  return $query->result_array();
}
function select_some($table1,$data,$where)
{
  $this->db->select($data);
  $this->db->from($table1);
  $this->db->where($where); 
  $query = $this->db->get();
  return $query->result_array();
}
function row_count($table,$where)
{
   $this->db->select('count(*)');
   $this->db->where($where);
   //$this->db->where('status !=' ,DELETED,FALSE);
   $query = $this->db->get($table);
   $cnt = $query->row_array();
   return $cnt['count(*)'];
}
public function batchinsert($table,$data){
  $this->db->insert_batch($table, $data); 
  if($this->db->affected_rows() > 0)
return 1;
else
return 0; 
}
public function lastrecordId($table,$name)
{ try
  {
	  $last = $this->db->order_by($name,"desc")
	  ->limit(1)
	  ->get($table)
	  ->row();
	  return ($last->$name)?$last->$name:1000;
  }
  catch( Exception $e )
  {
	  log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
	  // on error
  }
  
}
public function run_query($SQL)
{ 
  $query = $this->db->query($SQL);
  return $query->row_array();
}
public function run_Allquery($SQL)
{ 
  $query = $this->db->query($SQL);
  return $query->result();
}
public function multiple_insert($table,$data)
{ 
  $query =$this->db->insert_batch($table,$data);
  return $query;
}
}