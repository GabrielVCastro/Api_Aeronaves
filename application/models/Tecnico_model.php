<?php  

class Tecnico_model extends CI_Model {

	public function listar(){  
		$this->db->select("*");
		return	$this->db->from("tecnico")->get()->result();
		
	}

	public function cadastrar($tecnico){
		$this->db->select("*")->from("tecnico");
		if($this->db->where("endereco", $tecnico['endereco'])->get()->num_rows()>0) {
			return false;
		}

		return $this->db->insert("tecnico", $tecnico);
			
	}

	public function editar($id, $tecnico){
		$this->db->where("id", $id);
		return $this->db->update("tecnico", $tecnico);
	}


	public function ativar_desativar($id){
		$tecnico = $this->db->select("*")->from("tecnico")->where("id", $id)->get()->result();
		if ($tecnico[0]->status=="A") {
			$tecnico = array(
				"status" => "D"
			);
			$this->db->where("id", $id);
			$this->db->update('tecnico', $tecnico);
			return $this->db->select("*")->from("tecnico")->where("id", $id)->get()->result();;
		}

		if ($tecnico[0]->status=="D") {
			$tecnico = array(
				"status" => "A"
			);
			$this->db->where("id", $id);
			$this->db->update('tecnico', $tecnico);
			return $this->db->select("*")->from("tecnico")->where("id", $id)->get()->result();
		}
	}		 	


}		