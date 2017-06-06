<?php
return [
'catTables' => array("god" => "God","investor" => "Investor","farmer" => "Farmer"),
'facGI' => 0.15,
'facFI' => 0.05,
'sysLE'=>God::all()->sum('le') + Investor::all()->sum('le') + Farmer::all()->sum('le'),

'godPercent'=>0.51,
'login'=>"Log bak in :<br> <a href='/login/34'>God</a><br> <a href='/login/38'>Investor</a><br> <a href='/login/47'>Farmer</a><br>",
'reset'=>" <a href='/resetUsers'> Reset </a><br>",

// 'GTnoLand'=>0,
'dontFool'=>"Don't play with me Fool",

];
?>