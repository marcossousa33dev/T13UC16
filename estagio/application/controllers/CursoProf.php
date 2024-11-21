<?php
defined('BASEPATH') or exit('No direct script acess allowed');

class CursoProf extends CI_Controller
{
    //Atributos da classe
    private $json;
    private $resultado;

    //Atributos privados da classe
    private $idCurso;
    private $newIdCurso;
    private $idProf;
    private $estatus;

    private $usuario;
    private $senha;

    private $permissao;

    //getters
    public function getIdCurso()
    {
        return $this->idCurso;
    }

    public function getNewIdCurso()
    {
        return $this->newIdCurso;
    }

    public function getIdProf()
    {
        return $this->idProf;

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

    public function getPermissao()
    {
        return $this->permissao;
    }

    //setters
    public function setIdCurso($idCursoFront)
    {
        $this->idCurso = $idCursoFront;
    }

    public function setNewIdCurso($newIdCursoFront)
    {
        $this->newIdCurso = $newIdCursoFront;
    }

    public function setIdProf($IdProfFront)
    {
        $this->idProf = $IdProfFront;
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

    public function setPermissao($permissaoFront)
    {
        $this->permissao = $permissaoFront;
    }

    //Métodos da classe
    //Cadastrar curso/prof
    public function inserirCursoProf()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Array com os dados que deverão vir do Front
        $lista = array(
            "idCurso" => '0',
            "idProf" => '0',
            "estatus" => '0'
        );

        //Verificação dos parâmetros passados na Helper
        if (verificarParam($resultado, $lista) == 1) {
            //Fazendo os setters
            $this->setIdCurso($resultado->idCurso);
            $this->setIdProf($resultado->idProf);
            $this->setEstatus($resultado->estatus);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - RELAÇÃO CURSO/PROFESSOR CADASTRADA COM SUCESSO (MODEL)
                02 - HOUVE ALGUM PROBLEMA NA INSERÇÃO NA TABELA CURSOPROF (MODEL)
                03 - RELAÇÃO CURSO/PROFESSOR JÁ CADASTRADA NA BASE DE DADOS (MODEL)
                04 - RELAÇÃO CURSO/PROFESSOR SE ENCONTRA DESATIVADA NA BASE DE DADOS (MODEL)
                05 - PROFESSOR NÃO LOCALIZADO (MODEL)
                06 - CURSO NÃO LOCALIZADO (MODEL)
                07 - MATRÍCULA DO PROFESSOR NÃO INFORMADA OU ZERADA (CONTROLLER)
                08 - ID DO CURSO NÃO INFORMADO OU ZERADO (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */
            if (trim($this->getIdProf()) == "" || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'Matricula do professor não informada ou zerada.'
                );
            } elseif (trim($this->getIdCurso()) == "" || $this->getIdCurso() == 0) {
                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'ID do curso não informado ou zerado.'
                );
            } else {
                //Realizo a instância da model
                $this->load->Model('M_cursoProf');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_cursoProf->inserirCursoProf($this->getIdCurso(), $this->getIdProf(), $this->getEstatus());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindo do FrontEnd não representam o método de inserção. Verifique.'
            );
        }
        echo json_encode($retorno);
    }

