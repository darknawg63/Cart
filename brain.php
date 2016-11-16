<?php

require __dir__ . '/vendor/braintree/braintree_php/lib/Braintree.php';

Braintree\Configuration::environment('sandbox');
Braintree\Configuration::merchantId('pjdgv9wdvqrr7jk9');
Braintree\Configuration::publicKey('d4dm259p2x7kqk5z');
Braintree\Configuration::privateKey('b46cc700badecb7c02be578ecade3');


$result = Braintree_Transaction::sale([
    'amount' => '1000.00',
    'paymentMethodNonce' => 'nonceFromTheClient',
    'options' => [ 'submitForSettlement' => true ]
]);

if ($result->success) {
    print_r("success!: " . $result->transaction->id);
} else if ($result->transaction) {
    print_r("Error processing transaction:");
    print_r("\n  code: " . $result->transaction->processorResponseCode);
    print_r("\n  text: " . $result->transaction->processorResponseText);
} else {
    print_r("Validation errors: \n");
    print_r($result->errors->deepAll());
}