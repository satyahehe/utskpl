<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<?php
//File      : show_cart.php
//Deskripsi : untuk menambahkan item ke shopping cart dan menampilkan isi shopping cart

session_start();
$id = $_GET['id'];
if ($id != "") {
    //jika $_SESSION['cart'] belum ada, maka inisialisasi dengan array kosong
    //$_SESSION['cart'] merupakan array assosiatif
    //indeksnya berisi isbn buku yang dipilih
    //value-nya berisi jumlah (qty) dari buku dengan isbn tersebut
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    //jika $_SESSION['cart'] dengan indeks isbn buku yang dipilih sudah ada, tambahkan value-nya dengan 1, jika belum ada, buat elemen baru dengan indeks tersebut dan set nilainya dengan 1
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
}
?>
<!-- Menampilkan isi shopping cart -->
<br>
<div class="card">
    <div class="card-header">Shopping Cart</div>
    <div class="card-body">
        <br>
        <table class="table table-striped">
            <tr>
                <th>ISBN</th>
                <th>Author</th>
                <th>Title</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Price * Qty</th>
            </tr>
            <?php
            //include our login information
            require_once('../bookorama/db_login.php');
            $sum_qty = 0; //inisialisasi total item di shopping cart
            $sum_price = 0; //inisialisasi total price di shopping cart
            $qty = $id;
            if (is_array($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $qty) {
                    $query = "SELECT * FROM books WHERE isbn='" . $id . "'";
                    $result = $db->query($query);
                    if (!$result) {
                        die("Could not query the database: <br/>" . $db->error . "<br>Query: " . $query);
                    }
                    while ($row = $result->fetch_object()) {
                        echo '<tr>';
                        echo '<td>' . $row->isbn . '</td>';
                        echo '<td>' . $row->author . '</td>';
                        echo '<td>' . $row->title . '</td>';
                        echo '<td>' . $row->price . '</td>';
                        echo '<td>' . $qty . '</td>';
                        $price = $row->price;
                        echo '<td>' . $row->price*$qty . '</td>';
                        $sum_qty = $sum_qty + $qty;
                        $sum_price = $sum_price + ($price * $qty);
                    }
                }
                echo '<tr><td></td><td></td><td></td><td></td><td>' . $sum_qty . '</td><td>' . $sum_price . '</td></tr>';
                $result->free();
                $db->close();
            } else {
                echo '<tr><td colspan="6" align="center">There is no item in shopping cart</td></tr>';
            }
            ?>
        </table>
        Total items = <?php echo $sum_qty; ?><br><br>
        <a class="btn btn-primary" href="view_books.php">Continue Shopping</a>
        <a class="btn btn-danger" href="delete_cart.php">Empty Cart</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>