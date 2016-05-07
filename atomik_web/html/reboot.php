<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Atomik Controller - Rebooting</title>
<?php
 $Handle = fopen("/tmp/atomikreboot", 'w');
 fwrite($Handle, "doreboot");
 fclose($Handle);

?>
</head>

<body>
The Atomik Controller is Rebooting....
</body>
</html>