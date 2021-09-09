<?php

namespace App\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

class Permission
{
    /**
     * @ORM\Column(type="boolean")
     */
    public bool $canRead = true;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $canCreate = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $canEdit = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $canDelete = false;
}
