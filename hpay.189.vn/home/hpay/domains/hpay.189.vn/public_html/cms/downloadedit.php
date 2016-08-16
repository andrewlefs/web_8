<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
	$sql->db_connect();
	$sql->db_select();
	$downloadcat = array();
	//get info of news category
	$select_query = "SELECT id, title FROM downloadcat WHERE publish=1 ORDER BY list_order, title";
	$sql->query($select_query);
	$i = 0;
	while($rows = $sql->fetch_array()){
		$i = $i + 1;
		$downloadcat[$i]["id"] 		= $rows["id"];
		$downloadcat[$i]["title"] 	= $rows["title"];	
	}


	if($HTTP_POST_VARS[mode] == "edit"){
		$id 	= $_POST["id"];		
		$title 	= isset($_POST["title"])				? convert_font($_POST["title"])		: '';
		$intro	= isset($_POST["intro"])				? convert_font($_POST["intro"])		: '';		
		$content 	= isset($_POST["content"])				? convert_font($_POST["content"])		: '';		
		$filename 	= isset($_POST["filename"]) ? $_POST["filename"] : '';
		$publish 	= $_POST["publish"]==1?$_POST["publish"]:0;
		$downloadcat_id	= $_POST["downloadcat_id"];
		$position_page = $_POST["position_page"];
				
		if($title 		== "") $message1 = $message1."<li/>Hãy nhập tiêu đề tin";		
		if($content 	== "") $message1 = $message1."<li/>Hãy nhập nội dung tin tức";
		if($downloadcat_id 	== 0) $message1 = $message1."<li/>Hãy chọn một nhóm tin";
	
		//Bat dau chen DL vao CSDL		
		if($message1 ==""){			
			$title 	= convert_font($_POST["title"],2);
			$intro 	= convert_font($_POST["intro"],2);
			$content = convert_font($_POST["content"],2);
			$list_order = $_POST["list_order"];

			$update_query = "UPDATE download SET title='$title', intro='$intro', filename='$filename', 
							 content='$content', publish=$publish, list_order=$list_order, downloadcat_id=$downloadcat_id WHERE id='$id'";
		
			if($sql->query($update_query)){
				$sql->close();
				$message = $message."<li>Cập nhật thành công !";
				include_once("download.php");
				exit();
			}
		}
	}
	//lay  mang chu de
	if($HTTP_GET_VARS[mode] == "edit"){
		$id = $HTTP_GET_VARS["id"];
		$select_query = "SELECT * FROM download WHERE id = '$id'";

		$sql->query($select_query);
		$row = $sql->fetch_array();
		$title 	= convert_font($row["title"]);
		$intro	= convert_font($row["intro"]);
		$content 	= convert_font($row["content"]); 
		$filename 	= $row["filename"];
		$publish = $row["publish"];
		$downloadcat_id	= $row["downloadcat_id"];
		$list_order = $row["list_order"];
		$position_page = $_GET["position_page"];
		$row_count = $sql->count_rows_from_query("SELECT * FROM download WHERE downloadcat_id = ".$downloadcat_id);
		$list_order = $list_order > $row_count ? $row_count : $list_order;
	}	

?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META content="DEMO - Thuong mai dien tu - Kinh doanh tren Internet - Quang ba san pham..." name=keywords>
<META content="DEMO" name=description>
<LINK href="../style/mstyle.css" rel=stylesheet type=text/css>
<script language='Javascript' src='viettyping.js'></script>
<title>-- Edit Download --</title>
<script language="javascript">
function validateForm(){
	if (document.getElementById("downloadcat_id").value > 0)
		return true;
	else
	{
		alert("Xin hãy chọn một Nhóm tin");
		return false;
	}
}
</script>
</head>
<body><div align="center">
<table width="780" border="0" align="center" cellpadding="2" cellspacing="0">
  <tbody>
    <tr>
      <td width="143" align="center" bgcolor='whitesmoke' class="logout">[ <a href="index.php?pages=logout">Logout</a> ]</td>
      <td align="center" bgcolor='whitesmoke' class="menu_bar_manager">[ <a href="index.php?pages=download&mode=add">Th&ecirc;m Download </a>] [ <a href="index.php?pages=download">Danh sách Download </a>]</td>
    </tr>
  </tbody>
</table>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor='whitesmoke' width="147" height="100%" valign="top"><?php include("menu.php"); ?></td>
    <td width="633" valign="top">
      <center>
        <div align="center"><br>
            <table width="600">
              <tr>
                <td class="header_table"><a href="index.php?pages=download&position_page=<?=$position_page?>"><img height=15 alt="Danh sách Download" src="../images/back.gif" width=15 border=0></a></td>
              </tr>
              <tr>
                <td class="header_table"><?php if($message!="") echo $message; if($message1!="") echo $message1; ?></td>
              </tr>
            </table>
            <table width="600" cellspacing="0">
              <form action="index.php?pages=download&mode=edit" method="post" enctype="multipart/form-data" name="editnew" id="editnew">
                <tr>
                  <td valign="top" bgcolor="#d4d0c8">
                    <table bgcolor="whitesmoke"  width="100%" cellpadding="0" cellspacing="1" >
                      <tr class="header_table">
                        <td colspan="4" valign="top" bgcolor="whitesmoke" class="book_header"> Sửa th&ocirc;ng tin cho một Download <br></td>
                      </tr>
                      <tr class="book_tr">
                        <td width="28%"   class="book_tr_left" >Nhóm: </td>
				<td width="72%"  colspan="3">
				  <select size="1" name="downloadcat_id" id="downloadcat_id" class="input_b3">
				  <option value="0">---</option>
				  <?php
				  for($i=1;$i<=count($downloadcat);$i++){
						$str = "<option ";
						if($downloadcat_id == $downloadcat[$i]["id"])
							$str.= "selected ";
						$str.= "value='".$downloadcat[$i]["id"]."'>".$downloadcat[$i]["title"]."</option>";
						echo $str;
				  }
				  ?>
				  </select>				</td>
			  </tr>
			  <tr class="book_tr">
                <td width="28%"   class="book_tr_left" >Ti&ecirc;u &#273;&#7873;: </td>
                <td width="72%"  colspan="3">
                  <input name="title" class="input_b3" id="title" value="<?=$title?>" size="18">                </td>
              </tr>
              <tr class="book_tr">
                <td class="book_tr_left" >File:</td>
                <td colspan="3">
				<table>
				<tr>
				<td>
				<?
				$used_files = array();
				$files_array = download_files_listing();
				$n = count($files_array);
				
				$sql = new db_sql();
				$sql->db_connect();	
				$sql->db_select();
				$str_sql = "SELECT filename FROM download WHERE filename IN(";
				for($i=0; $i<$n; $i++){
					$str_sql.="'".$files_array[$i]."'";
					if($i<$n-1)
						$str_sql.=",";
				}					
				$str_sql.=") ";
