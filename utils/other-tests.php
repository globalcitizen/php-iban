<?php

# additional tests library
#  - first we enable error display
ini_set('display_errors',1);
#  - next we ensure that all errors are displayed
ini_set('error_reporting',E_ALL);

# include the library itself
require_once(dirname(dirname(__FILE__)) . '/php-iban.php');

print "Other tests:\n";

# === verify_iban machine_format_only mode ===============================
$test_data = array(
			      # input					# machine_format_only?	# expected
			array('GB29 NWBK 6016 1331 9268 19',		true,			false),		# spaces present, machine_format_only mode
			array('GB29 NWBK 6016 1331 9268 19',		false,			true),		# spaces present, normal (relaxed) mode
			array('IBAN GB29-NWBK-6016-1331-9268 19',	true,			false),		# spaces + prefix + dashes, machine_format_only
			array('IBAN GB29-NWBK-6016-1331-9268 19',	false,			true),		# spaces + prefix + dashes, normal mode
			array('IIBAN GB29-NWBK-6016-1331-9268 19',	false,			true),		# spaces + prefix + dashes, normal mode
             );
$i=0;
foreach($test_data as $this_test) {
 print " - verify_iban() test #$i... ";
 
 if(verify_iban($this_test[0],$this_test[1]) !== $this_test[2]) {
  print "FAILED.\n";
  exit(1);
 }
 else {
  print "OK.\n";
 }
 $i++;
}

# === swift_official field ===================================
print " - SWIFT official check for 'AA'... ";
if(iban_country_get_country_swift_official('AA')) {
 print "FAILED.\n";
 exit(1);
}
else {
 print "OK.\n";
}

print " - SWIFT official check for 'VG'... ";
if(!iban_country_get_country_swift_official('VG')) {
 print "FAILED.\n";
 exit(1);
}
else {
 print "OK.\n";
}

# === iban_to_human_format ===================================
# case of already in human format (unofficial country)
$test_data = array(     # input				=>			# expected output
			'AA11 0011 123Z 5678' 		=> 			'AA11 0011 123Z 5678',			# already done (unofficial country)
			'VG96VPVG0000012345678901' 	=> 			'VG96 VPVG 0000 0123 4567 8901',	# machine format (official country)
			' VG96VPVG0000012345678901 '	=>			'VG96 VPVG 0000 0123 4567 8901'		# as above, extra whitespace
                  );
$i=0;
foreach($test_data as $input=>$expected_output) {
 print " - iban_to_human_format() test #$i... ";
 $received_output = iban_to_human_format($input);
 if($received_output != $expected_output) {
  print "FAILED (expected '$expected_output', received '$received_output')\n";
  exit(1);
 }
 else {
  print "OK.\n";
 }
 $i++;
}

# === iban_get_nationalchecksum_part ========================
$test_data = array(	# input				=>	# expected output
			'AL47212110090000000235698741'	=>	'9',
			'ES9121000418450200051332'	=>	'45',
			'BE68 5390 0754 7034'		=>	'34'
	     );
$i=0;
foreach($test_data as $input=>$expected_output) {
 print " - iban_get_nationalchecksum_part() test #$i... ";
 $received_output = iban_get_nationalchecksum_part($input);
 if($received_output != $expected_output) {
  print "FAILED (expected '$expected_output', received '$received_output')\n";
  exit(1);
 }
 else {
  print "OK.\n";
 }
 $i++;
}

# === iban_country_get_iana ==================================
$test_data = array(	# input				=>	# expected output
			'AA'				=>	'',			# IIBAN has no IANA code
			'XK'				=>	'',			# Kosovo has no IANA code
			'BL'				=>	'',			# Saint Barthélemy has no IANA code
			'MF'				=>	'',			# Saint Martin (French Part) has no IANA code
			'MQ'				=>	'mq',			# Martinique is .mq
			'GB'				=>	'uk'			# Great Britain is .uk
	     );
$i=0;
foreach($test_data as $input=>$expected_output) {
 print " - iban_country_get_iana() test #$i... ";
 $received_output = iban_country_get_iana($input);
 if($received_output != $expected_output) {
  print "FAILED (expected '$expected_output', received '$received_output')\n";
  exit(1);
 }
 else {
  print "OK.\n";
 }
 $i++;
}

