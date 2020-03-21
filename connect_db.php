<?php
// connect to the database
$host="localhost";
$dbname="CRUD";
$user_name="root";
$password="";
try{
$db=new PDO("mysql:host=$host;dbname=$dbname",$user_name,$password);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "error :".$e->getMessage();
    exit;
}

?>