    //Consultar curso/prof
    public function consultarCursoProf()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Fazendo os setters
        $lista = array(
            "idCurso" => '0',
            "idProf" => '0',
            "estatus" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdCurso($resultado->idCurso);
            $this->setIdProf($resultado->idProf);
            $this->setEstatus($resultado->estatus);

        /*
            VALIDAÇÕES NECESSÁRIAS REOTRNOS POSSÍVEIS
            01 - CONSULTA EFETUADA COM SUCESSO (MODEL)
            02 - DADOS NÃO ENCONTRADOS (MODEL)
            03 - STATUS NÃO CONDIZ COM O PERMITIDO (CONTROLLER)
            04 - ID DO CURSO NÃO PODE SER ZERADO (CONTROLLER)
            05 - MATRÍCULA DO PROFESSOR NÃO PODE SER ZERADA (CONTROLLER)
            99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
        */

            if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
                $retorno = array(
                    'codigo' => 3,
                    'msg' => 'Status não condiz com o permitido.'
                );
            } elseif($this->getIdCurso() == 0){
                $retorno = array(
                    'codigo' => 4,
                    'msg' => 'ID do curso não pode ser zerado.'
                );
            } elseif($this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'Matrícula do professor não pode ser zerada.'
                );
            } else {

                //Realizo a instância da model
                $this->load->model('M_cursoProf');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_cursoProf->consultarCursoProf($this->getIdCurso(), $this->getIdProf(), $this->getEstatus());
            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representa o método de consulta. Verifique.'
            );
        }
        echo json_encode($retorno);
    }

    //Alterando cursoprof
    public function alterarCursoProf()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Fazendo os setters
        $lista = array(
            "idCurso" => '0',
            "idProf" => '0',
            "newIdCurso" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdCurso($resultado->idCurso);
            $this->setIdProf($resultado->idProf);
            $this->setNewIdCurso($resultado->newIdCurso);

            /*
            VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
            01 - RELAÇÃO CURSO/PROFESSOR ATUALIZADA COM SUCESSO (MODEL)
            02 - HOUVE ALGUM PROBLEMA NA ATUALIZAÇÃO DA RELAÇÃO CURSO/PROFESSOR (MODEL)
            03 - PROFESSOR NÃO LOCALIZADO (MODEL)
            04 - CURSO NÃO LOCALIZADO (MODEL)
            05 - RELAÇÃO CURSO/PROFESSOR NÃO LOCALIZADA (MODEL)
            06 - ID DO CURSO NÃO INFORMADO OU ZERADO (CONTROLLER)
            07 - MATRÍCULA DO PROFESSOR NÃO INFORMADA OU ZERADA (CONTROLLER)
            08 - ID DO NOVO CURSO NÃO INFORMADO OU ZERADO (CONTROLLER)
            99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)

        */

            if ($this->getIdCurso() == "" || $this->getIdCurso() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'ID do curso não informado ou zerado.'
                );

            } elseif (strlen($this->getIdProf() == 0) || $this->getIdProf() == "") {
                $retorno = array(
                    'codigo' => 7,
                    'msg' => 'Matricula do professor não informada ou zerada.'
                );

            } elseif (trim($this->getNewIdCurso()) == "" || $this->getNewIdCurso() == 0) {

                $retorno = array(
                    'codigo' => 8,
                    'msg' => 'ID do novo curso não informado ou zerado.'
                ); 
            } else {
                //Realizo a instância da model
                $this->load->model('M_cursoProf');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_cursoProf->alterarCursoProf($this->getIdCurso(), $this->getIdProf(), $this->getNewIdCurso());

            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de alteração. Verifique.'
            );
        }
        echo json_encode($retorno);

    }

    //"Apagar cursoprof"
    public function apagarCursoProf()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Fazendo os setters
        $lista = array(
            "idCurso" => '0',
            "idProf" => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdCurso($resultado->idCurso);
            $this->setIdProf($resultado->idProf);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - RELAÇÃO CURSO/PROFESSOR DESATIVADA COM SUCESSO (MODEL)
                02 - HOUVE UM PROBLEMA NA DESATIVAÇÃO DA RELAÇÃO CURSO/PROFESSOR (MODEL)
                03 - A RELAÇÃO CURSO PROFESSOR INFORMADA JÁ ESTÁ DESATIVADA (MODEL)
                04 - A RELAÇÃO CURSO PROFESSOR INFORMADA NÃO ESTÁ CADASTRADA NA BASE DE DADOS (MODEL)
                05 - ID DO CURSO NÃO INFORMADO OU ZERADO (CONTROLLER)
                06 - MATRÍCULA DO PROFESSOR NÃO INFORMADA OU ZERADA (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if ($this->getIdCurso() == "" || $this->getIdCurso() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'ID do curso não informado ou zerado.'
                );
            }elseif ($this->getIdProf() == "" || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Matrícula do professor não informada ou zerada.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_cursoProf');

                //Atributo $retorno recebe array com informações da validação de acesso

                $retorno = $this->M_cursoProf->apagarCursoProf($this->getIdCurso(), $this->getIdProf());

            }
        } else {
            $retorno = array(
                'codigo' => 99,
                'msg' => 'Os campos vindos do FrontEnd não representam o método de exclusão. Verifique.'
            );
        }
        echo json_encode($retorno);
    }

    //Reativar cursoprof
    public function reativarCursoProf()
    {
        //Dados vindos do FrontEnd
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        //Fazendo os setters
        $lista = array(
            'idCurso' => '0',
            'idProf' => '0'
        );

        if (verificarParam($resultado, $lista) == 1) {
            $this->setIdCurso($resultado->idCurso);
            $this->setIdProf($resultado->idProf);

            /*
                VALIDAÇÕES NECESSÁRIAS RETORNOS POSSÍVEIS
                01 - RELAÇÃO CURSO/PROFESSOR REATIVADA COM SUCESSO (MODEL)
                02 - HOUVE UM PROBLEMA NA REATIVAÇÃO DA RELAÇÃO CURSO/PROFESSOR (MODEL)
                03 - A RELAÇÃO CURSO PROFESSOR INFORMADA JÁ ESTÁ ATIVA (MODEL)
                04 - A RELAÇÃO CURSO PROFESSOR INFORMADA NÃO ESTÁ CADASTRADA NA BASE DE DADOS (MODEL)
                05 - ID DO CURSO NÃO INFORMADO OU ZERADO (CONTROLLER)
                06 - MATRÍCULA DO PROFESSOR NÃO INFORMADA OU ZERADA (CONTROLLER)
                99 - OS CAMPOS INFORMADOS PELO FRONTEND NÃO REPRESENTAM O MÉTODO (CONTROLLER)
            */

            if (strlen($this->getIdCurso()) == 0 || $this->getIdCurso() == 0) {
                $retorno = array(
                    'codigo' => 5,
                    'msg' => 'ID do curso não informado ou zerado.'
                );
            } elseif (strlen($this->getIdProf()) == 0 || $this->getIdProf() == 0) {
                $retorno = array(
                    'codigo' => 6,
                    'msg' => 'Matrícula do professor não informada ou zerada.'
                );
            } else {
                //Realizo a instância da model
                $this->load->model('M_cursoProf');

                //Atributo $retorno recebe array com informações da validação de acesso
                $retorno = $this->M_cursoProf->reativarCursoProf($this->getIdCurso(), $this->getIdProf());
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