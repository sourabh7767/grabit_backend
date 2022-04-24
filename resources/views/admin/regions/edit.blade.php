@extends('admin.app')
@section('content')


    <div class="container-fluid py-4">
        <div class="row">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(Session::has('message'))
                    <div class="alert alert-success">
                        <p class="text-white">{{session('message')}}</p>
                    </div>

                @endif

                <form role="form" method="post" action="{{action('App\Http\Controllers\admin\RegionsController@update',$region->id)}}" enctype="multipart/form-data">
                    <div class="col-md-6 col-6  mt-4">

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">AR Name</label>
                            <input type="text" class="form-control" name="region_name_ar" value="{{$region->region_name_ar}}" required  onfocus="focused(this)" onfocusout="defocused(this)">

                        </div>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">EN Name</label>
                            <input type="text" class="form-control" name="region_name_en" value="{{$region->region_name_en}}" onfocus="focused(true)" onfocusout="defocused(this)">
                        </div>



                
                        @csrf
                        @method('PUT')
                        <div class="text-center">
                            <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Update">
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection