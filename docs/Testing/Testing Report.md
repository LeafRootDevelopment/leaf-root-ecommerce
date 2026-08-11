# Testing Report

## Item: Product Catalogue

### Test: Product Catalogue Loads

Expected:
Product list displayed.

Actual:
Product list displayed.

Result:
Pass

Evidence:
product catalogue.png

----------------------------------------

### Test: Product Link Navigation

Expected:
Product details page opens.

Actual:
Product details page opened successfully.

Result:
Pass

Evidence:
product catalogue.png
product details.png

----------------------------------------

### Test: Product Details Display

Expected:
Product name, description and category displayed.

Actual:
Product name, description and category displayed.

Result:
Pass

Evidence:
product details.png

----------------------------------------

### Test: Back to Catalogue Link

Expected:
Returns to Product Catalogue page.

Actual:
Returned to Product Catalogue page successfully.

Result:
Pass

Evidence:
product details.png
back to catalogue.png

----------------------------------------

## Item: Product Search

### Test: Search for "snake"

Expected:
Only Snake Plant is displayed.

Actual:
Snake Plant displayed and other products filtered out.

Result:
Pass

Evidence:
product search snake.png

----------------------------------------

### Test: Search with Invalid Term

Search Term:
xyz123

Expected:
No matching products message displayed.

Actual:
"No products found matching your search." displayed.

Result:
Pass

Evidence:
product search invalid team.png

----------------------------------------

### Test: Clear Search

Expected:
Clear Search link removes search filter and displays all products.

Actual:
Search filter removed and all products displayed.

Result:
Pass

Evidence:
clear search term.png

----------------------------------------

### Test: Product Price Display in Catalogue

Test Objective:
Verify that product prices are displayed correctly in the customer product catalogue.

Test Steps:
1. Navigate to /products.
2. Review multiple product listings.

Expected Result:
Each product displays its price in pounds sterling (£).

Actual Result:
All products displayed the correct price beneath the product description.

Result:
Pass

Evidence:
catalogue pricing1.png

----------------------------------------

## Item: Category Filtering

### Test: Filter by Indoor Plants

Expected:
Only products belonging to the Indoor Plants category are displayed.

Actual:
Monstera Deliciosa and Snake Plant displayed. Products from other categories were hidden.

Result:
Pass

Evidence:
filter by indoor plants.png

----------------------------------------

### Test: Display All Categories

Expected:
Selecting "All Categories" displays all available products.

Actual:
All products were displayed successfully.

Result:
Pass

Evidence:
display all categories.png

----------------------------------------

### Test: Clear Filters

Expected:
Clicking "Clear Filters" removes both search and category filters and displays all products.

Actual:
Search criteria and category selection were cleared and all products were displayed.

Result:
Pass

Evidence:
filter by indoor plants.png
clear filters.png

----------------------------------------

### Test: Combined Search and Category Filter

Search Term:
plant

Category:
Indoor Plants

Expected:
Only products matching both the search term and selected category are displayed.

Actual:
Results were filtered correctly according to both criteria.

Result:
Pass

Evidence:
combined search and category filter.png

----------------------------------------

### Test: No Matching Products After Filtering

Expected:
When no products match the selected criteria, an appropriate message is displayed.

Actual:
The message "No products found matching your search or filter criteria." was displayed.

Result:
Pass

Evidence:
no products match search or filter.png

----------------------------------------

## Item: Product Pricing

### Test: Create ZZ Plant Product

Test Data:

Product Name:
ZZ Plant

Price:
24.99

Category:
Indoor Plants

Expected Result:
The product is successfully created and appears in the product catalogue with the correct price and category.

Actual Result:
The product was successfully created and displayed with the correct price and category.

Result:
Pass

Evidence: 
create zz plant1.png
create zz plant2.png
create zz plant3.png

----------------------------------------

## Basket Functionality Testing

### Test: Add Product To Basket

Test Objective:

Verify that a customer can add a product to the basket successfully.

Test Data:
Product: ZZ Plant
Price: £24.99
Quantity: 1

Test Steps:

1. Navigate to the Product Catalogue.
2. Select the ZZ Plant product.
3. Enter a quantity of 1.
4. Click "Add To Basket".

