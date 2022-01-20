# PHPStyle

A slim opinionated wrapper around PHPCSFixer.

This comes preloaded with sane style choices for most PHP applications. You should be able to safely run it on most code out of the box.

## Setup
1. Require the package
```neon
composer require jspaetzel/phpstyle-setup --dev
```

2. Run the setup script to download php-cs-fixer and create default configs: 

```
./vendor/bin/phpstyle-setup`
```

3. Review the `phpstyle.neon` file and make changes if desired

4. Run the php-cs-fixer
```bash
./vendor/bin/php-cs-fixer fix
```
