<nav class="navbar navbar-vertical navbar-expand-lg">
    <script>
        var navbarStyle = window.config.config.phoenixNavbarStyle;
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li>
                    <p class="navbar-vertical-label">
                        Monitoring
                    </p>
                    <hr class="navbar-vertical-line"/>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('index') ? 'active' : '' }}"
                           href="{{ route('index') }}">
                            <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <span class="bi bi-house"></span>
                        </span>
                                <span class="nav-link-text-wrapper">
                            <span class="nav-link-text">Dashboard</span>
                        </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('liveLocation') ? 'active' : '' }}"
                           href="{{route('liveLocation')}}">
                            <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <span class="bi bi-pin-map-fill"></span>
                        </span>
                                <span class="nav-link-text-wrapper">
                            <span class="nav-link-text">Live Location</span>
                        </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('timeLine') ? 'active' : '' }}"
                           href="{{route('timeLine')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                  <span class="nav-link-icon">
                      <span class="fa fa-route"></span>
                  </span>
                                <span class="nav-link-text-wrapper">
                      <span class="nav-link-text">Time Line</span>
                  </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('cardView') ? 'active' : '' }}"
                           href="{{route('cardView')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                 <span class="nav-link-icon">
                     <span class="bi bi-card-heading"></span>
                 </span>
                                <span class="nav-link-text-wrapper">
                     <span class="nav-link-text">Card View</span>
                 </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('noticeboard.index') ? 'active' : '' }}"
                           href="{{route('noticeboard.index')}}" role="button" data-bs-toggle=""
                           aria-expanded="false">
                            <div class="d-flex align-items-center">
                 <span class="nav-link-icon">
                     <span class="bi bi-clipboard-data"></span>
                 </span>
                                <span class="nav-link-text-wrapper">
                     <span class="nav-link-text">Notice Board</span>
                 </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <p class="navbar-vertical-label">
                        Employee Management
                    </p>
                    <hr class="navbar-vertical-line"/>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('employee.index') ? 'active' : '' }}"
                           href="{{route('employee.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                <span class="nav-link-icon">
                    <span class="bi bi-people"></span>
                </span>
                                <span class="nav-link-text-wrapper">
                    <span class="nav-link-text">Employees</span>
                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('shift.index') ? 'active' : '' }}"
                           href="{{route('shift.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                     <span class="nav-link-icon">
                         <span class="bi bi-calendar2-week"></span>
                     </span>
                                <span class="nav-link-text-wrapper">
                         <span class="nav-link-text">Shifts</span>
                     </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('team.index') ? 'active' : '' }}"
                           href="{{route('team.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                <span class="nav-link-icon">
                    <span class="bi bi-diagram-3"></span>
                </span>
                                <span class="nav-link-text-wrapper">
                    <span class="nav-link-text">Teams</span>
                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('device.index') ? 'active' : '' }}"
                           href="{{route('device.index')}}">
                            <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="fa fa-mobile-alt"></span>
                                    </span>
                                <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">Device Management</span>
                                    </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <p class="navbar-vertical-label">
                        Attendance
                    </p>
                    <hr class="navbar-vertical-line"/>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('holiday.index') ? 'active' : '' }}"
                           href="{{route('holiday.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                     <span class="nav-link-icon">
                         <span class="bi bi-person-slash"></span>
                     </span>
                                <span class="nav-link-text-wrapper">
                         <span class="nav-link-text">Holidays</span>
                     </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('visit.index') ? 'active' : '' }}"
                           href="{{route('visit.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                     <span class="nav-link-icon">
                         <span class="fa fa-glasses"></span>
                     </span>
                                <span class="nav-link-text-wrapper">
                         <span class="nav-link-text">Visits</span>
                     </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <p class="navbar-vertical-label">
                        Leave Management
                    </p>
                    <hr class="navbar-vertical-line"/>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('leaveRequest.index') ? 'active' : '' }}"
                           href="{{route('leaveRequest.index')}}">
                            <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="fa fa-list"></span>
                                    </span>
                                <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">Leave Requests</span>
                                    </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('leaveType.index') ? 'active' : '' }}"
                           href="{{route('leaveType.index')}}">
                            <div class="d-flex align-items-center">
                             <span class="nav-link-icon">
                                 <span class="bi bi-list-check"></span>
                             </span>
                                <span class="nav-link-text-wrapper">
                                 <span class="nav-link-text">Leave Types</span>
                             </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <p class="navbar-vertical-label">
                        Expense Management
                    </p>
                    <hr class="navbar-vertical-line"/>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('expenseRequest.index') ? 'active' : '' }}"
                           href="{{route('expenseRequest.index')}}">
                            <div class="d-flex align-items-center">
                             <span class="nav-link-icon">
                                 <span class="bi bi-cash-stack"></span>
                             </span>
                                <span class="nav-link-text-wrapper">
                                 <span class="nav-link-text">Expense Requests</span>
                             </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('expenseType.index') ? 'active' : '' }}"
                           href="{{route('expenseType.index')}}">
                            <div class="d-flex align-items-center">
                             <span class="nav-link-icon">
                                 <span class="fa fa-coins"></span>
                             </span>
                                <span class="nav-link-text-wrapper">
                                 <span class="nav-link-text">Expense Types</span>
                             </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li>
                    <p class="navbar-vertical-label">
                        Other
                    </p>
                    <hr class="navbar-vertical-line"/>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('chat.index') ? 'active' : '' }}"
                           href="{{route('chat.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                 <span class="nav-link-icon">
                     <span class="bi bi-chat-dots"></span>
                 </span>
                                <span class="nav-link-text-wrapper">
                     <span class="nav-link-text">Chats</span>
                 </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1  {{ Route::is('client.index') ? 'active' : '' }}"
                           href="{{route('client.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                <span class="nav-link-icon">
                    <span class="fa fa-building"></span>
                </span>
                                <span class="nav-link-text-wrapper">
                    <span class="nav-link-text">Clients</span>
                </span>
                            </div>
                        </a>
                    </div>
                </li>
                {{--  <li class="nav-item">
                      <div class="nav-item-wrapper">
                          <a class="nav-link label-1" asp-controller="Report" asp-action="Index" role="button" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center">
                  <span class="nav-link-icon">
                      <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                  </span>
                              <span class="nav-link-text-wrapper">
                      <span class="nav-link-text">Reports</span>
                  </span>
                          </div>
                          </a>
                      </div>
                  </li>--}}
                {{--   <li class="nav-item">
                       <div class="nav-item-wrapper">
                           <a class="nav-link label-1" asp-controller="Notification" asp-action="Index" role="button" data-bs-toggle="" aria-expanded="false">
                           <div class="d-flex align-items-center">
                   <span class="nav-link-icon">
                       <span class="fa fa-bell"></span>
                   </span>
                               <span class="nav-link-text-wrapper">
                       <span class="nav-link-text">Notifications</span>
                   </span>
                           </div>
                           </a>
                       </div>
                   </li>--}}
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1  {{ Route::is('support.index') ? 'active' : '' }}"
                           href="{{route('support.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                <span class="nav-link-icon">
                    <span class="bi bi-info-circle-fill"></span>
                </span>
                                <span class="nav-link-text-wrapper">
                    <span class="nav-link-text">Support</span>
                </span>
                            </div>
                        </a>
                    </div>
                </li>

                <li>
                    <p class="navbar-vertical-label">
                        Portal Management
                    </p>
                    <hr class="navbar-vertical-line"/>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 " href="{{route('account')}}" role="button"
                           data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                 <span class="nav-link-icon">
                     <span class="fa fa-users"></span>
                 </span>
                                <span class="nav-link-text-wrapper">
                     <span class="nav-link-text">Portal Users</span>
                 </span>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button
            class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 white-space-nowrap d-flex align-items-center">
            <span class="uil uil-left-arrow-to-left fs-0"></span><span
                class="uil uil-arrow-from-right fs-0"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span>
        </button>
    </div>
</nav>
