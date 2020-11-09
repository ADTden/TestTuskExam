<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности");
?>Больше всего времени потребовалось странице&nbsp;<a href="http://testtusk/bitrix/admin/perfmon_hit_list.php?lang=ru&set_filter=Y&find_script_name=%2Fproducts%2Findex.php">/products/index.php</a>&nbsp;- 3.8 сек.<br>
 <br>
 Самая ресурсоемкая страница -&nbsp;<a href="http://testtusk/bitrix/admin/perfmon_hit_list.php?lang=ru&set_filter=Y&find_script_name=%2Fcontacts%2Findex.php">/contacts/index.php</a><br>
 Нагрузка&nbsp;35.23%<br>
<br>
При множестве ключей кеша в компоненте, его объем состовляет 119 Кб<br>
При определенных ключах - 5 Кб<br>
<br>
Разница в кеше 114 КБ<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>