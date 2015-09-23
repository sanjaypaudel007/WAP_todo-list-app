<?php

include("db-connection.php");
include ("getters.php");
$action = filter_input(INPUT_POST, 'action');
session_start();
include_once '../session_check.php';
//$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];

switch ($action) {
    case "Insert":
        $comment_text = filter_input(INPUT_POST, 'commentText');
        $item_id = filter_input(INPUT_POST, 'itemId');
        $created_date = date('Y-m-d H:i:s');

        $statement = $db->prepare("INSERT INTO comments VALUES (NULL, :comment_text, :user_id, :item_id, :created_date)");
        $statement->execute(array(":comment_text" => $comment_text, ":user_id" => $user_id, ":item_id" => $item_id, ":created_date" => $created_date));

        $comments = getcomments($item_id);
        echo json_encode($comments);
        break;

    case "Update":
        $comment_text = filter_input(INPUT_POST, 'commentText');
        $comment_id = filter_input(INPUT_POST, 'commentId');
        $user_id = filter_input(INPUT_POST, 'userId');

        $statement = $db->prepare("UPDATE comments set comment_text= :comment_text where comment_id= :comment_id and user_id= :user_id");
        $statement->execute(array(":comment_text" => $comment_text, ":user_id" => $user_id, ":comment_id" => $comment_id));
        if ($statement->rowCount()) {
            echo $comment_id;
        } else {
            echo 'You are not allowed to do update.';
        }
        break;
    case "Delete":
        $comment_id = filter_input(INPUT_POST, 'commentId');
        $statement = $db->prepare("DELETE FROM comments where comment_id= :comment_id and user_id= :user_id");
        $statement->execute(array(":user_id" => $user_id, ":comment_id" => $comment_id));
        if ($statement->rowCount()) {
            echo $comment_id;
        } else {
            echo 'You are not allowed to do delete.';
        }
        break;
    case "Select":
        $item_id = filter_input(INPUT_POST, 'itemId');
        $statement = $db->prepare("SELECT * FROM comments where item_id= :item_id");
        $statement->execute(array(":item_id" => $item_id));
        return $statement->fetchall();
    default:
        exit(0);
}

function check($comment_id) {
    global $db, $user_id;
    $statement = $db->prepare("SELECT * FROM comments where comment_id= :comment_id and user_id= :user_id");
    $statement->execute(array(":user_id" => $user_id, ":comment_id" => $comment_id));
    if (count($statement->fetchall()) > 0) {
        return true;
    } else {
        $error = "You are not allowed to do this operation.";
        $_SESSION['error'] = $error;
        exit(0);
    }
}
