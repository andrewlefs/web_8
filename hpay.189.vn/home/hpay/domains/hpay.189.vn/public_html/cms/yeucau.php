<?php

	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
                             session_start();
                             
	$module_name = 'Danh sách yêu cầu';
	if(session_is_registered('countadd')) //get number record input in databases
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
     
                            $method_request = isset($_GET["method"]) ? $_GET["method"] : $_POST["method"]; // mã yêu cầu   
                            $tukhoa = isset($_GET["tu_khoa"])?$_GET["tu_khoa"]:"";
                            $sql = new db_sql();
                            $sql->db_connect();
                            $sql->db_select();                                                     
                            
                            $select = "SELECT mb.`memberid` as memberid, mb.`user` as user, mb.`fullname` as fullname, mb.`email` as email,
                                                        lrq.`id` as request_id, lrq.`method` as request_method, lrq.`createdate` as request_createdate
                                                        FROM ".DB_PREFIX."member as mb 
                                                        INNER JOIN ".DB_PREFIX."list_request lrq ON lrq.user_id = mb.memberid where  mb.`fullname` like '%$tukhoa%' and lrq.method!='buycard' ";
                            if($method_request !="")
                                $select .= " and  lrq.`method`  = '".$method_request."' ";                           
                            
                            $sql->query($select);
                            $n = $sql->num_rows();
                            
                            $rows_per_page_of_product = is_numeric($rows_per_page_of_product) && $rows_per_page_of_product>0 ? $rows_per_page_of_product : 1;
                            $position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $_GET["position_page"]:1; 
                            $position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page ;	
                            $count_rows = $n;
                            $pages_number = ceil($count_rows/$rows_per_page_of_product);
                            $position_page = ($position_page > $pages_number) ? 1 : $position_page;
                            $from = $position_page ==1 ? 0 : (($rows_per_page_of_product*$position_page)- $rows_per_page_of_product);
                         
                            $tv = "SELECT mb.`memberid` as memberid, mb.`user` as user, mb.`fullname` as fullname, mb.`email` as email,
                                                        lrq.`id` as request_id, lrq.`method` as request_method, lrq.`createdate` as request_createdate,  lrq.`publish` as request_publish
                                                        FROM ".DB_PREFIX."member as mb 
                                                        INNER JOIN ".DB_PREFIX."list_request lrq ON lrq.user_id = mb.memberid where  mb.`fullname` like '%$tukhoa%' and  lrq.method!='buycard' " ;
                             if($method_request !="")
                                $tv .= " and  lrq.`method` = '".$method_request."' "; 
                             
                             $tv .= " order by lrq.`createdate` desc,lrq.`method` limit $from, $rows_per_page_of_product";
                             
                            $sql->query($tv);
                            $k = 0;
                            $tem_arr = array();
                            while($r = $sql->fetch_array()){
                                            $k = $k+1;
                                            $tem_arr[$k]["memberid"]                = $r["memberid"];
                                            $tem_arr[$k]["user"]                         = $r["user"];
                                            $tem_arr[$k]["fullname"]                  = $r["fullname"];
                                            $tem_arr[$k]["email"]                        = $r["email"];
                                            $tem_arr[$k]["request_id"]              = $r["request_id"];
                                            $tem_arr[$k]["request_method"]    = $r["request_method"];
                                            $tem_arr[$k]["request_createdate"] = $r["request_createdate"];
                                            $tem_arr[$k]["request_publish"]     = $r["request_publish"];
                            }
                                                