Expected Result:
The product is successfully added to the basket and a confirmation message is displayed.

Example:
ZZ Plant (x1) added to your basket!

Actual Result:
The product was successfully added to the basket and the confirmation message was displayed.

Result:
Pass

Evidence:
basket add success1.png
basket add success2.png

----------------------------------------

### Test: Basket Quantity Validation

Test Objective:
Verify that the basket quantity field validates invalid quantities.

Test Data:
Product: ZZ Plant
Quantity: 0

Test Steps:
1. Navigate to the ZZ Plant product page.
2. Set the quantity to 0.
3. Submit the Add To Basket form.

Expected Result:
The basket item is not added and a validation error is displayed.

Example:
The quantity field must be at least 1.

Actual Result:
The validation error was displayed and the product was not added to the basket.

Result:
Pass

Evidence:
basket quantity validation1.png
basket quantity validation2.png

----------------------------------------

### Test: Update Basket Quantity

Test Objective:
Verify that basket quantities can be updated successfully.

Test Data:
Product: ZZ Plant
Original Quantity: 1
Updated Quantity: 3
Price: £24.99

Test Steps:
1. Navigate to the Basket page.
2. Locate ZZ Plant.
3. Change quantity from 1 to 3.
4. Click "Update".

Expected Result:
A confirmation message is displayed.

Example:
Basket updated successfully.
The basket total recalculates correctly.
Expected Basket Total:
£74.97

Actual Result:
The quantity updated successfully and the basket total recalculated correctly.

Result:
Pass

Evidence:
basket update1.png
basket update2.png

----------------------------------------

### Test: Remove Basket Item

Test Objective:
Verify that products can be removed from the basket.

Test Data:
Product: ZZ Plant

Test Steps:
1. Navigate to the Basket page.
2. Click "Remove".
3. Confirm removal when prompted.

Expected Result:
The product is removed from the basket and a confirmation message is displayed.

Example:
Product removed from basket successfully.
The basket updates accordingly.

Actual Result:
The product was removed successfully and the basket contents updated correctly.

Result:
Pass

Evidence:
basket remove1.png
basket remove2.png

----------------------------------------

### Test: Basket Total Calculation

Test Objective:
Verify that basket totals are calculated correctly.

Test Data:
Product: ZZ Plant
Price: £24.99
Quantity: 2

Test Steps:
1. Add ZZ Plant to the basket.
2. Update quantity to 2.
3. Review line total and basket total.

Expected Result:
Line Total:
£49.98
Basket Total:
£49.98

Actual Result:
Line totals and basket totals were calculated correctly.

Result:
Pass

Evidence:
basket totals1.png
basket totals2.png

----------------------------------------
## Checkout Functionality Testing
### Test: Successful Checkout

Test Objective:
Verify that a customer can successfully complete checkout.

Test Data:
Product: ZZ Plant
Quantity: 3
First Name: Jordan
Last Name: Barker
Email: admin@leafroot.test
Phone: 01234567890
Address: 123 High Street
City: West Bromwich
Postcode: B70 1AA

Expected Result:
The order is created successfully and the customer is redirected to the confirmation page.

Actual Result:
The order was created successfully and the confirmation page displayed the order details correctly.

Result:
Pass

Evidence:
checkout success1.png
checkout success2.png

----------------------------------------

### Test: Order Creation

Test Objective:
Verify that checkout creates an order record.

Expected Result:
An order record is created in the database.

Actual Result:
Order #2 was successfully created and displayed on the confirmation page and as OrderItems in the database.

Result:
Pass

Evidence:
checkout success2.png
order item creation1.png

----------------------------------------

### Test: Order Item Creation

Test Objective:
Verify that order items are stored correctly.

Expected Result:
The ordered products, quantities and prices are stored as OrderItems in the database.

Actual Result:
ZZ Plant was stored with quantity 3 and price £24.99 which is reflected on both the checkout success page as OrderItems.

Result:
Pass

Evidence:
checkout success2.png
order item creation1.png

----------------------------------------

### Test: Order Total Calculation

Test Objective:
Verify that order totals are calculated correctly.

Expected Result:
£24.99 × 3 = £74.97

