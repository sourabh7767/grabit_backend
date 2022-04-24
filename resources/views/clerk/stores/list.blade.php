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
                    <div style="padding: 25px">

                            @foreach($stores as $store)

                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{asset('images/stores/'.$store->logo)}}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h2 class="mb-0 text-sm">{{$store->ar_name}}</h2>
                                                <p class="text-xs text-secondary mb-0">{{$store->en_name}}</p>
                                            </div>
                                        </div>
                            <br><br>
                                        <p class="text-xs font-weight-bold mb-0">{{$store->phone}}</p>
                                        <p class="text-xs font-weight-bold mb-0">{{$store->location}}</p>
                            <br><br>
                                        <p class="text-xs font-weight-bold mb-0">{{\App\Models\admin\Regions::where('id',$store->region)->first()->region_name_en}}</p>
                                        <p class="text-xs font-weight-bold mb-0">{{\App\Models\admin\Areas::where('id',$store->city)->first()->area_name_en}}</p>



                                    <div class="align-middle " align="right">



                                            <a href="{{url('clerk/store/'.$store->id.'/edit')}}" class="btn btn-warning" data-toggle="tooltip" data-original-title="Edit ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                          
                                    </div>
                            @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection