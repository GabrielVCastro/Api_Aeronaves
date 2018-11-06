<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aeronave extends CI_Controller {

 	public function index(){

 		//listar aeronaves
 		$this->load->model("Aeronave_model", "aeronave");

 		if ($this->aeronave->listar()) {
 			$aeronaves = $this->aeronave->listar();
 			echo json_encode($aeronaves);
			
			
 		}else{
 			echo json_encode(array(
 				"success" => false,
 				"msg" => "Não existe aeronave cadastrada"
 			


 			));
 			exit;
 		}
		


		$this->load->view('aeronave/index');

	}

	public function cadastrar(){
	
		$post = json_decode(file_get_contents('php://input'));


		//Validação do formulario
	
		if ((!isset($post->prefixo)) || ($post->prefixo=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Prefixo indefinido"
			));
			exit;
		}
		if((strlen($post->prefixo)<5) && (strlen($post->prefixo)>12)){
			echo json_encode(array(
				"success" => false,
				"msg" => "Tamanho do prefixo incorreto"
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
		if ((strlen($post->tipo)>1)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
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


		if (strlen($post->horas_voo)>8){
			echo json_encode(array(
				"success" => false,
				"msg" => "tamanho incorreto"
			));
			exit;
		}
		if (!is_numeric($post->horas_voo)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Use ponto(.) para separar casa decimal e somente númmeros"
			));
			exit;
		};
	

		if (strlen($post->ano_fabricacao)>4) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tamanho incorreto"
			));
			exit;
		}
		if (!is_numeric($post->ano_fabricacao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
			));
			exit;
		};


		if ((!isset($post->status)) || ($post->status=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tipo indefinido"
			));
			exit;
		}
		if ((strlen($post->status)>1)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
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

		$this->load->model("Aeronave_model", "aeronave");


		$aeronave = array(
			"prefixo" => $post->prefixo,
			"tipo" => $post->tipo,
			"horas_voo" => $post->horas_voo,
			"ano_fabricacao" => $post->ano_fabricacao,
			"status" => "A"
 		);

 		if ($this->aeronave->cadastrar($aeronave)) {
 			echo json_encode(array(
 				"success" => true,
 				"msg" => "Aeronave cadastrada com sucesso"
 			));
 		}else{
			echo json_encode(array(
 				"success" => false,
 				"msg" => "Aeronave já cadastrada"
 			));
 		}

	}




	public function editar(){
		$post = json_decode(file_get_contents('php://input'));

		//Validação do formulario


		if ((!isset($post->id)) || ($post->id=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Prefixo indefinido"
			));
			exit;
		}
		if ((!isset($post->prefixo)) || ($post->prefixo=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Prefixo indefinido"
			));
			exit;
		}
		if((strlen($post->prefixo)<5) && (strlen($post->prefixo)>12)){
			echo json_encode(array(
				"success" => false,
				"msg" => "Tamanho do prefixo incorreto"
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
		if ((strlen($post->tipo)>1)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
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


		if (strlen($post->horas_voo)>8){
			echo json_encode(array(
				"success" => false,
				"msg" => "tamanho incorreto"
			));
			exit;
		}
		if (!is_numeric($post->horas_voo)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Use ponto(.) para separar casa decimal e somente númmeros"
			));
			exit;
		};
	

		if (strlen($post->ano_fabricacao)>4) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tamanho incorreto"
			));
			exit;
		}
		if (!is_numeric($post->ano_fabricacao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
			));
			exit;
		};


		if ((!isset($post->status)) || ($post->status=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "tipo indefinido"
			));
			exit;
		}
		if ((strlen($post->status)>1)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "parametro incorreto"
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



		$this->load->model("Aeronave_model", "aeronave");

		$aeronave = array(

			"prefixo" => $post->prefixo,
			"tipo" => $post->tipo,
			"horas_voo" => $post->horas_voo,
			"ano_fabricacao" => $post->ano_fabricacao,
			"status" => $post->status
 		);

		

 		if ($this->aeronave->editar($post->id, $aeronave)) {
 			echo json_encode(array(
 				"success" => true,
 				"msg" => "Aeronave editada com sucesso"
 			));
 		}else{
			echo json_encode(array(
 				"success" => false,
 				"msg" => "Usuário não encontrado"
 			));
 		}



	}

	public function ativar_desativar(){
		$this->load->model("Aeronave_model", "aeronave");
		if ((!isset($_GET['ativar_desativar'])) || ($_GET['ativar_desativar']=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "usuário não existe"
			));
			exit;
		}

		$aeronave = $this->aeronave->ativar_desativar($_GET['ativar_desativar']);
		if ($aeronave[0]->status=="A") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Aeronave ativada"
			));
			exit;
		}
		if ($aeronave[0]->status=="D") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Aeronave desativada"
			));
			exit;
		}

	}


}