Actual Result:
The order total was calculated correctly and displayed as £74.97.

Result:
Pass

Evidence:
checkout success2.png
order item creation1.png

----------------------------------------

### Test: Basket Cleared After Checkout

Test Objective:
Verify that the shopping basket is cleared after a successful checkout and order creation process.

Test Data:
Product: ZZ Plant
Quantity: 3
Order Total: £74.97

Test Steps:
1. Add ZZ Plant to the basket.
2. Update the quantity to 3.
3. Proceed to Checkout.
4. Enter valid customer details.
5. Submit the order.
6. Wait for the Order Confirmation page to display.
7. Navigate back to the Basket page.

Expected Result:
The basket is emptied after successful checkout and displays the empty basket message.

Example:
Your basket is currently empty.

Actual Result:
The basket was successfully emptied after checkout and displayed the empty basket message.

Result:
Pass

Evidence:
basket cleared1.png

----------------------------------------

### Test: Add Product To Basket From Catalogue

Test Objective:
Verify that customers can add products directly from the product catalogue page.

Test Steps:
1. Navigate to /products.
2. Select a quantity.
3. Click Add To Basket.

Expected Result:
The product is added to the basket without needing to view the product details page.

Actual Result:
The product was successfully added to the basket directly from the catalogue page and the basket updated correctly.

Result:
Pass

Evidence:
catalogue add basket1.png
catalogue add basket2.png

----------------------------------------

### Test: Stock Validation During Add To Basket

Test Objective:

Verify that basket quantities cannot exceed available stock levels.

Test Steps:
1. Select a quantity greater than available stock.
2. Submit the Add To Basket form.

Expected Result:
The system prevents the action and displays an appropriate validation message.

Actual Result:
The product was not added and a validation error message was displayed.

Result:
Pass

Evidence:
stock validation1.png

----------------------------------------

### Test: Product Stock Display

Test Objective:
Verify that product stock levels are displayed correctly to both customers and administrators.

Test Data:
Product: ZZ Plant
Stock Level: 5

Test Steps:
1. Navigate to the Product Catalogue.
2. Locate the ZZ Plant product.
3. Verify the displayed stock level.
4. Log in as an administrator.
5. Navigate to Manage Products.
6. Locate the ZZ Plant product.
7. Verify the displayed stock level.
 
Expected Result:
The current stock quantity is displayed correctly on both the customer-facing catalogue and the admin product management page.

Example:
Stock: 5 available

Actual Result:
The stock level was displayed correctly on both the Product Catalogue and the Admin Products page.

Result:
Pass

Evidence:
catalogue stock1.png
admin stock display1.png

----------------------------------------

### Test: Stock Validation

Test Objective:
Verify that customers cannot add a quantity greater than the available stock level.

Test Data:
Product: ZZ Plant
Available Stock: 5
Attempted Quantity: 6

Test Steps:
1. Set the stock level of ZZ Plant to 5.
2. Navigate to the Product Catalogue.
3. Enter a quantity of 6.
4. Click "Add To Basket".

Expected Result:
The system prevents the action and displays an appropriate validation message.

Example:
The requested quantity exceeds available stock.

Actual Result:
The system prevented the product from being added to the basket and displayed a stock validation error message.

Result:
Pass

Evidence:
stock validation1.png

----------------------------------------

### Test: Stock Reduction After Checkout

Test Objective:
Verify that product stock levels are automatically reduced when an order is successfully placed.

Test Data:
Product: ZZ Plant
Initial Stock: 5
Ordered Quantity: 2
Expected Remaining Stock: 3

Test Steps:
1. Set ZZ Plant stock level to 5.
2. Add 2 ZZ Plants to the basket.
3. Proceed through checkout.
4. Complete the order successfully.
5. Verify the stock level in the database.

Expected Result:
Product stock is reduced by the quantity purchased.

Calculation:
5 - 2 = 3

Actual Result:
The stock level was reduced from 5 to 3 after successful checkout completion.

Result:
Pass

Evidence:
stock reduction1.png
stock reduction2.png
stock reduction3.png
stock reduction4.png

----------------------------------------
























## Item: Admin Features

### Test: Dashboard Loads

