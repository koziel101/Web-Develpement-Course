<?php

error_reporting(E_ALL);

include("../connection.php");

if (!$_GET['course']) $_GET['course']="webdev";
if (!$_GET['number']) $_GET['number']=1;

$course=$_GET['course'];

$courseid['watch'] = 370636;
$url['watch'] = 'https://www.udemy.com/complete-apple-watch-developer-course/';

$courseid['webdev'] = 185774;
$url['webdev'] = 'https://www.udemy.com/complete-web-developer-course/';

$courseid['ios'] = 250114;
$url['ios']='https://www.udemy.com/complete-ios-developer-course/';

$courseid['oop'] = 242574;
$url['oop'] = 'https://www.udemy.com/object-oriented-programming-in-php/';

$courseid['android'] = 428526;
$url['android'] = 'https://www.udemy.com/the-complete-android-developer-course/';

$courseid['ios9'] = 528422;
$url['ios9'] = 'https://www.udemy.com/the-complete-ios-9-developer-course/';

$courseid['web2'] = 764164;
$url['web2'] = 'https://www.udemy.com/the-complete-web-developer-course-2/';


//INSERT PEOPLE INTO DATABASE 
 
$emailtext = "";

$emails=explode("
", $emailtext);

foreach ($emails as $email ) {

$row=mysql_fetch_array(mysql_query("SELECT * FROM coursecoupons WHERE email='".$email."'"));

if (!$row) {

$row=mysql_fetch_array(mysql_query("SELECT * FROM coursecoupons WHERE email='' ORDER BY id LIMIT 1"));


mysql_query("UPDATE coursecoupons SET email='".mysql_real_escape_string($email)."' WHERE id=".$row['id']." LIMIT 1");

}

}



if (!class_exists('PHPMailer')) {
   require '../PHPMailer/PHPMailerAutoload.php';
}


include("../udemylogin.php");


function getcouponcode($coupon_code, $price, $noc, $course_id) {

global $n;

    echo 'https://www.udemy.com/course-manage/create-coupon-code/?courseId='.$course_id;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'https://www.udemy.com/course-manage/create-coupon-code/?courseId='.$course_id); 
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$n[1]));
echo $coupen=curl_exec($ch);
curl_close($ch);
preg_match('(csrfmiddlewaretoken=(.*?);)',$coupen,$m);

$csrf=$m[1];
echo 'xxx';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'https://www.udemy.com/course-manage/create-coupon-code/?courseId='.$course_id);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,"csrfmiddlewaretoken=$csrf&coupon_code=$coupon_code&price=$price&coupons_left=$noc&coupon_deadline=&submit=Save");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_HTTPHEADER, array("Referer: https://www.udemy.com/course-manage/create-coupon-code/?courseId=".$course_id,"Authorization: Bearer ".$n[1]));
echo $o=curl_exec($ch);
curl_close($ch);

if(stripos($o,'That coupon code has already been used'))
{
echo 'That coupon code has already been used';
}
else if(stripos($o,'This field is required'))
{
echo 'some fields left blank';
}
else if(stripos($o,'Your coupon code is created'))
{
return true;
}
else if(stripos($o,'Ensure this value is greater than or equal to 1'))
{
echo 'number of coupons should be greater than or equal to 1';
}
else
{
echo 'unknown error occured';
}
return false;
}




$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';

/*
if (!$_GET['email'] && $_GET['test']==1) {

$i=0;
while ($i < 5009) {
echo mysql_query("INSERT INTO  `coursecoupons` 
(`email`) VALUES('appsumo');");

$i++;
}
} */

if ($_GET['codestarsuniversity']) {
    
    foreach ($courseid as $key => $value) {
      
        $string = '';
 for ($i = 0; $i < 10; $i++) {
      $string .= $characters[rand(0, strlen($characters) - 1)];
 }  
        
        if (getcouponcode($string, 0, 1, $courseid[$key])) $cucodes .= $url[$key].'?couponCode='.$string.'~';
        
    }
    
    
} else if (!$_GET['email']) {

$result=mysql_query("SELECT * 
FROM  `coursecoupons` 
WHERE  couponcode=''
LIMIT 500");
while ($row=mysql_fetch_array($result)) {

print_r($row);
$course=$row['course'];

 $string = '';
 for ($i = 0; $i < 10; $i++) {
      $string .= $characters[rand(0, strlen($characters) - 1)];
 }


echo $couponCode=$string;
$initPrice="0";
$couponsLeft="1";
$couponDeadline=rawurlencode("2025-08-31 23:59:00");

$postdata="couponCode=$couponCode&initPrice=$initPrice&couponsLeft=$couponsLeft&couponDeadline=$couponDeadline";

for($i=0; $i<3; $i++){
	$key=$matches3[1][$i];
	$value=$matches3[2][$i];
	$postdata.="&$key=$value";
	
	echo "<span style='color:red'><b>$key=$value</b></span><br/>";

}

if (getcouponcode($couponCode, $initPrice, $couponsLeft, $courseid[$course])) mysql_query("UPDATE `coursecoupons` SET  `couponcode` =  '".$couponCode."' WHERE  `id` =".$row['id']." LIMIT 1");




}

} else {




$k=0;

while ($k<$_GET['number']) {
$k++;
 $string = '';
 for ($i = 0; $i < 10; $i++) {
      $string .= $characters[rand(0, strlen($characters) - 1)];
 }


$couponCode=$string;
$initPrice="0";
$couponsLeft="1";
$couponDeadline=rawurlencode("2018-08-31 23:59:00");

if ($_GET['price']) $initPrice=$_GET['price'];
//if ($_GET['number']) $couponsLeft=$_GET['number'];
if ($_GET['deadline']) $couponDeadline=rawurlencode($_GET['deadline']." 23:59:00");

$postdata="couponCode=$couponCode&initPrice[currency]=usd&initPrice[amount]=$initPrice&couponsLeft=$couponsLeft&couponDeadline=$couponDeadline";

for($i=0; $i<3; $i++){
	$key=$matches3[1][$i];
	$value=$matches3[2][$i];
	$postdata.="&$key=$value";
	

}
//echo $postdata;

//echo $createcoupon = post("https://www.udemy.com/course-manage/create-coupon-code-submit/", "https://www.udemy.com/course-manage/create-coupon-code/?courseId=".$courseid[$course]."&displayType=ajax", $agent, $cookie, $postdata);

$pos = strpos($createcoupon, "equired");

if ($course=="android") $pword="&password=beta";

if (getcouponcode($couponCode, $initPrice, $couponsLeft, $courseid[$course])) echo $url[$course]."?couponCode=".$couponCode.$pword;

if ($_GET['number']>1) echo "<br />";

}

}



?>







