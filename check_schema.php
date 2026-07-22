<?php
$conn = new mysqli("localhost", "root", "", "press_unsoed_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$tables = ['books', 'ebooks', 'authors'];
foreach ($tables as $t) {
    echo "--- $t ---\n";
    $result = $conn->query("DESCRIBE $t");
    if ($result) {
        while($row = $result->fetch_assoc()) {
            echo $row['Field'] . " | " . $row['Type'] . "\n";
        }
    } else {
        echo "Table not found.\n";
    }
}
$conn->close();
?>
