<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='../index.php'>Login</a> to Web Contents Manager !");
	}
        function get_date($date,$f='f'){
    //  date: nam.thang.ngay 20100427.
    // f: full: day du - ngày 27 tháng 04 năm 2010.
    // m hoac s: mini - small: ngắn gọn - 27-04-2010.
    $year = substr($date,6,4);
    $month = substr($date,0,2);
    $day = substr($date,3,2);
    if($f=='f'){
        return 'Ngày '.$day.' tháng '.$month.' năm '.$year;
    }elseif($f=='m' || $f=='s'){
        return $day.'-'.$month.'-'.$year;
    }else{
        return $day.$f.$month.$f.$year;
    }
}
function replace_badword($str) {
                $chars = array(
                '<a href="/thiet-ke-web.htm" title="thiết kế website">thiết kế website</a>'	=>	array('thiết kế website'),    
	);
	foreach ($chars as $key => $arr)
		foreach ($arr as $val)
			$str = str_replace($val, $key, $str);
	return $str;
}

function thumb($filename, $destination, $th_width, $th_height, $forcefill){ 
		list($width, $height) = getimagesize($filename);
		$source = imagecreatefromjpeg($filename);	
		if($width > $th_width || $height > $th_height){
			$a = $th_width/$th_height;
			$b = $width/$height;
			if(($a > $b)^$forcefill){
				$src_rect_width = $a * $height;
				$src_rect_height = $height;
				if(!$forcefill)	{
					$src_rect_width = $width;
					$th_width = $th_height/$height*$width;
				}
			}
			else{
				$src_rect_height = $width/$a;
				$src_rect_width = $width;
				if(!$forcefill)	{
					$src_rect_height = $height;
					$th_height = $th_width/$width*$height;
				}
			}
			$src_rect_xoffset = ($width - $src_rect_width)/2*intval($forcefill);
			$src_rect_yoffset = ($height - $src_rect_height)/2*intval($forcefill);
			$thumb = imagecreatetruecolor($th_width, $th_height);
			imagecopyresampled($thumb, $source, 0, 0, $src_rect_xoffset, $src_rect_yoffset, $th_width, $th_height, $src_rect_width, $src_rect_height);
			imagejpeg($thumb,$destination);
		}
		else{
			if (!copy($filename,$destination)) die ("Cannot upload file.");
		}
	}
function creatLOG($ip) {
	if(!is_dir('log')) mkdir("log", 0777);
	$f = fopen('log/'.md5($ip).'.x', "w");
	fwrite($f, '');
	fclose($f);
	}
function getTOTAL() {
	$total = 0;
	$current_time = time();
	$timeout = 10*60;
	$list = scandir('log');
	foreach($list as $num => $file) {
	$file = 'log/'.$file;
	if(substr($file, strrpos($file, '.') + 1) == 'x') {
	$log_time = filemtime($file);
	if ($current_time - $log_time > $timeout)
	unlink($file);
	else $total++;
		}
	}
	return $total;
	}
function check_valid_email($email){
		   $exp = "^[a-z0-9]+([._-][a-z0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
		   if(eregi($exp, $email)){
			   return true;
		   }else{
			 return false;
		   }    
		}
function redirect( $url='', $time=0) {
			// Fix to handle cookieless sessions
			if (headers_sent() || $time > 0) {
				echo "<meta http-equiv=\"refresh\" content=\"$time;url=$url\">";
			} else {
				@ob_end_clean(); // clear output buffer
				header( "Location: ". $url );
			}
			exit();	// stop the PHP execution
		}
function arraySelect( $arr, $select_name, $select_attribs, $selected) {
			reset( $arr );
			$s = "\n<select name=\"$select_name\" $select_attribs>";
			foreach ($arr as $k => $v ) {
				$s .= "\n\t<option value=\"".$k."\"".($k == $selected ? " selected=\"selected\"" : '').">" .  $v  . "</option>";
			}
			$s .= "\n</select>\n";
			return $s;
		}
