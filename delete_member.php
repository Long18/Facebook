<?php
ini_set('max_execution_time', 0);
//token full quyền
$token   = "EAAD4tyD9cRABAGH0VHQi2fNLVtWZByHwy5D3eeBg9LPDhPIbk1wYDF1w0biAlyMFIGK18mTa8hrDBb5FNJRaAQP6ZCDwYSZBwhBQrgxV8HrPCEKUiG6f8DQ8ZC5o8r41KDc5jAVNOFUp0pwLzPIcpSjTq9vNxTT48VAS5HU2s5w8ZCRVUQkngAimv7FNnhAsZD";
//điền ID nhóm
$id_nhom = "194840530871071";
//điền ID ban quản trị
$array_admin = ["100012655035344","100011651177359","100004079747487"];
$link    = "https://graph.facebook.com/$id_nhom/members?fields=id&limit=5000&access_token=$token"; 
while (true) {
   $curl    = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data     = json_decode($response,JSON_UNESCAPED_UNICODE);
    $datas = $data["data"];
    foreach($datas as $each){
        if(in_array($each["id"],$array_admin)) continue;
        $id_mem = $each["id"];
        $link   = "https://graph.facebook.com/$id_nhom/members?method=delete&member=$id_mem&access_token=$token";
        $curl   = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        curl_exec($curl);
        curl_close($curl);
        sleep(5);
    }
    if(!empty($data["paging"]["next"])){
        $link = $data["paging"]["next"];
    }
    else{
        break;
    }
}

?>
