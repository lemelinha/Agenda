<?php
    session_start();

    function LoginUsuario($usuario, $senha){
        $sql = "
                select nm_usuario, cd_senha 
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
                select nm_usuario
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
?>