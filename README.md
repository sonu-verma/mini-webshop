## rename .env-local to .env
.env-local -> .env

## for dependency  please run composer command
composer install

## for tables run migration command
php artisan migrate

## To Run Project on 8000 port please run
php  artisan serve --port=8000

## Import Master Data
php artisan import:masterdata

## API List

# Get Order List
    *URL: http://localhost:8000/api/orders (GET)

# Create Order #
    * URL: http://localhost:8000/api/orders (POST)
    * Request: 
        {
            "customer_id": 10
        }
            Or
        {
            "customer_id": 10,
            "product_id": 5
        }

    * Note: if product id passed on request parameter that will attached to the order else order created with customer id only

# Update Order #
    * URL: http://localhost:8000/api/orders/{order_id} (PUT)
    * Request: 
        {
            "customer_id":2,
            "product_id": 2
        }

    * Note: product_id will attached to order and to update customer_id and payed then need to add on order request parameter.

# Delete Order #
    * URL: http://localhost:8000/api/orders/{order_id} (DELETE)

    * Note: added condition if paid then not able to delete order else order will delete and product will also delete

# Attached Product
    * URL: http://localhost:8000/api/order/{order_id}/add (POST)
    
    * Request:
        {
            "product_id": 50
        }

# Pay Order
    * URL: http://localhost:8000/api/order/{order_id}/pay (POST)
    
    * Request:
        {
            "order_id": 4,
            "customer_email": "Harvey_Thornton4640@hourpy.biz",
            "value": 70
        }

    * Note: I have not used url order id because on request parameter also added order_id parameter so i have used that for action (on PaymentProviderFactory file we can add new payment type of implementation)


## Estimated vs. Tracked Time

| Task                   | Estimated Time (in hours) | Tracked Time (in hours) |
|------------------------|---------------------------|-------------------------|
| Analyzing requirements | 1                         | 1.5                     |
| Implementing backend   | 6                         | 8                       |
| Bug fixing             | 1                         | 1.5                     |
| Documentation          | 0.5                       | 1                       |
| **Total**              | **8.5**                   | **12**                  |


## Postman Collection

*Note: I have added a collection of Postman related to APIs in PostmanCollection folder under the main project folder.

