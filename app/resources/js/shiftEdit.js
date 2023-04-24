import './bootstrap';
import jQuery from 'jquery';
window.$ = jQuery;

$(function () {

    var isMouseDown = false;
    var downId;
    var startId = null;
    var endId = null;
    var breakStartId = null;
    var breakEndId = null;
    var parentId;
    var array = {};
    var count = 0;


    for (let i = 0; i < usersID.length ; i++){
        array[usersID[i]] = {"start_time": null, "end_time": null, "break_start_time": {}, "date":date};
    }

    $('tr').filter(function(){
        if ($.isNumeric(this.id)) {
            return this.id;
        }
    }).children('th')
    .mousedown(function () {
        downId = this.id;
        startId = null;
        endId = null;
        breakStartId = null;
        breakEndId = null;
        isMouseDown = true;
        parentId = $(this).parent()[0].id;

        $(this).toggleClass("highlighted");

        return false; // prevent text selection
    })
    .mouseover(function () {
        if (isMouseDown) {
            $(this).toggleClass("highlighted");
        }
    })

    $(document)
    .mouseup(function () {
        isMouseDown = false;
    })

    $('#update')
    .click(function() {

        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);
        });

        for(let element = 0; element < usersID.length ; element++){
            startId = null;
            endId = null;
            breakStartId = null;
            breakEndId = null;
            array[usersID[element]]["break_start_time"] = {};
            count = 0;
            for (let i = 0; i <= 60 ; i++){
                if($('#' + usersID[element] + "-" + i).hasClass("highlighted")) {
                    if(startId === null) {
                        startId = i;
                    }
                    endId = i;
                    if(count > 0) {
                        array[usersID[element]]["break_start_time"][breakStartId] = count - 1
                        count = 0
                        breakStartId = null;
                    }
                }
                if(!$('#' + usersID[element] + "-" + i).hasClass("highlighted") && startId != null) {
                    if(breakStartId === null) {
                        breakStartId = i;
                    }
                    count += 1;
                }
            }
            array[usersID[element]]["start_time"] = startId;
            array[usersID[element]]["end_time"] = endId;
        };

        console.log(array);

        $.ajaxSetup({
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
          //POST通信
          type: "post",
          //ここでデータの送信先URLを指定します。
          url: "/shift/update",
          dataType: "text",
          contentType: 'application/json',
          data: JSON.stringify(array),

        })
        //通信が成功したとき
        .then((res) => {
          console.log(res);
          setTimeout(function(){
            $("#overlay").fadeOut(300);
          },500);
          alert("更新しました！");
        //   window.location.href = "/request";
        })
        // 通信が失敗したとき
        .fail((error) => {
          console.log(error.statusText);
          setTimeout(function(){
            $("#overlay").fadeOut(300);
          },500);
          alert("更新に失敗しました！");
        //   window.location.href = "/request";
        });
    });
});