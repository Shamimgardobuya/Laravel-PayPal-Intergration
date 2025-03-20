web app for intergrating Paypal payment in a Laravel application. App curently contains web page for Paypal where user will make payment for donation to  a school and also api's such as users and staff for management of a school.

How to get Started
Prerequisites for installment 
  Laravel
  Composer
  Relational Database
  Node and npm
Clone the repository.
Run composer install
Run migrations by using the command php artisan migrate
RUn database seeders 
npm run dev 

REST API routes
To Make payment, visit the landing endpoing , localhost:8000/

To Create a Staff member ,
  visit endpoint http://localhost:8000/api/staff/create
   and make a post request with these values filled:
       first_name => required input
       last_name => required input
       role => required, depends on the role of the staff, if Teacher , head teacher  or cook.
       email => not required.
       phone => not required
       file => not required, a profile picture of the staff
       

To create a User.
visit the endpoint with a POST request 
    http://localhost:8000/api/users/create
    payload : name,email,  password and role_name.
    NB: role_name can only have any of these 2 values  Super Admin and Staff
To login the user
  visit the endpoint with a POST request 
    http://localhost:8000/api/users/login
    payload : email and password. You will receive a token that you are to persist with any other request that you make to the server.
To edit a user
    visit the endpoint with a PATCH request
      http://localhost:8000/api/users/update/{id}
      parameters, name , email, password.
  
To delete a user 
   visit the endpoint with a DELETE request
      http://localhost:8000/api/users/delete/{id}
   
