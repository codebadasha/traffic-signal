<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrafficSignal extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('General_model' ,'gen_model');
    }
	
	public function index()
	{
        $data['records'] = $this->gen_model->get_where(array('is_delete' =>'0'),'signal_records');
    
		$this->load->view('traffic_signal',$data);
	}

    public function start_signal(){
        $greenInterval = $_POST['greenInterval'];
        $yellowInterval = $_POST['yellowInterval'];
        $signalIndex = $_POST['signalIndex'];

        $insertData = array(
            'green_signal_interval' => $greenInterval,
            'yellow_signal_interval' => $yellowInterval,
            'signal_a' => $signalIndex[0],
            'signal_b' => $signalIndex[1],
            'signal_c' => $signalIndex[2],
            'signal_d' => $signalIndex[3],
        );
        $data = $this->gen_model->insert_data($insertData, 'signal_records');
  

        if($data){
            $output =array(
                'status' => '1',
                'greenInterval'=> $greenInterval,
                'yellowInterval'=> $yellowInterval,
                'signalIndex'=> $signalIndex,
            );
        }
        else{
            $output =array(
                'status' => '0',
                'greenInterval'=> '',
                'yellowInterval'=> '',
                'signalIndex'=> [],
            );
        }
       
        echo json_encode($output);
    }

    public function stop_signal(){

        $insertData = array(
            'is_delete' => '0'
        );
        $data = $this->gen_model->delete_soft($insertData,'signal_records');
  
        if($data){
            $output =array(
                'status' => '1',
                'data'=>$data,
            );
        }
        else{
            $output =array(
                'status' => '0',
            );
        }
       
        echo json_encode($output);
    }
}
