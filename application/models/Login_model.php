<?php  

class Login_model extends CI_Model {

	public function cadastrar($login){
		if($this->db->select("*")->from("login")->where("email", $login['email'])->get()->num_rows()>0){
			return false;	
		}

		return $this->db->insert("login", $login);

	}

	public function buscar_usuario($email){
		return $this->db->select("*")->from("login")->where("email", $email)->get()->result();
		

	}


	public function fazer_login($usuario){
		if($this->db->select("*")->from("login")->where("email", $usuario['email'])->get()->num_rows()>0){
			
			$verificar = $this->db->select("*")->from("login")->where("email", $usuario['email'])->get()->result();
			if ($verificar[0]->password==$usuario['password']) {
				$this->db->where("email", $usuario['email']);
				$this->db->update("login", $usuario);
				return $this->db->select("*")->from("login")->where("email", $usuario['email'])->get()->result();
			}
		}

		return false;
	}

}