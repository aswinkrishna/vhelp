<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HAuth extends CI_Controller {

	public function __construct()
	{
		// Constructor to auto-load HybridAuthLib
		parent::__construct();
	//	$this->load->library('HybridAuthLib');
	
require(APPPATH."/third_party/hybridauth/vendor/autoload.php");
	$this->load->library('hybridauth');
	
	$this->load->model('website/M_user');
	//exit;
	}
	
	public function pp() {
	    $providers = array();
    foreach ($this->hybridauth->HA->getProviders() as $provider_id => $params)
    {
      $providers[] = anchor("hauth/login/{$provider_id}", $provider_id);
    }
    echo '<pre>';print_r($providers);
	}

	public function index()
	{
		// Send to the view all permitted services as a user profile if authenticated
	/*	$login_data['providers'] = $this->hybridauthlib->getProviders();
		foreach($login_data['providers'] as $provider=>$d) {
			if ($d['connected'] == 1) {
				$login_data['providers'][$provider]['user_profile'] = $this->hybridauthlib->authenticate($provider)->getUserProfile();
			}
		}*/
		
		
		
		//print_r($_REQUEST);
		 $adapter = $this->hybridauth->HA->authenticate('Google', $_REQUEST['code']);
            $profile = $adapter->getUserProfile();
		
		echo print_r($profile, 1);
		//var_dump($profile);

	//	$this->load->view('hauth/home', $login_data);
	}

	public function login($provider_id)
	{
	   // echo '<pre>';print_r($_REQUEST);exit;
    /*$params = array(
      'hauth_return_to' => site_url("hauth/login/{$provider_id}"),
    );*/
    if (isset($_REQUEST['code']))
    {
      $params['openid_identifier'] = $_REQUEST['code'];
    }
    try
    {
        //echo $provider_id;
        if($provider_id=='Google')
        {
             $adapter = $this->hybridauth->HA->authenticate('Google');
             $profile = $adapter->getUserProfile();
              if($profile->email!="") 
        {
           // echo 1;
          $res =  $this->M_user->saveSocialLogin($profile);
          if($res>0)
          {
              redirect(base_url()."my-account");
          }
          else
          {
               redirect(base_url());
          }
            
        }
        }
        else
        {
            // echo 1;
             $adapter = $this->hybridauth->HA->authenticate('Facebook');
             $profile = $adapter->getUserProfile();
             
          $res =  $this->M_user->saveSocialLogin($profile);
          if($res>0)
          {
              redirect(base_url()."my-account");
          }
          else
          {
               redirect(base_url());
          }
             
           //  print_r($profile);
           // exit;
        }
      
     /* $this->load->view('hauth/done', array(
        'profile' => $profile,
      ));*/
      
     	//echo print_r($profile, 1);
     //if()
    // print_r($profile);
       
    }
        catch (Exception $e)
        {
          show_error($e->getMessage());
        }
	}

	public function endpoint()
	{
	   $this->hybridauth->process();

	}
}

/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */
