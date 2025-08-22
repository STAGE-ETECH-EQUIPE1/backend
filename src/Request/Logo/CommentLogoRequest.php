<?php

namespace App\Request\Logo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CommentLogoRequest
{
    #[Assert\NotBlank(
        message: 'BLANK_INPUT_MESSAGE'
    )]
    #[Assert\Length(
        min: 2,
        max: 250,
        minMessage: 'MIN_LENGTH_ERROR_MESSAGE',
        maxMessage: 'MAX_LENGTH_ERROR_MESSAGE'
    )]
    private string $comment;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->comment = $content['comment'] ?? '';
    }

    /**
     * Get the value of comment.
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}
