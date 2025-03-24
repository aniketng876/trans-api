# Laravel API Project

## Setup Instructions

### Prerequisites
Ensure you have the following installed:
- PHP (>=8.0)
- Composer
- MySQL
- Laravel (Latest version)

### Installation Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/aniketng876/trans-api
   cd trans-api
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Copy the `.env` file and configure database settings:
   ```sh
   cp .env.example .env
   ```
4. Generate an application key:
   ```sh
   php artisan key:generate
   ```
5. Run database migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```
6. Start the development server:
   ```sh
   php artisan serve
   ```

## API Endpoints

### Product Endpoints
- `GET /products` - Retrieve a paginated list of products (supports filtering by `category_id` and `search` query parameter).
- `GET /products/{id}` - Retrieve a specific product by ID.
- `POST /products` - Create a new product (requires request validation).
- `PUT /products/{id}` - Update an existing product.
- `DELETE /products/{id}` - Delete a product.

### Category Endpoints
- `GET /categories` - Retrieve a nested list of all categories.



## Deployment
Ensure you:
- Set proper environment configurations (`.env`).
- Run migrations and cache optimizations:
  ```sh
  php artisan config:cache
  php artisan route:cache
  ```
