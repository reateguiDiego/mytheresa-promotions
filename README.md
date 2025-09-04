![CI](https://github.com/reateguiDiego/mytheresa-promotions/actions/workflows/ci.yml/badge.svg)

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

## Stop the application

```bash
composer stop
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

#### Example request with filters

`GET /products?category=boots&priceLessThan=80000`

This will return boots priced ≤ €800 (80 000 cents), with promotions applied.

## Project structure

```
src/
  Domain/          # Entities (Product DTO)
  Application/     # Application services (ProductService)
  Infrastructure/  # Data sources (JsonFile, InMemory for tests)
  Controller/      # HTTP endpoints
data/              # Product dataset
.github/workflows/ # CI pipeline definition (GitHub Actions)
```

## Design Decisions

- **Domain / Application / Infrastructure separation**:  
  Chosen to keep business logic isolated from framework and transport (Clean Architecture inspiration).

- **Products stored in JSON**:  
  Enough for the coding challenge. Could be swapped for a database by changing only the `ProductDataSourceInterface` implementation.

- **DTO with price in cents (int)**:  
  Avoids floating point rounding errors and matches the requirement (`100€ = 10000`).

- **Filtering before discounts**:  
  The requirement explicitly asks for `priceLessThan` to apply before discounts.

- **Limit to 5 results**:  
  Enforced after filtering and applying discounts. The order is not relevant for the assignment.

- **Discount logic centralized in ProductService**:  
  Easy to test and extend. Could evolve into separate `DiscountPolicy` classes for flexibility (Strategy Pattern).

- **Testing**:  
  - Unit tests: ProductService with in-memory datasource.  
  - Functional tests: `/products` endpoint.  
  - Tests do not depend on filesystem or network.

- **Complexity**:  
  Algorithm is O(n), linear with the number of products. Handling 20k items is easy for PHP.  
  For larger datasets, replace JSON with a database and apply filters in SQL.

```
⚠️ Note: The `APP_SECRET` value in `.env` is a placeholder used only for local/dev and testing purposes.  
In production, this should be set via environment variables or Symfony secrets.  
This value does not represent any real credential.
```
