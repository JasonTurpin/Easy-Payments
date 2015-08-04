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
                        <li><a href="/Admin/listPermissions">List Permissions</a></li>
                        <li class="active"><a href="{{{$_pageAction }}}">{{{ $_pageName }}}</a></li>
                    </ul>
                    <header class="panel-heading">{{{ $_pageName }}}</header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form role="form" class="form-horizontal" method="post" action="{{{ $_pageAction }}}">
@if ($Roles->count() > 0)
                                    <div class="col-sm-4 pull-right">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Roles</label>
                                            <div class="col-sm-8">
                                                <div class="input-group m-bot15">
                                                    <ul class="inputList">
    @foreach ($Roles as $role)
                                                        <li>
                                                            <label><input type="checkbox" name="roles[]" value="{{{ $role->role_id }}}" {!!
                                                                (in_array($role->role_id, $permissionRoles)
                                                                    ? ' checked'
                                                                    : '');
                                                            !!} /> {{{ $role->label }}}</label>
                                                        </li>
    @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
@endif
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="label" value="{{{ $permission->label }}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Active</label>
                                            <div class="col-lg-10">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" value="1" name="isActive"{!!
                                                            ($permission->isActive == '1' || is_null($permission->isActive)
                                                                ? ' checked'
                                                                : '')
                                                        !!}> Yes
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" value="0" name="isActive"{!!
                                                            ($permission->isActive == '0'
                                                                ? ' checked'
                                                                : '')
                                                        !!}> No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="pull-right col-sm-1">
                                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                                                <button class="btn btn-success" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
@stop
