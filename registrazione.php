<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	registrazione </title>
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
    
    



    legend{
        color: #f6f6f6; 
        font-family: comfortaa-regular; 
        font-size: 110%;
      }

    fieldset{
        border: none;
      
    }

  


</style>
<body>
    <div class=sticky>
    <button id=btn class=fill onclick=goBack()>torna indietro</button>
</div>
    <center><styTit>{Registrazione}</styTit>

    <div style="padding:20px;margin-top:20px;"> 

    <?php

        if(isset($_POST['cf'])){
            /**deve aggiungere l'utente al DB */
            $cf=$_POST['cf'];
            $psw=hash("sha256", $_POST['psw']);
            $nome=$_POST['nome'];
            $cognome=$_POST['cognome'];
            $dataNascita=$_POST['dataNascita'];
            $email=$_POST['email'];
            $tel=$_POST['tel'];
            $pIVA=$_POST['pIVA'];
            $genere=$_POST['genere'];

            include 'connessione.php';

            if($dataNascita!="")
                $query="insert into Utenti values
                    ('$cf', '$psw', '$nome', '$cognome', '$dataNascita', '$email', '$tel', '$pIVA', '$genere');";
            else
                $query="insert into Utenti values
                    ('$cf', '$psw', '$nome', '$cognome', null, '$email', '$tel', '$pIVA', '$genere');";

            $ris=mysqli_query($con, $query);

            if(!$ris){
                echo "errore ".mysqli_error($con);
            ?>
            <script>window.location.href="index.php?newUser=2"</script>
                <?php
            }else{
               
             
               
                require 'PHPMailer/PHPMailerAutoload.php';

                $mail = new PHPMailer;
    
                $mail->isSMTP();                            // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                     // Enable SMTP authentication
                $mail->Username = 'assis.onlinegiu@gmail.com';         // SMTP username del mittente
                $mail->Password = 'qwerty1234#'; 			// SMTP password del mittente
                $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                          // TCP port to connect to
    
                $mail->setFrom('assis.onlinegiu@gmail.com', 'Real Life i-Tech Help');
                $mail->addReplyTo('assis.onlinegiu@gmail.com', 'Real Life i-Tech Help');
                $mail->addAddress($email);   
              //  $mail->addAddress('assis.onlinegiu@gmail.com');   // Add a recipient, ho messo questo cosi' arrivano sempre qua, 
                $mail->addCC('');
                $mail->addBCC('');
    
                $mail->isHTML(true);  // Set email format to HTML
    
                $bodyContent = '<h1>Registrazione avvenuta</h1>';
                $bodyContent .= "<div style='font-family: comfortaa-regular;'><p> Benvenuto nel sito REAL LIFE I-TECH HELP  !!<br>
                                adesso potrai accedere alla tua area riservata cliccando al seguente link:<br>
                              <b><a href=http://127.0.0.1:80/info/assis_online/index.php>
                                http://127.0.0.1:80/info/assis_online/index.php</a></b>
                               
                                <br><br>
                                speriamo ti piaccia il sito, per qualsiasi motivo non esitare a chider aiuto ;)</p></div>";
    
                $mail->Subject = 'da Real Life I-Tech Help ;)';
                $mail->Body    = $bodyContent;
    
                if(!$mail->send()) {
                    ?>
                    <div id=error class=divMsg >
                    <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                    <button id=btnMsg type="button" class="close font__size-18" data-dismiss="alert">
                                                <span aria-hidden="true">
                                                    <i class="fa fa-times danger "></i>
                                                </span>
                                                <span class="sr-only">Close</span>
                                            </button>
                    <i class="start-icon far fa-times-circle faa-pulse animated"></i>
                    <strong class="font__weight-semibold">Oh  no!</strong> l'email non può essere inviata...<br><?php echo $mail->ErrorInfo; ?>
                    </div>
                </div>

                <?php

                 } else {
                      
                 ?>
                
                 <script>window.location.href="index.php?newUser=1"</script>
                 
               
                   <?php
 
                }
              
                               
                 }
                   
                 
               
   
               mysqli_close($con);
           
   
            
        }else{

    ?>

<div style=overflow-x:auto;>
  
    <!-- form registrazione -->
    <form method=POST name=dati >
    <table align=center cellpadding=7 cellspacing=0 >
        <tr>
        <!--prima di inviare i dati li controlla tramite JS-->
            <td><label for=cf>codice fiscale<font color=red>*</font></label></td>
            <td><input  style="background-image: url('icons/username.png');" type=text class=cf name=cf placeholder="codicefiscale" maxlenght=16 size=16 autocomplete=off  required></td>
        </tr>
        <tr>
            <td><label for=email>e-mail<font color=red>*</font></label></td>
            <td><input  style="background-image: url('icons/email.png');"  type=text id=email class=email name=email placeholder="inserisci email" autocomplete=off  required></td>
        </tr>
        
        <tr hidden id=wrongTRE height=2px>
        <td colspan=2>	
                    <div id=errorEmail class=divMsg>
					<div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
						<button type="button" class="close font__size-18" data-dismiss="alert">
								<span aria-hidden="true">
									<i class="fa fa-times warning"></i>
								</span>
								<span class="sr-only">Close</span>
						</button>
						<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
						<strong class="font__weight-semibold">Attenzione!</strong><span id=wrongEMAIL>a</span>
					</div>
                </div>
            </tr>
        <tr>
            <td><label for=nome>nome<font color=red>*</font></label></td>
            <td><input type=text style="background-image: url('icons/name.png');"  id=nome class=name name=nome placeholder="inserisci nome" autocomplete=off  ></td>
        </tr>
        <tr hidden id=wrongTRN height=2px>
        <td colspan=2>	
                    <div id=errorNome class=divMsg>
					<div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
						<button type="button" class="close font__size-18" data-dismiss="alert">
								<span aria-hidden="true">
									<i class="fa fa-times warning"></i>
								</span>
								<span class="sr-only">Close</span>
						</button>
						<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
						<strong class="font__weight-semibold">Attenzione!</strong><span id=wrongNAME>a</span>
					</div>
                </div>
            </tr>
        <tr>
            <td><label for=cognome>cognome</label></td>
            <td><input type=text style="background-image: url('icons/cognome.png');" id=cognome class=name name=cognome placeholder="inserisci cognome" autocomplete=off  ></td>
        </tr>
      
        <tr>
            <td ><fieldset><legend align=center>nuova password<font color=red>*</font></legend>
                <input type=password name=psw  style="background-image: url('icons/psw.png');"  placeholder=***** class=psw required></td>
            <td><fieldset><legend align=center>conferma psw<font color=red>*</font></legend>
                <input type=password name=confPsw  style="background-image: url('icons/lock.png');"  placeholder=*****  class=psw required></td>
        </tr>
        <tr hidden id=wrongTRP height=2px>
                <td colspan=2>	
                    <div id=errorPsw class=divMsg>
					<div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
						<button type="button" class="close font__size-18" data-dismiss="alert">
								<span aria-hidden="true">
									<i class="fa fa-times warning"></i>
								</span>
								<span class="sr-only">Close</span>
						</button>
						<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
						<strong class="font__weight-semibold">Attenzione!</strong><span id=wrongPSW>a</span>
					</div>
                </div>
            </td>
            </tr>
        <tr>
            <td><label for=dataNascita>data nascita</label></td>
            <td><input type=date style="background-image: url('icons/data.png');"  id=dataNascita class=dataNascita name=dataNascita placeholder="" autocomplete=off  ></td>
        </tr>
        <tr>
            <td><label for=pIVA>partita IVA</label></td>
            <td><input type=text style="background-image: url('icons/piva.png');"  id=pIVA class=pIVA name=pIVA placeholder="IVA" autocomplete=off size=11  >
            
            <span style="margin-left: 5px;" class=" alert-simple alert-info "><a id=infoIVA>
                <i class="start-icon  fa fa-info-circle faa-shake animated"></i></a>
            </span>													
        </td>
        </tr>

        <tr>
            <td colspan=2><div id=infopIVA class=divMsg>
        <div class="alert fade alert-simple alert-info alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
          <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true">
										<i class="fa fa-times blue-cross"></i>
									</span>
									<span class="sr-only">Close</span>
								</button>
          <i class="start-icon  fa fa-info-circle faa-shake animated"></i>
          <strong class="font__weight-semibold"></strong> inserisci la partita IVA solo se vuoi ricevere la fattura
        </div>

      </div></td>
        </tr>

        <tr>
            <td><label for=tel>numero</label></td>
            <td><input type=text style="background-image: url('icons/tel.png');"  id=tel class=tel name=tel placeholder="telefono/cellulare" autocomplete=off  ></td>
        </tr>
        <tr i>
            <td><label >genere</label></td>
            <td>
                <input type=radio name=genere id=femmina value=F class="option-input radio" />
                <label for=femmina  >femmina</label>
                <input type=radio name=genere id=maschio value=M class="option-input radio" />
                <label for=maschio  >maschio</label>
                <input type=radio name=genere id=altro value=A checked class="option-input radio"/>
                <label for=altro  >altro</label>
            
        </td>
        </tr>
        <tr>
            
        </tr>
        <tr>
            <td colspan=2 align=center><input type=reset  id=svuota onclick=resetTUTTO() style="font-size: 115%;" value=cancella class=offset >
            <button id=btn onclick=controlla() style="font-size: 115%;" class=pulsee>registrati</button></td>
        </tr>

    </form>
   
    <?php
        }
    ?>


