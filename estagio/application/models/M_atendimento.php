<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_professor.php");
include_once("M_aluno.php");

class M_atendimento extends CI_Model
{
    public function registraAtendimento($codAtendimento, $ra, $idProf, $dataAtendimento, $horaAtendimento, $descricao, $estatus)
    {

        $professor = new M_professor();
        $aluno = new M_aluno();

        $retornoAtendimento = $this->consultarSoAtendimento($codAtendimento);
        // $retornoProfessor = $professor->consultarSoProfessor($idProf);

        if ($retornoAtendimento['codigo'] == 3) {

            $retornoAluno = $aluno->consultarSoAluno($ra);

            if ($retornoAluno['codigo'] == 1 || $retornoAluno['codigo'] == 2) {
                //Instrução de inserção de dados

                $sql = "insert into atendimento (cod_atendimento, ra, id_professor, data_atendimento, hora_atendimento, descricao, estatus)
                        values ('$codAtendimento', '$ra', '$idProf', '$dataAtendimento', '$horaAtendimento', '$descricao', '$estatus')";

                $this->db->query($sql);

                //Verificar se a inserção ocorreu com sucesso

                if ($this->db->affected_rows() > 0) {
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Atendimento registrado com sucesso.'
                    );
                } else {
                    $dados = array(
                        'codigo' => 2,
                        'msg' => 'Houve um problema no registro.'
                    );
                }
            } else {
                $dados = array(
                    'codigo' => 3,
                    'msg' => 'Aluno não cadastrado na base de dados.'
                );
            }

        } elseif ($retornoAtendimento['codigo'] == 2) {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Atendimento está finalizado.'
            );
        } else {
            $dados = array(
                'codigo' => 5,
                'msg' => 'Atendimento já registrado na base de dados.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function consultaAtendimento($codAtendimento, $ra, $idProf, $estatus)
    {
        //--------------------------------------------------
        //Função que servirá para três tipos de consulta:
        // * Para todos os atendimentos;
        // * Para um determinado atendimento;
        // * Para um determinado status;
        //---------------------------------------------------

        //Query para consultar dados de acordo com parâmetros passados

        $sql = "select * from atendimento where estatus = '$estatus' ";

        if (($codAtendimento) != '') {
            $sql = $sql . "and cod_atendimento = '$codAtendimento' ";
        }

        if (trim($ra) != '' && trim($ra) != '0') {
            $sql = $sql . "and ra = '$ra' ";
        }

        if (trim($idProf) != '' && trim($idProf) != '0') {
            $sql = $sql . "and id_professor = '$idProf' ";
        }

        $retorno = $this->db->query($sql);

        //Verificar se a consulta ocorreu com sucesso
        if ($retorno->num_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Consulta realizada com sucesso.',
                'dados' => $retorno->result()
            );
        } else {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Atendimento não localizado.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function consultarSoAtendimento($codAtendimento)
    {
        //--------------------------------------------------
        //Função que servirá somente para verificar se o atendimento está na base de dados

        //Query para consultar dados de acordo com parâmetros passados

        $sql = "select * from atendimento where cod_atendimento = '$codAtendimento' and estatus = ''";

        $retorno = $this->db->query($sql);

        $sqll = "select * from atendimento where cod_atendimento = '$codAtendimento' and estatus = 'F'";

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
                'msg' => 'Atendimento já finalizado.'
            );
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Dados não encontrados.'
            );
        }

        //Envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function alteraAtendimento($codAtendimento, $dataAtendimento, $horaAtendimento, $descricao, $estatus)
    {
        // Verificar se o professor e o aluno estão cadastrados na base de dados
        // Realizar a instância dos objetos professor e aluno

        //Verificar se o atendimento já se encontra na base de dados
        $retornoAtendimento = $this->consultarSoAtendimento($codAtendimento);


        if ($retornoAtendimento['codigo'] == 1) {
            //Instrução de inserção dos dados
            $sql = "update atendimento set ";

            //Alteração informando todos os campos 
            if ($dataAtendimento != "" && $horaAtendimento != "" && $descricao != "" && $estatus == "") {
                $sql = $sql . "data_atendimento = '$dataAtendimento', hora_atendimento = '$horaAtendimento', descricao = '$descricao', estatus = '$estatus'";
            }
            //Alteração sem informar hora 
            elseif ($dataAtendimento != "" && $descricao != "" && $estatus == "") {
                $sql = $sql . "data_atendimento = '$dataAtendimento', descricao = '$descricao', estatus = '$estatus'";
            }
            //Alteração sem informar data 
            elseif ($horaAtendimento != "" && $descricao != "" && $estatus == "") {
                $sql = $sql . "hora_atendimento = '$horaAtendimento', descricao = '$descricao', estatus = '$estatus'";
                
            } 
            //Alteração sem informar descrição 
            elseif ($dataAtendimento != "" && $horaAtendimento != "" && $estatus == "") {
                $sql = $sql . "data_atendimento = '$dataAtendimento', hora_atendimento = '$horaAtendimento', estatus = '$estatus'";
                
            } 
            //Alteração sem informar status
            elseif ($dataAtendimento != "" && $horaAtendimento != "" && $descricao != "") {
                $sql = $sql . "data_atendimento = '$dataAtendimento', hora_atendimento = '$horaAtendimento', descricao = '$descricao'";
            } 

            //Alterando só data e hora
            elseif ($dataAtendimento != "" && $horaAtendimento != "") {
                $sql = $sql . "data_atendimento = '$dataAtendimento', hora_atendimento = '$horaAtendimento'";
            } 
            //Alterando só data e descrição
            elseif ($dataAtendimento != "" && $descricao != "") {
                $sql = $sql . "data_atendimento = '$dataAtendimento', descricao = '$descricao'";
            } 
            //Alterando só data e status
            elseif ($dataAtendimento != "" && $estatus == "") {
                $sql = $sql . "data_atendimento = '$dataAtendimento', estatus = '$estatus'";
            } 
            //Alterando só hora e descrição
            elseif ($horaAtendimento != "" && $descricao != "") {
                $sql = $sql . "hora_atendimento = '$horaAtendimento', descricao = '$descricao'";
            }
            //Alterando só hora e status 
            elseif ($horaAtendimento != "" && $estatus == "") {
                $sql = $sql . "hora_atendimento = '$horaAtendimento', estatus = '$estatus'";
            } 
            //Alterando descrição e status
            elseif ($descricao != "" && $estatus == "") {
                $sql = $sql . "descricao = '$descricao', estatus = '$estatus'";
            } 
            //Alterando só o status
            else {
                $sql = $sql . "estatus = '$estatus'";
            }

            $sql = $sql . " where cod_atendimento = $codAtendimento";

            $this->db->query($sql);

            //Verificar se a atualização ocorreu com sucesso
            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Atendimento alterado com sucesso.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Nada foi alterado.'
                );
            }

        } elseif ($retornoAtendimento['codigo'] == 2) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Não é possível alterar um atendimento já finalizado.'
            );
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Atendimento não localizado.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function finalizaAtendimento($codAtendimento) {
        $retornoAtendimento = $this->consultarSoAtendimento($codAtendimento);

        if($retornoAtendimento['codigo'] == 1) {
            $sql = "update atendimento set estatus = 'F' where cod_atendimento = $codAtendimento";

            $this->db->query($sql);

            if($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Atendimento finalizado com sucesso.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Não foi possível finalizar o atendimento. Tente novamente ou contate o suporte.'
                );
            }
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Atendimento não localizado.'
            );
        }

        return $dados;
    }
}
?>