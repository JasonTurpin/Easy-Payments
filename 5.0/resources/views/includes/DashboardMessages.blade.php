<div class="panel-body">
    <div class="dashboardMessages">
        <div class="alert alert-danger alert-dismissable<?php echo
            (empty($_errorMsgs)
                ? ' hoffa'
                : '');
        ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <ul class="msgContainer">
@foreach ($_errorMsgs as $_msg)
                <li>{{{ $_msg }}}</li>
@endforeach
            </ul>
        </div>

        <div class="alert alert-success alert-dismissable<?php echo
            (empty($_successMsgs)
                ? ' hoffa'
                : '');
        ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <ul class="msgContainer">
@foreach ($_successMsgs as $_msg)
                <li>{{{ $_msg }}}</li>
@endforeach
            </ul>
        </div>
        
        <div class="alert alert-info alert-dismissable<?php echo
            (empty($_neutralMsgs)
                ? ' hoffa'
                : '');
        ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <ul class="msgContainer">
@foreach ($_neutralMsgs as $_msg)
                <li>{{{ $_msg }}}</li>
@endforeach
            </ul>
        </div>
    </div>
</div>
