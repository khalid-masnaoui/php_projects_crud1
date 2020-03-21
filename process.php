<?php 

require_once("connect_db.php");
//{}
session_start();
$_SESSION["action"]="";

// creating data (inserting)
if(isset($_POST["Save"])){
    $name=$_POST["name"];
    $location=$_POST["location"];
    $Errors=["name"=>"","location"=>""];

    //use the validation methodes before inserting ...
    //here we gonna check only if the fields are empty or no

    if(empty($name)){
        $Errors["name"]="name is required";
    }
    if(empty($location)){
        $Errors["location"]="location is required";
    }

    if(array_filter($Errors)){
       
        
        $_SESSION["ERR"]=$Errors;
        $_SESSION["name_x"]=$name;
        $_SESSION["location_x"]=$location; 
        header("location:index.php");
    }else {
        // now do whatever you wanna do with the data (database)
        try{ 
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt=$db->prepare("INSERT INTO data (name,location) VALUES (:name,:location)");
            $stmt->execute([":name"=>$name,":location"=>$location]);
            $_SESSION["action"]="ADD";
            header("location:index.php");


            }catch(PDOException $e){
                echo "error :".$e->getMessage();
                exit;
            }
    }
}
//{}
// deleting  data ;
if(isset($_GET["delete"])){
    $id=$_GET["delete"];
        try{ 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt=$db->prepare("DELETE FROM data WHERE id=:id");
        $stmt->execute([":id"=>$id]);
        $_SESSION["action"]="DELETED";

        header("location:index.php");


        }catch(PDOException $e){
            echo "error :".$e->getMessage();
            exit;
        }

}


// updating data ; 
if(isset($_GET["edit"])){
    $id=$_GET["edit"];  
    $_SESSION['id']=$id; 
    //or we can creat a hidden input from the POST or the global/GLOBALS key_words

    $_SESSION["s/u"]="U";

        try{ 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt=$db->prepare("SELECT name,location FROM data WHERE id=:id");
        $stmt->execute([":id"=>$id]);

        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["name"]=$result["name"];
        $_SESSION["location"]=$result["location"];
        header("location:index.php");


        }catch(PDOException $e){
            echo "error :".$e->getMessage();
            exit;
        }
        


}
if(isset($_POST["Update"])){
    $name=$_POST["name"];
    $location=$_POST["location"];
    $Errors=["name"=>"","location"=>""];

    //use the validation methodes before inserting ...
    //here we gonna check only if the fields are empty or no

    if(empty($name)){
        $Errors["name"]="name is required";
    }
    if(empty($location)){
        $Errors["location"]="location is required";
    }

    if(array_filter($Errors)){
       
        
        $_SESSION["ERR"]=$Errors;
        $_SESSION["name_x"]=$name;
        $_SESSION["location_x"]=$location; 

        header("location:index.php");
    }else {
        $_SESSION["s/u"]="S";

        // now do whatever you wanna do with the data (database)
        try{ 
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id=$_SESSION['id'];
            unset($_SESSION['id']);
            $stmt=$db->prepare("UPDATE data SET name = :name, location = :location WHERE  id = :id");
            $stmt->execute([":name"=>$name,":location"=>$location,":id"=>$id]);
            unset($_SESSION["name"],$_SESSION["location"]);
            $_SESSION["action"]="UPDATED";

            header("location:index.php");


            }catch(PDOException $e){
                echo "error :".$e->getMessage();
                exit;
            }
    }
}


?>