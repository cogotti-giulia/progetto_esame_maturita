<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
    }
    
    //richieste fatte dall'utente loggato
?>

<!doctype html>
<html>
<title>	mie richieste </title>
<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<style>

    
    #noAccettata{
        cursor: default;
    
    }
</style>



<div class=sticky>

<button id=btn class=fill onclick=goBack()>torna indietro</button>


</div>
<center>
    <styTit>{Richieste Utenti}</styTit>


    <div style="padding:20px;margin-top:20px;"> 
    


    <?php
    /**prende le richieste di quell'utente loggato */
        include 'connessione.php';

        $query="select a.*, u.*
            from ((Utenti u inner join Assistenza a on u.CFu=a.CFu)
                inner join Interventi i on a.codInte=i.codInte)

          where a.CFu='".$_SESSION['cf']."'; ";
        
        $ris=mysqli_query($con, $query);

        if(!$ris){
            echo "erroe".mysqli_error($con);
        }else{
            ?>

        <table  style="font-family: comfortaa-regular; font-size: 110%; color: #f6f6f6; text-align: center;" cellpadding=9 cellspacing=0  >
            <tr style="border-bottom: 2px solid #03caca;">
            
                <td>CF UTENTE</td>
                <td>PROBLEMATICA</td>
                <td>TIPO</td>
                <td>LIVELLO URGENZA</td>
               
          
                
            
            </tr>
            <?php
             $I=0;
            while($riga=mysqli_fetch_array($ris)){
               
                $codProblema=$riga['codProblema'];
  

                
                echo "<tr>";
                echo "<td>".$riga['CFu']."</td>";
                echo "<td>&ldquo;".$riga['descri']."&rdquo;</td>";
                echo "<td>".$riga['tipo']."</td>";
                if($riga['lvlUrgenza']=="basso")
                echo "<td rowspan=2><button id=basso disabled onmouseover=bShow($I) onmouseout=bHide($I) ></button><div id=bassoInfo$I style='display:none; color:#36ee08c4;' >basso</div></td>";

            else if($riga['lvlUrgenza']=="medio")
                echo "<td rowspan=2><button id=medio disabled onmouseover=mShow($I) onmouseout=mHide($I) ></button><div id=medioInfo$I style='display:none; color: #ff9203c9;' >medio</div></td>";
            else
                echo "<td rowspan=2><button id=alto disabled  onmouseover=aShow($I) onmouseout=aHide($I)></button><div id=altoInfo$I style='display:none; color:#c90707;' >alto</div></td>";
           

                echo"</tr><tr>";
                //controlla se è risolto oppure no
                if($riga['risolto']!=1){
                if($riga['CFa']==""){ //se nessuno l'ha ancora accettata
                    ?>
                      <td colspan=4 align=center>
                         <p style=" font-family: comfortaa-regular;">la richiesta <span style="color: #ff0303;">non è stata ancora accettata</span> da nessun admin<br>abbi pazienza e aspetta... ; )</p>
                     </td>
                        <?php
                }else{ //se è stata accettata = bottone per la chat
                    if($riga['rifiutato']!=1 )
                    echo "<td colspan=4><button id=btn class=pulsee onclick=chat($codProblema)>vai alla chat</button>";
                    else{
                        ?>
                        <td colspan=4 align=center>
                          <p style=" font-family: comfortaa-regular;">la richiesta è stata già <span style="color: #fffb03;">accettata</span> dall'admin <span style='color: #03d0ff;'><?php echo $riga['CFa']; ?></span></p>
                      </td>
                      <?php
                    }

                }
                echo"</tr><tr style='border-bottom: 1px dashed #078888;'>";
            
            }

                $I++;
                
            }

            mysqli_close($con);
            
        }



   
    ?>

    

    </div>
</body>



</html>
<script>
	/*jquery !!! */

	/**toglie il messaggio */
	$("#error").click(function(){ //quando si clicca sull'oggetto con id error 
		$("#error").fadeToggle(); //lo fa sparire con un'animazione
		window.location.href="vediRichieste .php"; /**ricarica cosi quando si preme il tasto refersh sul browser non appare di nuovo */
	
    });
</script>
<script>
    function bShow(x){ document.getElementById("bassoInfo"+x).style.display="block";}
    function bHide(x){ document.getElementById("bassoInfo"+x).style.display="none";}

    function mShow(x){ document.getElementById("medioInfo"+x).style.display="block";}
    function mHide(x){ document.getElementById("medioInfo"+x).style.display="none";}

    function aShow(x){ document.getElementById("altoInfo"+x).style.display="block";}
    function aHide(x){ document.getElementById("altoInfo"+x).style.display="none";}


     function goBack(){ 
        window.location.href="areaUtente.php";
    }

   

    function chat(num){
        window.location.href="chat.php?cod="+num;
    }

</script>

