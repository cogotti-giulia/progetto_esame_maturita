<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	nuova faq </title>
<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
    td{
        text-align:center;
    }

    input:invalid+span:after {
  content: '✖';
  padding-left: 5px;
  color: #cc0000;
  font-size: 150%;
}

input:valid+span:after {
  content: '✓';
  padding-left: 5px;
  color: #00f4f4;
  font-size: 150%;
}
</style>
<body>
<div class=sticky> <!-- style="float:left;"-->
    <button class=fill id=btn onclick=goBack()>torna indietro</button>
</div>

<center>
<styTit>{Inserisci Nuova faq}</styTit>

<div style="padding:20px;margin-top:20px;"> 
 

    




    <form  method=POST name=dati >
    <table align=center  cellpadding=10 cellspacing=0 >
        <tr>
            <td><label for=descri>problema<font color=red>*</font></label></td>
            <td colspan=2><textarea class=descri id=descri name=descri placeholder="inserisci una breve descrizione"  maxlength=300  required></textarea>
            <br><span id=totChar>300</span></td>
        </tr>
        <tr hidden id=wrongTRD >
        <td colspan=2 >	
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
            <td >
                <input type=checkbox  id=tipo name=tipo value=hardware autocomplete=off  class="option-input checkbox" />
                <label for=tipo > hardware </label>

                <input type=checkbox id=tipo  name=tipo value=software autocomplete=off  class="option-input checkbox" />
                <label for=tipo > software </label>
        </td></tr>
        <tr >
            <td colspan=2><label for=descri>inserisci il numero di nuove soluzioni<font color=red>*</font></label>&nbsp;&nbsp;
            <input type=number style="width: 80px;" class=totS id=totS name=totS value="0" size=2  min=0 max=20 required></textarea>
            <span class="validity"></span>
        </tr>
        </table>
        <table align=center  cellpadding=0 cellspacing=0 >

        <?php
        /**prende le soluzioni già presenti, magari qualcuna va bene */
            include 'connessione.php';

            $query="select * from Soluzioni;";

            $ris=mysqli_query($con, $query);

            if(!$ris)
                echo "err";
            else if(mysqli_num_rows($ris)>0){
                ?>
            <tr style='border: 2px dashed #078888;'>
            <td colspan=2><label >seleziona le soluzioni che ritieni utili per la risoluzione del problema:</label>
            </tr>
<?php
                $I=0;
                while($riga=mysqli_fetch_array($ris)){
                echo "<tr><td><input type=checkbox  id=tipo name=$I value=".$riga['codSoluzione']." autocomplete=off  class='option-input checkbox' />
                </td><td style='text-align: left; '> <label style='padding-top:20px; padding-left:20px;' for=tipo > ".$riga['soluzione']." </label></td>";
                $I++;
            }

            $totS=$I;
                
            }
        ?>
        <tr>
            <td colspan=2 align=center><input type=reset style="font-size: 115%;"  id=svuota value=cancella class=offset >
            <button id=btn onclick=controlla() style="font-size: 115%;" class=pulsee name=avanti>avanti</button></td>
    
        </tr>

    </form>
  
</div>

</body>
</html>

<script>
function goBack(){ 
        window.location.href="gestisciFaq.php";
    }

    function resetTUTTO(){
    document.getElementById("wrongTRD").hidden=true;
    
}


function controlla(){

       var descri=document.dati.descri.value;
    
       if(descri==""){
             
           document.getElementById("wrongDESCRI").innerHTML = "devi inserire la descrizione del problema..";
     
           document.getElementById("wrongTRD").hidden=false;
           
           return false; //fa uscire dalla la funzione
       }else{
           
           document.dati.action="next.php?totS=<?php echo $totS;?>";
           document.dati.submit();
       }
       
     
               
       
   
       
   }




</script>


<script>
	/**toglie il messaggio */
	$("#errorDescri").click(function(){
		$("#errorDescri").fadeToggle();
		
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