<?php include_once 'db-connection.php'; ?>
<?php

function getusername($id) {
    global $db;
    $stmt = $db->prepare("select * from  users  where user_id =:id");
    $stmt->execute(array(':id' => $id));
    $todolist = $stmt->fetch();
    return $todolist['username'];
}

function getalltasks() {
    global $db;
    $stmt = $db->prepare("select tod.item_id as item_id , tod.item_text, tod.user_id, tod.created_date, us.username "
            . "from todolist tod, users us where tod.user_id = us.user_id and tod.item_done = :id order by tod.item_id desc");
    $stmt->execute(array(':id' => 0));
    $tasks = $stmt->fetchAll();
    return $tasks;
}

function getUsertasks($user_id) {
    global $db;
    $stmt = $db->prepare("select *,(select  username from users where user_id=todolist.user_id) as username "
            . "from todolist where item_done =:id and user_id= :user_id order by item_id desc");
    $stmt->execute(array(':id' => 0, ':user_id' => $user_id));
    $tasks = $stmt->fetchAll();
    return $tasks;
}

function getcomments($item_id) {
    global $db;
    $stmt = $db->prepare("select *,(select  username from users where user_id=comments.user_id) as username from  comments where item_id = :item_id order by comment_id desc");
    $stmt->execute(array(':item_id' => $item_id));
    $comments = $stmt->fetchAll();
    return $comments;
}
?>

