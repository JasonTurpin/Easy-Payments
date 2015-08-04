if (typeof Admin === 'undefined') {
    var Admin = {};
}

Admin.ListUsers = (function() {
    var obj = {
        context : 'body.admin-listusers',

        // Initialize
        init: function() {
            var self = this;

            // Initialize data table
            $('#listUsers').dataTable({
                "aaSorting"    : [[1, "asc"]],

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
