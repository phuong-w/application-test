# VAND

## About This Project

This is the project for **Testing** by **VAND**. This project is built with:

-   **[Laravel](https://laravel.com/)**
-   **[Scribe Library](https://scribe.knuckles.wtf/)**
-   **[Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v5/introduction)**

## Getting started

### Prerequisites

-   PHP ^8.1
-   Latest [Node.js](https://nodejs.org) version
-   Docker
-   Composer v2.5.4

### Installing

#### Manual

```bash
# Clone the project and run composer


# Install the composer packages
composer install

# Copy the .env.example file to .env
cp .env.example .env

# Remember to setup your DB settings in .env
# Migration and DB seeder (after changing your DB settings in .env)
php artisan migrate --seed

# Run the Vite production server...
npm run build

# Generate documents
php artisan scribe:generate
```

#### With Docker

```bash
# Clone the project and run composer


# We need to copy the .env.example file to .env first (!!important)
cp .env.example .env

# Run the sail with path
./vendor/bin/sail up -d
```

-   Or You can configuring a shell alias

```sh
# Run command
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Run the sail
sail up -d
```

### Final steps

Add **application-test.local** to your **hosts** file.

Go to [application-test.local](http://application-test.local) to access the website.

## Running the tests

-   Tests system is under development

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Authors

-   **Steven** - _Initial Work_

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details.
