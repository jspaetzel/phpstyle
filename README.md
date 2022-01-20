# PHPStyle

A slim wrapper around PHPCSFixer with simple to use opinionated configs.

First require the package
```neon
composer require jspaetzel/phpstyle --dev
```

Create the following file
`phpstyle.neon`

```neon
parameters:
	paths:
		- src
		- tests
	rules:
	    - PSR12
```

Once configured, run the helper script `./vendor/phpstyle/phpstyle`
