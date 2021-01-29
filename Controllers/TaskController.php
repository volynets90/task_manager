<?php

require_once('../Models/TaskModel.php');

header("Content-type:application/json");
//get data from fom\


/*if (session_id() == '') {
    session_start();
}*/

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['id']))
{
    $id = $_GET['id'] ? $_GET['id']:'';
    file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). "ID- " . $id."\n", FILE_APPEND);
    TaskModel::DeleteTask($id);
}
else if($_SERVER['REQUEST_METHOD']=='GET'){
    $data = TaskModel::LoadTasks();
    //var_dump($data);
    file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). "Load  from moodel"."\n", FILE_APPEND);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $name = prepeare_input($_POST['fio']);
    $email = prepeare_input($_POST['email']);
    $endDate = prepeare_input($_POST['endDate']);
    $taskName = prepeare_input($_POST['taskName']);
    $taskDescription = prepeare_input($_POST['taskDescription']);
    $creationDate= date('d.m.Y');

    if($name=='' || $email=='' || $endDate==''|| $taskName=='' || $taskDescription==''){
        echo json_encode(array("status" => "failed", "error"=>"All fields required!"), JSON_UNESCAPED_UNICODE);
        return;
    }

    if(strlen($taskDescription)>1000){
        echo json_encode(array("status" => "failed", "error"=>"Task description must be less, than 1000 symbols"), JSON_UNESCAPED_UNICODE);
        return;
    }
   if(!valid_email($email))
   {
         echo json_encode(array("status" => "failed", "error"=>"Invalid email. Input correct email"), JSON_UNESCAPED_UNICODE);
         return;
   }
    $data=[
        $name,
        $email,
        $creationDate,
        valid_date($endDate),
        $taskName,
        $taskDescription
    ];

    $response=TaskModel::AddTask($data);
    if($response['status']=='success'){
        $data=TaskModel::ShowTask($response['id']);
        send_mail($email, $taskName, $taskDescription);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

function send_mail($to, $taskName, $taskDesc){
     try {
        $to = $to;
        $subject = $taskName;
        $message = ' <p><b>'.$taskName.'</b></p><br>
        <p>'.$taskDesc.'</p>';
        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: Task manager <taskmanager@email.com>\r\n";
    mail($to, $subject, $message, $headers);
     } catch (Exception $e) {
         file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " Email: " . strval($e->getMessage())
         ."\n", FILE_APPEND);
     }
}

function prepeare_input($input) {
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}

function valid_date($date){
    $date = new DateTime($date);
    return $date->format('d.m.Y');
}

function valid_email($email){
    $result=filter_var($email, FILTER_VALIDATE_EMAIL);
    file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " " . $result. "\n", FILE_APPEND);
    return $result;
}
//file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " " . $response['status'] . " " . $data['email']. "\n", FILE_APPEND);