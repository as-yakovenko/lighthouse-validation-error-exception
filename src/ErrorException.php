<?php

namespace Yakovenko\ValidationErrorException;

use Exception;
use GraphQL\Error\ClientAware;
use GraphQL\Error\ProvidesExtensions;


final class ErrorException extends Exception implements ClientAware, ProvidesExtensions
{
    private string $class;
    private string $reason;
    private string $action;

    public function __construct( string $class, string $action, string $message, string $reason )
    {
        parent::__construct( $message );

        $this->class  = $class;
        $this->action = $action;
        $this->reason = $reason;
    }

    public function isClientSafe(): bool
    {
        return true;
    }

    public function getTypeError(): string
    {
        return $this->message;
    }

    public function getExtensions(): array
    {
        return [
            'action' => $this->action,
            'reason' => $this->reason,
            'class'  => $this->class,
        ];
    }
}
