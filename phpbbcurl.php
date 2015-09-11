<?php
/*
icon=0&subject=title&addbbcode20=100&message=content&lastclick=1441959638&post=Submit&attach_sig=on&show_panel=attach-panel&creation_time=1441959638&form_token=4deb4300e605d8f7cb00e7cff8162d4395e0ed97
http://phpbb.com/posting.php?mode=post&f=2
*/
function sendStreamFile($url, $file){  
  
    if(file_exists($file)){  
  
        $opts = array(  
            'http' => array(  
                'method' => 'POST',  
                'header' => 'content-type:application/x-www-form-urlencoded',  
                'content' => file_get_contents($file)  
            )  
        );  
  
        $context = stream_context_create($opts);  
        $response = file_get_contents($url, false, $context);  
        $ret = json_decode($response, true);  
        return $ret['success'];  
  
    }else{  
        return false;  
    }  
  
}  

$url = "http://url.co.uk/board/";
#登录
#$post_fields = 'username=user&password=pass&redirect=&login=Log+in';
$post_fields = 'username=niunaijidan&password=xs19891227&redirect=index.php&login=Login';
#$lurl = $url."ucp.php";
$lurl = "http://phpbb.com/ucp.php?mode=login";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$lurl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_COOKIEJAR,"cookie.txt");
$result= curl_exec ($ch);
curl_close ($ch);
$sid1 = explode("sid=",$result);
$sid2 = explode('&',$sid1[1]);
$sid = rtrim(substr($sid2[0], 0, -29),'"');
#发帖
#$purl = url&"posting.php?mode=post&f=20&sid=$sid";
$purl = "http://phpbb.com/posting.php?mode=post&f=2";
var_dump($purl);
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL,$purl);
curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
curl_setopt ($ch1, CURLOPT_HEADER, false );
curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch1,CURLOPT_COOKIEFILE,"cookie.txt");
$result1= curl_exec ($ch1);
curl_close ($ch1);

preg_match('%name="form_token" value="(.*)"\ /\>%',$result1,$security123);
preg_match('%name="lastclick" value="(.*)"\ /\>%',$result1,$lastclick);
preg_match('%name="creation_time" value="(.*)"\ /\>%',$result1,$ctime1);
$lclick = explode('" />',$lastclick[1]);

$title = "title";
$subject = "subject to post";
$post_fields = array(
'subject'   => $title,
'message'   => htmlspecialchars_decode($subject),
'icon'      => 0,
'poll_title' => "Poll Name",
'poll_option_text' => "poll 1\r\npoll 2",
'poll_max_options' => 1,
'poll_length' => 0,
'poll_vote_change' => "on",
'disable_smilies'   => 0,
'attach_sig'        => 1,
'notify'           => 0,
'topic_type'         => 2,
'topic_time_limit'   => "",
'creation_time'      => $ctime1[1],
'lastclick'          => $lclick[0],
'form_token'   => $security123[1],
'sid'     =>  $sid,
'post'   => 'Submit',
);
print_r($post_fields);
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL,$purl);
curl_setopt($ch1, CURLOPT_POST, 1);
curl_setopt($ch1, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
curl_setopt ($ch1, CURLOPT_HEADER, false );
curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch1,CURLOPT_COOKIEFILE,"cookie.txt");
$result2= curl_exec ($ch1);
if(curl_errno($ch1))
{
    echo 'Curl error: ' . curl_error($ch1);
}
curl_close ($ch1);
echo $result2;
?>