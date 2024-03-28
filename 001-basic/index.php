<?php
const EXCHANGE_RATE_SOURCE = 'https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx';
const EXCHANGE_RATE_FILE = './tmp/exchange_rate_source.xml';
$exchangeRates = [
    [
        "CurrencyCode" => "AUD", "CurrencyName" => "AUSTRALIAN DOLLAR", "Buy" => "15,660.26",
        "Transfer" => "15,660.26",
        "Sell" => "16,326.56"
    ]
];
function convertCurrencyStringToNumber(string $s): float
{
    return round(floatval(str_replace(',', '', $s)), 2);
}

function formatNumberIntoString(float $number): string
{
    return number_format($number, 0, '.', ',');
}

foreach ($exchangeRates as $exchangeRate) {
    foreach ($exchangeRate as $key => $value) {
        print("{$key}: {$value}\n");
    }

    $currencyCode = $exchangeRate['CurrencyCode'];
    $currencyName = $exchangeRate['CurrencyName'];
    $transfer = convertCurrencyStringToNumber($exchangeRate['Transfer']);
    $buy = convertCurrencyStringToNumber($exchangeRate['Buy']);
    $sell = convertCurrencyStringToNumber($exchangeRate['Sell']);
    $totalAmount = 12;
    print("{$currencyName} ( {$currencyCode} )\n");
    printf("You can sell {$totalAmount} {$currencyCode} with %s VND by transfering\n", formatNumberIntoString($transfer * $totalAmount));
    printf("You can sell {$totalAmount} {$currencyCode} with %s VND by cash\n", formatNumberIntoString($buy * $totalAmount));
    printf("You can buy {$totalAmount} {$currencyCode} with %s VND\n", formatNumberIntoString($sell * $totalAmount));
}

function xmlFileToArray($filePath)
{
    $array = [];

    // Check if the file exists
    if (!file_exists($filePath)) {
        return null; // Return null if the file does not exist
    }

    // Create a new XMLReader instance
    $reader = new XMLReader();
    $reader->open($filePath);

    // Iterate through the XML content
    while ($reader->read()) {
        // Check for start elements
        if ($reader->nodeType == XMLReader::ELEMENT) {
            $nodeName = $reader->name;
            // If the node is an <Exrate> element
            if ($nodeName == 'Exrate') {
                $exrate = [];
                // Extract attributes
                while ($reader->moveToNextAttribute()) {
                    $exrate[$reader->name] = $reader->value;
                }
                $array['Exrate'][] = $exrate;
            }
            // If the node is a <DateTime> or <Source> element
            elseif ($nodeName == 'DateTime' || $nodeName == 'Source') {
                $reader->read(); // Move to the text node
                $array[$nodeName] = $reader->value;
            }
        }
    }

    // Close the XMLReader
    $reader->close();

    return $array;
}

function downloadFile(string $url): bool
{
    try {
        $data = file_get_contents($url);
        file_put_contents(EXCHANGE_RATE_FILE, $data);
    } catch (\Throwable $error) {
        //throw $th;
        print_r($error);
        return false;
    }

    return true;
}

// read xml
if (!file_exists('./tmp')) {
    mkdir('./tmp', 0664);
}
// fetch and save file
downloadFile(EXCHANGE_RATE_SOURCE);
$exchangeRateFilePath = EXCHANGE_RATE_FILE;
$data = xmlFileToArray($exchangeRateFilePath);
print_r($data);
