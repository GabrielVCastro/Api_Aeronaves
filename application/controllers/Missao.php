<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Missao extends CI_Controller {

 	public function index(){
 		$this->load->model("Missao_model", "missao");


 		if ($this->missao->listar()) {
 			$missoes = $this->missao->listar();
 			echo json_encode($missoes);
			
			
 		}else{
 			echo json_encode(array(
 				"success" => false,
 				"msg" => "Não existe missão cadastrada"
 			


 			));
 			exit;
 		}

 	}

 	public function cadastrar(){
 		$post = json_decode(file_get_contents('php://input'));

 		//VALIDAR DADOS

		if ((!isset($post->data_partida)) || ($post->data_partida=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data indefinida"
			));
			exit;
		}


		if ((!isset($post->data_partida)) || ($post->data_partida=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de partida indefinida"
			));
			exit;
		}
		$ano = substr($post->data_partida, 0,4);
	

		$ano = substr($post->data_partida, 0,4);
		$mes = substr($post->data_partida, 5,2);
		$dia = substr($post->data_partida, 8,2);
		$tempo_atual = strtotime(date('Y/m/d h:i:s'));
		$tempo_partida = strtotime($post->data_partida);

		if ($tempo_partida<$tempo_atual) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de partida invalida"
			));
			exit;
		}
	
		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de partida indefinido"
			));
			exit;
		}



		if ((!isset($post->data_chegada)) || ($post->data_chegada=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada indefinida"
			));
			exit;
		}


		if ((!isset($post->data_chegada)) || ($post->data_chegada=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada  indefinida"
			));
			exit;
		}
		$ano = substr($post->data_chegada, 0,4);
		

		$ano = substr($post->data_chegada, 0,4);
		$mes = substr($post->data_chegada, 5,2);
		$dia = substr($post->data_chegada, 8,2);
		$tempo_atual = strtotime(date('Y/m/d h:i:s'));
		$tempo = strtotime($post->data_chegada);

		if ($tempo<$tempo_partida) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada  invalida"
			));
			exit;
		}
		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada  invalida"
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




		if ((!isset($post->id_piloto)) || ($post->id_piloto=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Piloto indefinido"
			));
			exit;
		}

		$this->load->model("Missao_model", "missao");

		if ($this->missao->verificar_piloto($post->id_piloto)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "Piloto indefinido"
			));
			exit;
		}

		if ($this->missao->verificar_copiloto($post->id_copiloto)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "Copiloto indefinido"
			));
			exit;
		}

		if ($this->missao->verificar_aeronave($post->id_aeronave)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "Aeronave indefinida"
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


		//VERIFICAR piloto,copiloto e eaeronave se nao estão em 2 missões ao msm tempo//

		$piloto = $this->missao->piloto($post->id_piloto);
		
		$data_partida = strtotime($post->data_partida);
		$data_chegada = strtotime($post->data_chegada);
		foreach ($piloto as $item) {
			$data_partida_missao = strtotime($item->data_partida);
			$data_chegada_missao = strtotime($item->data_chegada);
			if (($data_partida>=$data_partida_missao) && ($data_chegada<=$data_chegada_missao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Piloto já esta em missão"
			));
			exit;
			}
			
		}

		$copiloto = $this->missao->copiloto($post->id_copiloto);

		foreach ($copiloto as $item) {
			$data_partida_missao = strtotime($item->data_partida);
			$data_chegada_missao = strtotime($item->data_chegada);
			if (($data_partida>=$data_partida_missao) && ($data_chegada<=$data_chegada_missao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Copiloto já esta em missão"
			));
			exit;
			}
			
		}

		$aeronave = $this->missao->aeronave($post->id_aeronave);
		
		foreach ($aeronave as $item) {
			$data_partida_missao = strtotime($item->data_partida);
			$data_chegada_missao = strtotime($item->data_chegada);
			if (($data_partida>=$data_partida_missao) && ($data_chegada<=$data_chegada_missao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Aeronave já esta em missão"
			));
			exit;
			}
			
		}

		//verificar indentidade Piloto e Copiloto

		$identidade=  $this->missao->identidade($post->id_piloto, $post->id_copiloto, $post->id_aeronave);
		
		if ($identidade[0]->piloto=="C") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Qualificacao incorreta"
			));
			exit;
		}
		if ($identidade[0]->copiloto=="P") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Qualificacao incorreta"
			));
			exit;
		}
		if (($identidade[0]->aeronave_tipo!="P") && ($identidade[0]->aeronave_tipo!="C")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "aeronave indefinida"
			));
			exit;
		}


		$missao = array(
			"data_partida" => $post->data_partida,
			"data_chegada" => $post->data_chegada,
			"tipo" => $post->tipo,
			"id_piloto" => $post->id_piloto,
			"id_copiloto" => $post->id_copiloto,
			"id_aeronave" => $post->id_aeronave,
			"status" => $post->status

		);
	

		if ($this->missao->cadastrar($missao)) {
			echo json_encode(array(
				"success" => true,
				"msg" => "Cadastrado com sucesso"
			));
			exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "Erro ao tentar cadastrar"
			));
			exit;
		}


 	}

 	public function editar(){
 		$post = json_decode(file_get_contents('php://input'));

 		//VALIDAR DADOS

		if ((!isset($post->data_partida)) || ($post->data_partida=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data indefinida"
			));
			exit;
		}


		if ((!isset($post->data_partida)) || ($post->data_partida=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de partida indefinida"
			));
			exit;
		}
		$ano = substr($post->data_partida, 0,4);
	

		$ano = substr($post->data_partida, 0,4);
		$mes = substr($post->data_partida, 5,2);
		$dia = substr($post->data_partida, 8,2);
		$tempo_atual = strtotime(date('Y/m/d h:i:s'));
		$tempo_partida = strtotime($post->data_partida);

		if ($tempo_partida<$tempo_atual) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de partida invalida"
			));
			exit;
		}
	
		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data de partida indefinido"
			));
			exit;
		}



		if ((!isset($post->data_chegada)) || ($post->data_chegada=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada indefinida"
			));
			exit;
		}


		if ((!isset($post->data_chegada)) || ($post->data_chegada=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada  indefinida"
			));
			exit;
		}
		$ano = substr($post->data_chegada, 0,4);
		

		$ano = substr($post->data_chegada, 0,4);
		$mes = substr($post->data_chegada, 5,2);
		$dia = substr($post->data_chegada, 8,2);
		$tempo_atual = strtotime(date('Y/m/d h:i:s'));
		$tempo = strtotime($post->data_chegada);

		if ($tempo<$tempo_partida) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada  invalida"
			));
			exit;
		}
		if (!checkdate($mes, $dia, $ano)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "data chegada  invalida"
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




		if ((!isset($post->id_piloto)) || ($post->id_piloto=="")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "Piloto indefinido"
			));
			exit;
		}

		$this->load->model("Missao_model", "missao");

		if ($this->missao->verificar_piloto($post->id_piloto)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "Piloto indefinido"
			));
			exit;
		}

		if ($this->missao->verificar_copiloto($post->id_copiloto)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "Copiloto indefinido"
			));
			exit;
		}

		if ($this->missao->verificar_aeronave($post->id_aeronave)) {
				echo json_encode(array(
				"success" => false,
				"msg" => "Aeronave indefinida"
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


		//VERIFICAR piloto,copiloto e eaeronave se nao estão em 2 missões ao msm tempo// EDITAR-------------

		$piloto = $this->missao->verificar_piloto_editar($post->id_piloto, $post->id);
		
		$data_partida = strtotime($post->data_partida);
		$data_chegada = strtotime($post->data_chegada);
		


		foreach ($piloto as $item) {
			$data_partida_missao = strtotime($item->data_partida);
			$data_chegada_missao = strtotime($item->data_chegada);
			
			if (($data_partida>=$data_partida_missao) && ($data_partida<=$data_chegada_missao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => " piloto em missao partida"
			));
			exit;
			}
			if (($data_chegada>=$data_partida_missao) && ($data_chegada<=$data_chegada_missao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "piloto em missao chegada"
			));
			exit;
			}

		}


		$copiloto = $this->missao->verificar_copiloto_editar($post->id_copiloto, $post->id);

		foreach ($copiloto as $item) {
			$data_partida_missao = strtotime($item->data_partida);
			$data_chegada_missao = strtotime($item->data_chegada);
			
			if (($data_partida>=$data_partida_missao) && ($data_partida<=$data_chegada_missao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => " copiloto em missao partida"
			));
			exit;
			}
			if (($data_chegada>=$data_partida_missao) && ($data_chegada<=$data_chegada_missao)) {
			echo json_encode(array(
				"success" => false,
				"msg" => "copiloto em missao chegada"
			));	
			exit;
			}

		}

		//verificar indentidade Piloto e Copiloto

		$identidade=  $this->missao->identidade($post->id_piloto, $post->id_copiloto, $post->id_aeronave);
		
		if ($identidade[0]->piloto=="C") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Qualificacao incorreta"
			));
			exit;
		}
		if ($identidade[0]->copiloto=="P") {
			echo json_encode(array(
				"success" => false,
				"msg" => "Qualificacao incorreta"
			));
			exit;
		}
		if (($identidade[0]->aeronave_tipo!="P") && ($identidade[0]->aeronave_tipo!="C")) {
			echo json_encode(array(
				"success" => false,
				"msg" => "aeronave indefinida"
			));
			exit;
		}


		$missao = array(
			"data_partida" => $post->data_partida,
			"data_chegada" => $post->data_chegada,
			"tipo" => $post->tipo,
			"id_piloto" => $post->id_piloto,
			"id_copiloto" => $post->id_copiloto,
			"id_aeronave" => $post->id_aeronave,
			"status" => $post->status

		);

		if ($this->missao->editar($post->id, $missao)) {
			echo json_encode(array(
					"success" => true,
					"msg" => "Missao editada com sucesso"
				));
				exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "erro ao editar missao"
			));
			exit;
		}
 	}



 	//Deleta missao

 	public function excluir(){
 		$this->load->model("Missao_model", "missao");


 		if ((!isset($_GET['excluir'])) || ($_GET['excluir']=="")) {
 			echo json_encode(array(
				"success" => false,
				"msg" => "Dado invalido"
			));
			exit;
 		}

		if ($this->missao->excluir($_GET['excluir'])) {
			echo json_encode(array(
					"success" => true,
					"msg" => "Missao excluida com sucesso"
				));
				exit;
		}else{
			echo json_encode(array(
				"success" => false,
				"msg" => "erro ao excluir missao"
			));
			exit;
		}
 	}
}	
