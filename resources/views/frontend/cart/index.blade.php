@extends('frontend.layouts.app-v2')

@section('title', 'سلة التسوق - ' . ($siteSettings['site_name'] ?? 'JeniCare'))

@section('content')
<section class="pt-32 pb-8 bg-gradient-to-b from-brand-50 to-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-ink">سلة التسوق</h1>
        <p class="text-gray-500 mt-1">مراجعة المنتجات قبل إتمام الطلب</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-20">
    @if($cart && $cart->items->isNotEmpty())
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            {{-- Free shipping banner --}}
            @php $subtotal = $cart->subtotal; $freeShippingThreshold = floatval($freeShippingMin ?? $siteSettings['free_shipping_min'] ?? 200); @endphp
            @if($subtotal < $freeShippingThreshold)
            <div class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-2xl px-5 py-4 mb-4 flex items-center gap-4">
                <i class="ph ph-truck text-xl text-amber-600"></i>
                <div class="flex-1">
                    <strong class="text-amber-800 text-sm">تبقى {{ number_format($freeShippingThreshold - $subtotal, 2) }} ₪ للشحن المجاني!</strong>
                    <div class="h-1.5 bg-amber-200 rounded-full mt-2 overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full transition-all duration-500" style="width:{{ min(100, ($subtotal / $freeShippingThreshold) * 100) }}%"></div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl px-5 py-4 mb-4 flex items-center gap-3">
                <i class="ph-fill ph-check-circle text-xl text-green-500"></i>
                <strong class="text-green-700 text-sm">مؤهل للشحن المجاني!</strong>
            </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <span class="font-bold text-ink flex items-center gap-2">
                        <i class="ph-fill ph-shopping-bag text-brand-500"></i>
                        منتجات السلة (<span id="cart-total-items">{{ $cart->items->sum('quantity') }}</span>)
                    </span>
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من تفريغ السلة؟')">
                        @csrf
                        <button type="submit" class="text-gray-400 text-xs hover:text-red-500 transition-colors flex items-center gap-1">
                            <i class="ph ph-trash"></i> تفريغ السلة
                        </button>
                    </form>
                </div>

                <div id="cart-items-container">
                    @foreach($cart->items as $item)
                    <div class="cart-item-row flex items-center gap-4 px-5 py-4 border-b border-gray-50 hover:bg-gray-50/50 transition-colors" data-item-id="{{ $item->id }}">
                        <a href="{{ route('product.show', $item->product->slug) }}" class="flex-shrink-0">
                            @if($item->product->main_image_url)
                            <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product->name_ar }}" class="w-20 h-20 rounded-xl object-cover">
                            @else
                            <div class="w-20 h-20 rounded-xl bg-gray-50 flex items-center justify-center"><i class="ph ph-image text-2xl text-gray-200"></i></div>
                            @endif
                        </a>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('product.show', $item->product->slug) }}">
                                <h4 class="text-sm font-bold text-ink hover:text-brand-600 transition-colors">{{ $item->product->name_ar }}</h4>
                            </a>
                            @if($item->product->sku)<p class="text-[11px] text-gray-400 mt-0.5">SKU: {{ $item->product->sku }}</p>@endif
                            <p class="text-sm text-brand-600 font-bold mt-1">{{ number_format($item->unit_price, 2) }} ₪</p>
                        </div>
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                            <button onclick="updateCartQty({{ $item->id }}, -1)" class="px-3 py-2 hover:bg-gray-100 transition-colors text-gray-500"><i class="ph ph-minus text-xs"></i></button>
                            <span class="cart-qty-val font-bold text-sm min-w-[28px] text-center text-ink px-1 py-2">{{ $item->quantity }}</span>
                            <button onclick="updateCartQty({{ $item->id }}, 1)" class="px-3 py-2 hover:bg-gray-100 transition-colors text-gray-500"><i class="ph ph-plus text-xs"></i></button>
                        </div>
                        <div class="text-left min-w-[80px]">
                            <span class="cart-item-total font-extrabold text-brand-600 whitespace-nowrap">{{ number_format($item->total, 2) }} ₪</span>
                        </div>
                        <button onclick="removeCartItem({{ $item->id }})" title="حذف" class="w-8 h-8 rounded-full border border-gray-200 bg-white text-gray-400 hover:border-red-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center flex-shrink-0">
                            <i class="ph ph-trash text-sm"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm lg:sticky lg:top-32">
                <div class="px-5 py-4 border-b border-gray-100">
                    <span class="font-bold text-ink flex items-center gap-2">
                        <i class="ph ph-receipt text-brand-500"></i> ملخص الطلب
                    </span>
                </div>
                <div class="p-5">
                    <div class="mb-4">
                        <div class="flex gap-2">
                            <input type="text" id="couponCode" placeholder="كود الخصم" class="flex-1 bg-surface border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
                            <button onclick="applyCoupon()" class="px-4 py-2.5 bg-ink text-white text-sm font-bold rounded-xl hover:bg-brand-600 transition-colors whitespace-nowrap">تطبيق</button>
                        </div>
                        <div id="couponMsg" class="mt-2 text-xs"></div>
                    </div>

                    <div class="flex justify-between py-3 text-sm text-gray-600">
                        <span>المجموع الفرعي</span>
                        <span id="cart-subtotal" class="font-semibold text-ink">{{ number_format($cart->subtotal, 2) }} ₪</span>
                    </div>
                    <div id="discountRow" class="hidden justify-between py-3 text-sm text-green-600">
                        <span>الخصم</span>
                        <span id="discountAmount" class="font-semibold">-0.00 ₪</span>
                    </div>
                    <div class="flex justify-between py-3 text-sm text-gray-600">
                        <span>الشحن</span>
                        @if(($shippingCost ?? 0) > 0)
                        <span class="text-ink font-semibold" id="shipping-cost">{{ number_format($shippingCost, 2) }} ₪</span>
                        @else
                        <span class="text-green-500 font-semibold" id="shipping-cost">مجاني</span>
                        @endif
                    </div>
                    <div class="flex justify-between py-4 border-t-2 border-gray-100 text-lg font-extrabold text-ink mt-2">
                        <span>الإجمالي</span>
                        <span id="cart-total" class="text-brand-600">{{ number_format($cart->subtotal + ($shippingCost ?? 0), 2) }} ₪</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-ink text-white rounded-full font-bold hover:bg-brand-600 transition-all shadow-lg mt-4">
                        <i class="ph ph-credit-card"></i> إتمام الشراء
                    </a>
                    <a href="{{ route('shop') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-white text-brand-600 border border-brand-200 rounded-full font-bold hover:border-brand-500 hover:bg-brand-50 transition-all mt-2">
                        <i class="ph ph-arrow-right"></i> متابعة التسوق
                    </a>
                </div>
            </div>

            <div class="flex justify-center gap-6 mt-4 text-xs text-gray-400">
                <span class="flex items-center gap-1"><i class="ph ph-lock text-green-500"></i> دفع آمن</span>
                <span class="flex items-center gap-1"><i class="ph ph-truck text-brand-500"></i> توصيل سريع</span>
                <span class="flex items-center gap-1"><i class="ph ph-arrow-counter-clockwise text-amber-500"></i> استرجاع سهل</span>
            </div>
        </div>
    </div>
    @else
    <div class="text-center max-w-md mx-auto py-16">
        <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-brand-50 to-pink-50 flex items-center justify-center mx-auto mb-6 shadow-lg">
            <i class="ph ph-shopping-cart text-5xl text-brand-400"></i>
        </div>
        <h3 class="text-2xl font-extrabold text-ink mb-3">سلتك فارغة</h3>
        <p class="text-gray-500 mb-8 leading-relaxed">لم تقم بإضافة أي منتجات بعد. تصفحي مجموعتنا المميزة من منتجات العناية.</p>
        <a href="{{ route('shop') }}" class="inline-flex items-center gap-3 px-10 py-3.5 bg-ink text-white rounded-full font-bold hover:bg-brand-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="ph ph-arrow-left"></i> تصفحي المتجر
        </a>
    </div>
    @endif
