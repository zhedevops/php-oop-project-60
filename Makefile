lint:
	composer exec phpcs -v -- --standard=PSR12 -np src tests

lint-fix:
	composer exec phpcbf -v -- --standard=PSR12 -np src tests

test:
	composer exec --verbose phpunit tests
