<?php
include __DIR__."/session.php";
include __DIR__."/url.php";
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Challenge 08: RCE via PHP</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet"type="text/css" href="<?php echo basename($_SERVER["SCRIPT_NAME"],".php");?>.css?v=<?php echo filemtime(basename($_SERVER["SCRIPT_NAME"]));?>">
</head>
<body>
  <h1>Partecipa al concorso!</h1>
  <h2>Carica la tua immagine e prova a vincere. Le uniche estensioni ammesse sono PNG, JPEG e JPG, di certo non il PHP (sarebbe un bel guaio altrimenti!).
  Il nostro "abilissimo" programmatore ha impostato dei controlli sul MIME Type del file, in questo modo sarà impossibile caricare file di estensioni diverse da quelle accettate.</h2>
      <div id="login" style="background-color: #ecf0f1;">
        <h2>Login</h2>
        <form action="" method="POST">
          <label for="username">Username:</label><br>
          <input type="text" id="username" name="username" autocomplete="off" required><br>
          <label for="password">Password:</label><br>
          <input type="text" id="password" name="password" style="text-security:disc; -webkit-text-security:disc;" autocomplete="off" required><br><br>
          <input id="btn" type="submit" value="Submit">
        </form>
        <a id="reg_link" href="registration.php"><b>Registrazione</b></a>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (!empty($username) && !empty($password)) {
              try{
                include __DIR__."/dbch8connection.php";
                $stmt = $conn->prepare("SELECT Password from users WHERE Username=?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                  while($row = $result->fetch_assoc()) {
                    $hashed = hash("sha512", $password);
                    if($hashed===$row['Password']){
                      $_SESSION['user'] = $username;
                      $_SESSION['login'] = true;
                      header('Location: '.$url."/image.php");
                    }
                    else {
                      $_SESSION['login'] = false;
                      throw new Exception();
                    }
                  }
                }
                else {
                  throw new Exception();
                }
              }catch(Exception $e){
                echo "<span>Login non riuscito</span>";
              }finally{
                $conn->close();
              }
            }else {
              echo "<span>Login non riuscito</span>";
            }
          }
        ?>
      </div>
    </body>
</html>
