# PHPStyle ✨

A slim, opinionated wrapper around PHPCSFixer.

This comes preloaded with sane style choices for most PHP applications. You should be able to safely run it on most code out of the box.

## 🏗 Setup

1. Require the package
```bash
composer require jspaetzel/phpstyle --dev
```

2. Run the [setup script](https://github.com/jspaetzel/phpstyle/blob/main/phpstyle-setup):

```bash
./vendor/bin/phpstyle-setup
```

> 🗒 Note: This script is for convenience, you can alternatively do the same steps manually by [installing php-cs-fixer](https://cs.symfony.com/#installation), and copying two files ([.php-cs-fixer.dist.php](https://github.com/jspaetzel/phpstyle/blob/main/.php-cs-fixer.dist.php) and [phpstyle.neon](https://raw.githubusercontent.com/jspaetzel/phpstyle/main/phpstyle.neon)) to your project root.

3. Review the `phpstyle.neon` configuration file. Feel free to make changes to this file at any time.


4. Run php-cs-fixer to fix your code
```bash
./vendor/bin/php-cs-fixer fix
```

> 🗒 Note: php-cs-fixer is integrated with PHPStorm and other editors and so PHPStyle should work with them as well.

That's it, your code is styled!

## ⚙ Configuration

The configuration for [PHPStyle](https://github.com/jspaetzel/phpstyle) takes inspiration from [PHPStan](https://github.com/phpstan/phpstan) and is a very simple neon configuration file. Just adjust your paths and php versions if needed, and you'll be good to go.
```neon
parameters:
    php: 7.1
    risky: false
    paths:
        - src
        - tests
    excludePaths:
        - src/path/you/want/to/skip
        - src/or/a/file-to-skip.php
```
> Want to enable more rules? change `risky: true` and then see what happens. But watch out, these are risky! ⚠
