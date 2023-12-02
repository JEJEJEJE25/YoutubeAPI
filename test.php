<?php
// Check if the form is submitted
include_once('config.php');

$sql = "SELECT searchCode FROM tblqueue LIMIT 1";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        $searchCode = $row['searchCode'];
        echo "Search Code of the first row: " . $searchCode;
    } else {
        echo "No rows found in the table.";
    }
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>