function download_files_listing(){
		$arr = array();
		$i = 0;
		if ($handle = opendir('../uploads/download')) {
			while (false !== ($file = readdir($handle))) {
				if(!is_dir($file)){
					if ($file != "." && 
						$file != ".." && 
						$file != ".htaccess" && 
						$file != "index.htm" && 
						$file != "index.html" &&
						$file != "default.htm" &&
						$file != "default.html" &&
						$file != "default.htm" &&
						$file != "default.php"){
						
						$arr[$i++] = $file;
					}
				}
			}
			closedir($handle);
		}
		return $arr;
	} 
function strimString($str,$num_word) {
				$iCount =0;
				$bFlag = false;
				for($i=0;$i<strlen($str);$i++) {
					if($str[$i]==" ")					
					 {$iCount++;}
					if($iCount==$num_word) 
					{
						$bFlag	= true;
						break;
					}
				}
				$cut=(($bFlag)?"...":"");
				return substr($str, 0, $i).$cut; 
			}
function strimStringA($str,$num_word) {
				$iCount =0;
				$bFlag = false;
				for($i=0;$i<strlen($str);$i++) {
					if($str[$i]==" ")					
					 {$iCount++;}
					if($iCount==$num_word) 
					{
						$bFlag	= true;
						break;
					}
				}
				$cut=(($bFlag)?",":"");
				return substr($str, 0, $i).$cut; 
			}
function check_admin_user(){
	global $login;
	if (session_is_registered("login"))
		return true;
	else
		return false;
	}
function check_customer_user(){
	if (session_is_registered("login_customer")&&$_SESSION["login_customer"]=="true")
		return true;
	else
		return false;
	}
function convert_font($field,$choice=1){
		$field = ($choice == 1 ? html_entity_decode(stripslashes(htmlentities(trim($field,ENT_QUOTES))),ENT_NOQUOTES) : html_entity_decode(htmlentities($field,ENT_QUOTES)));
		return $field;
	}
function check_in($fromtable,$checkname,$checkvalue){
		$sql = new db_sql();
		$sql->db_connect();
		$sql->db_select();
	   	$sql_query = "SELECT * FROM $fromtable WHERE $checkname = $checkvalue" ;
  	    $sql->query($sql_query);
    	if ( $sql->num_rows()>0 ){
			$sql->close();
	  		return 1;
		}else{
			$sql->close();
    	   	return 0;
		}
    }
function pages_browser($url,$position_page,$pages_number){
    global $lang, $_lang;
	echo "<ul>";
			echo "<li class='firsitem'>";
			echo "".$lang['page'].":  ";
			echo "</li>";
		for ($i=1; $i<=$pages_number; $i++)
		{ 
			if(($position_page >1 && $position_page==$i)||($position_page == 1 && $i==1))			
			echo "<li class='pagingselect'>".$position_page."</li>";			
			else
			{
				if($position_page!=$i)					
					echo "<li><a href='".$url.$i."' rel='nofollow'>".$i."</a></li>";
			}					
		}
	echo "</ul><br class='clear' /><br />";	
	}
function pages_browser_admin($url,$position_page,$pages_number){
        //global $lang, $_lang;
		//echo "".$lang['page']."";
		//echo " ";	
		if($position_page<=$pages_number && $position_page>1)
		{
			$p=$position_page-1;
			echo "<a href='".$url.$p."'>";
			echo "Tr&#7903; l&#7841;i" ;
			echo "</a> ";		
		}
		if($position_page > 6){			
			echo "<a href='".$url.'1'."' rel='nofollow' title ='Trang dau tien'>...</a> ";
			$first = $position_page - 5;
		}else $first = 1;
		$j=0;
		for ($i=$first; $i<=$pages_number; $i++)
		{ 
			if($j==12) break;
			$j=$j+1;
			if(($position_page >1 && $position_page==$i)||($position_page == 1 && $i==1))
				echo "<a class='active'>".$position_page."</a> ";			
			else
			{
				if($position_page!=$i)
					echo "<a href='".$url.$i."' rel='nofollow'>".$i."</a> ";
			}
		}
		if($pages_number > 12 && $position_page < ($pages_number - 6))
			echo "<a href='".$url.$pages_number."' rel='nofollow' title ='Trang cuoi cung'>...</a> ";		
		if($pages_number>1 && $position_page<$pages_number)
		{
			$p=$position_page+1;
			echo "<a href='".$url.$p."' rel='nofollow'>";
			echo "Ti&#7871;p theo";
			echo "</a>";		
		}	
	} //End Function 	
