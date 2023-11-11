<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Cadastro</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Sistema de Cadastro</h3>
                    <div class="notification is-info">
                        <p>A conta que você criar por aqui, poderá ser usada no servidor.</p>
                    </div>
                    <div class="box">
                    <?php
                      $user = new User();
                        if (isset($_POST['submit'])) {
                            $user->sign_up($_POST['username'], $_POST['email'], $_POST['name'], $_POST['password']);
                        }
                    ?>
                        <form method="POST">
                            <div class="field">
                                <div class="control">
                                    <input name="name" type="text" class="input is-large" placeholder="Nome" autofocus required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input name="email" type="email" class="input is-large" placeholder="Email" autofocus required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input name="username" type="text" class="input is-large" placeholder="Usuário" required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input name="password" class="input is-large" type="password" placeholder="Senha" required>
                                </div>
                            </div>
                            <div class="field">
                                <input name="submit" type="submit" class="button is-block is-link is-large is-fullwidth" value="Cadastrar">
                            </div>
                            <a href="/" class="button is-block is-link is-large is-fullwidth">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>