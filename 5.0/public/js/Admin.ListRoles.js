if (typeof Admin === 'undefined') {
    var Admin = {};
}

Admin.ListRoles = (function() {
    var obj = {
        context : 'body.admin-listroles',

        // Initialize
        init: function() {
            var self = this;

            // Initialize data table
            $('#listRoles').dataTable({
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
