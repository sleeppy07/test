<?php
    $db_type = "mysql";
    $db_host = "localhost";
    $db_name = "test";
    $user_name ="root";
    $user_pass ="pwdpwd";
    
    $conn = new PDO("$db_type:host=$db_host;dbname=$db_name",$user_name,$user_pass);
    if ($conn) {
        echo "Connected to the $db_host successfully! <br><br>";
    }
    else echo "Connected to the $db_host fail! <br><br>";


    // $data = [
    //     [
    //          'ma' => 'KH11',
    //          'hoten' => 'rut tien',
    //          'diachi' => '2023-06-07',
    //          'sodt' => '1000',
    //          'ngaysinh' => 'di rut tien',
    //          'doanhso' => '600000',
    //          'ngdk'=> '2023-08-07'
    //     ]];
    
    // $state = $conn->prepare("INSERT INTO khachhang(MAKH,HOTEN,DIACHI,SODT,NGAYSINH,DOANHSO,NGDK) VALUE (:ma,:hoten,:diachi,:sodt,:ngaysinh,:doanhso,:ngdk)");

    // try{
    //     foreach($data as $row) {
    //         $state->execute($row); 
    //     }
    //     echo "Add success <br><br>";
    // }
    // catch (Exception $e) 
    // {
    //     echo "Add failed: " . $e->getMessage();
    // }


    // $state = $conn->query("SELECT * FROM khachhang")->fetchAll();

    // try{
    //     foreach ($state as $row) {
    //         print_r($row);
    //         echo '<br><br>';
    //     }

    //     foreach ($state as $row) {
    //         echo $row['MAKH'], '<br>';
    //         echo $row['HOTEN'], '<br>';
    //     }
    // }
    // catch (Exception $e) 
    // {
    //     echo "get failed: " . $e->getMessage();
    // }


    // $state = $conn->prepare("UPDATE khachhang SET HOTEN = :fullname WHERE MAKH = :id");

    // $data = [
    //     'fullname'=> 'NGUYENTHUHA',
    //     'id' => 'KH02'
    // ];

    // try{
    //     $result = $state->execute($data);
    //     echo "<br>Update success <br>";
    // }
    // catch (Exception $e) 
    // {
    //     echo "<br>Update failed: " . $e->getMessage();
    // }

    // $state = $conn->prepare("DELETE from khachhang WHERE MAKH=:ma");
    // $data = [
    //          'ma' => 'KH05',
    // ];
        
    // try{
    //     $result = $state->execute($data);
    //     echo "<br>delete success <br>";
    // }
    // catch (Exception $e) 
    // {
    //     echo "<br>delete failed: " . $e->getMessage();
    // }


    function insert($table, $columns = [], $values = [])
    {
        global $conn;
        $count = count($columns) - count($values);

        $implodeArrayColumn = implode(', ', $columns);

        $valueSets = array();
        foreach($values as $index => $value) $valueSets[] = "'".$value."'";
        for($index = $count; $index > 0; $index--) $valueSets[] = "'?'";
        $implodeArrayValue = implode(', ', $valueSets);

        $state = $conn->prepare("INSERT INTO $table ($implodeArrayColumn) VALUE ($implodeArrayValue)");
        $result = $state->execute();
        return $result;
    }

    function delete($table, $conditions = [], $keys = [])
    {
        global $conn;
        $conditionSets = array();
        foreach($keys as $indexKey => $key) {
            foreach($conditions as $indexCondition => $condition){
                if($indexKey == $indexCondition){
                    $conditionSets[] = $condition . " = '" . $key . "'";
                }
            }
        }
        $implodeArrayCondition = implode(',', $conditionSets);

        $state = $conn->prepare("DELETE FROM $table WHERE $implodeArrayCondition");
        $result = $state->execute();
        return $result;
    }
    
    function select($table, $columns = [], $conditions = [], $keys = [])
    {
        global $conn;
        $implodeArrayColumn = implode(', ', $columns);

        if(count($columns) == 0) $implodeArrayColumn = '*';

        $conditionSets = array();
        foreach($keys as $indexKey => $key) {
            foreach($conditions as $indexCondition => $condition){
                if($indexKey == $indexCondition){
                    $conditionSets[] = $condition . " = '" . $key . "'";
                }
            }
        }
        $implodeArrayCondition = count($conditions) == 0 || count($keys) == 0 ? null : "WHERE ".implode(',', $conditionSets);

        $state = $conn->prepare("SELECT $implodeArrayColumn FROM $table $implodeArrayCondition");
        $result = $state->execute();
        return $state->fetchAll();
    }

    function update($table, $columns = [], $values = [], $conditions = [], $keys = [])
    {
        global $conn;
        $valueSets = array();
        foreach($values as $indexValue => $value) {
            foreach($columns as $indexColumn => $column){
                if($indexValue == $indexColumn){
                    $valueSets[] = $column . " = '" . $value . "'";
                }
            }
        }

        $conditionSets = array();
        foreach($keys as $indexKey => $key) {
            foreach($conditions as $indexCondition => $condition){
                if($indexKey == $indexCondition){
                    $conditionSets[] = $condition . " = '" . $key . "'";
                }

            }
        }
        $implodeArrayValue = implode(', ', $valueSets);
        $implodeArrayCondition = count($conditions) == 0 || count($keys) == 0 ? null : "WHERE ".implode(', ', $conditionSets);
        $state = $conn->prepare("UPDATE $table SET $implodeArrayValue $implodeArrayCondition");
        $result = $state->execute();
        return $result;
    }

    //----- INSERT -----

    //  $table = "nhanvien";
    //  $columns = ['MANV','HOTEN','NGVL','SODT'];//"MANV,HOTEN,NGVL,SODT"
    //  $values = ['NV06','Nguyen thu ha', '2009-10-01 00:00:00'];
    //  $implodeValue = implode(', ', $values);

    //  $result = insert($table, $columns, $values);

    // if($result) echo "<br>"."Insert Value $implodeValue in table $table Successfully!";
    // else echo "<br>"."Insert Value $implodeValue in table $table Failed!";

    //----- SELECT -----

    // $table = "nhanvien";
    // $columns = [];
    // $conditions = ['MANV'];
    // $keys = ['NV01'];

    // $result = select($table, $columns, $conditions, $keys);
    // var_dump($result);

    //----- DELETE -----

    // $table = "sanpham";
    // $conditions = ['MASP'];
    // $keys = ['BB01'];
    // $implodeValue = implode(', ', $keys);

    // $result = delete($table ,$conditions, $keys);

    // if($result) echo "Delete Value $implodeValue in table $table Successfully!";
    // else echo "Update Value $implodeValue in table $table Failed!";


    //----- UPDATE -----

    // $table = "khachhang";
    // $columns = ['HOTEN','DIACHI'];
    // $values = ['Nguyen thu ha', 'HCM'];
    // $conditions = [];
    // $keys = [];
    // $implodeColumn = implode(', ', $columns);

    // $result = update($table ,$columns, $values, $conditions, $keys);

    // if($result) echo "Update Value $implodeColumn in table $table Successfully!";
    // else echo "Update Value $implodeColumn in table $table Failed!"

 ?>