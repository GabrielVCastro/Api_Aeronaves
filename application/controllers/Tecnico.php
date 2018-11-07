<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnico extends CI_Controller {

 	public function index(){
 		$this->load->model("Tecnico_model", "tecnico");


 		if ($this->tecnico->listar()) {
 			$tecnicos = $this->tecnico->listar();
 			echo json_encode($tecnicos);
			
			
 		}else{
 			echo json_encode(array(
 				"success" => false,
 				"msg" => "Não existe tecnico cadastrado"
 			


 			));
 			exit;
 		}
 	}


 	public function cadastrar(){
		$post = json_decode(file_get_contents('php://input'));

		if ((!isset($post->nome)) || ($post->nome=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Nome indefinido"
			));
			exit;
		}



		if ((!isset($post->data_nascimento)) || ($post->data_nascimento=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimento indefinido"
			));
			exit;
		}
		$ano = substr($post->data_nascimento, 0,4);
		if ($ano<1950) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimento invalida"
			));
			exit;
		}
		
		
		$mes = substr($post->data_nascimento, 5,2);

		$dia = substr($post->data_nascimento, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimento indefinido"
			));
			exit;
		}


		if ((!isset($post->sexo)) || ($post->sexo=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "sexo indefinido"
			));
			exit;
		}
		if (($post->sexo!="M") && ($post->sexo)!="F") {
			echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
			));
			exit;
		}



		if ((!isset($post->naturalidade)) || ($post->naturalidade=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "naturalidade indefinida"
			));
			exit;
		}

		if (strlen($post->naturalidade)>100) {
			echo json_encode(array(
				"success" => false,
				"msg" => "naturalidade invalidada"
			));
			exit;
		}



		if((!isset($post->exame_medico)) || ($post->exame_medico=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico indefinido"
			));
			exit;
		}
		$ano = substr($post->exame_medico, 0,4);
		$tempo_atual = strtotime(date('Y/m/d'));

		$tempo = strtotime(substr($post->exame_medico, 0,10));
		if ($tempo>$tempo_atual) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}
		if ($ano<1950) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}
	

		$mes = substr($post->exame_medico, 5,2);

		$dia = substr($post->exame_medico, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}



		if((!isset($post->qualificacao)) || ($post->qualificacao=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico indefinido"
			));
			exit;
		}



		if ((!isset($post->telefone)) || ($post->telefone=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "telefone indefinido"
			));
			exit;
		}
		if (!preg_match('#^\(\d{2}\) 9?[6789]\d{3}-\d{4}$#', $post->telefone)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "telefone indefinido"
			));
			exit;
		}

		if ((!isset($post->endereco)) || ($post->endereco=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "endereço indefinido"
			));
			exit;
		}


		if ((!isset($post->status)) || ($post->status=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "endereço indefinido"
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

		$telefone = str_replace("(", "", $post->telefone);
		$telefone1 = str_replace(")", "", $telefone);
		$telefone2 = str_replace("-", "", $telefone1);
		$telefone3 = str_replace(" ", "", $telefone2);

		$this->load->model("Tecnico_model", "tecnico");

		$tecnico = array(
			"nome" => $post->nome,
			"data_nascimento" => $post->data_nascimento,
			"sexo" => $post->sexo,
			"exame_medico" => $post->exame_medico,
			"qualificacao" => $post->qualificacao,
			"telefone" => $telefone3,
			"endereco" => $post->endereco,
			"status" => $post->status
		);
		
		if ($this->tecnico->cadastrar($tecnico)) {
			echo json_encode(array(
				"success" => true,
				"msg" => "cadastrado com sucesso"
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "Tecnico já cadastrado "
			));
			exit;
		}

 	}	

 	public function editar(){
 		$post = json_decode(file_get_contents('php://input'));


		if ((!isset($post->id)) || ($post->id=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Nome indefinido"
			));
			exit;
		}


		if ((!isset($post->nome)) || ($post->nome=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Nome indefinido"
			));
			exit;
		}



		if ((!isset($post->data_nascimento)) || ($post->data_nascimento=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimento indefinido"
			));
			exit;
		}
		$ano = substr($post->data_nascimento, 0,4);
		if ($ano<1950) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimento invalida"
			));
			exit;
		}
		
		
		$mes = substr($post->data_nascimento, 5,2);

		$dia = substr($post->data_nascimento, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimento indefinido"
			));
			exit;
		}


		if ((!isset($post->sexo)) || ($post->sexo=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "sexo indefinido"
			));
			exit;
		}
		if (($post->sexo!="M") && ($post->sexo)!="F") {
			echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
			));
			exit;
		}



		if ((!isset($post->naturalidade)) || ($post->naturalidade=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "naturalidade indefinida"
			));
			exit;
		}

		if (strlen($post->naturalidade)>100) {
			echo json_encode(array(
				"success" => false,
				"msg" => "naturalidade invalidada"
			));
			exit;
		}



		if((!isset($post->exame_medico)) || ($post->exame_medico=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico indefinido"
			));
			exit;
		}
		$ano = substr($post->exame_medico, 0,4);
		$tempo_atual = strtotime(date('Y/m/d'));

		$tempo = strtotime(substr($post->exame_medico, 0,10));
		if ($tempo>$tempo_atual) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}
		if ($ano<1950) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}
	

		$mes = substr($post->exame_medico, 5,2);

		$dia = substr($post->exame_medico, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}



		if((!isset($post->qualificacao)) || ($post->qualificacao=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico indefinido"
			));
			exit;
		}



		if ((!isset($post->telefone)) || ($post->telefone=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "telefone indefinido"
			));
			exit;
		}
		if (!preg_match('#^\(\d{2}\) 9?[6789]\d{3}-\d{4}$#', $post->telefone)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "telefone indefinido"
			));
			exit;
		}

		if ((!isset($post->endereco)) || ($post->endereco=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "endereço indefinido"
			));
			exit;
		}


		if ((!isset($post->status)) || ($post->status=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "endereço indefinido"
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

		$telefone = str_replace("(", "", $post->telefone);
		$telefone1 = str_replace(")", "", $telefone);
		$telefone2 = str_replace("-", "", $telefone1);
		$telefone3 = str_replace(" ", "", $telefone2);
		$this->load->model("Tecnico_model", "tecnico");

		$tecnico = array(
			"nome" => $post->nome,
			"data_nascimento" => $post->data_nascimento,
			"sexo" => $post->sexo,
			"exame_medico" => $post->exame_medico,
			"qualificacao" => $post->qualificacao,
			"telefone" => $telefone3,
			"endereco" => $post->endereco,
			"status" => $post->status
		);

		


	
		if ($this->tecnico->editar($post->id ,$tecnico)) {
 			echo json_encode(array(
 				"success" => true,
 				"msg" => "Tecnico editado com sucesso"
 			));
 		}else{
			echo json_encode(array(
 				"success" => false,
 				"msg" => "ERRO AO TENTAR EDITAR"
 			));
 		}
	 	
	 }


	public function ativar_desativar(){
		$this->load->model("Tecnico_model", "tecnico");
		if ((!isset($_GET['ativar_desativar'])) || ($_GET['ativar_desativar']=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "usuário não existe"
			));
			exit;
		}

		$tecnico = $this->tecnico->ativar_desativar($_GET['ativar_desativar']);
		if ($tecnico[0]->status=="A") {
			echo json_encode(array(
				"success" => false,
				"msg" => "tecnico ativado"
			));
			exit;
		}
		if ($tecnico[0]->status=="D") {
			echo json_encode(array(
				"success" => false,
				"msg" => "tecnico desativado"
			));
			exit;
		}

	}

} 		