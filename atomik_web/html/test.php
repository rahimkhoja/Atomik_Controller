<?php 

function Check0to255( $input )
{
	if (preg_match("/^[0-9]+$/", $input)) {
		if (  ( $input >= 0 ) && ( $input <= 255 ) ) {
			return 1;
		}
	}
	return 0;
}

echo "100: ".Check0to255( 100 );
echo '"100": '.Check0to255( "100" );
echo "10: ".Check0to255( 10 );
echo '"10": '.Check0to255( "10" );
echo "500: ".Check0to255( 500 );
echo '"500": '.Check0to255( "500" );

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>