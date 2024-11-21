<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Atendimento extends CI_Controller
{
    //Atributos da classe
    private $json;
    private $resultado;

    //Atributos privados da classe
    private $codAtendimento;
    private $ra;
    private $idProf;
    private $dataAtendimento;
    private $horaAtendimento;
    private $descricao;
    private $estatus;

    //getters
    public function getCodAtendimento()
    {
        return $this->codAtendimento;
    }

    public function getRa()
    {
        return $this->ra;
    }

    public function getIdProf()
    {
        return $this->idProf;
    }

    public function getDataAtendimento()
    {
        return $this->dataAtendimento;
    }

    public function getHoraAtendimento()
    {
        return $this->horaAtendimento;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }


    //setters
    public function setCodAtendimento($codAtendimentoFront)
    {
        $this->codAtendimento = $codAtendimentoFront;
    }

    public function setRa($raFront)
    {
        $this->ra = $raFront;
    }

    public function setIdProf($idProfFront)
    {
        $this->idProf = $idProfFront;
    }

    public function setDataAtendimento($dataAtendimentoFront)
    {
        $this->dataAtendimento = $dataAtendimentoFront;
    }

    public function setHoraAtendimento($horaAtendimentoFront)
    {
        $this->horaAtendimento = $horaAtendimentoFront;
    }

    public function setDesricao($descricaoFront)
    {
        $this->descricao = $descricaoFront;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }

    //Métodos da classe
    //Registro de atendimento

    public function registraAtendimento()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "codAtendimento" => '0',
            "ra" => '0',
            "idProf" => '0',
            "dataAtendimento" => '0',
            "horaAtendimento" => '0',
            "descricao" => '0',
            "estatus" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);
            $this->setRa($resultado->ra);
            $this->setIdProf($resultado->idProf);
            $this->setDataAtendimento($resultado->dataAtendimento);
            $this->setHoraAtendimento($resultado->horaAtendimento);
            $this->setDesricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - ATENDIMENTO REGISTRADO COM SUCESSO (MODEL)
                02 - HOUVE UM PROBLEMA NO REGISTRO (MODEL)
                03 - ALUNO NÃO CADASTRADO NA BASE DE DADOS (MODEL)
                04 - ATENDIMENTO JÁ FINALIZADO (MODEL)
                05 - ATENDIMENTO JÁ REGISTRADO NA BASE DE DADOS (MODEL)
                06 - CÓDIGO DE ATENDIMENTO NÃO INFORMADO OU ZERADO (CONTROLLER)
                07 - RA DO ALUNO NÃO INFORMADO OU ZERADO (CONTROLLER)
                08 - MATRÍCULA DO PROFESSOR NÃO INFORMADA OU ZERADA (CONTROLLER)
                09 - DATA DO ATENDIMENTO NÃO ESPECIFICADA (CONTROLLER)
                10 - HORA DO ATENDIMENTO NÃO ESPECIFICADA (CONTROLLER)
                11 - STATUS NÃO CONDIZ COM O PERMITIDO (CONTROLLER)
                99 - OS CAMPOS VINDOS DO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getCodAtendimento()) == 0 || $this->getCodAtendimento() == "") {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Código de atendimento não informado ou zerado.'
                );
            } elseif (strlen($this->getRa()) == 0 || $this->getRa() == "") {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'RA do aluno não informado ou zerado.'
                );
            } elseif (strlen($this->getIdProf()) == 0 || $this->getIdProf() == "") {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'Matrícula de professor não informada ou zerada.'
                );
            } elseif ($this->getDataAtendimento() == "") {
                $retorno = array(
                    'codigo' => 9,
                    'msg' => 'Data do atendimento não especificada.'
                );
            } elseif ($this->getHoraAtendimento() == "") {
                $retorno = array(
                    'codigo' => 10,
                    'msg' => 'Hora do atendimento não especificada.'
                );
            } elseif ($this->getEstatus() == 0) {
                $retorno = array(
                    'codigo' => 11,
                    'msg' => 'Status não condiz com o permitido.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_atendimento');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_atendimento->registraAtendimento(
                    $this->getCodAtendimento(),
                    $this->getRa(),
                    $this->getIdProf(),
                    $this->getDataAtendimento(),
                    $this->getHoraAtendimento(),
                    $this->getDescricao(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de registro, verifique.'
            );
        }

        echo json_encode($retorno);
    }

    public function consultaAtendimento()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "codAtendimento" => '0',
            "ra" => '0',
            "idProf" => '0',
            "estatus" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);
            $this->setRa($resultado->ra);
            $this->setIdProf($resultado->idProf);
            $this->setEstatus($resultado->estatus);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - CONSULTA REALIZADA COM SUCESSO (MODEL)
                02 - ATENDIMENTO NÃO LOCALIZADO (MODEL)
                03 - INFORME UM DADO PARA CONSULTA (CONTROLLER)
                04 - CÓDIGO DE ATENDIMENTO NÃO PODE SER ZERO (CONTROLLER)
                05 - RA DO ALUNO NÃO PODE SER ZERO (CONTROLLER)
                06 - MATRÍCULA DO PROFESSOR NÃO PODE SER ZERO (CONTROLLER)
                07 - STATUS NÃO CONDIZ COM O PERMITIDO (CONTROLLER)
                99 - OS CAMPOS VINDOS DO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getCodAtendimento()) == 0 && strlen($this->getRa()) == 0 && strlen($this->getIdProf()) == 0 && strlen($this->getEstatus()) == 0) {
                $retorno = array(
                    'codigo' => 2,
                    'msg' => 'Informe um dado para consulta.'
                );
            } elseif ($this->getCodAtendimento() == 0) {
                $retorno = array(
                    'codigo' => 3,
                    'msg' => 'Código de atendimento não pode ser zero.'
                );
            } elseif ($this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 4,
                    'msg' => 'RA do aluno não pode ser zero.'
                );
            } elseif ($this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'Matrícula do professor não pode ser zero.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_atendimento');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_atendimento->consultaAtendimento($this->getCodAtendimento(), $this->getRa(), $this->getIdProf(), $this->getEstatus());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta, verifique.'
            );
        }

        echo json_encode($retorno);
    }

    //Alterar atendimento
    public function alteraAtendimento()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "codAtendimento" => '0',
            "dataAtendimento" => '0',
            "horaAtendimento" => '0',
            "descricao" => '0',
            "estatus" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);
            $this->setDataAtendimento($resultado->dataAtendimento);
            $this->setHoraAtendimento($resultado->horaAtendimento);
            $this->setDesricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - ATENDIMENTO ALTERADO COM SUCESSO (MODEL)
                02 - NADA FOI ALTERADO (MODEL)
                03 - NÃO É POSSÍVEL ALTERAR UM ATENDIMENTO JÁ FINALIZADO (MOEDEL)
                04 - ATENDIMENTO NÃO LOCALIZADO (MODEL)
                05 - CÓDIGO DE ATENDIMENTO NÃO PODE SER VAZIO OU ZERADO (CONTROLLER)
                06 - INFORME UM DADO PARA ALTERAÇÃO (CONTROLLER)
                07 - VALOR DA DATA DE ATENDIMENTO NÃO PODE SER ZERO (CONTROLLER)
                08 - VALOR DA HORA DE ATENDIMENTO NÃO PODE SER ZERO (CONTROLLER)
                99 - OS CAMPOS VINDOS DO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */
            if (strlen($this->getCodAtendimento()) == 0 || $this->getCodAtendimento() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'Codigo do atendimento não pode ser vazio ou zerado'
                );
            } elseif (
                strlen($this->getDataAtendimento()) == 0 && strlen($this->getHoraAtendimento()) == 0 && strlen($this->getDescricao()) == 0 && strlen($this->getEstatus()) == 0
            ) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Informe um dado para alteração.'
                );
            } elseif ($this->getDataAtendimento() == 0) {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'Valor da data de atendimento não pode ser zero.'
                );
            } elseif ($this->getHoraAtendimento() == 0) {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'Valor da hora de atendimento não pode ser zero.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_atendimento');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_atendimento->alteraAtendimento($this->getCodAtendimento(), $this->getDataAtendimento(), $this->getHoraAtendimento(), $this->getDescricao(), $this->getEstatus());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de alteração, verifique.'
            );
        }

        echo json_encode($retorno);
    }

    public function finalizaAtendimento()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "codAtendimento" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - ATENDIMENTO FINALIZADO COM SUCESSO (MODEL)
                02 - NÃO FOI POSSÍVEL ALTERAR O ATENDIMENTO. TENTE NOVAMENTE OU CONTATE O SUPORTE (MOEDEL)
                03 - ATENDIMENTO NÃO LOCALIZADO (MODEL)
                04 - CÓDIGO DE ATENDIMENTO NÃO PODE INFORMADO OU ZERADO (CONTROLLER)
                06 - INFORME UM DADO PARA ALTERAÇÃO (CONTROLLER)
                07 - VALOR DA DATA DE ATENDIMENTO NÃO PODE SER ZERO (CONTROLLER)
                08 - VALOR DA HORA DE ATENDIMENTO NÃO PODE SER ZERO (CONTROLLER)
                99 - OS CAMPOS VINDOS DO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getCodAtendimento()) == 0 || $this->getCodAtendimento() == 0) {
                $retorno = array(
                    'codigo' => 4,
                    'msg' => 'Codigo de atendimento não informado vazio ou zerado.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_atendimento');

                //Atributo $retorno recebe array com informações da validação do acesso

                $retorno = $this->M_atendimento->finalizaAtendimento($this->getCodAtendimento());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de finalização, verifique.'
            );
        }

        echo json_encode($retorno);
    }

}
?>