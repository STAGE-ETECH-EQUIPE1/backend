<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CommentLogoDTO
{
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 250)]
    private string $comment;

    /**
     * Get the value of comment.
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Set the value of comment.
     */
    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
