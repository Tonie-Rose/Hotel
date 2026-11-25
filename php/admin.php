<?php
$conn= new PDO(dsn:"mysql: host=localhost; dbname=hotelreserve_db",username: "root", password: "");
$user_name = $_POST['user_name'];
$password = $_POST['password'];
$role = $_POST['role'];

$stmt = $conn->prepare(query: "SELECT *FROM tb_admin WHERE user_name=? AND password=? AND role=?");
$stmt ->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
$stmt ->bindparam(param: 1,var: $user_name);
$stmt ->bindparam(param: 2,var: $password);
$stmt ->bindparam(param: 3,var: $role);
$stmt ->execute();

$stmt -> fetchAll((PDO:: FETCH_ASSOC));
$row=$stmt -> rowCount();
if ($row){
    echo json_encode(value: ["msg"=>"ok"]);
} else{
    echo json_encode(value: ["msg"=>"error"]);
}
?> 