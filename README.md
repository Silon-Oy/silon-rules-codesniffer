# Silon PHP_CodeSniffer Rules

[The Silon standard contains over 300 rules. Check them out.](USED_RULES.md)

## Installation

```
composer require --dev silon-oy/silon-rules-codesniffer
cp vendor/silon-oy/silon-rules-codesniffer/phpcs.xml phpcs.xml
```

## Usage

Use `vendor/bin/phpcs --standard=phpcs.xml` to make sure you are using the `phpcs` command from this package.

You could add to your project `composer.json` file the following:

```json
{
    "scripts": {
        "lint": "vendor/bin/phpcs --standard=phpcs.xml -s --warning-severity=0",
        "lint-all": "vendor/bin/phpcs --standard=phpcs.xml",
        "lint-fix": "vendor/bin/phpcbf --standard=phpcs.xml"
    }
}
```

After that has been added to your `composer.json` file, you can run `composer lint` to check for all the errors and warnings.
