<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Forget_password extends CI_Controller

{

	// Forget_password

	public function index()
	{
	}

	// SEND EMAIL TO CUSTOMERS WHO FORGET THERE PASSWORD INCLUDING HASHED CODE
	// Forget_password/Forget_password

	public function forget_password_send_email_user()
	{
		$user_email = html_escape($this->input->post('user_email'));
		if (!empty($user_email)) {

			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS

			$this->load->model('Crud_model');
			$fetch_record = $this->Crud_model->recover_password('mp_customer', $user_email, 'cus_email');
			if (!empty($fetch_record)) {
				$email_desc = 'Click here to confirm password ' . base_url('login/get_password_recover_user') . ' Kode Email anda adalah : ' . $fetch_record[0]->cus_password;

				$cname = $this->db->get_where('mp_langingpage', array(
					'id' => 1
				))->result_array()[0]['companyname'];
				$serv = $this->Crud_model->email_config();
				$config['protocol']    = 'smtp';
				$config['smtp_host']    = $serv['url_'];
				$config['smtp_port']    = '587';
				$config['smtp_timeout'] = '60';
				$config['smtp_user']    = $serv['username'];    //Important
				$config['smtp_pass']    = $serv['key'];  //Important
				$config['charset']    = 'utf-8';
				$config['newline']    = '\r\n';
				$config['mailtype'] = 'html'; // or html
				$config['validation'] = TRUE; // bool whether to validate email or not 
				$send['config'] = $config;
				$this->email->initialize($config);

				$this->email->from($serv['username'], $cname);
				$this->email->to($user_email);
				$this->email->subject("Lupa Password ");
				$this->email->message($email_desc);
				$result = $this->email->send();
				if ($result == 1) {
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Email berhasil dikirim',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				} else {
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Email gagal dikirim',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			} else {
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alamat email tidak valid',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		} else {
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Masukkan alamat email',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('Main/');
	}

	// REDIRECTED TO THIS FUNCTION WHEN ADMIN FORGET ITS PASSWORD
	// /Forget_password/forget_password_administrator

	public function forget_password_administrator()
	{
		$user_email = html_escape($this->input->post('username'));
		if (!empty($user_email)) {

			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');
			$fetch_record = $this->Crud_model->recover_password('mp_users', $user_email, 'user_email');
			if (!empty($fetch_record)) {

				$email_desc = 'Klik disini untuk konfirmasi kata sandi ' . base_url('login/get_password_recover') . ' Kode email anda adalah : ' . $fetch_record[0]->user_password;

				$cname = $this->db->get_where('mp_langingpage', array(
					'id' => 1
				))->result_array()[0]['companyname'];

				$serv = $this->Crud_model->email_config();
				$config['protocol']    = 'smtp';
				$config['smtp_host']    = $serv['url_'];
				$config['smtp_port']    = '587';
				$config['smtp_timeout'] = '60';
				$config['smtp_user']    = $serv['username'];    //Important
				$config['smtp_pass']    = $serv['key'];  //Important
				$config['charset']    = 'utf-8';
				$config['newline']    = '\r\n';
				$config['mailtype'] = 'html'; // or html
				$config['validation'] = TRUE; // bool whether to validate email or not 
				$send['config'] = $config;
				$this->email->initialize($config);

				$this->email->from($serv['username'], $cname);
				$this->email->to($user_email);
				$this->email->subject("Lupa Kata Sandi ");
				$this->email->message($email_desc);
				$result = $this->email->send();
				// $result = 1;

				if ($result == 1) {

					echo json_encode(array('error' => false, 'message' => 'Permintaan berhasil, harap cek email untuk konfirmasi!.'));
					return;
				} else {
					echo json_encode(array('error' => true, 'message' => 'Permintaan berhasil, harap cek email untuk konfirmasi!.'));
					return;
				}
			} else {
				echo json_encode(array('error' => true, 'message' => 'Email tidak ditemukan!.'));
				return;
			}
		} else {
			echo json_encode(array('error' => true, 'message' => 'Masukkan email dengan benar!.'));
			return;
		}
		echo json_encode(array('error' => true, 'message' => 'Masukkan email dengan benar!.'));
		return;
		// redirect('Login/');
	}
}
