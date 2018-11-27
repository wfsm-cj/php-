<?php
session_start();
/*
	resource imagecreatetruecolor(int $width,int $height);
	返回一个图像标识符，代表了一个x_size 和 y_size 的黑色图像

	int imagecolorallocate(resource $image,int $red,int $green,int $blue);
	为一副图像分配颜色，返回一个标识符，代表了由给定的RGB成分组成的颜色

	bool imagestring(resource $image,int $font,int $x,int $y,string $s,int $col)
	水平的画一行字符串， 用$col颜色将字符串$s画到所代表的图像$x,$y坐标处，如果$font 是1,2,3,4或5，则使用内置字体

	bool imagepng(resource $image[,string $filename])
	以png格式将图片输出到浏览器或文件,如果用filename给出了文件名则将其输出到该文件

	bool imagedestroy(resource $image)
	销毁一图像，释放与image关联的内存

	bool imagefill(resource $image,int $x ,int $y,int $corlor)
	区域填充 在$image图像的坐标$x,$y 进行区域填充$color

	int rand(void)
	返回0-getrandmax() 之间的伪随机整数

	int rand(int $min,int $max);
	返回 $min -$max 之间的伪随机整数

	bool imagesetpixel(resource $image,int $x,int $y,int $color);
	在$image图像中用 $color颜色在$x,$y，坐标画一个点

	bool imageline(resource $image,int $x1,int $y1,int $x2,int $y2,int $color);
	用$color颜色在图像image中从坐标 $x1,$y1 到 $x2,$y2上画一条线段

	int strlen(string $string)
	返回给定的字符串string的长度

	string substr(string $string,int $start[,int $length]);
	返回字符串string 由 start和length参数指定的子字符串

	bool session_start([ array $options=array() ])
	启动新会话或者重用现有会话，成功返回true 否则返回false

	string file_get_contents(string $filename);
	将整个文件读入一个字符串

	array imagettftext(resource $image,float $size,float $angle,int $x,int $y, int $color,string $fontfile,string $text)
	使用trueType字体将制定的text写入图像  angle角度制表示的角度，更高数值表示逆时针旋转
*/ 
header("content-type:image/png");

$image=@imagecreatetruecolor(200, 60) or die('can not initialize new GD image stream');
$text_color=imagecolorallocate($image,233,14,91);
// allocate  分配
$bg_color=imagecolorallocate($image, 255, 255, 255);
// imagestring($image,1,5,5,'a Simple Text String',$text_color);
imagefill($image, 0, 0, $bg_color);



// $fontsize=6;
// for($i=0;$i<4;$i++){
// 	// 0-120是深色区间 
// 	$fontcolor=imagecolorallocate($image, rand(0,120), rand(0,120), rand(0,120));
// 	$fontcontent=rand(0,9);
// 	$x=($i*100/4)+rand(5,10);
// 	$y=rand(5,10);
// 	imagestring($image, $fontsize, $x, $y, $fontcontent,$fontcolor);
// }

// 验证码加干扰元素，干扰机器能识别里面的内容，加一些干扰的点或者线
for($i=0;$i<200;$i++){
	$pointcolor=imagecolorallocate($image, rand(50,200), rand(50,200), rand(50,200));
	imagesetpixel($image, rand(1,199), rand(1,59), $pointcolor);
}

for($i=0;$i<3;$i++){
	$linecolor=imagecolorallocate($image, rand(80,220),  rand(80,220),  rand(80,220));
	imageline($image, rand(1,199), rand(1,59), rand(1,199), rand(1,59), $linecolor);
}

$captcha_code="";
$fontsize=6;
$fontface='FZYTK.TTF';
$strdb=array("慕","课","副","手");
// 把一些容易起冲突的字符干掉 比如 0 和o   L和1  2和z
$data='abcdefghijkmnopqrstuvwy3456789';
$strlength=strlen($data);
for($i=0;$i<4;$i++){
	$fontcolor=imagecolorallocate($image, rand(0,120), rand(0,120), rand(0,120));
	$fontcontent=substr($data,rand(0,$strlength),1);
	$x=($i*100/4)+rand(5,10);
	$y=rand(5,10);
	$captcha_code.=$fontcontent;
	imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);

	// 中文验证码
	// $cn=$strdb[$i];
	// $captcha_code.=$cn;
	// imagettftext($image, mt_rand(20,24), mt_rand(-60,60),(40*$i+20), mt_rand(30,35), $fontcolor, $fontface, $cn);

}

// 将验证码内容记录在服务端

// 多服务器的时候需要考虑session的问题
$_SESSION['authcode']=$captcha_code;





imagepng($image);
imagedestroy($image);

?>