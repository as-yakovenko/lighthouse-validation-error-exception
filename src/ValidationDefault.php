<?php

namespace Yakovenko\ValidationErrorException;

trait ValidationDefault
{
    /**
     * Resolve the class name
     * @param string|null $className
     * @return string
     */
    public static function resolveClassName( ?string $className ): string
    {
        return $className ?? static::class;
    }

    /**
     * is exists model
     * @return bool
     */
    public static function isModelExists( ?object $model, ?int $id, ?string $className = null ): bool
    {
        if( empty( $model ) ) {
            self::throwError(
                errorMsg  : __('GL_NotExist') . ' model_id: ' . $id,
                className : self::resolveClassName( $className )
            );
        }

        return true;
    }

    /**
     * validator error checking
     * @return bool
     */
    public static function isFails( object $validator, ?string $className = null ): void
    {
        if ( $validator->fails() ) {
            self::throwError(
                errorMsg  : self::getErrorValidator( $validator ),
                className : self::resolveClassName( $className )
            );
        }
    }

    /**
     * Check if the user is the author
     * @return bool
     */
    public static function isAuthor( int $user_id, int $author_id, ?string $className = null ): bool
    {
        if( $user_id !== $author_id ) {

            self::throwError(
                errorMsg  : __('GL_ACTION_FAILED_Rights'),
                className : self::resolveClassName( $className )
            );

        }

        return true;
    }
	
	/**
     * showing error from validator
     * @return string
     */
    public static function getErrorValidator( object $validator ): string
    {
        foreach( $validator->messages()->getMessages() as $field_name => $messages ){
            return $field_name . ': ' . $messages[0];
        }
    }

    /**
     * Throw error message
     * @return void
     */
    public static function throwError( string $errorMsg = '', ?string $className = null ): void
    {
        throw new ErrorException(
            class   : self::resolveClassName( $className ),
            action  : 'throwError',
            message : __('GL_FAILED'),
            reason  : $errorMsg
        );
    }
}