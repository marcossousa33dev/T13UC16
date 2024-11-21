<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aluno extends CI_Controller
{

    //Atributos da classe
    private $json;
    private $resultado;

    //Atributos provados da classe
    private $ra;
    private $idCurso;
    private $nome;
    private $estatus;

    private $usuario;
    private $senha;
    // private $idProf;

    private $permissao;

    //Getters dos atributos
    public function getRa()
    {
        return $this->ra;
    }

    public function getIdCurso()
    {
        return $this->idCurso;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    // public function getIdProf()
    // {
    //     return $this->idProf;
    // }

    public function getPermissao()
    {
        return $this->permissao;
    }

    //Setters dos atributos
    public function setRa($raFront)
    {
        $this->ra = $raFront;
    }

    public function setIdCurso($idCursoFront)
    {
        $this->idCurso = $idCursoFront;
    }

    public function setNome($nomeFront)
    {
        $this->nome = $nomeFront;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    public function setUsuario($usuarioFront)
    {
        $this->usuario = $usuarioFront;
    }

    public function setSenha($senhaFront)
    {
        $this->senha = $senhaFront;
    }

    // public function setIdProf($idProfFront)
    // {
    //     $this->idProf = $idProfFront;
    // }

    public function setPermissao($permissaoFront)
    {
        $this->permissao = $permissaoFront;
    }

    //Métodos da classe
    //Cadastrar o Aluno
    public function inserirAluno()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "ra" => '0',
            "nome" => '0',
            "idCurso" => '0',
            "estatus" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setRa($resultado->ra);
            $this->setIdCurso($resultado->idCurso);
            $this->setNome($resultado->nome);
            $this->setEstatus($resultado->estatus);

            /*
                ** VALIDAÇÕES NECESSÁRISAS RETORNOS POSSÍVEIS **
                01 - ALUNO CADASTRADO CORRETAMENTE (MODEL)
                02 - HOUVE ALGUM PROBLEMA NO CADASTRO DO ALUNO (MODEL)
                03 - ALUNO SE ENCONTRA DESATIVADO NA BASE DE DADOS (MODEL)
                04 - ALUNO JÁ SE ENCONTRA CADASTRADO NA BASE DE DADOS (MODEL)
                05 - CURSO INFORMADO NÃO ESTÁ CADASTRADO NA BASE DE DADOS (MODEL)
                06 - RA DO ALUNO NÃO INFORMADO OU ZERADO (CONTROLLER)
                07 - ID O CURSO NÃO INFORMADO OU ZERADO (CONTROLLER)
                08 - STATUS NÃO CONDIZ COM O PERMITIDO (CONTROLLER)
                09 - NOME NÃO INFORMADO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */
            if (trim($this->getRa()) == "" || $this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'RA do Aluno não informado ou zerado.'
                );
            } elseif (trim($this->getIdCurso()) == "" || $this->getIdCurso() == 0) {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'ID do curso não informado ou zerado.'
                );
            } elseif ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'Status não condiz com o permitido.'
                );
            } elseif (strlen($this->getNome()) == 0) {
                $retorno = array(
                    'codigo' => 9,
                    'msg' => 'Nome do aluno não informado.'
                );
            } else {
                //Realizo a instância da Model
                $this->load->model('M_aluno');

                //Atributos $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_aluno->inserirAluno($this->getRa(), $this->getIdCurso(), $this->getNome(), $this->getEstatus());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de inserção. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    //Consultar Aluno(s)
    public function consultarAluno()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "ra" => '0',
            "idCurso" => '0',
            "nome" => '0',
            "estatus" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setRa($resultado->ra);
            $this->setIdCurso($resultado->idCurso);
            $this->setNome($resultado->nome);
            $this->setEstatus($resultado->estatus);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - ALUNO CONSULTADO CORRETAMENTE (MODEL)
                02 - ALUNO SE ENCONTRA DESATIVADO NA BASE DE DADOS (MODEL)
                03 - DADOS NÃO ENCONTRADOS (MODEL)
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
                $this->load->model('M_aluno');

                //Atributos $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_aluno->consultarAluno($this->getRa(), $this->getIdCurso(), $this->getNome(), $this->getEstatus());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    //Alterar Aluno
    public function alterarAluno()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "ra" => '0',
            "idCurso" => '0',
            "nome" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setRa($resultado->ra);
            $this->setIdCurso($resultado->idCurso);
            $this->setNome($resultado->nome);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - DADOS DO ALUNO ATUALIZADOS CORRETAMENTE (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA ATUALIZAÇÃO DO ALUNO (MODEL)
                03 - NÃO É POSSÍVEL ALTERAR, POIS O ALUNO ESTÁ DESATIVADO (MODEL)
                04 - ALUNO NÃO LOCALIZADO (MODEL)
                05 - CURSO NÃO LOCALIZADO (MODEL)
                06 - RA DO ALUNO NÃO INFORMADO OU ZERADO (CONTROLLER)
                07 - INFORME UM DADO PARA ALTERAÇÃO (CONTROLLER)
                08 - ID DO CURSO NÃO PODE SER ZERADO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getRa()) == 0 || $this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'RA do aluno não informado ou zerado.'
                );
            } elseif ($this->getIdCurso() == "" && strlen($this->getNome()) == 0) {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'Informe um dado para alteração.'
                );
            } elseif($this->getIdCurso() == 0) {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'ID do curso não pode ser zerado.'
                );
            } else {
                //Realizo a instância da Model
                $this->load->model('M_aluno');

                //Atributos $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_aluno->alterarAluno($this->getRa(), $this->getIdCurso(), $this->getNome());

            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de alteração. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    //"Apagar" aluno
    public function apagarAluno()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);



        //Array com os dados que deverão vir do Front
        $lista = array(
            "ra" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setRa($resultado->ra);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - ALUNO DESATIVADO CORRETAMENTE (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA "EXCLUSÃO" DO ALUNO (MODEL)
                03 - ALUNO JÁ DESATIVADO (MODEL)
                04 - RA DO ALUNO INFORMADO NÃO ESTÁ CADASTRADO NA BASE DE DADOS (MODEL)
                05 - SEM PERMISSÃO (MODEL)
                06 - RA DO ALUNO NÃO INFORMADO OU ZERADO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getRa()) == 0 || $this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'RA do aluno não informado ou zerado.'
                );
            }else {
                //Realizo a instância da model
                $this->load->model('M_aluno');

                //Atributo $retorno recebe array com informações da validação do acesso
                $retorno = $this->M_aluno->apagarAluno($this->getRa());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método. Verifique.'
            );
        }

        echo json_encode($retorno);
    }

    public function reativarAluno()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array("ra" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRa($resultado->ra);

            /*
                ** VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS **
                01 - ALUNO REATIVADO CORRETAMENTE (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA REATIVAÇÃO DO ALUNO (MODEL)
                03 - ALUNO JÁ ATIVO NA BASE DE DADOS (MODEL)
                04 - ALUNO NÃO LOCALIZADO (MODEL)
                05 - RA DO ALUNO NÃO INFORMADO OU ZERADO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getRa()) == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'RA do aluno não informado ou zerado.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_aluno');

                //Atributo $retorno recebe array com informações da validação do acesso
                $retorno = $this->M_aluno->reativarAluno($this->getRa());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta. Verifique.'
            );
        }

        echo json_encode($retorno);
    }
}
?>