<?php

require_once(dirname(__FILE__) . '/php-iban.php');

# OO wrapper for 'php-iban.php'

/**
 * Class IBAN
 */
class IBAN
{

    /** @var string */
    protected $iban;

    /**
     * @param null $iban
     */
    public function __construct($iban = null)
    {
        $this->iban = $iban;
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param null $iban
     * @param bool $machine_format_only
     *
     * @return bool
     */
    public function Verify($iban = null, $machine_format_only = false)
    {
        if ($iban !== null) {
            return verify_iban($iban, $machine_format_only);
        }

        return verify_iban($this->iban, $machine_format_only);
        # we could throw exceptions of various types, but why - does it really
        # add anything? possibly some slightly better user feedback potential.
        # however, this can be written by hand by performing individual checks
        # ala the code in verify_iban() itself where required, which is likely
        # almost never. for the increased complexity and
        # maintenance/documentation cost, i say, therefore: no. no exceptions.
    }

    /**
     * @param null $iban
     *
     * @return bool
     */
    public function VerifyMachineFormatOnly($iban = null)
    {
        if ($iban != '') {
            return verify_iban($iban, true);
        }

        return verify_iban($this->iban, true);
    }

    /**
     * @return array
     */
    public function MistranscriptionSuggestions()
    {
        return iban_mistranscription_suggestions($this->iban);
    }

    /**
     * @return null|string|string[]
     */
    public function MachineFormat()
    {
        return iban_to_machine_format($this->iban);
    }

    /**
     * @return string
     */
    public function HumanFormat()
    {
        return iban_to_human_format($this->iban);
    }

    /**
     * @return bool|string
     */
    public function Country()
    {
        return iban_get_country_part($this->iban);
    }

    /**
     * @return bool|string
     */
    public function Checksum()
    {
        return iban_get_checksum_part($this->iban);
    }

    /**
     * @return bool|string
     */
    public function NationalChecksum()
    {
        return iban_get_nationalchecksum_part($this->iban);
    }

    /**
     * @return bool|string
     */
    public function BBAN()
    {
        return iban_get_bban_part($this->iban);
    }

    /**
     * @return bool
     */
    public function VerifyChecksum()
    {
        return iban_verify_checksum($this->iban);
    }

    /**
     * @return string
     */
    public function FindChecksum()
    {
        return iban_find_checksum($this->iban);
    }

    /**
     *
     */
    public function SetChecksum()
    {
        $this->iban = iban_set_checksum($this->iban);
    }

    /**
     * @return mixed
     */
    public function ChecksumStringReplace()
    {
        return iban_checksum_string_replace($this->iban);
    }

    /**
     * @return string
     */
    public function FindNationalChecksum()
    {
        return iban_find_nationalchecksum($this->iban);
    }

    /**
     *
     */
    public function SetNationalChecksum()
    {
        $this->iban = iban_set_nationalchecksum($this->iban);
    }

    /**
     * @return string
     */
    public function VerifyNationalChecksum()
    {
        return iban_verify_nationalchecksum($this->iban);
    }

    /**
     * @return array
     */
    public function Parts()
    {
        return iban_get_parts($this->iban);
    }

    /**
     * @return bool|string
     */
    public function Bank()
    {
        return iban_get_bank_part($this->iban);
    }

    /**
     * @return bool|string
     */
    public function Branch()
    {
        return iban_get_branch_part($this->iban);
    }

    /**
     * @return bool|string
     */
    public function Account()
    {
        return iban_get_account_part($this->iban);
    }

    /**
     * @return array
     */
    public function Countries()
    {
        return iban_countries();
    }
}

/**
 * Class IBANCountry
 */
Class IBANCountry
{

    /** @var string */
    protected $code;

    /**
     * @param string $code
     */
    function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function Code()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function Name()
    {
        return iban_country_get_country_name($this->code);
    }

    /**
     * @return mixed
     */
    public function DomesticExample()
    {
        return iban_country_get_domestic_example($this->code);
    }

    /**
     * @return mixed
     */
    public function BBANExample()
    {
        return iban_country_get_bban_example($this->code);
    }

    /**
     * @return mixed
     */
    public function BBANFormatSWIFT()
    {
        return iban_country_get_bban_format_swift($this->code);
    }

    /**
     * @return mixed
     */
    public function BBANFormatRegex()
    {
        return iban_country_get_bban_format_regex($this->code);
    }

    /**
     * @return mixed
     */
    public function BBANLength()
    {
        return iban_country_get_bban_length($this->code);
    }

    /**
     * @return mixed
     */
    public function IBANExample()
    {
        return iban_country_get_iban_example($this->code);
    }

    /**
     * @return mixed
     */
    public function IBANFormatSWIFT()
    {
        return iban_country_get_iban_format_swift($this->code);
    }

    /**
     * @return mixed
     */
    public function IBANFormatRegex()
    {
        return iban_country_get_iban_format_regex($this->code);
    }

    /**
     * @return mixed
     */
    public function IBANLength()
    {
        return iban_country_get_iban_length($this->code);
    }

    /**
     * @return mixed
     */
    public function BankIDStartOffset()
    {
        return iban_country_get_bankid_start_offset($this->code);
    }

    /**
     * @return mixed
     */
    public function BankIDStopOffset()
    {
        return iban_country_get_bankid_stop_offset($this->code);
    }

    /**
     * @return mixed
     */
    public function BranchIDStartOffset()
    {
        return iban_country_get_branchid_start_offset($this->code);
    }

    /**
     * @return mixed
     */
    public function BranchIDStopOffset()
    {
        return iban_country_get_branchid_stop_offset($this->code);
    }

    /**
     * @return mixed
     */
    public function NationalChecksumStartOffset()
    {
        return iban_country_get_nationalchecksum_start_offset($this->code);
    }

    /**
     * @return mixed
     */
    public function NationalChecksumStopOffset()
    {
        return iban_country_get_nationalchecksum_stop_offset($this->code);
    }

    /**
     * @return mixed
     */
    public function RegistryEdition()
    {
        return iban_country_get_registry_edition($this->code);
    }

    /**
     * @return mixed
     */
    public function SWIFTOfficial()
    {
        return iban_country_get_country_swift_official($this->code);
    }

    /**
     * @return mixed
     */
    public function IsSEPA()
    {
        return iban_country_is_sepa($this->code);
    }

    /**
     * @return mixed
     */
    public function IANA()
    {
        return iban_country_get_iana($this->code);
    }

    /**
     * @return mixed
     */
    public function ISO3166()
    {
        return iban_country_get_iso3166($this->code);
    }

    /**
     * @return mixed
     */
    public function ParentRegistrar()
    {
        return iban_country_get_parent_registrar($this->code);
    }

    /**
     * @return mixed
     */
    public function CurrencyISO4217()
    {
        return iban_country_get_currency_iso4217($this->code);
    }

    /**
     * @return mixed|string
     */
    public function CentralBankURL()
    {
        return iban_country_get_central_bank_url($this->code);
    }

    /**
     * @return mixed
     */
    public function CentralBankName()
    {
        return iban_country_get_central_bank_name($this->code);
    }

}
