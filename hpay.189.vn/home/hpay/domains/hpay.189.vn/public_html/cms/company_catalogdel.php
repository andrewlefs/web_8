<?php
	if (!defined("qaz_wsxedc_qazxc0FD_123K")){
		die("<a href='index.php'>Login</a> to Web Contents Manager !");
	}
	$sql = new db_sql();
                           $sql->db_connect();
                           $sql->db_select();
	if ($_GET["mode"]=="del" && $_GET["pages"]=="company_catalog" )
	{
                                        if($_GET["act"]=="del") {                                                   
                                                    $id = $_GET["id"];
                                                    $query = "delete from ".DB_PREFIX."company_catalog where id=$id";
                                                    $sql->query($query);
                                                    require_once("company_catalog.php");
                                                    exit();                                                  
                                          }
	}
?>
