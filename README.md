# Book Management Application

This is a dynamic and user-friendly book management application built with Laravel and Livewire. 

It provides a seamless interface for performing CRUD (Create, Read, Update, Delete) operations on book records without requiring page reloads.

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

## Technical Stack

* **Laravel 10**
* **Livewire 2**
* **Bootstrap 5**
* **Font Awesome**
* **jQuery 3**

## Installation and Setup

1. Clone the repository.
2. Run `composer install`.
3. Run `npm install`.
4. Copy `.env.example` to `.env` and configure your database connection.
5. Run `php artisan key:generate`.
6. Run `php artisan migrate`.
7. (Optional) Run `php artisan db:seed` to seed the database with sample data.
8. Run `npm run dev` or `npm run build`.
9. Start your Laravel development server (e.g., `php artisan serve`).

## Database

* **Migrations:** The application utilizes Laravel's migration system to manage the database schema. You can find the migration file for the `books` table in the `database/migrations` directory.
* **Seeders:** (Optional) If you want to populate your database with sample data, you can create seeders for your `Book` model and run them using the `php artisan db:seed` command.

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

## TODOs

* **Backend**
    * Implement a basic authentication system (login/logout) for library employees.
    * Restrict book registration functionality to authenticated users.
    * Write unit tests for the main functionalities (authentication, book registration, book management).
    * Implement security measures to protect against common vulnerabilities (e.g., CSRF, SQL injection).
    * Implement proper error handling and display user-friendly error messages.

* **Search and Filtering:**
    * Implement a search bar to allow users to search for books by title, author, or ISBN.
    * Add filtering options to narrow down the book list based on genre, publication date, or other criteria.

* **Book Borrowing and Returns:**
    * Extend the application to track book borrowing and returns.
    * Allow users to mark books as borrowed or returned.
    * Implement features to manage due dates, overdue books, and fines.

* **User Management:**
    * If applicable, add functionality to manage library members or patrons.
    * Allow users to register, log in, and view their borrowing history.

* **Book Availability Status:**
    * Display the availability status of each book (e.g., available, borrowed).
    * Allow users to place holds on books that are currently borrowed.

* **Book Cover Images:**
    * Enable uploading and displaying book cover images.

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
