@extends('layouts.Portal')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
@include('includes.DashboardMessages')
                    <ul class="breadcrumb">
                        <li><a href="/Admin"><i class="fa fa-home"></i> Admin Home</a></li>
                    </ul>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        User Account Management
                                    </header>
                                    <div class="list-group panel-body">
                                        <a class="list-group-item" href="/Admin/addPermission/">Add Permission</a>
                                        <a class="list-group-item" href="/Admin/addRole/">Add User Role</a>
                                        <a class="list-group-item" href="/Admin/listPermissions/">List Permission Levels</a>
                                        <a class="list-group-item" href="/Admin/listRoles/">List User Roles</a>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
@stop
