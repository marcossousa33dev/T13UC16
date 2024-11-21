<!DOCTYPE html>
<html>

<head>
    <?php
    session_start();

    if ((!isset($_SESSION['id_professor']) == true) && (!isset($_SESSION['usuario']) == true) && (!isset($_SESSION['senha']) == true)) {
        header('location:index.php');
    }

    $logado = $_SESSION['usuario'];

    ?>
    <title>Página inicial</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/sweetalert2.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>" type="text/css" />
</head>

<body class="h-100 bg-dark">
    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="content bg-secondary">
            <h1 class="text-center text-light">Sistema de Estágio</h1>
            <h2 class="text-center text-warning">
                <?php
                echo "$logado";
                ?>
            </h2>
            <div class="row m-1 p-1">
                <button type="button" id="alunosBtn" class="btn btn-light btn-block">
                    ALUNOS
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="cursosBtn" class="btn btn-light btn-block">
                    CURSOS
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="professorBtn" class="btn btn-light btn-block">
                    PROFESSOR
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="atendimentoBtn" class="btn btn-light btn-block">
                    ATENDIMENTO
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="documentacaoBtn" class="btn btn-light btn-block">
                    DOCUMENTAÇÕES
                </button>
            </div>
        </div>
    </div>
</body>

<script src="<?php echo base_url("assets/js/jquery-3.6.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
    var base_url = "<?= base_url(); ?>"
    $(document).ready(function () {
        //Alunos
        $('#alunosBtn').on('click', async function (e) {
            e.preventDefault();

            window.location.href = "pagIniAluno";
        });

        //Cursos
        $('#cursosBtn').on('click', async function (e) {
            e.preventDefault();

            window.location.href = "pagIniCurso";
        });

        //Professores
        $('#professorBtn').on('click', async function (e) {
            e.preventDefault();

            window.location.href = "pagIniProfessor";
        });

        //Atendimento
        $('#atendimentoBtn').on('click', async function (e) {
            e.preventDefault();

            window.location.href = "pagIniAtendimento";
        });

        //Documentação
        $('#documentacaoBtn').on('click', async function (e) {
            e.preventDefault();

            window.location.href = "pagIniDocs";
        });

    });
</script>

</html>