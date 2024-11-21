<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Professor extends CI_Controller
{
    //Atributos da classe
    private $json;
    private $resultado;

    //Atributos privados da classe
    private $idProf;
    private $nome;
    private $usuario;
    private $senha;
    private $estatus;
    private $permissao;

    //getters
    public function getIdProf()
    {
        return $this->idProf;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function getPermissao()
    {
        return $this->permissao;
    }

    //setters
    public function setIdProf($idProfFront)
    {
        $this->idProf = $idProfFront;
    }

    public function setNome($nomeProfFront)
    {
        $this->nome = $nomeProfFront;
    }

    public function setUsuario($usuarioFront)
    {
        $this->usuario = $usuarioFront;
    }

    public function setSenha($senhaFront)
    {
        $this->senha = $senhaFront;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    public function setPermissao($permissaoFront)
    {
        $this->permissao = $permissaoFront;
    }

    //Métodos da classe
    //Cadastrar o professor
    public function inserirProfessor()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "idProf" => '0',
            "nome" => '0',
            "usuario" => '0',
            "senha" => '0',
            "estatus" => '0',
            "permissao" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setIdProf($resultado->idProf);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setEstatus($resultado->estatus);
            $this->setPermissao($resultado->permissao);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSÍVEIS **
                01 - PROFESSOR CADASTRADO CORRETAMENTE (MODEL)
                02 - HOUVE ALGUM PROBLEMA NO CADASTRO DO PROFESSOR (MODEL)
                03 - PROFESSOR SE ENCONTRA DESATIVADO NA BASE DE DADOS (MODEL)
                04 - PROFESSOR JÁ SE ENCONTRA CADASTRADO NA BASE DE DADOS (MODEL)
                05 - ID DO PROFESSOR NÃO INFORMADO OU ZERADO (CONTROLLER)
                06 - STATUS NÃO CONDIZ COM O PERMITIDO (CONTROLLER)
                07 - NOME NÃO INFORMADO (CONTROLLER)
                08 - USUARIO NÃO INFORMADO (CONTROLLER)
                09 - SENHA NÃO INFORMADA (CONTROLLER)
                10 - PERMISSÃO NÃO INFORMADA (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (trim($this->getIdProf()) == "" || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'ID do professor não informado ou zerado.'
                );
            } elseif ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Status não condiz com o permitido.'
                );
            } elseif (strlen($this->getNome()) == 0) {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'Nome não informado.'
                );
            } elseif ($this->getUsuario() == "") {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'Usuario não informado.'
                );
            } elseif ($this->getSenha() == "") {
                $retorno = array(
                    'codigo' => 9,
                    'msg' => 'Senha não informada.'
                );
            } elseif ($this->getPermissao() == "") {
                $retorno = array(
                    'codigo' => 10,
                    'msg' => 'Permissão não informada.'
                );
            } else {
                //Realizo a instância da Model
                $this->load->model('M_professor');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_professor->inserirProfessor($this->getIdProf(), $this->getNome(), $this->getUsuario(), $this->getSenha(), $this->getEstatus(), $this->getPermissao());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de inserção. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    public function login()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "idProf" => '0',
            "usuario" => '0',
            "senha" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setIdProf($resultado->idProf);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSÍVEIS **
                01 - ACESSO PERMITIDO. BEM VINDO (MODEL)
                02 - ACESSO NEGADO. POR FAVOR, CONTATO A ADMINISTRAÇÃO (MODEL)
                03 - DADOS NÃO LOCALIZADOS (MODEL)
                04 - MATRÍCULA NÃO INFORMADA OU ZERADA (CONTROLLER)
                05 - USUARIO NÃO INFORMADO (CONTROLLER)
                06 - SENHA NÃO INFORMADA (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getIdProf()) == 0 || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 4,
                    'msg' => 'Matrícula não informada ou zerada.'
                );
            } elseif (strlen($this->getUsuario()) == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'Usuario não informado.'
                );
            } elseif (strlen($this->getSenha()) == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Senha não informada.'
                );
            } else {
                $this->load->model('M_professor');

                $retorno = $this->M_professor->login($this->getIdProf(), $this->getUsuario(), $this->getSenha(), $this->getPermissao());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de acesso. Verifique.'
            );
        }

        echo json_encode($retorno);

    }

    //Consultar Professor
    public function consultarProfessor()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "idProf" => '0',
            "nome" => '0',
            "usuario" => '0',
            "estatus" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setIdProf($resultado->idProf);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setEstatus($resultado->estatus);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - CONSULTA EFETUADA COM SUCESSO (MODEL)
                02 - PROFESSOR SE ENCONTRA DESATIVADO NA BASE DE DADOS (MODEL)
                03 - DADOS NÃO LOCALIZADOS (MODEL)
                04 - STATUS NÃO CONDIZ COM O PERMITIDO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array(
                    'codigo' => 4,
                    'msg' => 'Status não condiz com o permitido.'
                );
            } else {
                //Realizo a instância da Model
                $this->load->model('M_professor');

                //Atributos $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_professor->consultarProfessor($this->getIdProf(), $this->getNome(), $this->getUsuario(), $this->getEstatus());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    //Alterar Professor
    public function alterarProfessor()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "idProf" => '0',
            "nome" => '0',
            "usuario" => '0',
            "senha" => '0',
            "permissao" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setIdProf($resultado->idProf);
            $this->setNome($resultado->nome);
            $this->setUsuario($resultado->usuario);
            $this->setSenha($resultado->senha);
            $this->setPermissao($resultado->permissao);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - PROFESSOR ALTERADO CORRETAMENTE (MODEL)
                02 - HOUVE ALGUM PROBLEMA DE ALTERAÇÃO DOS DADOS (MODEL)
                03 - NÃO É POSSÍVEL ALTERAR, POIS O PROFESSOR ESTÁ DESATIVADO (MODEL)
                04 - PROFESSOR NÃO CADASTRADO NA BASE DE DADOS (MODEL)
                05 - MATRÍCULA NÃO INFORMADA OU ZERADA (CONTROLLER)
                06 - INFORME UM DADO PARA ALTERAÇÃO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getIdProf()) == 0 || strlen($this->getIdProf()) == "") {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'Matrícula não informada ou zerada.'
                );
            } elseif (strlen($this->getNome()) == 0 && strlen($this->getUsuario()) == 0 && strlen($this->getSenha()) == 0 && $this->getPermissao() == "") {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Informe um dado para alteração.'
                );
            } else {
                //Realizo a instância da Model
                $this->load->model('M_professor');

                //Atributos $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_professor->alterarProfessor($this->getIdProf(), $this->getNome(), $this->getUsuario(), $this->getSenha(), $this->getPermissao());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de alteração. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    //"Apagar" Professor
    public function apagarProfessor()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "idProf" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setIdProf($resultado->idProf);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - PROFESSOR "APAGADO" CORRETAMENTE (MODEL)
                02 - VOUVE ALGUM PROBLEMA NA "EXCLUSÃO" DO PROFESSOR (MODEL)
                03 - PROFESSOR JÁ DESATIVADO (MODEL)
                04 - PROFESSOR NÃO CADASTRADO NA BASE DE DADOS (MODEL)
                05 - MATRÍCULA NÃO INFORMADA OU ZERADA (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getIdProf()) == 0 || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 4,
                    'msg' => 'Matrícula não informada ou zerada.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_professor');

                //Atributo $retorno recebe array com informações da validação do acesso
                $retorno = $this->M_professor->apagarProfessor($this->getIdProf());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de exclusão. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    public function reativarProfessor()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("idProf" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdProf($resultado->idProf);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - PROFESSOR REATIVADO CORRETAMENTE (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA REATIVAÇÃO DO PROFESSOR (MODEL)
                03 - PROFESSOR JÁ ATIVO NA BASE DE DADOS (MODEL)
                04 - MATRÍCULA CADASTRADA NA BASE DE DADOS (MODEL)
                05 - MATRÍCULA NÃO INFORMADA OU ZERADA (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getIdProf()) == 0 || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'Matrícula não informada ou zerada.'
                );
            } else {
                $this->load->model('M_professor');

                $retorno = $this->M_professor->reativarProfessor($this->getIdProf());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de reativação. Verifique.'
            );
        }

        echo json_encode($retorno);
    }
}
?>