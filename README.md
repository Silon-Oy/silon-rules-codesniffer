# Silon PHP_CodeSniffer Rules

[The Silon standard contains over 300 rules. Check them out.](USED_RULES.md)

## Installation

The package is not on Packagist yet, so add this repository as a VCS source in
your project's `composer.json` first:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Silon-Oy/silon-rules-codesniffer"
        }
    ]
}
```

The repository is public, so no access token or `COMPOSER_AUTH` is needed.
Then require a tagged release and copy the example config:

```
composer require --dev silon-oy/silon-rules-codesniffer:^1.0
cp vendor/silon-oy/silon-rules-codesniffer/phpcs.xml phpcs.xml
```

## Usage

Use `vendor/bin/phpcs --standard=phpcs.xml` to make sure you are using the `phpcs` command from this package.

You could add to your project `composer.json` file the following:

```json
{
    "scripts": {
        "post-install-cmd": ["vendor/bin/silon-install-hooks"],
        "post-update-cmd": ["vendor/bin/silon-install-hooks"],
        "lint": "vendor/bin/phpcs --standard=phpcs.xml -s --warning-severity=0",
        "lint-all": "vendor/bin/phpcs --standard=phpcs.xml",
        "lint-fix": "vendor/bin/phpcbf --standard=phpcs.xml"
    }
}
```

After that has been added to your `composer.json` file, you can run `composer lint` to check for all the errors and warnings.

## Pre-commit Hook

The package includes a git pre-commit hook that automatically lints staged PHP files on every commit.

### What it does

1. Finds staged `.php` files
2. Auto-fixes them with PHPCBF and re-stages the fixed files
3. Runs PHPCS — blocks the commit if errors remain
4. Uses `phpcs.xml` from your project root (falls back to the Silon standard)

### Installation

Add the install script to your project's Composer scripts (see above). The hook is installed automatically on `composer install` and `composer update`.

To install manually: `vendor/bin/silon-install-hooks`

### Bypass

```
git commit --no-verify
```

## License

[MIT](LICENSE)
