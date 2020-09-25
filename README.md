#Shopping app Admin and API
Technology: PHP, YII2, MySql

Database folder(sql files): shopping_app\db

<strong>App url(backend): http://localhost/shopping_app/web/product/index</strong>


<h3>Get all products details with images</h3>
<strong>API Url: http://localhost/shopping_app/web/product-api/all-products</strong>
<pre>
<code>
Method: GET

Response:	
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "name": "Product 1",
            "price": 1500,
            "images": [
                {
                    "image_name": "shirt_1.jpg",
                    "image_path": "http://localhost/shopping_app/web/uploads/products/1_1.jpg"
                },
                {
                    "image_name": "shirt_2.jpg",
                    "image_path": "http://localhost/shopping_app/web/uploads/products/1_2.jpg"
                }
            ]
        },
        {
            "id": 2,
            "name": "Product 2",
            "price": 2000,
            "images": [
                {
                    "image_name": "blue_jeans.jpg",
                    "image_path": "http://localhost/shopping_app/web/uploads/products/2_1.jpg"
                }
            ]
        }
    ]
}
</code>
</pre>

<h3>Add products to cart using user id and proctuct details</h3>
<strong>API Url: http://localhost/shopping_app/web/cart-api/add</strong>
<pre>
	<code>
Method: POST
Content type: JSON
Body: RAW

Post json data:
{
    "user_id" : "1",
    "products":[
        {
            "product_id":"1",
            "quantity":"2"
        },
        {
            "product_id":"2",
            "quantity":"4"
        }
    ]
}

Response:	
{
    "user_id" : "1",
    "products":[
        {
            "product_id":"1",
            "quantity":"2"
        },
        {
            "product_id":"2",
            "quantity":"4"
        }
    ]
}
	</code>
</pre>

<h3>Get all products added in cart</h3>
<strong>API Url: http://localhost/shopping_app/web/cart-api/user-cart?userId=1</strong>
<pre>
<code>
Method: GET
Response:	
{
    "status": 200,
    "data": [
        {
            "product_id": 1,
            "product_name": "Product 1",
            "quantity": 2
        },
        {
            "product_id": 2,
            "product_name": "Product 2",
            "quantity": 4
        }
    ]
}
</code>
</pre>

