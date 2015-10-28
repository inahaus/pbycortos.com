<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name class.session.php
*/
class Session
	{

		function Session(){session_start();}

		function set($name, $value){$_SESSION[$name] = $value;}

		function get($name)
		{
			if (isset($_SESSION[$name]))
				return $_SESSION[$name];
			else
				return false;
		}

		function del($name){unset($_SESSION[$name]);}

		function destroy()
		{
            @session_start();
			$_SESSION = array();
			session_destroy();
		}
	}
?>