Expected:
Dashboard displays product and category totals.

Actual:
Dashboard displayed product and category totals successfully.

Result:
Pass

Evidence:
admin dashboard loads.png

----------------------------------------

### Test: Admin Products Page Loads

Expected:
All products and their categories are displayed.

Actual:
All products and categories displayed successfully.

Result:
Pass

Evidence:
admin products page loads.png

----------------------------------------

### Test: Admin Creates New Product

Test Data:

Name:
Moisture Meter

Description:
Simple gardening tool used to monitor soil moisture levels accurately.

Category:
Accessories

Expected:
Product is saved successfully and appears in the Admin Product Listing page.

Actual:
Product was saved successfully and displayed in the Admin Product Listing page.

Result:
Pass

Evidence:
create new product.png
admin products page.png

----------------------------------------

### Test: Admin Updates Existing Product

Expected:
Administrator can update product details.

Actual:
Product details updated successfully and displayed in the product listing.

Result:
Pass

Evidence:
update existing product1.png
update existing product2.png

----------------------------------------

### Test: Admin Deletes Existing Product

Test Objective:
Verify that an administrator can successfully delete a product from the Admin Product Listing page.

Test Steps:
1. Navigate to:
   /admin/products

2. Locate an existing product.

3. Click the "Delete Product" button.

4. Confirm the deletion when prompted.

Expected:
- Product is deleted from the database.
- Product no longer appears in the Admin Product Listing.
- User is redirected back to the Admin Products page.
- No errors are displayed.

Actual:
- Product was successfully deleted.
- Product no longer appeared in the Admin Products list.
- User was redirected back to the Admin Products page.
- No errors were displayed.

Result:
Pass

Evidence:
delete existing product1.png
delete existing product2.png
delete existing product3.png

----------------------------------------

### Test: Admin Creates New Category

Test Objective:
Verify that an administrator can successfully create a new category using the Category Management system.

Test Data:
Category Name: Garden Tools

Test Steps:
1. Navigate to:
   /admin/categories/create

2. Enter the category name:
   Garden Tools

3. Click the "Create Category" button.

Expected Result:
- The category is successfully saved to the database.
- The user is redirected to the Admin Categories page.
- The new category appears in the category list.

Actual Result:
- The category was successfully created.
- The user was redirected to the Admin Categories page.
- The new category "Garden Tools" appeared in the category list.

Result:
Pass

Evidence:
create category1.png
create category2.png

----------------------------------------

### Test: Admin Updates Existing Category

Test Data:
Garden Tools → Garden Equipment

Expected Result:
The category is updated successfully and the new name is displayed in the Admin Categories list.

Actual Result:
The category was updated successfully and displayed with the new name.

Result:
Pass

Evidence:
edit category name1.png
edit category name2.png

----------------------------------------

### Test: Admin Deletes Existing Category

Test Data:
Test Category

Expected Result:
Category is deleted successfully and removed from the category list.

Actual Result:
Category was deleted successfully and no longer appeared in the Admin Categories list.

Result:
Pass

Evidence:
delete category1.png
delete category2.png

----------------------------------------

### Test: Administrator Login

Test Data:
Email: admin@leafroot.test
Password: password123

Expected Result:
Administrator is successfully authenticated and redirected to the Admin Dashboard.

Actual Result:
Administrator logged in successfully and was redirected to the Admin Dashboard.

Result:
Pass

Evidence:
admin login1.png
admin login2.png

----------------------------------------

### Test: Unauthenticated User Access

Test Data:
Attempt to access:
/admin
/admin/products
/admin/categories

Expected Result:
User is redirected to the login page.

Actual Result:
User was redirected to the login page.

Result:
Pass

Evidence:
route protection1.png
route protection2.png
route protection3.png

----------------------------------------

### Test: Administrator Logout

Expected Result:
User session is terminated and protected routes require re-authentication.

Actual Result:
User was logged out successfully and protected routes redirected to the login page.

Result:
Pass

Evidence:
admin logout1.png
admin logout2.png

----------------------------------------

### Test: Empty Email

Expected Result:
Validation error displayed.

Actual Result:
Validation error displayed and login prevented.

