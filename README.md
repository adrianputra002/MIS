# MIS

This project is a MIS built with Laravel. It allows users to create, store, view  claims data by Line of Business (LOB), and integrate to penampung(another) database.

## Installation

### Prerequisites

- PHP 8.1.6 or higher
- Composer
- Laravel
- Microsoft SQL Server with `sqlsrv` driver

### Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/claims-management-system.git
    cd claims-management-system
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up the environment:
    php artisan key:generate

4. Configure the database in the `.env` file:
    DB_CONNECTION=sqlsrv
    DB_HOST=your_sql_server_host
    DB_PORT=1433
    DB_DATABASE=your_app_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

    DB_CONNECTION_SQLSRV_DB2=sqlsrv
    DB_HOST_SQLSRV_DB2=your_sql_server_host
    DB_PORT_SQLSRV_DB2=1433
    DB_DATABASE_SQLSRV_DB2=your_penampung_database
    DB_USERNAME_SQLSRV_DB2=your_username
    DB_PASSWORD_SQLSRV_DB2=your_password

5. Run migrations:
    php artisan migrate


6. Run the unit test
    php artisan test
