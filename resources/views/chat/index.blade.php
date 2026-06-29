@php
    $title = 'Chats'
@endphp
@section('title')
    {{$title}}
@endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{$title}}</h4>
            </div>
        </div>
        <div class="col">

        </div>
    </div>


    <div class="chat d-flex phoenix-offcanvas-container pt-1 mt-n1 mb-9">
        <div class="card p-3 p-xl-1 mt-xl-n1 chat-sidebar me-3 phoenix-offcanvas phoenix-offcanvas-start"
             id="chat-sidebar">
            <button class="btn d-none d-sm-block d-xl-none mb-2" data-bs-toggle="modal"
                    data-bs-target="#chatSearchBoxModal"><span
                    class="fa-solid fa-magnifying-glass text-600 fs-1"></span></button>
            <div class="d-none d-sm-block d-xl-none mb-5">
                <button class="btn w-100 mx-auto" type="button" data-bs-toggle="dropdown" data-boundary="window"
                        aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                        class="fa-solid fa-bars text-600 fs-1"></span></button>
                <ul class="dropdown-menu dropdown-menu-end p-0">
                    <li><a class="dropdown-item" href="#!">All</a></li>
                </ul>
            </div>
            <h5>Team Chat</h5>
            <ul class="nav nav-phoenix-pills mb-5 d-sm-none d-xl-flex" id="contactListTab"
                data-chat-thread-tab="data-chat-thread-tab" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link cursor-pointer active" data-bs-toggle="tab"
                                                            data-chat-thread-list="all" role="tab" aria-selected="true">All
                        Teams</a></li>
            </ul>
            <div class="scrollbar">
                <div class="tab-content" id="contactListTabContent">
                    <div data-chat-thread-tab-content="data-chat-thread-tab-content">
                        <ul class="nav chat-thread-tab flex-column list">
                            @foreach ($teams as $team)
                                <li class="nav-item unread mb-1" role="presentation">
                                    <a class="nav-link d-flex align-items-center justify-content-center p-2"
                                       id="@team.TeamId" onclick="loadChat('{{$team->id}}','{{$team->name}}')">
                                        <div
                                            class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2">
                                            <img class="rounded-circle border border-2 border-white"
                                                 src="{{asset('img/user.png')}}" alt=""/>
                                        </div>
                                        <div class="flex-1 d-sm-none d-xl-block">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="text-900 fw-normal name text-nowrap">{{$team->name}}</h5>
                                                <p class="fs--2 text-600 mb-0 text-nowrap">
                                                    Members {{$team->users->count()}}</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="fs--1 mb-0 line-clamp-1 text-600 message">{{$team->description}}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-content tab-content flex-1">
            <div class="tab-pane h-100 fade active show" id="tab-thread-1" role="tabpanel"
                 aria-labelledby="tab-thread-1">
                <div class="card flex-1 h-100 phoenix-offcanvas-container">
                    <div class="card-header p-3 p-md-4 d-flex flex-between-center">
                        <div class="d-flex align-items-center">
                            <button class="btn ps-0 pe-2 text-700 d-sm-none" data-phoenix-toggle="offcanvas"
                                    data-phoenix-target="#chat-sidebar"><span class="fa-solid fa-chevron-left"></span>
                            </button>
                            <div class="d-flex flex-column flex-md-row align-items-md-center">
                                <button
                                    class="btn fs-1 fw-semi-bold text-1100 d-flex align-items-center p-0 me-3 text-start">
                                    <span class="line-clamp-1" id="teamtitle">Select a team</span></button>
                                <p class="fs--1 mb-0 me-2"><span
                                        class="fa-solid fa-circle text-success fs--3 me-2"></span>Active now</p>
                            </div>
                        </div>
                        <div class="d-flex">
                        </div>
                    </div>
                    <div class="card-body p-3 p-sm-4 scrollbar" id="chatcontent">
                        Please select a team to begin the chat
                    </div>
                    <div class="card-footer" style="display:none;" id="chatfooter">

                        <div class="d-flex justify-content-between align-items-end">
                            <input class="form-control chat-textarea outline-none scrollbar mb-1 mr-3" id="message"
                                   name="message" contenteditable="true"/>
                            <div>
                                <a class="btn btn-primary fs--2" onclick="sendMessage()">Send<span
                                        class="fa-solid fa-paper-plane ms-1"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var selectedTeamId;

        $(document).ready(function () {
            $('#chatfooter').hide();
            $('#message').keypress(function (e) {
                var key = e.which;
                if (key === 13)  // the enter key code
                {
                    sendMessage();
                    return false;
                }
            });
        });

        function loadChat(teamId, teamName) {
            //make it active
            $('#' + teamId).css('active');

            $('#chatfooter').show();

            selectedTeamId = teamId;
            $('#teamtitle').text(teamName)

            $.ajax({
                'csrf-token': '{{csrf_token()}}',
                url: "{{route('chat.getTeamChat','')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    teamId: teamId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    generateChatItem(response)
                },
                failure: function (response) {
                    console.log(response.responseText);
                },
                error: function (response) {
                    console.log(response.responseText);
                }
            })
        }

        function generateChatItem(data) {

            var selector = $('#chatcontent');

            if (data.length === 0) {
                selector.html(`	<p class="text-center">No messages!</p>`);
            } else {
                selector.html('');
            }


            data.forEach(function (item) {
                if (item.type == 'text') {
                    var messageString = item.message.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
                    if (item.isYou) {
                        selector.append(` <div class="d-flex chat-message">
						<div class="d-flex mb-2 justify-content-end flex-1">
							<div class="w-100 w-xxl-75">
								<div class="d-flex flex-end-center hover-actions-trigger">
									<div class="chat-message-content me-2">
										<div class="mb-1 sent-message-content light bg-primary rounded-2 p-3 text-white">
													<p class="mb-0">${messageString}</p>
										</div>
									</div>
								</div>
								<div class="text-end">
									<p class="mb-0 fs--2 text-600 fw-semi-bold">${item.time}</p>
								</div>
							</div>
						</div>
					</div>`);
                    } else {
                        selector.append(`    <div class="d-flex chat-message">
						<div class="d-flex mb-2 flex-1">
							<div class="w-100 w-xxl-75">
								<div class="d-flex hover-actions-trigger">
									<div class="avatar avatar-m me-3 flex-shrink-0"><img class="rounded-circle" src="/img/user.png" alt="" /></div>
									<div class="chat-message-content received me-2">
									${item.from}
										<div class="mb-1 received-message-content border rounded-2 p-3">
													<p class="mb-0">${messageString}</p>
										</div>
									</div>

								</div>
								<p class="mb-0 fs--2 text-600 fw-semi-bold ms-7">${item.time}</p>
							</div>
						</div>
					</div>`);

                        //selector.append(`
                        //			<div class="chat-content-leftside">
                        //		<div class="d-flex">
                        //			<img src="/img/user.png" width="48" height="48" class="rounded-circle" alt="" />
                        //			<div class="flex-grow-1 ms-2">
                        //				<p class="mb-0 chat-time">${item.from}, ${item.time}</p>
                        //				<p class="chat-left-msg">${item.message}</p>
                        //			</div>
                        //		</div>
                        //	</div>

                        //	`);
                    }
                } else {
                    selector.append(`    <div class="d-flex chat-message">
								<div class="d-flex mb-2 flex-1">
									<div class="w-100 w-xxl-75">
										<div class="d-flex hover-actions-trigger">
											<div class="avatar avatar-m me-3 flex-shrink-0"><img class="rounded-circle" src="/img/user.png" alt="" /></div>
											<div class="chat-message-content received me-2">
											${item.from}
												<div class="mb-1 received-message-content border rounded-2 p-3">
															<img src="${item.imageUrl}" style="width:300px;">
												</div>
											</div>

										</div>
										<p class="mb-0 fs--2 text-600 fw-semi-bold ms-7">${item.time}</p>
									</div>
								</div>
							</div>`);
                }

            });


            var elem = document.getElementById('chatcontent');
            elem.scrollTop = elem.scrollHeight;

        }

        function sendMessage() {
            var message = $('#message').val();

            if (message) {
                console.log(message);
                $.ajax({
                    'csrf-token': '{{csrf_token()}}',
                    url: "{{route('chat.sendMessage')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        teamId: selectedTeamId,
                        message: message,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        loadChat(selectedTeamId);
                        $('#message').val('');
                    },
                    failure: function (response) {
                        console.log(response.responseText);
                    },
                    error: function (response) {
                        console.log(response.responseText);
                    }
                });
            }
        }
    </script>
@endsection
