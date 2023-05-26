import './bootstrap';
import jQuery from 'jquery';
window.$ = jQuery;

$(function () {

    var isMouseDown = false;
    var downId;
    var startId = null;
    var endId = null;
    var prefixId;
    var parentId;
    var array = {};
    var isProcessing;

    for (let i = 0; i < 7 ; i++){
        array[dates[i]] = {"start_time": null, "end_time": null};
    }

    $("#" + dates[0] + " th")
    .add($("#" + dates[1] + " th"))
    .add($("#" + dates[2] + " th"))
    .add($("#" + dates[3] + " th"))
    .add($("#" + dates[4] + " th"))
    .add($("#" + dates[5] + " th"))
    .add($("#" + dates[6] + " th"))
    .mousedown(function () {
        isProcessing = true;
        downId = this.id;
        prefixId = this.id.slice( 0, 2 );
        // console.log(prefixId);
        startId = null;
        endId = null;
        isMouseDown = true;
        parentId = $(this).parent()[0].id;
        $("#" + parentId + " th").removeClass("highlighted");

        $(this).toggleClass("highlighted");

        return false; // prevent text selection
    })
    .mouseover(function () {
        if (isMouseDown && downId[0] === this.id[0]) {
            $(this).addClass("highlighted");
        }
    })
    .mouseup(function () {
        isMouseDown = false;

        if(this.id === downId) {
            $(this).removeClass("highlighted");
        }

    })

    $(document)
    .mouseup(function () {
        isMouseDown = false;

        if(isProcessing) {
            for (let i = 0; i <= 60 ; i++){
                if($('#' + prefixId + i).hasClass("highlighted")) {
                    if(startId === null) {
                        startId = i;
                    }
                    endId = i;
                }
            }
            for (let i = startId; i <= endId ; i++) {
                $('#' + prefixId + i).addClass("highlighted");
            }
        }
    })

    $('#update')
    .click(function() {

        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);
        });

        isProcessing = false;

        for (let j = 0; j < 7 ; j++){
            startId = null;
            endId = null;
            for (let i = 0; i <= 60 ; i++){
                if($('#' + j + "-" + i).hasClass("highlighted")) {
                    if(startId === null) {
                        startId = i;
                    }
                    endId = i;
                }
            }
            array[dates[j]]["start_time"] = startId;
            array[dates[j]]["end_time"] = endId;
        }

        $.ajaxSetup({
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
          //POST通信
          type: "post",
          //ここでデータの送信先URLを指定します。
          url: "/request",
          dataType: "text",
          contentType: 'application/json',
          data: JSON.stringify(array)
        
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