<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link rel="stylesheet" href="/autoEdge/productPage.css">
    <link rel="icon" type="image/x-icon" href="/autoEdge/uploads/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css"
        integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    <style>
    .checked {
        color: orange;
    }
    </style>
</head>

<body>
    <?php
    session_start();
    include 'utils/_dbconnect.php';
    if(isset($_POST['requestId'])){
        $requestId = $_POST['requestId'];
        $requestId = (int)$requestId;
        $script = $_POST["script"];
        $params = $_POST["params"];
        $user = $_POST["requestUser"];
        $reqName = $_POST["requestName"];
        $reqCat = $_POST["requestCat"];
        $sqlReq = "INSERT INTO `request` (`request_user_id`, `request_product_name`, `request_product_id`,`request_catagory` ,`request_time`) VALUES ('$user', '$reqName', '$requestId', '$reqCat', current_timestamp())";
        $result = mysqli_query($conn, $sqlReq);
        if($result){
            header("Location: $script?$params&request=True");
        }
        else{
            header("Location: $script?$params&request=False");
        }
    }
    $script   = $_SERVER['SCRIPT_NAME'];
    $params   = $_SERVER['QUERY_STRING'];
    include 'utils/_header.php'; 

     if(isset($_GET["err"])){
        $err = $_GET["err"];
        if($err=="True"){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Invalid Quantity.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }else{
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Item added to cart.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    if(isset($_GET["comment"])){
        $comment = $_GET["comment"];
        if($comment=="success"){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Comment added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Comment not added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    if(isset($_GET["request"])){
        if($_GET["request"]=="True"){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Thanks for your request.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Request not added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    if(isset($_GET["delete"])){
        if($_GET["delete"]=="true"){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Comment and rating deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Comment and rating not deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    
    $id = $_GET['productId'];
    $sql = "SELECT * FROM `products` WHERE product_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['product_id'];
        $name = $row['product_name'];
        $category = strtoupper($row['product_category']);
        $desc = $row['product_description'];
        $price = $row['product_price'];
        $img = $row['product_image'];
        $stock = $row['product_stock'];
        $tempSql = "SELECT rating FROM `comments` WHERE commented_for = $id";
        $tempResult = mysqli_query($conn, $tempSql);
        $totalRating = 0;
        $count = 0;
        $rating=0;
        while ($tempRow = mysqli_fetch_assoc($tempResult)) {
            $totalRating += $tempRow['rating'];
            $count++;
        }
        if($count==0){
            $rating = 0;
        }else{
            $rating = $totalRating/$count;
        }
    }
    echo'
    <div class="container" id="productPage">
        <div class="product-container main-product-container">
            <div class="product-left-container">
                <img src="/autoEdge/uploads/'.$img.'"
                    alt="'.$name.'" height="407" width="400" />
            </div>
            <div class="product-col-container">
                <small>
                    <p class="product-info-meta">'.$category.'</p>
                </small>
                <h1 class="product-page">'.$name.'</h1>
                <p>
                    <b>Quick overview</b><br />
                    '.$desc.'
                </p>
                <hr>
                <div class="d-flex justify-content-around">
                <p class="text-justify font-weight-light">Rating</p>
                ';
                    $temp = 5-$rating;
                            for($i=0; $i<$rating; $i++){
                                echo '<span class="fa fa-star checked"></span>';
                            }
                            for($i=0; $i<$temp; $i++){
                                echo '<span class="fa fa-star"></span>';
                            }
                echo'</div>
                <p class="product-price">
                    <b>Price:</b>
                    <span class="price">$'.$price.'</span>';
                    if($stock == 0){
                        echo '<span class="product-price-meta" style="float:right;">
                        Not in stock
                    </span>';}
                    else{
                        echo '<span class="product-price-meta" style="float:right;">
                        <strong>In Stock</strong>
                    </span>
                    </p>';
                    }
                if($stock != 0){
                echo'
                <p>
                <form action="utils/_addToCart.php" method="post">';
                    echo'
                    <input type="hidden" name="id" id="id" value='.$id.'>
                    <input type="hidden" name="script" id="script" value='. $script.'>
                    <input type="hidden" name="params" id="params" value='. $params.'>
                    <input class="quantity" style="padding: 10px; type="text" name="quan" id="quan" placeholder="Type quantity" value=1>
                    <button class="btn btn-success" style="margin-left: 10px;">Add to cart</button>
                    <br clear="both" />
                </form>
                </p>';
                    }
    else{
    echo'
    <p>
        <button class="btn btn-secondary" disabled>Add to cart</button>';
        if(isset($_SESSION['user_id'])){
            $curUser = $_SESSION['user_id'];
            $checkReqCountSql = "SELECT * FROM `request` WHERE request_user_id = $curUser AND request_product_id = $id";
            $checkReqCountResult = mysqli_query($conn, $checkReqCountSql);
            $checkReqCount = mysqli_num_rows($checkReqCountResult);
        if($checkReqCount>0){
            echo'
            <button class="btn btn-primary" style="margin-left: 10px;" disabled>Requested</button>';
        }else{
        echo'
        <form action="'.$_SERVER['PHP_SELF'].'" method="post">
        <input type="hidden" name="requestId" id="id" value='.$id.'>
        <input type="hidden" name="requestName" id="id" value='.$name.'>
        <input type="hidden" name="requestCat" id="id" value='.$category.'>
        <input type="hidden" name="requestUser" id="id" value='.$_SESSION['user_id'].'>
        <input type="hidden" name="script" id="script" value='. $script.'>
        <input type="hidden" name="params" id="params" value='. $params.'>
        <button class="btn btn-primary" type="submit" name="request_product" style="margin-left: 10px;">Request for this product</button>
        </form>';}
        }else{
            echo'
            <a href="/autoEdge/login.php"><button class="btn btn-primary" style="margin-left: 10px;">Login to Request</button></a>';
        }        
        echo'
        <br clear="both" />
    </p>';
    }

    echo '</div>
    </div>
    <br clear="all" />';
            
            echo'
    </div>
    <br clear="all" />
    </div>';
    ?>
    <?php include 'utils/_footer.php' ?>
    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <script>
    $(function() {
        $(".rateyo").rateYo().on("rateyo.change", function(e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :' + $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('Rating: ' + rating);
            $(this).parent().find('input[name=rating]').val(rating);
        });
    });
    </script>
</body>

</html>