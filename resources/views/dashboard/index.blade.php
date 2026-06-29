@php
    use App\Models\Settings;$title = 'Dashboard';
    $settings = Settings::first();
@endphp
@section('title')
    {{$title}}
@endsection
@extends('layout')
@section('main-content')
    <h3 class="mb-3">Today's Statistics</h3>
    <div class="row align-items-center g-6 mb-3">
        <div class="col-12 col-md-auto">
            <a href="{{route('leaveRequest.index')}}">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                                    <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                            class="fa-solid fa-square fa-stack-2x text-success-300"
                                            data-fa-transform="down-4 rotate--10 left-4"></span><span
                                            class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                            data-fa-transform="up-4 right-3 grow-2"></span><span
                                            class="fa-stack-1x fa-solid fa-sign-out-alt text-success "
                                            data-fa-transform="shrink-2 up-8 right-6"></span></span>
                        <div class="ms-3">
                            <h4 class="mb-0" id="leaverequestcount">
                                {{$counts['leaveRequests']}}
                            </h4>
                            <p class="text-800 fs--1 mb-0">Leave Requests</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-auto">
            <a href="{{route('expenseRequest.index')}}">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                                    <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                            class="fa-solid fa-square fa-stack-2x text-danger-300"
                                            data-fa-transform="down-4 rotate--10 left-4"></span><span
                                            class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100"
                                            data-fa-transform="up-4 right-3 grow-2"></span><span
                                            class="fa-stack-1x fa-solid fa-xmark text-danger "
                                            data-fa-transform="shrink-2 up-8 right-6"></span></span>
                        <div class="ms-3">
                            <h4 class="mb-0" id="expenserequestcount">
                                {{$counts['expenseRequests']}}
                            </h4>
                            <p class="text-800 fs--1 mb-0">Expense Requests</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-auto">
            <a href="{{route('visit.index')}}">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                                    <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                            class="fa-solid fa-square fa-stack-2x text-warning-300"
                                            data-fa-transform="down-4 rotate--10 left-4"></span><span
                                            class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                            data-fa-transform="up-4 right-3 grow-2"></span><span
                                            class="fa-stack-1x fa-solid fa-users text-warning "
                                            data-fa-transform="shrink-2 up-8 right-6"></span></span>
                        <div class="ms-3">
                            <h4 class="mb-0" id="clientscount">
                                {{$counts['visits']}}
                            </h4>
                            <p class="text-800 fs--1 mb-0">Visits</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-auto">
            <a href="#">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                class="fa-solid fa-square fa-stack-2x text-danger-300"
                                data-fa-transform="down-4 rotate--10 left-4"></span><span
                                class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100"
                                data-fa-transform="up-4 right-3 grow-2"></span><span
                                class="fa-stack-1x fa-solid fa-list text-danger "
                                data-fa-transform="shrink-2 up-8 right-6"></span></span>
                        <div class="ms-3">
                            <h4 class="mb-0">
                                {{$counts['expenseRequests']}}
                            </h4>
                            <p class="text-800 fs--1 mb-0">Form Submissions</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-auto">
            <a href="#">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                class="fa-solid fa-square fa-stack-2x text-warning-300"
                                data-fa-transform="down-4 rotate--10 left-4"></span><span
                                class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                data-fa-transform="up-4 right-3 grow-2"></span><span
                                class="fa-stack-1x fa-solid fa-list text-warning "
                                data-fa-transform="shrink-2 up-8 right-6"></span></span>
                        <div class="ms-3">
                            <h4 class="mb-0">
                                {{$counts['leaveRequests']}}
                            </h4>
                            <p class="text-800 fs--1 mb-0">Tasks</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-auto">
            <a href="#">
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                class="fa-solid fa-square fa-stack-2x text-warning-300"
                                data-fa-transform="down-4 rotate--10 left-4"></span><span
                                class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                data-fa-transform="up-4 right-3 grow-2"></span><span
                                class="fa-stack-1x fa-solid fa-box text-warning "
                                data-fa-transform="shrink-2 up-8 right-6"></span></span>
                        <div class="ms-3">
                            <h4 class="mb-0">
                                {{$counts['leaveRequests']}}
                            </h4>
                            <p class="text-800 fs--1 mb-0">Orders</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row gx-6">
        <div class="col-12 col-xl-6">
            <div>
                <div class="row align-items-center g-6 mb-3">
                    {{-- <div class="col-12 col-md-auto">
                         <a href="{{route('leaveRequest.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-success-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-sign-out-alt text-success "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="leaverequestcount">
                                             {{$counts['leaveRequests']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Leave Requests</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>

                     <div class="col-12 col-md-auto">
                         <a href="{{route('visit.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-warning-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-users text-warning "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="clientscount">
                                             {{$counts['visits']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Visits</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>
                     <div class="col-12 col-md-auto">
                         <a href="{{route('expenseRequest.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-danger-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-xmark text-danger "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="expenserequestcount">
                                             {{$counts['expenseRequests']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Expense Requests</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>
                     <div class="col-12 col-md-auto">
                         <a href="{{route('employee.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-danger-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-xmark text-danger "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="employeescount">
                                             {{$counts['totalEmployees']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Total Employees</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>--}}
                </div>
                <div class="p-1">
                    <div id="attendancechart" class="mt-3">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="mx-n4 mx-lg-n6 ms-xl-0">
                <div class="card w-100">
                    <div class="p-3">Recent Checkins</div>
                    <div class="card-body w-100">
                        <div class="table-responsive scrollbar" style="height:700px">
                            <table class="table table-striped fs--1">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Attendance</th>
                                    <th>Last Update</th>
                                    <th>Location</th>
                                </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gap-4 card mt-3">
        <div class="card-body">
            <div id="teamchart"></div>
        </div>
    </div>

    {{-- <div class="row gx-6">
         <div class="col-12 col-xl-12">
             <div>
                 <div class="row align-items-center g-6 mb-3">
                     <div class="col-12 col-md-auto">
                         <a href="{{route('leaveRequest.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-success-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-sign-out-alt text-success "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="leaverequestcount">
                                             {{$counts['leaveRequests']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Leave Requests</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>

                     <div class="col-12 col-md-auto">
                         <a href="{{route('visit.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-warning-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-users text-warning "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="clientscount">
                                             {{$counts['visits']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Visits</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>
                     <div class="col-12 col-md-auto">
                         <a href="{{route('expenseRequest.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-danger-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-xmark text-danger "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="expenserequestcount">
                                             {{$counts['expenseRequests']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Expense Requests</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>
                     <div class="col-12 col-md-auto">
                         <a href="{{route('employee.index')}}">
                             <div class="card p-3">
                                 <div class="d-flex align-items-center">
                                     <span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span
                                             class="fa-solid fa-square fa-stack-2x text-danger-300"
                                             data-fa-transform="down-4 rotate--10 left-4"></span><span
                                             class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100"
                                             data-fa-transform="up-4 right-3 grow-2"></span><span
                                             class="fa-stack-1x fa-solid fa-xmark text-danger "
                                             data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                     <div class="ms-3">
                                         <h4 class="mb-0" id="employeescount">
                                             {{$counts['totalEmployees']}}
                                         </h4>
                                         <p class="text-800 fs--1 mb-0">Total Employees</p>
                                     </div>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
                 <div class="p-1">
                     <div id="attendancechart">
                     </div>
                 </div>
             </div>
         </div>
     </div>



     <div class="col-12 col-xl-6">
         <div class="mx-n4 mx-lg-n6 ms-xl-0">
             <div class="card w-100">
                 <h5 class="p-3">Recent Checkins</h5>
                 <div class="card-body w-100">
                     <div class="table-responsive scrollbar" style="height:700px">
                         <table class="table table-striped fs--1">
                             <thead>
                             <tr>
                                 <th>Name</th>
                                 <th>Attendance</th>
                                 <th>Last Update</th>
                                 <th>Location</th>
                             </tr>
                             </thead>
                             <tbody id="tableBody">
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row gap-4 card mt-3">
         <div class="card-body">
             <div id="teamchart"></div>
         </div>
     </div>--}}
@endsection

@section('styles')

@endsection

@section('scripts')
    <script src="{{asset('vendors/apexcharts-bundle/js/apexcharts.min.js')}}"></script>

    <script>
        $(document).ready(function () {

            setupCharts();

            let isTeamView = getCookie("team_wise_view");

            if (isTeamView) {
                //Settings Title
                $('#attendanceReportType').text('Attendance Report (Team View)');
                $('#teamView').text('AdminView');
                loadData();
                loadTeamWiseData();
                console.log('Team View');
            } else {
                //Settings Title
                $('#attendanceReportType').text('Attendance Report (Admin View)');
                $('#teamView').text('TeamView');
                loadData();
                console.log('Admin View');
            }

            $("#teamView").click(function () {

                isTeamView = getCookie("team_wise_view");

                if (isTeamView) {
                    setCookie("team_wise_view", false, 7);
                    $('#attreport').html("");
                    $('#teamView').text('TeamView');
                    loadData();
                } else {
                    setCookie("team_wise_view", true, 7);
                    $('#attreport').html("");
                    $('#teamView').text('AdminView');
                    loadTeamWiseData();
                }
            });
        });


        function setupCharts() {
            loadAttendanceChart();
            //loadAdminPieChart();
            loadTeamAttendanceChart();
        }


        function loadTeamWiseData() {
            $.ajax({
                type: "GET",
                url: '{{route('dashboard.getTeamWiseCountAjax')}}',
                success: function (response) {

                    $('#attreport').html("");

                    if (response.length > 0) {
                        for (let i = 0; i < response.length; i++) {
                            addTeamItem(response[i]);
                        }
                    }
                },
                failure: function (response) {
                    console.log(response.responseText);
                },
                error: function (response) {
                    console.log(response.responseText);
                }

            });
        }


        function loadData() {
            $.ajax({
                type: "GET",
                url: '{{route('dashboard.getRecentCheckInsAjax')}}',
                success: function (response) {

                    var data = response;

                    let isTeamView = getCookie("team_wise_view");
                    if (isTeamView) {

                    } else {
                        $('#attreport').html("");
                        $('#attreport').html(`  <div class="row">
                                             <div class="col-6" id="username"></div>
                                             <div class="col-6">
                                                      <div class="d-flex align-items-center justify-content-around gap-3">
                                                     <h5><span class="badge rounded-pill bg-success" id="activecount">0</span></h5>
                                                     <h5><span class="badge rounded-pill bg-warning" id="inactivecount">0</span></h5>
                                                     <h5><span class="badge rounded-pill bg-danger" id="offlinecount">0</span></h5>
                                                     <h5><span class="badge rounded-pill bg-primary" id="nwcount">0</span></h5>
                                                 </div>
                                             </div>
                                         </div>`);
                        $('#username').text(data.user);
                        $('#activecount').text(data.onlineCount);
                        $('#offlinecount').text(data.offlineCount);
                        $('#nwcount').text(data.notWorkingCount);
                    }

                    loadTable(data.employeeItems);
                },
                failure: function (response) {
                    console.log(response.responseText);
                },
                error: function (response) {
                    console.log(response.responseText);
                }
            });
        }


        function loadTable(items) {
            var selector = '#tableBody';

            $(selector).html('');

            items.forEach(function (item, index) {


                var att = '';
                if (item.attendanceInAt.length !== 0) {
                    att = 'In at : ' + item.attendanceInAt;
                }

                if (item.attendanceOutAt.length !== 0) {
                    att += '\n Out at : ' + item.attendanceOutAt;
                }

                if (item.attendanceInAt.length === 0 && item.attendanceOutAt.length === 0) {
                    att = '<span class="badge badge-phoenix fs--2 badge-phoenix-warning"><span class="badge-label">Not checked in</span><span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span></span>';
                }

                var location = 'https://www.google.com/maps/search/?api=1&query=' + item.latitude + ',' + item.longitude;

                var content = ` <tr>
                                                 <td>   <img src="/img/user.png" width="40" class="user-img" alt=""> ${item.name}</td>
                                         <td>${att}</td>
                                         <td>${item.lastUpdate}</td>
                                                     <td> <a href='${location}' target="_blank">Open in maps</a></td>
                                     </tr>`;
                $(selector).append(content);
            });
        }

        function addTeamItem(item) {
            var content = `<div class="row align-items-start">
                             <div class="col-md-6" >${item.name}</div>
                               <div class="col-md-6">
                                 <div class="d-flex align-items-center justify-content-around gap-3">
                                    <h5><span class="badge rounded-pill bg-success" ">${item.onlineCount}</span></h5>
                                    <h5><span class="badge rounded-pill bg-warning" >${item.inActiveCount}</span></h5>
                                    <h5><span class="badge rounded-pill bg-danger" >${item.offlineCount}</span></h5>
                                    <h5><span class="badge rounded-pill bg-primary" >${item.notWorkingCount}</span></h5>
                                  </div>
                              </div>
                          </div>`;

            $('#attreport').append(content);
        }

        function loadAttendanceChart() {

            $.ajax({
                type: "GET",
                url: '{{route('dashboard.getPresentDataAjax')}}',
                success: function (response) {
                    var data = response;

                    let dates = data.map(a => a.date);

                    let present = data.map(a => a.presentCount);

                    let absent = data.map(a => a.absentCount);

                    renderAttendanceChart(dates, present, absent);
                },
                failure: function (response) {
                    console.log(response.responseText);
                },
                error: function (response) {
                    console.log(response.responseText);
                }
            });

        }

        function loadAdminPieChart() {
            $.ajax({
                type: "GET",
                url: "Dashboard/GetTodaysAttendanceStatusAjax",
                success: function (response) {
                    var data = response;
                    renderAdminChart(data.presentCount, data.absentCount, data.onLeaveCount);
                },
                failure: function (response) {
                    console.log(response.responseText);
                },
                error: function (response) {
                    console.log(response.responseText);
                }
            });
        }

        function loadTeamAttendanceChart() {
            $.ajax({
                type: "GET",
                url: '{{route('dashboard.getTeamWiseAttendanceAjax')}}',
                success: function (response) {
                    console.log(response);
                    var data = response;

                    let teams = data.map(x => x.name);

                    let present = data.map(x => x.present);

                    let absent = data.map(x => x.absent);

                    let onLeave = data.map(x => x.onLeave);

                    renderTeamChart(teams, present, absent, onLeave);
                },
                failure: function (response) {
                    console.log(response.responseText);
                },
                error: function (response) {
                    console.log(response.responseText);
                }
            });
        }

        function renderTeamChart(teams, present, absent, onLeave) {
            var options = {
                series: [{
                    name: 'Present',
                    data: present
                }, {
                    name: 'Absent',
                    data: absent
                }, {
                    name: 'On Leave',
                    data: onLeave
                }],
                chart: {
                    foreColor: '#9ba7b2',
                    type: 'bar',
                    height: 360
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                title: {
                    text: 'Team Wise Attendance',
                    align: 'left',
                    style: {
                        fontSize: "16px",
                        color: '#666'
                    }
                },
                colors: ["#4CAF50", "#D32F2F", "#6c757d"],
                xaxis: {
                    categories: teams,
                    // categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                },
                yaxis: {
                    title: {
                        text: 'Count'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " employees"
                        }
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#teamchart"), options);
            chart.render();
        }

        function renderAttendanceChart(dates, present, absent) {
            var options = {
                series: [{
                    name: 'Total Present',
                    data: present
                }, {
                    name: 'Total Absent',
                    data: absent
                }],
                chart: {
                    foreColor: '#9ba7b2',
                    height: 505,
                    type: 'area',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    },
                },
                colors: ["#20388c", '#c41010'],
                title: {
                    text: 'Attendance Status',
                    align: 'left',
                    style: {
                        fontSize: "16px",
                        color: '#666'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 4,
                    colors: ["#3461ff"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: 'Present & Absent Count',
                    },
                },
                xaxis: {
                    type: 'datetime',
                    categories: dates
                },
                tooltip: {
                    x: {
                        format: 'dd/MMM'
                    },
                },
            };
            var chart = new ApexCharts(document.querySelector("#attendancechart"), options);
            chart.render();
        }


        function renderAdminChart(present, absent, onLeave) {
            var options = {
                series: [present, absent, onLeave],
                chart: {
                    foreColor: '#9ba7b2',
                    type: 'pie',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: true
                    },
                },
                title: {
                    text: 'Device Status',
                    align: 'left',
                    style: {
                        fontSize: "16px",
                        color: '#666'
                    }
                },
                colors: ["#4CAF50", "#D32F2F", "#6c757d"],
                labels: ['Online', 'Offline', 'In Active'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 360
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#adminchart"), options);
            chart.render();
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }
    </script>
@endsection
