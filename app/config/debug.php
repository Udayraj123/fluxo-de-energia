<?php
return [
'login'=>"Log back in :<br> <a href='/login/god'>God ".
User::where('logged_in',0)->where('is_moderator',0)->where('category','god')->count()."</a><br>
<a href='/login/investor'>Investor ".
User::where('logged_in',0)->where('is_moderator',0)->where('category','investor')->count()."</a><br>
<a href='/login/farmer'>Farmer ".
User::where('logged_in',0)->where('is_moderator',0)->where('category','farmer')->count()."</a><br>
",
'reset'=>" <a href='/resetUsers'> Reset </a><br>",
'goBack'=>"<br> Going back in a sec... <b>Reload afterwards.</b><script> setTimeout(function(){window.location.href='".route('energy')."';},500); </script>",
// 'goBack'=>"<br> Going back in a sec... <b>Reload afterwards.</b><script> setTimeout('history.back()',500); </script>",
// 'GTnoLand'=>0,
'dontFool'=>"Don't play with me Fool",

'today_format'=>'Y-m-d',
'date_format'=>'H:i:s d-m-Y',
'file_time_new'=>'d M, H:i:s',
'file_time'=>'d,m,y-H_i_s',
'log_date_format'=>'d M, H:i:s',
'now_time'=>'H:i A, d M Y',
'hour_format'=>'H:i',
'feedback_format'=>'d M Y',
];
?>