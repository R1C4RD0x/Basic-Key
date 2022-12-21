<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['h']) or !isset($_GET['k'])) {
  returnMessage('error', 'HWID_OR_KEY_MISSING');
  exit();
}

$hwid = $_GET['h'];
$key = $_GET['k'];

$json_file = file_get_contents( __DIR__ . '/data.json');
$json = json_decode($json_file, true);

if (!empty($json['hwids'][$hwid])) {
  $keyDB = sha1($json['hwids'][$hwid]);
  if ($key === $keyDB) {
    if (time() >= $json['hwids'][$hwid]) {
      returnMessage('error', 'EXPIRED_KEY');
    } else {
      returnMessage('success', 'VALID_KEY');
    }
  } else {
    returnMessage('error', 'INVALID_KEY');
  }
} else {
  returnMessage('error', 'HWID_NOT_FOUND');
}

function returnMessage($status, $message) {
  echo json_encode(['status' => $status, 'message' => $message]);
}