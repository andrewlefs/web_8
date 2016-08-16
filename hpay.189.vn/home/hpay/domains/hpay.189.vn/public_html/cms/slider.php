<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	if(session_is_registered('countadd'))
	{
		$HTTP_SESSION_VARS['countadd']=0;
	}
                           $slider123 = array(); 
	$select_query = "SELECT `id_slider`, `logo`, `link`, `list_order`, `publish`, `content` FROM ".DB_PREFIX."slider  ORDER BY  list_order ";
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();	
	$sql->query($select_query);
                            $i =0;
                            while ($r = $sql->fetch_array()){
                                $i = $i+1;
                                $slider123[$i]["id_slider"] = $r["id_slider"];
                                $slider123[$i]["logo"] = $r["logo"];
                                $slider123[$i]["link"] = $r["link"];
                                $slider123[$i]["list_order"] = $r["list_order"];
                                $slider123[$i]["publish"] = $r["publish"];
                                $slider123[$i]["content"] = $r["content"];
                            }
	$n = $sql->num_rows();
			
?>
<?php include("lib/header.php")?>
<script language="JavaScript" type="text/javascript">
	function delSlider(id) {
		if (confirm("Are you sure ?" )) {
			window.location.replace("index.php?pages=slider&mode=del&id=" + id);			
		}
	}	
</script>
<div id="content">
  <div class="breadcrumb">
        <a href="/">Home</a>
         :: <a href="index.php?pages=slider">Quản lý ảnh Slider </a>
     </div>
    <?php if($message!="") echo "<div class='success'>Success: ".$message."</div>";?>
      <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" />Quản lý ảnh Slider (<?=$n?>) </h1>
      <div class="buttons"><a onclick="location = 'index.php?pages=slider&mode=add'" class="button">Thêm</a><a class="button">Delete</a></div>
    </div>

    <div class="content">
        <? if($n>0){?>
        <table class="list">
          <thead>
            <tr>
              <td class="left">Thứ tự</td>
              <td class="left">Logo</td>
              <td class="left">Content</td>
              <td class="left">Link</td>
              <td class="left">Publish</td>
              <td class="right">Công cụ</td>
            </tr>
          </thead>
          <tbody>
              <?php
                    for($j=1; $j<=  count($slider123); $j++){
                    $tt = $tt + 1;
                    $id                            = $slider123[$j]['id_slider'];
                    $logo	= $slider123[$j]["logo"] <> "" ? "<img src='".$dir_imgslider.$slider123[$j]["logo"]."'  width='200' style='border: 1px solid #000000; padding-left: 0; padding-right: 0; padding-top: 0px; padding-bottom: 0px'>" : 'slider này chưa có ảnh';
                    $content	= $slider123[$j]['content'];
                    $publish	= $slider123[$j]['publish'];
                    $link                         =$slider123[$j]['link'];
            ?>
            <tr>
              <td class="left"><?= $tt ?></td>
              <td class="left"><?= $logo ?> </td>
              <td class="left"><?= $content ?></td>
              <td class="left"><?= $link ?></td>
              <td class="left"><?= ($publish == "1" ? "Có":"Không") ?></td>
              <td class="right"> <a href="index.php?pages=slider&mode=edit&id=<?=$id ?>"> <img border="0" alt="Edit" src="images/edit_button.gif" width="36" height="13"></a>
                                 <a class="openl" onClick="delSlider(<?=$id ?>)"> <img height="13" alt="Delete" src="images/del_button.gif" width="36" border="0"></a>
                </td>
            </tr>
            	<?php 
		} $sql->close();
		?>

        </tbody>
        </table>
        <? }else echo "<br><div align=center>Chưa có slider nào trong CSDL !</div>";?>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>