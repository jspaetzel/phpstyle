# PHPStyle

A slim wrapper around PHPCSFixer with simple to use opinionated configs.

First require the package
```neon
composer require jspaetzel/phpstyle-setup --dev
```

Once configured run the setup script: `./vendor/bin/phpstyle-setup`

The script will download php-cs-fixer and create bootstrapping files. You can now customize the configuration for your application by modifying the `phpstyle.neon` file.

Once configured you use the normal php-cs-fixer script to run fixes or analysis.
`./vendor/bin/php-cs-fixer fix`
