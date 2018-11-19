<?php

DEFINE('LETTERS_LC', 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z');
DEFINE('LETTERS_UC', 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z');
DEFINE('NUMBERS', '0,1,2,3,4,5,6,7,8,9');
DEFINE('SPECIAL_CHARS', '!,@,#,$,%,^,&,*,(,),-,_,=,+');

#$rounds = $argv[1] ?? 1;
#if ($rounds > 4) {
#	$rounds = 4;
#}

#echo $rounds; exit;

$charset = array_merge(
	explode(',', LETTERS_LC),
	explode(',', LETTERS_UC),
	explode(',', NUMBERS),
	explode(',', SPECIAL_CHARS)
);

#var_dump($charset); exit;

$config = [
    'host' => '10.0.2.2',
    'user' => 'swoole',
    'password' => 'swoole',
    'database' => 'swoole',
];
/*
$db = new swoole_mysql;

$db->on('close', function() use($db) {
    echo "mysql is closed.\n";
});

$db->connect($config, function ($db, $result)
{
    if ($result === false)
    {
        var_dump($db->connect_errno, $db->connect_error);
        die;
    }
    echo "connect to mysql server sucess\n";
    $sql = 'show tables';
    //$sql = "INSERT INTO `test`.`userinfo` (`id`, `name`, `passwd`, `regtime`, `lastlogin_ip`) VALUES (NULL, 'jack', 'xuyou', CURRENT_TIMESTAMP, '');";
    $db->query($sql, function (swoole_mysql $db, $r)
    {
        global $s;
        if ($r === false)
        {
            var_dump($db->error, $db->errno);
        }
        elseif ($r === true)
        {
            var_dump($db->affected_rows, $db->insert_id);
        }
        echo "count=" . count($r) . ", time=" . (microtime(true) - $s), "\n";
        var_dump($r);
        $db->close();
    });
});
 */

$smysql = new swoole_mysql;

$request_index = 0;

$smysql->connect($config, function ($db, $result) use($charset) {
foreach ($charset as $char) {
    $sql = 'INSERT INTO swoole.rainbow (req_id, original, hash)'
         . ' VALUES (' . $request_index++ . ', "' . $char . '", "' . hash('sha384', $char) . '")';
    $db->query($sql, function(swoole_mysql $db, mysqli_result $result){
	    #var_dump($result->fetch_all());
	    echo "inserted $char at " . $request->insert_id . PHP_EOL;
    });
}
});

