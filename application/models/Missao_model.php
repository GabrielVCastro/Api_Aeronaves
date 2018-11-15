<?php  

class Missao_model extends CI_Model {

	public function listar(){  
		$this->db->select("missao.id, missao.* , piloto.nome as piloto, copiloto.nome as copiloto, aeronave.prefixo");
    	$this->db->join("piloto", "missao.id_piloto = piloto.id");
    	$this->db->join("piloto copiloto", "missao.id_copiloto = copiloto.id");
   		$this->db->join("aeronave", "missao.id_aeronave = aeronave.id");
  		return $this->db->get("missao")->result();
		
	}

	public function verificar_piloto($id_piloto){
		if($this->db->select("*")->from("piloto")->where("id", $id_piloto)->get()->num_rows()==0){
			return true;
		}
		return false;
	
	}
//VERIFICAR SE EXISTEM
	public function verificar_copiloto($id_copiloto){
		if($this->db->select("*")->from("piloto")->where("id", $id_copiloto)->get()->num_rows()==0){
			return true;
		}
		return false;
		
	}
	public function verificar_aeronave($id_aeronave){
		if($this->db->select("*")->from("aeronave")->where("id", $id_aeronave)->get()->num_rows()==0){
			return true;
		}
		return false;
		
	}



//Vericar se nao estao em 2 missao ao msm tempo------

	public function piloto($id_piloto){

		$this->db->select("missao.*,  piloto.cpf as piloto");
    	$this->db->join("piloto", "missao.id_piloto = piloto.id");
    	$this->db->where("missao.id_piloto", $id_piloto);
    	return $this->db->get("missao")->result();

	
	}

	public function copiloto($id_copiloto){

		$this->db->select("missao.*,  piloto.cpf as copiloto");
    	$this->db->join("piloto", "missao.id_copiloto = piloto.id");
    	$this->db->where("missao.id_copiloto", $id_copiloto);
    	return $this->db->get("missao")->result();

	
	}

	public function aeronave($id_aeronave){

		$this->db->select("missao.*,  aeronave.prefixo as prefixo");
    	$this->db->join("aeronave", "missao.id_aeronave = aeronave.id");
    	$this->db->where("missao.id_aeronave", $id_aeronave);
    	return $this->db->get("missao")->result();

	}

	public function identidade($id_piloto, $id_copiloto, $id_aeronave){

		$this->db->select("piloto.qualificacao as piloto, copiloto.qualificacao as copiloto, aeronave.tipo as aeronave_tipo");
		$this->db->from("piloto, piloto as copiloto , aeronave");
        $this->db->where("piloto.id", $id_piloto);
        $this->db->where("copiloto.id", $id_copiloto);
        $this->db->where("aeronave.id", $id_aeronave);
       
		return $this->db->get()->result();

	} 


	public function cadastrar($missao){

		return $this->db->insert("missao", $missao);
	}

	//Vericiar se existem em outra missao antes de cadastrar

	public function verificar_piloto_editar($id_piloto, $id_missao){	
	
		$this->db->select("missao.id ,missao.data_partida, missao.data_chegada ");
    	$this->db->join("piloto", "missao.id_piloto = piloto.id");
    	if ($this->db->where("missao.id <>", $id_missao)) {
    		$this->db->where("missao.id_piloto", $id_piloto);
    		return $this->db->get("missao")->result();
    	}
	} 

	public function verificar_copiloto_editar($id_copiloto, $id_missao){	
	
		$this->db->select("missao.id ,missao.data_partida, missao.data_chegada ");
    	$this->db->join("piloto", "missao.id_copiloto = piloto.id");
    	if ($this->db->where("missao.id <>", $id_missao)) {
    		$this->db->where("missao.id_copiloto", $id_copiloto);
    		return $this->db->get("missao")->result();
    	}
	}

	//Editar missao por fim ...

	public function editar($id ,$missao){
		$this->db->where("id", $id);
		return $this->db->update("missao", $missao);
	}




	//Excluir missao


	public function excluir($id){
	if($this->db->select("*")->from("missao")->where("id", $id)->get()->num_rows()==0){
			return false;
	}
		$this->db->where("id", $id);
		return $this->db->delete("missao");

	}	 



}	
