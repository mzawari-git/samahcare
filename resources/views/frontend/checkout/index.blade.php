@extends('frontend.layouts.app-v2')

@section('title', 'إتمام الشراء - ' . ($siteSettings['site_name'] ?? 'JeniCare'))

@section('content')
<section class="pt-32 pb-8 bg-gradient-to-b from-brand-50 to-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-ink">إتمام الشراء</h1>
        <p class="text-gray-500 mt-1">أدخلي معلومات الشحن وأكدي طلبك</p>
    </div>
</section>

{{-- Progress Steps --}}
<div class="max-w-xl mx-auto px-4 py-8">
    <div class="flex items-center justify-center gap-0">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-brand-600 text-white flex items-center justify-center font-extrabold text-sm shadow-lg">1</span>
            <span class="font-bold text-sm text-ink">السلة</span>
        </div>
        <div class="w-10 h-0.5 bg-brand-400 mx-3 rounded-full"></div>
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-brand-600 text-white flex items-center justify-center font-extrabold text-sm shadow-lg">2</span>
            <span class="font-bold text-sm text-brand-600">الدفع</span>
        </div>
        <div class="w-10 h-0.5 bg-gray-200 mx-3 rounded-full"></div>
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-extrabold text-sm">3</span>
            <span class="font-semibold text-sm text-gray-400">تأكيد</span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">
            <div class="lg:col-span-4 space-y-5">
                {{-- Shipping Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-11 h-11 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 text-lg">
                            <i class="ph ph-truck"></i>
                        </span>
                        <h3 class="text-lg font-bold text-ink">معلومات الشحن</h3>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1.5 font-semibold text-sm text-ink">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', Auth::user()->name ?? '') }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition-all bg-white"
                            placeholder="أدخل اسمك الكامل">
                        @error('customer_name')<p class="text-red-500 text-xs mt-1"><i class="ph ph-warning-circle"></i> {{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1.5 font-semibold text-sm text-ink">البريد الإلكتروني <span class="text-red-500">*</span></label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', Auth::user()->email ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition-all bg-white"
                                placeholder="example@email.com">
                            @error('customer_email')<p class="text-red-500 text-xs mt-1"><i class="ph ph-warning-circle"></i> {{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block mb-1.5 font-semibold text-sm text-ink">رقم الهاتف <span class="text-red-500">*</span></label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone', Auth::user()->phone ?? '') }}" required dir="ltr"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition-all bg-white"
                                placeholder="05XX XXXXXX">
                            @error('customer_phone')<p class="text-red-500 text-xs mt-1"><i class="ph ph-warning-circle"></i> {{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1.5 font-semibold text-sm text-ink">العنوان <span class="text-red-500">*</span></label>
                        <textarea name="shipping_address" required rows="2"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition-all bg-white resize-y"
                            placeholder="العنوان بالكامل (الشارع، الحي، المبنى)">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')<p class="text-red-500 text-xs mt-1"><i class="ph ph-warning-circle"></i> {{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1.5 font-semibold text-sm text-ink">المدينة <span class="text-red-500">*</span></label>
                            <select name="shipping_city" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition-all bg-white cursor-pointer">
                                <option value="">اختر المدينة</option>
                                @foreach(['رام الله','نابلس','الخليل','بيت لحم','جنين','طولكرم','قلقيلية','طوباس','سلفيت','القدس','أريحا','غزة'] as $city)
                                <option value="{{ $city }}" {{ old('shipping_city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                            @error('shipping_city')<p class="text-red-500 text-xs mt-1"><i class="ph ph-warning-circle"></i> {{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block mb-1.5 font-semibold text-sm text-ink">المنطقة</label>
                            <input type="text" name="shipping_region" value="{{ old('shipping_region') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition-all bg-white"
                                placeholder="(اختياري)">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 font-semibold text-sm text-ink">ملاحظات الطلب</label>
                        <textarea name="shipping_notes" rows="2"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition-all bg-white resize-y"
                            placeholder="أي ملاحظات إضافية للتوصيل">{{ old('shipping_notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-5">
                {{-- Order Review --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-11 h-11 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 text-lg">
                            <i class="ph ph-shopping-bag"></i>
                        </span>
                        <span class="font-bold text-ink">مراجعة الطلب</span>
                    </div>
                    <div class="px-5 py-3 space-y-1">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-3 py-2.5 border-b border-gray-50 last:border-b-0">
                            @if($item->product->main_image_url)
                            <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product->name_ar }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 border border-gray-100">
                            @else
                            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0"><i class="ph ph-image text-gray-300"></i></div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-ink truncate">{{ $item->product->name_ar }}</p>
                                <p class="text-xs text-gray-400">الكمية: {{ $item->quantity }}</p>
                            </div>
                            <span class="font-bold text-sm text-ink whitespace-nowrap">{{ number_format($item->total, 2) }} ₪</span>
                        </div>
                        @endforeach
                        <div class="flex justify-between py-2.5 text-sm text-gray-500">
                            <span>المجموع الفرعي</span>
                            <span class="font-semibold text-ink">{{ number_format($cart->subtotal, 2) }} ₪</span>
                        </div>
                        <div class="flex justify-between py-2.5 text-sm text-gray-500">
                            <span>الشحن</span>
                            @if(($shippingCost ?? 0) > 0)
                            <span class="font-semibold text-ink">{{ number_format($shippingCost, 2) }} ₪</span>
                            @else
                            <span class="font-semibold text-green-600">مجاني</span>
                            @endif
                        </div>
                        <div class="flex justify-between py-3 border-t-2 border-gray-100 text-base font-extrabold text-ink">
                            <span>الإجمالي</span>
                            <span class="text-brand-600">{{ number_format($totalAmount ?? $cart->subtotal, 2) }} ₪</span>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                        <span class="w-11 h-11 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 text-lg">
                            <i class="ph ph-credit-card"></i>
                        </span>
                        <span class="font-bold text-ink">طريقة الدفع</span>
                    </div>
                    <div class="p-5 space-y-3">
                        @php $firstMethod = array_key_first($paymentMethods); @endphp
                        @foreach($paymentMethods as $method)
                        @php $isFirst = $loop->first; @endphp
                        <label class="payment-option flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 {{ $isFirst ? 'border-brand-400 bg-brand-50' : 'border-gray-200 bg-white hover:border-brand-300' }}" data-method="{{ $method['id'] }}">
                            <input type="radio" name="payment_method" value="{{ $method['id'] }}" {{ $isFirst ? 'checked' : '' }} class="w-5 h-5 accent-brand-600 flex-shrink-0">
                            <div class="flex-1">
                                <strong class="block text-sm text-ink mb-0.5">{{ $method['name'] }}</strong>
                                <small class="text-gray-400 text-xs">{{ $method['description'] }}</small>
                            </div>
                            <i class="ph ph-{{ $method['id'] === 'cod' ? 'money' : ($method['id'] === 'bank_transfer' ? 'bank' : 'device-mobile') }} text-xl {{ $isFirst ? 'text-brand-500' : 'text-gray-400' }}"></i>
                        </label>
                        @endforeach

                        @if(isset($paymentMethods['bank_transfer']))
                        <div id="bankDetails" class="{{ $firstMethod === 'bank_transfer' ? '' : 'hidden' }} mt-2 p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm">
                            <p class="font-bold text-blue-800 mb-2"><i class="ph ph-info"></i> معلومات التحويل البنكي:</p>
                            @if($settings['payment_bank_name'] ?? false)<p class="text-blue-800 mb-1"><strong>البنك:</strong> {{ $settings['payment_bank_name'] }}</p>@endif
                            @if($settings['payment_bank_holder'] ?? false)<p class="text-blue-800 mb-1"><strong>اسم المستفيد:</strong> {{ $settings['payment_bank_holder'] }}</p>@endif
                            @if($settings['payment_bank_account'] ?? false)<p class="text-blue-800 mb-1" dir="ltr"><strong>رقم الحساب:</strong> {{ $settings['payment_bank_account'] }}</p>@endif
                            @if($settings['payment_bank_iban'] ?? false)<p class="text-blue-800 mb-1" dir="ltr"><strong>IBAN:</strong> {{ $settings['payment_bank_iban'] }}</p>@endif
                            <p class="text-blue-400 text-xs mt-2">بعد التحويل، يرجى إرسال إيصال الدفع عبر واتساب لتأكيد الطلب.</p>
                        </div>
                        @endif
                        @if(isset($paymentMethods['jawwal_pay']))
                        <div id="jawwalDetails" class="{{ $firstMethod === 'jawwal_pay' ? '' : 'hidden' }} mt-2 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm">
                            <p class="font-bold text-amber-800 mb-2"><i class="ph ph-info"></i> معلومات الدفع عبر جوال باي:</p>
                            @if($settings['payment_jawwal_holder'] ?? false)<p class="text-amber-800 mb-1"><strong>اسم المستفيد:</strong> {{ $settings['payment_jawwal_holder'] }}</p>@endif
                            @if($settings['payment_jawwal_phone'] ?? false)<p class="text-amber-800 mb-1" dir="ltr"><strong>رقم جوال باي:</strong> {{ $settings['payment_jawwal_phone'] }}</p>@endif
                            <p class="text-amber-500 text-xs mt-2">بعد إرسال المبلغ، يرجى إرسال تأكيد الدفع عبر واتساب.</p>
                        </div>
                        @endif
                        @if(isset($paymentMethods['reflect']))
                        <div id="reflectDetails" class="{{ $firstMethod === 'reflect' ? '' : 'hidden' }} mt-2 p-4 bg-cyan-50 border border-cyan-200 rounded-xl text-sm">
                            <p class="font-bold text-cyan-800 mb-2"><i class="ph ph-info"></i> معلومات الدفع عبر Reflect:</p>
                            @if($settings['payment_reflect_holder'] ?? false)<p class="text-cyan-800 mb-1"><strong>اسم المستفيد:</strong> {{ $settings['payment_reflect_holder'] }}</p>@endif
                            @if($settings['payment_reflect_phone'] ?? false)<p class="text-cyan-800 mb-1" dir="ltr"><strong>رقم هاتف Reflect:</strong> {{ $settings['payment_reflect_phone'] }}</p>@endif
                            <p class="text-cyan-500 text-xs mt-2">بعد إرسال المبلغ عبر تطبيق Reflect، يرجى إرسال تأكيد الدفع عبر واتساب.</p>
                        </div>
                        @endif

                        <button type="submit" id="checkoutBtn"
                            class="flex items-center justify-center gap-2 w-full py-4 bg-gradient-to-r from-ink to-brand-600 text-white rounded-full font-bold text-base hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 shadow-lg mt-3">
                            <i class="ph ph-check-circle text-lg"></i> تأكيد الطلب
                        </button>
                    </div>
                </div>

                {{-- WhatsApp alternative --}}
                <div class="text-center p-5 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-sm text-gray-400 mb-3">تفضلين الطلب عبر واتساب؟</p>
                    <a href="https://wa.me/{{ $settings['site_whatsapp'] ?? '970591234567' }}?text={{ urlencode('السلام عليكم، أريد تأكيد طلبي من JeniCare') }}" target="_blank"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-green-500 text-white rounded-full font-bold text-sm hover:bg-green-600 hover:shadow-lg transition-all duration-300">
                        <i class="ph ph-whatsapp-logo text-lg"></i> اطلب عبر واتساب
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.querySelectorAll('.payment-option');
    const detailsMap = {
        bank_transfer: document.getElementById('bankDetails'),
        jawwal_pay: document.getElementById('jawwalDetails'),
        reflect: document.getElementById('reflectDetails')
    };

    function selectPayment(label) {
        const radio = label.querySelector('input[type="radio"]');
        radio.checked = true;
        paymentOptions.forEach(o => { o.classList.remove('border-brand-400','bg-brand-50'); o.classList.add('border-gray-200','bg-white'); o.querySelector('i:last-child').classList.remove('text-brand-500'); o.querySelector('i:last-child').classList.add('text-gray-400'); });
        label.classList.remove('border-gray-200','bg-white');
        label.classList.add('border-brand-400','bg-brand-50');
        label.querySelector('i:last-child').classList.remove('text-gray-400');
        label.querySelector('i:last-child').classList.add('text-brand-500');
        Object.values(detailsMap).forEach(d => { if(d) d.classList.add('hidden'); });
        const method = label.dataset.method;
        if (detailsMap[method]) detailsMap[method].classList.remove('hidden');
    }

    paymentOptions.forEach(opt => { opt.addEventListener('click', () => selectPayment(opt)); });

    const form = document.getElementById('checkoutForm');
    const btn = document.getElementById('checkoutBtn');
    form.addEventListener('submit', function() {
        btn.disabled = true;
        btn.innerHTML = '<span class="loading-spinner"></span> جاري تأكيد الطلب...';
        btn.style.opacity = '0.7';
        btn.style.cursor = 'not-allowed';
    });
});
</script>
@endsection
