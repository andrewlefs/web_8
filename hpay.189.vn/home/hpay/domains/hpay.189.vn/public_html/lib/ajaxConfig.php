<?php
if(!empty($_POST['productId'])){
    $sql = new db_sql();
    $sql->db_connect();
    $sql->db_select();
    $productId = $_POST['productId'];
    $sql_query = "SELECT gia FROM sanpham WHERE  SanphamID = $productId";
    $sql->query($sql_query);
    $row = $sql->fetch_array();
    $giaString = number_format($row['gia']*$_POST['numb']);
    $giaNumber = $row['gia']*$_POST['numb'];
    }else{
        $giaString=gia(0);
        $giaNumber=0;
    }
    $arrData = array(   'giaString' => $giaString,
                    'giaNumber' => $giaNumber
    );
    print_r(json_encode($arrData));
    die();
?>