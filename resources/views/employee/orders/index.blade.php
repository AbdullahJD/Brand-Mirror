@extends('Dashboard.layouts.master')

@section('title')
Order
@endsection

@section('content')

<div class="container-xxl">

    <h2 class="mb-5">Employee Orders</h2>

    {{-- FILTER --}}
    <form method="GET" class="mb-4">
        <select name="status" class="form-select w-25" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="pending" {{ $status=='pending'?'selected':'' }}>Pending</option>
            <option value="confirmed" {{ $status=='confirmed'?'selected':'' }}>Confirmed</option>
            <option value="processing" {{ $status=='processing'?'selected':'' }}>Processing</option>
            <option value="shipped" {{ $status=='shipped'?'selected':'' }}>Shipped</option>
            <option value="delivered" {{ $status=='delivered'?'selected':'' }}>Delivered</option>
            <option value="cancelled" {{ $status=='cancelled'?'selected':'' }}>Cancelled</option>
        </select>
    </form>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($orders as $order)
                    <tr id="row-{{ $order->id }}">

                        <td>{{ $order->id }}</td>

                        <td>{{ $order->customer?->name ?? 'Guest' }}</td>

                        <td>${{ $order->final_total }}</td>

                        <td>
                            {{-- STATUS BADGE --}}
                            <span class="badge bg-primary status-badge" id="badge-{{ $order->id }}">
                                {{ $order->status }}
                            </span>

                            {{-- DROPDOWN --}}
                            <select class="form-select mt-2 status-dropdown"
                                    data-id="{{ $order->id }}">
                                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>Confirmed</option>
                                <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                                <option value="shipped" {{ $order->status=='shipped'?'selected':'' }}>Shipped</option>
                                <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                            </select>
                        </td>

                        <td>
                            <a href="{{ route('employee.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                {{ __('messages.view') }}
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">{{ __('messages.no_orders_found') }}</td>
                    </tr>
                @endforelse
                </tbody>

            </table>

            {{ $orders->links() }}

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    let oldValue = null;

    $('.status-dropdown').on('focus', function () {
        oldValue = $(this).val();
    });

    $('.status-dropdown').on('change', function () {

        let orderId = $(this).data('id');
        let status = $(this).val();

        if (status === oldValue) return;

        $.ajax({
            url: '/employee/orders/' + orderId + '/status',
            type: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },

            success: function (res) {

                if (!res.success) {
                    alert(res.message);
                    return;
                }

                // update badge بدون reload
                $('#badge-' + orderId).text(res.status);

            },

            error: function (xhr) {
                alert(xhr.responseJSON?.message ?? 'Error updating status');
            }

        });

    });

});
</script>
@endpush