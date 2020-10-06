<?php 
$info = json_decode(file_get_contents('info.json'),true);
if(!file_exists('info.json')) { 
$token =  readline("- Enter Token : ");
$id = readline("- Enter Id Sudo : ");
$info["token"] = "$token";
file_put_contents('info.json', json_encode($info));
$info["id"] = "$id";
file_put_contents('info.json', json_encode($info));
$info["name"] = "a";
file_put_contents('info.json', json_encode($info));
}
$token = $info["token"];
define('API_KEY',$token);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res,true);
    }
}
function stats($nn) {
$st = "";
$x = shell_exec("pm2 show $nn");
if(preg_match("/online/", $x)) {
$st = "run";
}else{
$st = "stop";
}
return $st;
}
$lastupdid = 1; 
while(true){ 
 $upd = bot("getUpdates", ["offset" => $lastupdid]); 
 if(isset($upd['result'][0])){ 
  $text = $upd['result'][0]['message']['text']; 
  $chat_id = $upd['result'][0]['message']['chat']['id']; 
$from_id = $upd['result'][0]['message']['from']['id']; 
$message = $upd['result'][0]['message']; 
$nn = bot('getme', ['bot']) ["result"]["username"];
$date = $update['callback_query']['data'];
$info = json_decode(file_get_contents('info.json'),true);
$value = "";
$admin = $info["id"];
if ($chat_id == $admin) {
if ($text == "/start") {
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "𝗪𝗲𝗹𝗰𝗼𝗺𝗲 𝗧𝗼 𝗠𝘂𝘀𝗹𝗶𝗺 𝗖𝗵𝗲𝗰𝗸𝗲𝗿 𝗕𝗮𝗯𝘆",
'reply_markup' => json_encode(['resize_keyboard' => true, 'keyboard' => [ 
[["text" => "Run"],  
["text" => "Stop"]], 
[["text" => "Pin User"]], 
[["text" => "Checker info"]],  
[["text" => "Set Account"],  
["text" => "Set Channel"]],
[["text" => "Users"],  
["text" => "Delete all users"]],  
[["text" => "Change phone number"]],
], 
]) 
]); 
}
if($text == "Change phone number") {
system('rm -rf *ma*');
file_put_contents("step","");
if(file_get_contents("step") == ""){
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Send me Number Phone\n ex +**",
]);
file_put_contents("step","2");
  system('php ph.php');
}
}
if ($text == "Set Account") {
$type = file_get_contents("type.txt");
file_put_contents("type.txt", "Account");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "Done select Account take"]);
system("pm2 stop $nn");
system("pm2 start checker.php --name $nn");
}
if($text == "Set Channel") {
$type = file_get_contents("type.txt");
file_put_contents("type.txt", "Channel");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "Done Select Channel take"]);
system("pm2 stop $nn");
system("pm2 start checker.php --name $nn");
}
if($text == "Checker info") {
$type = file_get_contents("type.txt");
$n = file_get_contents("name");
$msg = file_put_contents("msg");
$st = stats($nn);
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "checker stats : $st\ntype : $type", 
]);
}
if($value == "name"){
file_put_contents("name", $text);
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' =>" Done Set This Name",
]);
$value = "";
}
if($text == "Users"){
if(file_get_contents('users') !== ""){
$se = explode("\n",file_get_contents("users"));
$u = "";
for($i=0; $i<count($se); $i++){
$n1 = $i + 1;
$u .= $n1." - | @".$se[$i]."\n";
}
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>" - Done pin on : \n".$u,
]);
$u = "";
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>" No users in list ",
]);
}
}
if($text == "Pin User"){
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' =>" - Send Ex : /add @Txxxx \n For pinned",
]);
}
if(preg_match("/\/add(.*)/", $text)) {
$str = str_replace("@","",$text);
$ex = explode('/add ',$str)[1];
file_put_contents("users",$ex);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"done @$ex added to list",
]);
}
if($text == "Delete all users"){
	file_put_contents("users","");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' =>" Done Delete all users",
]);
}
if ($text == "Run") {
system("pm2 stop $nn");
system("pm2 start checker.php --name $nn");
}
if ($text == "Stop") {
system("pm2 stop $nn");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "Done stop checker"]);
			}
		}
$lastupdid = $upd['result'][0]['update_id'] + 1; 
} 
}