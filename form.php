


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php
session_start();
if(isset($_REQUEST['authcode'])){
	if(strtolower($_REQUEST['authcode'])==$_SESSION['authcode']){
		echo '<font color="#0000cc">输入正确</font>';
	}else{
		echo '<font color="#cc0000">输入错误</font>';
	}

	exit();
}

?>
	<form action="" method="post">
		<p>验证码图片<img src="./captcha.php" alt="" id="captcha_img">
<a href="javascript:void(0)" onclick="document.querySelector('#captcha_img').src='./captcha.php'">换一个？</a>
		</p> 
		<p>请输入图片中的内容： <input type="text" name="authcode" value=""></p>
		<p><input type="submit" value="提交"></p>
	</form>

</body>
</html>