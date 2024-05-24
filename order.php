
<?php include('partials-front/menu.php'); ?>

<?php 
    if(isset($_GET['food_id']))
    {
        $food_id = $_GET['food_id'];
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else
        {
            header('location:'.SITEURL);
        }
    }
    else
    {
        header('location:'.SITEURL);
    }
?>

<section class="food-order">
    <div class="container">        
        <h2 class="text-center text-white">Please confirm to place order</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend style="color:white;">Selected Food</legend>

                <div class="food-menu-img">
                    <?php 
                    
                        if($image_name=="")
                        {
                            echo "<div class='error'>Image not Available.</div>";
                        }
                        else
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                        }
                    
                    ?>
                    
                </div>

                <div class="food-menu-desc">
                    <h3 style="color:white;"><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">

                    <p class="food-price" style="color:white;">₹<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label" style="color:white;">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                    
                </div>

            </fieldset>
            
            <fieldset>
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                if(empty($_SESSION["u_id"]))
{
header('location:login.php');
}
else{

  $food = $_POST['food'];
  $price = $_POST['price'];
  $qty = $_POST['qty'];

  $total = $price * $qty; 

  $order_date = date("Y-m-d h:i:sa"); 

  $status = "Ordered";  
  $u_id=$_SESSION["u_id"];
  

  $sql2 = "INSERT INTO tbl_order SET 
      food = '$food',
      price = $price,
      qty = $qty,
      total = $total,
      order_date = '$order_date',
      status = '$status',
      u_id='$u_id'
       ";

  $res2 = mysqli_query($conn, $sql2);

  if($res2==true)
  {
      
      $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
      header('location:'.SITEURL);
  }
  else
  {
      $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
      header('location:'.SITEURL);
  }
}
            }
        ?>

    </div>
</section>

<?php include('partials-front/footer.php'); ?>