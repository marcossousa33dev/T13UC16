<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once("M_aluno.php");
include_once("M_professor.php");

class M_documentacao extends CI_Model
{


    public function inserirDocumentacao($semestre_ano, $ra, $tcer, $tcenr, $desc_atividades, $ficha_valid_estagio, $rel_atividades, $rescisao, $rel_equivalencia, $observacoes, $estatus)
    {
        $aluno = new M_aluno();
        $retornoAluno = $aluno->consultarSoAluno($ra);

        if ($retornoAluno['codigo'] == 1) {

            $retornoDocumentacao = $this->consultarSoDocumentacao($semestre_ano, $ra);

            if ($retornoDocumentacao['codigo'] == 3) {

                $sql = "insert into documentacao (semestre_ano, ra_aluno, tcer, tcenr, desc_atividades, ficha_valid_estagio, rel_atividades, rescisao, rel_equivalencia, observacoes, estatus)
                values ($semestre_ano, '$ra', $tcer, $tcenr, $desc_atividades, $ficha_valid_estagio, $rel_atividades, $rescisao, $rel_equivalencia, '$observacoes', '$estatus')";

                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Documentação cadastrada com sucesso.'
                    );
                } else {
                    $dados = array(
                        'codigo' => 2,
                        'msg' => 'Houve algum problema na inserção dos documentos.'
                    );
                }
            } elseif ($retornoDocumentacao['codigo'] == 2) {
                $dados = array(
                    'codigo' => 3,
                    'msg' => 'Documentação se encontra desativada na base de dados.'
                );

            } elseif ($retornoDocumentacao['codigo'] == 1) {
                $dados = array(
                    'codigo' => 4,
                    'msg' => 'Documentação já se encontra na base de dados.'
                );
            }
        } else {
            $dados = array(
                'codigo' => 5,
                'msg' => 'Aluno não localizado.'
            );
        }
        return $dados;
    }
    public function consultarDocumentacao($semestre_ano, $ra, $tcer, $tcenr, $desc_atividades, $ficha_valid_estagio, $rel_atividades, $rescisao, $rel_equivalencia, $estatus)
    {
        $sql = "select * from documentacao
                where estatus = '$estatus' ";

        if (($ra) != '') {
            $sql = $sql . "and ra_aluno = '$ra' ";
        }
        if (($semestre_ano) != '') {
            $sql = $sql . "and semestre_ano = $semestre_ano ";
        }
        if (trim($tcer) != '' && trim($tcer) != '0') {
            $sql = $sql . "and tcer = $tcer ";
        }
        if (trim($tcenr) != '' && trim($tcenr) != '0') {
            $sql = $sql . "and tcenr = $tcenr ";
        }
        if (trim($desc_atividades) != '' && trim($desc_atividades) != '0') {
            $sql = $sql . "and desc_atividades = $desc_atividades ";
        }
        if (trim($ficha_valid_estagio) != '' && trim($ficha_valid_estagio) != '0') {
            $sql = $sql . "and ficha_valid_estagio = $ficha_valid_estagio ";
        }
        if (trim($rel_atividades) != '' && trim($rel_atividades) != '0') {
            $sql = $sql . "and rel_atividades = $rel_atividades ";
        }
        if (trim($rescisao) != '' && trim($rescisao) != '0') {
            $sql = $sql . "and rescisao = $rescisao ";
        }
        if (trim($rel_equivalencia) != '' && trim($rel_equivalencia) != '0') {
            $sql = $sql . "and rel_equivalencia = $rel_equivalencia ";
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
    public function consultarSoDocumentacao($semestre_ano, $ra)
    {

        $sql = "select * from documentacao where semestre_ano = $semestre_ano and ra_aluno = '$ra' and estatus = ''";

        $retorno = $this->db->query($sql);

        $sqll = "select * from documentacao where semestre_ano = $semestre_ano and ra_aluno = '$ra' and estatus = 'D'";

        $retorno1 = $this->db->query($sqll);

        if ($retorno->num_rows() > 0) {
            $dados = array(
                'codigo' => 1,
                'msg' => 'Consulta efetuada com sucesso.'
            );

        } elseif ($retorno1->num_rows() > 0) {
            $dados = array(
                'codigo' => 2,
                'msg' => 'Documentação desativada.'
            );
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Dados não localizados.'
            );
        }
        return $dados;
    }
    public function alterarDocumentacao($semestre_ano, $ra, $tcer, $tcenr, $desc_atividades, $ficha_valid_estagio, $rel_atividades, $rescisao, $rel_equivalencia, $observacoes)
    {
        $retornoDocumentacao = $this->consultarSoDocumentacao($semestre_ano, $ra);

        if ($retornoDocumentacao['codigo'] == 1) {
            $sql = "update documentacao set ";
            if ($tcer != "") {
                $sql = $sql . "tcer = $tcer,";
            }
            if ($tcenr != "") {
                $sql = $sql . "tcenr = $tcenr,";
            }
            if ($desc_atividades != "") {
                $sql = $sql . "desc_atividades = $desc_atividades,";
            }
            if ($ficha_valid_estagio != "") {
                $sql = $sql . "ficha_valid_estagio = $ficha_valid_estagio,";
            }
            if ($rel_atividades != "") {
                $sql = $sql . "rel_atividades = $rel_atividades,";
            }
            if ($rescisao != "") {
                $sql = $sql . "rescisao = $rescisao,";
            }
            if ($rel_equivalencia != "") {
                $sql = $sql . "rel_equivalencia = $rel_equivalencia,";
            }
            if ($observacoes != "") {
                $sql = $sql . "observacoes = '$observacoes',";
            }

            $sql = rtrim($sql, ",");

            $sql = $sql . " where ra_aluno = '$ra' 
            and semestre_ano = $semestre_ano";
            $this->db->query($sql);


            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Documentação atualizada com sucesso.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na atualização dos documentos.'
                );
            }
        } else {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Documentação não localizada.'
            );
        }
        return $dados;
    }
    public function apagarDocumentacao($semestre_ano, $ra, $idProf)
    {
        if ($_SESSION['id_professor'] == $idProf && $_SESSION['permissao'] == 'S') {

            $retornoDocumentacao = $this->consultarSoDocumentacao($semestre_ano, $ra);

            if ($retornoDocumentacao['codigo'] == 1) {

                $sql = "update documentacao set estatus = 'D'
                    where ra_aluno = '$ra' and semestre_ano = $semestre_ano";
                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array(
                        'codigo' => 1,
                        'msg' => 'Documentação excluida com sucesso.'
                    );
                } else {
                    $dados = array(
                        'codigo' => 2,
                        'msg' => 'Houve algum problema na desativação da documentação.'
                    );
                }

            } elseif ($retornoDocumentacao['codigo'] == 2) {
                $dados = array(
                    'codigo' => 3,
                    'msg' => 'Documentação já desativada.'
                );
            } else {
                $dados = array(
                    'codigo' => 4,
                    'msg' => 'Documentação não localizada.'
                );
            }
        } else {
            $dados = array(
                'codigo' => 5,
                'msg' => 'Sem permissão.'
            );
        }

        return $dados;
    }

    public function reativarDocumentacao($semestre_ano, $ra)
    {
        $retornoDocumentacao = $this->consultarSoDocumentacao($semestre_ano, $ra);

        if ($retornoDocumentacao['codigo'] == 2) {

            $sql = "update documentacao set estatus = ''
                    where ra_aluno = '$ra' and semestre_ano = $semestre_ano ";
            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array(
                    'codigo' => 1,
                    'msg' => 'Documentação reativada com sucesso.'
                );
            } else {
                $dados = array(
                    'codigo' => 2,
                    'msg' => 'Houve algum problema na reativação da documentação.'
                );
            }
        } elseif ($retornoDocumentacao['codigo'] == 1) {
            $dados = array(
                'codigo' => 3,
                'msg' => 'Documentação já ativa na base de dados.'
            );

        } else {
            $dados = array(
                'codigo' => 4,
                'msg' => 'Documentação não localizada.'
            );
        }
        return $dados;
    }


}

?>