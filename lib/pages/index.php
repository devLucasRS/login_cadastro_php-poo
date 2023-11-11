<?php
    session_start();
    ob_start();
?>


                    <?php
                        $user = new User();
                        if (isset($_POST['submit'])) {
                            $user->sign_in($_POST['email'], $_POST['password']);
                        }
                    ?>

                        <form method="POST">
                            <div class="field">
                                <div class="control">
                                    <input name="email" name="text" class="input is-large" placeholder="Seu usuário" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="password" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>

                            <div class="field">
                                <a class="button is-block is-link is-large is-fullwidth" href="/register">Cadastrar</a>
                            </div>
                            <input name="submit" type="submit" class="button is-block is-link is-large is-fullwidth" value="Entrar">
                        </form>

</html>