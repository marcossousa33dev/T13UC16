<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcoes extends CI_Controller {

    //Métodos da classe
    //Chamada da view de login
    public function index() {
        $this->load->view('index');
    }

    //Chamada da view Home
    public function abrirHome() {
        $this->load->view('Home');
    }

    //Views de Aluno
    //Chamada da view Aluno
    public function pagIniAluno() {
        $this->load->view('Aluno');
    }

    //Chamada da view inserirAluno
    public function inserirAluno() {
        $this->load->view('inserirAluno');
    }

    //Chamada da view consultarAluno
    public function consultarAluno() {
        $this->load->view('consultarAluno');
    }

    //Chamada da view alterarAluno
    public function alterarAluno() {
        $this->load->view('alterarAluno');
    }

    //Chamada da view apagarAluno
    public function apagarAluno() {
        $this->load->view('apagarAluno');
    }

    //Chamada da view reativarAluno
    public function reativarAluno() {
        $this->load->view('reativarAluno');
    }

    //--------------------------------------------------------------------

    //Views de Curso
    //Chamada da view Curso
    public function pagIniCurso() {
        $this->load->view('Curso');
    }

    //Chamada da view inserirCurso
    public function inserirCurso() {
        $this->load->view('inserirCurso');
    }

    //Chamada da view consultarCurso
    public function consultarCurso() {
        $this->load->view('consultarCurso');
    }

    //Chamada da view alterarCurso
    public function alterarCurso() {
        $this->load->view('alterarCurso');
    }

    //Chamada da view apagarCurso
    public function apagarCurso() {
        $this->load->view('apagarCurso');
    }

    //--------------------------------------------------------------------

    //Views de Professor
    //Chamada da view Professor
    public function pagIniProfessor() {
        $this->load->view('Professor');
    }

    //Chamada da view consultarProfessor
    public function consultarProfessor() {
        $this->load->view('consultarProfessor');
    }

    //Chamada da view alterarProfessor
    public function alterarProfessor() {
        $this->load->view('alterarProfessor');
    }

    //Chamada da view apagarProfessor
    public function apagarProfessor() {
        $this->load->view('apagarProfessor');
    }

    //Chamada da view reativarProfessor
    public function reativarProfessor() {
        $this->load->view('reativarProfessor');
    }

    //--------------------------------------------------------------------

    //Views de Atendimento
    //Chamada da view Atendimento
    public function pagIniAtendimento() {
        $this->load->view('Atendimento');
    }

    //Chamada da view inserirAtendimento
    public function registraAtendimento() {
        $this->load->view('registraAtendimento');
    }

    //Chamada da view consultarAtendimento
    public function consultarAtendimento() {
        $this->load->view('consultarAtendimento');
    }

    //Chamada da view alterarAtendimento
    public function alterarAtendimento() {
        $this->load->view('alterarAtendimento');
    }

    //Chamada da view finalizarAtendimento
    public function finalizarAtendimento() {
        $this->load->view('finalizarAtendimento');
    }

    //--------------------------------------------------------------------

    //View de Documentação
    //Chamada da view Documentação
    public function pagIniDocs() {
        $this->load->view('Documentacao');
    }

    //Chamada da view inserirDocs
    public function inserirDocs() {
        $this->load->view('inserirDocs');
    }

    //Chamdada da view consultarDocs
    public function consultarDocs() {
        $this->load->view('consultarDocs');
    }

    //Chamada da view alterarDocs
    public function alterarDocs() {
        $this->load->view('alterarDocs');
    }

    //Chamada da view apagarDocs
    public function apagarDocs() {
        $this->load->view('apagarDocs');
    }

    //Chamada da view reativarDocs
    public function reativarDocs() {
        $this->load->view('reativarDocs');
    }
}
?>