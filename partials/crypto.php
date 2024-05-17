<?php

define("HASH", "M1A7X4X9");

function encrypt($payload) {
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  $encrypted = openssl_encrypt($payload, 'aes-256-cbc', HASH, 0, $iv);
  return base64_encode($encrypted . '::' . $iv);
}

function decrypt($garble) {
  list($encrypted_data, $iv) = explode('::', base64_decode($garble), 2);
  return openssl_decrypt($encrypted_data, 'aes-256-cbc', HASH, 0, $iv);
}
