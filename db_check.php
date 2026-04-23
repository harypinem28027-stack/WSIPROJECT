<?php
require_once 'config.php';

$db = new Database();
$conn = $db->getConnection();

echo "<h2>Database Check - db_kampus</h2>";

// Check tables
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows > 0) {
    echo "<p><strong>✅ users table exists</strong></p>";
    
    // Describe table
    echo "<h3>users table structure:</h3>";
    $desc = $conn->query("DESCRIBE users");
    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th></tr>";
    while ($row = $desc->fetch_assoc()) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td></tr>";
    }
    echo "</table>";
    
    // Count users
    $count = $conn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc()['cnt'];
    echo "<p><strong>Total users: $count</strong></p>";
    
    if ($count > 0) {
        echo "<h3>First 5 users (pw masked):</h3>";
        $users = $conn->query("SELECT username, email FROM users LIMIT 5");
        echo "<table border='1'><tr><th>Username</th><th>Email</th></tr>";
        while ($user = $users->fetch_assoc()) {
            echo "<tr><td>{$user['username']}</td><td>{$user['email']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p><strong>⚠️ No users in table. Add manually or use register.</strong></p>";
    }
} else {
    echo "<p><strong>❌ users table NOT found!</strong></p>";
    echo "<p>Create table: <code>CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE, email VARCHAR(100) UNIQUE, password VARCHAR(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);</code></p>";
}

// Close
$conn->close();
?>

