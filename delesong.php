<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you want to get the timer value from the POST data
    $timer = $_POST['dummy_param']; // Adjust this according to your needs

    if ($timer == 1) { // Change this condition based on your requirement
        deleteFirstSong();
    }
}

function deleteFirstSong() {
    include_once("config.php");

    $firstRow = $conn->query("SELECT ID FROM tblqueue LIMIT 1");

    if ($firstRow) {
        $row = $firstRow->fetch_assoc();
        if ($row) {
            $id = $row['ID'];
            $deletesql = $conn->query("DELETE FROM tblqueue WHERE ID='$id'");
            if ($deletesql) {
                echo "Deleted successfully.";
            } else {
                echo "Error deleting song: " . $conn->error;
            }
        } else {
            echo "No rows found in the table.";
        }
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
