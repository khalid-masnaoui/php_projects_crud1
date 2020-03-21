<?php 
require_once("connect_db.php");
session_start();
if(isset($_SESSION["ERR"])){
$name_ERR=$_SESSION["ERR"]["name"];
$location_ERR=$_SESSION["ERR"]["location"];

$name_input=$_SESSION["name_x"];
$location_input=$_SESSION["location_x"];
    unset($_SESSION["ERR"],$_SESSION["name_x"],$_SESSION["location_x"]);
}
if(isset($_SESSION["name"]) && isset($_SESSION["location"])) {
    $name_input=$_SESSION["name"]; //differenet !!
    $location_input=$_SESSION["location"];

    //the unset was removed else where for : when refresing the page , want tp keep the values nd update option ....the values stay only with the update option...

    
    
}





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple CRUD</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
    .narrow{
        padding:2rem;
        width:100%;   }
    .narrow1{
        
        width:100%;   }
    .not_allowed{
     background-color: grey;
     cursor: not-allowed;
}
    </style>

</head>
<body>

<?php
//{}
if(isset($_SESSION["action"])){
$action=$_SESSION["action"];
switch($action){
    case "ADD":
        echo "<div class='container narrow text-center  bg-success'><span class='narrow1'> Record added 
        </span><br></div>";
        unset($_SESSION["action"]);
    break;
    case "UPDATED":
        echo "<div class='container narrow text-center bg bg-success'><span class='narrow1'> Record updated 
        </span><br></div>";
        unset($_SESSION["action"]);

    break;
    case "DELETED":
        echo "<div class='container narrow text-center bg bg-warning'><span class='narrow1'> Record delted 
        </span><br></div>";
        unset($_SESSION["action"]);

    break;
    default:
    
}}

?>
<div class="container">

<div class="row justify-content-center">
<table class="table table-striped table-dark table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col">id</th>
      <th scope="col">name</th>
      <th scope="col">location</th>
      <th colspan="2">Action</th>
    </tr>
  </thead>
  <tbody>
   <?php
 try{ 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt=$db->prepare("SELECT * FROM data");
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)){
        foreach($result as $row ){
            echo "<tr>
            <th scope='row' class='not_allowed'>".$row['id']."</th>
            <td>".$row['name']."</td>
            <td>".$row['location']."</td>
            <td> <a href='process.php?edit=".$row['id']."'   class='btn btn-success' > UPDATE </a> 
            <a type='delet' class='btn btn-danger' href='process.php?delete=".$row['id']."'  > DELETE </a></td>

          </tr>" ;
        }
    }
    //for us se we can select the a action ---we gonna use GET with a link (pass it into the link nd the row id )
    //links , submit doesnt work with .....links with a via href ---GET

    }catch(PDOException $e){
        echo "error :".$e->getMessage();
        exit;
    }

?>
    
  </tbody>
</table></div></div>

<div class="row justify-content-center" >
<form action="process.php" method="POST">
<div class="form-group">
<label for="">Name : </label>
<input type="text" name="name" class="form-control" placeholder="Enter your Name"  value="<?php if(isset($name_input) && $name_input!=""){
    echo $name_input;
} 
?>"> 
<?php if(isset($name_ERR) && $name_ERR!=""){
    echo "<br> <span class='alert alert-danger'> * ".$name_ERR."</span> ";
} 
?>


</div>
<div class="form-group">
<label for="">Location : </label>
<input type="text" name="location"  class="form-control"  placeholder="Enter your Location"  value="<?php if(isset($location_input) && $location_input!=""){
    echo $location_input;
} 
?>"> <?php if(isset($location_ERR) && $location_ERR!=""){
    echo "<br> <span class='alert alert-danger'> * ".$location_ERR."</span> ";
} 
?>

</div>
<div class="form-group">

<button type="submit"  class="btn btn-primary"  name="<?php
if(isset($_SESSION["s/u"]) && $_SESSION["s/u"]=="U") {
    echo 'Update';

    
}else{
    echo 'Save';
}

?>"><?php
if(isset($_SESSION["s/u"]) && $_SESSION["s/u"]=="U") {
    echo 'Update';

    
}else{
    echo 'Save';
}

?></button>
</div>
</div>



</form>
    









<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>