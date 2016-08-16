<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){		
		die("<a href='../index.php'>Trang ch&#7911;</a>");
}
if($Auth["memberid"] < 1){
	header("Location: /login.html");
	exit;
}

$ms = array();
$sql = new db_sql();
$sql->db_connect();
$sql->db_select();
$select ="SELECT bank_number,bankid  FROM ".DB_PREFIX."user_bank  WHERE `userid`= $Auth[memberid] ";
$sql->query($select);
$i = 0;
while($r = $sql->fetch_array()){
    $i = $i+1;
      $ms[$i]["bankid"] = $r["bankid"];  
      $ms[$i]["maso"] = $r["bank_number"];  
}


function get_namebank($id){
    $name_bank = "";
    $sql = new db_sql();
    $sql->db_connect();
    $sql->db_select();
    $select = "SELECT `Title`  FROM `kien_bankinfo` WHERE `Published`= 1 and Id=$id limit 1";
    $sql->query($select);
    if($r = $sql->fetch_array()){
        $name_bank = $r["Title"];
    }
    
    return $name_bank;
}

function publish(){
    global $Auth,$ms;
    echo '<div class="left_box_slide naptien">
                	<div class="title"><h3>Tài khoản ngân hàng</h3><a href="'.WEB_DOMAIN.'/add-bank.html">Thêm mới</a></div>
                    <div class="content">
                    	<table border="1" cellpadding="10">
                        	<tbody>
                            	<tr class="tt">
                                	<td width="35%">Số điện thoại</td>
                                    <td>'.$Auth["user"].'</td>
                                </tr>
                                <tr class="tt">
                                	<td>Số CMTND</td>
                                    <td>'.$Auth["cmt"].'</td>
                                </tr>
                                <tr class="tt">
                                	<td>Email</td>
                                    <td>'.$Auth["email"].'  </td>
                                </tr>';
                                 if(!empty($ms)){
                                                echo ' <tr class="tieude">
                                	<td>Tên ngân hàng</td>
                                                      <td>Mã số tài khoản</td>
                                                        </tr>';                                 
                                                                    for($j= 1;$j<=count($ms);$j++){
                                                                         $id = $ms[$j]["bankid"];
                                                                                    echo '<tr>
                                                                                            <td>'.  get_namebank($id).'</td>
                                                                                        <td>'.$ms[$j]["maso"].'</td>
                                                                                    </tr>';
                                                                                    }
                                  }else{
                                                  echo ' <tr class="tieude">
                                	<td colspan="2">Bạn chưa có tài khoản ngân hàng nào</td>                                                 
                                                        </tr>'; 
                                  }
                         
                            echo '</tbody>
                        </table>
                    </div>
                </div><!--left_box-->';
}


?>