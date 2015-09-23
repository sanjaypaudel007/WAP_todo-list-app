$(function () {
    "use strict";

    //get all task
    $('#btnAllList').click(function () {
        $('#btnAllList').addClass('active');
        $('#btnMyList').removeClass('active');
        $.post('logic/tasks.php', {
            'action': 'Alltask',
            'dataType': "json"
        }).done(GetAlltaskSuccess)
                .fail(Failure);
    });

    //get user task
    $('#btnMyList').click(function () {
        $('#btnMyList').addClass('active');
        $('#btnAllList').removeClass('active');
        $.post('logic/tasks.php', {
            'action': 'Mytask',
            'dataType': "json"
        }).done(GetUsertaskSuccess)
                .fail(Failure);
    });

    //add new task
    $('#btnSaveTask').click(function () {
        var task = $('#txtNewTask').val();
        $.post('logic/tasks.php', {
            'action': 'Insert',
            'itemText': task,
            'dataType': "json"
        }).done(taskSuccess)
                .fail(Failure);
    });
    //add new Comment
    $("body").on("click", ".btn-comment", function () {
        var comment = $("#txtnewcomment-" + this.id).val();
        var item_id = (this.id);
        $.post("logic/comments.php", {
            'action': 'Insert',
            'commentText': comment,
            "itemId": item_id,
            "dataType": "json"
        }).done(commentSuccess).fail(Failure);
    });
    //mark done of the task
    $("body").on("click", ".flag", function () {
        var x = confirm("Are you sure you want to mark done this task?");
        if (x) {
            var item_id = (this.id);
            $.post("logic/tasks.php", {
                'action': 'Markdone',
                "itemId": item_id,
                "dataType": "json"
            }).done(markdoneSuccess).fail(Failure);
        }
        else{
            return false;
        }
    });
    //deleting task
    $("body").on("click", ".trash", function () {
        var x = confirm("Are you sure you want to delete this task?");
        if (x) {
            var item_id = (this.id);
            $.post("logic/tasks.php", {
                'action': 'Delete',
                "itemId": item_id,
                "dataType": "json"
            }).done(deleteTaskSuccess).fail(Failure);
        }
        else{
            return false;
        }
            
    });
    //deleting comment
    $("body").on("click", ".deletecomment", function () {
        var x = confirm("Are you sure you want to delete this comment?");
        if (x) {
            var comment_id = (this.id);
            $.post("logic/comments.php", {
                'action': 'Delete',
                "commentId": comment_id,
                "dataType": "json"
            }).done(deleteCommentSuccess).fail(Failure);
        }
        else{
            return false;
        }
            
    });
});

function GetAlltaskSuccess(data) {
    var tasks = jQuery.parseJSON(data);
    for (var i = 0; i < tasks.length; i++) {
        $('#liTask-' + tasks[i].item_id).show();
    }
}

function GetUsertaskSuccess(data) {
    var tasks = jQuery.parseJSON(data);
    $('[id^=liTask-]').hide();
    for (var i = 0; i < tasks.length; i++) {
        $('#liTask-' + tasks[i].item_id).show();
    }
}

function deleteCommentSuccess(data) {
    var comment_id = jQuery.parseJSON(data);
    $('#liComment-' + comment_id).hide();
}

function deleteTaskSuccess(data) {
    var item_id = jQuery.parseJSON(data);
    $('#liTask-' + item_id).hide();
}

function markdoneSuccess(data) {
   // alert(data);
    var item_id = jQuery.parseJSON(data);
    $('#liTask-' + item_id).hide();
}

