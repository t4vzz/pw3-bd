<?php 
session_start();

//verifique se o usuario ja esta logado. se sim , redirecione-o para a paginade boas vindas
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: welcome.php");
    }

    require_once "config.php";

//defina variaveis e inicialize com valores vazios
    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //verifique se o nome de usuario esta vazio 
        if(empty(trim($_POST["username"]))){
            $username_err = "Por favor, insira o nome de usuário.";
        }
        else {
            $username = trim($_POST["username"]);
        }

        //verifique se a senha está vazia
        if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, insira sua senha";
        }
        else{
            $password = trim($_POST["password"]);
        }
    
    
    
    //validar credenciais 
    if(empty($username_err) && empty($password_err)){
        //prepare uma declaracao selecionada
        $sql = "SELECT id, username, password FROM users WHERE username = :username";

        if($stmt = $pdo->prepare(sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            //definir parametros
            $param_username = trim($_POST["username"]);

            //tente executar a declaração preparada
        if($stmt->execute){
            //verifique se o nome de usuario existe, se sim, verifique a senha
            if($stmt->rowCount() == 1){
                if($row = $stmt->fetch()){
                    $id = $row["id"];
                    $username = $row["username"];
                    $hashed_password = $row ["password"];
                    if(password_verify($password, $hashed_password)){
                        // a senha esta correta, então inicie uma nova sessão
                        session_start();
                    }
                }
            }

        }
        }
    }
    }
 ?>