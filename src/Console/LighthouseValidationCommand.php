<?php

namespace Yakovenko\ValidationErrorException\Console;

use Illuminate\Console\Command;

class LighthouseValidationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yas:validation {name : The name of the validation class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new validation class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $className  = $this->argument( 'name' );
        $stubPath   = __DIR__ . '/../stubs/validation.stub';
        $targetPath = $this->getPath( $className );

        if ( file_exists( $targetPath ) ) {
            $this->error( 'Class already exists!' );
            return 1;
        }

        $this->createFileFromStub( $stubPath, $targetPath, $className );

        $this->info( 'Validation class created successfully!' );
        return 0;
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath( $name )
    {
        return base_path( 'app/Validations/' . $name . 'Validation.php' );
    }

    /**
     * Create a file from a stub.
     *
     * @param string $stubPath
     * @param string $targetPath
     * @param string $className
     * @return void
     */
    protected function createFileFromStub( $stubPath, $targetPath, $className )
    {
        $stub    = file_get_contents( $stubPath );
        $content = $this->replaceClass( $stub, $className );
        file_put_contents( $targetPath, $content );
    }

    /**
     * Replace placeholders in the stub with actual class names.
     *
     * @param string $stub
     * @param string $className
     * @return string
     */
    protected function replaceClass( $stub, $className )
    {
        $classNameWithSuffix = $className . 'Validation';
        return str_replace( ['{{ class }}', '{{class}}'], $classNameWithSuffix, $stub );
    }
}