function taskSuccess(data) {
    $('#txtNewTask').val('');
    var task = jQuery.parseJSON(data);
    var litag1 = $('<li>')
            .addClass('list-group-item titleBox')
            .attr({'id': 'liTask-' + task[0]['item_id'] + ' '});
    var labeltag = $('<label>')
            .attr({'id': 'lbltask' + task[0]['item_id']});
    labeltag.append(task[0]['item_text']);
    litag1.append(labeltag);
    var spantag1 = $('<span>')
            .addClass('sub-text');
    spantag1.append(' On ' + task[0]['created_date'] + ' By ' + task[0]['username']);
    litag1.append(spantag1);
    var divtag1 = $('<div>')
            .addClass('hideMe')
            .attr({'id': 'main_div_todo' + task[0]['item_id']});
    var inputtag1 = $('<input>')
            .addClass('form-control')
            .attr({'id': 'txttask' + task[0]['item_id'], 'type': 'text', 'value': task[0]['item_text']});
    var inputbtn1 = $('<input>')
            .addClass('form-control')
            .attr({'id': task[0]['item_id'], 'type': 'button', 'value': 'Save'});
    divtag1.append(inputtag1);
    divtag1.append(inputbtn1);
    litag1.append(divtag1);
    var divbtns1 = $("<div>")
            .addClass('pull-right action-buttons');
    var aicon1 = $("<a>")
            .addClass('edit')
            .attr({'id': task[0]['item_id']});
    var span1 = $("<span>")
            .addClass('glyphicon glyphicon-pencil');
    aicon1.append(span1);
    divbtns1.append(aicon1);
    var aicon1 = $("<a>")
            .addClass('trash')
            .attr({'id': task[0]['item_id']});
    var span1 = $("<span>")
            .addClass('glyphicon glyphicon-trash');
    aicon1.append(span1);
    divbtns1.append(aicon1);
    var aicon1 = $("<a>")
            .addClass('flag')
            .attr({'id': task[0]['item_id']});
    var span1 = $("<span>")
            .addClass('glyphicon glyphicon-ok');
    aicon1.append(span1);
    divbtns1.append(aicon1);
    litag1.append(divbtns1);
    var divactionbox = $('<div>')
            .addClass('actionBox');
    var ulcommentList = $('<ul>')
            .attr({'id': 'commentList-' + task[0]['item_id']});
    divactionbox.append(ulcommentList);
    var formtag = $('<div>')
            .addClass('form-inline');
    var divform = $('<div>')
            .addClass('form-group');
    var inputComment = $('<input>')
            .addClass('form-control')
            .attr({'id': 'txtnewcomment-' + task[0]['item_id'], 'type': 'text', 'placeholder': 'Your comments'});
    divform.append(inputComment);
    formtag.append(divform);
    divform = $('<div>').addClass('form-group');
    var btnComment = $('<input>')
            .addClass('btn btn-success btn-comment')
            .attr({'id': task[0]['item_id'], 'type': 'button', 'value': 'Add'});
    divform.append(btnComment);
    formtag.append(divform);
    divactionbox.append(formtag);
    litag1.append(divactionbox);
    $('#TasksList').prepend(litag1);
}

function commentSuccess(data) {
    var comment = jQuery.parseJSON(data);
    var litag1 = $('<li>')
            .attr({'id': 'liComment-' + comment[0]['comment_id']});
    var divtag = $('<div>')
            .addClass('commentText');
    var ptag = $('<p>')
            .addClass('comment')
            .attr({'id': 'comment-' + comment[0]['comment_id']});
    ptag.append(comment[0]['comment_text']);
    divtag.append(ptag);
    var divbtns1 = $("<div>")
            .addClass('pull-right action-buttons');
    var aicon1 = $("<a>")
            .addClass('editcomment')
            .attr({'id': comment[0]['comment_id']});
    var span1 = $("<span>")
            .addClass('glyphicon glyphicon-pencil');
    aicon1.append(span1);
    divbtns1.append(aicon1);
    var aicon1 = $("<a>")
            .addClass('deletecomment')
            .attr({'id': comment[0]['comment_id']});
    var span1 = $("<span>")
            .addClass('glyphicon glyphicon-trash');
    aicon1.append(span1);
    divbtns1.append(aicon1);
    divtag.append(divbtns1);
    var spantag1 = $('<span>')
            .addClass('sub-text');
    spantag1.append(' On ' + comment[0]['created_date'] + ' By ' + comment[0]['username']);
    divtag.append(spantag1);
    litag1.append(divtag);
    $('#commentList-' + comment[0]['item_id']).append(litag1);
    $('#txtnewcomment-' + comment[0]['item_id']).val('');
}

function Failure() {
    alert('Fail');
    //$('#errors').text('Invalid UserName or password...');
}


