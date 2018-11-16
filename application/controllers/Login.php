<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

 	public function cadastrar(){
		$post = json_decode(file_get_contents('php://input'));

 		$this->load->model("Login_model", "login");


 	
 		//VALIDAR DADOS

 		$password = hash('sha512', hash('sha512', $post->password));
 	

	 	if ((!isset($post->nome)) || ($post->nome=="")) {
				echo json_encode(array(
					"success" => false,
					"msg" => "nome indefinida"
				));
				exit;
		}	
	 

	 	if ((!isset($password)) || ($password=="")) {
				echo json_encode(array(
					"success" => false,
					"msg" => "password indefinida"
				));
				exit;
		}



	 	if ((!isset($post->email)) || ($password=="")) {
				echo json_encode(array(
					"success" => false,
					"msg" => "email indefinida"
				));
				exit;
		}
		//Verificar se é um email
		if(!filter_var($post->email, FILTER_VALIDATE_EMAIL)){
				echo json_encode(array(
					"success" => false,
					"msg" => "email invalido"
				));
				exit;
		}


		if ((!isset($post->status)) || ($post->status=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "status indefinido"
			));
			exit;
		}
		if (($post->status!="A") && ($post->status)!="D") {
			echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
			));
			exit;
		}

		$login = array(
			"nome" => $post->nome,
			"password" => $password,
			"email" => $post->email,
			"status"=> $post->status

 
		);


		if ($this->login->cadastrar($login)){
			echo json_encode(array(
				"success" => true,
				"msg" => "cadastrado com sucesso"
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "erro ao cadastrar"
			));
			exit;
		}
		
	// ToKen :hash('sha512', hash('sha512', $login['nome'].$login['password'].$login['email']));


 	}


 	public function fazer_login(){
 		$post = json_decode(file_get_contents('php://input'));
 		


		if ((!isset($post->email)) || ($post->email=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "email indefinido"
			));
			exit;
		}


		if ((!isset($post->password)) || ($post->password=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "password indefinido"
			));
			exit;
		}
		$this->load->model("Login_model", "login");



		//Criar token
		$dados_token = $this->login->buscar_usuario($post->email);

		if (count($dados_token)==0) {
			echo json_encode(array(
				"success" => false,
				"msg" => "email invalido"
			));
			exit;
		}
		
		if ($dados_token[0]->token==null) {
			$token = hash('sha512',hash('sha512', $dados_token[0]->nome.$dados_token[0]->email.$dados_token[0]->password));
			$login = array(
			"token" =>$token
 
			);
			

		}

		$usuario = array(
			"email" => $post->email,
			"password" => hash('sha512', hash('sha512', $post->password)),
			"token" => $token
		);

		
		if ($this->login->fazer_login($usuario)) {
			echo json_encode(array(
				"success" => true,
				"msg" => "logado",
				"usuario_logado" => $this->login->fazer_login($usuario)
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "Usuário ou senha incorreto"
			));
			exit;
		}

 	}


 	public function fazer_logoff(){
 		$this->load->model("Login_model", "login");

 		$usuario = $this->login->fazer_logoff($_GET['sair']);
 		$novo_token = hash('sha512',hash('sha512', $usuario[0]->nome.$usuario[0]->email.$usuario[0]->password.$usuario[0]->token));

 		$token = array(
 			"id" => $usuario[0]->id,
 			"token" => $novo_token
 		);

 		if ($this->login->editar_token($token)) {
			echo json_encode(array(
				"success" => true,
				"msg" => "editado token"
				
			));
			exit;
 		}else{
				echo json_encode(array(
				"success" => false,
				"msg" => "erro"
				
			));
			exit;
 		}


 	}	


 }	
