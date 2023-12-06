<?php
    session_start();

    function LoginUsuario($usuario, $senha){
        $sql = "
                select cd_usuario, nm_usuario, cd_senha 
                from tb_usuarios
                where nm_usuario = :usuario
                limit 1
        ";

        $query_banco = $GLOBALS["conn"]->prepare($sql);
        $query_banco->bindParam("usuario", $usuario);
        $query_banco->execute();

        $tupla_usuario = $query_banco->fetch(PDO::FETCH_ASSOC);

        if($tupla_usuario && password_verify($senha, $tupla_usuario["cd_senha"])){
            //echo "encontrei o usuario " . $tupla_usuario["nm_usuario"];
            SalvarLogin($tupla_usuario);
        } else {
            $_SESSION["msg-login"] = "<p style='color:#f00;'>Usuário ou senha inválidos</p>";
        }
    }

    function SalvarLogin($tupla_usuario){
        $header = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];
        $header = json_encode($header);
        $header = base64_encode($header);
        
        //paylaod
        $duracao = time() + strtotime("+1 month");
        $payload = [
            "exp" => $duracao,
            "cd_usuario" => $tupla_usuario["cd_usuario"],
            "nm_usuario" => $tupla_usuario["nm_usuario"]
        ];
        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        //assinatura
        $chave = "GFI6TM1WOQCLQ28IM4U3P3I5ZWA59N";
        $signature = hash_hmac("sha256", "$header.$payload", $chave, true);
        $signature = base64_encode($signature);

        $token = "$header.$payload.$signature";

        setcookie("token", $token, $duracao);
        header("Location: dashboard.php");
    }

    function ValidarToken() {
        if(!isset($_COOKIE["token"])){
            return false;
        }

        $token = $_COOKIE["token"];

        $token_array = explode('.', $token);
    
        $header = $token_array[0];
        $payload = $token_array[1];
        $signature = $token_array[2];

        $chave = "GFI6TM1WOQCLQ28IM4U3P3I5ZWA59N";

        $validar_token = hash_hmac("sha256", "$header.$payload", $chave, true);
        $validar_token = base64_encode($validar_token);

        if($validar_token == $signature){
            $dados_token = RecuperarDadosToken();
            if($dados_token->exp > time()){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function RecuperarDadosToken(){
        $token = $_COOKIE['token'];
        
        $token_array = explode('.', $token);
    
        $payload = $token_array[1];
        $payload = base64_decode($payload);
        $payload = json_decode($payload);
    
        return $payload;
    }

    function CadastrarUsuario($usuario, $senha){
        $sql = "
                select nm_usuario
                from tb_usuarios
                where nm_usuario = :usuario
                limit 1
        ";

        $verificar_usuario = $GLOBALS["conn"]->prepare($sql);
        $verificar_usuario->bindParam("usuario", $usuario);
        $verificar_usuario->execute();

        $tupla_usuario = $verificar_usuario->fetch(PDO::FETCH_ASSOC);
        if(!$tupla_usuario) {
            $sql = "
                    insert into tb_usuarios
                    (nm_usuario, cd_senha) values
                    (:usuario, :senha)
            ";

            $cadastrar_usuario = $GLOBALS["conn"]->prepare($sql);
            $cadastrar_usuario->bindParam("usuario", $usuario);
            $cadastrar_usuario->bindParam("senha", password_hash($senha, PASSWORD_DEFAULT));
            $cadastrar_usuario->execute();
            
            $sql = "
                select cd_usuario, nm_usuario
                from tb_usuarios
                where nm_usuario = :usuario
                limit 1
            ";

            $usuario_cadastrado = $GLOBALS["conn"]->prepare($sql);
            $usuario_cadastrado->bindParam("usuario", $usuario);
            $usuario_cadastrado->execute();

            $tupla_usuario = $usuario_cadastrado->fetch(PDO::FETCH_ASSOC);

            SalvarLogin($tupla_usuario);
        } else {
            $_SESSION["msg-cadastro"] = "<p style='color:#f00;'>Já existe um usuário com esse nome</p>";
            echo "
                <style>
                    #form-cadastro{ display: flex; }
                    #form-login{ display: none; }
                </style>
            ";
        }
    }

    function NovaTarefa($cd_usuario, $nome_tarefa, $desc_tarefa, $prazo_tarefa){
        $sql = "
                insert into tb_tarefas
                (cd_tarefa, nm_tarefa, ds_tarefa, dt_registro, dt_prazo, st_tarefa, dt_termino, id_usuario) values
                (null, :nometarefa, :desctarefa, default, :dtprazo, 'P', null, :cdusuario)
        ";
        
        $nova_tarefa = $GLOBALS["conn"]->prepare($sql);
        $nova_tarefa->bindParam("nometarefa", $nome_tarefa);
        $nova_tarefa->bindParam("desctarefa", $desc_tarefa);
        $nova_tarefa->bindParam("dtprazo", $prazo_tarefa);
        $nova_tarefa->bindParam("cdusuario", $cd_usuario);
        $nova_tarefa->execute();

        $_SESSION["msg-nova-tarefa"] = "<p>Tarefa adicionada</p>";

        header("Location: dashboard.php");
    }

    function ListarTarefas($cd_usuario){
        $sql = "
                select nm_tarefa, ds_tarefa, dt_registro, dt_prazo from tb_tarefas
                where id_usuario = :cdusuario and
                st_tarefa = 'P'
                order by dt_registro desc
        ";

        $minhas_tarefas = $GLOBALS["conn"]->prepare($sql);
        $minhas_tarefas->bindParam('cdusuario', $cd_usuario);
        $minhas_tarefas->execute();

        $minhas_tarefas = $minhas_tarefas->fetchALL(PDO::FETCH_ASSOC);
        //var_dump($minhas_tarefas);

        for ($i=0; $i<sizeof($minhas_tarefas); $i++) {
            $nome_tarefa = $minhas_tarefas[$i]["nm_tarefa"];
            $desc_tarefa = $minhas_tarefas[$i]["ds_tarefa"];

            $dt_registro = date_create($minhas_tarefas[$i]["dt_registro"]);
            $dt_registro = date_format($dt_registro, "d/m/Y");
            
            $dt_atual = date("Y-m-d");
            $dt_prazo = $minhas_tarefas[$i]["dt_prazo"];

            $dt_atual = str_replace("-", "", $dt_atual);
            $dt_prazo = str_replace("-", "", $dt_prazo);

            if ($dt_atual<$dt_prazo) {
                $cor_data_prazo = "116811";
            } else {
                $cor_data_prazo = "b81f1f";
            }

            $dt_prazo = date_create($dt_prazo);
            $dt_prazo = date_format($dt_prazo, "d/m/Y");

            ?>
                <div class="tarefa">
                    <h2><?= $nome_tarefa ?></h2>
                    <p class="desc-tarefa">
                    <?= $desc_tarefa ?>
                    </p>

                    <span>Adicionado em: <?= $dt_registro ?></span>
                    <span>Prazo: <span style="color: #<?= $cor_data_prazo ?>; font-weight: bold;"><?= $dt_prazo ?></span></span>

                    <div class="botoes">
                        <button class="btn" id="btn-concluida">Concluída</button>
                        <button class="btn" id="btn-excluir">Excluir</button>
                    </div>
                    <hr style="width: 100%; height: 2px; background-color: #000; border: 0;">
                </div>
            <?php
        }
    }
?>