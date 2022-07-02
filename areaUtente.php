<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	area utente </title>
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


<body id=bodii>
<div class=sticky>

<button id=btn class=fill onclick=logout()>LOGOUT</button>

<div class="dropdown">
<div id=areaNoti class="notification-box">
    <?php
        include 'connessione.php';

        /**conta i problemi accettati e nella notifica appare il numero */
        $query="select count(codProblema) as tot
            from Assistenza a inner join Utenti u on a.CFu=u.CFu
            where a.risolto!=1 and a.rifiutato!=1
                and a.CFu='".$_SESSION['cf']."' and a.CFa is not null;";

        $ris=mysqli_query($con, $query);

        if(!$ris)
            echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >errore ".mysqli_error($con)."</p>";
        else if(mysqli_num_rows($ris)==0)
            echo "<span hidden id=noti class='notification-count'></span>";
        else{
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
                echo"hai ".$riga['tot']." chat attiva<br><a href=vediRichieste.php>clicca qua</a> oppure vai su &rdquo;vedi richieste&rdquo;</a>";
            else
                echo"hai ".$riga['tot']." chat attive<br><a href=vediRichieste.php>clicca qua</a> oppure vai su &rdquo;vedi richieste&rdquo;</a>";
        
        mysqli_close($con);
    ?>

 
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
        qualsiasi problema tu abbia non esitare a chiedere!!<br>
        abbiamo creato il sito per questo motivo &#128521;
    </p>

    

    <button id=btn class=raise onclick=assistenza()>assistenza</button><br>
    <button id=btn class=pulsee onclick=richieste()>vedi richieste</button>

    
</body>



</html>
<script>
    function logout(){
        window.location.href="logout.php";
    }

    function assistenza(){
        window.location.href="assistenza.php";
    }

    function richieste(){
        window.location.href="vediRichieste.php";
    }

</script>

<script>
/*
    document.getElementById("areaNoti").addEventListener("mouseover", function() {
        document.getElementById("noti").hidden=false;
    }); 

    document.getElementById("areaNoti").addEventListener("mouseout", function() {
        document.getElementById("noti").hidden=true;
    }); */

    document.getElementById("areaNoti").addEventListener("click", function(event) {
        event.stopPropagation();
        document.getElementById("myDropdown").classList.toggle("show");

        // Close the dropdown if the user clicks outside of it

    });

    window.onclick = function(event) {
        document.getElementById("myDropdown").classList.remove('show'); 
    }


</script>