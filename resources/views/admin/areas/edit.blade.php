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

                <form role="form" method="post" action="{{action('App\Http\Controllers\admin\AreasController@update',$area->id)}}" enctype="multipart/form-data">
                    <div class="col-md-6 col-6  mt-4">

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Area AR</label>
                            <input type="text" class="form-control" name="area_name_ar" value="{{$area->area_name_ar}}" required  onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Area EN</label>
                            <input type="text" class="form-control" name="area_name_en" value="{{$area->area_name_en}}"  onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <p style="padding-right: 15px"> Region &nbsp; &nbsp;</p>
                            <select name="region_id" id="region"  style="width: 40%;border-radius: 8px;height: fit-content;">
                                <option>select</option>
                               <?php
                                foreach($regions as $region){
                                    if($region->id == $area->region_id){
                                        $selected="selected";
                                    }else{
                                       $selected="";
                                    }
                                    echo '<option value="'.$region->id.'"  '.$selected.'  > '.$region->region_name_en.'</option> ';
                                }
                            ?>
                            </select>
                        </div>


                        @csrf
                        <div class="text-center">
                            <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Update">
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
