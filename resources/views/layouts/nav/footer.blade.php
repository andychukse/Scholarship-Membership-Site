<footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ secure_url('/home') }}">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ secure_url('/lists/scholarships') }}">Scholarships</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ secure_url('/lists/guides') }}">Guides</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ secure_url('/lists/grants') }}">Grants</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ secure_url('/lists') }}">All Posts</a>
              </li>
            </ul>
            <span class="copyright ml-auto my-auto mr-2">Copyright © {{ \Carbon\Carbon::now()->format('Y') }}
              <a href="https://afribary.com">Afribary</a>
            </span>
          </footer>