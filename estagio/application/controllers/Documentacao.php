<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Documentacao extends CI_Controller
{
    //Atributos da classe
    private $json;
    private $resultado;

    //Atributos privados da classe
    private $semestre_ano;
    private $ra;
    private $tcer;
    private $tcenr;
    private $desc_atividades;
    private $ficha_valid_estagio;
    private $rel_atividades;
    private $rescisao;
    private $rel_equivalencia;
    private $observacoes;
    private $estatus;
    private $usuario;
    private $senha;
    private $idProf;
    private $permissao;

    //getters
    public function getIdProf()
    {
        return $this->idProf;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getPermissao()
    {
        return $this->permissao;
    }

    public function getRa()
    {
        return $this->ra;
    }

    public function getSemestre_ano()
    {
        return $this->semestre_ano;
    }

    public function getTcenr()
    {
        return $this->tcenr;
    }

    public function getTcer()
    {
        return $this->tcer;
    }

    public function getFicha_valid_estagio()
    {
        return $this->ficha_valid_estagio;
    }

    public function getDesc_atividades()
    {
        return $this->desc_atividades;
    }

    public function getRel_atividades()
    {
        return $this->rel_atividades;
    }

    public function getRescisao()
    {
        return $this->rescisao;
    }

    public function getRel_equivalencia()
    {
        return $this->rel_equivalencia;
    }

    public function getObservacoes()
    {
        return $this->observacoes;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }



    //setters
    public function setIdProf($idProfFront)
    {
        $this->idProf = $idProfFront;
    }

    public function setUsuario($usuarioFront)
    {
        $this->usuario = $usuarioFront;
    }

    public function setSenha($senhaFront)
    {
        $this->senha = $senhaFront;
    }

    public function setPermissao($permissaoFront)
    {
        $this->permissao = $permissaoFront;
    }

    public function setRa($raFront)
    {
        $this->ra = $raFront;
    }

    public function setSemestre_ano($semestre_anoFront)
    {
        $this->semestre_ano = $semestre_anoFront;
    }

    public function setTcenr($tcenrFront)
    {
        $this->tcenr = $tcenrFront;
    }

    public function setTcer($tcerFront)
    {
        $this->tcer = $tcerFront;
    }

    public function setFicha_valid_estagio($ficha_valid_estagioFront)
    {
        $this->ficha_valid_estagio = $ficha_valid_estagioFront;
    }

    public function setDesc_atividades($desc_atividadesFront)
    {
        $this->desc_atividades = $desc_atividadesFront;
    }

    public function setRel_atividades($rel_atividadesFront)
    {
        $this->rel_atividades = $rel_atividadesFront;
    }

    public function setRescisao($rescisaoFront)
    {
        $this->rescisao = $rescisaoFront;
    }

    public function setRel_equivalencia($rel_equivalenciaFront)
    {
        $this->rel_equivalencia = $rel_equivalenciaFront;
    }

    public function setObservacoes($ObservacoesFront)
    {
        $this->observacoes = $ObservacoesFront;
    }

    public function setEstatus($estatusFront)
    {
        $this->estatus = $estatusFront;
    }


    //Métodos da classe
    //Cadastrar documentação
    public function inserirDocumentacao()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $lista = array(
            "semestre_ano" => '0',
            "ra" => '0',
            "tcer" => '0',
            "tcenr" => '0',
            "desc_atividades" => '0',
            "ficha_valid_estagio" => '0',
            "rel_atividades" => '0',
            "rescisao" => '0',
            "rel_equivalencia" => '0',
            "observacoes" => '0',
            "estatus" => '0'
        );
        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestre_ano($resultado->semestre_ano);
            $this->setRa($resultado->ra);
            $this->setTcer($resultado->tcer);
            $this->setTcenr($resultado->tcenr);
            $this->setDesc_atividades($resultado->desc_atividades);
            $this->setFicha_valid_estagio($resultado->ficha_valid_estagio);
            $this->setRel_atividades($resultado->rel_atividades);
            $this->setRescisao($resultado->rescisao);
            $this->setRel_equivalencia($resultado->rel_equivalencia);
            $this->setObservacoes($resultado->observacoes);
            $this->setEstatus($resultado->estatus);

            /*
                VALIDAÇÕES NECESSÁRAS RETORNOS POSSÍVEIS
                01 - DOCUMENTAÇÃO CADASTRADA COM SUCESSO (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA INSERÇÃO DOS DOCUMENTOS (MODEL)
                03 - DOCUMENTAÇÃO SE ENCONTRA DESATIVADA NA BASE DE DADOS (MODEL)
                04 - DOCUMENTAÇÃO JÁ SE ENCONTRA NA BASE DE DADOS (MODEL)
                05 - ALUNO NÃO LOCALIZADO (MODEL)
                06 - SEMESTRE_ANO NÃO INFORMADO OU ZERADO (CONTROLLER)
                07 - RA DO ALUNO NÃO INFORMADO OU ZERADO (CONTROLLER)
                08 - INFORME AO MENOS UM DADO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */


            if (strlen($this->getSemestre_ano()) == 0 || $this->getSemestre_ano() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Semestre_ano não informado ou zerado.'
                );

            } elseif (strlen($this->getRa()) == 0 || $this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'RA do Aluno não informado ou zerado.'
                );

            } elseif (
                strlen($this->getTcer()) == 0 && strlen($this->getTcenr()) == 0 && strlen($this->getDesc_atividades()) == 0 && strlen($this->getFicha_valid_estagio()) == 0 && strlen($this->getRel_atividades()) == 0
                && strlen($this->getRescisao()) == 0 && strlen($this->getRel_equivalencia()) == 0 && strlen($this->getObservacoes()) == 0
            ) {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'Informe ao menos um dado.'
                );

            } else {
                //Realizo a instância da model
                $this->load->model('M_documentacao');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_documentacao->inserirDocumentacao(
                    $this->getSemestre_ano(),
                    $this->getRa(),
                    $this->getTcer(),
                    $this->getTcenr(),
                    $this->getDesc_atividades(),
                    $this->getFicha_valid_estagio(),
                    $this->getRel_atividades(),
                    $this->getRescisao(),
                    $this->getRel_equivalencia(),
                    $this->getObservacoes(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de inserção. Verifique.'
            );
        }
        echo json_encode($retorno);
    }

    public function consultarDocumentacao()
    {

        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "semestre_ano" => '0',
            "ra" => '0',
            "tcer" => '0',
            "tcenr" => '0',
            "desc_atividades" => '0',
            "ficha_valid_estagio" => '0',
            "rel_atividades" => '0',
            "rescisao" => '0',
            "rel_equivalencia" => '0',
            "estatus" => '0'
        );
        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestre_ano($resultado->semestre_ano);
            $this->setRa($resultado->ra);
            $this->setTcer($resultado->tcer);
            $this->setTcenr($resultado->tcenr);
            $this->setDesc_atividades($resultado->desc_atividades);
            $this->setFicha_valid_estagio($resultado->ficha_valid_estagio);
            $this->setRel_atividades($resultado->rel_atividades);
            $this->setRescisao($resultado->rescisao);
            $this->setRel_equivalencia($resultado->rel_equivalencia);
            $this->setEstatus($resultado->estatus);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - CONSULTA EFETUADA COM SUCESSO (MODEL)
                02 - DADOS NÃO ENCONTRADOS (MODEL)
                03 - STATUS NÃO CONDIZ COM O PERMITIDO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array(
                    'codigo' => 3,
                    'msg' => 'Status não condiz com o permitido.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_documentacao');
                
                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_documentacao->consultarDocumentacao(
                    $this->getSemestre_ano(),
                    $this->getRa(),
                    $this->getTcer(),
                    $this->getTcenr(),
                    $this->getDesc_atividades(),
                    $this->getFicha_valid_estagio(),
                    $this->getRel_atividades(),
                    $this->getRescisao(),
                    $this->getRel_equivalencia(),
                    $this->getEstatus()
                );
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de consulta. Verifique.'
            );
        }
        echo json_encode($retorno);
    }

    public function alterarDocumentacao()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "semestre_ano" => '0',
            "ra" => '0',
            "tcer" => '0',
            "tcenr" => '0',
            "desc_atividades" => '0',
            "ficha_valid_estagio" => '0',
            "rel_atividades" => '0',
            "rescisao" => '0',
            "rel_equivalencia" => '0',
            "observacoes" => '0'
        );
        if (verificarParam($resultado, $lista) == 1) {
            $this->setRa($resultado->ra);
            $this->setSemestre_ano($resultado->semestre_ano);
            $this->setTcer($resultado->tcer);
            $this->setTcenr($resultado->tcenr);
            $this->setDesc_atividades($resultado->desc_atividades);
            $this->setFicha_valid_estagio($resultado->ficha_valid_estagio);
            $this->setRel_atividades($resultado->rel_atividades);
            $this->setRescisao($resultado->rescisao);
            $this->setRel_equivalencia($resultado->rel_equivalencia);
            $this->setObservacoes($resultado->observacoes);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - DOCUMENTAÇÃO ATUALIZADA COM SUCESSO (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA ATUALIZAÇÃO DOS DOCUMENTOS (MODEL)
                03 - DOCUMENTAÇÃO NÃO LOCALIZADA (MODEL)
                04 - SEMESTRE_ANO NÃO INFORMADO OU ZERADO (CONTROLLER)
                05 - RA DO ALUNO NÃO INFORMADO OU ZERADO (CONTROLLER)
                06 - INFORME AO MENOS UM DADO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */


            if (trim($this->getSemestre_ano()) == "" || $this->getSemestre_ano() == 0) {
                $retorno = array(
                    'codigo' => 4,
                    'msg' => 'Semestre_ano não informado ou zerado.'
                );

            } elseif (trim($this->getRa()) == "" || $this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'RA do Aluno não informado ou zerado.'
                );

            } elseif (
                strlen($this->getTcer()) == 0 && strlen($this->getTcenr()) == 0 && strlen($this->getDesc_atividades()) == 0 && strlen($this->getFicha_valid_estagio()) == 0 && strlen($this->getRel_atividades()) == 0
                && strlen($this->getRescisao()) == 0 && strlen($this->getRel_equivalencia()) == 0 && strlen($this->getObservacoes()) == 0
            ) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Informe ao menos um dado.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_documentacao');
                
                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_documentacao->alterarDocumentacao(
                    $this->getSemestre_ano(),
                    $this->getRa(),
                    $this->getTcer(),
                    $this->getTcenr(),
                    $this->getDesc_atividades(),
                    $this->getFicha_valid_estagio(),
                    $this->getRel_atividades(),
                    $this->getRescisao(),
                    $this->getRel_equivalencia(),
                    $this->getObservacoes()
                );
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de alteração. Verifique.'
            );
        }
        echo json_encode($retorno);
    }

    
    //Cadastrar documentação
    public function apagarDocumentacao()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "semestre_ano" => '0',
            "ra" => '0',
            "idProf" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setSemestre_ano($resultado->semestre_ano);
            $this->setRa($resultado->ra);
            $this->setIdProf($resultado->idProf);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - DOCUMENTAÇÃO EXCLUÍDA COM SUCESSO (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA EXCLUSÃO DA DOCUMENTAÇÃO (MODEL)
                03 - DOCUMENTAÇÃO JÁ DESATIVADA (MODEL)
                04 - DOCUMENTAÇÃO NÃO LOCALIZADA (MODEL)
                05 - SEM PERMISSÃO (MODEL)
                06 - SEMESTRE_ANO NÃO INFORMADO (CONTROLLER)
                07 - RA DO ALUNO NÃO INFORMADA (CONTROLLER)
                08 - MATRÍCULA DO PROFESSOR NÃO INFORMADA OU ZERADA (CONTROLLER)
                09 - USUARIO NÃO INFORMADO (CONTROLLER)
                10 - SENHA NÃO INFORMADA (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */


            if (trim($this->getSemestre_ano()) == "" || $this->getSemestre_ano() == 0){
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Semestre_ano não informado ou zerado.'
                );
            } elseif (trim($this->getRa()) == "" || $this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'RA do aluno não informado ou zerado.'
                );
            } elseif(strlen($this->getIdProf()) == 0 || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'Matrícula do professor não informada ou zerada.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_documentacao');
                
                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_documentacao->apagarDocumentacao($this->getSemestre_ano(), $this->getRa(), $this->getIdProf());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de exclusão. Verifique.'
            );
        }
        echo json_encode($retorno);
    }

    public function reativarDocumentacao()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "semestre_ano" => '0',
            "ra" => '0',
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setRa($resultado->ra);
            $this->setSemestre_ano($resultado->semestre_ano);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - DOCUMENTAÇÃO REATIVADA COM SUCESSO (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA REATIVAÇÃO DA DOCUMENTAÇÃO (MODEL)
                03 - DOCUMENTAÇÃO JÁ ATIVA NA BASE DE DADOS (MODEL)
                04 - DOCUMENTAÇÃO NÃO LOCALIZADA (MODEL)
                05 - SEMESTRE_ANO NÃO INFORMADO OU ZERADO (MODEL)
                06 - RA DO ALUNO NÃO INFORMADO OU ZERADO (MODEL)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getSemestre_ano()) == 0 || $this->getSemestre_ano() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'Semestre_ano não informado ou zerado.'
                );
            } elseif (strlen($this->getRa()) == 0 || $this->getRa() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'RA do aluno não informado ou zerado.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_documentacao');
                
                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_documentacao->reativarDocumentacao($this->getSemestre_ano(), $this->getRa());
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