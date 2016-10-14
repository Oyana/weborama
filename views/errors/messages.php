<?php

//Error Messages
if(!empty($_SESSION['msgError'])){
	echo '<div class="alert alert-danger"><ul>';
	foreach ($_SESSION['msgError'] as $error){
		echo '<li>'. $error .'</li>';
	}
	echo '</ul></div>';
}

//Warning Messages
if(!empty($_SESSION['msgWarning'])){
	echo '<div class="alert alert-info"><ul>';
	foreach ($_SESSION['msgWarning'] as $warning){
		echo '<li>'. $warning .'</li>';
	}
	echo '</ul></div>';
}

//Info Messages
if(!empty($_SESSION['msgInfo'])){
	echo '<div class="alert alert-warning"><ul>';
	foreach ($_SESSION['msgInfo'] as $info){
		echo '<li>'. $info .'</li>';
	}
	echo '</ul></div>';
}

//Success Messages
if(!empty($_SESSION['msgSuccess'])){
	echo '<div class="alert alert-success"><ul>';
	foreach ($_SESSION['msgSuccess'] as $success){
		echo '<li>'. $success .'</li>';
	}
	echo '</ul></div>';
}
?>
