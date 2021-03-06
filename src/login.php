<?php
 
 if ( $_SERVER["REQUEST_METHOD"] == "POST") {
     require "db.php";

     extract($_POST) ; 
     
     $email = filter_var($email, FILTER_SANITIZE_EMAIL);

     $stmt = $db->prepare("select * from user where email = ?") ;
     $stmt->execute([$email]) ;
     if ( $stmt->rowCount() == 1) {
         $user = $stmt->fetch(PDO::FETCH_ASSOC) ;
         if ( password_verify($password, $user["password"])) {
             $_SESSION["user"] = $user ;
             header("Location: ?page=main");
             exit ;
         }
     } 

     addMessage("Login Failed!");
     header("Location: ?page=loginForm") ;
     exit ;
 }