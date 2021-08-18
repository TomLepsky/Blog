<?php

namespace App\Security\Voter;

class VoterAttribute
{
    const CREATE = 'canCreate';

    const READ = 'canRead';

    const EDIT = 'canEdit';

    const DELETE = 'canDelete';

    public static function getAttributes() : array
    {
        return array_values((new \ReflectionClass(__CLASS__))->getConstants());
    }
}
