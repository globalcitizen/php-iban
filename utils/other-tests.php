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

print "All tests passed.\n";
exit(0);
?>
