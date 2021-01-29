<?php
require_once('../db_connect.php');

class TaskModel{
    
    public static function AddTask($data){
        
        $db = new DBConnect();
        $sql = 'INSERT INTO tasks (name, email, creation_date, end_date, task_name, task_desc) VALUES(?, ?, ?, ?, ?, ?)';
        $selectLastId='SELECT id FROM tasks ORDER BY ID DESC LIMIT 1';
        try {

            $stmt = $db->connectToDB()->prepare($sql);
            $stmt->execute($data);
            $id = $db->connectToDB()->query($selectLastId)->fetch();
            return array("status" => "success", "id"=>$id['id']);

        } catch (Exception $e) {
            file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " " . strval($e->getMessage()) . "\n", FILE_APPEND);
            return array("status" => "failed", 'id'=>'');
        }
    }
    public static function ShowTask($id){
        try {
              $db = new DBConnect();
              $selectLastDataQuery='SELECT * FROM tasks WHERE id='.$id;
              $data=$db->connectToDB()->query($selectLastDataQuery)->fetch();
              file_put_contents(dirname(__FILE__) . '/'.'log2.txt', date('Y-m-d H:i:s'). " " .$data['name'] . "\n",FILE_APPEND);
              return $data;
        } catch (Exception $e) {
            file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " " . strval($e->getMessage()) ."\n", FILE_APPEND);
            return array("status" => "failed", 'id'=>$id);
        }
      
    }
    public static function DeleteTask($id){
        try {
              $db = new DBConnect();
              $deleteQuery = 'DELETE FROM tasks WHERE id ='.$id;
              file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " ID- " . $id."\n",
              FILE_APPEND);
              $stmt = $db->connectToDB()->prepare($deleteQuery);
              $stmt->execute();
              return array("status" => "success", 'id'=>$id);
        } catch (Exception $e) {
            file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " " . strval($e->getMessage())
            ."\n", FILE_APPEND);
            return array("status" => "failed", 'id'=>$id);
        }
    }

    public static function LoadTasks(){
        try {
            $db = new DBConnect();
            $selectAll='SELECT * FROM tasks';
            $data=$db->connectToDB()->query($selectAll)->fetchAll();
            file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). "Load from BD "."\n",
            FILE_APPEND);
            return $data;
        } catch (Exception $e) {
            file_put_contents(dirname(__FILE__) . '/'.'log.txt', date('Y-m-d H:i:s'). " " . strval($e->getMessage())
            ."\n", FILE_APPEND);
            return array("status" => "failed");
        }
        
    }
}