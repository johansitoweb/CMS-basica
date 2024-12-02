<?php  
session_start();  
include 'conexion.php';  

if (!isset($_SESSION['username'])) {  
    header("Location: login.php");  
    exit;  
}  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $db = conectarDB();  
    $titulo = $_POST['titulo'];  
    $contenido = $_POST['contenido'];  

    $imagen = null;  
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {  
        $fileTmpPath = $_FILES['imagen']['tmp_name'];  
        $fileName = $_FILES['imagen']['name'];  
        $fileName = uniqid() . '-' . $fileName;  // Asegurar que el nombre sea único  
        $dest_path = 'imagenes/' . $fileName;  

        move_uploaded_file($fileTmpPath, $dest_path);  
        $imagen = $fileName;  
    }  

    $stmt = $db->prepare("INSERT INTO contenidos (titulo, contenido, imagen) VALUES (:titulo, :contenido, :imagen)");  
    $stmt->bindValue(':titulo', $titulo);  
    $stmt->bindValue(':contenido', $contenido);  
    $stmt->bindValue(':imagen', $imagen);  
    $stmt->execute();  
    
    header("Location: index.php");  
}  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <title>Crear Contenido</title>  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
    <link rel="stylesheet" href="estilo.css"> 
</head>  
<body>  
    <h1>Crear Nuevo Contenido</h1>  
    <form method="post" enctype="multipart/form-data">  
        <input type="text" name="titulo" placeholder="Título" required>  
        <textarea name="contenido" placeholder="Contenido" required></textarea>  
        <input type="file" name="imagen">  
        <button type="submit">Guardar</button>  
    </form>  
    <a href="index.php">Volver</a>  
</body>  
</html>