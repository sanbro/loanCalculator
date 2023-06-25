# Mortgage Loan Calculator Web Application

This is a web application built using Laravel that provides a mortgage loan calculator. It allows users to input loan details such as loan amount, interest rate, and loan term. The application generates an amortization schedule that shows the monthly payment breakdown, including the principal and interest components, for the entire loan term. It also supports fixed terms and extra repayments.

## Project Setup

Follow the instructions below to set up and run the Mortgage Loan Calculator web application.

### Prerequisites

Before getting started, ensure that you have the following software installed:

- PHP (>= 7.4)
- Composer
- MySQL (or any other database of your choice)

### Installation

1. Clone the repository by running the following command in your terminal:

```shell
git clone <repository-url>
```

2. Navigate to the project directory:

```shell
cd mortgage-loan-calculator
```

3. Install the project dependencies using Composer:

```shell
composer install
```

4. Create a copy of the `.env.example` file and rename it to `.env`:

```shell
cp .env.example .env
```

5. Generate an application key:

```shell
php artisan key:generate
```

6. Update the `.env` file with your database credentials.

7. Run the database migrations to create the necessary tables:

```shell
php artisan migrate
```

8. Serve the application locally:

```shell
php artisan serve
```

9. Visit `http://localhost:8000` in your browser to access the application.

### Testing

To run the unit tests for the application, use the following command:

```shell
php artisan test
```

The unit tests cover various scenarios for the loan calculation and ensure the accuracy of the results.

## Development Workflow

To contribute to this project, please follow these guidelines:

1. Create a fork of the main repository.

2. Clone your forked repository to your local machine.

```shell
git clone <your-forked-repository-url>
```

3. Create a new branch to implement your changes.

```shell
git checkout -b feature/loan-calculation
```

4. Implement the necessary logic and make the desired changes.

5. Commit your changes with clear and descriptive commit messages.

6. Push your branch to your forked repository.

```shell
git push origin feature/loan-calculation
```

7. Create a pull request from your branch to the `main` branch of the main repository.

8. Await feedback and address any comments or suggestions provided.

## Coding Practices and Patterns

This project adheres to coding practices and patterns to ensure clean, maintainable, and readable code. Please follow these guidelines when making changes:

- Use proper naming conventions for variables, functions, and classes.
- Follow the PSR-12 coding style guidelines.
- Write unit tests to cover your code and ensure its correctness.
- Apply SOLID principles to maintain a high level of code quality.
- Avoid code smells and refactor any existing code if necessary.
- Write clean and meaningful commit messages.

## License

This project is open source and available under the [MIT License](https://opensource.org/licenses/MIT).

## Acknowledgements

This project is based on Laravel, an excellent PHP framework. Special thanks to the Laravel community for their contributions and support.