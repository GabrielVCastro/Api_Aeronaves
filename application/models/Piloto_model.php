
<?php  

class Piloto_model extends CI_Model {
	
	public function listar(){
		$this->db->select("*");
		return $this->db->from("piloto");
	}

	public function cadastrar($piloto){
		if($this->db->select("*")->from("piloto")->where("cpf", $piloto['cpf'])->get()->num_rows()>0){
			return false;
		}

		return $this->db->insert("piloto", $piloto);

	}

	public function editar($id, $piloto){

		$this->db->where("id", $id);
		return $this->db->update("piloto", $piloto);

	}
	public function ativar_desativar($id){
		$piloto = $this->db->select("*")->from("piloto")->where("id", $id)->get()->result();
		if ($piloto[0]->status=="A") {
			$piloto = array(
				"status" => "D"
			);
			$this->db->where("id", $id);
			$this->db->update('piloto', $piloto);
			return $this->db->select("*")->from("piloto")->where("id", $id)->get()->result();;
		}

		if ($piloto[0]->status=="D") {
			$piloto = array(
				"status" => "A"
			);
			$this->db->where("id", $id);
			$this->db->update('piloto', $piloto);
			return $this->db->select("*")->from("piloto")->where("id", $id)->get()->result();
		}
	}		 	
}