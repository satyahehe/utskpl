<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<?php
// File         : edit_customer.php
// Deskripsi    : menampilkan form edit data customer dan mengupdate data ke database

session_start(); //inisialisasi session
if(!isset($_SESSION['username'])){
    header('Location: ../bookorama/login.php');
}

require_once('../bookorama/db_login.php');
$id = $_GET['id']; //mendapatkan customerid yang dilewatkan ke url

//mengecek apakah user belum menekan tombol submit
if (!isset($_POST["submit"])) {
    $query = "SELECT * FROM customers WHERE customerid=" . $id . "";
    //Execute the query
    $result = $db->query($query);
    if (!$result) {
        die("Could not query the database: <br/>" . $db->error);
    } else {
        while ($row = $result->fetch_object()) {
            $name = $row->name;
            $address = $row->address;
            $city = $row->city;
        }
    }
} else {
    $valid = TRUE; //flag validasi
    $name = test_input($_POST['name']);
    if ($name == '') {
        $error_name = "Nama is required";
        $valid = FALSE;
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $error_name = "Only letters and white space allowed";
        $valid = FALSE;
    }

    $address = test_input($_POST['address']);
    if ($address == '') {
        $error_address = "Address is required";
        $valid = FALSE;
    }

    $city = test_input($_POST['city']);
    if ($city == '' || $city == 'none') {
        $error_city = "City is required";
        $valid = FALSE;
    }

    //update data into database
    if ($valid) {
        //escape inputs data
        $address = $db->real_escape_string($address);
        //Assign a query
        $query = "UPDATE customers SET name='".$name."', address='".$address."', 
        city='".$city."' WHERE customerid ='".$id."'";
        //Execute the query
        $result = $db->query($query);
        if (!$result) {
            die("Could not query the database: <br/>" . $db->error . '<br>Query' . $query);
        } else {
            $db->close();
            header('Location: ../bookorama/view_customer.php');
        }
    }
}

?>

<br>
<div class="card">
    <div class="card-header">Edit Customers Data</div>
    <div class="card-body">
        <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($name)) {echo $name;} ?>">
                <div class="error"><?php if (isset($error_name)) echo $error_name; ?></div>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" rows="5" class="form-control"><?php if(isset($address)) {echo $address;} ?></textarea>
                <div class="error"><?php if (isset($error_address)) echo $error_address; ?></div>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <select name="city" id="city" class="form-control" required>
                    <option value="none" <?php if (isset($city)) echo 'selected="true"'; ?>>--Select a city--</option>
                    <option value="Airport West" <?php if (isset($city) && $city == "Airport West") echo 'selected="true"'; ?>>Airport West</option>
                    <option value="Box Hill" <?php if (isset($city) && $city == "Box Hill") echo 'selected="true"'; ?>>Box Hill</option>
                    <option value="Yarraville" <?php if (isset($city) && $city == "Yarraville") echo 'selected="true"'; ?>>Yarraville</option>
                </select>
                <div class="error"><?php if (isset($error_city)) echo $error_city; ?></div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            <a href="view_customer.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php
$db->close();
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>