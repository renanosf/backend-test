<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Biblioteca adicionada para facilitar a criação do servidor RESTful
require_once(APPPATH.'libraries/REST_Controller.php');

class Webservice extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct(){
		parent::__construct();
		//Habilita Cors
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type');
		//Carrega array de vagas
		$this->vagas = json_decode(file_get_contents(FCPATH."vagas.json"))->docs;
	}

	//Ordena vagas pelo salário
	public function orderna(){
		if(strtolower($this->ordem) === 'desc'){
			usort($this->vagas,function($a,$b){
				if ($a->salario == $b->salario) {
		        	return 0;
		    	}
		    	return ($a->salario > $b->salario) ? -1 : 1;
			});
		} else {
			usort($this->vagas,function($a,$b){
				if ($a->salario == $b->salario) {
		        	return 0;
		    	}
		    	return ($a->salario < $b->salario) ? -1 : 1;
			});
		}
	}

	//Filtra vagas pelo termo de busca
	public function filtra(){
		$this->vagas = array_filter($this->vagas, function($obj){
			return strpos(strtolower($obj->title),strtolower($this->busca)) !== FALSE || strpos(strtolower($obj->description),strtolower($this->busca)) !== FALSE;
		});
	}

	//Filtra cidade da vaga
	public function filtraCidade(){
		$this->vagas = array_filter($this->vagas, function($obj){
			return strpos(strtolower($obj->cidade[0]),strtolower($this->cidade)) !== FALSE;
		});
	}

	//Para utilização de CORS preflight request
	public function vagas_options(){
		$this->response("OK");
	}

	//Metodo para a busca de vagas
	public function vagas_get(){
		//Recebe parametros get
		$this->busca = $this->get("busca");
		$this->cidade = $this->get("cidade");
		$this->ordem = $this->get("ordem") ? $this->get("ordem") : "asc";

		//Realiza os filtros e ordena
		if(!empty($this->busca)) $this->filtra();
		if(!empty($this->cidade)) $this->filtraCidade();
		$this->orderna();
		//Manda resposta de volta
		$this->response($this->vagas);
	}
}
