<?php

namespace WappoVendor\Egulias\EmailValidator\Parser;

use WappoVendor\Doctrine\Common\Lexer\Token;
use WappoVendor\Egulias\EmailValidator\EmailLexer;
use WappoVendor\Egulias\EmailValidator\Warning\TLD;
use WappoVendor\Egulias\EmailValidator\Result\Result;
use WappoVendor\Egulias\EmailValidator\Result\ValidEmail;
use WappoVendor\Egulias\EmailValidator\Result\InvalidEmail;
use WappoVendor\Egulias\EmailValidator\Result\Reason\DotAtEnd;
use WappoVendor\Egulias\EmailValidator\Result\Reason\DotAtStart;
use WappoVendor\Egulias\EmailValidator\Warning\DeprecatedComment;
use WappoVendor\Egulias\EmailValidator\Result\Reason\CRLFAtTheEnd;
use WappoVendor\Egulias\EmailValidator\Result\Reason\LabelTooLong;
use WappoVendor\Egulias\EmailValidator\Result\Reason\NoDomainPart;
use WappoVendor\Egulias\EmailValidator\Result\Reason\ConsecutiveAt;
use WappoVendor\Egulias\EmailValidator\Result\Reason\DomainTooLong;
use WappoVendor\Egulias\EmailValidator\Result\Reason\CharNotAllowed;
use WappoVendor\Egulias\EmailValidator\Result\Reason\DomainHyphened;
use WappoVendor\Egulias\EmailValidator\Result\Reason\ExpectingATEXT;
use WappoVendor\Egulias\EmailValidator\Parser\CommentStrategy\DomainComment;
use WappoVendor\Egulias\EmailValidator\Result\Reason\ExpectingDomainLiteralClose;
use WappoVendor\Egulias\EmailValidator\Parser\DomainLiteral as DomainLiteralParser;
class DomainPart extends PartParser
{
    public const DOMAIN_MAX_LENGTH = 253;
    public const LABEL_MAX_LENGTH = 63;
    /**
     * @var string
     */
    protected $domainPart = '';
    /**
     * @var string
     */
    protected $label = '';
    public function parse() : Result
    {
        $this->lexer->clearRecorded();
        $this->lexer->startRecording();
        $this->lexer->moveNext();
        $domainChecks = $this->performDomainStartChecks();
        if ($domainChecks->isInvalid()) {
            return $domainChecks;
        }
        if ($this->lexer->token['type'] === EmailLexer::S_AT) {
            return new InvalidEmail(new ConsecutiveAt(), $this->lexer->token['value']);
        }
        $result = $this->doParseDomainPart();
        if ($result->isInvalid()) {
            return $result;
        }
        $end = $this->checkEndOfDomain();
        if ($end->isInvalid()) {
            return $end;
        }
        $this->lexer->stopRecording();
        $this->domainPart = $this->lexer->getAccumulatedValues();
        $length = \strlen($this->domainPart);
        if ($length > self::DOMAIN_MAX_LENGTH) {
            return new InvalidEmail(new DomainTooLong(), $this->lexer->token['value']);
        }
        return new ValidEmail();
    }
    private function checkEndOfDomain() : Result
    {
        $prev = $this->lexer->getPrevious();
        if ($prev['type'] === EmailLexer::S_DOT) {
            return new InvalidEmail(new DotAtEnd(), $this->lexer->token['value']);
        }
        if ($prev['type'] === EmailLexer::S_HYPHEN) {
            return new InvalidEmail(new DomainHyphened('Hypen found at the end of the domain'), $prev['value']);
        }
        if ($this->lexer->token['type'] === EmailLexer::S_SP) {
            return new InvalidEmail(new CRLFAtTheEnd(), $prev['value']);
        }
        return new ValidEmail();
    }
    private function performDomainStartChecks() : Result
    {
        $invalidTokens = $this->checkInvalidTokensAfterAT();
        if ($invalidTokens->isInvalid()) {
            return $invalidTokens;
        }
        $missingDomain = $this->checkEmptyDomain();
        if ($missingDomain->isInvalid()) {
            return $missingDomain;
        }
        if ($this->lexer->token['type'] === EmailLexer::S_OPENPARENTHESIS) {
            $this->warnings[DeprecatedComment::CODE] = new DeprecatedComment();
        }
        return new ValidEmail();
    }
    private function checkEmptyDomain() : Result
    {
        $thereIsNoDomain = $this->lexer->token['type'] === EmailLexer::S_EMPTY || $this->lexer->token['type'] === EmailLexer::S_SP && !$this->lexer->isNextToken(EmailLexer::GENERIC);
        if ($thereIsNoDomain) {
            return new InvalidEmail(new NoDomainPart(), $this->lexer->token['value']);
        }
        return new ValidEmail();
    }
    private function checkInvalidTokensAfterAT() : Result
    {
        if ($this->lexer->token['type'] === EmailLexer::S_DOT) {
            return new InvalidEmail(new DotAtStart(), $this->lexer->token['value']);
        }
        if ($this->lexer->token['type'] === EmailLexer::S_HYPHEN) {
            return new InvalidEmail(new DomainHyphened('After AT'), $this->lexer->token['value']);
        }
        return new ValidEmail();
    }
    protected function parseComments() : Result
    {
        $commentParser = new Comment($this->lexer, new DomainComment());
        $result = $commentParser->parse();
        $this->warnings = \array_merge($this->warnings, $commentParser->getWarnings());
        return $result;
    }
    protected function doParseDomainPart() : Result
    {
        $tldMissing = \true;
        $hasComments = \false;
        $domain = '';
        do {
            $prev = $this->lexer->getPrevious();
            $notAllowedChars = $this->checkNotAllowedChars($this->lexer->token);
            if ($notAllowedChars->isInvalid()) {
                return $notAllowedChars;
            }
            if ($this->lexer->token['type'] === EmailLexer::S_OPENPARENTHESIS || $this->lexer->token['type'] === EmailLexer::S_CLOSEPARENTHESIS) {
                $hasComments = \true;
                $commentsResult = $this->parseComments();
                //Invalid comment parsing
                if ($commentsResult->isInvalid()) {
                    return $commentsResult;
                }
            }
            $dotsResult = $this->checkConsecutiveDots();
            if ($dotsResult->isInvalid()) {
                return $dotsResult;
            }
            if ($this->lexer->token['type'] === EmailLexer::S_OPENBRACKET) {
                $literalResult = $this->parseDomainLiteral();
                $this->addTLDWarnings($tldMissing);
                return $literalResult;
            }
            $labelCheck = $this->checkLabelLength();
            if ($labelCheck->isInvalid()) {
                return $labelCheck;
            }
            $FwsResult = $this->parseFWS();
            if ($FwsResult->isInvalid()) {
                return $FwsResult;
            }
            $domain .= $this->lexer->token['value'];
            if ($this->lexer->token['type'] === EmailLexer::S_DOT && $this->lexer->isNextToken(EmailLexer::GENERIC)) {
                $tldMissing = \false;
            }
            $exceptionsResult = $this->checkDomainPartExceptions($prev, $hasComments);
            if ($exceptionsResult->isInvalid()) {
                return $exceptionsResult;
            }
            $this->lexer->moveNext();
        } while (null !== $this->lexer->token['type']);
        $labelCheck = $this->checkLabelLength(\true);
        if ($labelCheck->isInvalid()) {
            return $labelCheck;
        }
        $this->addTLDWarnings($tldMissing);
        $this->domainPart = $domain;
        return new ValidEmail();
    }
    /**
     * @psalm-param array|Token<int, string> $token
     */
    private function checkNotAllowedChars($token) : Result
    {
        $notAllowed = [EmailLexer::S_BACKSLASH => \true, EmailLexer::S_SLASH => \true];
        if (isset($notAllowed[$token['type']])) {
            return new InvalidEmail(new CharNotAllowed(), $token['value']);
        }
        return new ValidEmail();
    }
    /**
     * @return Result
     */
    protected function parseDomainLiteral() : Result
    {
        try {
            $this->lexer->find(EmailLexer::S_CLOSEBRACKET);
        } catch (\RuntimeException $e) {
            return new InvalidEmail(new ExpectingDomainLiteralClose(), $this->lexer->token['value']);
        }
        $domainLiteralParser = new DomainLiteralParser($this->lexer);
        $result = $domainLiteralParser->parse();
        $this->warnings = \array_merge($this->warnings, $domainLiteralParser->getWarnings());
        return $result;
    }
    protected function checkDomainPartExceptions(array $prev, bool $hasComments) : Result
    {
        if ($this->lexer->token['type'] === EmailLexer::S_OPENBRACKET && $prev['type'] !== EmailLexer::S_AT) {
            return new InvalidEmail(new ExpectingATEXT('OPENBRACKET not after AT'), $this->lexer->token['value']);
        }
        if ($this->lexer->token['type'] === EmailLexer::S_HYPHEN && $this->lexer->isNextToken(EmailLexer::S_DOT)) {
            return new InvalidEmail(new DomainHyphened('Hypen found near DOT'), $this->lexer->token['value']);
        }
        if ($this->lexer->token['type'] === EmailLexer::S_BACKSLASH && $this->lexer->isNextToken(EmailLexer::GENERIC)) {
            return new InvalidEmail(new ExpectingATEXT('Escaping following "ATOM"'), $this->lexer->token['value']);
        }
        return $this->validateTokens($hasComments);
    }
    protected function validateTokens(bool $hasComments) : Result
    {
        $validDomainTokens = array(EmailLexer::GENERIC => \true, EmailLexer::S_HYPHEN => \true, EmailLexer::S_DOT => \true);
        if ($hasComments) {
            $validDomainTokens[EmailLexer::S_OPENPARENTHESIS] = \true;
            $validDomainTokens[EmailLexer::S_CLOSEPARENTHESIS] = \true;
        }
        if (!isset($validDomainTokens[$this->lexer->token['type']])) {
            return new InvalidEmail(new ExpectingATEXT('Invalid token in domain: ' . $this->lexer->token['value']), $this->lexer->token['value']);
        }
        return new ValidEmail();
    }
    private function checkLabelLength(bool $isEndOfDomain = \false) : Result
    {
        if ($this->lexer->token['type'] === EmailLexer::S_DOT || $isEndOfDomain) {
            if ($this->isLabelTooLong($this->label)) {
                return new InvalidEmail(new LabelTooLong(), $this->lexer->token['value']);
            }
            $this->label = '';
        }
        $this->label .= $this->lexer->token['value'];
        return new ValidEmail();
    }
    private function isLabelTooLong(string $label) : bool
    {
        if (\preg_match('/[^\\x00-\\x7F]/', $label)) {
            \idn_to_ascii($label, \IDNA_DEFAULT, \INTL_IDNA_VARIANT_UTS46, $idnaInfo);
            return (bool) ($idnaInfo['errors'] & \IDNA_ERROR_LABEL_TOO_LONG);
        }
        return \strlen($label) > self::LABEL_MAX_LENGTH;
    }
    private function addTLDWarnings(bool $isTLDMissing) : void
    {
        if ($isTLDMissing) {
            $this->warnings[TLD::CODE] = new TLD();
        }
    }
    public function domainPart() : string
    {
        return $this->domainPart;
    }
}
