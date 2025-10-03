<?php
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    
    $dataFile = 'users.json';
    
    
    if (file_exists($dataFile)) {
        $users = json_decode(file_get_contents($dataFile), true);
    } else {
        $users = [];
    }

    if ($action === 'signup') {
        $email = $_POST['email'] ?? '';
        
        // Verifica se o usuário já existe
        if (isset($users[$username])) {
            echo "
                <div class='success-container'>
                    <h1>Erro!</h1>
                    <p>Usuário já existe.</p>
                    <a href='index.html'>Voltar</a>
                </div>
            ";
        } else {
            // Salva o novo usuário (a senha é salva em texto puro para simplificação. Em produção, use `password_hash`).
            $users[$username] = [
                'email' => $email,
                'password' => $password 
            ];
            file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));
            
            echo "
                <div class='success-container'>
                    <h1>Cadastro Realizado com Sucesso!</h1>
                    <p>Seja bem-vindo, {$username}!</p>
                    <a href='index.html'>Voltar para Login</a>
                </div>
            ";
        }

    } elseif ($action === 'signin') {
    // Verifica se o usuário e senha estão corretos
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        session_start();
        $_SESSION['username'] = $username; // guarda o nome do usuário logado
        header("Location: ../dashboard.html");
        exit();
    } else {
        echo "
            <div class='success-container'>
                <h1>Erro!</h1>
                <p>Usuário ou senha incorretos.</p>
                <a href='index.html'>Tentar Novamente</a>
            </div>
        ";
    }
}

}
?>

<style>
    body {
        background: #f6f5f7;
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        text-align: center;
    }
    .success-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        padding: 50px;
        max-width: 600px;
        color: #333;
    }
    .success-container h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
        color: #4169E1;
    }
    .success-container p {
        font-size: 1.2em;
        margin-bottom: 30px;
    }
    .success-container a {
        border-radius: 20px;
        border: 1px solid #4169E1;
        background-color: #4169E1;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        padding: 12px 45px;
        text-decoration: none;
        transition: transform 80ms ease-in;
    }
    .success-container a:active {
        transform: scale(0.95);
    }
</style>