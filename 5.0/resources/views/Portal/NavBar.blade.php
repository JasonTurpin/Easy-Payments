<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
    </div>
    <div class="top-nav">
        <ul class="nav pull-right top-menu">
<?php if (!empty($_user->user_id)) { ?>
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="username">{{{ $_user->firstName.' '.$_user->lastName }}}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="/signOut"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
<?php } else { ?>
            <li class="dropdown">
                <a href="/signIn"><span class="username">Sign In</span></a>
            </li>
<?php } ?>
        </ul>
    </div>
</header>
