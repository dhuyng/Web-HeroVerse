# Web-HeroVerse

## Setup eviroments

### Configure `.env` for Database Connection

Make sure to set up your database connection by creating or updating the `.env` file in the root of your project. Add the following environment variables:
```env
DB_HOST=localhost  
DB_USER=username  
DB_PASS=password  
DB_NAME=heroverse
```
- Replace `localhost` with your database host if different.
- Set `DB_USER` and `DB_PASS` to your database credentials.
- Set `DB_NAME` to the name of your database (e.g., `heroverse`).

### Configure `RewriteBase`

If your application is in a subdirectory, update the `.htaccess` file to set the correct `RewriteBase`. For example:

```apache
RewriteBase /your-subdirectory/
```
Replace ```/your-subdirectory/``` with the actual path where your app is hosted (e.g., /BTL/HeroVerse/).

### Enabling GD Library for QR Code Generation in XAMPP

1. **Locate `php.ini`**:
   - Go to `C:\xampp\php` and open `php.ini` in a text editor.

2. **Enable GD extension**:
   - Find `;extension=gd` and remove the semicolon to make it `extension=gd`.

3. **Save the file** and **restart Apache**:
   - Save the `php.ini` file and restart Apache via the XAMPP Control Panel.

4. **Verify GD is enabled**:
   - Create a PHP file with `phpinfo();` and check for `GD` in the output.

This will enable QR code generation in your project.

### Git Line Endings Setup

To ensure consistent line endings across different systems, follow these steps:

1. **Windows**:  
   Run the following command:
   ```bash
   git config --global core.autocrlf true
   ```
2. **macOS/Linux**:  
   Run the following command:
   ```bash
   git config --global core.autocrlf input
   ```
3. **Run `renormalize`**:  
   After setting the above, execute:
   ```bash
   git add --renormalize .
   ```

## Project structure

```
/HeroVerse
│
├── /public                  # Publicly accessible files
│   ├── /css                 # Stylesheets
│   ├── /js                  # JavaScript files
│   ├── /img                 # Images and icons
│   
│
├── /app
│   ├── /controllers         # Handles logic for requests
│       └── HomeController.php
│   ├── /models              # Database interaction logic
│   ├── /views               # HTML templates or views
│       ├── admin            # Admin-specific pages
│       ├── heroes           # Hero-related pages
│       ├── layouts          # Shared layout files
│       ├── pages            # Static or general pages
│       ├── user             # User-specific pages
│
├── /config                  # Configuration files
│   ├── database.php         # Database connection logic
│   ├── env.php              # Environment variable loader
├── index.php                # Main entry point (public-facing)
├── .env                     # Stores environment variables
└── .htaccess                # Optional for URL rewriting
```
## Database Schema

This document provides an overview of the database schema for the application. It includes the structure for users, heroes, comments, news, and pages tables.

### 1. `users` Table

| Column       | Type            | Constraints                | Description                       |
|--------------|-----------------|----------------------------|-----------------------------------|
| `id`         | INT             | PRIMARY KEY, AUTO_INCREMENT | Unique ID for each user.          |
| `username`   | VARCHAR(50)     | UNIQUE, NOT NULL            | User’s username.                  |
| `email`      | VARCHAR(100)    | UNIQUE, NOT NULL            | User’s email address.             |
| `password`   | VARCHAR(255)    | NOT NULL                    | Hashed password.                  |
| `role`       | ENUM('admin', 'member') | DEFAULT 'member'     | User’s role (Admin/Member).       |
| `avatar`     | VARCHAR(255)    | NULL                        | Path to profile image.            |
| `created_at` | TIMESTAMP       | DEFAULT CURRENT_TIMESTAMP   | Account creation date.            |
| `updated_at` | TIMESTAMP       | ON UPDATE CURRENT_TIMESTAMP | Last update date.                 |

### 2. `heroes` Table

