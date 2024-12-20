<?php

defined('BASEPATH') or exit('No direct script access allowed');
include_once("M_professor.php");

class M_curso extends CI_Model
{
    public function inserirCurso($descricao, $estatus)
    {
        //Instrução de inserção dos dados
        $sql = "insert into curso (descricao, estatus)   
                values ('$descricao', '$estatus')";

        $this->db->query($sql);

        //Verificar se a inserção ocorreu com sucesso
        if ($this->db->affected_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Curso cadastrado corretamente.'
            );
        } else {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Houve algum problema na inserção do curso.'
            );
        }

        //Envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }


    public function consultarCurso($idCurso, $descricao, $estatus)
    {
        //-------------------------------------------------
        //Função que servirá para quatro tipos de consulta:
        //  * Para todos os cursos;
        //  * Para um determinado curso;
        //  * Para um determinado status;
        //  * Para nomes de cursos;
        //-------------------------------------------------

        //Query para consultar dados de acordo com parâmetros passados
        $sql = "select * from curso
            where estatus = '$estatus' ";

        if (trim($idCurso) != '' && trim($idCurso) != '0') {
            $sql = $sql . "and id_curso = '$idCurso' ";
        }

        if (trim($descricao) != '') {
            $sql = $sql . "and descricao like '%$descricao%' ";
        }

        $retorno = $this->db->query($sql);

        //Verificar se a consulta ocorreu com sucesso
        if ($retorno->num_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Consulta efetuada com sucesso.',
                'dados' => $retorno->result()
            );
        } else {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Dados não encontrados.'
            );
        }

        //Envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function consultarSoCurso($idCurso)
    {
        //--------------------------------------------------
        //Função que servirá somente para verificar se o curso está na base de dados

        //Query para consultar dados de acordo com parâmetros passados
        $sql = "select * from curso
                where id_curso = '$idCurso' 
                and estatus = ''";
        $retorno = $this->db->query($sql);

        $sqll = "select * from curso
                where id_curso = '$idCurso'
                and estatus = 'D'";
        $retorno1 = $this->db->query($sqll);

        //Verificar se a consulta ocorreu com sucesso
        if ($retorno->num_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Consulta efetuada com sucesso.'
            );
        } elseif ($retorno1->num_rows() > 0) {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Curso já desativado.'
            );
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Dados não encontrados.'
            );
        }

        //envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function alterarCurso($idCurso, $descricao)
    {
        //Verificar se o curso está cadastrado na base de dados
        $retornoCurso = $this->consultarSoCurso($idCurso);

        if ($retornoCurso['codigo'] == 2) {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Curso deletado.'
            );
        } elseif ($retornoCurso['codigo'] == 1) {

            //Instrução de inserção dos dados
            $sql = "update curso set descricao = '$descricao'
                    where id_curso = $idCurso";

            $this->db->query($sql);

            //Verificar se a atualização ocorreu com sucesso
            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Descrição do curso atualizada corretamente.'
                );

            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na atualização na descrição do curso'
                );
            }
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'O ID do curso passado não está cadastrado na base de dados.'
            );
        }
        //Envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function apagarCurso($idCurso)
    {
        if ($_SESSION['id_professor'] == true && $_SESSION['usuario'] == true && $_SESSION['senha'] == true) {
            //verificar se o curso está cadastrado na base de dados
            if ($_SESSION['permissao'] == 'S') {
                $retornoCurso = $this->consultarSoCurso($idCurso);

                if ($retornoCurso['codigo'] == 2) {
                    $dados = array(
                        'codigo' => 5,
                        'msg' => 'Curso já deletado.'
                    );
                } elseif ($retornoCurso['codigo'] == 1) {

                    //Instrução de inserção dos dados
                    $sql = "update curso set estatus = 'D'
                    where id_curso = $idCurso";

                    $this->db->query($sql);

                    //Verificar se a atualização ocorreu com sucesso
                    if ($this->db->affected_rows() > 0) {
                        $dados = array(
                            'codigo' => 1,
                            'msg' => 'Curso desativado corretamente.'
                        );
                    } else {
                        $dados = array(
                            'codigo' => 2,
                            'msg' => 'Houve algum problema na desativação do curso.'
                        );
                    }
                } else {
                    $dados = array(
                        'codigo' => 3,
                        'msg' => 'O ID do curso passado não está cadastrado na base de dados.'
                    );
                }
            } else {
                $dados = array(
                    'codigo' => 4,
                    'msg' => 'Sem permissão.'
                );
            }
        }  else {
            $dados = array(
                'codigo' => 444,
                'msg' => '¡¿QUE HACES AQUÍ, CABRON?!'
            );
        }
        //Envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

}