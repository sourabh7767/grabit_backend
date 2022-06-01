@extends('clerk.app')
@section('content')
    <br>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{$section}}</h6>
                    </div>
                </div>
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Items</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                <th class="text-secondary opacity-7">Update Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$order->id}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$order->user_name}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$order->item_names}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$order->total_price}}</p>
                                    </td>

                                    <td class="align-middle">
                                        @if($order->status == 1)
                                        <a href="{{url('clerk/orders/accept/'.$order->id)}}" class="btn btn-warning" data-toggle="tooltip" title="Accept ">
                                                Accept
                                        </a>
                                        @endif
                                        @if($order->status == 2)
                                        <a href="{{url('clerk/orders/complete/'.$order->id)}}" class="btn btn-danger" data-toggle="tooltip" title="Ready To Deliver">
                                                Ready To Deliver
                                        </a>
                                        @endif
                                        @if($order->status == 3)
                                        <a href="{{url('clerk/orders/deliver/'.$order->id)}}" class="btn btn-success" data-toggle="tooltip" title="Order Delivered">
                                                Order Deliver
                                        </a>
                                        @endif
                                        @if($order->status == 4)
                                        Order Delivered
                                        @endif
                                        <!-- <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{url('admin/orders/'.$order->id.'/edit')}}" class="btn btn-warning" data-toggle="tooltip" data-original-title="Edit ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button onclick="submit()" class="btn btn-danger" data-toggle="tooltip" data-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form> -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection