<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<html>
<title>	home page </title>

<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>




<center>


<div style="padding:15px;margin-top: 40px;"> 

<span style="	color: #00f4f4; 
		font-family: starsFighters; 
		font-size:200%; 
		padding:20px;
		margin-top:10px;">Real Life i-Tech Help</span>

<div style="padding:20px;margin-top:100px;"> 


<?php
				if(isset($_GET['error'])){
					if($_GET['error']==1){/**stampa l'errore se le credenziali sono erratte */
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
					<strong class="font__weight-semibold">Oh  no!</strong> Utente non registrato o credenziali errate...
					</div>
				</div>

			<?php
					
				
					}else{
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
								<strong class="font__weight-semibold">Oh  no!</strong> Utente non registrato o credenziali errate...<br>se non sei un admin accedi come utente base!
								</div>
							</div>
			
						<?php
					}
				}else if(isset($_GET['pswAd'])){
					?>

				<div id=error class=divMsg>
					<div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
						<button type="button" class="close font__size-18" data-dismiss="alert">
								<span aria-hidden="true">
									<i class="fa fa-times warning"></i>
								</span>
								<span class="sr-only">Close</span>
						</button>
						<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
						<strong class="font__weight-semibold">Attenzione!</strong> la password dell'admin non può essere vuota
					</div>
				</div>
					<?php
				}else if(isset($_GET['logout']) && $_GET['logout']==1){
					?>
					<div id=error class="divMsg" >
        <div class="alert fade alert-simple alert-primary alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
          <button type="button" id=q  class="close font__size-18" data-dismiss="alert">
									<span  aria-hidden="true"><i class="fa fa-times alertprimary"></i></span>
									<span class="sr-only">Close</span>
								</button>
					
          <i class="start-icon fa fa-thumbs-up faa-bounce animated"></i>
		  <strong class="font__weight-semibold">Bene!</strong> logout effettuato con successo!
		        </div>

      </div>


<?php

				}else if(isset($_GET['newUser'])){
					if($_GET['newUser']==1){
					?>

     <div id=error class="divMsg">
        <div class="alert fade alert-simple alert-success alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show">
          <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true"><a onclick=close() target="_blank">
                    <i class="fa fa-times greencross"></i>
                    </a></span>
									<span class="sr-only">Close</span> 
								</button>
          <i class="start-icon far fa-check-circle faa-tada animated"></i>
          <strong class="font__weight-semibold">Bene!</strong> La tua registrazione è andata a buon fine!!
        </div>
      </div>
<?php
			}else{
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
								<strong class="font__weight-semibold">Oh  no!</strong> qualcosa è andato storto... registrazione non effettuata
								</div>
							</div>
			
						<?php
			}
				}
			?>


     <!--from per il login-->
        <form method=post name=formLogin>
		
        <table  cellpadding=5 cellspacing=0 > <tr>
			<td colspan=2 align=center >
				<!-- scritte che si cancellano grazie a JS -->
				<p style="font-size: 150%; font-family: comfortaa-bold; color: #f6f6f6;" href="" class="typewrite" data-period="2000" data-type='["BENVENUT* &#129321;", "accedi alla tua area riservata", "oppure registrati", "spero ti piaccia il sito ;)" ]'>
    <span class="wrap"></span>
	</p></td>
			
			<tr>
				<td align=center><label for=id>cf/email<font color=red style="">*</font></label></td>
                <td align=center><input style="background-image: url('icons/username.png');" class=name type=text name=id placeholder="nome utente" autocomplete=off  required></td>
			</tr>
			<tr>
				<td align=center><label for=psw>password<font color=red>*</font></label></td>
				<td align=center><input style="background-image: url('icons/psw.png');" class=psw type=password name=psw placeholder=password autocomplete=off  required></td>
			</tr>
		
			<tr id=trAdmin>
				<td  align=center><label for=pswAd>psw admin<font color=red>*</font></label></td>
				<td  align=center><input class=psw style="background-image: url('icons/lock.png');" type=password name=pswAd placeholder=password autocomplete=off  ></td>
			</tr>
		
			<tr>
			<td colspan=2 align=center>
			<!-- se deve entrare l'admin ha una password in più, uguale per tutti gli admin-->
					<input type=radio name=tipo id=admin value=a class="option-input radio" />
					<label for=admin>admin</label>
					<input type=radio name=tipo id=base value=b class="option-input radio" checked />
					<label for=base>base</label>
			
                
            
			</td></tr>

			<tr>
				<td colspan=2 align=center>
				<button id=btn class=slide onclick=faq()>visualizza FAQ</button>
				<button name=btn id=btn onclick=registrati() class=raise>REGISTRATI</button>
				<button onclick=invia() id=btn class=pulsee>ACCEDI</td>
			

			</tr></table>
        </form>

        </table>
  
        </div>

		<h1>
  
</h1>

	</body>
</html>

<script>
	/*jquery !!! */

	/**toglie il messaggio */
	$("#error").click(function(){ //quando si clicca sull'oggetto con id error 
		$("#error").fadeToggle(); //lo fa sparire con un'animazione
		window.location.href="index.php"; /**ricarica cosi quando si preme il tasto refersh sul browser non appare di nuovo */
	
	});

	$('#admin').click(function (){
		$('#trAdmin').show();

	});

	$('#base').click(function (){
		$('#trAdmin').hide();

	});

	/*$("#base").prop("checked", true){
		$('#trAdmin').hide();
	};*/


</script>

<script>
	if($("#base").prop("checked"))
		$('#trAdmin').hide();

</script>

<script>

	function registrati(){
		window.location.href="registrazione.php";
	}

	function faq(){
		window.location.href="faq.php";
	}

/*	document.getElementById("admin").addEventListener("click", function(event) {
        event.stopPropagation();
        document.getElementById("lblAdmin").style.display="table-cell";
	
		document.getElementById("pswAdmin").style.display="table-cell";
		
    });

	document.getElementById("base").addEventListener("click", function(event) {
        event.stopPropagation();
		document.getElementById("lblAdmin").style.display="none";
		document.getElementById("pswAdmin").style.display="none";
    });*/
</script>



<script>

	function invia(){
		if(document.formLogin.tipo.value=="b"){
			document.formLogin.action="login.php";
            document.formLogin.submit();
		}else{
			if(document.formLogin.pswAd.value==""){
				
				document.formLogin.action="index.php?pswAd=1";

			}else{
				document.formLogin.action="login.php";
            	document.formLogin.submit();
			}
		}
	}

</script>




<script>
	/**serve per le scritte che si cancellano */
	var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
        }

        setTimeout(function() {
        that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };

</script>


