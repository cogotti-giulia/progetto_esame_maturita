<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	fine </title>


    <?php

 
    //inserisce il problema nel DB
    include 'connessione.php';

    for($I=0; $I<$_GET['newS']; $I++){
          $query="insert into Soluzioni values
              (null, '".$_POST[$I]."');";
      //echo $_POST[$I];
      $ris=mysqli_query($con, $query);

      if(!$ris)
          echo "erroree ".mysqli_error($con);
      else{
        $query="insert into ha values
        (".$_GET['codFaq'].", '".mysqli_insert_id($con)."');";

        $ris=mysqli_query($con, $query);

        if(!$ris)
          echo "err";
        
      
      }
      
  }

  ?>
      <script>window.location.href=gestisciFaq.php</script> <?php
   
  

      
        
    

    mysqli_close($con);

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

       var descri=document.dati.descri.value;
    
       if(descri==""){
             
           document.getElementById("wrongDESCRI").innerHTML = "devi inserire la descrizione del problema..";
     
           document.getElementById("wrongTRD").hidden=false;
           
           return false; //fa uscire dalla la funzione
       }else{
           
           document.dati.action="fine.php?newS=<?php echo $newS;?>";
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

