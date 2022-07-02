<?php

    session_start(); /**inizia la sessione */
	
	$id=$_POST['id'];
	$psw=hash("sha256", $_POST['psw']); /*cifra la psw inserita per vedere se è uguale a quella cifrata nel DB*/
	echo "aaaa";
	if(isset($_POST['tipo']) && $_POST['tipo']!="a"){
		include 'connessione.php';

		$query="select * from Utenti where (CFu='$id' or email='$id') and password='$psw';";

		$ris=mysqli_query($con, $query);

		if(!$ris)		//la query è sbagliata
			echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >errore ".mysqli_error($con)."</p>";
		else if(mysqli_num_rows($ris)==0) //non ci sono utenti con quei dati
			header("Location: index.php?error=1");
		else{
			//ha trovato l'utente nel DB, prende i dati e li salva i suoi dati nel vettore $_SESSION
			$utente=mysqli_fetch_array($ris); //associa il valore come in un vet assocciativo, l'indice è il nome dei campi della tabella del DB
			
			$_SESSION['cf']=$utente['CFu'];
			$_SESSION['nome']=$utente['nome'];
			$_SESSION['cognome']=$utente['cognome'];
			$_SESSION['dataNascita']=$utente['dataNascita'];
			$_SESSION['email']=$utente['email'];
			$_SESSION['genere']=$utente['genere'];	
			$_SESSION['tipo']="u";

					header("Location: areaUtente.php");
			
	
			mysqli_close($con);

		}

	}else{
		//echo "admi";
		//è l'admin
		$pswAd=hash("sha256", $_POST['pswAd']);

		include 'connessione.php';

		$query="select * from Adminn 
			where (CFa='$id' or email='$id') and password='$psw' and pswAd='$pswAd';";
		
			$ris=mysqli_query($con, $query);
		
		if(!$ris)		//la query è sbagliata
			echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >errore ".mysqli_error($con)."</p>";
		else if(mysqli_num_rows($ris)==0) //non ci sono utenti con quei dati
			header("Location: index.php?error=2");
		else{
			//ha trovato l'utente nel DB, prende i dati e li salva i suoi dati nel vettore $_SESSION
			$utente=mysqli_fetch_array($ris); //associa il valore come in un vet assocciativo, l'indice è il nome dei campi della tabella del DB
			
			$_SESSION['cf']=$utente['CFa'];
			$_SESSION['nome']=$utente['nome'];
			$_SESSION['cognome']=$utente['cognome'];
			$_SESSION['dataNascita']=$utente['dataNascita'];
			$_SESSION['email']=$utente['email'];
			$_SESSION['genere']=$utente['genere'];	

			$_SESSION['tipo']="a";

			
			header("Location: areaAdmin.php");
			

			mysqli_close($con);

		}

	}

?>