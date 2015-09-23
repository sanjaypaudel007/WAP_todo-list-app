<?php include_once 'includes/header.php'; ?>

<div class="row form-group">
    <div class="col-md-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Add Todo</div>
            <div class="panel-body">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Your Todo.." id="txtNewTodo">

                    <span class="input-group-addon success" id="btnSaveTodo">
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
                <ul class="list-group" id="response">
                </ul>
            </div>
        </div>
    </div>
</div>


<?php include_once 'includes/footer.php'; ?>
