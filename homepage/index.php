<?php   
    include("../system/security.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    bonjour <?php echo $_SESSION['username'];?>
    <a class="nav-link active btn-outline-success btn"  id="font" href="../system/logout.php">logout</a>
</body>
</html>