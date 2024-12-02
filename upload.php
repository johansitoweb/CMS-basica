<?php  
session_start();  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    // Verificar si se ha enviado un archivo  
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {  
        // Directorio donde se guardarán las imágenes  
        $uploadDir = 'imagenes/';   
        $fileTmpPath = $_FILES['imagen']['tmp_name'];  
        $fileName = $_FILES['imagen']['name'];  
        $fileSize = $_FILES['imagen']['size'];  
        $fileType = $_FILES['imagen']['type'];  
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);  

        // Validar el tipo de archivo (ej. solo imágenes)  
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];  
        if (!in_array($fileType, $allowedTypes)) {  
            echo "Tipo de archivo no permitido. Solo se aceptan JPEG, PNG o GIF.";  
            exit;  
        }  

        // Generar nombre único para el archivo  
        $newFileName = uniqid() . '.' . $extension;   
        $destPath = $uploadDir . $newFileName;  

        // Mover el archivo al directorio deseado  
        if (move_uploaded_file($fileTmpPath, $destPath)) {  
            echo "Archivo subido con éxito: <a href='$destPath'>Ver imagen</a>";  
        } else {  
            echo "Error al mover el archivo al directorio de destino.";  
        }  
    } else {  
        echo "No se ha enviado ningún archivo o ha ocurrido un error.";  
    }  
} else {  
    echo "Método no permitido.";  
}  
?>