Result:
Pass

Evidence:
email address required1.png
email address required2.png

----------------------------------------

### Test: Invalid Email Format

Expected Result:
Validation error displayed.

Actual Result:
Validation error displayed and login prevented.

Result:
Pass

Evidence:
invalid email format1.png
invalid email format2.png

----------------------------------------

### Test: Empty Password

Expected Result:
Validation error displayed.

Actual Result:
Validation error displayed and login prevented.

Result:
Pass

Evidence:
empty password1.png
empty password2.png

----------------------------------------

### Test: Invalid Credentials

Expected Result:
Authentication fails and error message is displayed.

Actual Result:
Invalid credentials message displayed.

Result:
Pass

Evidence:
empty password1.png
empty password2.png

----------------------------------------

### Test: Invalid Credentials

Expected Result:
Authentication fails and error message is displayed.

Actual Result:
Invalid credentials message displayed.

Result:
Pass

Evidence:
wrong password1.png
wrong password2.png

----------------------------------------

### Test: Admin Dashboard Navigation

Expected Result:
Administrator can navigate between dashboard, products and categories.

Actual Result:
Navigation links functioned correctly.

Result:
Pass

Evidence:
admin navigation1.png
admin navigation2.png
admin navigation3.png

----------------------------------------

### Test: Admin Logout From Admin Area

Expected Result:
Administrator is logged out and redirected to the login page.

Actual Result:
Logout completed successfully and access to protected routes required re-authentication.

Result:
Pass

Evidence:
admin area logout1.png
admin area logout2.png
admin area logout3.png  

----------------------------------------

### Flash Message For Product Created

Test Objective:
Verify that a success flash message is displayed when a product is created.

Test Data:
Product Name: Test Product

Description: Test Product Description

Category: Indoor Plants

Expected Result:
The product is created successfully and the following message is displayed:

Product created successfully.

Actual Result:
The product was created successfully and the success message was displayed.

Result:
Pass

Evidence:
product flash create1.png
product flash create2.png

----------------------------------------

### Test: Flash Message for Product Updated

Test Objective:
Verify that a success flash message is displayed when a product is updated.

Test Data:
Original Product Name: Test Product

Updated Product Name: Updated Test Product

Expected Result:
The product is updated successfully and the following message is displayed:

Product updated successfully.

Actual Result:
The product was updated successfully and the success message was displayed.

Result:
Pass

Evidence:
product flash update1.png
product flash update2.png

----------------------------------------

### Test: Flash Message for Product Deleted

Test Objective:
Verify that a success flash message is displayed when a product is deleted.

Test Data:
Product Name: Updated Test Product

Expected Result:
The product is deleted successfully and the following message is displayed:

Product deleted successfully.

Actual Result:
The product was deleted successfully and the success message was displayed.

Result:
Pass

Evidence:
product flash delete1.png
product flash delete2.png

----------------------------------------

### Test: Flash Message For Category Created

Test Objective:
Verify that a success flash message is displayed when a category is created.

Test Data:
Category Name: Test Category

Expected Result:
The category is created successfully and the following message is displayed:

Category created successfully.

Actual Result:
The category was created successfully and the success message was displayed.

Result:
Pass

Evidence:
category flash create1.png
category flash create2.png

----------------------------------------

### Test: Flash Messgae For Category Updated

Test Objective:
Verify that a success flash message is displayed when a category is updated.

Test Data:
Original Category Name: Test Category

Updated Category Name: Updated Test Category

Expected Result:
The category is updated successfully and the following message is displayed:

Category updated successfully.

Actual Result:
The category was updated successfully and the success message was displayed.

Result:
Pass

Evidence:
category flash update1.png
category flash update2.png

----------------------------------------

### Test: Flash Message For Category Deleted

Test Objective:
Verify that a success flash message is displayed when a category is deleted.

Test Data:
Category Name: Updated Test Category

Expected Result:
The category is deleted successfully and the following message is displayed:

Category deleted successfully.

Actual Result:
The category was deleted successfully and the success message was displayed.

Result:
Pass

Evidence:
category flash delete1.png
category flash delete2.png

----------------------------------------

### Test: Product Price Display in Admin Product Management

