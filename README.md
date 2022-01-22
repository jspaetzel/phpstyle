# PHPStyle ✨

A slim, opinionated wrapper around PHPCSFixer.

This comes preloaded with sane style choices for most PHP applications. You should be able to safely run it on most code out of the box.

## 🏗 Setup
1. Require the package
```neon
composer require jspaetzel/phpstyle --dev
```

2. Run the setup script to download php-cs-fixer and create default configs: 

```
./vendor/bin/phpstyle-setup
```

3. Review the `phpstyle.neon` configuration file and make changes if necessary

4. Run the php-cs-fixer to fix your code
```bash
./vendor/bin/php-cs-fixer fix
```

## ⚙ Configuration

The configuration for [PHPStyle](https://github.com/jspaetzel/phpstyle) takes inspiration from [PHPStan](https://github.com/phpstan/phpstan) and is a very simple neon configuration file. Just adjust your paths and php versions if needed, and you'll be good to go.
```neon
parameters:
    php: 7.1
    risky: false
    paths:
        - src
        - tests
```
> Want to enable more rules? change `risky: true` and then see what happens. But watch out, these are risky! ⚠
