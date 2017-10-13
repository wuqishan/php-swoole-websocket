# /bin/bash

for((i=1; i<10000; i++))
do
	a=$(curl http://swoole.cn/test_swoole/mysql_pool/connect_mysql.php)
	echo $a
done