Test Objective:
Verify that administrators can view product prices in the Manage Products page.

Test Steps:
1. Log in as an administrator.
2. Navigate to /admin/products.

Expected Result:
Each product displays its assigned price.

Actual Result:
All products displayed the correct price alongside product names and categories.

Result:
Pass

Evidence:
admin product pricing1.png

----------------------------------------

## Item: Admin Order Management
### Test: Admin Orders Page Loads

Expected:
The Orders Management page loads and displays all customer orders.

Actual:
The Orders Management page loaded successfully and displayed all existing customer orders.

Result:
Pass

Evidence:
admin orders list1.png

----------------------------------------

### Test: Order Listing Displays Correct Information

Test Objective:
Verify that the Orders Management page displays the correct order information.

Expected Result:
Each order displays:

Order ID
Customer Name
Email Address
Order Total
Order Status
Date Created
View Button

Actual Result:
All order information was displayed correctly for each order.

Result:
Pass

Evidence:
admin orders list1.png

----------------------------------------

### Test: View Order Details

Test Objective:
Verify that administrators can view detailed order information.

Test Steps:
1. Navigate to /admin/orders.
2. Select an existing order.
3. Click the "View" button.

Expected Result:
The Order Details page is displayed showing:

Customer Details
Delivery Address
Order Items
Quantities
Total Cost
Order Status

Actual Result:
The Order Details page loaded successfully and displayed all customer and order information correctly.

Result:
Pass

Evidence:
admin order details1.png

----------------------------------------

### Test: Order Item Display

Test Objective:
Verify that ordered products are displayed correctly on the Order Details page.

Expected Result:
Each order item displays:

Product Name
Quantity
Unit Price
Subtotal

Actual Result:
All ordered products were displayed correctly with their quantities, prices and subtotals.

Result:
Pass

Evidence:
admin order details1.png

----------------------------------------

### Test: Order Total Display

Test Objective:
Verify that the order total is displayed correctly.

Expected Result:
The Grand Total displayed matches the total stored for the order.

Actual Result:
The displayed Grand Total matched the order total stored in the database.

Result:
Pass

Evidence:
admin order details1.png

----------------------------------------

### Test: Update Order Status

Test Objective:
Verify that administrators can update order statuses.

Test Data:
Original Status:
Pending

Updated Status:
Processing

Test Steps:
1. Open an existing order.
2. Select a new status from the dropdown.
3. Click "Update Status".

Expected Result:
Order status is updated successfully.
Success flash message displayed.
Updated status appears on the page.

Actual Result:
The order status updated successfully and the success message was displayed.

Result:
Pass

Evidence:
admin update status1.png
admin update status2.png

----------------------------------------

### Test: Status Badge Display

Test Objective:
Verify that status badges display correctly for different order statuses.

Expected Result:
Order statuses display with their appropriate visual badge style.

Examples:

Pending
Processing
Dispatched
Completed
Cancelled

Actual Result:
Status badges displayed correctly for all tested order statuses.

Result:
Pass

Evidence:
admin update status2.png

----------------------------------------

### Test: Search Orders By Customer Name

Test Data:
Jordan

Expected Result:
Only orders matching the customer name are displayed.

Actual Result:
Matching orders were displayed successfully.

Result:
Pass

Evidence:
admin order search name1.png

----------------------------------------

### Test: Search Orders By Email Address

Test Data:
admin@leafroot.test

Expected Result:
Only orders matching the email address are displayed.

Actual Result:
Matching orders were displayed correctly.

Result:
Pass

Evidence:
admin order search email1.png

----------------------------------------

### Test: Search Orders By Order ID

Test Data:
1

Expected Result:
The corresponding order is displayed.

Actual Result:
The correct order was returned by the search.

Result:
Pass

Evidence:
admin order search id1.png

----------------------------------------

### Test: Search With Invalid Search Term

Test Data:
xyz123

Expected Result:
No matching orders message displayed.

Actual Result:
"No orders found matching your criteria." was displayed.

Result:
Pass

Evidence:
admin order search invalid1.png

----------------------------------------

### Test: Clear Order Search

Expected Result:
The search filter is removed and all orders are displayed.

