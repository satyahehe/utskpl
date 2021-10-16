<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="card">
        <div class="card-header">
            <div class="card-body">
                <br>
                <a href="add_customer.php" class="btn btn-primary">+ Add Customer Data</a><br><br>
                <a href="logout.php" class="btn btn-primary pull-right" style="position: absolute; top: 3.5em; right: 2.5em;">Logout</a>
                <table class="table table-striped">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>

                <?php
                    session_start(); //inisialisasi session
                    if(!isset($_SESSION['username'])){
                        header('Location: ../bookorama/login.php');
                    }

                    // Include our login information
                    require_once('../bookorama/db_login.php');
                    // Execute the query
                    $query = "SELECT * FROM customers ORDER BY customerid";
                    $result = $db->query($query);
                    if (!$result){
                        die ("Could not query the database: <br/>". $db->error ."<br>Query: ".$query);
                    }
                    // Fetch and display the results
                    $i = 1;
                    while ($row = $result->fetch_object()){
                        echo '<tr>';
                        echo '<td>'.$i.'</td>';
                        echo '<td>'.$row->name.'</td>';
                        echo '<td>'.$row->address.'</td>';
                        echo '<td>'.$row->city.'</td>';
                        echo '<td><a href="edit_customer.php?id='.$row->
                        customerid.'" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_customer.php?id='.$row
                                ->customerid.'" class="btn btn-danger btn-sm">Delete</a>
                                </td>';
                        echo '</tr>';
                        $i++;
                    }
                    echo '<table>';
                    echo '<br>';
                    echo 'Total Rows = '.$result->num_rows;
                    $result->free();
                    $db->close();
                ?>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>