<?php

namespace Yakovenko\ValidationErrorException;

use Illuminate\Validation\Validator;

trait ValidationDefault
{
    /**
     * Resolve the class name.
     *
     * @param string|null $className
     * @return string
     */
    public static function className( ?string $className ): string
    {
        return class_basename( $className ?? __CLASS__ );
    }

    /**
     * Check if the model exists, otherwise throw an error.
     *
     * @param object|null $model
     * @param int $id
     * @param string|null $modelClass
     * @return bool
     * @throws ErrorException
     */
    public static function isModelExists( ?object $model = null, ?int $id, ?string $modelClass = 'Model' ): bool
    {
        if( empty( $model ) ) {
            $modelName = class_basename( $modelClass );

            self::throwError(
                errorMsg  : __('GL_NotExist') . " {$modelName}: {$id}",
                action    : 'isModelExists',
            );
        }

        return true;
    }

    /**
     * Checks if the provided record is empty. If the record is not empty, it throws an error.
     *
     * @param mixed $record
     * @param int|string|null $id
     * @param string|null $className
     * @return bool Returns true if the record is empty, otherwise throws an error.
     * @throws ErrorException If the record is not empty.
     */
    public static function isRecordEmpty( mixed $record = null, int|string|null $id, ?string $className = null ): bool
    {
        if( !empty( $record ) ) {
            self::throwError(
                errorMsg  : __('GL_RecordExist') . ": {$id}",
                action    : 'isRecordExist',
                className : self::className( $className ),
            );
        }

        return true;
    }


    /**
     * Check if two values are equal.
     *
     * @param int|string $currentValue
     * @param int|string $checkValue
     * @param string|null $className
     * @return bool
     * @throws ErrorException
     */
    public static function isValuesEqual( int|string $currentValue, int|string $checkValue, ?string $className = null ): bool
    {
        if ( $currentValue === $checkValue ) {
            return true;
        }

        self::throwError(
            errorMsg  : __('GL_ValuesNotEqual'),
            action    : 'isValuesEqual',
            className : self::className( $className ),
        );
    }

    /**
     * Check if the validator has failed.
     *
     * @param Validator $validator
     * @param string|null $className
     * @return void
     * @throws ErrorException
     */
    public static function isFails( Validator $validator, ?string $className = null ): void
    {
        if ( $validator->fails() ) {
            self::throwError(
                errorMsg  : $validator->errors()->first(),
                action    : 'validator',
                className : self::className( $className )
            );
        }
    }

    /**
     * Check if the value is empty.
     *
     * @param mixed $value
     * @param string|null $errorMsg
     * @param string|null $className
     * @return bool
     * @throws ErrorException
     */
    public static function isEmpty( mixed $value, ?string $errorMsg = null, ?string $className = null ): bool
    {
        if( !empty( $value ) ){
            return true;
        }

        self::throwError(
            errorMsg  : $errorMsg ? $errorMsg : __('GL_NotExist'),
            action    : 'isEmpty',
            className : self::className( $className )
        );
    }

    /**
     * Check if the user is the author.
     *
     * @param int $user_id
     * @param int $author_id
     * @param string|null $className
     * @return bool
     * @throws ErrorException
     */
    public static function isAuthor( int $user_id, int $author_id, ?string $className = null ): bool
    {
        if( $user_id !== $author_id ) {
            self::throwError(
                errorMsg  : __('GL_ACTION_FAILED_Rights'),
                action    : 'isAuthor',
                className : self::className( $className )
            );
        }

        return true;
    }

    /**
     * Get the first error message from the validator.
     *
     * @param Validator $validator The validator instance.
     * @return string The first validation error message in the format "field_name: message".
     */
    public static function getErrorValidator( Validator $validator ): string
    {
        foreach( $validator->messages()->getMessages() as $field_name => $messages ){
            return $field_name . ': ' . $messages[0];
        }
    }

    /**
     * Throw a custom error exception.
     *
     * @param string $errorMsg
     * @param string $action
     * @param string|null $className
     * @throws ErrorException
     */
    public static function throwError( string $errorMsg = '', ?string $action = 'throwError', ?string $className = null ): void
    {
        throw new ErrorException(
            class   : self::className( $className ),
            action  : $action,
            message : __('GL_FAILED'),
            reason  : $errorMsg
        );
    }
}