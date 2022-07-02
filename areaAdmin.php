<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	area admin </title>
<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<style>

 
</style>



<div class=sticky>

<button id=btn class=fill onclick=logout()>LOGOUT</button>

<!-- notifiche, se ci sono nuove richieste ne segna il numero -->
<div id=areaNoti class="notification-box">
<?php
        include 'connessione.php';

        $query="select count(codProblema) as tot
            from Assistenza a 
            where a.CFa is null;";

        $ris=mysqli_query($con, $query);

        if(!$ris)
            echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >errore ".mysqli_error($con)."</p>";
        else {
            $riga=mysqli_fetch_array($ris);
            if($riga['tot']!=0)
             echo "<span  id=noti class='notification-count'>".$riga['tot']."</span>";
        }

    
    ?>


    <div class="notification-bell">
      <span class="bell-top"></span>
      <span class="bell-middle"></span>
      <span class="bell-bottom"></span>
      <span class="bell-rad"></span>
    </div>
   

 
    <div id="myDropdown" class="dropdown-content">

<?php
    if($riga['tot']!=0)
        if($riga['tot']==1)
            echo"hai ".$riga['tot']." nuova richiesta<br><a href=richiesteUsr.php>clicca qua</a> oppure vai su &rdquo;richieste utenti&rdquo;</a>";
        else
            echo"hai ".$riga['tot']." nuove richieste<br><a href=richiesteUsr.php>clicca qua</a> oppure vai su &rdquo;richieste utenti&rdquo;</a>";
    
    mysqli_close($con);
?>


</div>

  </div>

    </div>
</div>

</div>
<center>
    <styTit>{Area Riservata}</styTit>


    <div style="padding:20px;margin-top:20px;"> 
    <p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;'>
        <?php
            if($_SESSION['genere']=="F")
                echo "Benvenuta ";
            else
                echo "Benvenuto ";
    
            echo $_SESSION['nome']
     
        ?>
              &#128519;<br>
        
    </p>

    <button id=btn onclick=gestisciFaq() class=raise >gestisci FAQ</button><br>

    <button id=btn onclick=richiesteUsr() class=offset >richieste utenti</button><br>

   
</body>



</html>
<script>
    function logout(){
        window.location.href="logout.php";
    }

    

    function gestisciFaq() {
        window.location.href="gestisciFaq.php";
    }

    function richiesteUsr() {
        window.location.href="richiesteUsr.php";
    }

   

</script>

<script>

   /**visualizza e nasconde l'area di notifica */
    document.getElementById("areaNoti").addEventListener("click", function(event) {
        event.stopPropagation();

        document.getElementById("myDropdown").classList.toggle("show");

    
    });

    window.onclick = function(event) {
        
        document.getElementById("myDropdown").classList.remove('show'); 
    }


</script>