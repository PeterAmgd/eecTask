Complete this steps by that order
1)composer install
2)Rename or copy .env.example file to .env 1.php artisan key:generate to generate app key.
3)Set your database credentials in your .env file
4)Set your APP_URL in your .env file.
5)php artisan storage:link
6)php artisan migrate
7)php artisan db:seed --class=ProductsTableSeeder
8)php artisan db:seed --class=PharmaciesTableSeeder
9)php artisan db:seed --class=PharmacyProductTableSeeder
10)npm install
11)npm run dev

//here I used the perfix "admin" 
http://127.0.0.1:8000/admin/products
In products page u can click on any row to show details
on eye button to assign product to pharmacy or many pharmacies

to use that command "php artisan products:search-cheapest product_id"
please make sure the product_id is from products table in products page 


