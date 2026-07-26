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

---

### Test: Display All Categories

Expected:
Selecting "All Categories" displays all available products.

Actual:
All products were displayed successfully.

Result:
Pass

Evidence:
display all categories.png
---

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

---

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

---

### Test: No Matching Products After Filtering

Expected:
When no products match the selected criteria, an appropriate message is displayed.

Actual:
The message "No products found matching your search or filter criteria." was displayed.

Result:
Pass

Evidence:
no products match search or filter.png

