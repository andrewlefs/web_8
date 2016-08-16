<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
                          $module_name = 'Quản trị';
                          $u = array();
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	if($HTTP_SESSION_VARS["super"]==0)
		$select_query = "SELECT user, fullname FROM ".DB_PREFIX."users WHERE user ='$HTTP_SESSION_VARS[user_admin]'";
	else
		if($HTTP_SESSION_VARS["super"]==1)
			$select_query = "SELECT user, fullname, superuser FROM  ".DB_PREFIX."users ORDER BY fullname";
	$sql->query($select_query);
                           $i = 0;
                           while ($t = $sql->fetch_array()){
                                            $i = $i+1;
                                            $u[$i]["user"] = $t["user"];
                                            $u[$i]["fullname"] = $t["fullname"];
                                            $u[$i]["superuser"] = $t["superuser"];
                           }
	$n = $sql->num_rows();					
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
<!--
	function delUser(id) {
		if (confirm("Are you sure ?" )) {
			window.location.replace("index.php?pages=user&mode=del&id=" + id);			
		}
	}
-->
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=<?= $pages ?>"><?= $module_name ?></a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /><?= $module_name ?> (<?=$n?>) </h1>
      <div class="buttons"> 
          <?=$detail = $HTTP_SESSION_VARS["super"]==1 ? "<a href='index.php?pages=user&mode=add' class='button'>Add User</a>   <a href='index.php?pages=user' class='button'>Manager User</a>  <a href='index.php?pages=user&mode=detail' class='button'>History</a> " : ''?>
          
      </div>
    </div>

    <div class="content">
         <? if($n>0){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">User Name</td>
              <td class="left">Full Name</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
               for($j=1;$j<=count($u);$j++){
			$from 		= $from + 1;			
			$user 		= $u[$j]['user'];			
			$fullname 	= $u[$j]['fullname'];	
			$superuser 	= $u[$j]['superuser'];
			if($superuser == 1 && $HTTP_SESSION_VARS['super'] == 1)
				$fullname   = $fullname."&nbsp;(<font color=#ff0000>Super User</font>)";
		?>
            <tr>
              <td class="left"><?= $from ?></td>
              <td class="left"><strong><?= $user ?></strong></td>
              <td class="left"><?= $fullname ?></td>
              <td class="right">[ <a style="CURSOR: hand" href="index.php?pages=user&mode=edit&id=<?=$user?>">Sửa</a> ]
                                [ <a style="CURSOR: hand" onClick="delUser('<?=$user?>')">Xóa</a> ]
                </td>
            </tr>
            <?php 
            } $sql->close();
            ?>

        </tbody>
        
        </table>
        <?php pages_browser_admin("index.php?pages=<?= $pages ?>&amp;position_page=",$position_page,$pages_number);?>
        <? }else echo "<br><div align=center>Chưa có nhà sản xuất nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>