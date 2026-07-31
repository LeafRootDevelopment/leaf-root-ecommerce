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

## Admin Features

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

