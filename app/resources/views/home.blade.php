@extends('layout')
@section('title', 'ホーム画面')
@section('script')
    @vite(['resources/sass/home.scss', 'resources/js/app.js'])
@endsection
@section('content')
@if (session('err_msg'))
    <p class="alert alert-danger">
        {{session('err_msg')}}
    </p>
@endif
<div id='calendar'></div>

<!-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js'></script> -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ja',
            navLinks: true,
            navLinkDayClick: function(date) {
                var day;
                day = date.toLocaleDateString().replace(/\//g, '-0').replace(/(-)0(\d{2,})/g, '$1$2');
                var today = new Date();
                var dayOfWeek = today.getDay();
                var startOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - dayOfWeek);
                var twoWeeksLater = startOfWeek.setDate(startOfWeek.getDate() + 21);

                if (new Date(twoWeeksLater) < date) {
                    alert("再来週より後のシフトはまだきまっていません")
                } else {
                    $.ajax({
                      url: "/day/"+day,
                      type: 'GET',
                      success: function(response) {
                        // データベースから情報を取得できた場合は新しいタブで開く
                        var isAdmin = @json($isAdmin);
                        if(isAdmin) {
                            window.open("/shift/"+day, '_blank');
                        } else {
                            window.open("/day/"+day, '_blank');
                        }
                      },
                      error: function() {
                        // データベースから情報を取得できなかった場合はhomeにリダイレクト
                        window.location.href = "/home";
                      }
                    });
                }
            },
            dayCellDidMount: function(info) {
                var today = new Date();
                var dayOfWeek = today.getDay();
                var startOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - dayOfWeek);
                var twoWeeksLater = startOfWeek.setDate(startOfWeek.getDate() + 21);
                var day = info.date;

                // 再来週よりも後の日付はグレーアウトする（クリックしても見れないようにする(未実装)）
                if (day > twoWeeksLater) {
                    info.el.classList.add('gray'); // クリック不可スタイルの適用
                    // if (day.getMonth() == today.getMonth()) {
                    //     var elements = info.el.querySelector('.fc-daygrid-day-number')
                    //     elements.style.opacity = 0.3; // グレーアウト
                    // }
                }

                $('.fc-prev-button, .fc-next-button, .fc-today-button').click(function(){
                    if (day > twoWeeksLater) {
                        info.el.classList.add('gray'); // クリック不可スタイルの適用
                    }
                });
            }
            // dayCellContent: function(arg) {
            //     arg.dayNumberText = arg.dayNumberText.replace('日', ''); // 「日」の言葉を含まない日付のテキストを返す
            // }
        });
        calendar.render();
    });
</script>
@endsection