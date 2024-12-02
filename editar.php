<?php  
session_start();  
include 'conexion.php';  

if (!isset($_SESSION['username'])) {  
    header("Location: login.php");  
    exit;  
}  

$db = conectarDB();  
$id = $_GET['id'];  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $titulo = $_POST['titulo'];  
    $contenido = $_POST['contenido'];  

    // Manejar la imagen  
    $imagen = null;  
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {  
        $fileTmpPath = $_FILES['imagen']['tmp_name'];  
        $fileName = $_FILES['imagen']['name'];  
        $fileName = uniqid() . '-' . $fileName;  // Asegurar que el nombre sea único  
        $dest_path = 'imagenes/' . $fileName;  

        move_uploaded_file($fileTmpPath, $dest_path);  
        $imagen = $fileName;  
    }  

    // Actualizar la base de datos  
    if ($imagen) {  
        $stmt = $db->prepare("UPDATE contenidos SET titulo=:titulo, contenido=:contenido, imagen=:imagen WHERE id=:id");  
        $stmt->bindValue(':imagen', $imagen);  
    } else {  
        $stmt = $db->prepare("UPDATE contenidos SET titulo=:titulo, contenido=:contenido WHERE id=:id");  
    }  
    
    $stmt->bindValue(':titulo', $titulo);  
    $stmt->bindValue(':contenido', $contenido);  
    $stmt->bindValue(':id', $id);  
    $stmt->execute();  
    
    header("Location: index.php");  
}  

$resultado = $db->query("SELECT * FROM contenidos WHERE id=$id");  
$contenido = $resultado->fetchArray();  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <title>Editar Contenido</title>  
</head>  
<body>  
    <h1>Editar Contenido</h1>  
    <form method="post" enctype="multipart/form-data">  
        <input type="text" name="titulo" value="<?php echo $contenido['titulo']; ?>" required>  
        <textarea name="contenido" required><?php echo $contenido['contenido']; ?></textarea>  
        <input type="file" name="imagen">  
        <button type="submit">Actualizar</button>  
    </form>  
    <?php if ($contenido['imagen']): ?>  
        <img src="imagenes/<?php echo $contenido['imagen']; ?>" alt="Imagen" style="max-width: 200px;">  
    <?php endif; ?>  
    <a href="index.php">Volver</a>  
</body>  
</html>