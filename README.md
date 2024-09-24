# AgronomProject

1. [Project Overview](#project-overview)

   - [Technology Stack](#technology-stack)
   - [Integrations](#integrations)

2. [Getting Started](#getting-started)

   - [Development Setup](#development-setup)
   - [Production Setup](#production-setup)
   - [CI/CD with GitHub Actions](#cicd-with-github-actions)

3. [Entities](#entities)

4. [Resources](#resources)

## Project Overview

AgronomProject is an online store built with Laravel that allows users to make purchases online. The main features include:

- Products: A list of products that can be purchased.
- Product Categories: Products are organized into categories for easy navigation.
- User Account: Users can register, log in, manage orders, and account settings.
- Online Payments: Integration with YooKassa (formerly Yandex.Kassa) for secure online transactions.
- Bonus System: Users can earn and use bonuses for discounts on future purchases.

A working version of the project is available at [agronomcity.ru](https://agronomcity.ru).

### Technology Stack

The application is built on Laravel 11, leveraging a modern and efficient stack to deliver high performance and scalability.

- **Backend**:

  - **Laravel 11**: The latest version of the Laravel framework, used for building the application's backend and managing business logic.
  - **Laravel Sail**: A lightweight command-line interface for managing a Docker-based development environment without the need for configuring Docker manually.
  - **Filament 3**: powerful admin panel used to manage the application's content and resources, providing an intuitive interface for non-technical users to update and maintain the website.
  - **Livewire 3**: A reactive framework for creating dynamic, interactive components on the frontend without the need for complex JavaScript code. It allows for server-side rendering and state management, improving the user experience.
  - **PHP 8.3**: The primary programming language.
  - **MySQL 8.0**: A relational database for storing and retrieving application data.

- **Frontend**:
  - **Vite**: A fast tool for building and serving frontend assets.
  - **Alpine.js**: A lightweight JavaScript framework used for handling basic frontend interactivity.
  - **Swiper.js**: A modern JavaScript library for implementing touch-friendly sliders and carousels on the frontend, providing a smooth and responsive user experience for content presentation.

### Integrations:

- **YooKassa**: A payment gateway integration for processing secure online payments.

## Getting Started

This section will guide you through the setup process for both development and production environments. Additionally, we’ll provide a resource for setting up CI/CD using GitHub Actions.

### Prerequisites

- **PHP ^8.3**
- **Composer**
- **Node.js & npm**
- **Docker** (for Laravel Sail)

### Development Setup

To set up the development environment for the **AgronomProject** application, follow these steps:

#### Steps

1. **Clone the repository**:
   ```bash
   git clone [repository_url]
   cd [project_name]
   ```
2. Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
3. Install PHP and Node dependencies:
   ```bash
   composer install
   npm install
   ```
4. **Start the development environment with Laravel Sail**:
   ```bash
   ./vendor/bin/sail up -d
   ```
5. Generate an application key and storage link:
   ```bash
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan storage:link
   ```
6. Migrate the database and seed the database:
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```
7. Build frontend assets:
   ```bash
   npm run dev
   ```
8. Create an admin user:

   ```bash
   ./vendor/bin/sail artisan php artisan make:filament-user
   ```

9. Code style and linting using Laravel pint and Prettier:
   ```bash
   npm run style
   ```

At this point, the application should be accessible at http://localhost:3000 (or a different port if using Sail).

PhpMyAdmin can be used to manage the database.
(http://localhost:8080)

### Production Setup

For deploying the application in a production environment, follow these steps:

- Clone the repository to your server;
- Set environment variables:

  Copy .env.example to .env, and modify the environment variables to match your production environment, especially database and payment system configurations.

- Install PHP and Node dependencies:
  ```bash
  composer install
  npm install
  ```
- Generate an application key and storage link:
  ```bash
  php artisan key:generate
  php artisan key:generate
  ```
- Run database migrations:
  ```bash
  php artisan migrate --force
  ```

### CI/CD with GitHub Actions

To automate the deployment of Agronom application, you can use GitHub Actions for CI/CD. For a detailed guide, refer to the following article:

[dev.to/kenean50/automate-your-laravel-app-deployment-with-github-actions-2g7j](https://dev.to/kenean50/automate-your-laravel-app-deployment-with-github-actions-2g7j)

Secrets & Variables `.github/workflows/deploy.yml`:

```bash
secrets.HOST
secrets.PORT
secrets.USERNAME
secrets.SSHKEY
vars.SCRIPT
```

## Entities

Almost all entities are editable in the filament control panel.

- [Article](./app/Models/Article.php): Represents a published article or blog post on the platform.
- [Banner](./app/Models/Banner.php): Defines a promotional banner displayed on the website, likely used for advertising or highlighting special offers.
- [Bonus](./app/Models/Bonus.php): Represents a bonus or reward that can be earned by users, possibly tied to loyalty programs or purchases.
- [Callback](./app/Models/Callback.php): Represents a form for collecting requests for callbacks from a website. May contain data from forms for requesting a callback, such as a name, phone number, and other contact information.
- [Cart](./app/Models/Cart.php): Manages the shopping cart for guests and users. Contains cart and wishlist.
- [CartItem](./app/Models/CartItem.php): Represents an item in the cart or wishlist. Contains information about the product and quantity.
- [Category](./app/Models/Category.php): Represents a category of products on the platform. May contain only products.
- [Coupon](./app/Models/Coupon.php): Represents a coupon code that can be used to get discounts on orders.
- [Loyalty](./app/Models/Loyalty.php): Manages loyalty programs, tracking user rewards and points.
- [Order](./app/Models/Order.php): Represents an order placed by a user. May contain items, shipping, and payment information. _When changing the status, it changes the stock of goods or variations, data on promo codes (coupon), sends notifications to administrators/client_
- [OrderItem](./app/Models/OrderItem.php): Represents a single item within an order.
- [Page](./app/Models/Page.php): Defines a static page on the website, such as an about page or terms of service.
- [Product](./app/Models/Product.php): Represents a product on the platform. May contain variations.
- [Prop](./app/Models/Prop.php): May represent a property or attribute that is not stored in the config directory.
- [Review](./app/Models/Review.php): Represents a user review or rating of a product.
- [ProductVariation](./app/Models/ProductVariation.php): Defines a variation of a product, such as different sizes or colors.
- [VariationGroup](./app/Models/VariationGroup.php): Represents a group of product variations, used for organizing and displaying related products.
- [User](./app/Models/User.php): Represents a registered user on the platform, storing information about their account and activity.

## Resources

Documentations:

- [Livewire](https://livewire.dev/)
- [Filament](https://filamentphp.com/docs)
- [Alpine.js](https://alpinejs.dev/)
- [Swiper.js](https://swiperjs.com/)
- [Laravel Sail](https://laravel.com/docs/11.x/sail)
- [Laravel MediaLibrary](https://github.com/spatie/laravel-medialibrary)
- [Laravel Sitemap](https://github.com/spatie/laravel-sitemap)
- [Laravel Phone](https://github.com/Propaganistas/Laravel-Phone)
- [SeoTools](https://github.com/artesaos/seotools)
- [YooKassa](https://git.yoomoney.ru/projects/SDK/repos/yookassa-sdk-php/browse)
