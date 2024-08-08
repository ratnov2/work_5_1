<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

class ResultQiwiCommentDTO extends ResultDTO {
    protected string $status;
    protected string $comment;
    protected array $sum;

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Get the value of amount
     */
    public function getSum()
    {
        return $this->sum;
    }
}
