# Shopping-App-Back-End

This is the backend API for our Shopping App, built with Laravel. It provides the functionality for user registration, authentication, product management, and order processing.

## Table of Contents

- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
  - [Authentication](#authentication)
  - [User Routes](#user-routes)
  - [Product Routes](#product-routes)
  - [Cart Routes](#cart-routes)
  - [Order Routes](#order-routes)

## Getting Started

### Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP >= 7.3
- Composer
- MySQL or another compatible database
- Laravel CLI

### Installation

1. **Clone this repository:**

   ```shell
   git clone https://github.com/your-username/shopping-app-backend.git
   
2. **Navigate to the project directory:**

   ```shell
   cd shopping-app-backend

3. **Install project dependencies:**

   ```shell
   composer install
   
4. **Create a .env file by copying the .env.example file and configuring it with your database credentials and other environment-specific settings.**
5. **Generate a new application key:**

   ```shell
   php artisan key:generate
   
6. **Run the database migrations and seed the database:**

   ```shell
   php artisan migrate --seed

7. **Start the development server:**

   ```shell
   php artisan serve

  Now, your backend API should be up and running.

## Usage

### Authentication
- POST /api/customer: Register a new customer account.
- POST /api/admin: Register a new admin account.
- POST /api/login: Authenticate a user and receive an access token.
- POST /api/logout: Logout User.
### User Routes
- GET /api/user: Get a list of all users.
- GET /api/user/{id}: Get a specific user's details.
- PUT /api/user/{id}: Update a user's information (admin only).
- DELETE /api/user/{id}: Delete a user (admin only).
### Product Routes
- GET /api/products: Get a list of all products.
- GET /api/products/{id}: Get a specific product's details.
- POST /api/product: Add a new product (admin only).
- PUT /api/product/{id}: Update a product's details (admin only).
- DELETE /api/product/{id}: Delete a product (admin only).
### Cart Routes
- GET /api/cart: Get the user's shopping cart.
- GET /api/cart/{id}: Get a specific shopping cart item.
- POST /api/cart/{product_id}: Add a product to the cart.
- PUT /api/cart/{id}: Update the quantity of a product in the cart.
- DELETE /api/cart/{id}: Remove a product from the cart.
### Order Routes
- GET /api/order: Get a list of all orders (admin only).
- GET /api/order/{id}: Get a specific order's details.
- POST /api/order/{product_id}: Place a new order.
- PUT /api/order/{id}: Update the status of an order (admin only).
### File Upload
- GET /api/files: Get a list of all filenames.
- POST /api/files/add: Upload a file.
- POST /api/files/{product_id}/{filename}: View a file.


