<?php

namespace WappoVendor\Egulias\EmailValidator\Result;

use WappoVendor\Egulias\EmailValidator\Result\Reason\SpoofEmail as ReasonSpoofEmail;
class SpoofEmail extends InvalidEmail
{
    public function __construct()
    {
        $this->reason = new ReasonSpoofEmail();
        parent::__construct($this->reason, '');
    }
}
