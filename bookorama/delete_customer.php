<?php
require_once('../bookorama/db_login.php');

$customerid = $_GET['id'];
//assign query
$query = "DELETE FROM customers WHERE customerid = ".$customerid."";
//execute query
$result = $db->query($query);
if (!$result) {
    die("Could not query the database: <br/>" . $db->error . '<br>Query' . $query);
} else {
    $db->close();
    header('Location: ../bookorama/view_customer.php');
}
?>
