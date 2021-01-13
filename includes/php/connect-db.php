<?php
	 try
		{
			$db = new PDO('mysql:host=localhost;dbname=iplogger;charset=utf8', 'username', 'password');
		}
	catch(Exception $e) 
		{
			die('Erreur : '.$e->getMessage());
		}
