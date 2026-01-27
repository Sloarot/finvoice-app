<?php
// Simple test to verify database connection

echo "<h3>Testing Database Connections</h3>";

// Test old database
echo "<br><strong>Testing OLD database:</strong><br>";
try {
    $old_conn = new PDO(
        "mysql:host=localhost;dbname=u993307518_old;charset=utf8mb4",
        "u993307518_old_user",
        "Lehendakari83@"
    );
    $old_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ OLD database connection SUCCESS!<br>";
} catch (PDOException $e) {
    echo "✗ OLD database connection FAILED: " . $e->getMessage() . "<br>";
}

// Test new database
echo "<br><strong>Testing NEW database:</strong><br>";
try {
    $new_conn = new PDO(
        "mysql:host=localhost;dbname=u993307518_fin;charset=utf8mb4",
        "u993307518_fin",
        "QeJB5/4Q2A8q"
    );
    $new_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ NEW database connection SUCCESS!<br>";
    
    // Try a simple query
    $stmt = $new_conn->query("SELECT COUNT(*) as count FROM clients");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Found {$result['count']} clients in new database<br>";
    
} catch (PDOException $e) {
    echo "✗ NEW database connection FAILED: " . $e->getMessage() . "<br>";
}

echo "<br><br>If both connections show SUCCESS, the migrate_jobs.php script should work.";
?>
