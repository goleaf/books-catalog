# Book Management Application

This is a dynamic and user-friendly book management application built with Laravel and Livewire. It provides a seamless interface for performing CRUD (Create, Read, Update, Delete) operations on book records without requiring page reloads.

## Key Features

* **Intuitive Book Listing:**
    * Presents a well-structured and visually appealing table showcasing all book records.
    * Includes columns for Title, Author, ISBN, Publication Date, Genre, and Number of Copies.
    * Features convenient "Edit" and "Delete" buttons for each book, with clear icons for improved user experience.
    * Table headers have a subtle hover effect to enhance visual feedback.

* **Effortless Book Creation and Editing:**
    * Uses a single form for both adding new books and editing existing ones, displayed directly on the page without modals.
    * Incorporates robust validation directly within the Livewire component, ensuring data integrity.
    * Provides clear and informative custom validation error messages, displayed inline next to the respective fields for a user-friendly experience.
    * Dynamically updates the book list after successful addition or update, without requiring page reloads.
    * Includes a "Cancel" button to allow users to discard changes and return to the book list.

* **Safe and Efficient Book Deletion:**
    * Enables the removal of unwanted book records with a clear "Delete" button and a confirmation prompt.
    * Dynamically updates the book list upon successful deletion.

* **Enhanced User Experience**
    * Leverages Livewire's reactive capabilities for a smooth and responsive interface.
    * Eliminates disruptive page reloads.
    * Employs flash messages for timely feedback on actions.
    * Uses Font Awesome icons for visual clarity.
    * Maintains a consistent and visually appealing design.

## Features

### Core Features

* **View Book List:** `true`
* **Add New Book:** `true`
* **Edit Book:** `true`
* **Delete Book:** `true`
* **Real-time Updates:** `true`
* **Custom Validation Messages:** `true`
* **Error Handling:** `true`
* **Flash Messages:** `true`
* **Sorting:** `true`
* **Searching:** `true`
* **Filtering:** `true`

### Additional Features

* **User Authentication:** `true`
* **Authorization (Admin vs Regular User):** `true`
* **Author Management:** `true`
* **Genre Management:** `true`
* **User Management:** `true` (limited to admin users)

### Potential Future Enhancements

* **Book Borrowing and Returns:** `false`
* **Book Availability Status:** `false`
* **Book Cover Images:** `false`
* **Reporting and Analytics:** `false`
* **Notifications:** `false`
* **Book Recommendations:** `false`
* **API Integration:** `false`

## Tech Stack

**Backend**

* **Laravel 10**
* **Livewire 2**
* **PHP >= 8.3**
* **Database: MySQL** (or another database supported by Laravel)

**Frontend**

* **Vite**
* **Bootstrap 5.3.3**
* **Font Awesome 6.6.0**
* **jQuery 3.7.1**
* **Sass**

**Development Tools**

* **Laravel Debugbar**
* **Laravel IDE Helper**
* **Laravel Pint**
* **Laravel Sail**
* **PHPUnit**
* **Spatie Laravel Ignition**

## Requirements

* PHP >= 8.3
* Composer
* Node.js and npm
* MySQL or another database supported by Laravel

## Installation and Setup

1. Clone the repository:
   ```
   git clone https://github.com/goleaf/books-catalog.git
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Create a copy of the `.env.example` file and rename it to `.env`:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Configure your database connection in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

7. Run database migrations:
   ```
   php artisan migrate
   ```

8. (Optional) Seed the database with sample data:
   ```
   php artisan db:seed
   ```

9. Compile assets:
   ```
   npm install && npm run dev
   ```
   or for production:
   ```
   npm install && npm run build
   ```

10. Start the Laravel development server:
    ```
    php artisan serve
    ```

11. Visit `http://localhost:8000` in your web browser to access the application.

## Database

* **Migrations:** The application utilizes Laravel's migration system to manage the database schema. You can find the migration files in the `database/migrations` directory.
* **Seeders:** (Optional) If you want to populate your database with sample data, you can create seeders for your models and run them using the `php artisan db:seed` command.

## How to Use

1. Access the book management page by visiting `/` in your browser.
2. Click the "Add New Book" button to display the book creation form.
3. Fill in the details and click "Add" to create a new book.
4. To edit an existing book, click the "Edit" button on its row. 
5. Make the necessary changes and click "Update" to save the modifications.
6. To delete a book, click the "Delete" button on its row and confirm the deletion.

## Key Improvements

* **Inline validation with custom error messages** for a better user experience
* **No modals or full page reloads** for a smoother and more interactive interface
* **Clearer and more informative flash messages**
* **Consistent design and use of icons** for improved usability
* **Simplified validation using Livewire's built-in capabilities**

## Tests

To run Laravel Pint and automatically fix any code style issues in your tests, use the following command

### Books test:
```
$ ./vendor/bin/pint tests/Feature/BooksTest.php

PASS  Tests\Feature\BooksTest
✓ it can render books component                                                                                                                                                                                  1.84s
✓ it can load books                                                                                                                                                                                              0.48s
✓ it can reset filters                                                                                                                                                                                           2.35s
✓ it can sort books ascending                                                                                                                                                                                    1.05s
✓ it can sort books descending                                                                                                                                                                                   1.16s
✓ it can filter books                                                                                                                                                                                            0.55s
✓ it can create a new book                                                                                                                                                                                       1.94s
✓ it can update an existing book                                                                                                                                                                                 2.17s
✓ it can delete a book                                                                                                                                                                                           0.43s

Tests:    9 passed (29 assertions)
Duration: 12.34s
```
### Authors test:
```
$ ./vendor/bin/pint tests/Feature/AuthorsTest.php

PASS  Tests\Feature\AuthorsTest
✓ it can render authors component                                                                                                                                                                                1.48s
✓ it can load authors                                                                                                                                                                                            0.16s
✓ it can reset filters                                                                                                                                                                                           0.09s
✓ it can sort authors ascending                                                                                                                                                                                  0.09s
✓ it can sort authors descending                                                                                                                                                                                 0.10s
✓ it can filter authors                                                                                                                                                                                          0.06s
✓ it can create a new author                                                                                                                                                                                     0.15s
✓ it can update an existing author                                                                                                                                                                               0.11s
✓ it can delete an author                                                                                                                                                                                        0.08s

Tests:    9 passed (19 assertions)
Duration: 2.70s
```


### Genres test:
```
$ ./vendor/bin/pint tests/Feature/GenresTest.php

PASS  Tests\Feature\GenresTest
✓ it can render genres component                                                                                                                                                                            1.69s
✓ it can load genres                                                                                                                                                                                        0.34s
✓ it can reset filters                                                                                                                                                                                      0.23s
✓ it can create a new genre                                                                                                                                                                                 0.31s
✓ it can update an existing genre                                                                                                                                                                           0.31s
✓ it can delete a genre                                                                                                                                                                                     0.13s

Tests:    6 passed (15 assertions)
Duration: 3.43s

```



## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
