CREATE DATABASE beprofit;

CREATE TABLE orders
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
);