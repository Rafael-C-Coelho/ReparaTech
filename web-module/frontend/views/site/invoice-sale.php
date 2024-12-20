<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .invoice-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .invoice-body {
            padding: 20px;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .invoice-info div {
            flex: 1;
        }

        .invoice-info div:first-child {
            margin-right: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th, .invoice-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #f4f4f4;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }

        .invoice-footer {
            text-align: center;
            background: #f4f4f4;
            padding: 10px;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .invoice-info {
                flex-direction: column;
            }

            .invoice-info div {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <div class="invoice-header">
        <h1>Invoice</h1>
    </div>

    <div class="invoice-body">
        <div class="invoice-info">
            <div>
                <strong>From:</strong>
                <p>Repara Tech</p>
            </div>
            <div>
                <strong>To:</strong>
                <p><?= $model->client->username ?></p>
            </div>
        </div>

        <div class="invoice-info">
            <div>
                <strong>Invoice Number:</strong> #<?= $invoice->id ?><br>
                <strong>Date:</strong> <?= Yii::$app->formatter->asDate($invoice->date, "long") ?>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
            <tr>
                <th>Product name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item["name"] ?></td>
                    <td><?= $item["quantity"] ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($item["price"],"EUR") ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            Total: <?= Yii::$app->formatter->asCurrency($invoice->total, "EUR") ?>
        </div>
    </div>
</div>

</body>
</html>

