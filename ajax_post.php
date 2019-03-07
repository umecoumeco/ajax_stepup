<?php
include('functions.php');

// 入力チェック
if (!isset($_POST['comment']) || $_POST['comment']=='') {
    exit('ParamError');
} else {
    $comment = $_POST['comment'];
}

// 名前の入力チェック（未入力の場合は名無しさんにしよう）
if (!isset($_POST['name']) || $_POST['name']=='') {
    $name = "名無しさん";
} else {
    $name = $_POST['name'];
}

// 登録のSQLを作成！
$sql ="INSERT INTO php_ajax_table(id,name,comment,indate)VALUES(NULL,:a1,:a2,sysdate())";

//DB接続
$pdo = db_conn();

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $comment, PDO::PARAM_STR);
$status = $stmt->execute();


// 情報持ってくるときはajax_get.phpと全く同じ
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
