<?php
$link = mysql_connect('us-cdbr-east-04.cleardb.com', 'b9f4160f988271', 'b35def12');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
printf("MySQL server version: %s\n", mysql_get_server_info());

