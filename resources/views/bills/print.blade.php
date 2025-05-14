<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill #{{ $bill->bill_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .bill-details {
            margin-bottom: 30px;
        }
        .bill-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .customer-info, .bill-info-right {
            width: 45%;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f5f5f5;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-row {
            font-weight: bold;
            font-size: 18px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .payment-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Water Supply Company</div>
        <div>123 Water Street, City, Country</div>
        <div>Phone: (123) 456-7890 | Email: info@watersupply.com</div>
    </div>

    <div class="bill-details">
        <div class="bill-info">
            <div class="customer-info">
                <h3>Bill To:</h3>
                <p>
                    <strong>{{ $bill->customer->name }}</strong><br>
                    {{ $bill->customer->address }}<br>
                    Phone: {{ $bill->customer->phone }}<br>
                    Email: {{ $bill->customer->email }}
                </p>
            </div>
            <div class="bill-info-right">
                <h3>Bill Information:</h3>
                <p>
                    <strong>Bill Number:</strong> {{ $bill->bill_number }}<br>
                    <strong>Date:</strong> {{ $bill->created_at->format('Y-m-d') }}<br>
                    <strong>Payment Status:</strong> {{ ucfirst($bill->payment_status) }}<br>
                    <strong>Payment Method:</strong> {{ ucfirst($bill->payment_method) }}
                </p>
            </div>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Water Bottles Delivered</td>
                <td>{{ $bill->bottles_delivered }}</td>
                <td>AED {{ number_format($bill->amount / $bill->bottles_delivered, 2) }}</td>
                <td>AED {{ number_format($bill->amount, 2) }}</td>
            </tr>
            @if($bill->empty_bottles_collected > 0)
            <tr>
                <td>Empty Bottles Collected</td>
                <td>{{ $bill->empty_bottles_collected }}</td>
                <td>AED 0.00</td>
                <td>AED 0.00</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            Total Amount: AED {{ number_format($bill->amount, 2) }}
        </div>
    </div>

    <div class="payment-info">
        <h3>Payment Information:</h3>
        <p>
            <strong>Payment Method:</strong> {{ ucfirst($bill->payment_method) }}<br>
            <strong>Payment Status:</strong> {{ ucfirst($bill->payment_status) }}<br>
            @if($bill->payment_status === 'pending')
                <strong>Due Date:</strong> {{ $bill->created_at->addDays(30)->format('Y-m-d') }}
            @endif
        </p>
    </div>

    @if($bill->notes)
    <div class="notes">
        <h3>Notes:</h3>
        <p>{{ $bill->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html> 