<?php
// Login directo sin Laravel para bypass
session_start();

if ($_POST) {
    // Configuración de base de datos
    $host = $_ENV['DATABASE_HOST'] ?? 'localhost';
    $dbname = $_ENV['DATABASE_NAME'] ?? 'hc_db';
    $username = $_ENV['DATABASE_USER'] ?? 'root';
    $password = $_ENV['DATABASE_PASSWORD'] ?? '';
    
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $email = $_POST['email'];
        $pass = $_POST['password'];
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: /home');
            exit;
        } else {
            $error = "Credenciales incorrectas";
        }
    } catch (Exception $e) {
        $error = "Error de conexión: " . $e->getMessage();
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