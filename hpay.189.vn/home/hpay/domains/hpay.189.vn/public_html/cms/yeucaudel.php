<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
        
                           $sql = new db_sql();
                           $sql->db_connect();
                           $sql->db_select();
                          $msg = "";
	if ($_GET["mode"]=="del" && $_GET["pages"]="yeucau")
	{                    
                                                  if($_GET["act"]=="upd") {
                                                                         
                                                                            $id = $_GET["id"];                                                                           
                                                                            $method = $_GET["method"];
                                                                            $memberid_request = $_GET["memberid"];
                                                                            
                                                                            // thực hiện đối với từng phương thức yêu cầu của khách
                                                                            switch ($method){
                                                                                case "addbank":
                                                                                     // select số tiền hiện có của user đã gửi yêu cầu
                                                                                    $select_gold = "SELECT `Gold` FROM ".DB_PREFIX."member WHERE  memberid='".$memberid_request."' and Published='1' ";
                                                                                    $sql->query($select_gold);
                                                                                    if($r = $sql->fetch_array()){
                                                                                                $gold = $r["Gold"];
                                                                                    }
                                                                                    
                                                                                    $select_money = "SELECT `number_money`  FROM ".DB_PREFIX."history_addmoney_bank WHERE `id_request` = $id";
                                                                                    $sql->query($select_money);
                                                                                    if($r = $sql->fetch_array()){
                                                                                        $mn = $r["number_money"];
                                                                                        $gold += $mn;
                                                                                        $update_mn = "update ".DB_PREFIX."member set Gold=$gold where memberid=$memberid_request";
                                                                                        $sql->query($update_mn);                                                                                      
                                                                                    }
                                                                                    break;  
                                                                                    
                                                                                case "naptien":
                                                                                                    // select số tiền hiện có của user đã gửi yêu cầu
                                                                                                   $select_gold = "SELECT `Gold` FROM ".DB_PREFIX."member WHERE  memberid='".$memberid_request."' and Published='1' ";
                                                                                                   $sql->query($select_gold);
                                                                                                   if($r = $sql->fetch_array()){
                                                                                                               $gold = $r["Gold"];
                                                                                                   }

                                                                                                   $select_money = "SELECT `money` FROM ".DB_PREFIX."history_request WHERE `request_id`=$id";
                                                                                                   $sql->query($select_money);
                                                                                                   if($r = $sql->fetch_array()){
                                                                                                       $mn = $r["money"];
                                                                                                       $gold += $mn;
                                                                                                       $update_mn = "update ".DB_PREFIX."member set Gold=$gold where memberid=$memberid_request";
                                                                                                       $sql->query($update_mn);                                                                                       
                                                                                                   }
                                                                                                   break;
                                                                                    
                                                                                    
                                                                                case "ruttien":
                                                                                                // select số tiền hiện có của user đã gửi yêu cầu
                                                                                               $select_gold = "SELECT `Gold` FROM ".DB_PREFIX."member WHERE  memberid='".$memberid_request."' and Published='1' ";
                                                                                               $sql->query($select_gold);
                                                                                               if($r = $sql->fetch_array()){
                                                                                                           $gold = $r["Gold"];
                                                                                               }
                                                                                    
                                                                                    
                                                                                                $select_money = "SELECT `money` FROM ".DB_PREFIX."history_request WHERE `request_id`=$id";
                                                                                                $sql->query($select_money);
                                                                                               if($r = $sql->fetch_array()){
                                                                                                   $mn = $r["money"];
                                                                                                   if($gold > 0 && $gold > $mn && $mn > 0){
                                                                                                           $gold -= $mn;
                                                                                                           $update_mn = "update ".DB_PREFIX."member set Gold=$gold where memberid=$memberid_request";
                                                                                                           $sql->query($update_mn);       
                                                                                                   }  else if($gold < $mn){
                                                                                                            $msg = "Số tiền rút phải nhỏ hơn số dư  khả dụng";
                                                                                                   }  else if($mn < 0){
                                                                                                            $msg = "Số tiền rút phải lớn hơn 0";
                                                                                                   }

                                                                                               }
                                                                                               break;
                                                                                 case "sendmoney":
                                                                                                  // select số tiền hiện có của user đã gửi yêu cầu
                                                                                               $select_gold = "SELECT `Gold` FROM ".DB_PREFIX."member WHERE  memberid='".$memberid_request."' and Published='1' ";
                                                                                               $sql->query($select_gold);
                                                                                               if($r = $sql->fetch_array()){
                                                                                                           $gold = $r["Gold"];
                                                                                               }
                                                                                               $select_money = "SELECT `money`,`tranto` FROM ".DB_PREFIX."history_tranfer  WHERE `request_id`=$id";                                                                                       
                                                                                               $sql->query($select_money);
                                                                                               if($r = $sql->fetch_array()){
                                                                                                                $mn = $r["money"];
                                                                                                                $tranto = $r["tranto"];
                                                                                                                // kiểm tra số dư khả dụng của người chuyển
                                                                                                                if($gold > 0 && $gold > $mn && $mn > 0){
                                                                                                                                // trừ tiền trong tài khoản của người chuyển                                                                                                                                 
                                                                                                                                $gold -= $mn;
                                                                                                                                $update_mn = "update ".DB_PREFIX."member set Gold=$gold where memberid='".$memberid_request."' ";
                                                                                                                                if($sql->query($update_mn)){
                                                                                                                                                // cộng tiền vào tài khoản muốn chuyển
                                                                                                                                                $select_gold = "SELECT `Gold` FROM `kien_member` WHERE  user='".$tranto."' and Published='1' ";
                                                                                                                                                $sql->query($select_gold);
                                                                                                                                                if($r = $sql->fetch_array()){
                                                                                                                                                        $goldTo = $r["Gold"];
                                                                                                                                                }
                                                                                                                                                $goldTo += $mn;
                                                                                                                                                $update_mn = "update ".DB_PREFIX."member set Gold='".$goldTo."'  where user='".$tranto."' ";
                                                                                                                                                $sql->query($update_mn);
                                                                                                                                }
                                                                                                                }else if($gold < $mn){
                                                                                                                                $msg = "Số tiền muốn chuyển phải nhỏ hơn số dư khả dụng";
                                                                                                                }else if($mn < 0){
                                                                                                                                $msg = "Số tiền muốn chuyển phải lớn hơn 0";
                                                                                                                }
                                                                                             }
                                                                                    break;
                                                                            }
                                                                            
                                                                            if($msg ==""){
                                                                                       $update_query = "UPDATE ".DB_PREFIX."list_request  SET publish='1' WHERE id = '$id'";
                                                                                       $sql->query($update_query);
                                                                                       $sql->close();
                                                                                       header("Location: index.php?pages=yeucau&mode=detail&id=".$id);
                                                                                       exit();
                                                                            }else{
                                                                                       echo '<script>alert("'.$msg.'");</script>';
                                                                                       
                                                                            }
                                                 }
	}
	
		
	
?>
