<?php

namespace Yakovenko\ValidationErrorException;

use Illuminate\Validation\Validator;

/**
 * Business validation trait following "throw on error, return true on success" pattern.
 * All validation methods either throw ErrorException or return true.
 */
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
     * @param int|string|null $id
     * @return bool
     * @throws ErrorException
     */
    public static function isModelExists( ?object $model = null, int|string|null $id, ?string $modelName = 'Object' ): bool
    {
        if ( empty( $model ) ) {
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
     * @return bool
     * @throws ErrorException
     */
    public static function isRecordEmpty( mixed $record = null, int|string|null $id ): bool
    {
        if ( !empty( $record ) ) {
            self::throwError(
                errorMsg  : __('GL_RecordExist') . ": {$id}",
                action    : 'isRecordExist',
            );
        }

        return true;
    }

    /**
     * Check if the value is empty.
     *
     * @param mixed $value
     * @param string|null $errorMsg
     * @return bool
     * @throws ErrorException
     */
    public static function isEmpty( mixed $value, ?string $errorMsg = null ) : bool
    {
        if ( !empty( $value ) ) {
            return true;
        }

        self::throwError(
            errorMsg  : $errorMsg ?: __('GL_NotExist'),
            action    : 'isEmpty'
        );

        return false;
    }

    /**
     * Check if two values are equal.
     *
     * @param int|string $currentValue
     * @param int|string $checkValue
     * @return bool
     * @throws ErrorException
     */
    public static function isValuesEqual( int|string $currentValue, int|string $checkValue ): bool
    {
        if ( $currentValue !== $checkValue ) {
            self::throwError(
                errorMsg  : __('GL_ValuesNotEqual'),
                action    : 'isValuesEqual',
            );
        }

        return true;
    }

    /**
     * Check if the validator has failed.
     *
     * @param Validator $validator
     * @return void
     * @throws ErrorException
     */
    public static function isFails( Validator $validator ): void
    {
        if ( $validator->fails() ) {
            self::throwError(
                errorMsg  : $validator->errors()->first(),
                action    : 'validator',
            );
        }
    }

    /**
     * Check if the user is the author.
     *
     * @param int $user_id
     * @param int $author_id
     * @return bool
     * @throws ErrorException
     */
    public static function isAuthor( int $user_id, int $author_id ): bool
    {
        if ( $user_id !== $author_id ) {
            self::throwError(
                errorMsg  : __('GL_ACTION_FAILED_Rights'),
                action    : 'isAuthor',
            );
        }

        return true;
    }

    /**
     * Get the first error message from the validator.
     *
     * @param Validator $validator The validator instance.
     * @return string|null The first validation error message in the format "field_name: message".
     */
    public static function getErrorValidator( Validator $validator ): ?string
    {
        foreach ( $validator->messages()->getMessages() as $field_name => $messages ) {
            return $field_name . ': ' . $messages[0];
        }

        return null;
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
