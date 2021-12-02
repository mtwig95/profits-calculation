
<?PHP
// Getting data from the file
$json_a = json_decode(file_get_contents("data.json"), true);
$data = json_decode($json_a)->{'data'};

$conn = new mysqli('localhost:3306', 'maytal', 'test1234', 'beprofit');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($data as $o) {
    $sql = "INSERT INTO orders (order_ID,shop_ID,closed_at,created_at,updated_at,total_price,subtotal_price,total_weight,total_tax,currency,financial_status,total_discounts,name,processed_at,fulfillment_status,country,province,total_production_cost,total_items,total_order_shipping_cost,total_order_handling_cost)
VALUES ($o->order_ID,$o->shop_ID,'$o->closed_at','$o->created_at','$o->updated_at',$o->total_price,$o->subtotal_price,$o->total_weight,$o->total_tax,'$o->currency','$o->financial_status',$o->total_discounts,'$o->name','$o->processed_at','$o->fulfillment_status','$o->country','$o->province',$o->total_production_cost,$o->total_items,$o->total_order_shipping_cost,$o->total_order_handling_cost)";

    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$net_sales_query = "SELECT SUM(total_price) FROM orders WHERE financial_status LIKE '%paid%'    OR financial_status LIKE '%partially_paid%'";
$production_costs_sales_query = "SELECT SUM(total_production_cost) FROM orders WHERE fulfillment_status = 'fulfilled' and financial_status LIKE '%paid%'";
$net_res = $conn->query($net_sales_query)->fetch_assoc();
$production_res = $conn->query($production_costs_sales_query)->fetch_assoc();

if (isset($net_res) || isset($production_res)) {
    $net_sales = $net_res['SUM(total_price)'];
    $production_costs = $production_res['SUM(total_production_cost)'];
    $gross_profit = $net_sales - $production_costs;
    $gross_margin = $gross_profit / $net_sales * 100;
    echo nl2br("Net Sales: $net_sales\n");
    echo nl2br("Production costs: $production_costs\n");
    echo nl2br ("Gross profit: $gross_profit\n");
    echo nl2br ("Gross margin: $gross_margin%\n");
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<h1 class="center grey-text">Home Task - Beprofit</h1>
<h3 class="center grey-text">Net Sales - sum of total_price fields of orders where financial_status is one of the following: 'paid', 'partially_paid'</h3>
<h3 class="center grey-text">Production costs - sum of total_production_cost fields of orders where financial_status is one of the following: 'paid', 'partially_paid' and fulfillment_status is 'fulfilled'</h3>
<h3 class="center grey-text">Gross profit - Net Sales with Production substructed</h3>
<h3 class="center grey-text">Gross margin - what percent out of Net Sales does Gross Profit make</h3>
</html>
