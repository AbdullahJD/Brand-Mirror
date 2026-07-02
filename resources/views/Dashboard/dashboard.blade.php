@extends('Dashboard.layouts.master')

@section('content')

<div class="post d-flex flex-column-fluid">
<div class="container-xxl">

    {{-- TITLE --}}
    <div class="mb-5">
        <h2 class="fw-bold">{{ __('messages.dashboard') }}</h2>
        <p class="text-muted">{{ __('messages.store_overview') }}</p>
    </div>

    {{-- STATS --}}
    <div class="row g-5">

        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $productsCount }}</h3>
                    <span class="text-muted">{{ __('messages.products') }}</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $ordersCount }}</h3>
                    <span class="text-muted">{{ __('messages.orders') }}</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $usersCount }}</h3>
                    <span class="text-muted">{{ __('messages.stats_users') }}</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h3>${{ $revenue }}</h3>
                    <span class="text-muted">{{ __('messages.revenue_delivered') }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- LATEST ORDERS --}}
    <div class="card mt-8">
        <div class="card-header">
            <h3>{{ __('messages.latest_orders') }}</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('messages.customer') }}</th>
                        <th>{{ __('messages.total') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.date') }}</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($latestOrders as $order)

                    @php
                        $status = strtolower($order->status);

                        $colors = [
                            'pending'    => 'bg-warning',
                            'confirmed'  => 'bg-info',
                            'processing' => 'bg-primary',
                            'shipped'    => 'bg-dark',
                            'delivered'  => 'bg-success',
                            'cancelled'  => 'bg-danger',
                        ];
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->user?->name ?? __('messages.guest') }}</td>
                        <td>${{ $order->final_total ?? $order->total }}</td>
                        <td>
                            <span class="badge {{ $colors[$status] ?? 'bg-secondary' }}">
                                {{ __('messages.status_' . $status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- CHARTS --}}
    <div class="row mt-8">

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>{{ __('messages.orders_status_chart') }}</h4>
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>{{ __('messages.revenue_per_month_chart') }}</h4>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>
</div>

@endsection

@push('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusLabels = {!! json_encode(
            $statusCounts->keys()->map(fn($status) => __('messages.status_' . strtolower($status)))->values()
        ) !!};

        // Orders Chart
        new Chart(document.getElementById('ordersChart'), {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: {!! json_encode($statusCounts->values()) !!},
                    backgroundColor: [
                        '#ffc107',
                        '#0dcaf0',
                        '#0d6efd',
                        '#212529',
                        '#198754',
                        '#dc3545'
                    ]
                }]
            }
        });

        // Revenue Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($revenuePerMonth->keys()) !!},
                datasets: [{
                    label: @json(__('messages.revenue_label')),
                    data: {!! json_encode($revenuePerMonth->values()) !!},
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25,135,84,0.2)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });

    });
    </script>
@endpush
