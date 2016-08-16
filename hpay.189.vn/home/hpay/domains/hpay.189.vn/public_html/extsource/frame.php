<?php
include('alexa.php');

if(isset($_POST['exinput']))
{
    preg_match_all('/[-\w^.]*\.(com|net|org|info|co|us|vn)/si',$_POST['exinput'],$rs);
    function StrToNum($Str, $Check, $Magic) {
            $Int32Unit = 4294967296;  // 2^32
        
            $length = strlen($Str);
            for ($i = 0; $i < $length; $i++) {
                $Check *= $Magic; 	
                if ($Check >= $Int32Unit) {
                    $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
                    //if the check less than -2^31
                    $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
                }
                $Check += ord($Str{$i}); 
            }
            return $Check;
        }
        
        //genearate a hash for a url
        function HashURL($String) {
            $Check1 = StrToNum($String, 0x1505, 0x21);
            $Check2 = StrToNum($String, 0, 0x1003F);
        
            $Check1 >>= 2; 	
            $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
            $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
            $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);	
        	
            $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
            $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
        	
            return ($T1 | $T2);
        }
        
        function CheckHash($Hashnum) {
            $CheckByte = 0;
            $Flag = 0;
        
            $HashStr = sprintf('%u', $Hashnum) ;
            $length = strlen($HashStr);
        	
            for ($i = $length - 1;  $i >= 0;  $i --) {
                $Re = $HashStr{$i};
                if (1 === ($Flag % 2)) {              
                    $Re += $Re;     
                    $Re = (int)($Re / 10) + ($Re % 10);
                }
                $CheckByte += $Re;
                $Flag ++;	
            }
        
            $CheckByte %= 10;
            if (0 !== $CheckByte) {
                $CheckByte = 10 - $CheckByte;
                if (1 === ($Flag % 2) ) {
                    if (1 === ($CheckByte % 2)) {
                        $CheckByte += 9;
                    }
                    $CheckByte >>= 1;
                }
            }
        
            return '7'.$CheckByte.$HashStr;
        }
        
        function getch($url) { return CheckHash(HashURL($url)); }
        
        function getpr($url) 
        {
        	global $googlehost,$googleua;
        	$ch = getch($url);
            	$fp = fsockopen($googlehost, 80, $errno, $errstr, 30);
        	if ($fp) {
        	   $out = "GET /tbr?client=navclient-auto&ch=$ch&features=Rank&q=info:$url HTTP/1.1\r\n";
        	   //echo "<pre>$out</pre>\n"; //debug only
        	   $out .= "User-Agent: $googleua\r\n";
        	   $out .= "Host: $googlehost\r\n";
        	   $out .= "Connection: Close\r\n\r\n";
        	
        	   fwrite($fp, $out);
        	   
        	   //$pagerank = substr(fgets($fp, 128), 4); //debug only
        	   //echo $pagerank; //debug only
        	   while (!feof($fp)) {
        			$data = fgets($fp, 128);
        			//echo $data;
        			$pos = strpos($data, "Rank_");
        			if($pos === false){} else{
        				$pr=substr($data, $pos + 9);
        				$pr=trim($pr);
        				$pr=str_replace("\n",'',$pr);
        				return $pr;
        			}
        	   }
        	   //else { echo "$errstr ($errno)<br />\n"; } //debug only
        	   fclose($fp);
        	}
        }
        
        //generate the graphical pagerank
        function pagerank($url,$width=100,$method='image') 
        {
        	if (!preg_match('/^(http:\/\/)?([^\/]+)/i', $url)) { $url='http://'.$url; }
        	$pr=getpr($url);
        	$pagerank="PageRank: $pr/10";
        
        	//The (old) image method
        	if ($method == 'image') {
        	$prpos=$width*$pr/10;
        	$prneg=$width-$prpos;
        	$html='<img src="pos.jpg" width='.$prpos.' height=15px border=0 alt="'.$pagerank.'"><img src="neg.jpg" width='.$prneg.' height=15px border=0 alt="'.$pagerank.'">';
        	}
        	//The pre-styled method
        	if ($method == 'style') {
        	$prpercent=100*$pr/10;
        	$html='<div style="position: relative; width: '.$width.'px; padding: 0; background: #D9D9D9;"><strong style="width: '.$prpercent.'%; display: block; position: relative; background: #5EAA5E; text-align: center; color: #333; height: 10px; line-height: 10px;"><span></span></strong></div>';
        	}
            
            
            if($pr=='')
            {
                $out= '<font color=red><b>Unrank</b></font>';
            }
            else
            {
        	 $out="<b>Page Rank:</b>(<font color=red><b>$pr<b></font>/10)";
        	}
        	return $out;
        }
    $dem=0;$list_domain=array();ob_start();
    
    foreach($rs[0] as $value)
    {
            ob_end_flush();
    
            ob_flush();
            
            flush();
            
            ob_start();
            $dem++;
            echo '<script type="text/javascript">
                var t1 = document.getElementById("status");
                t1.innerHTML="Đã kiểm tra:'.$dem.' liên kết:'.$value .'...";
                </script>
                ';

        
        $url='http://'.$value;
        $_POST['link']=$url;
        if(isset($_POST['link']))
        {
          
        error_reporting(0);   
        $_POST['url']=$_POST['link'];
            $url3 = strtolower($_POST['url']);
        
        $num = strtolower($_POST['url']);
        if ($pos === false) {
            $num1="http://".$num;
            $url = parse_url($num1); 
            } else {
           $url = parse_url($num1); 
        } 
        $googlehost='toolbarqueries.google.com';
        $googleua='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.6) Gecko/20060728 Firefox/1.5';
        
        //convert a string to a 32-bit integer
        
        $list_domain[]=$_POST['url'];
        $list_pr[]=pagerank($_POST['link']);
        $list_stt = $list_stt + 1;
        $pagerank[]=$_POST['url'].' - '.pagerank($_POST['link']);
        $alexarank[] =get_alexa($_POST['url']);
        $lienkett[] =$_POST['url'];
        }
    }
   
}
// print_r($list_domain);
?>

<?php
if(isset($list_domain))
{ 
?>
<table class="list">
          <thead>
            <tr>
              <td class="tt" width="10%">Order</td>
              <td class="left" width="30%">Domain</td>
              <td class="left" width="30%">PageRank</td>
              <td class="left" width="30%">Alexa</td>
            </tr>
          </thead>
          <tbody>
            <?php
            $tt=0;
                foreach($list_domain as $key=>$tenmien)  {
                $tt = $tt+1 ;
                    ?>
            <tr>
              <td class="tt" width="10%"><?=$tt ?></td>
              <td class="left" width="30%"><?=$tenmien?></td>
              <td class="left" width="30%"><?=$list_pr[$key]?></td>
              <td class="left" width="30%"><?=$alexarank[$key] ?></td>
            </tr>
            <?php 
            } 
            ?>

        </tbody>
</table>
<?php
}
?>