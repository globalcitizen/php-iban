<?php

# Basic test script for the object-oriented version of the php-iban library
#  - Exit status is 0 in case of success, or the number of failed tests
#    in case of failure

# Engine configuration
#  - first we enable error display
ini_set('display_errors',1);
#  - next we ensure that all errors are displayed
ini_set('error_reporting',E_ALL);

# include the object oriented version of the library itself
require_once(dirname(dirname(__FILE__)) . '/oophp-iban.php');

# display registry contents
#print_r($_iban_registry);

# init
$errors=0;

# Try to validate an invalid IBAN
$iban = "(@#(*@*ZV-This is NOT an IBAN!";
$myIban = new IBAN($iban);
if($myIban->verify()) {
 print "ERROR: An invalid IBAN was validated!\n";
 $errors++;
}
print "Hooray! - Invalid IBAN successfully rejected.\n\n";

# Broken IIBAN
$broken_iiban = 'AA12011123ZS6';
$myIban = new IBAN($broken_iiban);
$suggestions = $myIban->MistranscriptionSuggestions();
if(count($suggestions)) {
 print "Hooray!  Successfully derived '" . implode(',',$suggestions) . "' as likely transcription error source suggestion(s) for the incorrect IBAN $broken_iiban.\n";
}
else {
 print "ERROR: Not able to ascertain suggested transcription error source(s) for $broken_iiban.\n";
}
print "\n";

# Get list of countries
$countries = $myIban->Countries();

# Loop through the registry's examples, validating
foreach($countries as $countrycode) {

 # instantiate
 $myCountry = new IBANCountry($countrycode);

 # start section
 print "[$countrycode: " . $myCountry->Name() . "]\n";

 # output remaining country properties
 print "Is a SEPA member? ";
 if($myCountry->IsSEPA()) { print "Yes"; } else { print "No"; }
 print ".\n";

 # get example iban
 $myIban = new IBAN($myCountry->IBANExample());

 # output example iban properties one by one
 print "Example IBAN: " . $myIban->HumanFormat() . "\n";
 print " - country  " . $myIban->Country() . "\n";
 print " - checksum " . $myIban->Checksum() . "\n";
 print " - bban     " . $myIban->BBAN() . "\n";
 print " - bank     " . $myIban->Bank() . "\n";
 print " - branch   " . $myIban->Branch() . "\n";
 print " - account  " . $myIban->Account() . "\n";
 
 # output all properties
 #$parts = $myIban->Parts();
 #print_r($parts);
 
 # verify
 print "\nChecking validity... ";
 if($myIban->Verify()) {
  print "IBAN $myIban->iban is valid.\n";
 }
 else {
  print "ERROR: IBAN $myIban->iban is invalid.\n";
  $errors++;
 }

 print "\n";
}

exit($errors);

?>
