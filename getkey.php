<?php 
if(!file_exists(__DIR__ . '/data.json')) {
  echo 'data.json not found!';
  exit();
}

if (!isset($_GET['h'])) {
    header('Location: https://68aj7au2j8ikw88jjw782onw7.onion/go-back.html'); 
    exit();
}
    
function getKey() {
    $hwid = $_GET['h'];
    $json_file = file_get_contents(__DIR__ . '/data.json');
    $json = json_decode($json_file, true);

    if(empty($json['hwids'][$hwid]) || $json['hwids'][$hwid] <= time()) {
        unset($json['hwids'][$hwid]);
        $json['hwids'][$hwid] = time() + 60 * 60 * 3; // 3 hours
        file_put_contents(__DIR__ . '/data.json', json_encode($json));
    }

    $key = sha1($json['hwids'][$hwid]);
    return $key;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    
    <style>
      *{margin: 0;padding: 0;box-sizing: border-box;font-family: Ubuntu, 'Segoe UI'}html,body{height: 100%;background: #121212}.container{height: 100%;display: flex;align-items: center;justify-content: center;flex-direction: column}.card{width: 460px;background: #1E1E1E;border-radius: 3px;border: none;padding: 24px;margin: 8px 0}.card-title{text-align: center;font-size: 20px;font-weight: 500;display: block;margin-bottom: 15px;color: #BB86FC}.card-description{text-align: center;font-size: 14px;color: #E1E1E1;display: block}.card-key{width: 100%;height: 35px;border-radius: 4px;border: none;padding: 0 10px 0 10px;overflow: hidden;color: #969696;background: #1A1A1A;margin-bottom: 10px}*:focus{outline: none}.key-container{position: relative;margin-bottom: 10px}.card-button{height: 30px;width: 100%;padding: 0 14px;background: #C38FFF;color: #1E1E1E;border-radius: 4px;border: none;font-weight: 500;font-size: medium;box-shadow: 0 2px 3px -1px rgba(0, 0, 0, .14)}
    </style>

    <title>Simple Key System</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <center>
                <p class="card-title">Simple Key System</p>
                <span class="card-description">
                This is your temporary key, using it you will gain access to the exploit for 3 hours. 

                It will work only for you.
                </span>
            </center>
            <br>
            <key class="key-container">
                <input readonly type="text" class="card-key" id="key" value="<?php echo getKey(); ?>"></key>
                <button onclick="copyKey()" class="card-button">Copy Key</button>
            </key>
        </div>
    </div>

    <script>
        function copyKey(){
            document.getElementById("key").select();
            document.execCommand("copy");
        }
    </script>
</body>
</html>