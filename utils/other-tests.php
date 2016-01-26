<?php

# additional tests library
#  - first we enable error display
ini_set('display_errors',1);
#  - next we ensure that all errors are displayed
ini_set('error_reporting',E_ALL);

# include the library itself
require_once(dirname(dirname(__FILE__)) . '/php-iban.php');

print "Other tests:\n";

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
