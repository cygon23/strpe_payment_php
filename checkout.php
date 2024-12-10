 <?php

require __DIR__ . "/vendor/autoload.php";

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// $stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'];
$stripe_secret_key = "sk_test_51QCbWNKGU0hfcppgfzGyvTi72KaE7GPndV03lFcjeyZsoel0twHjtA5Ja0nu84IZw1Y9TWaabRPymbfzyHZlmkx100i0eZcD81";

\Stripe\Stripe::setApiKey($stripe_secret_key);

//accepting varibles from the form

$name = $_POST['name'];
$email = $_POST['email'];
$amount = $_POST['amount'];

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://localhost/success.php",
        "cancel_url" => "http://localhost/index.php",
        "locale" => "auto",
        "line_items" => [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "usd",
                    "unit_amount" => $amount,
                    "product_data" => [
                        "name" => "Donation",
                        "description" => "Donation from $name ($email)",
                    ]
                ]
            ]      
        ]
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error occurred: " . $e->getMessage();
    exit;
}

http_response_code(303);
header("Location: " . $checkout_session->url); 