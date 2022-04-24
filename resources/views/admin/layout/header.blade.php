<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/logo.png')}}">
        <link rel="icon" type="image/png" href="../assets/img/logo.png">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? env('APP_NAME') }}</title>
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- Nucleo Icons -->
        <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
        <!-- CSS Files -->
        <link id="pagestyle" href="{{asset('assets/css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />
    </head>

    <body class="g-sidenav-show ">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header  bg-gray-900">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="#" target="_blank">
                <img src="{{asset('assets/img/logo.png')}}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">Grabit Admin</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">


        <div class="container">
            <div class="row">
                <div class="col s2 m4 l5  bg-gray-900">
                    <div id="menu-lateral">
                        <ul id="menu-menu-lateral" class="menu">
                            <li class="menu-item">
                                <a href="{{ url('./admin/dashboard')}}" class="nav-link text-white <?php if(Request::segment(2) =='dashboard'){echo 'bg-gradient-primary';} ?> "><i class="fa fa-home" aria-hidden='true'></i>  Home</a></li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#"  class="nav-link text-white "><i class="fa fa-shopping-basket" aria-hidden='true'></i>  Stores</a>

                                <ul class="sub-menu <?php if(Request::segment(2) =='stores'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='stores' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a class="<?php if(Request::segment(2) =='stores'&& empty(Request::segment(3))){echo 'text-white';} ?>" href="{{ url('./admin/stores')}}"><i class="fa fa-list" aria-hidden='true'></i> Stores</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='stores' && Request::segment(3)=="create"){echo 'bg-gradient-primary';} ?>"><a class="<?php if(Request::segment(2) =='stores' && Request::segment(3)=="create"){echo 'text-white';} ?>" href="{{ url('./admin/stores/create')}}"><i class="fa fa-plus-circle" aria-hidden='true'></i>  New Store</a></li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#" class="nav-link text-white" ><i class="fa fa-tags" aria-hidden='true'></i>  Categories</a>
                                
                                <ul class="sub-menu <?php if(Request::segment(2) =='categories' || Request::segment(2) =='sub-categories'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='categories' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a class="<?php if(Request::segment(2) =='categories'&& empty(Request::segment(3))){echo 'text-white';} ?>" href="{{ url('./admin/categories')}}"><i class="fa fa-list" aria-hidden='true'></i> Categories</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='categories' && Request::segment(3)=="create"){echo 'bg-gradient-primary';} ?>"><a  class="<?php if(Request::segment(2) =='categories' && Request::segment(3)=="create"){echo 'text-white';} ?>" href="{{ url('./admin/categories/create')}}"><i class="fa fa-plus-circle" aria-hidden='true'></i> New Category</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='sub-categories' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a class="<?php if(Request::segment(2) =='sub-categories'&& empty(Request::segment(3))){echo 'text-white';} ?>" href="{{ url('./admin/sub-categories')}}"><i class="fa fa-list" aria-hidden='true'></i> Sub Categories</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='sub-categories' && Request::segment(3)=="create"){echo 'bg-gradient-primary';} ?>"><a  class="<?php if(Request::segment(2) =='sub-categories' && Request::segment(3)=="create"){echo 'text-white';} ?>" href="{{ url('./admin/sub-categories/create')}}"><i class="fa fa-plus-circle" aria-hidden='true'></i> New Sub Category</a></li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#" class="nav-link text-white"><i class="fa fa-shopping-cart" aria-hidden='true'></i>  Orders</a>
                                
                                <ul class="sub-menu <?php if(Request::segment(2) =='orders'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='orders' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a class="<?php if(Request::segment(2) =='orders'){echo 'text-white';} ?>" href="{{ url('./admin/orders')}}"><i class="fa fa-list" aria-hidden='true'></i>  All Orders</a></li>

                                </ul>
                            </li>

                            <hr>
                            <li class="menu-item menu-item-has-children">
                                <a href="#" class="nav-link text-white"><i class="fa fa-user-plus" aria-hidden='true'></i>  Clerks</a>
                                
                                <ul class="sub-menu <?php if(Request::segment(2) =='clerks'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='clerks' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/clerks')}}"><i class="fa fa-list" aria-hidden='true'></i>  Clerks</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='clerks' && Request::segment(3)=="create"){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/clerks/create')}}"><i class="fa fa-plus-circle" aria-hidden='true'></i>  New Clerk</a></li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#" class="nav-link text-white"><i class="fa fa-users" aria-hidden='true'></i>  Users</a>
                                
                                <ul class="sub-menu <?php if(Request::segment(2) =='users'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='users' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/users')}}"><i class="fa fa-list" aria-hidden='true'></i> Users</a></li>
                                   
                                </ul>
                            </li>
                            <hr>
                            <li class="menu-item menu-item-has-children">
                                <a href="#" class="nav-link text-white"><i class="fa fa-user-secret" aria-hidden='true'></i>  Admins</a>
                                
                                <ul class="sub-menu <?php if(Request::segment(2) =='admins'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='admins' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/admins')}}"><i class="fa fa-list" aria-hidden='true'></i> Admins</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='admins' && Request::segment(3)=="create"){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/admins/create')}}"><i class="fa fa-plus-circle" aria-hidden='true'></i> New Admin</a></li>
                                </ul>
                            </li>

                            <li class="menu-item menu-item-has-children">
                                <a href="#" class="nav-link text-white"><i class="fa fa-map" aria-hidden='true'></i>  Regions</a>

                                <ul class="sub-menu <?php if(Request::segment(2) =='regions' || Request::segment(2) =='areas'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='regions' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/regions')}}"><i class="fa fa-list" aria-hidden='true'></i> Regions</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='regions' && Request::segment(3)=="create"){echo 'bg-gradient-primary';} ?> "><a href="{{ url('./admin/regions/create')}}"><i class="fa fa-plus-circle" aria-hidden='true'></i> New Region</a></li>

                                    <li class="menu-item <?php if(Request::segment(2) =='areas' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/areas')}}"><i class="fa fa-list" aria-hidden='true'></i> Areas</a></li>
                                    <li class="menu-item <?php if(Request::segment(2) =='areas' && Request::segment(3)=="create"){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/areas/create')}}"><i class="fa fa-plus-circle" aria-hidden='true'></i> New Area</a></li>
                                </ul>
                            </li>

                            <li class="menu-item menu-item-has-children">
                                <a href="#" class="nav-link text-white"><i class="fa fa-gears" aria-hidden='true'></i> APP Settings</a>
                                
                                <ul class="sub-menu <?php if(Request::segment(2) =='settings'){echo 'active';} ?>">
                                    <li class="menu-item <?php if(Request::segment(2) =='settings' && empty(Request::segment(3))){echo 'bg-gradient-primary';} ?>"><a href="{{ url('./admin/settings')}}"><i class="fa fa-gear" aria-hidden='true'></i> Manage</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

        <div class="sidenav-footer position-absolute w-100 bottom-0 ">

        </div>
    </aside>