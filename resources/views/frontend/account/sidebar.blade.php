<aside style="background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.08);overflow:hidden;">
    <div style="padding:24px 20px;text-align:center;color:var(--gray-800);border-bottom:1px solid var(--gray-100);">
        <div style="width:64px;height:64px;margin:0 auto 12px;border-radius:50%;background:var(--pink-600);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#fff;">
            <i class="fas fa-user"></i>
        </div>
        <p style="font-weight:700;font-size:1rem;margin-bottom:2px;">{{ Auth::user()->name }}</p>
        <p style="font-size:.8rem;opacity:.7;margin:0;">{{ Auth::user()->email }}</p>
    </div>
    <ul style="list-style:none;padding:0;margin:0;">
        <li style="border-bottom:1px solid var(--gray-100);">
            <a href="{{ route('account') }}" style="display:flex;align-items:center;gap:10px;padding:14px 20px;color:var(--gray-700);font-size:.9rem;font-weight:500;text-decoration:none;transition:all .2s;{{ request()->routeIs('account') && !request()->routeIs('orders*') && !request()->routeIs('wishlist') && !request()->routeIs('addresses') ? 'background:var(--pink-600);color:#fff;font-weight:600;' : '' }}" onmouseover="this.style.background='{{ request()->routeIs('account') && !request()->routeIs('orders*') && !request()->routeIs('wishlist') && !request()->routeIs('addresses') ? 'var(--pink-600)' : 'var(--pink-50)' }}';this.style.color='{{ request()->routeIs('account') && !request()->routeIs('orders*') && !request()->routeIs('wishlist') && !request()->routeIs('addresses') ? '#fff' : 'var(--pink-600)' }}'" onmouseout="this.style.background='{{ request()->routeIs('account') && !request()->routeIs('orders*') && !request()->routeIs('wishlist') && !request()->routeIs('addresses') ? 'var(--pink-600)' : 'transparent' }}';this.style.color='{{ request()->routeIs('account') && !request()->routeIs('orders*') && !request()->routeIs('wishlist') && !request()->routeIs('addresses') ? '#fff' : 'var(--gray-700)' }}'">
                <i class="fas fa-tachometer-alt" style="width:20px;text-align:center;"></i> لوحة التحكم
            </a>
        </li>
        <li style="border-bottom:1px solid var(--gray-100);">
            <a href="{{ route('orders') }}" style="display:flex;align-items:center;gap:10px;padding:14px 20px;color:var(--gray-700);font-size:.9rem;font-weight:500;text-decoration:none;transition:all .2s;{{ request()->routeIs('orders*') ? 'background:var(--pink-600);color:#fff;font-weight:600;' : '' }}" onmouseover="this.style.background='{{ request()->routeIs('orders*') ? 'var(--pink-600)' : 'var(--pink-50)' }}';this.style.color='{{ request()->routeIs('orders*') ? '#fff' : 'var(--pink-600)' }}'" onmouseout="this.style.background='{{ request()->routeIs('orders*') ? 'var(--pink-600)' : 'transparent' }}';this.style.color='{{ request()->routeIs('orders*') ? '#fff' : 'var(--gray-700)' }}'">
                <i class="fas fa-box" style="width:20px;text-align:center;"></i> طلباتي
            </a>
        </li>
        <li style="border-bottom:1px solid var(--gray-100);">
            <a href="{{ route('wishlist') }}" style="display:flex;align-items:center;gap:10px;padding:14px 20px;color:var(--gray-700);font-size:.9rem;font-weight:500;text-decoration:none;transition:all .2s;{{ request()->routeIs('wishlist') ? 'background:var(--pink-600);color:#fff;font-weight:600;' : '' }}" onmouseover="this.style.background='{{ request()->routeIs('wishlist') ? 'var(--pink-600)' : 'var(--pink-50)' }}';this.style.color='{{ request()->routeIs('wishlist') ? '#fff' : 'var(--pink-600)' }}'" onmouseout="this.style.background='{{ request()->routeIs('wishlist') ? 'var(--pink-600)' : 'transparent' }}';this.style.color='{{ request()->routeIs('wishlist') ? '#fff' : 'var(--gray-700)' }}'">
                <i class="fas fa-heart" style="width:20px;text-align:center;"></i> المفضلة
            </a>
        </li>
        <li style="border-bottom:1px solid var(--gray-100);">
            <a href="{{ route('addresses') }}" style="display:flex;align-items:center;gap:10px;padding:14px 20px;color:var(--gray-700);font-size:.9rem;font-weight:500;text-decoration:none;transition:all .2s;{{ request()->routeIs('addresses') ? 'background:var(--pink-600);color:#fff;font-weight:600;' : '' }}" onmouseover="this.style.background='{{ request()->routeIs('addresses') ? 'var(--pink-600)' : 'var(--pink-50)' }}';this.style.color='{{ request()->routeIs('addresses') ? '#fff' : 'var(--pink-600)' }}'" onmouseout="this.style.background='{{ request()->routeIs('addresses') ? 'var(--pink-600)' : 'transparent' }}';this.style.color='{{ request()->routeIs('addresses') ? '#fff' : 'var(--gray-700)' }}'">
                <i class="fas fa-map-marker-alt" style="width:20px;text-align:center;"></i> عناويني
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="display:flex;align-items:center;gap:10px;padding:14px 20px;color:var(--gray-700);font-size:.9rem;font-weight:500;text-decoration:none;transition:all .2s;" onmouseover="this.style.background='var(--pink-50)';this.style.color='var(--danger)'" onmouseout="this.style.background='transparent';this.style.color='var(--gray-700)'">
                <i class="fas fa-sign-out-alt" style="width:20px;text-align:center;color:var(--danger);"></i> تسجيل الخروج
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </li>
    </ul>
</aside>
