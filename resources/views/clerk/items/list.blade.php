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
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class=" text-secondary opacity-7">Name</th>
                                <th class="text-secondary opacity-7">Stock</th>
                                <th class="text-secondary opacity-7">Status</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{asset('images/items/'.$item->img)}}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$item->ar_item_name}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$item->en_item_name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$item->stock}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 center">
                                            @if($item->status ==1)
                                                     <i class="fa fa-dot-circle text-success"></i>
                                               @else
                                                <i class="fa fa-dot-circle text-danger"></i>
                                            @endif
                                        </p>

                                    </td>

                                    <td class="align-middle">


                                        <form action="{{ route('clerk.items.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{url('clerk/items/'.$item->id.'/edit')}}" class="btn btn-warning" data-toggle="tooltip" data-original-title="Edit ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button onclick="submit()" class="btn btn-danger" data-toggle="tooltip" data-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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