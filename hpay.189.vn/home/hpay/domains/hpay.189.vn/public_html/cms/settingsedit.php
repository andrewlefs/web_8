<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
	if($_GET[mode] == "edit"){
		$id = $_GET["id"];
		$select_query = "SELECT id, keyword, description, siteurl, intro, siteemail, contact, footer, sitename FROM ".DB_PREFIX."settings WHERE id = '$id'";
		$sql->query($select_query);
		$row = $sql->fetch_array();
			$keyword 	= $row["keyword"]; 
			$description    = $row["description"]; 
			$siteurl 	= $row["siteurl"]; 
			$siteemail 	= $row["siteemail"]; 
			$contact 	= $row["contact"];
                                                                                $intro  	= $row["intro"];
			$footer 	= $row["footer"]; 
			$sitename 	= $row["sitename"]; 
                                                                                $position_page = $_GET["position_page"];
	}	
	if($_POST[mode] == "edit"){
			$id 			= $_POST["id"];		
			$keyword 		= isset($_POST["keyword"])	? ($_POST["keyword"])		: '';
			$description            = isset($_POST["description"])	? ($_POST["description"])	: '';
			$siteurl 		= isset($_POST["siteurl"])	? ($_POST["siteurl"])		: '';
			$siteemail 		= isset($_POST["siteemail"])	? ($_POST["siteemail"])		: '';
			$contact 		= isset($_POST["contact"])	? ($_POST["contact"])		: '';
                                                                                $intro                  = isset($_POST["intro"])	? ($_POST["intro"])		: '';
			$footer 		= isset($_POST["footer"])	? ($_POST["footer"])		: '';
			$sitename 		= isset($_POST["sitename"])	? ($_POST["sitename"])		: '';		
			$position_page 	= $_POST["position_page"];
				
		if($siteurl 	== "") $message1 = $message1."Hãy nhập tên website";
		if($message1 ==""){			
//			$keyword 	= $_POST["keyword"]; 
//			$description 	= $_POST["description"]; 
//			$siteurl 	= $_POST["siteurl"]; 
//			$siteemail 	= $_POST["siteemail"]; 
//			$contact 	= $_POST["contact"]; 
//                                                                                $intro          = $_POST["intro"]; 
//			$footer 	= $_POST["footer"]; 
//			$sitename 	= $_POST["sitename"];		
                                                                                $update_query = "UPDATE ".DB_PREFIX."settings SET keyword='$keyword', description='$description', siteurl='$siteurl', 
					siteemail='$siteemail',	contact='$contact',  intro='$intro', footer='$footer', sitename='$sitename'  WHERE id='$id'";
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."Cập nhật thành công !";
                                                                                                           header("Location: index.php?pages=settings&mode=edit&id=1");
				exit();
			}
		}
	}			
?>

<?php include("lib/header.php")?>
<!-- TinyMCE -->
<script type="text/javascript" src="/extsource/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/extsource/tiny_mce/tiny_mce_menu.js"></script>
<!-- /TinyMCE -->
<div id="content">
<div class="breadcrumb">
        <a href="/">Home</a> :: <a href="index.php?pages=settings">Cấu hình website</a>
     </div>
    <?php   if($message!="") echo "<div class='success'>Success: ".$message."</div>"; 
            if($message1!="") echo "<div class='warning'>Warning: ".$message1."</div>"; ?>
    <div class="box">
    <div class="heading">
      <h1><img src="images/category.png" alt="" /> Cấu hình website</h1>
      <form action="index.php?pages=settings&amp;mode=edit" method="post" enctype="multipart/form-data" name="editsettings" id="editsettings" onSubmit="return submitForm();">
      <div class="buttons"><input type="submit" name="Submit" value="Cập nhật" class="submit1" />
                                <a onclick="location = ''" class="button">Cancel</a></div>
    </div>
    <div class="content">
       <div id="tab-general">
       <div id="language1">
            <table class="form">
                      <?=$update_query?>
              <tr>
                <td><span class="required">*</span> Tên website:</td>
                <td><input type="text" name="sitename" size="100"  id="sitename" value="<?=$sitename?>" />
                  </td>
              </tr>
             <tr>
                <td><span class="required">*</span>Địa chỉ website:</td>
                <td><input type="text" name="siteurl" size="100"  id="siteurl" value="<?=$siteurl?>" />
                 <br/> <i>(vd: http://www.hoanggia.net)</i></td>
              </tr> 
              <tr>
                <td><span class="required">*</span>Email:</td>
                <td><input type="text" name="siteemail" size="100"  id="siteemail" value="<?=$siteemail?>" />
                </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Keyword:</td>
                <td><input type="text" name="keyword" size="100"  id="keyword" value="<?=$keyword?>" />
                </td>
              </tr>
              <tr>
                <td><span class="required">*</span>Description:</td>
                <td><input type="text" name="description" size="100"  id="description" value="<?=$description?>" />
                </td>
              </tr>
             <tr>
                <td><span class="required">*</span>Contact:</td>
                <td><input type="text" name="contact" size="100"  id="contact" value="<?=$contact?>" />
                </td>
              </tr> 
              <tr>
                <td>Intro:</td>
                <td><textarea name="intro" cols="150" rows="10" ><?=$intro?></textarea></td>
                </tr>
              <tr>
                <td>Footer:</td>
                <td><textarea name="footer" cols="150" rows="10" ><?=$footer?></textarea></td>
                </tr>
   
            </table>
          </div>
       </div>   
        <input name="pages" type="hidden" id="pages" value="settings">
        <input name="mode" type="hidden" id="mode" value="edit">
        <input name="position_page" type="hidden" id="tinid_old" value="<?=$position_page?>">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
      </form>
    </div>
  </div>
</div>
</div>
<?php include("lib/footer.php")?>
</body>
</html>

