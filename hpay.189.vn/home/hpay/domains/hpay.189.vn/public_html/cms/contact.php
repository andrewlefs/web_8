<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
        $contacta = array();
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();		
	$position_page = isset($_GET["position_page"]) && is_numeric($_GET["position_page"])  ? $HTTP_GET_VARS["position_page"]:1;
	$position_page = isset($_POST["position_page"]) ? $_POST["position_page"] : $position_page; 
	$from = $position_page ==1 ? 0 : (($new_per_pagead*$position_page)- $new_per_pagead);
	$count_rows = $sql->count_rows(DB_PREFIX."contact");
	$pages_number = ceil($count_rows/$new_per_pagead);
	
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
	$select_query = "SELECT `contactid`, `name`, `senddate`  FROM ".DB_PREFIX."contact ORDER BY senddate DESC LIMIT $from, $new_per_pagead";
	$sql->query($select_query);
	$n = $sql->num_rows();	
                          $i = 0;
                          while ($r = $sql->fetch_array()){
                              $i = $i + 1;
                              $contacta[$i]["contactid"] = $r["contactid"];
                               $contacta[$i]["name"] = $r["name"];
                                $contacta[$i]["senddate"] = $r["senddate"];
                          }
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delContact(id) {
		if (confirm("Are you sure ?" )) {
			window.location.replace("index.php?pages=contact&mode=del&id=" + id);			
		}
	}
	function open_window(id){
			window.open("index.php?pages=contact&mode=detail&id=" +id ,"","width=700,height=500,left=0,top=0,scrollbars=yes");
	}
</script>

<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=contact">Quản lý liên hệ</a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Liên hệ (<?=$count_rows?>) </h1>
      <div class="buttons"></div>
    </div>

    <div class="content">
        <? if($count_rows>0){ ?>
        <table class="list">
          <thead>
            <tr>
              <td class="tt">Order</td>
              <td class="left">Category Name</td>
              <td class="center">Send Date</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
            <?php
                for($j=1; $j<=count($contacta); $j++){
			$from = $from + 1;		
			$contactid 	= 	$contacta[$j]['contactid'];
			$name		=	$contacta[$j]['name'];
			$senddate = change_date123($contacta[$j]["senddate"]);			
		?>
            <tr>
              <td class="tt"><?= $from ?></td>
              <td class="left"><a title="Information detail" style="CURSOR: hand" onClick="open_window(<?=$contactid?>)"><?= $name ?></a></td>
              <td class="center"><?= $senddate ?></td>
              <td class="right"><a style="CURSOR: hand" onClick="delContact(<?=$contactid ?>)"><img height="13" alt="Delete" src="images/del_button.gif" width="36" border="0"></a></td>
            </tr>
           <?php 
		} $sql->close();
		?>

        </tbody>
        </table>
        <table width="98%">
        <tr>
       <td class="header_table" bgColor="whitesmoke"><?php pages_browser_admin("index.php?pages=contact&position_page=",$position_page,$pages_number);?></td>
      </tr>
      </table>
        <? }else echo "<br><div align=center>Chưa có liên hệ nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>