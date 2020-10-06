<?php
$info = json_decode(file_get_contents('info.json'),true);
define('API_KEY',$info['token']);
function bot($method,$datas=[]){
    $bot = http_build_query($datas);
        $url = "https://api.telegram.org/bot".API_KEY."/".$method."?$bot";
        $bots = file_get_contents($url);
        return json_decode($bots);
}
date_default_timezone_set("Asia/Baghdad");
if (!file_exists('madeline.php')) {
	copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
define('MADELINE_BRANCH', 'deprecated');
include 'madeline.php';
use \danog\MadelineProto\Exception;
use \danog\MadelineProto\RPCErrorException;
function Ac($session) {
	$settings['app_info']['api_id'] = 579315;
	$settings['app_info']['api_hash'] = '4ace69ed2f78cec268dc7483fd3d3424';
	$settings['updates']['handle_updates'] = false;
	require 'turbo/lite/vendor/autoload.php';
	return new \danog\MadelineProto\API($session);
}
$settings['app_info']['api_id'] = 579315;
$settings['app_info']['api_hash'] = '4ace69ed2f78cec268dc7483fd3d3424';
$MadelineProto = new \danog\MadelineProto\API('me.madeline', $settings);
$MadelineProto->start();
$info = json_decode(file_get_contents('info.json'),true);
$admin = $info["id"];
$type = file_get_contents("type.txt");
$name = $info["name"];
$time = date('h:i');
$user = file_get_contents('users');
if($type == "Channel"){
$updates = $MadelineProto->channels->createChannel(['broadcast' => true,'megagroup' => false,'title' => $name, ]);
}
if($user !== ""){
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>" - I'm Run To $type.",
]);
}
$x = 0;
if($type == "Account"){
while(1){
if($user !== ""){
try{
$MadelineProto->messages->getPeerDialogs(['peers' => [$user]]);
$x++;
} catch (\danog\MadelineProto\Exception | \danog\MadelineProto\RPCErrorException $e) {
try{
$MadelineProto->account->updateUsername(['username' => $user]);
$send = "-NewUsername : @$user ";
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>$send
]);
}catch (\danog\MadelineProto\Exception | \danog\MadelineProto\RPCErrorException $e) {
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>$e->getMessage()
]);
file_put_contents("users","");
exit();
}
}
}
}
}elseif($type == "Channel");
while(1){
if($user !== ""){
try{
$MadelineProto->messages->getPeerDialogs(['peers' => [$user]]);
$x++;
} catch (\danog\MadelineProto\Exception | \danog\MadelineProto\RPCErrorException $e) {
try{
$MadelineProto->channels->updateUsername(['channel' => $updates['updates'][1], 'username' => $user]);
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"- Hi Muslim /n - I Fucked A New Username : @$user ",
]);
}catch (\danog\MadelineProto\Exception | \danog\MadelineProto\RPCErrorException $e) {
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>$e->getMessage()
]);
file_put_contents("user","");
exit();
}
}
}
}