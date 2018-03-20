<?php
$access_token = 'wR3VmhhR1/VmzZOsmL23vhaPYB6HpVnIlT2jksuvf7+ascb9FvpbA8ydUp082roxw3/Cye7GwTeKkB7D3L2PC7n9OQI8zExIJTz4tPvekhr6ZuOoeW6/KwxmNE+h+81As7LMlJ1+y+jJnTQOE4Tc9QdB04t89/1O/w1cDnyilFU=';
system("echo \"Recv\n\" >> log");
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
  // Loop through each event
  system("echo \"Recv2\n\" >> log");
  foreach ($events['events'] as $event) {
    system("echo \"Recv3\n\" >> log");
    // Reply only when message sent is in 'text' format
    if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
      system("echo \"Recv4\n\" >> log");
      // Get text sent
      $text = $event['message']['text'];
      // Get replyToken
      $replyToken = $event['replyToken'];
      // Build message to reply back
      $messages = [
        'type' => 'text',
        'text' => $text
      ];
      system("echo \"" . $replyToken . "," . $text . "\n\" >> log");
      // Make a POST Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/reply';
      $data = [
        'replyToken' => $replyToken,
        'messages' => [$messages],
      ];
      $post = json_encode($data);
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close($ch);
      echo $result . "";
    }
  }
}
echo "OKv3";
