<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{{ isset($_description) ? $_description : '' }}}">
<meta name="keyword" content="{{{ isset($_keywords) ? $_keywords : '' }}}">
{{{ isset($_favicon) ? '<link rel="shortcut icon" href="'.$_favicon.'">' : '' }}}
<title>{{{ isset($_title) ? $_title.' | '.$_siteName : $_siteName }}}</title>
