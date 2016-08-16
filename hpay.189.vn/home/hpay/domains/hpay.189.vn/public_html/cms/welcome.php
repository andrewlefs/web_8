<?php
if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
        if(session_is_registered('countadd'))
            {
              $HTTP_SESSION_VARS['countadd']=0;
            }
            $title 	= "Bảng điều khiển";
?>

<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function open_window(id){
			window.open("index.php?pages=contact&mode=detail&id=" +id ,"","width=650,height=400,left=0,top=0,scrollbars=yes");
	}
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/" tiele="Ra trang chủ">Trang chủ</a>
      </div>
              <div class="box">
    <div class="heading">
      <h1><img src="images/home.png" alt="" />Bảng điều khiển</h1>
    </div>
    <div class="content">
      <div class="overview">
        <div class="dashboard-heading">Tổng quan</div>
        <div class="dashboard-content">
          <table>
            <tr>
              <td>Tổng số sản phẩm:</td>
              <td><?=$count_product?> </td>
            </tr>
            <tr>
              <td>Tổng số bản tin:</td>
              <td><?=$count_new?></td>
            </tr>
            <tr>
              <td>Lượt truy cập:</td>
              <td><?=$counter?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="statistic">
        <div class="range">Hôm nay:<?php $gio= date("d/ m / Y / h:i A"); echo $gio; ?>
        </div>
        <div class="dashboard-heading">Báo cáo chung</div>
        <div class="dashboard-content">
          <div id="report" style="width: 390px; height: 160px; margin: auto;"></div>
        </div>
      </div>
        <?php 
        $sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();		
	$select_query = "SELECT contactid, email, title, titlec,  senddate FROM contact ORDER BY senddate DESC LIMIT 10";
	$sql->query($select_query);
	$n = $sql->num_rows();
        ?>
      <div class="latest">
        <div class="dashboard-heading">Có <?=$n?> liên hệ hoặc góp ý của khách hàng</div>
        <div class="dashboard-content">
          <table class="list">
            <thead>
              <tr>
                <td class="right">Số TT</td>
                <td class="left">Tiêu đề</td>
                <td class="left">Email</td>
                <td class="left">Ngày gửi</td>
                <td class="right">Action</td>
              </tr>
            </thead>
            <? if($n>0){ ?>
            <tbody>
                <?php
                        for($i=1; $i<$n+1; $i++){
			$from = $from + 1;		
			$row = $sql->fetch_array();
			$contactid  = 	$row['contactid'];
			$title      =	$row['titlec'];
                        $email      =	$row['email'];
			$senddate = gmdate("d/m/Y, h:i, a",$row["senddate"] + 7*3600);			
                    ?>
                <tr>
                    <td class="right"><?= $from ?></td>
                    <td class="left"> <?= $title ?></td>
                    <td class="left"><?= $email?></td>
                    <td class="left"><?= $senddate ?></td>
                    <td class="right">[ <a class="openl" onClick="open_window(<?=$contactid?>)">Chi tiết</a> ]</td>
                </tr>
                <?php 

		} 
		?>

            </tbody>
            <?
            }else echo"<br><div align=center>&nbsp;&nbsp;Chưa có thư liên hệ hoặc góp ý nào trong CSDL !</div>";
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>