</body>


<script>
    function goBack(){
        window.location.href="index.php";
    }
function resetTUTTO(){
    document.getElementById("wrongTRE").hidden=true;
    document.getElementById("wrongTRP").hidden=true;
    document.getElementById("wrongTRN").hidden=true;
}
function controlla(){
    var result= window.confirm ("stai per registrarti al sito...\nne sei sicuro??");
        /*finestra di conferma*/

    if(result!=false){

        var password=document.dati.psw.value;
        var conferma=document.dati.confPsw.value;
        var email=document.dati.email.value;
        var nome=document.dati.nome.value;

        var reg_exp =/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;/*è una stringa che serve a definire il formato possibile di una cosa
            deve contenere una prima parte di caratteri alfanumerici, obbligatoriamente la chioccola
            e anche il punto obbligatorio
            è un oggetto che ha una funzione test, se li si passa una stringa,  da vero se rispetta il formato*/

           
        
        if(!reg_exp.test(email)|| (email=="")){/*se è vuota o se non rispetta il formato*/
                
                //document.dati.email.value = "";//scuota il campo email
                
              
            document.getElementById("wrongEMAIL").innerHTML = "l'email inserita non è valida...";
      
            document.getElementById("wrongTRE").hidden=false;
               
        }else
            email="okei";
            
        if(nome==""){
            document.getElementById("wrongNAME").innerHTML = "il nome non può essere lasciato vuoto...";
      
            document.getElementById("wrongTRN").hidden=false;
        }
                
        if(password != conferma){
                     
            document.dati.psw.value="";
            document.dati.confPsw.value="";
            document.getElementById("wrongPSW").innerHTML = "le due password devono coincidere...";
      
            document.getElementById("wrongTRP").hidden=false;
                        
        }else if(password==""){
            document.dati.psw.value="";
            document.dati.confPsw.value="";
            document.getElementById("wrongPSW").innerHTML = "la password non può essere vuota...";
            document.getElementById("wrongTRP").hidden=false;
                       
        }else{
            password="okei";

            
        }

        if(email=="okei" && password=="okei"){
            document.dati.action="registrazione.php";
            document.dati.submit();
        }else
            return false; //fa uscire dalla la funzione
                
        
        }
    }




</script>


<script>
	/**toglie il messaggio */
	$("#errorEmail").click(function(){
		$("#errorEmail").fadeToggle();
		
	});

    	/**toglie il messaggio */
	$("#errorPsw").click(function(){
		$("#errorPsw").fadeToggle();

	});

    	/**toglie il messaggio */
    $("#errorNome").click(function(){
		$("#errorNome").fadeToggle();
	
	});

    	/**toglie il messaggio */
	$("#infopIVA").click(function(){
		$("#infopIVA").fadeToggle();
	
	});

	$("#infoIVA").click(function(){
		$("#infopIVA").fadeToggle();
		
	});


</script>

</html>