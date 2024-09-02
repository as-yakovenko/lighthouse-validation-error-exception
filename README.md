# Lighthouse GraphQL Validation ErrorException

`yakovenko/lighthouse-validation-error-exception` - Advanced validation for Laravel with custom error handling.

## Installation

### Requirements

- PHP               : ^8
- Laravel           : ^9.0 || ^10.0 || ^11.0
- Nuwave Lighthouse : ^6.0

### Install the Package

Add the repository to your project's `composer.json` file:
```bash
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/as-yakovenko/lighthouse-validation-error-exception"
    }
],
```

Then install the package with:
```bash
composer require yakovenko/lighthouse-validation-error-exception
```

**Publish Configuration**

To publish configuration files and other necessary resources, run:
```bash
php artisan vendor:publish --tag=lighthouse-validation-error-exception
```

### Console Command Example

To create a new validation class, use the following command:
```bash
php artisan lighthouse:validation {name}
```

Replace {name} with the name of your validation class. For example:
```bash
php artisan lighthouse:validation User
```

**Usage Example**

1 - Create a validation class:
```bash
php artisan lighthouse:validation Example
```

2 - Edit the created file app/Validations/ExampleValidation.php to define validation rules.

3 - Use the created validation class in your code for data validation by using `canCreate` and `canUpdate` methods.