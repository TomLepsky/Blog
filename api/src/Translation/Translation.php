<?php

namespace App\Translation;

abstract class Translation
{
    protected $translatable;

    public function getTranslatable() : ?Translatable
    {
        return $this->translatable;
    }

    public function setTranslatable(?Translatable $translatable) : self
    {
        $this->translatable = $translatable;
        return $this;
    }

    abstract public function getLocaleName() : string;
}
