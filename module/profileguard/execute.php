<?php
if (@$_POST) {
    if (@$_POST['profileguardon']) {
        $status = "true";
    }elseif (@$_POST['profileguardoff']) {
        $status = "false";
    }
    $token = $_SESSION['token'];
    $md5 = md5(time());
    $hash = substr($md5, 0, 8)."-".substr($md5, 8, 4)."-".substr($md5, 12, 4)."-".substr($md5, 16, 4)."-".substr($md5, 20, 12);

    $me = json_decode(file_get_contents_curl("https://graph.facebook.com/me?fields=id&access_token=".$token));
    if($me && $me->id) {
        $var = "{\"0\":{\"is_shielded\":{$status},\"session_id\":\"$hash\",\"actor_id\":\"$me->id\",\"client_mutation_id\":\"$hash\"}}";
        $hajar = json_decode(file_get_contents_curl("https://graph.facebook.com/graphql", array(
            "variables" => $var,
            "doc_id" => "1477043292367183",
            "query_name" => "IsShieldedSetMutation",
            "strip_defaults" => "{$status}",
            "strip_nulls" => "{$status}",
            "locale" => "en_US",
            "client_country_code" => "US",
            "fb_api_req_friendly_name" => "IsShieldedSetMutation",
            "fb_api_caller_class" => "IsShieldedSetMutation",
            "access_token" => $token
            )));

        if($hajar->data->is_shielded_set->is_shielded == true) {
            $_SESSION['execute'] = "<script> sweetAlert('Hore!', 'Berhasil Mendapatkan Profile Guard! Silahkan cek profile facebook anda', 'success'); </script>";
        }elseif($hajar->data->is_shielded_set->is_shielded == false) {
            $_SESSION['execute'] = "<script> sweetAlert('Hore!', 'Berhasil Menghilangkan Profile Guard! Silahkan cek profile facebook anda', 'success'); </script>";
        }else {
            $_SESSION['execute'] = "<script> sweetAlert('Ehmm!', 'Gagal Mendapatkan Profile Guard!', 'error'); </script>";
        }
    }
}
?>