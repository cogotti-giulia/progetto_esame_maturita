<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
    }
 
?>

<!doctype html>
<html>
<title>	chat </title>
<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<body>

<style>
  
  #MSG{
   
    position: absolute;
    visibility: Hidden;
    width: 1px;
    height: 1px;
  }


</style>

<body>
<div class=sticky>

<button id=btn class=fill onclick=goBack("<?php echo $_SESSION['tipo']; ?>") >torna indietro</button>
</div>
<center>
    <styTit>{Chat Problema <?php echo $_GET['cod']; ?>}</styTit>

    <div style="padding:20px;margin-top:20px;"> 


<?php $cod=$_GET['cod']; 


  if($_SESSION['tipo']=="a"){
    /**se è un admin ha il pulsante per segnare risolto il problema e chiudere la chat */
?>
    <div style="position:fixed; right: 0px; margin: 20px; bottom:0; ">
        
       
        <span id=ris style="font-family: comfortaa-regular;
            color:#fffb03; 
            font-size: 120%;
            position: relative;
            top: 5px;
            margin-right: 2px;
            display: none;">risolto</span>
             <button class=risolto style="border: 1px solid #fffb03;
  background-color: rgba(236, 201, 5, 0.452);
  box-shadow: 0px 0px 15px #fffb03;


  padding: 25px;
  border-radius:100px;

  cursor: pointer;" onclick=risolto("<?php echo $cod ?>")></button>
    </div>
    
    <?php
  }


  if(!isset($_GET['risolto'])){



?>




<div id="CHAT" class=chatDiv></div>

  <form id=my_form name="chat" method="post"  action="messaggio.php?cod=<?php echo $cod; ?>" >
    <input type="text" name="msg" id=msg maxlength="500" placeholder="scrivi qualcosa..." autocomplete=off >
   <input type="submit" class=raise value="invia messaggio"><br>
   <span id=totChar>500</span>
    <input type=hidden name=cod value=<?php echo $cod; ?>>
  </form>
  <iframe src="messaggio.php" name="MSG" id="MSG"></iframe>

<?php

  }else{
    //mette risolto nel db e torna alla pagina delle richieste
    include 'connessione.php';

    $query="update Assistenza set risolto=1
      where codProblema=".$_GET['cod']." and CFa='".$_SESSION['cf']."';";

    $ris=mysqli_query($con, $query);

    if(!$ris)
      echo "erer".mysqli_error($con);
    else
      ?>
  <script> window.location.href="richiesteUsr.php"</script>

      <?php

  }

?>

</body>
</html>

<!-- onclick=a("</*?php echo $cod ?>"*/) -->

<script>
  $(".risolto").mouseover(function(){

      $("#ris").fadeIn();
  });

  $(".risolto").mouseout(function(){

    $("#ris").fadeToggle();
  });
</script>

<script>


    function  goBack(tipo){
     
        if(tipo=="a")
          window.location.href="richiesteUsr.php";
        else
          window.location.href="vediRichieste.php";
      
    }

    function risolto(cod){
      window.location.href="chat.php?cod="+cod+"&risolto=1";
    }


    document.getElementById('msg').onkeyup = function () {
    if(this.value.length!=0){
      document.getElementById("totChar").style.display="inline-block";      

      document.getElementById("totChar").innerHTML = "caratteri rimasti: " + (500 - this.value.length);
     }else
      document.getElementById("totChar").style.display="none";      


};

</script>
<script>
/**invia i dati con ajax, quindi non si vede la pagina bianca nemmeno per un secondo */
$("#my_form").submit(function(event){
	event.preventDefault(); //prevent default action 
	var post_url = $(this).attr("action"); //get form action url
	var request_method = $(this).attr("method"); //get form GET/POST method
	var form_data = $(this).serialize(); //Encode form elements for submission
	
	$.ajax({
		url : post_url,
		type: request_method,
		data : form_data
	}).done(function(response){ 
		$("#CHAT").html(response);
	});
});
</script>
<script>
/*update, aggiorna la pagina chiamando request che aggiorna ogni  secondom, 
cosi se arrivano nuovi messaggi non c'è bisogno di ricaricarla, darebbe fastidio*/
function Update() {
  return Request();
}
window.setInterval("Update()", 1000)

var XMLHTTP;
function Request(){
  XMLHTTP = GetBrowser(ChangeStatus);
  XMLHTTP.open("GET", "ajax.php?cod=<?php echo $cod?>", true);
  XMLHTTP.send(null);
}

/*mostra i differenti record*/
function ChangeStatus(){
  if (XMLHTTP.readyState == 4){
    var R = document.getElementById("CHAT");
    R.innerHTML = XMLHTTP.responseText;
  }
}

/*verifica il supporto ajax da parte del browser in uso*/
function GetBrowser(FindBrowser){
  if (navigator.userAgent.indexOf("MSIE") != (-1)){
    var Class = "Msxml2.XMLHTTP";
    
    if (navigator.appVersion.indexOf("MSIE 5.5") != (-1));{
      Class = "Microsoft.XMLHTTP";
    } 
    try{
      ObjXMLHTTP = new ActiveXObject(Class);
      ObjXMLHTTP.onreadystatechange = FindBrowser;
      return ObjXMLHTTP;

    }catch(e){
      alert("attenzione: l'ActiveX non sarà eseguito!");
    }

  }else if (navigator.userAgent.indexOf("Mozilla") != (-1)){
    ObjXMLHTTP = new XMLHttpRequest();
    ObjXMLHTTP.onload = FindBrowser;
    ObjXMLHTTP.onerror = FindBrowser;
    return ObjXMLHTTP;

  }else{
    alert("L'esempio non funziona con altri browser!");
  }
}

</script>