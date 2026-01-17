<?php
// Login directo sin Laravel para bypass
session_start();

if ($_POST) {
    // Configuración de base de datos - usar getenv() en lugar de $_ENV
    $host = getenv('DATABASE_HOST') ?: $_SERVER['DATABASE_HOST'] ?? 'localhost';
    $dbname = getenv('DATABASE_NAME') ?: $_SERVER['DATABASE_NAME'] ?? 'hc_db';
    $username = getenv('DATABASE_USER') ?: $_SERVER['DATABASE_USER'] ?? 'root';
    $password = getenv('DATABASE_PASSWORD') ?: $_SERVER['DATABASE_PASSWORD'] ?? '';
    $port = getenv('DATABASE_PORT') ?: $_SERVER['DATABASE_PORT'] ?? '5432';
    
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $email = $_POST['email'];
        $pass = $_POST['password'];
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            echo '<script>alert("Login exitoso! Redirigiendo..."); window.location.href="/";</script>';
            exit;
        } else {
            $error = "Credenciales incorrectas";
        }
    } catch (Exception $e) {
        $error = "Error de conexión: " . $e->getMessage();
        // Debug: mostrar variables de entorno
        $error .= "<br><br>Debug info:<br>";
        $error .= "HOST: " . ($host ?? 'null') . "<br>";
        $error .= "DB: " . ($dbname ?? 'null') . "<br>";
        $error .= "USER: " . ($username ?? 'null') . "<br>";
        $error .= "PORT: " . ($port ?? 'null');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Directo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background: #1a1a1a; color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .login-form { background: #2a2a2a; padding: 30px; border-radius: 10px; width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #555; background: #333; color: white; border-radius: 5px; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: #ff6b6b; margin: 10px 0; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login Directo</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required value="admin@gmail.com">
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <p style="text-align: center; margin-top: 20px; font-size: 12px;">
            Credenciales: admin@gmail.com / 12345678
        </p>
    </div>
</body>
</html>