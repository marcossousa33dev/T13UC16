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
    <title>Cursos</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/sweetalert2.min.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>" type="text/css" />
</head>

<body class="h-100 bg-dark">
    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="content bg-secondary">
            <h1 class="text-center text-light">Selecione a opção desejada</h1>

            <div class="row m-1 p-1">
                <button type="button" id="inserirCursoBtn" class="btn btn-light btn-block">
                    INSERIR CURSO
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="consultarCursoBtn" class="btn btn-light btn-block">
                    CONSULTAR CURSO
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="alterarCursoBtn" class="btn btn-light btn-block">
                    ALTERAR INFORMAÇÕES DE CURSO
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="apagarCursoBtn" class="btn btn-light btn-block">
                    APAGAR CURSO
                </button>
            </div>
        </div>
    </div>
</body>

<script src="<?php echo base_url("assets/js/jquery-3.6.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
    var base_url = "<?= base_url();?>"
    $(document).ready(function () {
        $('#inserirCursoBtn').on('click', async function(e) {
            e.preventDefault();

            window.location.href = "inserirCurso";
        });

        $('#consultarCursoBtn').on('click', async function(e) {
            e.preventDefault();

            window.location.href = "inserirCurso";
        });

        $('#alterarCursoBtn').on('click', async function(e) {
            e.preventDefault();

            window.location.href = "consultarCurso";
        });

        $('#apagarCursoBtn').on('click', async function(e) {
            e.preventDefault();

            window.location.href = "apagarCurso";
        });

    });
</script>
</html>