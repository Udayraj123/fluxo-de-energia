<?php
return [
'catTables' => array("god" => "God","investor" => "Investor","farmer" => "Farmer"),
'facGI' => 0.15,
'facFI' => 0.05,
'sysLE'=>God::all()->sum('le') + Investor::all()->sum('le') + Farmer::all()->sum('le'),

'godPercent'=>0.51,

// 'GTnoLand'=>0,
'dontFool'=>"Don't play with me Fool",

];
?>