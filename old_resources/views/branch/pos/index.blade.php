@extends('layouts.admin_master')
@section('title', 'POS Terminal')
@section('content')
    <div class="row">
        <!-- Left Side: Product Search & Cart -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="ti ti-shopping-cart me-2"></i>POS Cart</h5>
                    <div class="input-group" style="max-width: 350px;">
                        <span class="input-group-text"><i class="ti ti-barcode"></i></span>
                        <input type="text" id="productSearch" class="form-control"
                            placeholder="Scan Barcode or Search Name..." autocomplete="off">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">
                        <table class="table table-hover mb-0" id="posCartTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="120">Qty</th>
                                    <th width="120">Total</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                                <tr id="emptyCartMsg">
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="ti ti-package-off" style="font-size: 2rem;"></i><br>
                                        Cart is empty. Scan or search a product to add.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Checkout Panel -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="ti ti-receipt me-2"></i>Checkout</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('branch.pos.checkout') }}" method="POST" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="cart_data" id="cartDataInput">

                        <div class="mb-3">
                            <label class="form-label">Customer (Optional)</label>
                            <select name="customer_id" class="form-select">
                                <option value="">Walk-in Customer</option>
                                @foreach ($customers ?? [] as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="mobile_banking">Mobile Banking</option>
                            </select>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="fw-bold">৳<span id="displaySubtotal">0.00</span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fs-5 fw-bold text-primary">
                            <span>Total Payable:</span>
                            <span>৳<span id="displayTotal">0.00</span></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Received Amount <span class="text-danger">*</span></label>
                            <input type="number" name="received_amount" id="receivedAmount"
                                class="form-control form-control-lg text-end fw-bold" step="0.01" min="0"
                                required>
                        </div>

                        <div class="d-flex justify-content-between mb-4 fs-6 fw-bold text-success">
                            <span>Change:</span>
                            <span>৳<span id="displayChange">0.00</span></span>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg" id="checkoutBtn" disabled>
                            <i class="ti ti-check me-2"></i> Complete Sale & Print
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let cart = [];
            const searchInput = document.getElementById('productSearch');
            const checkoutBtn = document.getElementById('checkoutBtn');

            // 1. Continuous Barcode Scanning Support
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value.trim();
                    if (!query) return;

                    fetch(`{{ route('branch.pos.search') }}?q=${encodeURIComponent(query)}`)
                        .then(response => {
                            // ব্যাকএন্ড থেকে আসা JSON ডাটা পার্স করি, তারপর স্ট্যাটাস চেক করি
                            return response.json().then(data => {
                                if (!response.ok) {
                                    // ব্যাকএন্ডের আসল এরর মেসেজটিই এখন অ্যালার্টে দেখাবে
                                    throw new Error(data.error || 'Product not found or out of stock');
                                }
                                return data;
                            });
                        })
                        .then(data => {
                            addItemToCart(data);
                            this.value = '';
                            this.focus();
                        })
                        .catch(error => {
                            alert('⚠️ ' + error.message); // এখানে এখন আসল ডিবাগ মেসেজ আসবে
                            this.value = '';
                            this.focus();
                        });
                }
            });

            // Auto-focus on page load
            document.addEventListener('DOMContentLoaded', () => searchInput.focus());

            function addItemToCart(product) {
                const existingItem = cart.find(item => item.variant_id === product.variant_id);
                if (existingItem) {
                    existingItem.qty++;
                } else {
                    cart.push({
                        ...product,
                        qty: 1
                    });
                }
                renderCart();
            }

            function renderCart() {
                const tbody = document.getElementById('cartItems');
                const emptyMsg = document.getElementById('emptyCartMsg');
                let subtotal = 0;

                if (cart.length === 0) {
                    tbody.innerHTML = '';
                    tbody.appendChild(emptyMsg);
                    emptyMsg.style.display = 'table-row';
                    updateCheckoutState(0);
                    return;
                }

                emptyMsg.style.display = 'none';
                tbody.innerHTML = '';

                cart.forEach((item, index) => {
                    const total = item.price * item.qty;
                    subtotal += total;
                    tbody.innerHTML += `
                <tr>
                    <td>${item.name} <br><small class="text-muted">${item.sku}</small></td>
                    <td>${parseFloat(item.price).toFixed(2)}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm" value="${item.qty}" 
                            onchange="updateQty(${index}, this.value)" min="1" style="width: 70px;">
                    </td>
                    <td>${total.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">
                            <i class="ti ti-x"></i>
                        </button>
                    </td>
                </tr>
            `;
                });

                updateCheckoutState(subtotal);
            }

            function updateQty(index, newQty) {
                if (newQty < 1) newQty = 1;
                cart[index].qty = parseInt(newQty);
                renderCart();
            }

            function removeItem(index) {
                cart.splice(index, 1);
                renderCart();
            }

            function updateCheckoutState(subtotal) {
                document.getElementById('displaySubtotal').innerText = subtotal.toFixed(2);
                document.getElementById('displayTotal').innerText = subtotal.toFixed(2);
                document.getElementById('cartDataInput').value = JSON.stringify(cart);

                calculateChange();

                // Disable checkout if cart is empty or received amount is insufficient
                const received = parseFloat(document.getElementById('receivedAmount').value) || 0;
                if (cart.length > 0 && received >= subtotal) {
                    checkoutBtn.disabled = false;
                } else {
                    checkoutBtn.disabled = true;
                }
            }

            function calculateChange() {
                const total = parseFloat(document.getElementById('displayTotal').innerText) || 0;
                const received = parseFloat(document.getElementById('receivedAmount').value) || 0;
                const change = received - total;

                document.getElementById('displayChange').innerText = change >= 0 ? change.toFixed(2) : '0.00';
                updateCheckoutState(total); // Re-evaluate button state
            }

            document.getElementById('receivedAmount').addEventListener('input', calculateChange);
        </script>
    @endpush
@endsection
