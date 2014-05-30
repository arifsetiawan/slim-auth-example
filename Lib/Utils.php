<?php

//
// Send JSON data and end slim request using halt()
function endResponse($code, $status, $message, $data, $app) {
  $result['status'] = $status;
  $result['message'] = $message;
  if (isset($data)) {
    $result['data'] = $data;
  }
  $app->halt($code, json_encode($result));
};