//				echo $str_sql;
				$sql->query($str_sql);
				$i = 0;
				while($rows = $sql->fetch_array()){
					$used_files[$i++] = $rows["filename"];
				}
				$sql->close();
				$unused_files = array_merge(array_diff($used_files,$files_array),array_diff($files_array,$used_files));
				
				?>
				<select name="filename" id="filename" size="10">
				<optgroup label="Unused files">
				<?
					for($i=0; $i<count($unused_files); $i++)
						echo "<option value='$unused_files[$i]'>$unused_files[$i]</option>\n";
				?>
				</optgroup>
				<optgroup label="Files in use">
                <?
					for($i=0; $i<count($used_files); $i++){
						$str = "<option ";
						if($filename == $used_files[$i])
							$str.= "selected ";
						$str.= "value='$used_files[$i]'>$used_files[$i]</option>\n";
						echo $str;
				  	}
				?>
				</optgroup>
				</select>				</td>
				<td align="right">
				<input type="button" value="Refresh files list" onClick="document.location = 'index.php?pages=download&mode=add'"><br>
				<script language="javascript">
				function OpenNewWindow(url,w,h) {
					window.open(url,'new_page','toolbar=no,location=no,menubar=no,scrollbars=yes,width=' + w + ',height=' + h + ',top=60,left=100,resizeable=no,status=no');
				}
				</script>
				<input type="button" value="Upload new files" onClick="OpenNewWindow('index.php?pages=upload_form',370,350)">				</td>
                </tr>
				</table>				</td>
                      </tr>                      
                      <tr  class="book_tr">
						<td colspan="4"  valign="top" class="book_text" >Trích dẫn:<br> 
						  <?
							include("FCKeditor/fckeditor.php");
						?>
						  <?php
							$oFCKeditor = new FCKeditor('intro') ;
							$oFCKeditor->BasePath = 'FCKeditor/';
							$oFCKeditor->Width  = '100%' ;
							$oFCKeditor->Height = '200' ;
							$oFCKeditor->Value = $intro;
							$oFCKeditor->Create() ;
						?>					    </td>
					  </tr>
					  <tr  class="book_tr">
						<td colspan="4"  valign="top" class="book_text" >Nội dung Download:*<br> 
						  <?php
							$oFCKeditor = new FCKeditor('content') ;
							$oFCKeditor->BasePath = 'FCKeditor/';
							$oFCKeditor->Width  = '100%' ;
							$oFCKeditor->Height = '300' ;
							$oFCKeditor->Value = $content;
							$oFCKeditor->Create() ;
						?>						</td>
					  </tr>
					  <tr  class="book_tr">
						<td  valign="top" class="book_text" >Hiển thị: </td>
						<td valign="top" colspan="3">
							<INPUT name=publish type=checkbox id="publish" style="FLOAT: left" 
		                        value=1 <?=$publish==1?"checked":""?>>						 </td>
					  </tr>
					  <tr  class="book_tr">
						<td  valign="top" class="book_text" >Thứ tự: </td>
						<td valign="top" colspan="3">
						<SELECT name=list_order size=1 id="list_order">
						 <?php
						 for($i=1; $i<=$row_count; $i++) 
						 {
						 	if ($i == $list_order){
						 ?>
                            <OPTION value="<?=$i?>" selected><?=$i?></OPTION>                            
						 <?php }else { ?>
						 	<OPTION value="<?=$i?>"><?=$i?></OPTION>
						 <?php }}?>
                          </SELECT>						 </td>
					  </tr>
                      <tr class="book_tr" >
                        <td valign="top" ></td>
                        <td valign="top"  colspan="3"><input type="submit" name="Submit" value="Update">
                            <input name="pages" type="hidden" id="pages" value="new">
                            <input name="mode" type="hidden" id="mode" value="edit">
                            <input name="filecu" type="hidden" id="mode3" value="<?=$filecu?>">
                            <input name="imgtemp" type="hidden" id="mode3" value="<?=$imgtemp?>">
                            <input name="position_page" type="hidden" id="id_old" value="<?=$position_page?>">
                            <input name="id" type="hidden" id="id" value="<?=$id?>"></td>
                      </tr>
                  </table></td>
                </tr>
              </form>
            </table>
            <br>
        </div>
    </center></td>
  </tr>
</table>
</div></body>
</html>