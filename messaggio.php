<?php
session_start();
if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
  session_destroy();
  $_SESSION=array();
  }

  /*inserisce il nuovo messaggio nel DB*/

  if(isset($_POST['msg']) && $_POST['msg']!=""){
    include 'connessione.php';
   
    $msg = addslashes($_POST['msg']);

    $query="insert into chat values
      (".$_GET['cod'].", null , '".$_SESSION['nome']."',  '$msg', '".date("H:i:s")."', '".date("Y-m-d")."');";
   

  

		$ris=mysqli_query($con, $query);

    if(!$ris)
    echo "err".mysqli_error($con);
  else ?>
  <script> window.location.href="chat.php"+"?cod="+<?php echo $_GET['cod'] ?>+""</script>

<?php
}else{
  ?>
  <script> window.location.href="chat.php"+"?cod="+<?php echo $_GET['cod'] ?>+""</script>
<?php
}

  


