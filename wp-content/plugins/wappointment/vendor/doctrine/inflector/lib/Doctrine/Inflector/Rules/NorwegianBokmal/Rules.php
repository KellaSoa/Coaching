<?php

declare (strict_types=1);
namespace WappoVendor\Doctrine\Inflector\Rules\NorwegianBokmal;

use WappoVendor\Doctrine\Inflector\Rules\Patterns;
use WappoVendor\Doctrine\Inflector\Rules\Ruleset;
use WappoVendor\Doctrine\Inflector\Rules\Substitutions;
use WappoVendor\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Inflectible::getSingular()), new Patterns(...Uninflected::getSingular()), (new Substitutions(...Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : Ruleset
    {
        return new Ruleset(new Transformations(...Inflectible::getPlural()), new Patterns(...Uninflected::getPlural()), new Substitutions(...Inflectible::getIrregular()));
    }
}
