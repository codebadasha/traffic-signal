<?php

class General_model extends CI_Model {

    public function check_login($email_or_mobile,$password)
    {
        return $this->db
                    ->where("(mobile_no='".$email_or_mobile."' OR email='".$email_or_mobile."')")   
                    ->get_where('users',array('password' => $password,'is_delete' => '0'))
                    ->row();

    }
    public function get_all($table = '') {
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function get_all_select($select,$table = '') {
        $this->db->select($select);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function mysql_query($query)
    {
        return $this->db->query($query)->result_array();
    }

    public function get_where($where = [], $table = '') {
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function get_where_with_order_by($where = [], $key, $order_by, $table = '') {
        $this->db->where($where);
        $this->db->order_by($key, $order_by);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function get_where_single($where = [], $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->row(1);
    }

    public function get_where_single_order_by($where = [],$key, $order_by, $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $this->db->order_by($key, $order_by);
        $query = $this->db->get($table);
        return $query->row();
    }

    public function get_where_count($where = [], $table = '') {
        $result = 'result'; 
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function get_where_count_with_group_by($select,$group_by,$where = [], $table = '') {
        $this->db->select($select);
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $this->db->group_by($group_by);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function get_where_join($select="*",$where = [], $join = [], $table = '') {

        $table = (empty($table)) ? $this->table : $table;
        $this->db->select($select);
        $this->db->where($where);
        foreach ($join as $key => $value) { 
            $this->db->join("$key","$value");
        }
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    function get_where_select($select,$where = [], $table = '') {
        $this->db->select($select);
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function get_where_join_with_order_by($select="*",$where = [], $join = [], $table = '', $order_by) {

        $table = (empty($table)) ? $this->table : $table;
        $this->db->select($select);
        $this->db->where($where);
        foreach ($join as $key => $value) { 
            $this->db->join("$key","$value");
        }
        $this->db->order_by($order_by, 'desc');
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function get_where_join_single($select="*",$where = [], $join = [], $table = '') {

        $table = (empty($table)) ? $this->table : $table;
        $this->db->select($select);
        $this->db->where($where);
        foreach ($join as $key => $value) { 
            $this->db->join("$key","$value");
        }
        $query = $this->db->get($table);
        return $query->row();
    }

    public function get_what_where_how($column = '*', $where = [], $result = 'row', $limit = '', $offset = '', $table = '', $order_by = '', $order = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->select($column);
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($limit) && empty($offset)) {
            $this->db->limit($limit);
        }
        if (!empty($limit) && !empty($offset)) {
            $this->db->limit($limit, $offset);
        }
        if (!empty($order_by)) {
            $this->db->order_by($order_by, $order);
        }
        $query = $this->db->get($table);
        return $query->result_array($query, $result);
    }

    public function insert_data($data, $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_data($data, $where = '', $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $this->db->update($table, $data);
        return true;
    }

    public function delete_hard($where, $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $this->db->delete($table);
        return true;
    }

    public function delete_soft($where, $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $data = ['is_delete' => '1'];
        $this->db->update($table, $data);
        return true;
    }

    public function get_where_in($key,$where,$table)
    {
        $this->db->where_in($key,$where);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function is_unique($field, $value, $except, $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->select($field);
        $this->db->where($field, $value);
        $this->db->where($except);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function last_query(){
        return $this->db->last_query();
    }

    public function get_with_order_by($key, $order_by, $table = '') {
        $this->db->order_by($key, $order_by);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function insert_all_data($data, $table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->insert_batch($table, $data);
        return $this->db->insert_id();
    }

    public function get_where_with_order_by_limt($where = [],  $key, $order_by, $limit, $start , $table = '') {
        $this->db->where($where);
        $this->db->order_by($key, $order_by);
        $this->db->limit($limit,$start);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function get_where_with_order_by_limt_one($where = [],  $key, $order_by, $table = '') {
        $this->db->where($where);
        $this->db->order_by($key, $order_by);
        $this->db->limit(1);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function get_where_with_where_in($where = [],$key,$wherein,$table = '')
    {   
        $this->db->where($where);
        $this->db->where_in($key,$wherein);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function get_where_with_where_in_order_by($where = [],$key,$wherein,$key1,$order_by,$table = '')
    {   
        $this->db->where($where);
        $this->db->where_in($key,$wherein);
        $this->db->order_by($key1, $order_by);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function get_where_with_where_in_order_by_limit($where = [],$key,$wherein,$key1,$order_by,$limit, $start,$table = '')
    {   
        $this->db->where($where);
        $this->db->where_in($key,$wherein);
        $this->db->order_by($key1, $order_by);
        $this->db->limit($limit,$start);
        $query = $this->db->get($table);
        return $query->result_array();
    }


    public function update_data_where_with_wherein($data, $where = '', $key, $wherein = '' ,$table = '') {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $this->db->where_in($key,$wherein);
        $this->db->update($table, $data);
        return true;
    }


    public function time_elapsed_string($datetime, $full = false) 
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7); 
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'min',
            's' => 'sec',
        ); 
        foreach ($string as $k => &$v) { 
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . '' : 'just now';
    }

    public function get_where_with_order_by_passlimit($where = [],  $key, $order_by, $limit ,$table = '') {
        $this->db->where($where);
        $this->db->order_by($key, $order_by);
        $this->db->limit($limit);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }

    public function where_not_in($key,$wherenotin,$table)
    {
        $this->db->where('is_deleted','0');
        $this->db->where('is_active','1');
        $this->db->where_not_in($key,$wherenotin);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }
	
	public function get_where_like($where = [],$like_field,$like_value, $table = '') 
	{
        $this->db->where($where);
        $this->db->like($like_field,$like_value);
        $query = $this->db->get($table);
        return $query->result_array($query);
    }
	
	public function get_where_with_where_in_group_by($where = [],$key,$wherein,$group_by,$table = '')
    {   
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $this->db->where_in($key,$wherein);
        $this->db->group_by($group_by);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function get_where_with_group_by($where = [],$group_by, $table = '') 
    {
        $table = (empty($table)) ? $this->table : $table;
        $this->db->where($where);
        $this->db->group_by($group_by);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function get_where_with_where_not_in($where = [],$key,$wherenotin,$table = '')
    {   
        $this->db->where($where);
        $this->db->where_not_in($key,$wherenotin);
        $query = $this->db->get($table);
        return $query->result_array();
    }
	
	public function get_where_with_where_not_in_rand_limit1($where = [],$key,$wherenotin,$table = '')
    {   
        $this->db->where($where);
        $this->db->where_not_in($key,$wherenotin);
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $query = $this->db->get($table);
		//cho $this->db->last_query(); exit();
        return $query->result_array();
    }
	
	 //////////////////////  search api  /////////////////////////////

    function make_query($user_id,$latitude,$longitude,$search_text,$groupby,$value)
    {		
  		if($latitude!='' && $longitude!='')
        { 
			$query ="SELECT product.* 
							, ( 6371 * 
									ACOS( 
										COS( RADIANS( vendor.latitude ) ) * 
										COS( RADIANS( '".$latitude."' ) ) * 
										COS( RADIANS( '".$longitude."' ) - 
										RADIANS( vendor.longitude ) ) + 
										SIN( RADIANS( vendor.latitude ) ) * 
										SIN( RADIANS( '".$latitude."') ) 
									) 
								) 
								AS distance
								FROM product 
								LEFT JOIN  `vendor` ON  `product`.`user_id` =  `vendor`.`user_id`
								WHERE product.is_active = '1' AND product.is_delete = '0' ";
		}
		else
		{
			$query ="SELECT product.* , '0' as distance 
								FROM product 
								LEFT JOIN  `vendor` ON  `product`.`user_id` =  `vendor`.`user_id`
								WHERE product.is_active = '1' AND product.is_delete = '0' ";
		}	
		
        if($search_text!='')
        {
            $query .=" AND product.product_name LIKE '%".$search_text."%'";
        }
		
		if($value!='')
		{
			$query.=" AND product.user_id = '".$value."'" ;
		}
		
		if($groupby!='')
		{
			$query.=" GROUP BY ".$groupby ;
		}
		
		if($latitude!='' && $longitude!='')
        {   
            $distance = $this->get_where_single(array('setting_id'=>'1'),'general_setting');
            $search_distance = $distance->nearby_distance_km;  

            $query .=" having distance <= ".$search_distance."  order by distance ";
        }
		
		
        return $query;
    }


    function get_search_getlter($user_id,$latitude,$longitude,$search_text,$groupby,$value)
    {   
        $query = $this->make_query($user_id,$latitude,$longitude,$search_text,$groupby,$value);
        $data = $this->db->query($query);
		//echo $this->db->last_query();exit;
        return $data->result_array();
    }

    ////////////////////////   search  end ////////////////////////////////


    //////////////////////  booking time vehicle list search api  /////////////////////////////

    function make_query1($weight,$weight_type,$height,$width,$length,$size_type,$vehicle_type_id)
    {   
       
        $query =" SELECT gz_vehicle.* FROM gz_vehicle 
                  WHERE `gz_vehicle`.`is_active` = '1' AND `gz_vehicle`.`is_delete` = '0' ";

        
        if($weight!=null && $weight_type!=null)
        {
            $query .=" AND gz_vehicle.weight  >= '".$weight."'";
            $query .=" AND gz_vehicle.weight_type  = '".$weight_type."'";
        }


        if($height!=null && $width!=null && $length!=null && $size_type!=null)
        {
            $query .=" AND gz_vehicle.height  >= '".$height."'";
            $query .=" AND gz_vehicle.width  >= '".$width."'";
            $query .=" AND gz_vehicle.length  >= '".$length."'";
            $query .=" AND gz_vehicle.size_type  = '".$size_type."'";
        }
        
        if($vehicle_type_id!=null)
        {
            $query .=" AND gz_vehicle.vehicle_type_id = '".$vehicle_type_id."'";
        }

        
        return $query;
    }


    function search_member($weight,$weight_type,$height,$width,$length,$size_type,$vehicle_type_id)
    {   
        $query = $this->make_query1($weight,$weight_type,$height,$width,$length,$size_type,$vehicle_type_id);
        //$query .= ' LIMIT '.$start.','.$limit;
        $data = $this->db->query($query);
        //echo $this->db->last_query();exit;
        return $data->result_array();
    }

    //////////////////////  booking time vehicle list search api end  /////////////////////////////

}