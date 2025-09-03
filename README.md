# Mytheresa Promotions API (Symfony 6.4)

This is a coding challenge for Mytheresa backend position.  
It provides a REST API endpoint to list products with promotions/discounts applied.

## Requirements

- PHP >= 8.1
- Composer
- Symfony CLI (optional, you can use PHP built-in server)

## Installation

```bash
git clone https://github.com/<YOUR-USER>/mytheresa-promotions.git
cd mytheresa-promotions
composer install
```

## Run the application

```bash
composer start
```

Application will be available at:  
[http://127.0.0.1:8000/products](http://127.0.0.1:8000/products)

## Run tests

```bash
composer test
```

## Endpoints

### `GET /products`

Query parameters:
- `category` (optional) → filter by product category.
- `priceLessThan` (optional) → filter by original price (before discounts).

Returns a JSON list of up to **5 products** with applied promotions.

Example response:

```json
{
  "products": [
    {
      "sku": "000001",
      "name": "BV Lean leather ankle boots",
      "category": "boots",
      "price": {
        "original": 89000,
        "final": 62300,
        "discount_percentage": "30%",
        "currency": "EUR"
      }
    }
  ]
}
```

## Project structure

```
src/
  Domain/          # Entities (Product DTO)
  Application/     # Application services (ProductService)
  Infrastructure/  # Data sources (JsonFile, InMemory for tests)
  Controller/      # HTTP endpoints
var/data/          # Product dataset
```