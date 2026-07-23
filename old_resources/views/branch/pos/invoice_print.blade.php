<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $sale->invoice_no ?? '0000' }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .border-top {
            border-top: 1px dashed #000;
            margin-top: 10px;
            padding-top: 10px;
        }

        .border-bottom {
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            text-align: left;
            padding: 4px 0;
        }

        .no-print {
            text-align: center;
            margin-top: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                width: 100%;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="text-center border-bottom">
        <h2 style="margin: 0;">{{ auth()->user()->company->name ?? 'Your Company Name' }}</h2>
        <p style="margin: 5px 0;">{{ auth()->user()->branch->name ?? 'Main Branch' }}</p>
        <p style="margin: 5px 0;">Phone: 017XXXXXXXX</p>
    </div>

    <div class="border-bottom">
        <p><strong>Invoice:</strong> {{ $sale->invoice_no ?? 'INV-' . time() }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($sale->created_at ?? now())->format('d-M-Y h:i A') }}</p>
        <p><strong>Cashier:</strong> {{ auth()->user()->name ?? 'Admin' }}</p>
    </div>

    <table>
        <thead>
            <tr class="border-bottom">
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            {{-- Assuming $sale->items is available. Adjust relation name if needed --}}
            @forelse($sale->items ?? [] as $item)
                @php
                    $lineTotal = ($item->quantity ?? 1) * ($item->unit_price ?? 0);
                    $total += $lineTotal;
                @endphp
                <tr>
                    <td>{{ $item->product_name ?? 'Product' }}</td>
                    <td class="text-right">{{ $item->quantity ?? 1 }}</td>
                    <td class="text-right">{{ number_format($item->unit_price ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($lineTotal, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No items</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="border-top">
        <div class="d-flex" style="display: flex; justify-content: space-between;">
            <span class="bold">Subtotal:</span>
            <span>৳{{ number_format($total, 2) }}</span>
        </div>
        <div class="d-flex" style="display: flex; justify-content: space-between;">
            <span class="bold">Discount:</span>
            <span>৳{{ number_format($sale->discount ?? 0, 2) }}</span>
        </div>
        <div class="d-flex" style="display: flex; justify-content: space-between; font-size: 16px; margin-top: 5px;">
            <span class="bold">TOTAL:</span>
            <span class="bold">৳{{ number_format($sale->total_amount ?? $total, 2) }}</span>
        </div>
        <div class="d-flex" style="display: flex; justify-content: space-between; margin-top: 5px;">
            <span>Paid ({{ ucfirst($sale->payment_method ?? 'cash') }}):</span>
            <span>৳{{ number_format($sale->received_amount ?? $total, 2) }}</span>
        </div>
        <div class="d-flex" style="display: flex; justify-content: space-between;">
            <span class="bold">Change:</span>
            <span
                class="bold">৳{{ number_format(($sale->received_amount ?? $total) - ($sale->total_amount ?? $total), 2) }}</span>
        </div>
    </div>

    <div class="text-center" style="margin-top: 20px;">
        <p>*** Thank You for Your Purchase! ***</p>
        <p>Goods once sold will not be taken back.</p>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary"
            style="padding: 10px 20px; font-size: 16px; cursor: pointer;">🖨️ Print Again</button>
        <a href="{{ route('branch.pos.index') }}" style="display: block; margin-top: 10px; color: blue;">← Back to
            POS</a>
    </div>
</body>

</html>
