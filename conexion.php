<?php  
function conectarDB() {  
    $db = new SQLite3('base_de_datos.sqlite');  
    return $db;  
}  
?>
