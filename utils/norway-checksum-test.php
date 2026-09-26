<?php

require_once(dirname(__DIR__) . '/php-iban.php');

$example = 'NO9386011117947';
if (iban_find_nationalchecksum($example) !== '7' || iban_verify_nationalchecksum($example) !== true) {
 print "official Norway example failed\n";
 exit(1);
}
if (iban_set_nationalchecksum($example) !== $example) {
 print "official Norway example was rewritten\n";
 exit(1);
}

$broken = 'NO0012345678900';
$found = iban_find_nationalchecksum($broken);
if ($found !== '3') {
 print "expected check digit 3, got " . var_export($found, true) . "\n";
 exit(1);
}
$fixed = iban_set_nationalchecksum($broken);
if (iban_get_nationalchecksum_part($fixed) !== '3' || iban_verify_nationalchecksum($fixed) !== true) {
 print "set result did not verify: $fixed\n";
 exit(1);
}

$impossible = 'NO0010001000000';
if (iban_find_nationalchecksum($impossible) !== '' || iban_verify_nationalchecksum($impossible) !== false) {
 print "a remainder of 1 should have no check digit\n";
 exit(1);
}

print "ok\n";
