<?php

include("db-connection.php");
include ("getters.php");
$action = filter_input(INPUT_POST, 'action');
session_start();

include_once '../session_check.php';
$user_id = $_SESSION['user_id'];

switch ($action) {
    case "Insert":
        $item_text = filter_input(INPUT_POST, 'itemText');
        $created_date = date('Y-m-d H:i:s');
        $statement = $db->prepare("INSERT INTO todolist VALUES (NULL, :item_text, 0, :user_id, :created_date)");
        $statement->execute(array(":item_text" => $item_text, ":user_id" => $user_id, ":created_date" => $created_date));
        $tasks = getalltasks();
        echo json_encode($tasks);
        break;
    case "Markdone":
        $item_id = filter_input(INPUT_POST, 'itemId');
        $statement = $db->prepare("UPDATE todolist set item_done= 1 where item_id= :item_id and user_id= :user_id");
        $statement->execute(array(":item_id" => $item_id, ":user_id" => $user_id));
        if ($statement->rowCount()) {
            echo $item_id;
        }
        else{
            echo 'You are not allowed to do mark done.';
        }
        break;
    case "Delete":
        $item_id = filter_input(INPUT_POST, 'itemId');
        $statement = $db->prepare("DELETE from todolist where item_id= :item_id and user_id= :user_id");
        $statement->execute(array(":item_id" => $item_id, ":user_id" => $user_id));
        if ($statement->rowCount()) {
            echo $item_id;
        }
        else{
            echo 'You are not allowed to delete.';
        }
        break;
    case "Alltask":
        $tasks = getalltasks();
        echo json_encode($tasks);
        break;
    case "Mytask":
        $tasks = getUsertasks($user_id);
        echo json_encode($tasks);
        break;
    default:
        break;
}

function check($item_id) {
    global $db, $user_id;
    $statement = $db->prepare("SELECT * FROM todolist where item_id= :item_id and user_id= :user_id");
    $statement->execute(array(":user_id" => $user_id, ":item_id" => $item_id));
    if (count($statement->fetchall()) > 0) {
        //echo '$user_id' . $user_id . 'item_id' . $item_id;
        return true;
    } else {
        $error = "You are not allowed to do this operation.";
        $_SESSION['error'] = $error;
        exit(0);
    }
}
