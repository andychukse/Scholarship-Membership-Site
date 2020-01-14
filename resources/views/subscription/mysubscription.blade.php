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
                          <th scope="col" class="border-0">Plan</th>
                          <th scope="col" class="border-0">Amount</th>
                          <th scope="col" class="border-0">Status</th>
                          <th scope="col" class="border-0">AutoRenewal</th>
                          <th scope="col" class="border-0">Creation Date</th>
                          <th scope="col" class="border-0">Expiry Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($subscriptions as $subscription)
                        <tr>
                          <td>{{ $subscription->id }}</td>
                          <td>{{ $subscription->name }}</td>
                          <td>{{ $subscription->amount }}</td>
                          <td>@if($subscription->status == 1) <button type="button" class="mb-2 btn btn-sm btn-success mr-1">Paid</button> @else <button type="button" class="mb-2 btn btn-sm btn-warning mr-1">Pending</button> @endif</td>
                          <td>@if($subscription->state == 1) <button type="button" class="mb-2 btn btn-sm btn-success mr-1">Active</button> @else <button type="button" class="mb-2 btn btn-sm btn-default mr-1">Not Active</button> @endif</td>
                          <td>{{ \Carbon\Carbon::parse($subscription->created_at)->format('F d, Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($subscription->end_at)->format('F d, Y') }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{ $subscriptions->links() }}
                  </div>
                </div>
              </div>
            </div>
            <!-- End Default Light Table -->
@endsection
@section('footer')
@include('layouts.nav.footer')
@endsection