<?php
	include "LibrarySystemLib.php"; 
	mysqli_set_charset($Link, 'utf8');

	$Password = GetPost('Password');
	$PasswordBD = Select($Link, 'Password', "`LibraryService`", "`id`= '1'");
	
	if(empty($Password) or $Password == "Password")
	{
		echo "Вы не ввели пароль!";
	}else{
		if ($Password == $PasswordBD)
		{
			echo "Вы успешно вошли в систему!";
		}else{
			echo "Вы неправильно ввели пароль!";
		}
	}
	mysqli_close($Link);
?>
