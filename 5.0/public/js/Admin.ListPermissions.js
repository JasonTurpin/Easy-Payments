if (typeof Admin === 'undefined') {
    var Admin = {};
}

Admin.ListPermissions = (function() {
    var obj = {
        context : 'body.admin-listpermissions',

        // Initialize
        init: function() {
            var self = this;

            // Initialize data table
            $('#listPermissions').dataTable({
                "aaSorting"    : [[0, "asc"]],

                // 50 results per page
                "iDisplayLength": 50
            });
        }
    };

    $(document).ready(function() {
        if ($(obj.context).length > 0) {
            obj.init();
        }
    });
    return obj;
}());
