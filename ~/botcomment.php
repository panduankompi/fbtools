<?php  
include "config/function.php";

$userid = "100022866621555";
$postid = "241555503283335";
$message = "testcomm";
$token = "EAAAAAYsX7TsBAKP9ZBWKZBoZA2ZCukOBTcjILM2vLsnguNa7pBhcVT5WQEzuwH3bYHZBrvQM9euZAA2nlvNTS0tsmZCVAZCTr0kgZC50NDHakHJgyl4rC4xzZCNxSLJ22bG9GbfCo1NtzMd5RCoJnPcScrsq3w9yApIV0Eaef3xsG1ypwHLUrFWBdNADwZAOA65yUMTOxVqfQFrTVnKmkHXepP1";

// check if comment already exist
$curl = file_get_contents_curl("https://graph.facebook.com/462764390497214/?fields=name&access_token=EAAAAAYsX7TsBAKP9ZBWKZBoZA2ZCukOBTcjILM2vLsnguNa7pBhcVT5WQEzuwH3bYHZBrvQM9euZAA2nlvNTS0tsmZCVAZCTr0kgZC50NDHakHJgyl4rC4xzZCNxSLJ22bG9GbfCo1NtzMd5RCoJnPcScrsq3w9yApIV0Eaef3xsG1ypwHLUrFWBdNADwZAOA65yUMTOxVqfQFrTVnKmkHXepP1");
$result = json_decode($curl);

$check = false;
foreach ($result->data as $row) {
  $uidcomment = $row->from->id;
  if ($userid == $uidcomment) {
    $check = true;
    break;
  }
}

if ($check == false) {
  $url = "https://graph.facebook.com/{$postid}/comments";
  $data = "message=" . urlencode($message)
  . "&fields=permalink_url&access_token={$token}";
  $curl = file_get_contents_curl($url,$data);
  echo $curl;
}else { 
  echo "sudah ada komen dari user ini";
}



?>