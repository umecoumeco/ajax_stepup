<?php
include('functions.php');

//DB接続
$pdo = db_conn();

//データ表示SQL作成
$sql = 'SELECT * FROM php_ajax_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// jsonデータにして出力
if ($status==false) {
    errorMsg($stmt);
} else {
    $res = [];
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $result;
    }
    header('Content-Type: application/json');
    echo json_encode($res);
}
