# API Documentation

## Overview
This API provides endpoints for managing products and categories. It includes features like filtering, searching, pagination, caching, and rate limiting.

---

## Base URL
```
http://127.0.0.1:8000/trans-api
```

---

## Authentication
Currently, the API is open but can be secured using Laravel's authentication middleware.

---

## Endpoints

### 1️⃣ Products API

#### 📌 Get All Products (Paginated with Filtering & Search)
```
GET /products
```
**Query Parameters (Optional):**
- `category_id=5` → Filter products by category.
- `search=keyword` → Search by name or description.
- `page=2` → Paginate results.

**Example Request:**
```sh
curl -X GET "http://127.0.0.1:8000/api/products?category_id=5&search=laptop&page=1"
```

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Gaming Laptop",
      "description": "Powerful laptop for gaming",
      "price": 1200.00,
      "category_id": 5
    }
  ]
}
```

---

#### 📌 Get a Single Product by ID
```
GET /products/{id}
```
**Example Request:**
```sh
curl -X GET "http://127.0.0.1:8000/api/products/1"
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Gaming Laptop",
    "description": "Powerful laptop for gaming",
    "price": 1200.00,
    "category_id": 5
  }
}
```

---

#### 📌 Create a New Product
```
POST /products
```
**Request Body (JSON):**
```json
{
  "name": "Wireless Mouse",
  "description": "Ergonomic wireless mouse",
  "price": 25.99,
  "category_id": 3
}
```
**Example Request:**
```sh
curl -X POST "http://127.0.0.1:8000/api/products" \
     -H "Content-Type: application/json" \
     -d '{"name":"Wireless Mouse","description":"Ergonomic wireless mouse","price":25.99,"category_id":3}'
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 2,
    "name": "Wireless Mouse",
    "description": "Ergonomic wireless mouse",
    "price": 25.99,
    "category_id": 3
  }
}
```

---

#### 📌 Update an Existing Product
```
PUT /products/{id}
```
**Request Body (JSON):**
```json
{
  "name": "Updated Mouse",
  "description": "Wireless mouse with better battery life",
  "price": 29.99,
  "category_id": 3
}
```
**Example Request:**
```sh
curl -X PUT "http://127.0.0.1:8000/api/products/2" \
     -H "Content-Type: application/json" \
     -d '{"name":"Updated Mouse","description":"Wireless mouse with better battery life","price":29.99,"category_id":3}'
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 2,
    "name": "Updated Mouse",
    "description": "Wireless mouse with better battery life",
    "price": 29.99,
    "category_id": 3
  }
}
```

---

#### 📌 Delete a Product
```
DELETE /products/{id}
```
**Example Request:**
```sh
curl -X DELETE "http://127.0.0.1:8000/api/products/2"
```

**Response:**
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

---

### 2️⃣ Categories API

#### 📌 Get All Categories (Including Parent-Child Relations)
```
GET /categories
```
**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Electronics",
      "parent_id": null,
      "children": [
        {
          "id": 2,
          "name": "Laptops",
          "parent_id": 1
        },
        {
          "id": 3,
          "name": "Accessories",
          "parent_id": 1
        }
      ]
    }
  ]
}
```

---

## 🔒 Rate Limiting
- Users can make **60 requests per minute**.
- Controlled using Laravel's `throttle` middleware.

---

## 🚀 Caching
Frequently accessed data is cached using Laravel’s cache system.
- Cache Driver: **Redis / Database / File** (configured in `.env`).
- Clear cache manually:
```sh
php artisan cache:clear
```

---

## ⚡ Testing
Run Laravel's built-in tests:
```sh
php artisan test
```

For manual API testing, use:
- **Postman**
- **cURL**
- **API clients like Insomnia**