function cut_str($str,$len){
	if ($str=='' || $str==NULL) return $str;
	if (is_array($str)) return $str;
	$str = trim($str);
	if (strlen($str) <= $len) return $str;
	$str = substr($str,0,$len);
	if ($str != '') {
		if (!substr_count($str," ")) {
			return $str;
		}
		while(strlen($str) && ($str[strlen($str)-1] != " ")) $str = substr($str,0,-1);
		$str = substr($str,0,-1);
	}
    $str = $str." ...";
    return $str;
}	
function cut_space($str){
    $str = trim($str);
    $str = str_replace('  ',' ',$str);
	$str1 = strtolower($str);
	$str2 = str_replace(array('~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '+', '=', '{', '}', '[', ']', '|', ':', ';', '"', '<', '>', '.', '?', '/', ',', '//', '�', '�'), '-',($str));
	$str2 = str_replace(' ','-',$str2);
	$str3 = str_replace('--','-',$str2);
	$str4 = str_replace('__','_',$str3);
	return $str4;
}


function gia($price = 1){
    if($price == 1){
        return "Call";
    }else{
        return number_format($price).'&nbsp;vnđ';
    }
}

function giacu($gia = 0){
    if($gia == 0){ return ''; }else{ return gia($gia);}
}

	function catdau_admin($str) {
	$chars = array(
		'a'	=>	array('A','ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'e'     =>	array('E','ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'i'	=>	array('I','í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'o'	=>	array('O','ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
		'u'	=>	array('U','ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'y'	=>	array('Y','ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'd'	=>	array('D','đ','Đ'),
		'q'	=>	array('Q'),
		'w'	=>	array('W'),
		'r'	=>	array('R'),
		't'	=>	array('T'),
		'p'	=>	array('P'),
		's'	=>	array('S'),
		'f'	=>	array('F'),
		'g'	=>	array('G'),
		'h'	=>	array('H'),
		'j'	=>	array('J'),
		'k'	=>	array('K'),
		'l'	=>	array('L'),
		'z'	=>	array('Z'),
		'x'	=>	array('X'),
		'c'	=>	array('C'),
		'v'	=>	array('V'),
		'b'	=>	array('B'),
		'n'	=>	array('N'),
		'm'	=>	array('M'),
		''	=>	array('_'),
		'__'	=>	array('_'),
		"'"	=>	array('_'),
        '?' => array('_'),
	);
	foreach ($chars as $key => $arr)
		foreach ($arr as $val)
			$str = str_replace($val, $key, $str);
	return $str;
}

function name_ascii($str) {
                $chars = array(
		'a'	=>	array('A','ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'e'                      =>	array('E','ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'i'	=>	array('I','í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'o'	=>	array('O','ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
		'u'	=>	array('U','ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'y'	=>	array('Y','ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'd'	=>	array('D','đ','Đ'),
		'q'	=>	array('Q'),
		'w'	=>	array('W'),
		'r'	=>	array('R'),
		't'	=>	array('T'),
		'p'	=>	array('P'),
		's'	=>	array('S'),
		'f'	=>	array('F'),
		'g'	=>	array('G'),
		'h'	=>	array('H'),
		'j'	=>	array('J'),
		'k'	=>	array('K'),
		'l'	=>	array('L'),
		'z'	=>	array('Z'),
		'x'	=>	array('X'),
		'c'	=>	array('C'),
		'v'	=>	array('V'),
		'b'	=>	array('B'),
		'n'	=>	array('N'),
		'm'	=>	array('M'),
		''	=>	array('_'),
		'__'	=>	array('_'),
		"'"	=>	array('_'),
        '?' => array('_'),
	);
	foreach ($chars as $key => $arr)
		foreach ($arr as $val)
			$str = str_replace($val, $key, $str);
	return $str;
}

function huu($string, $allowUnder = false) {
    $string = name_ascii($string);  
    $regExpression = "`\W`i";
        if ($allowUnder)
        $regExpression = "`[^a-zA-Z0-9-]`i";
        $strings = preg_replace(array($regExpression, "`[-]+`",), "-", $string);
        return trim($strings);
    }
    
    function change_date123($date){
    $create_ct = getdate(strtotime($date));   
    return  $create_ct['mday'].'/'.$create_ct['mon'].'/'.$create_ct['year'];
}


function chang_title($chuoi){    
           $tieude = $chuoi;
            $tieude= strip_tags(strimString($tieude,5));
            $tieude = cut_space(name_ascii($tieude));
            $tieude = str_replace("--", "-", $tieude);
           $tieude = rtrim($tieude,"-");//loại bỏ ký tự  cuối chuỗi mặc định loại bỏ khoảng trắng
            return $tieude;
}


  function sentsmss($sdt,$noidung) {  
                    $wsdl = 'http://sms-gw1.apectech.vn:8081/axis/services/Mt_receicer?wsdl';
                    $client = new nusoap_client($wsdl, true);
                    $msg_id = ceil(rand(0, 1000));    
                    if($sdt ==""){
                            $msisdn= '0932235947';
                    }else{
                            $msisdn = $sdt;
                    }
                    $message = 'HoangGia '.$noidung;
                    $brandname = 'hoanggia';
                    $username = 'hoanggiacorp';
                    $password = 'reh7$8eh^e@92ye';
                    $sharekey = 'FJU445O9G94NFHH30CJ6H';
                    $hashkey = md5("{$msg_id}{$msisdn}{$message}{$brandname}{$username}{$password}{$sharekey}");
                    $params =array('msg_id'=>$msg_id,'msisdn'=>$msisdn,'message'=>$message,'brandname'=>$brandname,'username'=>$username,'password'=>$password,'hashkey'=>$hashkey);
                    $result = $client->call('sendTextMessage', $params);                 
    }

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
 
    return $ip;
}


   //------------------------ cac ham cho  service the --------------------------
                function generateRandomRequestID(){
                            $strFormat = 'YmdHis'; //bo u
                            $date = new DateTime();
                            $xxxx = "";
                            for ($i = 0; $i < 8; $i++){
                                    $xxxx .= rand(0, 9);
                            }
                            $requestID = $date->format($strFormat) . $xxxx;
                            return $requestID;
                }

                function deCrypt($encryptText,$key){
                        return decryptText($encryptText,$key);
                }
                
                function decryptText($encryptText,$key) {
                        $key = substr($key, 0, 24);
                        $iv = substr($key, 0, 8);
                        $keyData = "\xA2\x15\x37\x08\xCA\x62\xC1\xD2"
                                . "\xF7\xF1\x93\xDF\xD2\x15\x4F\x79\x06"
                                . "\x67\x7A\x82\x94\x16\x32\x95";
                        $cipherText = base64_decode($encryptText);
                        $res = mcrypt_decrypt("tripledes", $key, $cipherText, "cbc", $iv);
                        $resUnpadded = pkcs5_unpad($res);
                        return $resUnpadded;
                }
                function pkcs5_unpad($text)
                {
                        $pad = ord($text{strlen($text)-1});
                        if ($pad > strlen($text)) return false;
                        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
                        return substr($text, 0, -1 * $pad);
                }
                 




?>