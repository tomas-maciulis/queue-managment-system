## About

This project is my take on NFQ software engineering internship task. It is not meant to be developed further than it currently is. It's a queue managing app meant to be used in banks, fast food restaurants, hospitals, etc.


## Usage information

### Users
There are 3 types of users:
- Specialist - can receive reservations and change their statuses
- Guests - can create reservations and cancel them
- Display - can access the queue display

By default, the database is populated with 2 specialists:
- jane.doe@example.net : password
- john.doe@example.net : password

Also, there is 1 display user:
- display@example.net : password

### Creating reservations
When accessing the website, guest user will automatically be redirected to reservation creation page. Only active specialists will be available for selection. After creating a reservation, guest user is redirected to reservation display page which is populated with relevant data. Guest can cancel the reservation within this page, too. All guest accessible pages are optimized for smartphones since they will most likely be accessed using this medium.

### Managing reservations
Once specialist user is authenticated, she is redirected to personal dashboard. The dashboard contains a table with all active reservations (received or in progress) that belong to current user with ability to begin/cancel received reservations and finish ongoing reservation.

### Accessing display
Only display users can access the display. Once display user is authenticated, he is redirected to display dashboard that contains a button to show the display.


## Installation
### Prerequisites
- SQL database server of your choice (MySQL is recommended)
- Composer
- NPM
- PHP 7.4
- - BCMath PHP Extension
- - Ctype PHP Extension
- - Fileinfo PHP extension
- - JSON PHP Extension
- - Mbstring PHP Extension
- - OpenSSL PHP Extension
- - PDO PHP Extension
- - Tokenizer PHP Extension
- - XML PHP Extension

All required PHP extensions on Debian family systems can be installed using the following command:  
```sudo apt install openssl php-common php-curl php-json php-mbstring php-xml php-zip```

Also, selected SQL PHP extension should be installed as well. MySQL plugin on Debian family systems can be installed using following command:  
```sudo apt install php-mysql```

In order to run PHPUnit tests, SQLite3 PHP plugin must be installed and activated in the configuration:  
```sudo apt install php-sqlite3```

### Installation
Navigate your command line to project root directory and install PHP and JS dependencies:  
`composer install && npm install`

Create an empty SQL database.

Duplicate `.env.example` and rename it to `.env`
Open it and edit the DB section to reflect your database server configuration, other settings are optional.

Populate the database with tables by running `php artisan migrate`.
Optionally, `php artisan db:seed` command can be executed to populate the database with default users.

Generate application key by running `php artisan key:generate` command in project root directory.

To test if program is working, you can run `php artisan serve` command to start the built in server.

### Running tests
PHPUnit tests can be run using `php artisan test` command.
