<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	assistenza </title>
<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>

    td{
        text-align:center;
    }
  

</style>


<body>
<div class=sticky>

<button id=btn class=fill onclick=goBack()>torna indietro</button>
</div>
<center>
    <styTit>{Richiedi Assistenza}</styTit>

    <div style="padding:20px;margin-top:20px;"> 

<div style=overflow-x:auto;>
  
    <?php
    
    if(isset($_GET['ok'])){
        /**deve inserire nel DB la richiesta */

        echo $_POST['inte'];

        include 'connessione.php';


        if(isset($_POST['tipo']))
            $query="insert into Assistenza values
                ('".$_SESSION['cf']."', '".$_POST['inte']."', null, null, '".$_POST['lvlUrgenza']."', '".$_POST['tipo']."', '".$_POST['descri']."', 0, 0);";
        else
            $query="insert into Assistenza values
                ('".$_SESSION['cf']."', '".$_POST['inte']."', null, null,'".$_POST['lvlUrgenza']."', null, '".$_POST['descri']."', 0, 0);";


        $ris=mysqli_query($con, $query);

        if(!$ris)
            echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >errore ".mysqli_error($con)."</p>";
        else{



        
            echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >
                la sua richiesta con codice ".mysqli_insert_id($con)." è stata inviata
                </p>";

        }


        mysqli_close($con);
    }else{
       

    ?>

    <!-- form  -->
    <form  method=POST name=dati >
    <table align=center  cellpadding=10 cellspacing=0 >
        <tr>
            <td><label for=descri>descrizione<font color=red>*</font></label></td>
            <td colspan=2><textarea class=descri id=descri name=descri placeholder="inserisci una breve descrizione"  maxlength=300  required></textarea>
            <br><span id=totChar>300</span></td>
        </tr>
        <tr hidden id=wrongTRD >
        <td colspan=3 >	
                    <div id=errorDescri class=divMsg>
					<div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
						<button type="button" class="close font__size-18" data-dismiss="alert">
								<span aria-hidden="true">
									<i class="fa fa-times warning"></i>
								</span>
								<span class="sr-only">Close</span>
						</button>
						<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
						<strong class="font__weight-semibold">Attenzione! </strong><span id=wrongDESCRI>a</span>
					</div>
                </div>
    </td></tr>
        <tr>
            <td><label>tipo</label></td>
            <td colspan=2>
                <input type=checkbox  id=tipo name=tipo value=hardware autocomplete=off  class="option-input checkbox" />
                <label for=tipo > hardware </label>

                <input type=checkbox id=tipo  name=tipo value=software autocomplete=off  class="option-input checkbox" />
                <label for=tipo > software </label>
        </td></tr>
        <tr>
            <td><label >livello urgenza<font color=red>*</font></label></td>
            <td colspan=2>
            <radiogroup>
                <input type=radio name=lvlUrgenza id=bassoR value="basso" autocomplete=off class="option-input radio" />
                <label for=bassoR  >basso</label>
                <input type=radio name=lvlUrgenza id=medioR value="medio" autocomplete=off checked class="option-input radio" />
                <label for=medioR  >medio</label>
                <input type=radio name=lvlUrgenza id=altoR value="alto" autocomplete=off class="option-input radio"/>
                <label for=altoR  >alto</label>
            </radiogroup>
            
        </td>
        </tr>
  
        <?php
            //prende le tipologie di intervento divise in base ai costi
            //non ho idea di che tipologie possano esistere...
            include 'connessione.php';

            $query="select * from Interventi;";

            $ris=mysqli_query($con, $query);

            if(!$ris)
                echo "errorrr ".mysqli_error($con);
            else if(mysqli_num_rows($ris)!=0){        
                echo "<tr>";
              
                ?>
                <tr>
                <td colspan=3>
                    <span style="font-family: comfortaa-regular; color: #f6f6f6;   font-size: 110%; ">scegli una tariffa per la tipologia d'intervento:<font color=red>*</font></span>
                </td>
            </tr>
            <tr>
                <?php
                while($riga=mysqli_fetch_array($ris)){
                
        ?>
        
        <td ><div style="float:center; align:center; height: 200px; width: 130px; " >
            <div class=inte id=<?php echo $riga['codInte']; ?> >

                <?php echo $riga['metodo']; ?> <br> <?php echo $riga['costo']." $"; ?><br>
            </div>
            <input type=radio id="rb<?php echo $riga['codInte']; ?>" value=<?php echo $riga['codInte']; ?>  autocomplete=off class="option-input radio" required name=inte > 
        </div></td>
   
        <?php
             
            }
    
        }
        
        ?>
        <tr>
            <td colspan=3 align=center><input type=reset style="font-size: 115%;"  id=svuota value=cancella class=offset >
            <button id=btn onclick=controlla() style="font-size: 115%;" class=pulsee name=invia>invia richiesta</button></td>
    
        </tr>

    </form>
   
    

    <?php
    
    }
    ?>
</body>



</html>
<script>
    /**jquery, serve per selezionare solo una checkbox alla volta!! così può anche lasciarla vuota! */
$(document).ready(function(){
    $('input:checkbox').click(function() {
        $('input:checkbox').not(this).prop('checked', false);
    });
});



$(".inte").click( function() {
 //  alert($(this).attr('id'));

   $("#rb"+$(this).attr('id')).prop("checked", true);

});


</script>

<script>

 document.getElementById('descri').onkeyup = function () {
    if(this.value.length!=0){
      document.getElementById("totChar").style.display="inline-block";      

      document.getElementById("totChar").innerHTML = "caratteri rimasti: " + (300 - this.value.length);
     }else
      document.getElementById("totChar").style.display="none";     
 }

</script>

<script>
    function  goBack(){
        window.location.href="areaUtente.php";
    }


    function resetTUTTO(){
    document.getElementById("wrongTRD").hidden=true;
    
}

</script>
<script>
function controlla(){
   
    var result= window.confirm ("stai per inviare la richiesta...\nne sei sicuro??");
        /*finestra di conferma*/

    if(result!=false){

        var descri=document.dati.descri.value;
       
        
        if(descri==""){
       
             
              
            document.getElementById("wrongDESCRI").innerHTML = "devi inserire la descrizione del problema..";
      
            document.getElementById("wrongTRD").hidden=false;
            
            return false; //fa uscire dalla la funzione
        }else{
            
            document.dati.action="assistenza.php?ok=1";
            document.dati.submit();
        }
        
      
                
        
    
        }
    }




</script>


<script>
	/**toglie il messaggio */
	$("#errorDescri").click(function(){
		$("#errorDescri").fadeToggle();
		
	});

    	

</script>


</script>