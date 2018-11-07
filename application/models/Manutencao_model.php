<?php  

class Manutencao_model extends CI_Model {

	public function listar(){  
		$this->db->select("manutencao.*, tecnico.*, aeronave.prefixo");
    	$this->db->join("tecnico", "manutencao.id_tecnico = tecnico.id");
   		$this->db->join("aeronave", "manutencao.id_aeronave = aeronave.id");
  		return $this->db->get("manutencao")->result();
		
	}

	public function cadastrar($manutencao){
		return $this->db->insert("manutencao", $manutencao);
	}

	public function editar($id, $manutencao){
		$this->db->where("id", $id);
		return $this->db->update("manutencao", $manutencao);
	}


	public function ativar_desativar($id){
		$manutencao = $this->db->select("*")->from("manutencao")->where("id", $id)->get()->result();
		if ($manutencao[0]->status=="A") {
			$manutencao = array(
				"status" => "D"
			);
			$this->db->where("id", $id);
			$this->db->update('manutencao', $manutencao);
			return $this->db->select("*")->from("manutencao")->where("id", $id)->get()->result();;
		}

		if ($manutencao[0]->status=="D") {
			$manutencao = array(
				"status" => "A"
			);
			$this->db->where("id", $id);
			$this->db->update('manutencao', $manutencao);
			return $this->db->select("*")->from("manutencao")->where("id", $id)->get()->result();
		}
	}	
}