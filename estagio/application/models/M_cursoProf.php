<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_curso.php");
include_once("M_professor.php");

class M_cursoProf extends CI_Model
{
    public function inserirCursoProf($idCurso, $idProf, $estatus)
    {
        $curso = new M_curso();
        $professor = new M_professor();

        $retornoCurso = $curso->consultarSoCurso($idCurso);

        if ($retornoCurso['codigo'] == 1) {
            $retornoProf = $professor->consultarSoProfessor($idProf);

            if ($retornoProf['codigo'] == 1) {
                $retornoCursoProf = $this->consultarSoCursoProf($idCurso, $idProf);

                if ($retornoCursoProf['codigo'] == 3) {
                    //Instrução de inserção de dados
                    $sql = "insert into cursoprof (id_curso, id_professor, estatus)
                            values ('$idCurso', '$idProf', '$estatus')";

                    $this->db->query($sql);

                    //Verificar se a inserção ocorreu com sucesso
                    if ($this->db->affected_rows() > 0) {
                        $dados = array(
                            'codigo' => 1,
                            'msg' => 'Relação curso/professor cadastrada com sucesso.'
                        );
                    } else {
                        $dados = array(
                            'codigo' => 2,
                            'msg' => 'Houve algum problema na inserção na tabela cursoprof.'
                        );
                    }
                } elseif ($retornoCursoProf['codigo'] == 1) {
                    $dados = array(
                        'codigo' => 3,
                        'msg' => 'Relação curso/professor já cadastrada na base de dados.'
                    );
                } else {
                    $dados = array(
                        'codigo' => 4,
                        'msg' => 'Relação curso/professor se encontra desativada na base de dados.'
                    );
                }
            } else {
                $dados = array(
                    'codigo' => 5,
                    'msg' => 'Professor não localizado.'
                );
            }
        } else {
            $dados = array(
                'codigo' => 6,
                'msg' => 'Curso não localizado.'
            );
        }
        return $dados;
    }

    public function consultarCursoProf($idCurso, $idProf, $estatus)
    {
        $sql = "select * from cursoprof
                    where estatus = '$estatus' ";

        if (trim($idCurso) != '' && trim($idCurso) != '0') {
            $sql = $sql . "and id_curso = '$idCurso'";
        }

        if (($idProf) != '') {
            $sql = $sql . "and id_professor = '$idProf' ";
        }
        $retorno = $this->db->query($sql);

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

        return $dados;
    }

    public function consultarSoCursoProf($idCurso, $idProf)
    {
        $sql = "select * from cursoprof
                where id_curso = $idCurso and id_professor = '$idProf' and estatus = ''";

        $retorno = $this->db->query($sql);

        $sqll = "select * from cursoprof
                where id_curso = $idCurso and id_professor = '$idProf' and estatus = 'D'";

        $retorno1 = $this->db->query($sqll);

        if ($retorno->num_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Consulta efetuada com sucesso.'
            );
        } elseif ($retorno1->num_rows() > 0) {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Relação de curso/professor já desativada.'
            );
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Dados não localizados.'
            );
        }
        return $dados;
    }


    public function alterarCursoProf($idCurso, $idProf, $newIdCurso)
    {
        $curso = new M_curso();
        $professor = new M_professor();

        $retornoCursoProf = $this->consultarSoCursoProf($idCurso, $idProf);

        if ($retornoCursoProf['codigo'] == 1) {

            $retornoCurso = $curso->consultarSoCurso($idCurso);
            if ($retornoCurso['codigo'] == 1) {

                $retornoProfessor = $professor->consultarSoProfessor($idProf);
                if ($retornoProfessor['codigo'] == 1) {

                    $sql = "update cursoprof set ";

                    if ($idProf != '' && $idCurso != '' && $newIdCurso != '') {
                        $sql = $sql . "id_curso = '$newIdCurso', id_professor = '$idProf'";
                    }
                    $sql = $sql . " where id_curso = '$idCurso' and id_professor = '$idProf'";

                    $this->db->query($sql);

                    if ($this->db->affected_rows() > 0) {
                        $dados = array(
                            'codigo' => 1,
                            'msg' => 'Relação curso/professor atualizada com sucesso.'
                        );
                    } else {
                        $dados = array(
                            'codigo' => 2,
                            'msg' => 'Houve algum problema na atualização da relação curso/professor.'
                        );
                    }

                } else {
                    $dados = array(
                        'codigo' => 3,
                        'msg' => 'Professor não localizado.'
                    );
                }
            } else {
                $dados = array(
                    'codigo' => 4,
                    'msg' => 'Curso não localizado.'
                );
            }
        } else {
            $dados = array(
                'codigo' => 5,
                'msg' => 'Relação curso/professor não localizada.'
            );
        }
        return $dados;
    }

    public function apagarCursoProf($idCurso, $idProf)
    {
        $retornoCursoProf = $this->consultarSoCursoProf($idCurso, $idProf);

        if ($retornoCursoProf['codigo'] == 1) {

            $sql = "update cursoprof set estatus = 'D'
                    where id_curso = $idCurso and id_professor = $idProf";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Relação curso/professor desativada corretamente.'
                    );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na desativação da relação curso/professor.'
                );
            }
        } elseif ($retornoCursoProf['codigo'] == 2) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'A relação curso/professor informada já está desativada.'
            );
            
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'A relação curso/professor informada não está cadastrada na base de dados.'
            );
        }
        return $dados;
    }

    public function reativarCursoProf($idCurso, $idProf)
    {
        $retornoCursoProf = $this->consultarSoCursoProf($idCurso, $idProf);

        if ($retornoCursoProf['codigo'] == 2) {

            $sql = "update cursoprof set estatus = ''
                    where id_curso = $idCurso and id_professor = $idProf";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Relação curso/professor reativada corretamente.'
                    );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na reativação da relação curso/professor.'
                );
            }
        } elseif ($retornoCursoProf['codigo'] == 1) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'A relação curso/professor informada já está ativa.'
            );
            
        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'A relação curso/professor informada não está cadastrada na base de dados.'
            );
        }
        return $dados;
    }

}

?>