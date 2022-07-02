<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	next </title>
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
 

    <?php

        
        
        $problema=$_POST['descri'];

                
    //inserisce il problema nel DB
    include 'connessione.php';

    if(isset($_POST['tipo']))
        $query="insert into Faq values
            ('".$_SESSION['cf']."', null, '$problema', '".$_POST['tipo']."');";
    else
        $query="insert into Faq values
            ('".$_SESSION['cf']."', null, '$problema', null);";

    $ris=mysqli_query($con, $query);

    if(!$ris)
        echo "erroree ".mysqli_error($con);
    else{

    //fine inserimeto


        $codFaq=mysqli_insert_id($con);
        //echo $codFaq;

    ?>
    <form  method=POST name=dati >
    <table align=center  cellpadding=10 cellspacing=0 >
        <?php

            $newS=$_POST['totS'];
            for($I=0; $I<$_POST['totS']; $I++){
                ?>
        <tr>
            <td><label for=descri>soluzione <?php echo $I+1; ?><font color=red>*</font></label></td>
            <td c><textarea class=descri id=descri name=<?php echo $I; ?> placeholder="inserisci una breve descrizione"  maxlength=300  required></textarea>
            <br><span id=totChar>300</span></td>
        </tr>
        <tr hidden id=wrongTRD >
        <td >	
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
    <?php } 


    ?>
    <tr>
    <td colspan=2 align=center>
    <button id=btn onclick=indietro() style="font-size: 115%;" class=raise name=indetro>indietro</button>
    <input type=reset style="font-size: 115%;"  id=svuota value=cancella class=offset >


    <button id=btn onclick=controlla() style="font-size: 115%;" class=pulsee name=fine>fine</button></td>

    </tr>
    </form>
    <?php

    for($I=0; $I<$_GET['totS']; $I++){

      if(isset($_POST[$I]) ){
        $query="insert into ha values
        ($codFaq, '".$_POST[$I]."');";

        $ris=mysqli_query($con, $query);

        if(!$ris)
          echo "err";
        }  
      }


   
    }

    mysqli_close($con);
    if($newS==0){ ?>
      <script>window.location.href=gestisciFaq.php</script> <?php
    }
    ?>

</body>
</html>
<script>

function goBack(){ 
        window.location.href="gestisciFaq.php";
    }

    function indietro(){ 
        window.location.href="nuovaFaq.php";
    }



    function resetTUTTO(){
    document.getElementById("wrongTRD").hidden=true;
    
}


function controlla(){

    /*   var descri=document.dati.descri.value;
    
       if(descri==""){
             
           document.getElementById("wrongDESCRI").innerHTML = "devi inserire la descrizione del problema..";
     
           document.getElementById("wrongTRD").hidden=false;
           
           return false; //fa uscire dalla la funzione
       }else{
           */
           document.dati.action="fine.php?codFaq=<?php echo $codFaq; ?>&newS=<?php echo $newS;?>";
           document.dati.submit();
       /*}*/
       
     
               
       
   
       
   }




</script>


<script>
	/**toglie il messaggio */
	$("#errorDescri").click(function(){
		$("#errorDescri").fadeToggle();
		
	});

    	

</script>

<script>
/*
document.getElementById('descri').onkeyup = function () {
   if(this.value.length!=0){
     document.getElementById("totChar").style.display="inline-block";      

     document.getElementById("totChar").innerHTML = "caratteri rimasti: " + (300 - this.value.length);
    }else
     document.getElementById("totChar").style.display="none";     
}*/

</script>