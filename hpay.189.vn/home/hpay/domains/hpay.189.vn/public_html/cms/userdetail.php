<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
        $intro = array();
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}	
	$select_query = "SELECT tmpname, logon, logout FROM ".DB_PREFIX."users ORDER BY fullname";
	$sql->query($select_query);	
        $i =0;
        while ($r = $sql->fetch_array()){
                    $i = $i+1;
                    $intro[$i]["tmpname"] = $r["tmpname"];
                      $intro[$i]["logon"] = $r["logon"];
                        $intro[$i]["logout"] = $r["logout"];
        }
?>

<?php include("lib/header.php")?>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=user>">Quản trị</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Lịch sử</h1>
    </div>

    <div class="content">
         <? if($n>0){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">Full Name</td>
              <td class="left">Logon</td>
              <td class="right">Logout</td>
            </tr>
          </thead>
          <tbody>
              <?php            
               for($j=1;$j<=count($intro);$j++){
			$from 		= $from + 1;			
			$tmpname                                   =$intro[$j]['tmpname'];			
			$logon	 	= $intro[$j][logon]!=0 ? gmdate("d/m/Y, h:i, a",$intro[$j]["logon"] + 7*3600) : '';
			$logout	 	= $intro[$j][logout]!=0 ? gmdate("d/m/Y, h:i, a",$intro[$j]["logout"] + 7*3600) : '';
			
		?>
            <tr>
              <td class="left"><?= $from ?></td>
              <td class="left"><strong><?= $tmpname ?></strong></td>
              <td class="left"><?= $logon ?></td>
              <td class="right"><?=$logout?> </td>
            </tr>
            <?php 
            } $sql->close();
            ?>

        </tbody>
        
        </table>
        <?php pages_browser_admin("index.php?pages=user&mode=detail&amp;position_page=",$position_page,$pages_number);?>
        <? }else echo "<br><div align=center>Chưa có user nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>


