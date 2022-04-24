@extends('clerk.app')
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
                @endif

                <form role="form" enctype="multipart/form-data" method="post" action="{{action('App\Http\Controllers\clerk\StoreController@update',$stores->id)}}">
                    <div class="col-md-5 col-5  mt-4" style="display: inline-block;">

                        <div class="input-group input-group-outline mb-3 focused is-focused" style="margin-top: -15px">
                            <label class="form-label">AR Name</label>
                            <input type="text" name="ar_name" value="{{$stores->ar_name}}" required class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>



                        <br>

                        <div class="input-group input-group-outline mb-3 focused is-focused" >
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{$stores->phone}}" required class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <div class="input-group input-group-outline mb-3 focused is-focused" >
                            <label class="form-label">Delivery price</label>
                            <input type="text" name="delivery_price" value="{{$stores->delivery_price}}" required class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Location</label>
                            <input type="text"  name="location" value="{{$stores->location}}" class="form-control" required onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Longitude</label>
                            <input type="text"  name="longitude" value="{{$stores->longitude}}" class="form-control" required onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Latitude</label>
                            <input type="text"  name="latitude" value="{{$stores->latitude}}" class="form-control" required onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <br> <br>
                        <br>
                        <br>
                        <br>
                    </div>

                    <div class="col-md-5 col-6  mt-4 pull-right" style="display: inline-block;padding-left: 18px;">


                        <div class="input-group input-group-outline mb-3 focused is-focused" >
                            <br>

                            <label class="form-label">EN Name</label>
                            <input type="text" name="en_name" value="{{$stores->en_name}}"required  class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <br>
                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <p style="padding-right: 15px"> Category </p>
                            <select name="category" id="category" style="width: 40%;border-radius: 8px;height: fit-content;"required>
                                <option>select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                            @if($category->id == $stores->category_id)
                                            selected
                                            @endif
                                    > {{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <br>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <p style="padding-right: 15px"> Region &nbsp; &nbsp;</p>
                            <select name="region" id="region" onchange="get_region(this)" style="width: 40%;border-radius: 8px;height: fit-content;">
                                <option>select</option>
                                @foreach($regions as $region)
                                    <option value="{{$region->id}}"
                                            @if($region->id == $stores->region)
                                            selected
                                        @endif
                                    > {{$region->region_name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>

                        <div class="input-group input-group-outline mb-3">
                            <p style="padding-right: 15px"> City  &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;</p>
                            <select name="cities" id="cities" style="width: 40%;border-radius: 8px;height: fit-content;">

                            </select>
                        </div>

                        <div class="form-check form-check-info text-start ps-0">
                            <label class="form-check-label" for="flexCheckDefault"> Upload Logo</a>    &nbsp;&nbsp;&nbsp;
                            <input class="form-check-input" type="file" name="logo" value="" id="flexCheckDefault" style="width: auto">
                            </label>
                        </div>
                        @csrf
                        @method('PUT')
                        <br>
                        <br>
                        <br>
                        <br>
                                 <input type="hidden" name="img_src" value="{{$stores->logo}}">
                        <div class="text-center">
                            <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Update">
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>

        e="<?php echo $stores->region; ?>";
        city="<?php echo $stores->city; ?>";

        $cities=document.getElementById("cities");
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            ob=JSON.parse(this.responseText);
            i=0;
            document.getElementById("cities").innerHTML = "";
            for(var r in ob) {

                ele = document.createElement("option");
                ele.value = ob[i].id;
                if(ele.value==city){
                    ele.selected="selected"
                }
                ele.text = ob[i].area_name_en;
                $cities.append(ele);
                i++;
            }
        }
        xhttp.open("GET", "https://apps-valley.net/grabit/public/clerk/cities/"+e, true);
        xhttp.send();




        function get_region(e){
            $cities=document.getElementById("cities");
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                ob=JSON.parse(this.responseText);
                i=0;
                document.getElementById("cities").innerHTML = "";
                for(var r in ob) {

                    ele = document.createElement("option");
                    ele.value = ob[i].id;
                    ele.text = ob[i].area_name_en;
                    $cities.append(ele);
                    i++;
                }
            }
            xhttp.open("GET", "https://apps-valley.net/grabit/public/clerk/cities/"+e.value, true);
            xhttp.send();



        }

    </script>
@endsection
