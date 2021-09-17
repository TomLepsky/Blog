<?php

namespace App\DataMapper;

use App\Embeddable\MetaInformation;

class MetaInformationMapper
{
    public static function setMetaInformationFromEntity(object $object) : MetaInformation
    {
        $meta = new MetaInformation();
        $meta->setTitle($object->getTitle());
        $meta->setDescription($object->getDescription());
        $meta->setOgTitle($object->getOgTitle());
        $meta->setOgDescription($object->getOgDescription());
        $meta->setKeyWords($object->getKeyWords());
        return $meta;
    }
}
