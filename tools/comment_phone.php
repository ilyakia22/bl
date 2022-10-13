<?
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
