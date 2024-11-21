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
    <title>Reativação de aluno</title>
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
            <h1 class="text-center text-light">¡MUCHO TEXTO. ARRIBA!</h1>

            <form method="post" action="M_aluno.php" id="reativarAluno" name="reativarAluno">
                <div class="form-group mb-4">
                    <label for="raTxt" class="control-label">RA:</label>
                    <input class="form-control bg-dark text-light" placeholder="Digite o RA do aluno"
                        name="raTxt" id="raTxt" maxlength="13"/>
                </div>

            </form>

            <div class="row m-1 p-1">
                <button type="button" id="saveBtn" class="btn btn-light btn-block">
                    REATIVAR
                </button>
            </div>

            <div class="row m-1 p-1">
                <button type="button" id="returnBtn" class="btn btn-light btn-block">
                    VOLTAR
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
        $('#returnBtn').on('click', async function(e) {
            e.preventDefault();

            window.location.replace("pagIniAluno")
        });


        $('#saveBtn').on('click', async function(e) {
            e.preventDefault();

            const config = {
                method: "put",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ra: $('#raTxt').val()
                })
            };

            const request = await fetch(base_url + 'Aluno/reativarAluno', config);
            const response = await request.json();

            if (response.codigo == 5) {
                Swal.fire({
                    title: 'Atenção!',
                    text: response.codigo + ' - ' + 'RA do Aluno não informado ou zerado',
                    icon: 'warning'
                });
            } else if (response.codigo == 1) {
                Swal.fire({
                    title: response.codigo + ' - ' + 'Aluno reativado corretamente',
                    icon: 'success'
                });
            } else if (response.codigo == 2) {
                Swal.fire({
                    title: 'Atenção!',
                    text: response.codigo + ' - ' + 'Houve algum problema na reativação do aluno',
                    icon: 'warning'
                });
            } else if (response.codigo == 3) {
                Swal.fire({
                    title: 'Atenção!',
                    text: response.codigo + ' - ' + 'Aluno já ativo na base de dados',
                    icon: 'warning'
                });
            } else if (response.codigo == 4) {
                Swal.fire({
                    title: 'Atenção!',
                    text: response.codigo + ' - ' + 'Aluno não localizado',
                    icon: 'warning'
                });
            } else {
                Swal.fire({
                    title: 'Atenção!',
                    text: response.codigo + ' - ' + response.msg,
                    icon: 'error'
                });
            }
        });
    });
</script>
</html>