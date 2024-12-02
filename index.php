<?php  
session_start();  
include 'conexion.php';  
$db = conectarDB();  

// Configuración de paginación  
$limit = 5; // Cantidad de contenidos por página  
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  
$offset = ($page - 1) * $limit;  

// Contar total de registros  
$totalRes = $db->query('SELECT COUNT(*) as total FROM contenidos')->fetchArray();  
$total = $totalRes['total'];  
$totalPages = ceil($total / $limit);  

// Obtener contenido con paginación  
$res = $db->query("SELECT * FROM contenidos LIMIT $limit OFFSET $offset");  
?>  
<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <title>CMS Básico</title>  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
    <link rel="stylesheet" href="estilo.css">  
</head>  
<body>  
    <div class="container">  
        <h1 class="mt-4">Contenidos</h1>  
        
        <?php if (isset($_SESSION['username'])): ?>  
            <p>Bienvenido, <?php echo $_SESSION['username']; ?> <a href="logout.php">Cerrar Sesión</a></p>  
            <a href="crear.php" class="btn btn-primary mb-3">Crear Nuevo Contenido</a>  
        <?php else: ?>  
            <a href="login.php" class="btn btn-primary mb-3">Iniciar Sesión</a> o <a href="register.php" class="btn btn-primary mb-3">Registrarse</a>  
        <?php endif; ?>  

        <div class="list-group">  
        <?php while ($row = $res->fetchArray()): ?>  
            <div class="list-group-item">  
                <h2><?php echo htmlspecialchars($row['titulo']); ?></h2>  
                <p><?php echo htmlspecialchars($row['contenido']); ?></p>  
                <?php if ($row['imagen']): ?>  
                    <img src="imagenes/<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen">  
                <?php endif; ?>  
                <?php if (isset($_SESSION['username'])): ?>  
                    <div class="btn-group">  
                        <a href='editar.php?id=<?php echo $row['id']; ?>' class="btn btn-warning">Editar</a>  
                        <a href='eliminar.php?id=<?php echo $row['id']; ?>' class="btn btn-danger">Eliminar</a>  
                    </div>  
                <?php endif; ?>  
            </div>  
        <?php endwhile; ?>  
        </div>  

        <!-- Navegación de Páginas -->  
        <nav aria-label="Page navigation">  
            <ul class="pagination">  
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">  
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Anterior</a>  
                </li>  
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>  
                    <li class="page-item <?php if ($page == $i) echo 'active'; ?>">  
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>  
                    </li>  
                <?php endfor; ?>  
                <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">  
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Siguiente</a>  
                </li>  
            </ul>  
        </nav>  
    </div>  
    
    <script>  
        const switchModeButton = document.getElementById('switchMode');  
        switchModeButton.addEventListener('click', function() {  
            document.body.classList.toggle('dark-mode');  
        });  
    </script>  
</body>  
</html>
