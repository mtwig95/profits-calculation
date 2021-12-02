//Access endpoint https://www.become.co/api/rest/test/  via GET request with Basic
// Authentication using the following credentials:
//username: tzinch
//password: r#eD21mA%gNU
<?PHP

$username = 'tzinch';
$password = "r#eD21mA%gNU";
$remote_url = 'https://www.become.co/api/rest/test/';

// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header' => "Authorization: Basic " . base64_encode("$username:$password")                 
  )
);

$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
$file = file_get_contents($remote_url, false, $context);

$fp = fopen('data.json', 'w');
fwrite($fp, json_encode($file));
fclose($fp);

print($file);

?>
