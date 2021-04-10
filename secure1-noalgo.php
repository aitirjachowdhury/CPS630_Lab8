<?php

// First approach to storing passwords (very insecure)

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
    return true; //record found, return true.
  }
  return false; //record not found matching credentials, return false
}

insertUser('Smith','password1');
insertUser('David', 'password2');
echo validateUser('Smith', 'password1');
echo "<br>";
echo validateUser('David', 'password2');
?>
<!--
----------------------------------------------------------------------------------------------------------------------------
Password Storage: Plain Text, Insecure Method, No Confidentiality, No Integrity

User Id (int) 		User Name (varchar)		Password (varchar)
1			Smith				password1
2			David				password2

-->
