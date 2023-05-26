<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>希望シフト提出</title>
    <script src="https://unpkg.com/vue@next"></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<style>
    .base {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      justify-content: center;
      margin-top: 50px;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: gray;
      opacity: 0.5;
    }

    .content {
      background-color: white;
      position: relative;
      border-radius: 10px;
      padding: 40px;
    }
</style>
<body>
@include('logout')

<div id="app">
    <div id="gantt-header" class="h-12 p-2 flex items-center">
        <!-- <h1 class="text-xl font-bold">シフト表</h1> -->
        <h1 class="text-sm font-bold">{{$date->format('Y-m-d')}}のシフト</h1>
        <teleport to="#form">
            <div class="base" v-show="show">
                <div class="overlay" v-show="show" @click="show=false">
                </div>
                <div class="content" v-show="show">
                    <h2 class="font-bold">シフト更新</h2>
                    <div class="my-4">
                        <label class="text-xs">日付: @{{form.name}}</label>
                    </div>
                    <div class="my-4">
                        <label class="text-xs">開始時間:</label>
                        <select v-model="form.start_time" class="text-xs border px-4 py-2 rounded-lg">
                            <option v-for="(time,index) in timeScale" :key="index" :value="time.time.replace(':', '')">@{{ time.time }}
                            </option>
                        </select>
                    </div>
                    <div class="my-4">
                        <label class="text-xs">終了時間:</label>
                        <select v-model="form.end_time" class="text-xs border px-4 py-2 rounded-lg">
                            <option v-for="(time,index) in timeScale" :key="index" :value="time.time.replace(':', '')">@{{ time.time }}
                            </option>
                        </select>
                    </div>
                    <div>
                    <button
                        @click="updateUser(form.id)"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-xs flex items-center">
                        <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-xs font-bold text-white">シフトを更新</span>
                    </button>
                    <button 
                        @click="deleteTask(form.id)"
                        class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded-lg flex items-center ml-2">
                        <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="text-xs font-bold text-white">シフトを削除</span>
                    </button>
                    </div>
                </div>
            </div>
        </teleport>
    </div>
    <div id="gantt-content" class="flex">
        <div id="gantt-task" class="border-r">
            <div id="gantt-task-title" class="flex items-center bg-green-600 text-white h-20" ref="task">
                <div class="border-t border-b flex items-center justify-center font-bold text-xs h-full" :style="`width:300px`">日付</div>
            </div>
            <div id="gantt-task-list" class="overflow-y-hidden" :style="`height:${calendarViewHeight}px`">
                <div v-for="(user,index) in displayTasks" :key="index" class="flex h-20 border-b" v-bind:class="{ 'bg-gray-100': index % 2 === 1 }">
                    <div @click="editUser(user)" class="border-r flex items-center font-bold w-48 text-sm pl-2" :style="`width:300px`">@{{user.name}}</div>
                </div>
            </div>    
        </div>
        <div id="gantt-calendar" class="overflow-x-scroll overflow-y-hidden border-l" :style="`width:${calendarViewWidth}px`" ref="calendar">
            <div id="gantt-date" class="h-20">
                <div id="gantt-year-month" class="relative h-20">
                    <div v-for="(time,index) in timeScale.slice(0, timeScale.length - 1)" :key="index">
                        <div v-if="time.time_block_number % blockNumPerHour === 0">
                            <div class="bg-indigo-700 text-white border-b border-r border-t h-20 absolute font-bold text-sm flex items-center justify-center"
                                :style="`width:${blockNumPerHour*block_size}px;
                                left:${blockNumPerHour*time.time_block_number*block_size - time.time_block_number*(blockNumPerHour-1)*block_size}px`">                
                                @{{time.time}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="gantt-height" class="relative">
                    <div v-for="(time,index) in timeScale.slice(0, timeScale.length - 1)" :key="index">
                        <div class="border-r border-b absolute z-10"
                            :style="`width:${block_size}px;left:${time.time_block_number*block_size}px;height:${calendarViewHeight}px`">
                        </div>
                    </div>
                </div>
            </div>
            <div id="gantt-bar-area" class="relative" :style="`width:${calendarViewWidth}px;height:${calendarViewHeight}px`">
                <!-- <div v-for="(bar,index) in taskBars" :key="index">
                    <div class="h-20 border" v-bind:class="{ 'bg-gray-100': index % 2 === 1 }" :style="`width:${scrollWidth}px`">
                        <div :style="bar.style" class="rounded-lg absolute h-10 bg-yellow-100 z-20" @mousedown="mouseDownMove(bar.user)" v-if="bar.user.start_time && bar.user.end_time != '' ">
                            <div class="w-full h-full" style="pointer-events: none;">
                            </div>
                            <div class="absolute w-2 h-2 bg-gray-300 border border-black" style="top:14px;left:0px;cursor:col-resize" @mousedown.stop="mouseDownResize(bar.user,'left')">
                            </div>
                            <div class="absolute w-2 h-2 bg-gray-300 border border-black" style="top:14px;right:0px;cursor:col-resize" @mousedown.stop="mouseDownResize(bar.user,'right')">
                            </div>
                        </div>
                    </div>
                </div> -->
                <div v-for="(bar,index) in taskBars" :key="index">
                    <div class="h-20 border" v-bind:class="{ 'bg-gray-100': index % 2 === 1 }" :style="`width:${scrollWidth}px`">
                        <div :style="bar.style" class="rounded-lg absolute h-10 bg-yellow-100 z-20" @mousedown="mouseDownMove(bar.user)" v-if="bar.user.start_time && bar.user.end_time !== '' ">
                            <div class="w-full h-full" style="pointer-events: none;">
                            </div>
                            <div class="absolute w-2 h-2 bg-gray-300 border border-black" style="top:14px;left:0px;cursor:col-resize" @mousedown.stop="mouseDownResize(bar.user,'left')">
                            </div>
                            <div class="absolute w-2 h-2 bg-gray-300 border border-black" style="top:14px;right:0px;cursor:col-resize" @mousedown.stop="mouseDownResize(bar.user,'right')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
</div>
<div id="form" class="absolute z-30">
</div>
</body>
<script>

    const app = Vue.createApp({
        data(){
            return {
                block_size: 30,
                block_number: 0,
                inner_width: '',
                inner_height: '',
                task_width: '',
                task_height: '',

                timeScale:[],
                //1時間単位で設定する
                start_time: '0900',
                end_time: '2400',
                time_block_number: 0,
                //1時間を何分毎に区切るかを設定（15分もしくは30分を設定）
                minuteIntervals: 15,
                blockNumPerHour: '',
                position_id: 0,

                dragging:false,
                pageX:'',
                elememt:'',
                left:'',
                user_id:'',

                width:'', 
                leftResizing:false,
                rightResizing:false,

                scrollWidth:'',

                show:false,

                form: {
                    id: '',
                    name: '',
                    start_time: '',
                    end_time: '',
                },

                users: [
                    {
                        id: 1,
                        name: '2023-5-11',
                        start_time: '0900',
                        end_time: '2400',
                    },
                ]

            }
        },
        methods:{
            getTimeTable() {
                this.blockNumPerHour = 60 / this.minuteIntervals;
                let openMin = this.convertTimesToMins(this.start_time);
                let closeMin = this.convertTimesToMins(this.end_time);
                // let workingMin = closeMin - openMin - this.minuteIntervals;
                let workingMin = closeMin - openMin;
                let scaleDiv =  workingMin / this.minuteIntervals;
                let time_block_number = 0;
                for(let i=0; i <= scaleDiv; i++) {
                    let time = String((openMin + (i * this.minuteIntervals))/60);
                    this.timeScale.push({
                        time: this.convertMinsToHours(time),
                        time_block_number: time_block_number,
                        // requiredPeopleNum: 5,
                    })
                    time_block_number++;
                }
            },
            convertTimesToMins(time) {
                let hour = parseInt(String(time).slice(0, -2));
                let min = parseInt(String(time).slice(-2));
                let sumMins = hour * 60 + min;
                return sumMins;
            },
            convertMinsToHours(time) {
                switch (true){
                    case /\.25$/.test(time):
                        return time.replace(".25", ":15");
                        break;
                    case /\.5$/.test(time):
                        return time.replace(".5", ":30");
                        break;
                    case /\.75$/.test(time):
                        return time.replace(".75", ":45");
                        break;
                    default:
                        return time + ":00";
                }
            }, 
            getWindowSize() {
                this.inner_width = window.innerWidth;
                this.inner_height = window.innerHeight;
                this.task_width = this.$refs.task.offsetWidth;
                this.task_height = this.$refs.task.offsetHeight;
            },
            windowSizeCheck() {
                let height = this.users.length - this.position_id
                if (event.deltaY > 0 && height * 80 > this.calendarViewHeight) {
                    this.position_id++
                } else if (event.deltaY < 0 && this.position_id !== 0) {
                    this.position_id--
                }
            },
            mouseDownMove(user){
                this.dragging = true;
                this.pageX = event.pageX;
                this.element = event.target;
                this.left = event.target.style.left;
                this.original_left = event.target.style.left;
                this.width = event.target.style.width;
                this.user_id = user.id;
                event.preventDefault();
            },
            mouseMove() {
                if (this.dragging) {
                    let diff = this.pageX - event.pageX;
                    this.element.style.left = `${parseInt(this.left.replace('px', '')) - diff}px`;
                }
                event.preventDefault();
            },
            stopDrag(){
                if (this.dragging) {
                    let diff = this.pageX - event.pageX
                    let times = Math.ceil(diff / this.block_size)
                    if (times !== 0) {
                        let user = this.users.find(user => user.id === this.user_id);
                        let start_time = this.convertTimesToMins(user.start_time) - times * this.minuteIntervals;
                        let end_time = this.convertTimesToMins(user.end_time) - times * this.minuteIntervals;
                        if (end_time > this.convertTimesToMins(this.end_time) || start_time < this.convertTimesToMins(this.start_time)) {
                            this.element.style.left = `${this.left.replace('px', '')}px`;
                        } else {
                            user['start_time'] = this.convertMinsToHours(String(start_time/60)).replace(":", "");
                            user['end_time'] = this.convertMinsToHours(String(end_time/60)).replace(":", "");
                        }
                    } else {
                        this.element.style.left = `${this.left.replace('px', '')}px`;
                    }
                }
                if (this.leftResizing) {
                    let diff = this.pageX - event.pageX;
                    if (diff < this.left.replace('px', '')) {
                        let times = Math.ceil(diff / this.block_size)
                        if (times !== 0) {
                            let user = this.users.find(user => user.id === this.user_id);
                            let start_time = this.convertTimesToMins(user.start_time) - times * this.minuteIntervals;
                            let end_time = this.convertTimesToMins(user.end_time);
                            if ((end_time - start_time) / this.minuteIntervals <= 0) {
                                user['start_time'] = this.convertMinsToHours(String(end_time/60)).replace(":", "");
                            } else {
                                user['start_time'] = this.convertMinsToHours(String(start_time/60)).replace(":", "");
                            }
                        } else {
                            this.element.style.width = this.width;
                            this.element.style.left = `${this.left.replace('px', '')}px`;
                        }
                    } else {
                        this.element.style.width = this.width;
                        this.element.style.left = `${this.left.replace('px', '')}px`;
                    }
                }
                if (this.rightResizing) {
                    let diff = this.pageX - event.pageX;
                    let times = Math.ceil(diff / this.block_size)
                    // console.log("times: "+times)
                    if (times === 1) {
                        this.element.style.width = this.width;
                    } else if (times <= 2) {
                    // } else if (times < 1) {
                        let scrollWidth = Math.abs(diff) + parseInt(this.width.replace('px', '')) + parseInt(this.left.replace('px', ''));
                        if (scrollWidth < this.scrollWidth) {
                            times--;
                            let user = this.users.find(user => user.id === this.user_id);
                            let end_time = this.convertTimesToMins(user.end_time) - times * this.minuteIntervals;
                            user['end_time'] = this.convertMinsToHours(String(end_time/60)).replace(":", "");
                        } else {
                            this.element.style.width = this.width;
                        }
                    } else {
                        let user = this.users.find(user => user.id === this.user_id);
                        let start_time = this.convertTimesToMins(user.start_time);
                        let end_time = this.convertTimesToMins(user.end_time) - times * this.minuteIntervals;
                        if ((end_time - start_time) / this.minuteIntervals < 0) {
                            user['end_time'] = this.convertMinsToHours(String(start_time/60)).replace(":", "");
                        } else {
                            user['end_time'] = this.convertMinsToHours(String(end_time/60)).replace(":", "");
                        }
                    }
                }
                this.dragging = false;
                this.leftResizing = false;
                this.rightResizing = false;
                // let user = this.users.find(user => user.id === this.user_id);
                // console.log("最終的な開始時間: "+user.start_time)
                // console.log("最終的な終了時間: "+user.end_time)
            },
            mouseDownResize(user, direction) {
                direction === 'left' ? this.leftResizing = true : this.rightResizing = true;
                this.pageX = event.pageX;
                this.width = event.target.parentElement.style.width;
                this.left = event.target.parentElement.style.left;
                this.element = event.target.parentElement;
                this.user_id = user.id
                // console.log("mouseDownResize時pagex:"+this.pageX)
            },
            mouseResize() {
                if (this.leftResizing) {
                    let diff = this.pageX - event.pageX
                    if (parseInt(this.width.replace('px', '')) + diff > this.block_size) {
                        this.element.style.width = `${parseInt(this.width.replace('px', '')) + diff}px`
                        this.element.style.left = `${this.left.replace('px', '') - diff}px`;
                    }
                }
                if (this.rightResizing) {
                    // console.log("mouseResize時pagex:"+event.pageX)
                    let diff = this.pageX - event.pageX;
                    // console.log(diff)
                    if (parseInt(this.width.replace('px', '')) - diff > this.block_size) {
                        this.element.style.width = `${parseInt(this.width.replace('px', '')) - diff}px`
                    }
                }
                event.preventDefault();
            },
            getScrollWidth() {
                this.scrollWidth = this.$refs.calendar.scrollWidth;
            },
            editUser(user){
                this.show = true;
                // console.log(user)
                Object.assign(this.form, user);
            },
            updateUser(id) {
                let user = this.users.find(user => user.id === id);
                Object.assign(user, this.form);
                this.form = {}
                this.show = false;
            },
            deleteTask(id) {
                let user = this.users.find(user => user.id === id);
                user['start_time'] = '';
                user['end_time'] = '';
                this.form = {}
                this.show = false;
            },
        },
        mounted() {
            this.getTimeTable();
            this.getWindowSize();
            this.getScrollWidth();
            this.$nextTick(() => {
                this.getScrollWidth();
            });
            window.addEventListener('resize', this.getWindowSize);
            window.addEventListener('wheel', this.windowSizeCheck);
            window.addEventListener('mousemove', this.mouseMove);
            window.addEventListener('mouseup', this.stopDrag);
            window.addEventListener('mousemove', this.mouseResize);
            console.log(this.timeScale)
        },
        computed: {
            calendarViewWidth() {
                return this.inner_width - this.task_width;
            },
            calendarViewHeight() {
                return this.inner_height - this.task_height - 48 - 20;
            },
            taskBars() {
                let top = 20;
                let left;
                let between;
                let start;
                let style;
                return this.displayTasks.map(user => {
                    style = {}
                    let time_from = this.convertTimesToMins(user.start_time);
                    let time_to = this.convertTimesToMins(user.end_time);
                    between = (time_to - time_from) / this.minuteIntervals;
                    start = (time_from - this.convertTimesToMins(this.start_time)) / this.minuteIntervals;
                    left = start * this.block_size;
                    style = {
                        top: `${top}px`,
                        left: `${left}px`,
                        width: `${this.block_size * between}px`,
                    }
                    top = top + 80;
                    return {
                        style,
                        user,
                    }
                })
            },
            displayTasks() {
                let display_task_number = Math.floor(this.calendarViewHeight / 80);
                return this.users.slice(this.position_id, this.position_id + display_task_number);
            },
        }
    }).mount('#app')



</script>
</html>
