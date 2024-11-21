<?php

defined('BASEPATH') or exit('No direct script access allowed');

//Incluir a classe que precisamos instanciar
include_once("M_curso.php");
include_once("M_professor.php");

class M_aluno extends CI_Model
{
    public function inserirAluno($ra, $idCurso, $nome, $estatus)
    {
        //verificar se o curso está cadastrado
        //realizar a instância do objeto curso
        $curso = new M_curso();

        //chamar o método de verificação
        $retornoCurso = $curso->consultarSoCurso($idCurso);

        if ($retornoCurso['codigo'] == 1) {
            //Verificar se o aluno já se encontra na base de dados
            $retornoAluno = $this->consultarSoAluno($ra);

            if ($retornoAluno['codigo'] == 3) {
                //Instrução de inserção de dados
                $sql = "insert into aluno (ra, id_curso, nome, estatus)
                        values ('$ra', $idCurso, '$nome', '$estatus')";

                $this->db->query($sql);

                //Verificar se a inserção ocorreu com sucesso
                if ($this->db->affected_rows() > 0) {
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Aluno cadastrado corretamente.'
                    );
                } else {
                    $dados = array(
                        'codigo' => 2,
                        'msg' => 'Houve algum problema no cadastro no cadastro do aluno.'
                    );
                }
            } elseif ($retornoAluno['codigo'] == 2) {
                $dados = array(
                    'codigo' => 3,
                    'msg' => 'Aluno se encontra desativado na base de dados.'
                );
            } else {
                $dados = array(
                    'codigo' => 4,
                    'msg' => 'Aluno já se encontra cadastrado na base de dados.'
                );
            }
        } else {
            $dados = array(
                'codigo' => 5,
                'msg' => 'Curso informado não cadastrado na base de dados.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function consultarAluno($ra, $idCurso, $nome, $estatus)
    {
        //--------------------------------------------------
        //Função que servirá para quatro tipos de consulta:
        // * Para todos os alunos;
        // * Para um determinado aluno;
        // * Para um determinado status;
        // * Para nome do aluno;
        //---------------------------------------------------

        //Query para consultar dados de acordo com parâmetros passados
        $sql = "select * from aluno
                where estatus = '$estatus' ";

        if (($ra) != '') {
            $sql = $sql . "and ra = '$ra' ";
        }

        if (trim($idCurso) != '' && trim($idCurso) != '0') {
            $sql = $sql . "and id_curso = '$idCurso' ";
        }

        if (trim($nome) != '') {
            $sql = $sql . "and nome like '%$nome%' ";
        }

        $retorno = $this->db->query($sql);

        $sqll = "select * from aluno
                where ra = '$ra'
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
                'msg' => 'Aluno se encontra desativado na base de dados.'
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

    public function consultarSoAluno($ra)
    {
        //--------------------------------------------------
        //Função que servirá somente para verificar se o aluno está na base de dados

        //Query para consultar dados de acordo com parâmetros passados
        $sql = "select * from aluno
                where ra = '$ra'
                    and estatus = ''";

        $retorno = $this->db->query($sql);

        $sqll = "select * from aluno
                where ra = '$ra'
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
                'msg' => 'Aluno desativado.'
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

    public function alterarAluno($ra, $idCurso, $nome)
    {
        // Verificar se o curso está cadastrado na base de dados
        // Realizar a instância do objeto curso

        $curso = new M_curso();

        //Chamar o método de verificação

        //Verificar se o aluno já se encontra na base de dados
        $retornoAluno = $this->consultarSoAluno($ra);
        $retornoCurso = $curso->consultarSoCurso($idCurso);

        if ($retornoAluno['codigo'] == 1) {

            if ($retornoCurso['codigo'] == 2 || $retornoCurso['codigo'] == 3) {
                $dados = array(
                    'codigo' => 5,
                    'msg' => 'Curso não localizado'
                );
            } else {
                // Instrução de inserção dos dados
                $sql = "update aluno set ";

                if ($idCurso != "" && $nome != "") {
                    $sql = $sql . "id_curso = $idCurso, nome = '$nome'";
                } elseif ($nome != "") {
                    $sql = $sql . "nome = '$nome'";
                }

                // if($idCurso != "")
                else {
                    $sql = $sql . "id_curso = $idCurso";
                }

                $sql = $sql . " where ra = '$ra'";

                $this->db->query($sql);
                //Verificar se a atualização ocorreu com sucesso
                if ($this->db->affected_rows() > 0) {
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Dados do aluno atualizados corretamente.'
                    );
                } else {
                    $dados = array(
                        'codigo' => 2,
                        'msg' => 'Houve algum problema na atualização do aluno.'
                    );
                }
            }


        } elseif ($retornoAluno['codigo'] == 2) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Não é possível alterar, pois o aluno está desativado.'
            );
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Aluno não localizado.'
            );
        }

        //Envia o array $dados com as informtações tratadas
        //acima pela estrutura de decisão if
        return $dados;
    }

    public function apagarAluno($ra)
    {
        if ($_SESSION['id_professor'] == true && $_SESSION['usuario'] == true && $_SESSION['senha'] == true) {

            if ($_SESSION['permissao'] == 'S') {
                $retornoAluno = $this->consultarSoAluno($ra);

                if ($retornoAluno['codigo'] == 1) {
                    //Instrução de inserção dos dados

                    $sql = "update aluno set estatus = 'D'
                        where ra = '$ra'";

                    $this->db->query($sql);

                    //Verificar se a atualização ocorreu com sucesso

                    if ($this->db->affected_rows() > 0) {
                        $dados = array(
                            'codigo' => 1,
                            'msg' => 'Aluno desativado corretamente.'
                        );
                    } else {
                        $dados = array(
                            'codigo' => 2,
                            'msg' => 'Houve alum problema na desativação do aluno.'
                        );
                    }
                } elseif ($retornoAluno['codigo'] == 2) {
                    $dados = array(
                        'codigo' => 3,
                        'msg' => 'Aluno já desativado.'
                    );
                } else {
                    $dados = array(
                        'codigo' => 4,
                        'msg' => 'O RA informado não está cadastrado na base de dados.'
                    );
                }
            } else {
                $dados = array(
                    'codigo' => 5,
                    'msg' => 'Sem permissão.'
                );
            }

        } else {
            $dados = array(
                'codigo' => 444,
                'msg' => '¡¿QUE HACES AQUÍ, CABRON?!'
            );
        }

        //Envia o array $dados com as informações tratadas
        //acima pela estrutura de decisão if

        return $dados;
    }

    public function reativarAluno($ra)
    {
        $retornoAluno = $this->consultarSoAluno($ra);

        if ($retornoAluno['codigo'] == 2) {
            $sql = "update aluno set estatus = ''
                    where ra = '$ra'";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Aluno reativado corretamente.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na reativação do aluno.'
                );
            }
        } elseif ($retornoAluno['codigo'] == 1) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Aluno já ativo na base de dados.'
            );
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Aluno não localizado.'
            );
        }

        return $dados;
    }

}
?>