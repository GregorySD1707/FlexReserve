<?php
// Script para probar conexión a base de datos en Hostinger
// Extrae valores del .env

$dotenv = parse_ini_file('.env');

$host = $dotenv['DB_HOST'] ?? 'localhost';
$port = $dotenv['DB_PORT'] ?? 3306;
$db   = $dotenv['DB_DATABASE'] ?? 'laravel';
$user = $dotenv['DB_USERNAME'] ?? 'root';
$pass = $dotenv['DB_PASSWORD'] ?? '';

echo "=== PRUEBA DE CONEXIÓN A BASE DE DATOS ===\n";
echo "Host: $host\n";
echo "Puerto: $port\n";
echo "Base de datos: $db\n";
echo "Usuario: $user\n";
echo "Contraseña: " . str_repeat('*', strlen($pass)) . "\n";
echo "==========================================\n\n";

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    echo "✓ CONEXIÓN EXITOSA\n\n";
    
    // Prueba adicional: obtener versión de MySQL
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "Versión MySQL: $version\n";
    
    // Prueba: listar tablas
    echo "\nTablas en la base de datos:\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    if (empty($tables)) {
        echo "  (No hay tablas aún)\n";
    } else {
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ ERROR DE CONEXIÓN\n";
    echo "Mensaje: " . $e->getMessage() . "\n";
    echo "\nCausas comunes:\n";
    echo "  1. Host/usuario/contraseña incorrectos\n";
    echo "  2. Puerto 3306 bloqueado por firewall\n";
    echo "  3. IP no autorizada en Hostinger (Remote MySQL)\n";
    echo "  4. Base de datos no existe\n";
    exit(1);
}

echo "\n✓ Todas las pruebas pasaron correctamente.\n";
?>
