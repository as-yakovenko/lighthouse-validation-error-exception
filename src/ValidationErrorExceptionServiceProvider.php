<?php

namespace Yakovenko\ValidationErrorException;

use Illuminate\Support\ServiceProvider;

class ValidationErrorExceptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register console commands
        $this->commands([
            Console\LighthouseValidationCommand::class,
        ]);
    }

    public function boot()
    {
        // Publish stubs
        $this->publishes([
            __DIR__ . '/stubs/Validation.php' => base_path('app/Validations/Validation.php'),
        ], 'lighthouse-validation-error-exception');
    }
}