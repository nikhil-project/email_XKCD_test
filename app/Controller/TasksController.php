<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class TasksController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	  public $components = array('Session', 'Cookie');
/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	function beforeFilter() {
	    parent::beforeFilter();
	    $this->layout = 'ajax';
	 }
	public function index(){
		$token = bin2hex(random_bytes(32));
		$this->Session->Write('token',$token);
		$this->Session->Write('token_expire',time()+3600); //60 min * 60 sec = 3600 
	}
	public function save_data(){
		$this->layout=false;
		$this->autoRender = false;

		if(!empty($this->Session->read('token'))){
			if(time() >= $this->Session->read('token_expire')){
				$this->Session->delete('token');
				$this->Session->delete('token_expire');
			}else{
				if(!empty($this->request->data)){
				 	$name =  !empty($this->data['name'])?$this->data['name']:"";
				 	$email = !empty($this->data['email'])?$this->data['email']:"";
				 	$token = !empty($this->data['token'])?$this->data['token']:"";

				 	if($token == $this->Session->read('token')){
					 	$data = array();
					 	$data["User"]['id'] = '';
					 	$data["User"]['name'] = $name;
					 	$data["User"]['email'] = $email;
					 	$this->loadModel('User');
					 	if($this->User->save($data)){
					 		$emp_id = $this->User->getLastInsertId();
					 	}
						
						$Email = new CakeEmail();
						$Email->config('default');
						$Email->from(array('me@example.com' => 'Testing Purpose'));
						$Email->to($email);
						$Email->subject('Verify Email');
						$body = mt_rand(100000,999999);
						$unique_code = array();
						$unique_code['UniqueCode']['id'] = '';
						$unique_code['UniqueCode']['emp_id'] = $emp_id;
						$unique_code['UniqueCode']['code'] = $body;
						
						$this->loadModel('UniqueCode');
						if($this->UniqueCode->save($unique_code)){
							$latest_code_id = $this->UniqueCode->getLastInsertId();

							$Email->send($body);
							echo $latest_code_id; exit;
						}
				 	}
				}
			}
		}
	}

	public function verify_otp(){
		$this->layout=false;
		$this->autoRender = false;
		if(!empty($this->request->data)){
			$otp = !empty($this->data['otp'])?$this->data['otp']:"";
			$code_id = !empty($this->data['code_id'])?$this->data['code_id']:"";
			$this->loadModel('UniqueCode');
			$otp_verify = $this->UniqueCode->find('first',array('conditions'=>array('UniqueCode.id'=>$code_id,'UniqueCode.code'=>$otp)));
			if(!empty($otp_verify)){
				echo 'Verified'; exit;
			}else{
				echo 'Invalid Otp'; exit;
			} 
		}
	}

	public function send_xkcd_image(){
		$this->layout=false;
		$this->autoRender = false;
		$url = 'https://c.xkcd.com/random/comic'; // Url which need to be hit at every request
		$file_array = file($url); // converting the content of the url into an array

		// 69 is the key where we are getting the comic id from the url
		$comic_id_content = $file_array[69]; // here we are getting the string having the comic id
		$extract_comic_url = substr($file_array[69],30); // we will get exact url with id
		$extract_comic_url =  trim(strip_tags($extract_comic_url));
		/*converting the url to api url to fetch the data*/
		$build_url = $extract_comic_url.'info.0.json';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $build_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// echo $response;exit;
		$data = json_decode($response);
		// pr($data); exit;

		if(!empty($this->data['code_id'])){
			$this->loadModel('UniqueCode');
			$emp_id = $this->UniqueCode->find('first',array('conditions'=>array('id'=>$this->data['code_id'])));

			if(!empty($emp_id)){
				$this->loadModel('User');
				$email = $this->User->find('first',array('conditions'=>array('id'=>$emp_id['UniqueCode']['emp_id'])));
				if(!empty($email)){
					$email_address= $email['User']['email'];
				}
			}
		}

		$Email = new CakeEmail();
		$Email->config('default');
		$Email->from(array('me@example.com' => 'Testing Purpose'));
		$Email->to($email_address);
		$Email->subject($data->safe_title);

		$url = $data->img;
		$build_img_url = explode('/',$url);
		$img = WWW_ROOT.'/img/'.$build_img_url[4];
		file_put_contents($img, file_get_contents($url));

		
		$Email->attachments($img);	

		$body = $data->transcript . $data->alt;
		if($Email->send($body)){
			echo '1'; exit;
		}else{
			echo '0'; exit;
		}
		
	}
	
}