Actual Result:
The search filter was cleared and all orders were displayed successfully.

Result:
Pass

Evidence:
admin order search clear1.png

----------------------------------------

### Test: Admin Orders Route Protection

Test Objective:
Verify that unauthenticated users cannot access the Orders Management system.

Test Steps:
1. Log out.
2. Attempt to access:
   /admin/orders
   and
   /admin/orders/1


Expected Result:
User is redirected to the login page.

Actual Result:
Unauthenticated users were redirected to the login page successfully.

Result:
Pass

Evidence:
admin orders route protection1.png
admin orders route protection2.png

----------------------------------------

## Item: User Registration And Login
### Test: Registration Page Loads

Test Objective:
Verify that the customer registration page loads correctly and displays all required registration fields.

Test Steps:
1. Navigate to /register.
2. Observe the page contents.

Expected Result:
The registration page loads successfully and displays Name, Email Address, Password, Password Confirmation and Register button.

Actual Result:
The registration page loaded successfully and displayed all required registration fields.

Result:
Pass

Evidence:
registration page loads1.png

----------------------------------------

### Test: Successful Customer Registration

Test Objective:
Verify that a new customer account can be created successfully.

Test Data:
Name: Test User
Email: tester@example.com
Password: Password123
Confirm Password: Password123

Test Steps:
1. Navigate to /register.
2. Enter valid customer information.
3. Click Register.

Expected Result:
A customer account is created and the customer is automatically logged in.

Actual Result:
The customer account was created successfully and the customer was logged in automatically.

Result:
Pass

Evidence:
registration success1.png
registration success2.png

----------------------------------------

### Test: Duplicate Email Validation

Test Objective:
Verify that duplicate email addresses cannot be used to register multiple accounts.

Test Data:
Email: test@example.com

Test Steps:
1. Navigate to /register.
2. Enter an email address that already exists.
3. Complete the remaining fields.
4. Submit the registration form.

Expected Result:
Registration is prevented and a validation error is displayed.

Actual Result:
Registration was prevented and the validation error was displayed successfully.

Result:
Pass

Evidence:
duplicate email1.png
duplicate email2.png

----------------------------------------

### Test: Password Confirmation Validation

Test Objective:
Verify that registration requires matching passwords.

Test Data:
Password: Password123
Confirm Password: Password456

Test Steps:
1. Navigate to /register.
2. Complete the registration form.
3. Enter different values for Password and Confirm Password.
4. Submit the form.

Expected Result:
Registration fails and a validation error is displayed.

Actual Result:
Registration failed and the validation error was displayed successfully.

Result:
Pass

Evidence:
password confirmation validation1.png
password confirmation validation2.png

----------------------------------------

### Test: Customer Role Assignment

Test Objective:
Verify that all newly registered users are automatically assigned the customer role.

Test Steps:
1. Register a new customer account.
2. Open Laravel Tinker.
3. Retrieve the newly created user record.

Expected Result:
The user record contains:
role = customer

Actual Result:
The newly created account was assigned the customer role successfully.

Result:
Pass

Evidence:
registration success2.png
customer role assignment1.png

----------------------------------------

### Test: Password Hashing

Test Objective:
Verify that customer passwords are stored securely as hashes.

Test Steps:
1. Register a new customer account.
2. Open Laravel Tinker.
3. Retrieve the user's password value from the database.

Expected Result:
The password is stored as a bcrypt hash and not plain text.

Actual Result:
The password was stored securely as a bcrypt hash.

Result:
Pass

Evidence:
password hashing1.png

----------------------------------------

### Item: Customer Authentication

Test: Customer Login

Test Objective:
Verify that registered customers can authenticate successfully.

Test Data:
Email: tester@example.com
Password: Password123

Test Steps:
1. Navigate to /login.
2. Enter valid customer credentials.
3. Click Login.

Expected Result:
Customer is authenticated successfully and redirected to the Product Catalogue.

Actual Result:
Customer login completed successfully and the customer was redirected to the Product Catalogue.

Result:
Pass

Evidence:
customer login1.png
customer login2.png

----------------------------------------

### Test: Customer Logout

Test Objective:
Verify that customers can log out successfully.

