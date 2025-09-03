<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait SoftDeleteTrait
{
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleteAt = null;

    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(\DateTimeImmutable $at): static
    {
        $this->deleteAt = $at;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleteAt !== null;
    }
}
