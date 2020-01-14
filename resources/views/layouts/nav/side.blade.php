<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="{{ secure_asset('images/icon.png') }}" alt="Afribary Scholar">
                  <span class="d-none d-md-inline ml-1">Afribary Scholar</span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
            <div class="input-group input-group-seamless ml-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-search"></i>
                </div>
              </div>
              <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
          </form>

          @if(Auth::user()->hasAnyRole(['admin', 'superadmin']))
          <div class="nav-wrapper">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="{{ secure_url('/home') }}">
                  <i class="material-icons">edit</i>
                  <span>Blog Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/post') }}">
                  <i class="material-icons">vertical_split</i>
                  <span>Posts</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/post/create') }}">
                  <i class="material-icons">note_add</i>
                  <span>Add New Post</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/users') }}">
                  <i class="material-icons">person</i>
                  <span>Users</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/subscriptions') }}">
                  <i class="material-icons">table_chart</i>
                  <span>Payments</span>
                </a>
              </li>
            </ul>
          </div>
          @else
            <div class="nav-wrapper">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="{{ secure_url('/home') }}">
                  <i class="material-icons">edit</i>
                  <span>Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/lists/scholarships') }}">
                  <i class="material-icons">vertical_split</i>
                  <span>Scholarships</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/lists/grants') }}">
                  <i class="material-icons">note_add</i>
                  <span>Grants/Fellowships</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/lists/guides') }}">
                  <i class="material-icons">table_chart</i>
                  <span>Guides</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/lists/jobs') }}">
                  <i class="material-icons">table_chart</i>
                  <span>Jobs</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/profile') }}">
                  <i class="material-icons">person</i>
                  <span>My Profile</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ secure_url('/my-subscription') }}">
                  <i class="material-icons">view_module</i>
                  <span>Subscriptions</span>
                </a>
              </li>
            </ul>
          </div>
          @endif
        </aside>