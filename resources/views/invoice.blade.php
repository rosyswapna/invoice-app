<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
    </style>
</head>
<body>
    <h1>Invoice #{{ $invoice->invoice_number }}</h1>
    <p><strong>Customer:</strong> {{ $invoice->customer_name }}</p>
    <p><strong>Date:</strong> {{ $invoice->invoice_date->format('Y-m-d') }}</p>

    <table>
        <tr><th>Subtotal</th><td>{{ number_format($invoice->subtotal, 2) }}</td></tr>
        <tr><th>Tax</th><td>{{ number_format($invoice->tax, 2) }}</td></tr>
        <tr><th>Discount</th><td>{{ number_format($invoice->discount, 2) }}</td></tr>
        <tr><th>Total</th><td>{{ number_format($invoice->total, 2) }}</td></tr>
        <tr><th>Status</th><td>{{ $invoice->status }}</td></tr>
    </table>
</body>
</html>
