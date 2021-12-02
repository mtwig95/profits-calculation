<?PHP
// Getting data from the file
$json_a = json_decode(file_get_contents("data.json"), true);
$data = json_decode($json_a)->{'data'};

$conn = new mysqli('localhost:3306', 'maytal', 'test1234', 'test');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "create table orders
(
    order_ID                  bigint      null,
    shop_ID                   bigint      null,
    closed_at                 timestamp   null,
    created_at                timestamp   null,
    updated_at                timestamp   null,
    total_price               double      null,
    subtotal_price            double      null,
    total_weight              double      null,
    total_tax                 float       null,
    currency                  varchar(4)  null,
    financial_status          varchar(30) null,
    total_discounts           double      null,
    name                      varchar(30) null,
    processed_at              timestamp   null,
    fulfillment_status        varchar(20) null,
    country                   varchar(2)  null,
    province                  varchar(3)  null,
    total_production_cost     int         null,
    total_items               int         null,
    total_order_shipping_cost int         null,
    total_order_handling_cost int         null
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
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
    var_dump("\nnet_sales: $net_sales\n");
    print("production_costs: $production_costs\n");
    print("Gross profit: $gross_profit\n");
    print("Gross margin: $gross_margin%\n");
}

$conn->close();
?>