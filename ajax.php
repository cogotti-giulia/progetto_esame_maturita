<?php

session_start();
if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
  session_destroy();
  $_SESSION=array();
  }
/*stampa i messaggi*/
/**tramite l'ajax viene aggiornata ogni secondo, senza far vedere il refresh nella pagina;
 * in questo modo appena uno manda un messaggio, l'altro lo vedrà apparire senza dover
 * ricare il browser, e viceversa.
 *
 */
  ?>

  <?php
  
    include 'connessione.php';

    /**prende i messaggi relativi al problema con codice preso dall'url
     * li ordina per data e orario
     */
    $query="select msg, tx, orario, dataa
      from chat c inner join Assistenza a on c.codProblema=a.codProblema 
      where c.codProblema=".$_GET['cod']."
      order by dataa, orario ;";

    $ris=mysqli_query($con, $query);

    if(!$ris){
      echo "errpreee".mysqli_error($con);
    }else if(mysqli_num_rows($ris)==0){
    
      echo 'Non sono stati ancora inseriti dei messaggi.';
    }else{
     
     
      while ($riga = mysqli_fetch_array($ris)){ 
      
        $mex_utente = stripslashes($riga['msg']);
      /**stampa di colori diversi in base a chi è loggato dentro */
            echo "<span style='font-size: 80%; font-family: monospace;color: #f6f6f6;'>[".$riga['dataa'].";".$riga['orario']."] </span> ";
            if($_SESSION['nome']==$riga['tx'])
              echo "<span style='color: #03d0ff;' ><b>".$riga['tx']."</b> : &ldquo; ". $mex_utente." &rdquo; </span><br>";
            else
              echo "<b>".$riga['tx']."</b> : &ldquo; ". $mex_utente." &rdquo; <br>";

      }


    
    }



  
?>