?>
<?php include("lib/header.php")?>
                    <script language="JavaScript" type="text/javascript">
                              function open_window(id){
                                            window.open("index.php?pages=yeucau&mode=detail&id=" +id ,"","width=700,height=500,left=0,top=0,scrollbars=yes");
                            }
                    </script>

                    <div id="content">
                                        <div class="breadcrumb">
                                                        <a href="/">Home</a> :: <a href="index.php?pages=<?= $pages ?>"><?= $module_name ?></a>
                                       </div>
                    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
                                       <div class="box">
                                                            <div class="heading">
                                                                <h1><img src="images/category.png" alt="" />Có (<?=  count($tem_arr)?>) yêu cầu</h1> 
                                                                                 <!--   <div class="buttons"><a onclick="location = 'index.php?pages=<?= $pages ?>&cat=<?=$catid?>&mode=add'" class="button">Thêm</a></div>-->
                                                            </div>
                                                            <div class="content">
                                                                                    <div style="float: left">                                      
                                                                                                    <form action="index.php?pages=yeucau" method="post"  enctype="multipart/form-data"  class="header_table">
                                                                                                                        <select name="method" id="method"  onchange="document.location='index.php?pages=yeucau&method=' + document.getElementById('method').value ">
                                                                                                                                        <option value="" <?=$method_request==""?"selected":""?>>Danh sách phương thức</option>
                                                                                                                                        <option value="naptien" <?=$method_request=="naptien"?"selected":""?>>Nạp tiền trực tiếp tại đại lý</option>
                                                                                                                                        <option value="addcard" <?=$method_request=="addcard"?"selected":""?>>Nạp tiền sử dụng thẻ điện thoại</option>
                                                                                                                                        <option value="addbank" <?=$method_request=="addbank"?"selected":""?>>Nạp tiền sử dụng internet banking</option>
                                                                                                                                        <option value="sendmoney" <?=$method_request=="sendmoney"?"selected":""?>>Chuyển khoản</option>
                                                                                                                                        <option value="ruttien" <?=$method_request=="ruttien"?"selected":""?>>Rút tiền  trực tiếp tại đại lý</option>
                                                                                                                        </select>
                                                                                                                        <input  name="method" type="hidden" id="method" value="<?=$method_request?>">      
                                                                                                     </form>
                                                                                            </div>
                                                                                                
                                                                                            <div style="float: right">                                                                                                           
                                                                                                            <form action="index.php?pages=yeucau" method="post"  enctype="multipart/form-data" >  
                                                                                                                                <input style="width:250px"  id="tu_khoa" value="Từ khóa tìm kiếm" name="tu_khoa" onfocus="if (this.value=='Từ khóa tìm kiếm'){this.value=''};this.style.backgroundColor='#fffde8';" onblur="this.style.backgroundColor='#ffffff';if (this.value==''){this.value='Từ khóa tìm kiếm'}" />
                                                                                                                                <a class="kien"  href="javascript:;" onclick="document.location='index.php?pages=yeucau&method=' + document.getElementById('method').value+'&tu_khoa='+ document.getElementById('tu_khoa').value">Tìm kiếm</a>                                                                                                                                      
                                                                                                            </form>
                                                                                             </div>
                              
                                                                                            <? if(!empty($tem_arr)){ ?>
                                                                                                                <table class="list">
                                                                                                                            <thead>
                                                                                                                                            <tr>
                                                                                                                                                        <td class="tt">Order</td>
                                                                                                                                                        <td class="left">Tên thành viên</td>
                                                                                                                                                        <td class="left">Số điện thoại</td>
                                                                                                                                                        <td class="left">Email</td>
                                                                                                                                                        <td class="left">Phương thức</td>
                                                                                                                                                        <td class="left">Ngày yêu cầu</td>
                                                                                                                                                        <td class="left">Tình trạng</td>
                                                                                                                                                        <td class="right">Xem</td>
                                                                                                                                            </tr>
                                                                                                                            </thead>
                                                                                                                            <tbody>
                                                                                                                                            <?php
                                                                                                                                              for($i=1; $i<=count($tem_arr); $i++)
                                                                                                                                              {
                                                                                                                                                      $from                           = $from + 1;                                                                                                                                                   
                                                                                                                                                      $memberid	= $tem_arr[$i]['memberid'];
                                                                                                                                                      $fullname 	= $tem_arr[$i]['fullname'];
                                                                                                                                                      $request_method 	= $tem_arr[$i]['request_method'];
                                                                                                                                                      $email 	= $tem_arr[$i]['email'];
                                                                                                                                                      $user 	= $tem_arr[$i]['user'];
                                                                                                                                                      $request_id               = $tem_arr[$i]['request_id'];
                                                                                                                                                      $change                      = $tem_arr[$i]['request_publish']==0?1:0;
                                                                                                                                                      $publish                     = $tem_arr[$i]["request_publish"];
                                                                                                                                                       $ngaydang 	= change_date123($tem_arr[$i]["request_createdate"]);
                                                                                                                                                       
                                                                                                                                                       if($request_method=="add_money_banking")
                                                                                                                                                           $name_pt = "Nạp tiền qua internet banking";
                                                                                                                                                       else if($request_method=="sendmoney")
                                                                                                                                                           $name_pt = "Chuyển khoản";
                                                                                                                                                       else if($request_method=="ruttien")
                                                                                                                                                               $name_pt = "Rút tiền tại đại lý";
                                                                                                                                                       else if($request_method=="naptien")
                                                                                                                                                              $name_pt = "Nạp tiền tại đại lý";                                                                                                                                                       
                                                                                                                                              ?>
                                                                                                                              <tr>
                                                                                                                                                <td class="tt"><?= $from ?></td>
                                                                                                                                                <td class="left"> <?= $fullname ?></td>
                                                                                                                                                <td class="left"><?= $user ?></td>
                                                                                                                                                <td class="left"><?= $email ?></td>
                                                                                                                                                <td class="left"><?=  $name_pt?></td>
                                                                                                                                                <td class="left"><?= $ngaydang ?></td>
                                                                                                                                                <td class="left"><?= ($publish == 1 ? "Đã xử lý" : 'Chưa xử lý') ?> </td>
                                                                                                                                                <td class="right">
                                                                                                                                                    <a title="Information detail" style="CURSOR: hand" onClick="open_window(<?=$request_id ?>)">
                                                                                                                                                        <img   src="images/monitor.png" >
                                                                                                                                                    </a> 
                                                                                                                                                </td>
                                                                                                                              </tr>
                                                                                                                                                <?php 
                                                                                                                                                   }
                                                                                                                                                   $sql->close();
                                                                                                                                                 ?>
                                                                                                                          </tbody>
                                                                                                                </table>
                                                                                            <?php pages_browser_admin("index.php?pages=yeucau&position_page=",$position_page,$pages_number);?>
                                                                                            <? }else echo "<br><div align=center>Chưa có yêu cầu nào trong CSDL !</div>";?>
                                                                        </div>
                                                </div>
                        </div>
</div>
                <?php include("lib/footer.php")?>
</body>
</html>