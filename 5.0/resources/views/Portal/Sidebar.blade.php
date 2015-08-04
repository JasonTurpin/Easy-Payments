<aside>
    <div id="sidebar"  class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">

            <?php
            /**
             * @todo admin role test
             */
            ?>

            <li class="sub-menu">
                <a href="javascript:;"{!!
                    (in_array($_controllerAction, array('admin.listpermissions', 'admin.addpermission', 'admin.editpermission', 'admin.addrole', 'admin.editrole', 'admin.listroles', 'admin.home'))
                        ? ' class="active"'
                        : '');
                !!}>
                    <i class="fa fa-shield"></i> <span>Admin</span>
                </a>
                <ul class="sub">
{{-- Admin.Permissions START --}}
                    <li class="sub-menu dcjq-parent-li">
                        <a href="javascript:;" class="dcjq-parent{!!
                            (in_array($_controllerAction, array('admin.listpermissions', 'admin.addpermission', 'admin.editpermission'))
                                ? ' active'
                                : '');
                        !!}">Permission Levels<span class="dcjq-icon"></span></a>
                        <ul class="sub">
                            <li{!!
                                ($_controllerAction == 'admin.addpermission'
                                    ? ' class="active"'
                                    : '');
                            !!}><a href="/Admin/addPermission">Add</a></li>
                            <li{!!
                                ($_controllerAction == 'admin.listpermissions'
                                    ? ' class="active"'
                                    : '');
                            !!}><a href="/Admin/listPermissions">List</a></li>
                        </ul>
                    </li>
{{-- Admin.Permissions END --}}

{{-- Admin.Roles START --}}
                    <li class="sub-menu dcjq-parent-li">
                        <a href="javascript:;" class="dcjq-parent{!!
                            (in_array($_controllerAction, array('admin.addrole', 'admin.editrole', 'admin.listroles'))
                                ? ' active'
                                : '');
                        !!}">Roles<span class="dcjq-icon"></span></a>
                        <ul class="sub">
                            <li{!!
                                ($_controllerAction == 'admin.addrole'
                                    ? ' class="active"'
                                    : '');
                            !!}><a href="/Admin/addRole">Add</a></li>
                            <li{!!
                                ($_controllerAction == 'admin.listroles'
                                    ? ' class="active"'
                                    : '');
                            !!}><a href="/Admin/listRoles">List</a></li>
                        </ul>
                    </li>
{{-- Admin.Roles END --}}
                </ul>
            </li>
        </ul>
    </div>
</aside>
