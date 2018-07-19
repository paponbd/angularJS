<?php

include 'config.php';

$data = json_decode(file_get_contents("php://input"));

$request_type = $data->request_type;

// Get all records
if($request_type == 1){
    $sel = mysqli_query($con,"select * from users");
    $data = array();

    while ($row = mysqli_fetch_array($sel)) {
        $data[] = array("id"=>$row['id'],"name"=>$row['name'],"email"=>$row['email'],"phone"=>$row['phone'],"address"=>$row['address']);           
    }
    echo json_encode($data);
}

// Insert record
if($request_type == 2){
    $name = $data->name;
    $email = $data->email;
    $phone = $data->phone;
    $address = $data->address;

    mysqli_query($con,"insert into users values(NULL,'$name','$email','$phone','$address')");
    $lastinsert_id = mysqli_insert_id($con);

    $return_arr[] = array("id"=>$lastinsert_id,"name"=>$name,"email"=>$email,"phone"=>$phone,"address"=>$address);
    echo json_encode($return_arr);
}

// Delete record
if($request_type == 3){
    $userid = $data->userid;

    mysqli_query($con,"delete from users where id=".$userid);
    echo 1;
}

if($request_type == 4){
    $id = $data->id;
    $name = $data->name;
    $email = $data->email;
    $phone = $data->phone;
    $address = $data->address;

    mysqli_query($con,"update users set name='$name', email='$email', phone='$phone', address='$address' where id='$id'");
    $data[] = array("id"=>$id,"name"=>$name,"email"=>$email,"phone"=>$phone,"address"=>$address);
    echo json_encode($data);
}