| Column       | Type            | Constraints                                | Description                                    |
|--------------|-----------------|--------------------------------------------|------------------------------------------------|
| `id`         | `INT`           | `PRIMARY KEY, AUTO_INCREMENT`              | Unique ID for each hero.                       |
| `name`       | `VARCHAR(255)`  | `NOT NULL`                                 | Hero name.                                     |
| `price`      | `DECIMAL(10, 2)`| `NOT NULL`                                 | Price of the hero (stored as a decimal number).|
| `type`       | `ENUM('dark', 'light')` | `NOT NULL`                              | Hero type (e.g., Dark or Light).          |
| `image`      | `VARCHAR(255)`  | `NOT NULL`                                 | Path to the hero's image.                      |
| `created_at` | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP`                | Entry creation date.                           |
| `updated_at` | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Last update date.                 |


### 3. `comments` Table

| Column         | Type                | Constraints                     | Description                                  |
|----------------|---------------------|---------------------------------|----------------------------------------------|
| `id`           | INT                | PRIMARY KEY, AUTO_INCREMENT     | Unique ID for each comment.                  |
| `user_id`      | INT                | FOREIGN KEY (`users.id`)        | User who posted the comment.                 |
| `event_id`     | INT                | FOREIGN KEY (`events.id`)       | ID of the event being commented on.          |
| `content`      | TEXT               | NOT NULL                        | Comment text.                                |
| `status`       | ENUM('visible', 'hidden') | DEFAULT 'visible'          | Status for moderation (visible or hidden).   |
| `moderated_by` | INT                | FOREIGN KEY (`users.id`), NULL  | Admin who moderated the comment.             |
| `created_at`   | TIMESTAMP          | DEFAULT CURRENT_TIMESTAMP       | Comment creation date.                       |

---

### 4. `events` Table

| Column         | Type                | Constraints                     | Description                                  |
|----------------|---------------------|---------------------------------|----------------------------------------------|
| `id`           | INT                | PRIMARY KEY, AUTO_INCREMENT     | Unique ID for each event.                    |
| `title`        | VARCHAR(200)       | NOT NULL                        | Event title.                                 |
| `description`  | TEXT               | NOT NULL                        | Detailed description of the event.           |
| `image`        | VARCHAR(255)       | NULL                            | Path to event image.                         |
| `keywords`     | VARCHAR(255)       | NULL                            | SEO keywords.                                |
| `start_time`   | DATETIME           | NOT NULL                        | Event start time.                            |
| `end_time`     | DATETIME           | NOT NULL                        | Event end time.                              |
| `location`     | VARCHAR(255)       | NOT NULL                        | Event location.                              |
| `created_at`   | TIMESTAMP          | DEFAULT CURRENT_TIMESTAMP       | Event creation date.                         |
| `updated_at`   | TIMESTAMP          | ON UPDATE CURRENT_TIMESTAMP     | Last update date.                            |


### 5. `pages` Table

| Column       | Type            | Constraints                | Description                       |
|--------------|-----------------|----------------------------|-----------------------------------|
| `id`         | INT             | PRIMARY KEY, AUTO_INCREMENT | Unique ID for each page.          |
| `title`      | VARCHAR(100)    | NOT NULL                    | Page title.                       |
| `content`    | TEXT            | NOT NULL                    | Page content (HTML or Markdown).  |
| `created_at` | TIMESTAMP       | DEFAULT CURRENT_TIMESTAMP   | Page creation date.               |
| `updated_at` | TIMESTAMP       | ON UPDATE CURRENT_TIMESTAMP | Last update date.                 |


### 6. `map` Table
| Column       | Type            | Constraints                                | Description                                    |
|--------------|-----------------|--------------------------------------------|------------------------------------------------|
| `id`         | `INT`           | `PRIMARY KEY, AUTO_INCREMENT`              | Unique ID for each map.                        |
| `name`       | `VARCHAR(255)`  | `NOT NULL`                                 | Name of the map.                               |
| `image`      | `VARCHAR(255)`  | `NULL`                                     | Path to the map's image.                       |
| `created_at` | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP`                | Entry creation date.                           |
| `updated_at` | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP` | Last update date.                 |

### 7. `user_heroes` Table
| Column             | Type            | Constraints                                                       | Description                                                        |
|--------------------|-----------------|-------------------------------------------------------------------|--------------------------------------------------------------------|
| `id`               | `INT`           | `PRIMARY KEY, AUTO_INCREMENT`                                     | Unique ID for each record.                                         |
| `user_id`          | `INT`           | `NOT NULL`                                                        | User ID (Foreign Key linked to the `users` table).                 |
| `hero_id`          | `INT`           | `NOT NULL`                                                        | Hero ID (Foreign Key linked to the `heroes` table).                |
| `date_purchased`   | `TIMESTAMP`     | `DEFAULT CURRENT_TIMESTAMP`                                       | The timestamp when the hero was purchased (default is current time).|
| `unique_user_hero` | `UNIQUE KEY`    | `(user_id, hero_id)`                                              | Ensures each user can only own one unique hero.                     |
| `FOREIGN KEY (user_id)` | `FOREIGN KEY` | `REFERENCES users(id) ON DELETE CASCADE`                       | Foreign Key linking to the `users` table, cascading on delete.     |
| `FOREIGN KEY (hero_id)` | `FOREIGN KEY` | `REFERENCES heroes(id) ON DELETE CASCADE`                      x   | Foreign Key linking to the `heroes` table, cascading on delete.    |



## Payment Credit Cards Test Details
### Momo
ATM Cards Test Details: https://developers.momo.vn/v3/docs/payment/onboarding/test-instructions/#atm-cards-test-details
### ZaloPay
Bank card information for Portal Payment: https://docs.zalopay.vn/en/v2/start/#A-III