</div>

<script>
let cartSubtotal = {{ $cart->subtotal ?? 0 }};
let couponDiscount = 0;
let currentShipping = {{ $shippingCost ?? 0 }};

async function updateCartQty(itemId, delta) {
    const row = document.querySelector(`.cart-item-row[data-item-id="${itemId}"]`);
    const qtyEl = row.querySelector('.cart-qty-val');
    let newQty = parseInt(qtyEl.textContent) + delta;
    if (newQty < 1) { if (confirm('هل تريد حذف هذا المنتج؟')) { await removeCartItem(itemId); } return; }
    const basePath = window.basePath || '';
    try {
        const r = await fetch(basePath + '/cart/update', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify({ cart_item_id: itemId, quantity: newQty }) });
        const d = await r.json();
        if (d.success) { qtyEl.textContent = newQty; row.querySelector('.cart-item-total').textContent = parseFloat(d.item_total).toFixed(2) + ' ₪'; refreshCartTotals(d.cart_subtotal, d.cart_total, d.cart_count, d.shipping_cost); showNotification('success', 'تم تحديث الكمية'); }
    } catch(e) { showNotification('error', 'حدث خطأ'); }
}

async function removeCartItem(itemId) {
    if (!confirm('هل أنت متأكد من حذف هذا المنتج؟')) return;
    const basePath = window.basePath || '';
    try {
        const r = await fetch(basePath + '/cart/remove', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify({ cart_item_id: itemId }) });
        const d = await r.json();
        if (d.success) {
            const row = document.querySelector(`.cart-item-row[data-item-id="${itemId}"]`);
            row.style.opacity = '0'; row.style.transform = 'translateX(-20px)'; row.style.transition = 'all .3s';
            setTimeout(() => row.remove(), 300);
            refreshCartTotals(d.cart_subtotal, d.cart_total, d.cart_count, d.shipping_cost);
            if (document.querySelectorAll('.cart-item-row').length === 0) setTimeout(() => location.reload(), 400);
            showNotification('success', 'تم حذف المنتج');
        }
    } catch(e) { showNotification('error', 'حدث خطأ'); }
}

