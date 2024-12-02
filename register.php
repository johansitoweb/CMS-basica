<?php  
session_start();  
include 'conexion.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $db = conectarDB();  
    $username = $_POST['username'];  
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  
    
    $stmt = $db->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");  
    $stmt->bindValue(':username', $username);  
    $stmt->bindValue(':password', $password);  
    
    if ($stmt->execute()) {  
        header("Location: login.php");  
    } else {  
        echo "Error en el registro.";  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <title>Registro</title>  
</head>  
<body>  
    <h1>Registro de Usuario</h1>  
    <form method="post">  
        <input type="text" name="username" placeholder="Usuario" required>  
        <input type="password" name="password" placeholder="Contraseña" required>  
        <button type="submit">Registrar</button>  
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
        <link rel="stylesheet" href="estilo.css"> 
    </form>  
    <a href="login.php">Ya tengo una cuenta</a>  
</body>  
</html>