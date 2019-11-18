<?php
 session_start();
$username='root';
$password='';
$dbname = 'sampleloginDB';
$conn=mysqli_connect('localhost',$username,$password,$dbname);
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
} 
?>
