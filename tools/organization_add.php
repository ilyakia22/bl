<?
// Статус регистрации<br />
// Основание исключения участника закупки<br />
// Дата исключения<br />
// Тип участника закупки<br />
// Дата регистрации в ЕИС<br />
// Дата окончания срока регистрации в ЕИС<br />
// ОГРН<br />
// КПП<br />
// ИНН<br />
// Дата постановки на учет в налоговом органе<br />
// ОГРНИП<br />
// Аналог ИНН<br />
// Полное наименование<br />
// Сокращенное наименование<br />
// Адрес в пределах места нахождения<br />
// Страна или территория регистрации (инкорпорации)<br />
// Адрес (место нахождения) в пределах Российской Федерации<br />
// Полное наименование<br />
// Сокращенное наименование<br />
// Адрес в пределах места нахождения<br />
// ИНН<br />
// КПП<br />
// Дата постановки на учет в налоговом органе<br />
// ОГРН<br />
// ФИО<br />
// ФИО (латинскими буквами)<br />
// Дата регистрации индивидуального предпринимателя<br />
// Страна регистрации иностранного гражданина<br />
// ФИО<br />
// Должность<br />
// ИНН<br />
// ФИО<br />
// ИНН<br />
// Должность<br />
// Почтовый адрес<br />
// Адрес электронной почты<br />
// Контактный телефон<br />
// Адрес сайта в сети интернет<br />
// Участник закупки является субъектом малого предпринимательства<br />
// Коды по ОКВЭД<br />
$data = [];
$data[0] =  'status_registration';
$data[1] =  'exclusion_ground';
$data[2] =  'exclusion_date';
$data[3] =  'tip';
$data[4] =  'date_begin_eis';
$data[5] =  'date_end_eis';
$data[6] =  'ogrn';
$data[7] =  'kpp';
$data[8] =  'inn';
$data[9] =  'date_beg_nalog';
$data[10] =  'ogrnip';
$data[11] =  'inn_a';
$data[12] =  'full_name';
$data[13] =  'short_name';
$data[14] =  'address_in';
$data[15] =  'country_or_reg';
$data[16] =  'address_rf';
$data[17] =  'x_fullname';
$data[18] =  'x_shortname';
$data[19] =  'x_address_in';
$data[20] =  'x_inn';
$data[21] =  'x_kpp';
$data[22] =  'x_beg_nalog';
$data[23] =  'x_ogrn';
$data[24] =  'ip_fio';
$data[25] =  'ip_fio_en';
$data[26] =  'ip_date_reg';
$data[27] =  'ip_country_reg';
$data[28] =  'ooo_fio';
$data[29] =  'ooo_job_title';
$data[30] =  'ooo_inn';
$data[31] =  'xx_fio';
$data[32] =  'xx_inn';
$data[33] =  'xx_job_title';
$data[34] =  'c_address';
$data[35] =  'c_email';
$data[36] =  'c_phone';
$data[37] =  'c_site';
$data[38] =  'z_is_small';
$data[39] =  'z_cody';

include_once "funcs.php";
$curl = new myCURL('chernolist.ru');
$row = 1;
if (($handle = fopen("E:/xxx.csv", "r")) !== FALSE) {
	while (($d = fgetcsv($handle, 10000, ";")) !== FALSE) {
		$data2 = [];
		$num = count($d);
		//echo "<p> $num fields in line $row: <br /></p>\n";
		$row++;
		for ($c = 0; $c < $num; $c++) {
			//echo $d[$c] . "<br />\n";
			//echo $data[$c];
			$data2[$data[$c]] = $d[$c];
		}


		if ($row > 1000)
			exit;
		if ($row == 3) {
			// print_r($data2);
			// exit;
		}
		if ($row > 3) {
			$data3 = [];
			$data3['secret_scrf'] = 'xxxyyyiii';
			if (!empty($data2['ip_fio']) && !empty($data2['inn']) && !empty($data2['ogrnip'])) {
				$data3['name'] = $data2['ip_fio'];
				$data3['name_en'] = $data2['ip_fio_en'];
				$data3['date_reg'] = $data2['ip_date_reg'];
				$data3['country_reg'] = $data2['ip_country_reg'];

				$data3['is_small'] = $data2['z_is_small'] == 'Нет' ? 0 : 1;

				$data3['inn'] = $data2['inn'];
				$data3['ogrnip'] = $data2['ogrnip'];
				$data3['date_beg_eis'] = $data2['date_begin_eis'];
				$data3['date_end_eis'] = $data2['date_end_eis'];

				$data3['address'] = $data2['c_address'];
				$data3['email'] = $data2['c_email'];
				$data3['phone'] = $data2['c_phone'];
				$data3['site'] = $data2['c_site'];

				$data3['cody'] = $data2['z_cody'];
				//print_r($data3);
				$result = $curl->post("https://chernolist.ru/api.php/organization/ip", $data3);
				print_r($result);
				// print_r($info);
				// echo 333;
				exit;
			}
		}
	}
	fclose($handle);
}

exit;
echo "test\n";
$data = ['secret_scrf' => 'xxxyyyiii'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://bl-front.xx/api.php/phone/comment");
//curl_setopt($ch, CURLOPT_URL, "http://ya.ru");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
$info = curl_getinfo($ch);
$error = curl_error($ch);
curl_close($ch);

print_r($info);
print_r($error);

print_r($server_output);
