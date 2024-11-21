<?php
session_start();

defined('BASEPATH') or exit('No direct script access allowed');

class M_professor extends CI_Model
{
    public function inserirProfessor($idProf, $nome, $usuario, $senha, $estatus, $permissao)
    {

        $retornoProfessor = $this->consultarSoProfessor($idProf);

        if ($retornoProfessor['codigo'] == 3) {
            //Instrução de inserção de dados
            $sql = "insert into professor (id_professor, nome, usuario, senha, estatus, permissao)
                    values ('$idProf', '$nome', '$usuario', '$senha', '$estatus', '$permissao')";

            $this->db->query($sql);

            //Verificar se a inserção ocorreu com sucesso
            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Professor cadastrado corretamente.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema no cadastro do professor.'
                );
            }
        } elseif ($retornoProfessor['codigo'] == 2) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Professor se encontra desativado na base de dados.'
            );
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Professor já se encontra cadastrado na base de dados.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function consultarProfessor($idProf, $nome, $usuario, $senha, $estatus)
    {

        //--------------------------------------------------
        //Função que servirá para quatro tipos de consulta:
        // * Para todos os professores;
        // * Para um determinado professor;
        // * Para um determinado status;
        // * Para nome do professor;
        //---------------------------------------------------

        //Query para consultar dados de acordo com parâmetros passados

        $sql = "select * from professor
                where estatus = '$estatus' ";


        if (($idProf) != '') {
            $sql = $sql . "and id_professor = '$idProf' ";
        }

        if (trim($nome) != '') {
            $sql = $sql . "and nome like '%$nome%' ";
        }

        if (trim($usuario) != '') {
            $sql = $sql . "and usuario like '%$usuario%' ";
        }

        $retorno = $this->db->query($sql);

        $sqll = "select * from professor
                where id_professor = '$idProf'
                    and estatus = 'D'";

        $retorno1 = $this->db->query($sqll);

        //Verificar se a consulta ocorreu com sucesso
        if ($retorno->num_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Consulta efetuada com sucesso.',
                'dados' => $retorno->result()
            );
        } elseif ($retorno1->num_rows() > 0) {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Professor se encontra desativado na base de dados.'
            );
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Dados não encontrados.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function consultarSoProfessor($idProf)
    {
        //--------------------------------------------------
        //Função que servirá somente para verificar se o professor está na base de dados

        //Query para consultar dados de acordo com parâmetros passados

        $sql = "select * from professor
                where id_professor = '$idProf'
                    and estatus = ''";

        $retorno = $this->db->query($sql);

        $sqll = "select * from professor
                where id_professor = '$idProf'
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
                'msg' => 'Professor desativado.'
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

    public function alterarProfessor($idProf, $nome, $usuario, $senha, $permissao)
    {
        //Chamar o método de verificação

        //Verificar se o professor já se encontra na base de dados

        $retornoProfessor = $this->consultarSoProfessor($idProf);

        if ($retornoProfessor['codigo'] == 1) {
            //Instrução de inserção dos dados

            if ($nome != "" && $usuario != "" && $senha != "" && $permissao != "") {
                $sql = "update professor set nome = '$nome', usuario = '$usuario', senha = '$senha', permissao = '$permissao'";
            } elseif ($nome != "" && $usuario != "") {
                $sql = "update professor set nome = '$nome', usuario = '$usuario'";
            } elseif ($nome != "" && $senha != "") {
                $sql = "update professor set nome = '$nome', senha = '$senha'";
            } elseif ($nome != "" && $permissao != "") {
                $sql = "update professor set nome = '$nome', permissao = '$permissao'";
            } elseif ($usuario != "" && $senha != "") {
                $sql = "update professor set usuario = '$usuario', senha = '$senha'";
            } elseif ($usuario != "" && $permissao != "") {
                $sql = "update professor set usuario = '$usuario', permissao = '$permissao'";
            } elseif ($senha != "" && $permissao != "") {
                $sql = "update professor set senha = '$senha', permissao = '$permissao'";
            } elseif ($nome != "") {
                $sql = "update professor set nome = '$nome'";
            } elseif ($usuario != "") {
                $sql = "update professor set usuario = '$usuario'";
            } elseif ($senha != "") {
                $sql = "update professor set senha = '$senha'";
            } else {
                $sql = "update professor set permissao = '$permissao'";
            }

            $sql = $sql . " where id_professor = $idProf";

            //echo $sql;
            $this->db->query($sql);

            //Verificar se a atualização ocorreu com sucesso
            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Dados do professor atualizados corretamente.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na alteração dos dados.'
                );
            }
        } elseif ($retornoProfessor['codigo'] == 3) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Não é possível alterar, pois o professor está desativado.'
            );
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Matrícula não cadastrada na base de dados.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function login($idProf, $usuario, $senha, $permissao)
    {

        $sql = "select * from professor where id_professor = $idProf and usuario = '$usuario' and senha = '$senha' and estatus = ''";

        $retorno = $this->db->query($sql);

        $sqll = "select * from professor where id_professor = $idProf and usuario = '$usuario' and senha = '$senha'";

        $retorno1 = $this->db->query($sqll);


        if ($retorno->num_rows() > 0) {
            $teste = $retorno->row();
            $_SESSION['id_professor'] = $teste->id_professor;
            $_SESSION['usuario'] = $teste->usuario;
            $_SESSION['senha'] = $teste->senha;
            $_SESSION['permissao'] = $teste->permissao;

            $dados = array(
                'codigo' => 1,
                'msg' => 'Acesso permitido. Bem vindo.'
            );
        } elseif ($retorno1->num_rows() > 0) {

            $retornoProfessor = $this->consultarSoProfessor($idProf);

            if ($retornoProfessor['codigo'] == 2) {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Acesso negado. Por favor, contate a administração.'
                );
            }
        } else {
            unset($_SESSION['id_professor']);
            unset($_SESSION['usuario']);
            unset($_SESSION['senha']);
            unset($_SESSION['permissao']);

            $dados = array(

                'codigo' => 3,
                'msg' => 'Dados não localizados.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function apagarProfessor($idProf)
    {
        $retornoProfessor = $this->consultarSoProfessor($idProf);

        if ($retornoProfessor['codigo'] == 1) {

            //Instrução de inserção dos dados
            $sql = "update professor set estatus = 'D'
                where id_professor = $idProf";

            $this->db->query($sql);

            //Verificar se a atualização ocorreu com sucesso
            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Professor desativado corretamente.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na desativação do professor.'
                );
            }
        } elseif ($retornoProfessor['codigo'] == 3) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Professor já desativado.'
            );
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Matrícula não cadastrada na base de dados.'
            );
        }

        //Envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function reativarProfessor($idProf)
    {
        $retornoProfessor = $this->consultarSoProfessor($idProf);

        if ($retornoProfessor['codigo'] == 3) {
            $sql = "update professor set estatus = ''
                    where id_professor = $idProf";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Professor reativado corretamente.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na reativação do professor.'
                );
            }
        } elseif ($retornoProfessor['codigo'] == 1) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Professor já ativo na base de dados.'
            );
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Matrícula não cadastrada na base de dados.'
            );
        }

        return $dados;
    }

}
?>