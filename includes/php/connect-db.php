<?php
	 try
		{
			$db = new PDO('mysql:host=localhost;dbname=iplogger;charset=utf8', 'morc', 'tttttt');
		}
	catch(Exception $e) 
		{
			die('Erreur : '.$e->getMessage());
		}
