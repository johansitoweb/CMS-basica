<?php  
session_start();  
include 'conexion.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $db = conectarDB();  
    $username = $_POST['username'];  
    $password = $_POST['password'];  
    
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = :username");  
    $stmt->bindValue(':username', $username);  
    $stmt->execute();  
    $usuario = $stmt->fetchArray();  
    
    if ($usuario && password_verify($password, $usuario['password'])) {  
        $_SESSION['user_id'] = $usuario['id'];  
        $_SESSION['username'] = $usuario['username'];  
        header("Location: index.php");  
    } else {  
        echo "Usuario o contraseña incorrectos.";  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <title>Login</title>  
</head>  
<body>  
    <h1>Iniciar Sesión</h1>  
    <form method="post">  
        <input type="text" name="username" placeholder="Usuario" required>  
        <input type="password" name="password" placeholder="Contraseña" required>  
        <button type="submit">Entrar</button>  
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
        <link rel="stylesheet" href="estilo.css"> 
    </form>  
    <a href="register.php">Crear una cuenta</a>  
</body>  
</html>