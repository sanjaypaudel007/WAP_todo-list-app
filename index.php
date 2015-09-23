<?php
include_once 'includes/header.php';
include 'logic/getters.php';
include_once 'session_check.php';
?>
<?php
$alltasks = getalltasks();
//var_dump($allitems);
?>
<div id="logout">Welcome: <?= $_SESSION['username'] ?> | <a href="logout.php">Logout</a></div>
<div class="error"><?php if (!isset($_SESSION['error'])) {
    echo $_SESSION['error'];
} unset($_SESSION['error']); ?></div>
<div class="row form-group">
    <div class="col-md-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Add Todo</div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Your Todo.." id="txtNewTask">

                    <span class="input-group-addon success" id="btnSaveTask">
                        <span class="glyphicon glyphicon-plus"></span>
                    </span>

                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-4">
        <div class="col-md-2">
            <label>Filter By:</label>
        </div>
        <div class="col-md-4">
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button id="btnAllList" type="button" class="btn btn-default active">All</button>
                </div>
                <div class="btn-group" role="group">
                    <button id="btnMyList" type="button" class="btn btn-default">My Todo</button>
                </div></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-lg-offset-2">
        <hr class="hr-primary" />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-list"></span>Todo Lists
            </div>
            <div class="panel-body">
                <ul class="list-group" id="TasksList">
                <?php foreach ($alltasks as $task) { ?>
                        <li class="list-group-item titleBox" id="liTask-<?= $task['item_id'] ?>">                            
                            <label id="<?= "lbltask" . $task['item_id']; ?>"><?php echo $task['item_text']; ?></label>
                            <span class="sub-text">On <?= $task['created_date'] . ' By ' . getusername($task['user_id']); ?></span>

                            <div  id="<?= "main_div_todo" . $task['item_id']; ?>"  class="hideMe">
                                <input type="text" class="form-control" value="<?php echo $task['item_text']; ?>" id="<?= "txttask" . $task['item_id']; ?>" >
                                <input type="button" id="<?= "btntask" . $task['item_id']; ?>" value="Save">
                            </div>
                            <?php if ($_SESSION['user_id'] === $task['user_id']): ?>
                                <div class="pull-right action-buttons">
                                    <a id="<?= $task['item_id'] ?>" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a id="<?= $task['item_id'] ?>" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
                                    <a id="<?= $task['item_id'] ?>" class="flag"><span class="glyphicon glyphicon-ok"></span></a>
                                </div>
                                    <?php endif; ?>
                            <div class="actionBox">
                                <ul id="commentList-<?= $task['item_id'] ?>">                                
                                    <?php
                                    $comments = getcomments($task['item_id']);
                                    foreach ($comments as $comment) {
                                        ?>
                                        <li id="liComment-<?= $comment['comment_id'] ?>">
                                            <div class="commentText">
                                                <p class="comment" id="comment-<?= $comment['comment_id'] ?>"><?= $comment['comment_text']; ?></p> 
                                                <?php if ($_SESSION['user_id'] === $comment['user_id']): ?>
                                                <div class="pull-right action-buttons">
                                                    <a id="<?= $comment['comment_id'] ?>" class="editcomment"><span class="glyphicon glyphicon-pencil"></span></a>
                                                    <a id="<?= $comment['comment_id'] ?>" class="deletecomment"><span class="glyphicon glyphicon-trash"></span></a>
                                                </div>
                                                <?php endif; ?>
                                                <span class="date sub-text"><?= $comment['created_date'] . ' By ' . getusername($comment['user_id']); ?></span>

                                            </div>
                                        </li>
                    <?php } ?>	
                                </ul>
                                <div class="form-inline" role="form">
                                    <div class="form-group">
                                        <input class="form-control" id ="txtnewcomment-<?= $task['item_id'] ?>" type="text" placeholder="Your comments"/>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success btn-comment" id="<?= $task['item_id'] ?>">Add</button>
                                    </div>
                                </div>
                            </div>
<?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php include_once 'includes/footer.php'; ?>