function refreshCartTotals(subtotal, total, count, shipping) {
    cartSubtotal = parseFloat(subtotal);
    if (typeof shipping !== 'undefined') {
        currentShipping = parseFloat(shipping);
        const shippingEl = document.getElementById('shipping-cost');
        if (currentShipping > 0) {
            shippingEl.textContent = currentShipping.toFixed(2) + ' ₪';
            shippingEl.className = 'text-ink font-semibold';
        } else {
            shippingEl.textContent = 'مجاني';
            shippingEl.className = 'text-green-500 font-semibold';
        }
    }
    document.getElementById('cart-subtotal').textContent = cartSubtotal.toFixed(2) + ' ₪';
    document.getElementById('cart-total-items').textContent = count;
    updateTotalDisplay();
    const badge = document.getElementById('cart-count'); if (badge) badge.textContent = count;
}

function updateTotalDisplay() {
    document.getElementById('cart-total').textContent = Math.max(0, cartSubtotal + currentShipping - couponDiscount).toFixed(2) + ' ₪';
}

async function applyCoupon() {
    const code = document.getElementById('couponCode').value.trim();
    const msgEl = document.getElementById('couponMsg');
    if (!code) { msgEl.innerHTML = '<span class="text-red-500">أدخل كود الخصم</span>'; return; }
    const basePath = window.basePath || '';
    try {
        const r = await fetch(basePath + '/cart/coupon', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify({ code: code }) });
        const d = await r.json();
        if (d.success) {
            couponDiscount = parseFloat(d.discount);
            document.getElementById('discountRow').style.display = 'flex';
            document.getElementById('discountAmount').textContent = '-' + couponDiscount.toFixed(2) + ' ₪';
            updateTotalDisplay();
            msgEl.innerHTML = '<span class="text-green-600"><i class="ph ph-check-circle"></i> ' + d.message + '</span>';
            showNotification('success', d.message);
        } else { msgEl.innerHTML = '<span class="text-red-500"><i class="ph ph-x-circle"></i> ' + d.message + '</span>'; }
    } catch(e) { msgEl.innerHTML = '<span class="text-red-500">حدث خطأ</span>'; }
}
</script>

<style>
@media (max-width: 768px) {
    .cart-item-row { flex-wrap: wrap; gap: 10px !important; }
    .cart-item-row > a img { width: 64px !important; height: 64px !important; }
}
</style>
@endsection
