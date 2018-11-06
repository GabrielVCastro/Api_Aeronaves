<?php  

class Aeronave_model extends CI_Model {

	public function listar(){  
		$this->db->select("*");
		return	$this->db->from("aeronave")->get()->result();
	}

	public function cadastrar($aeronave){
		
		
		if ($this->db->select("*")->from("aeronave")->where("prefixo", $aeronave["prefixo"])->get()->num_rows()>0) {
		 	return false;
		}

		return $this->db->insert("aeronave", $aeronave);

	}

	public function editar($id, $aeronave){


		$this->db->where("id", $id);
		return $this->db->update('aeronave', $aeronave);
	}

	public function ativar_desativar($id){
	$aeronave = $this->db->select("*")->from("aeronave")->where("id", $id)->get()->result();
	if ($aeronave[0]->status=="A") {
		$aeronave = array(
			"status" => "D"
		);
		$this->db->where("id", $id);
		$this->db->update('aeronave', $aeronave);
		return $this->db->select("*")->from("aeronave")->where("id", $id)->get()->result();;
	}

	if ($aeronave[0]->status=="D") {
		$aeronave = array(
			"status" => "A"
		);
		$this->db->where("id", $id);
		$this->db->update('aeronave', $aeronave);
		return $this->db->select("*")->from("aeronave")->where("id", $id)->get()->result();
	}		 	
		
		
	}

	
		
	



}

