@extends('layouts.Portal')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
@include('includes.DashboardMessages')
                    <ul class="breadcrumb">
                        <li><a href="/Admin/"><i class="fa fa-home"></i> Admin Home</a></li>
                        <li class="active"><a href="{{{ $_pageAction }}}"> {{{ $_pageName }}}</a></li>
                    </ul>
                    <header class="panel-heading">{{{ $_pageName }}}</header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="listRoles">
                                        <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
@foreach($Roles as $role)
                                            <tr>
                                                <td>{{{ $role->label }}}</td>
                                                <td>{!! 
                                                    ($role->isActive == '1'
                                                        ? '<span class="label label-success">Yes</span>'
                                                        :'<span class="label label-danger">No</span>')
                                                !!}</td>
                                                <td class="text-center"><a href="/Admin/editRole/{{{ $role->role_id }}}" class="btn btn-primary">Edit</a></td>
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
