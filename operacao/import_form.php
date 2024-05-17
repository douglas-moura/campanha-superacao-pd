<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/db.php";
$db = new Db($config);

function getDbKeys($dbObj, $table, $key) {
  $query = "SELECT $key FROM $table";
  $rows = $dbObj -> select($query);
  $keys = [];
  if(isset($rows[0])){
    foreach ($rows as $field) {
      $keys[] = $field[$key];
    }
  }
  return $keys;
}

function generateQueryUpdate($tableName, $tableKey, $line, $header) {

  $queryWhere = "";
  $query = "update $tableName set ";
  foreach ($line as $key => $col) {
    switch ($header[$key]) {
      case $tableKey:
        $queryWhere = " where " . $header[$key] . " = '$col'";
        break;

      case 'id':
      case 'created_at':
        //null
        break;

      case 'updated_at':
        $fildDivisor = (count($line) > $key + 1) ? ', ' : '';
        $query .= $header[$key] . " = now() $fildDivisor";
        break;

      default:
        $fildDivisor = (count($line) > $key + 1) ? ', ' : '';
        $query .= $header[$key] . " = '$col' $fildDivisor";
        break;
    }

  }

  return  "$query $queryWhere; ";
}

function generateQueryInsert($tableName, $line, $header, $tableKey) {

  $query = "INSERT INTO $tableName ( ";
  foreach ($header as $key => $headerCol) {
    if ($header[$key] === 'id') {
      //null
    } else {
      $fildDivisor = (count($header) > $key + 1) ? ', ' : '';
      $query .= "$headerCol $fildDivisor ";
    }
  }
  $query .= " ) VALUES ( ";

  foreach ($line as $key => $col) {
    if ($header[$key] !== 'id') {
      $fildDivisor = (count($line) > $key + 1) ? ', ' : '';
      $query .= " '$col' $fildDivisor ";
    }
  }

  $query .= " ) ";

  return  $query;
}

function generateQueryInsertUpdate($tableName, $line, $header) {

  $query = "INSERT INTO $tableName ( ";
  foreach ($header as $key => $headerCol) {

    switch ($header[$key]) {

      case 'created_at':
      case 'updated_at':
        $fildDivisor = (count($line) > $key + 1) ? ', ' : '';
        $query .= $header[$key] . " = now() $fildDivisor";
        break;

      default:
        $fildDivisor = (count($line) > $key + 1) ? ', ' : '';
        $query .= $header[$key] . " = '$col' $fildDivisor";
        break;
    }

  }
  $query .= " ) VALUES ( ";

  foreach ($line as $key => $col) {
    if ($header[$key] !== 'id') {
      $fildDivisor = (count($line) > $key + 1) ? ', ' : '';
      $query .= " '$col' $fildDivisor ";
    }
  }

  $query .= " ) ON DUPLICATE KEY UPDATE ";

  foreach ($line as $key => $col) {
    $fildDivisor = (count($line) > $key + 1) ? ', ' : '';
    $query .= " " . $header[$key] . " = VALUES(" . $header[$key] . "), $fildDivisor ";
  }

  return  $query;
}

function readCSV($csvFile){
  $file_handle = fopen($csvFile, 'r');
  while (!feof($file_handle) ) {
      $line_of_text[] = fgetcsv($file_handle, 1024, ';');
  }
  fclose($file_handle);
  return $line_of_text;
}

function execute($tableName, $tableKey, $keys, $csv, $db) {
  foreach ($csv['lines'] as $key => $value) {
    if(in_array($key, $keys)) {
      $query = generateQueryUpdate($tableName, $tableKey, $value, $csv['header']);
      $db -> select($query);
    } else {
      $query = generateQueryInsert($tableName, $value, $csv['header']);
      $db -> select($query);
    }
  }
}

function getFile($tableKey) {
  $resultCsv = [];

  if(isset($_POST["Import"]) && $_FILES["file"]["size"]) {
    $resultCsv = readCSV($_FILES["file"]["tmp_name"]);
  }

  $result = [
    'header' => [],
    'lines' => []
  ];

  foreach ($resultCsv as $key => $value) {
    if($key === 0 && $value[0] === 'id' && empty($result['header']) ) {
      $result['header'] = $value;
    } else {
      $result['lines'][] = $value;
    }
  }
  return $result;
}



$table = 'catalog';
$tableKey = 'cod';
$dbKeys = getDbKeys($db, $table, $tableKey);

$csv = getFile($tableKey);
// var_dump($csv);

$query = generateQueryUpdate($table, $tableKey, $csv['lines'][0], $csv['header']);

echo "<pre> $query </pre>";
exit();

// INSERT INTO table (id,Col1,Col2) VALUES (1,1,1),(2,2,3),(3,9,3),(4,10,12)
// ON DUPLICATE KEY UPDATE Col1=VALUES(Col1),Col2=VALUES(Col2);

// $_keys = getDbKeys($db, $table, $table);
// execute($_keys, $csv);


?>
