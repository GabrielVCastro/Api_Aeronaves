<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piloto extends CI_Controller {

 	public function index(){

 		//listar aeronaves
 		$this->load->model("Piloto_model", "piloto");
		
		$pilotos = $this->piloto->listar()->get()->result();
 		if (count($pilotos)>0){ 
 			echo json_encode($pilotos);
			
			
 		}else{
 			echo json_encode(array(
 				"success" => false,
 				"msg" => "Não existe Piloto cadastrado"
 			


 			));
 			exit;
 		}
		


		$this->load->view('piloto/index');

	}


	public function cadastrar(){
	
		$post = json_decode(file_get_contents('php://input'));


		if ((!isset($post->nome)) || ($post->nome=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "nome teste"
			));
			exit;
		}

		if ((!isset($post->sobre_nome)) || ($post->sobre_nome=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "nome indefinido"
			));
			exit;
		}


		if (!isset($post->cpf)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "cpf indefinido"
			));
			exit;
		}

		// Verifica se um número foi informado
		if(empty($post->cpf)) {
			return false;
		}

		// Elimina possivel mascara
		$cpf_1 = preg_replace("/[^0-9]/", "", $post->cpf);
		$cpf_2 = str_pad($cpf_1, 11, '0', STR_PAD_LEFT);
		
		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf_2) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf_2 == '00000000000' || 
			$cpf_2 == '11111111111' || 
			$cpf_2 == '22222222222' || 
			$cpf_2 == '33333333333' || 
			$cpf_2 == '44444444444' || 
			$cpf_2 == '55555555555' || 
			$cpf_2 == '66666666666' || 
			$cpf_2 == '77777777777' || 
			$cpf_2 == '88888888888' || 
			$cpf_2 == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			
			for ($t = 9; $t < 11; $t++) {
				
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf_2{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf_2{$c} != $d) {
					return false;
				}
			}

			
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
				"msg" => "sexo de nascimento indefinido"
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



		if ((!isset($post->ultimo_exame)) || ($post->ultimo_exame=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "último exame indefinido"
			));
			exit;
		}
		$ano = substr($post->ultimo_exame, 0,4);
		if ($ano<1950) {
			echo json_encode(array(
				"success" => false,
				"msg" => "último exame invalido"
			));
			exit;
		}

		$mes = substr($post->ultimo_exame, 5,2);

		$dia = substr($post->ultimo_exame, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "último exame indefinido"
			));
			exit;
		}


		if ((!isset($post->telefone)) || ($post->telefone=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimen indefinido"
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

		$this->load->model("Piloto_model", "piloto");

		$piloto = array(
			"nome" => $post->nome,
			"sobre_nome" => $post->sobre_nome,
			"cpf" => $cpf_2,
			"data_nascimento" => $post->data_nascimento,
			"sexo" => $post->data_nascimento,
			"qualificacao" => $post->qualificacao,
			"ultimo_exame" => $post->ultimo_exame,
			"telefone" => $telefone3,
			"status" => $post->status

		);

		if ($this->piloto->cadastrar($piloto)) {
			echo json_encode(array(
				"success" => true,
				"msg" => "cadastrado com sucesso"
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "Piloto já cadastrado "
			));
			exit;
		}

	}


	public function editar(){

		$post = json_decode(file_get_contents('php://input'));

		if ((!isset($post->id)) || ($post->id=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "id invalido"
			));
			exit;
		}

		if ((!isset($post->nome)) || ($post->nome=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "nome teste"
			));
			exit;
		}

		if ((!isset($post->sobre_nome)) || ($post->sobre_nome=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "nome indefinido"
			));
			exit;
		}


		if (!isset($post->cpf)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "cpf indefinido"
			));
			exit;
		}

		// Verifica se um número foi informado
		if(empty($post->cpf)) {
			return false;
		}

		// Elimina possivel mascara
		$cpf_1 = preg_replace("/[^0-9]/", "", $post->cpf);
		$cpf_2 = str_pad($cpf_1, 11, '0', STR_PAD_LEFT);
		
		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf_2) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf_2 == '00000000000' || 
			$cpf_2 == '11111111111' || 
			$cpf_2 == '22222222222' || 
			$cpf_2 == '33333333333' || 
			$cpf_2 == '44444444444' || 
			$cpf_2 == '55555555555' || 
			$cpf_2 == '66666666666' || 
			$cpf_2 == '77777777777' || 
			$cpf_2 == '88888888888' || 
			$cpf_2 == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			
			for ($t = 9; $t < 11; $t++) {
				
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf_2{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf_2{$c} != $d) {
					return false;
				}
			}

			
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
				"msg" => "sexo de nascimento indefinido"
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



		if ((!isset($post->ultimo_exame)) || ($post->ultimo_exame=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "último exame indefinido"
			));
			exit;
		}
		$ano = substr($post->ultimo_exame, 0,4);
		if ($ano<1950) {
			echo json_encode(array(
				"success" => false,
				"msg" => "último exame invalido"
			));
			exit;
		}

		$mes = substr($post->ultimo_exame, 5,2);

		$dia = substr($post->ultimo_exame, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "último exame indefinido"
			));
			exit;
		}


		if ((!isset($post->telefone)) || ($post->telefone=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de nascimen indefinido"
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

		$this->load->model("Piloto_model", "piloto");

		$piloto = array(
			"nome" => $post->nome,
			"sobre_nome" => $post->sobre_nome,
			"cpf" => $cpf_2,
			"data_nascimento" => $post->data_nascimento,
			"sexo" => $post->data_nascimento,
			"qualificacao" => $post->qualificacao,
			"ultimo_exame" => $post->ultimo_exame,
			"telefone" => $telefone3,
			"status" => $post->status

		);


		
		if ($this->piloto->editar($post->id, $piloto)) {
			echo json_encode(array(
				"success" => true,
				"msg" => "editado com sucesso"
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "Erro ao tentar editar"
			));
			exit;
		}



	}


	public function ativar_desativar(){
		$this->load->model("Piloto_model", "piloto");
		if ((!isset($_GET['ativar_desativar'])) || ($_GET['ativar_desativar']=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "usuário não existe"
			));
			exit;
		}

		$piloto = $this->piloto->ativar_desativar($_GET['ativar_desativar']);
		if ($piloto[0]->status=="A") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Piloto ativado"
			));
			exit;
		}
		if ($piloto[0]->status=="D") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Piloto desativado"
			));
			exit;
		}

	}



}	