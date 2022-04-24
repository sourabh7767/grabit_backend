@extends('admin.app')
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sub_categories as $cat)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{asset('images/sub-categories/'.$cat->img)}}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$cat->sub_category_name}}</h6>
                                            <p class="text-xs text-secondary mb-0">{{$cat->sub_category_name_ar}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{$cat->sub_description}}</p>
                         
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{\App\Models\admin\Categories::Where('id',$cat->category_id)->first()->category_name ?? ''}}</p>

                                </td>
                                <td class="align-middle">
                                   

                                    <form action="{{ route('admin.sub-categories.destroy', $cat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{url('admin/sub-categories/'.$cat->id.'/edit')}}" class="btn btn-warning" data-toggle="tooltip" data-original-title="Edit ">
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