# === iban_country_get_iso3166 ==============================
$test_data = array(	# input				=>	# expected output
			'AA'				=>	'',			# IIBAN has no country
			'XK'				=>	'',			# Kosovo no longer ISO-allocated
			'GB'				=>	'GB'			# Great Britain has different IANA code, same ISO3166-1 alpha-2
	     );
$i=0;
foreach($test_data as $input=>$expected_output) {
 print " - iban_country_get_iso3166() test #$i... ";
 $received_output = iban_country_get_iso3166($input);
 if($received_output != $expected_output) {
  print "FAILED (expected '$expected_output', received '$received_output')\n";
  exit(1);
 }
 else {
  print "OK.\n";
 }
 $i++;
}

# === iban_country_is_sepa ===================================
$test_data = array(	# input				=>	# expected output
			'DE'				=>	true,			# Germany is SEPA
			'VA'				=>	true,			# Vatican City State is SEPA (SWIFT registry)
			'BI'				=>	false,			# Burundi is not SEPA
			'DJ'				=>	false,			# Djibouti is not SEPA
			'HN'				=>	false,			# Honduras is not SEPA
			'NI'				=>	false,			# Nicaragua is not SEPA
			'LY'				=>	false			# Libya is not SEPA
	     );
$i=0;
foreach($test_data as $input=>$expected_output) {
 print " - iban_country_is_sepa() test #$i... ";
 $received_output = (bool)iban_country_is_sepa($input);
 if($received_output !== $expected_output) {
  print "FAILED (expected '" . var_export($expected_output,true) . "', received '" . var_export($received_output,true) . "')\n";
  exit(1);
 }
 else {
  print "OK.\n";
 }
 $i++;
}

# === Belgian (BE) national checksum ============================
# The check is the BBAN (less the check) mod 97, as two digits.
# A remainder of 0 gives check '97'. A remainder below 10 keeps
# its leading zero.
$test_data = array(	# input				# expected national checksum
			array('BE54310000010897',		'97'),	# 3100000108 mod 97 = 0
			array('BE74310000011507',		'07'),	# 3100000115 mod 97 = 7
			array('BE68539007547034',		'34'),	# SWIFT registry example
             );
foreach($test_data as $this_test) {
 list($input,$expected) = $this_test;
 print " - Belgian national checksum for '$input'... ";
 $found = iban_find_nationalchecksum($input);
 if($found !== $expected) {
  print "FAILED (find: expected '$expected', received '$found')\n";
  exit(1);
 }
 if(iban_verify_nationalchecksum($input) !== true) {
  print "FAILED (verify did not return true)\n";
  exit(1);
 }
 # break the check, then set it again
 $broken = substr($input,0,-2) . ($expected == '11' ? '12' : '11');
 $fixed = iban_set_nationalchecksum($broken);
 if($fixed !== $input) {
  print "FAILED (set: expected '$input', received '$fixed')\n";
  exit(1);
 }
 print "OK.\n";
}

# === registry countries ======================================
# Countries listed as supported in README.md must be in the registry
$test_data = array('FK','LY','MN','SO');
foreach($test_data as $input) {
 print " - registry has '$input'... ";
 if(!in_array($input,iban_countries())) {
  print "FAILED.\n";
  exit(1);
 }
 else {
  print "OK.\n";
 }
}

# Verify all of the example IBANs using the validate-list script
$example_ibans_dir = dirname(__FILE__) . '/example-ibans/';
if(!file_exists($example_ibans_dir) && is_dir($example_ibans_dir)) {
 print "Example IBANs library is missing, not found or is not a directory at '" . $example_ibans_dir . "'.\n";
 exit(99);
}
print "\nTesting example IBANs by country...\n";
if ($dh = opendir($example_ibans_dir)) {
 while (($file = readdir($dh)) !== false) {
  $file = $example_ibans_dir . '/' . $file;
  # only process files
  if(filetype($file) == 'file') {
   print ' - ' . basename($file) . '... ';
   $cmd = "php " . dirname(__FILE__) . '/validate-list.php ' . escapeshellarg($file);
   $output=array();
   exec($cmd,$output,$exit_code);
   if($exit_code !== 0) {
    print "FAILED.\n================ output was ===================\n";
    print join("\n",$output) . "\n";
    exit(1);
   }
   else {
    print "ok\n";
   }
  }
 }
 closedir($dh);
}
else {
 print "Failed to open example IBANs directory at '" . $example_ibans_dir . "'!";
 exit(99);
}

print "All tests passed.\n";
exit(0);
?>
