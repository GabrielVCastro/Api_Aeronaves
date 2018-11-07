<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manutencao extends CI_Controller {

 	public function index(){
 		$this->load->model("Manutencao_model", "manutencao");


 		if ($this->manutencao->listar()) {
 			$manutencoes = $this->manutencao->listar();
 			echo json_encode($manutencoes);
			
			
 		}else{
 			echo json_encode(array(
 				"success" => false,
 				"msg" => "Não existe manutenção cadastrada"
 			


 			));
 			exit;
 		}
 	}


 	public function cadastrar(){
 		$post = json_decode(file_get_contents('php://input'));

		if ((!isset($post->id_tecnico)) || ($post->id_tecnico=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tecnico indefinido"
			));
			exit;
		}


		if ((!isset($post->id_aeronave)) || ($post->id_aeronave=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "aeronave indefinida"
			));
			exit;
		}


		if ((!isset($post->tipo)) || ($post->tipo=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tipo indefinido"
			));
			exit;
		}
		if (($post->tipo!="P") && ($post->tipo)!="C") {
			echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
			));
			exit;
		}



		if ((!isset($post->data_hora)) || ($post->data_hora=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data indefinida"
			));
			exit;
		}
		
		$ano = substr($post->data_hora, 0,4);
		$tempo_atual = strtotime(date('Y/m/d'));

		$tempo = strtotime(substr($post->data_hora, 0,10));
		if ($tempo>$tempo_atual) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}
		
		
		$mes = substr($post->data_hora, 5,2);

		$dia = substr($post->data_hora, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data  indefinida"
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

		$this->load->model("Manutencao_model", "manutencao");

		$manutencao = array(
			"id_tecnico" => $post->id_tecnico,
			"id_aeronave" => $post->id_aeronave,
			"tipo" => $post->tipo,
			"data_hora" => $post->data_hora,
			"status" => $post->status

		);

		if ($this->manutencao->cadastrar($manutencao)) {
			echo json_encode(array(
				"success" => true,
				"msg" => "cadastrado com sucesso"
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "erro "
			));
			exit;
		}

 	}



 	public function editar(){
 		$post = json_decode(file_get_contents('php://input'));

 		if ((!isset($post->id)) || ($post->id=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tecnico indefinido"
			));
			exit;
		}


 		if ((!isset($post->id_tecnico)) || ($post->id_tecnico=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tecnico indefinido"
			));
			exit;
		}


		if ((!isset($post->id_aeronave)) || ($post->id_aeronave=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "aeronave indefinida"
			));
			exit;
		}


		if ((!isset($post->tipo)) || ($post->tipo=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tipo indefinido"
			));
			exit;
		}
		if (($post->tipo!="P") && ($post->tipo!="C")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
			));
			exit;
		}



		if ((!isset($post->data_hora)) || ($post->data_hora=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data indefinida"
			));
			exit;
		}
		
		$ano = substr($post->data_hora, 0,4);
		$tempo_atual = strtotime(date('Y/m/d'));

		$tempo = strtotime(substr($post->data_hora, 0,10));
		if ($tempo>$tempo_atual) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data do ultimo exame medico invalida"
			));
			exit;
		}
		
		
		$mes = substr($post->data_hora, 5,2);

		$dia = substr($post->data_hora, 8,2);

		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data  indefinida"
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

		$this->load->model("Manutencao_model", "manutencao");

		$manutencao = array(
			"id_tecnico" => $post->id_tecnico,
			"id_aeronave" => $post->id_aeronave,
			"tipo" => $post->tipo,
			"data_hora" => $post->data_hora,
			"status" => $post->status

		);

		if ($this->manutencao->editar($post->id ,$manutencao)){
			echo json_encode(array(
				"success" => true,
				"msg" => "EDITADO com sucesso"
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "ERRO"
			));
			exit;
		}
 	}

 	public function ativar_desativar(){
		$this->load->model("Manutencao_model", "manutencao");
		if ((!isset($_GET['ativar_desativar'])) || ($_GET['ativar_desativar']=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "manutencao não existe"
			));
			exit;
		}

		$manutencao = $this->manutencao->ativar_desativar($_GET['ativar_desativar']);
		if ($manutencao[0]->status=="A") {
			echo json_encode(array(
				"success" => false,
				"msg" => "manutencao ativada"
			));
			exit;
		}
		if ($manutencao[0]->status=="D") {
			echo json_encode(array(
				"success" => false,
				"msg" => "manutencao desativada"
			));
			exit;
		}

	}
}	