# profits-calculation

Fetching data from endpoint and calculate profits.

## Description

The project store data into a table inside a MYSQL database and implement methods that calculate from the database the following:
 * Net Sales - sum of total_price fields of orders where financial_status is one of the following: 'paid', 'partially_paid'
 * Production costs - sum of total_production_cost fields of orders where financial_status is one of the following: 'paid', 'partially_paid' and fulfillment_status is 'fulfilled'
 * Gross profit - Net Sales with Production substructed
 * Gross margin - what percent out of Net Sales does Gross Profit make

## Getting Started

### Installing

 * Download the project to C:\xampp\htdocs (make sure the index.php in the main folder).
 * Start XAMPP control panel
 * Start Apach and MySQL
 * In MySql admin button (http://localhost:8080/phpmyadmin/) 
 * select import tab
 * locate orders.sql file and press butttom to import

### Executing program

project can be fond in http://localhost:8080/profits-calculation/

## Help

make sure in XAMPP control panel run port 8080
