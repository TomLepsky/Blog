<?php

namespace App\Translation;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Translatable
{
    protected $translations;

    public ?Collection $mappedTranslations = null;

    public function __construct()
    {
        $this->mappedTranslations = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function hasTranslation(Translation $translation) : bool
    {
        return
            $this->translations->containsKey($translation->getLocaleName()) ?
            $this->translations->get($translation->getLocaleName()) === $translation :
            false;
    }

    public function addTranslation(Translation $translation) : self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $this->mappedTranslations->set($translation->getLocaleName(), $translation);
            $translation->setTranslatable($this);
        }
        return $this;
    }

    public function removeTranslation(Translation $translation) : self
    {
        if ($this->translations->removeElement($translation)) {
            if ($translation->getTranslatable() === $this) {
                $translation->setTranslatable(null);
            }

            $this->mappedTranslations->remove($translation->getLocaleName());
        }
        return $this;
    }

    public function getTranslationByLocaleName(string $localeName) : ?Translation
    {
        return $this->mappedTranslations->containsKey($localeName) ? $this->mappedTranslations->get($localeName) : null;
    }
}
