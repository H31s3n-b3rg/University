<?php
    $user = "root";
    $pass = '74Xz!mNp3!6z';
    $servername = "ch8_db";
    $dbname = "ch8challenge";

    // Create connection
    try{
    $conn = new mysqli($servername, $user, $pass, $dbname);
    // Check connection
    if ($conn->connect_error) {
      throw new Exception($conn->connect_error);
    }
    }catch(Exception $e){
      #echo "<span style='color=red'>".$e->getMessage()."</span>";
      echo "<span style='color=red'>Database non disponibile</span>";
    }
?>
