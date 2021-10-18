# Jetstream Shop API

### Shop REST API with adminpanel example using Laravel Jetstream Inertia.

### Requirements:
- php >= 7.0
- mysql

### Installation:
- clone repository
- run `composer install` & `npm install`
- edit .env file
- create symlink for file storage
- run `php artisan migrate`
- run `npm run dev`
- register user via Jetstream register, go to DB, set `role = 2` and comment registration jetstream functionality (Not API)
- Use adminpanel


### REST API

1.) Registration:  
URL: `/register`
Method: POST
Headers:  `Content-Type: application/JSON`
Parameters (example):
```json
{
  "name": "Fname Lname",
  "email": "test@test.com",
  "password": "11111111",
  "device_name": "browser_postman"
}
```

Response (example):
```json
{
    "token": "5|DyIfheF1YuraZizQxTN5uO3Wq2dEeOeljVTnHFia"
}
```

2.) Authorization:
URL: `/authorize`
Method: POST
Headers:  `Content-Type: application/JSON`
Parameters (example):
```json
{
  "email": "test@test.com",
  "password": "11111111",
  "device_name": "browser_postman"
}
```

Response (example):
```json
{
    "token": "5|DyIfheF1YuraZizQxTN5uO3Wq2dEeOeljVTnHFia"
}
```

3.) Categories:
Authorization:
URL: `/catalog/categories`
Method: GET
Headers:  `Bearer {AUTH_TOKEN}`


Response (example):
```json
{
    "categories": [
        {
            "slug": "desktops",
            "title": "Desktops"
        },
        {
            "slug": "notebooks",
            "title": "Notebooks"
        },
        {
            "slug": "mobile-phones",
            "title": "Mobile phones"
        }
    ]
}
```


4.) Products:
Authorization:
URL: `/catalog/products`
Method: GET
Headers:  `Bearer {AUTH_TOKEN}`
Parameters: 
- `page` - page, not required
- `search` - search text, not required
- `sort_by` - order column, not required
- `sort_order` - sort order, not required, default 'ASC'

Response (example):
```json
{
    "products": {
        "current_page": 1,
        "data": [
            {
                "title": "Gaming PC 3D",
                "slug": "gaming-pc-3d",
                "category": "Desktops",
                "price": "450.00",
                "image_url": "http://localhost/ustora-shop/public/storage/product_images/3rc28xtxNnGIq96z2GWqQGqmXQuLj01P6s1BBFGx.jpg"
            }
        ],
        "first_page_url": "http://localhost/ustora-shop/public/api/catalog/products?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost/ustora-shop/public/api/catalog/products?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost/ustora-shop/public/api/catalog/products?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost/ustora-shop/public/api/catalog/products",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

5.) Products by category:
Authorization:
URL: `/catalog/categories/:slug`
Method: GET
Headers:  `Bearer {AUTH_TOKEN}`
Parameters:
- `page` - page, not required
- `search` - search text, not required
- `sort_by` - order column, not required
- `sort_order` - sort order, not required, default 'ASC'

Response (example):
```json
{
    "products": {
        "current_page": 1,
        "data": [
            {
                "title": "Gaming PC 3D",
                "slug": "gaming-pc-3d",
                "category": "Desktops",
                "price": "450.00",
                "image_url": "http://localhost/ustora-shop/public/storage/product_images/3rc28xtxNnGIq96z2GWqQGqmXQuLj01P6s1BBFGx.jpg"
            }
        ],
        "first_page_url": "http://localhost/ustora-shop/public/api/catalog/products?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost/ustora-shop/public/api/catalog/products?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost/ustora-shop/public/api/catalog/products?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost/ustora-shop/public/api/catalog/products",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```


6.) Product details:
Authorization:
URL: `/catalog/products/:slug`
Method: GET
Headers:  `Bearer {AUTH_TOKEN}`

Response (example):
```json
{
    "product": {
        "id": 1,
        "title": "Gaming PC 3D",
        "slug": "gaming-pc-3d",
        "category_id": 1,
        "description": "Here is high quality poly model. Ideal for close up renders.\nOriginally modeled in 3ds max 2014. Final images rendered with VRay.\nIts includes poly model with all textures and shaders",
        "price": "450.00",
        "enabled": 1,
        "created_at": "2021-10-03T15:21:35.000000Z",
        "updated_at": "2021-10-04T17:36:35.000000Z",
        "image_path": "public/product_images/3rc28xtxNnGIq96z2GWqQGqmXQuLj01P6s1BBFGx.jpg",
        "image_url": "http://localhost/ustora-shop/public/storage/product_images/3rc28xtxNnGIq96z2GWqQGqmXQuLj01P6s1BBFGx.jpg"
    }
}
```


7.) Create order:
Authorization:
URL: `/checkout`
Method: POST
Headers:  `Authorization: Bearer {AUTH_TOKEN}`
          `Content-Type: application/JSON`
Parameters (example):
```json
{
    "items": [
        "product_id": 1,
        "quantity": 3
    ]
}
```
Response (example):
```json

```



