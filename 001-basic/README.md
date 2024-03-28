# PHP Basic

To go through all basic concepts in PHP, we'll start learning by making something.
We'll make all of the below applications.

## References

- https://www.php.net/manual/en/index.php

## Exchange Rate

- Create a application to convert foreign currency to Vietnam Dong
- Datasource about exchange rate will be fetch every five minutes at https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx
- This application can be look like this

![image](https://gist.github.com/assets/31009750/ec4f2b52-97eb-48af-b7d5-b43a6eb0a501)

**Todo**

- Create data structure
- Download and save xml file
- Extract data from xml file
- Create Web Page
- Write JS to interact with user

**Data Structure**

```json
{
  "CurrencyCode": "AUD", // Mã ngoại tệ
  "CurrencyName": "AUSTRALIAN DOLLAR", // Tên ngoại tệ
  "Buy": "15,660.26", // buy with cash - Mua tiền mặt
  "Transfer": "15,818.45", // buy by transfering - Mua chuyển khoản
  "Sell": "16,326.56" // sell - Bán
}
```

```php
$exchangeRates = [
    [
        "CurrencyCode" => "AUD", "CurrencyName" => "AUSTRALIAN DOLLAR", "Buy" => "15,660.26",
        "Transfer" => "15,660.26",
        "Sell" => "16,326.56"
    ]
]
```

<Exrate CurrencyCode="AUD" CurrencyName="AUSTRALIAN DOLLAR " Buy="15,660.26" Transfer="15,818.45" Sell="16,326.56"/>