Test Steps:
1. Log in as a customer.
2. Click Logout.
3. Attempt to access customer-only functionality.

Expected Result:
The customer session is terminated and guest navigation options become visible.

Actual Result:
The customer session terminated successfully and guest navigation options were displayed.

Result:
Pass

Evidence:
customer logout1.png
customer logout2.png

----------------------------------------

## Item: Role-Based Authentication
### Test: Customer Redirect After Login

Test Objective:
Verify that customers are redirected to the Product Catalogue after successful login.

Test Data:
Email: test@example.com
Role: customer

Test Steps:
1. Navigate to /login.
2. Enter customer credentials.
3. Click Login.

Expected Result:
Customer is redirected to /products.

Actual Result:
Customer was redirected successfully to the Product Catalogue page.

Result:
Pass

Evidence:
customer login1.png
customer login2.png

----------------------------------------

### Test: Administrator Redirect After Login

Test Objective:
Verify that administrators are redirected to the Admin Dashboard after successful login.

Test Data:
Email: admin@leafroot.test
Role: admin

Test Steps:
1. Navigate to /login.
2. Enter administrator credentials.
3. Click Login.

Expected Result:
Administrator is redirected to /admin.

Actual Result:
Administrator was redirected successfully to the Admin Dashboard.

Result:
Pass

Evidence:
admin redirect1.png
admin redirect2.png
----------------------------------------

## Item: Admin Route Protection
### Test: Customer Access To Admin Dashboard

Test Objective:
Verify that customers cannot access administrator-only pages.

Test Data:
Customer Account:
test@example.com

Test Steps:
1. Log in as a customer.
2. Attempt to visit /admin.

Expected Result:
Customer is denied access and redirected to the Product Catalogue.

Actual Result:
Customer was denied access and redirected successfully.

Result:
Pass

Evidence:
customer admin denial1.png
customer admin denial2.png

----------------------------------------

### Test: Customer Access To Product Management

Test Objective:
Verify that customers cannot access product management functionality.

Test Steps:
1. Log in as a customer.
2. Attempt to visit /admin/products.

Expected Result:
Customer access is denied.

Actual Result:
Customer access was denied successfully.

Result:
Pass

Evidence:
customer admin denial1.png
customer products management blocked1.png

----------------------------------------

### Test: Customer Access To Category Management

Test Objective:
Verify that customers cannot access category management functionality.

Test Steps:
1. Log in as a customer.
2. Attempt to visit /admin/categories.

Expected Result:
Customer access is denied.

Actual Result:
Customer access was denied successfully.

Result:
Pass

Evidence:
customer admin denial1.png
customer category management blocked1.png

----------------------------------------

### Test: Customer Access To Order Management

Test Objective:
Verify that customers cannot access order management functionality.

Test Steps:
1. Log in as a customer.
2. Attempt to visit /admin/orders.

Expected Result:
Customer access is denied.

Actual Result:
Customer access was denied successfully.

Result:
Pass

Evidence:
customer admin denial1.png
customer order management blocked1.png

----------------------------------------

### Test: Administrator Access To Protected Admin Routes

Test Objective:
Verify that administrators retain access to all protected administrator functionality.

Test Data:
Email: admin@leafroot.test
Role: admin

Test Steps:
1. Log in as an administrator.
2. Navigate to /admin.
3. Navigate to /admin/products.
4. Navigate to /admin/categories.
5. Navigate to /admin/orders.

Expected Result:
Administrator can access all protected administrator functionality.

Actual Result:
Administrator successfully accessed all protected administrator functionality.

Result:
Pass

Evidence:
admin protected routes1.png
admin protected routes2.png
admin protected routes3.png
admin protected routes4.png

----------------------------------------

### Test: Unauthorized Access Warning Message

Test Objective:
Verify that an appropriate warning is displayed when a customer attempts to access an admin-only area.

Test Steps:
1. Log in as a customer.
2. Navigate to /admin.
3. Observe the response.

Expected Result:
The message:
'Unauthorized access. Admin privileges required.'
is displayed.

Actual Result:
The unauthorized access warning was displayed successfully.

Result:
Pass

Evidence:
customer admin denial1.png
customer admin denial2.png