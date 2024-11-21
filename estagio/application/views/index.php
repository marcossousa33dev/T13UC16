<!DOCTYPE html>
<html>

<head>
    <title>Login - Sistema de Estágio</title>
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
            <h1 class="text-center text-light">Acesso ao sistema</h1>
            <form method="post" action="M_professor.php" id="formlogin" name="formlogin">
                <div class="form-group mb-4">
                    <label for="idProfTxt" class="control-label">Matrícula:</label>
                    <input class="form-control bg-dark text-light" placeholder="Digite sua matrícula"
                        name="idProfTxt" id="idProfTxt" maxlength="20" />
                </div>

                <div class="form-group mb-4">
                    <label for="loginTxt" class="control-label">Usuário:</label>
                    <input class="form-control bg-dark text-light" placeholder="Digite seu usuário" name="loginTxt"
                        id="loginTxt" maxlength="15" />
                </div>

                <div class="form-group mb-4">
                    <label for="senhaTxt" class="control-label">Senha:</label>
                    <input type="password" class="form-control bg-dark text-light" placeholder="Digite sua senha"
                        name="senhaTxt" id="senhaTxt" maxlength="20" />
                </div>

                <div class="row m-0 p-0">
                    <button type="button" id="loginBtn" class="btn btn-light btn-block">
                        ACESSAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

<script src="<?php echo base_url("assets/js/jquery-3.6.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
    var base_url = "<?= base_url();?>"
    $(document).ready(function () {
        $('#loginBtn').on('click', async function (e) {
            e.preventDefault();

            const config = {
                method: "post",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    idProf: $('#idProfTxt').val(),
                    usuario: $('#loginTxt').val(),
                    senha: $('#senhaTxt').val()
                })
            };

            const request = await fetch(base_url + 'Professor/login', config);
            const response = await request.json();

            if (response.codigo == 1) {
                Swal.fire({
                    title: 'Acesso permitido',
                    text: response.codigo + ' - ' + 'Bem-vindo ao sistema de Estágio.',
                    icon: 'success'
                }).then(function() {
                    window.location.replace("funcoes/abrirHome");
                });
            } else if (response.codigo == 2) {
                Swal.fire({
                    title: 'Acesso negado',
                    text: response.codigo + ' - ' + 'Por favor, contate a administração.',
                    icon: 'warning'
                });
            }
            else {
                Swal.fire({
                    title: 'Atenção!',
                    text: response.codigo + ' - ' + response.msg,
                    icon: 'error'
                });
            }
        });
    });
</script>
</body>
</html>