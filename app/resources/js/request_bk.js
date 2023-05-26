import './bootstrap';
import jQuery from 'jquery';
window.$ = jQuery;

// $(function () {

//     var isMouseDown = false;
//     var downId;
//     var startId = null;
//     var endId = null;
//     var prefixId;
//     var parentId;
//     var array = {};
//     var isProcessing;

//     var selectedCells = {};

//     // for (let i = 0; i < 7 ; i++){
//     //     array[dates[i]] = {"start_time": null, "end_time": null};
//     // }

//     $("#" + dates[0] + " th")
//     .add($("#" + dates[1] + " th"))
//     .add($("#" + dates[2] + " th"))
//     .add($("#" + dates[3] + " th"))
//     .add($("#" + dates[4] + " th"))
//     .add($("#" + dates[5] + " th"))
//     .add($("#" + dates[6] + " th"))
//     .mousedown(function () {
//         isProcessing = true;
//         downId = this.id;
//         prefixId = this.id.slice( 0, 2 );
//         // console.log(prefixId);
//         startId = null;
//         endId = null;
//         isMouseDown = true;
//         parentId = $(this).parent()[0].id;
//         $("#" + parentId + " th").removeClass("highlighted");

//         $(this).toggleClass("highlighted");

//         var date = this.id.slice(0, 1);
//         var time = this.id.slice(3);
//         if (!(date in selectedCells)) {
//             selectedCells[date] = [];
//         }
//         selectedCells[date].push(time);

//         return false; // prevent text selection
//     })
//     .mouseover(function () {
//         if (isMouseDown && downId[0] === this.id[0]) {
//             $(this).addClass("highlighted");
//         }
//     })
//     .mouseup(function () {
//         isMouseDown = false;

//         if(this.id === downId) {
//             $(this).removeClass("highlighted");
//         }

//     })

//     $(document)
//     .mouseup(function () {
//         isMouseDown = false;

//         if(isProcessing) {
//             for (let i = 0; i <= 60 ; i++){
//                 if($('#' + prefixId + i).hasClass("highlighted")) {
//                     if(startId === null) {
//                         startId = i;
//                     }
//                     endId = i;
//                 }
//             }
//             for (let i = startId; i <= endId ; i++) {
//                 $('#' + prefixId + i).addClass("highlighted");
//             }
//         }
//     })

//     $('#update')
//     .click(function() {

//         $(document).ajaxSend(function() {
//             $("#overlay").fadeIn(300);
//         });

//         isProcessing = false;

//         var dataArray = {};
//         for (var date in selectedCells) {
//             var startId = Math.min.apply(Math, selectedCells[date]);
//             var endId = Math.max.apply(Math, selectedCells[date]);
//             dataArray[date] = {
//                 "start_time": startId,
//                 "end_time": endId
//             };
//         }

//         console.log(dataArray);

//         $.ajaxSetup({
//             headers: {
//               "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             },
//         });
//         $.ajax({
//           //POST通信
//           type: "post",
//           //ここでデータの送信先URLを指定します。
//           url: "/request",
//           dataType: "text",
//           contentType: 'application/json',
//           data: JSON.stringify(array)
        
//         })
//         //通信が成功したとき
//         .then((res) => {
//           console.log(res);
//           setTimeout(function(){
//             $("#overlay").fadeOut(300);
//           },500);
//           alert("更新しました！");
//         //   window.location.href = "/request";
//         })
//         // 通信が失敗したとき
//         .fail((error) => {
//           console.log(error.statusText);
//           setTimeout(function(){
//             $("#overlay").fadeOut(300);
//           },500);
//           alert("更新に失敗しました！");
//         //   window.location.href = "/request";
//         });
//     });
// });


// const bar = document.getElementById("bar");
// const step = 30;

// let isResizingLeft = false;
// let isResizingRight = false;
// let lastLeftPosition = 0;
// let lastRightPosition = 0;

// bar.addEventListener("mousedown", function(e) {
//   if (e.offsetX < 10) {
//     // console.log("offsetX:"+e.offsetX);
//     isResizingLeft = true;
//     lastLeftPosition = e.clientX;
//     // console.log("clientX:"+e.clientX);
//     lastRightPosition = bar.offsetWidth + bar.offsetLeft;
//     // console.log("offsetWidth:"+bar.offsetWidth);
//     // console.log("offsetLeft:"+bar.offsetLeft);
//   } else if (e.offsetX > bar.offsetWidth - 10) {
//     isResizingRight = true;
//     lastRightPosition = e.clientX;
//     lastLeftPosition = bar.offsetLeft;
//   }
// });

// document.addEventListener("mousemove", function(e) {
//   if (isResizingLeft) {
//     const newWidth = lastRightPosition - e.clientX;
//     if (newWidth >= step) {
//       const remainder = newWidth % step; // stepで割った余りを求める
//       const newLeft = e.clientX + remainder; // 新しい左端の位置を求める
//       const adjWidth = newWidth - remainder; // 余りを引いた幅を求める
//       if (adjWidth >= step) { // step以上幅がある場合、棒を動かす
//         bar.style.width = adjWidth + "px";
//         bar.style.left = newLeft + "px";
//       }
//     }
//   }  
//   // 右側をドラッグした場合の処理
//   else if (isResizingRight) {
//     const newWidth = e.clientX - lastLeftPosition;
//     if (newWidth >= step) {
//       const adjWidth = Math.floor(newWidth / step) * step; // stepの倍数に切り捨てる
//       if (adjWidth >= step) { // step以上幅がある場合、棒を動かす
//         bar.style.width = adjWidth + "px";
//       }
//     }
//   }
// });

// document.addEventListener("mouseup", function(e) {
//   isResizingLeft = false;
//   isResizingRight = false;
// });