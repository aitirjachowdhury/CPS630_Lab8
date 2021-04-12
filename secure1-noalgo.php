<?php

// First approach to storing passwords (very insecure)
$table = "lab8";

function createTable(){
  try {
    $db = new PDO("mysql:host=localhost", 'root', '');
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
    $sql ="CREATE database lab8;" ;
    $db->exec($sql);
    $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
    $sql ="CREATE table Users(
    UserID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR( 50 ) NOT NULL, 
    Password VARCHAR( 50 ) NOT NULL,
    Salt VARCHAR(50)
    );" ;
    $pdo->exec($sql);
} catch(PDOException $e) {
   echo $e->getMessage();//Remove or change message in production code
}
}


//Insert the user with the password
function insertUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $sql = "INSERT INTO Users(Username,Password) 
          VALUES(?,?)";
  $smt = $pdo->prepare($sql);
  $smt->execute(array($username,$password)); //execute the query
}

//Check if the credentials match a user in the system
function validateUser($username,$password){
  $pdo = new PDO("mysql:host=localhost;dbname=lab8", 'root', '');
  $sql = "SELECT UserID FROM Users WHERE Username=? AND
          Password=?";
  $smt = $pdo->prepare($sql);
  $smt->execute(array($username,$password)); //execute the query
  if($smt->rowCount()){
    return "User found!"; //record found, return true.
  }
  return "User not found!"; //record not found matching credentials, return false
}

createTable();
insertUser('Ally','password1');
insertUser('Bobby', 'password2');
//Sample Login and Password
echo validateUser('Ally', 'password1');
echo "<br>";
echo validateUser('Bobby', 'password2');
echo "<br>";
echo validateUser('Bobby', 'password');
?>
<!--
----------------------------------------------------------------------------------------------------------------------------
Password Storage: Plain Text, Insecure Method, No Confidentiality, No Integrity

User Id (int) 		User Name (varchar)		Password (varchar)
1			Smith				password1
2			David				password2

-->
