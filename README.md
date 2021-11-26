# Mars Rover API

API implementation of Mars Rover challenge in PHP.

## About

This application uses [ADR (Action Domain Responder)](https://github.com/pmjones/adr) pattern for HTTP.

The following features/requirements are skipped due to lack of time:

- Data validation
- Exception handling
- Environment-based configuration
- Domain/Repository tests
- API documentation

## Prerequisites

- [Git](https://git-scm.com)
- [PHP 8.0](https://www.php.net)
- [Composer](https://getcomposer.org)

## Installation

**1. Clone the repository:**

```shell
git clone git@github.com:nbayramberdiyev/mars-rover-api.git
```

**2. Go to the project folder:**

```shell
cd mars-rover-api
```

**3. Install dependencies:**

```shell
composer install
```

**4. Create a new SQLite database:**

```bash
cp db.sqlite.example db.sqlite
```

**5. Serve the application:**

```bash
composer serve
```

## Testing

You can run tests using `phpunit`:

```shell
./vendor/bin/phpunit
```

Or, you may use the `test` composer command:

```shell
composer test
```

