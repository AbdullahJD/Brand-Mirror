@extends('Dashboard.layouts.master')

@section('content')


<div class="container-xxl">

    <h2 class="mb-5">Employee Dashboard</h2>

    <div class="row g-5">

        <div class="col-md-6">
            <div class="card p-5">
                <h3>Total Orders</h3>
                <h1>{{ $ordersCount }}</h1>
            </div>
        </div>

    </div>

    <div class="card mt-5">
        <div class="card-header">
            <h3>Latest Orders</h3>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($latestOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user?->name ?? 'Guest' }}</td>
                            <td>{{ $order->status }}</td>
                            <td>${{ $order->final_total }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection