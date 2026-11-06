# SISTEM UJIAN ONLINE

A web-based online examination management system built with PHP and CodeIgniter 3.

This project is a legacy web application that provides examination management functionality through separate interfaces for administrators, teachers, and students. It is shared for learning, exploration, and further development.

## Features

The application includes the following role-based menus and functionality.

### Administrator

- Dashboard
- Manage teachers and students
- Manage examination questions
- Manage examination participants
- View examination results
- View violation logs
- Print student login cards
- Change password

### Teacher

- Dashboard
- Manage examination questions
- Change password

### Student

- Dashboard
- View examination schedules
- Take examinations
- View examination results
- Change password

> This feature list is based on the existing application navigation and code structure. Not every feature or workflow has been fully tested in a running environment.

## Technology Stack

- **Backend:** PHP
- **Framework:** CodeIgniter 3.1.10
- **Database:** MySQL / MariaDB
- **Database Driver:** MySQLi
- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Admin Template:** AdminLTE
- **PDF Generation:** Dompdf (bundled library)

## Requirements

The following versions describe the development environment inspected during repository preparation. They are reference information, not mandatory minimum requirements.

| Component          | Inspected Version |
| ------------------ | ----------------- |
| PHP                | 7.3.33            |
| CodeIgniter        | 3.1.10            |
| MariaDB            | 10.4.22           |
| Web Server         | Apache            |
| Database Extension | MySQLi            |

**Compatibility note:** PHP 7.3 has reached end of life and no longer receives security updates. This project uses a legacy CodeIgniter version. Compatibility with newer PHP versions has not been fully verified.

Commonly required PHP extensions include:

- mysqli
- mbstring
- gd
- fileinfo
- openssl
- session
- json
- xml
- zip

Apache `mod_rewrite` should be enabled when using the provided `.htaccess` configuration.

## Installation

### 1. Clone the repository

Open the repository's GitHub page and use **Code → HTTPS** to copy its clone URL.

Then run:

```bash
git clone <repository-url>
```

Replace `<repository-url>` with the URL copied from GitHub.

Move into the project directory:

```bash
cd SISTEM-UJIAN-ONLINE
```

### 2. Create a database

Create a MySQL or MariaDB database named `dbujianonline`:

```sql
CREATE DATABASE dbujianonline
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

### 3. Import the demo database

Import the SQL file provided in the repository:

```text
database/dbujianonline.sql
```

You can import it using phpMyAdmin or the MySQL command-line client.

### 4. Configure CodeIgniter

Copy the example configuration files:

```text
application/config/config.php.example
application/config/database.php.example
```

Create the corresponding active configuration files:

```text
application/config/config.php
application/config/database.php
```

Update the configuration values according to your local environment.

In `config.php`, configure:

- `base_url`
- `encryption_key`
- Session settings, if needed

In `database.php`, configure:

- Database hostname
- Database username
- Database password
- Database name (`dbujianonline` by default)
- Database driver (`mysqli`)

The active configuration files are excluded from Git to avoid publishing local environment settings.

### 5. Run the application

Place the project inside your Apache document root, such as `htdocs`.

Start Apache and MySQL/MariaDB, then open the application in your browser:

```text
http://localhost/SISTEM-UJIAN-ONLINE/
```

Adjust the URL according to your actual project folder and local server configuration.

## Demo Accounts

The included demo database provides one account for each application role.

| Role          | Username | Password         |
| ------------- | -------- | ---------------- |
| Administrator | `admin`  | `DemoAdmin2026!` |
| Teacher       | `guru`   | `DemoGuru2026!`  |
| Student       | `siswa`  | `DemoSiswa2026!` |

These credentials are intended for local demonstration and learning purposes only.

Do not reuse these credentials in a public production deployment.

## Project Structure

```text
SISTEM-UJIAN-ONLINE/
├── application/
│   ├── config/
│   ├── controllers/
│   ├── libraries/
│   ├── models/
│   └── views/
├── assets/
├── database/
│   └── dbujianonline.sql
├── image/
├── system/
├── .editorconfig
├── .gitignore
├── .htaccess
├── index.php
├── license.txt
└── README.md
```

## Known Limitations

This is a legacy project. Consider the following limitations before using or extending it:

- The application has not undergone a complete security audit.
- Not all application workflows have been tested end to end.
- The included demo database has not been fully verified through complete runtime testing. Some legacy records may contain inconsistent references between tables.
- Several referenced frontend assets were found missing during repository preparation:
  - `assets/style.css`
  - `assets/ad.js`
  - `assets/ckeditor/plugins/language/plugin.js`
  - `assets/timer/jquery.syotimer.min.js`
- Pages or JavaScript functionality that depend on those files may require further investigation.
- Compatibility with current PHP versions has not been fully verified.
- The project should not be considered production-ready without further maintenance, testing, and security review.

Use demo data only when exploring this repository.

## License

The repository includes the CodeIgniter license file (`license.txt`).

Third-party libraries, templates, and assets may have their own licensing terms. Review the applicable licenses before redistribution or commercial use.
