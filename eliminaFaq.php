<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	elimina faq </title>
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
<body>
<div class=sticky> <!-- style="float:left;"-->
    <button class=fill id=btn onclick=goBack()>torna indietro</button>
</div>

<center>
<styTit>{Elimina faq}</styTit>

<div style="padding:20px;margin-top:20px;"> 
<!-- elimina le faq, o le soluzioni o le domande-->



  <?php
    if(isset($_GET['del'])){
      if($_GET['del']==1){
        //elimina le domande
        include 'connessione.php';

        $query="select * from Faq;";

        $ris=mysqli_query($con, $query);

        if(!$ris)
            echo "err";
        else if(mysqli_num_rows($ris)>0){
            ?>
        <form method=POST name=dati >
        <table align=center  cellpadding=0 cellspacing=0 >
        <tr style='border: 2px dashed #078888;' align=center>
        <td colspan=2><label >seleziona le faq da eliminare:</label>
        </tr>
<?php
            while($riga=mysqli_fetch_array($ris)){
            echo "<tr><td><input type=checkbox  id=tipo name=".$riga['codFaq']." value=".$riga['codFaq']." autocomplete=off  class='option-input checkbox' />
            </td><td style='text-align: left; '> <label style='padding-top:20px; padding-left:20px;' for=tipo > ".$riga['problema']." </label></td>";
            
        }

        ?>

<tr>
            <td colspan=2 align=center>  <button id=btn onclick=annulla() style="font-size: 115%;" class=offset name=annulla>annulla</button>
            <button id=btn onclick=elimina() style="font-size: 115%;" class=pulsee name=elimina>elimina</button>
    </td>
        </tr>


        </table>

        </form>

       <?php
            
        }
    
      }
    }else{

  ?>

  <button id=btn class=raise onclick=eliminaDom()>domande</button>
  <button id=btn class=closee onclick=eliminaSol()>soluzioni</button>

      <?php
    }
      ?>
</div>


</body>
</html>


<script>
    function goBack(){ 
        window.location.href="gestisciFaq.php";
    }

    function eliminaDom(){ 
        window.location.href="eliminaFaq.php?del=1";
    }
    function eliminaSol(){ 
        window.location.href="eliminaFaq.php?del=2";
    }

    function annulla(){
      window.location.href="eliminaFaq.php";
    }
    function elimina(){
      window.location.href="eliminaDom.php";
    }
</script>