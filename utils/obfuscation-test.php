<?php
require_once('../php-iban.php');
$ibans = `cat example-ibans/*`;
$lines = explode("\n",$ibans);
foreach($lines as $iban) {
 $iban = iban_to_machine_format($iban);
 print iban_to_human_format($iban) . "\n";
 print iban_to_obfuscated_format($iban) . "\n";
}
?>
