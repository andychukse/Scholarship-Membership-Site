@extends('layouts.app')
@section('sidebar')
@include('layouts.nav.side')
@endsection

@section('topbar')
@include('layouts.nav.top')
@endsection 
@section('content')
<!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Dashboard</span>
                <h3 class="page-title">Overview</h3>
              </div>
            </div>
            <!-- End Page Header -->
            
            <!-- Default Light Table -->
            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Users</h6>
                  </div>
                  <div class="card-body p-0 pb-3 text-center">
                    <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">#</th>
                          <th scope="col" class="border-0">First Name</th>
                          <th scope="col" class="border-0">Last Name</th>
                          <th scope="col" class="border-0">Email</th>
                          <th scope="col" class="border-0">Phone</th>
                          <th scope="col" class="border-0">Date Joined</th>
                          <th scope="col" class="border-0"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $user)
                        <tr>
                          <td>{{ $user->id }}</td>
                          <td>{{ $user->firstname }}</td>
                          <td>{{ $user->lastname }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->phone }}</td>
                          <td>{{ \Carbon\Carbon::parse($user->created_at)->format('F d, Y') }}</td>
                          <td><a href="{{ route('user.edit', $user->id) }}"><i class="fas fa-edit"></i> Edit</a></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{ $users->links() }}
                  </div>
                </div>
              </div>
            </div>
            <!-- End Default Light Table -->
@endsection
@section('footer')
@include('layouts.nav.footer')
@endsection