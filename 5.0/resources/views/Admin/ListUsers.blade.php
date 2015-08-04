@extends('layouts.Portal')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
@include('includes.DashboardMessages')
                    <ul class="breadcrumb">
                        <li><a href="/Admin"><i class="fa fa-home"></i> Admin Home</a></li>
                        <li class="active"><a href="{{{$_pageAction }}}">{{{ $_pageName }}}</a></li>
                    </ul>
                    <header class="panel-heading">{{{ $_pageName }}}</header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="listUsers">
                                        <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
@foreach ($Users as $user)
                                            <tr class="gradeX">
                                                <td>{{{ $user->firstName }}}</td>
                                                <td>{{{ $user->lastName }}}</td>
                                                <td>{{{ $user->email }}}</td>
    @if ($user->isActive)
                                                <td><span class="label label-success label-mini">Active</span></td>
    @else
                                                <td><span class="label label-danger label-mini">Inactive</span></td>
    @endif
                                                <td class="text-center"><a href="/Admin/editUser/{{{ $user->user_id }}}" class="btn btn-primary">Edit</a></td>
                                            </tr>
@endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
@stop
