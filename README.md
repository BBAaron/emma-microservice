# Start
To start the application first make sure WSL2 is enabled if you're on Windows. 
Next make sure you have docker installed and configure it to use WSL2, in my case I use Ubuntu20.04.

Once these things are done, you can run the command `./vendor/bin/sail up` in this directory. When this has finished you can run `./vendor/bin/sail artisan migrate` and `./vendor/bin/sail artisan db:seed`. 

Now you should be able to make a POST request to localhost/cart with e.g. this JSON payload. I recommend using Postman for this.

```
POST /api/cart HTTP/1.1
Host: localhost
Content-Type: application/json
Content-Length: 316

{
    "products" : [
        {"id":1,"name":"banana","unitPrice":1.2,"count":2,"total":2.4},
        {"id":2,"name":"apple","unitPrice":1,"count":5,"total":5},
        {"id":3,"name":"mango","unitPrice":1.5,"count":3,"total":4.5},
        {"id":4,"name":"orange","unitPrice":1.1,"count":10,"total":11}
    ]
}
```



