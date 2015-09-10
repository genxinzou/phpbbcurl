<?php
$url = "http://url.co.uk/board/";

$post_fields = 'username=user&password=pass&redirect=&login=Log+in';
$lurl = $url."ucp.php";
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

$purl = url&"posting.php?mode=post&f=20&sid=$sid";
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