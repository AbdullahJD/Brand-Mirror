<script>
    window.i18n = {!! json_encode([
        'submitting' => __('messages.submitting'),
        'errorRemovingItem' => __('messages.error_removing_item'),
        'addedToCart' => __('messages.added_to_cart'),
        'couponError' => __('messages.coupon_error'),
        'ok' => __('messages.ok'),
        'couponApplied' => __('messages.coupon_applied'),
        'couponAppliedSuccess' => __('messages.coupon_applied_success'),
        'serverError' => __('messages.server_error'),
        'somethingWentWrong' => __('messages.something_went_wrong'),
        'loginRequired' => __('messages.login_required'),
        'loginRequiredForFavorites' => __('messages.login_required_for_favorites'),
        'login' => __('messages.login'),
        'addedToFavorites' => __('messages.added_to_favorites'),
        'removedFromFavorites' => __('messages.removed_from_favorites'),
        'errorRemovingFavorite' => __('messages.error_removing_favorite'),
        'products' => __('messages.products'),
        'categories' => __('messages.categories'),
        'noResultsFound' => __('messages.no_results_found'),
    ], JSON_UNESCAPED_UNICODE) !!};
</script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ URL::asset('website/lib/easing/easing.min.js') }}"></script>
<script src="{{ URL::asset('website/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Contact Javascript File -->
<script src="{{ URL::asset('website/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ URL::asset('website/mail/contact.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ URL::asset('website/js/main.js') }}"></script>

@yield('js')

<script>
    window.isLoggedIn = @json(auth('customer')->check());
</script>

<script>
document.addEventListener("submit", function (e) {
    const form = e.target;

    if (form.tagName === "FORM") {
        const btn = form.querySelector("button[type='submit']");

        if (btn) {
            btn.disabled = true;
            btn.innerText = window.i18n.submitting;
        }
    }
});
</script>

<script>
    async function removeItem(itemId) {

        try {
            const response = await fetch('/api/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    item_id: itemId
                })
            });

            const data = await response.json();

            if (data.status) {
                updateCartUI(data.cart, data.cart_count);
            }

        } catch (error) {
            console.log(error);
            alert(window.i18n.errorRemovingItem);
        }
    }
</script>

<script>
    async function updateQuantity(itemId, quantity) {
        const response = await fetch('/api/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                item_id: itemId,
                quantity: quantity
            })
        });

        const data = await response.json();

        if (data.status) {
            updateCartUI(data.cart, data.cart_count); //  بدل reload
        }
    }
</script>

<script>
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.add-to-cart');
        if (!btn) return;

        const productId = btn.dataset.id;

        const qtyInput = document.querySelector('.quantity-input');
        const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

        fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                updateCartUI(data.cart, data.cart_count);
                showToast(window.i18n.addedToCart);
            }
        });
    });
</script>


<script>
function showToast(message) {
    const toast = document.getElementById('toast');

    if (!toast) return;

    toast.innerText = message;

    // إظهار مع animation بسيط
    toast.style.display = 'block';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(20px)';

    setTimeout(() => {
        toast.style.transition = '0.3s ease';
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 10);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
    }, 1800);

    setTimeout(() => {
        toast.style.display = 'none';
    }, 2000);
}
</script>


<script>
    function updateCartUI(cart, cartCountFromServer) {

        const tbody = document.querySelector('.table tbody');
        const countEl = document.getElementById('cart-count');
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalBeforeEl = document.getElementById('total-before-coupon');
        const finalEl = document.getElementById('final-total');
        const discountEl = document.getElementById('cart-discount');

        let subtotal = 0;

        if (tbody) tbody.innerHTML = '';

        (cart.items || []).forEach(item => {

            subtotal += parseFloat(item.subtotal);

            if (tbody) {
                tbody.innerHTML += `
                    <tr>
                        <td>${item.product.name}</td>
                        <td>$${item.price}</td>
                        <td>
                            <input type="number"
                                value="${item.quantity}"
                                onchange="updateQuantity(${item.id}, this.value)">
                        </td>
                        <td>$${item.subtotal}</td>
                        <td>
                            <button onclick="removeItem(${item.id})">X</button>
                        </td>
                    </tr>
                `;
            }
        });

        const shipping = 5;
        const discount = Number(cart.discount || 0);

        if (discountEl) {
            discountEl.innerText = '-$' + discount.toFixed(2);
        }

        const totalBefore = subtotal + shipping;
        const finalTotal = totalBefore - discount;

        const headerCountEl = document.getElementById('header-cart-count');
        const pageCountEl = document.getElementById('page-cart-count');

        if (headerCountEl) {
            headerCountEl.innerText = cartCountFromServer;
        }

        if (pageCountEl) {
            pageCountEl.innerText = cartCountFromServer;
        }
        //  أهم تعديل هنا
        if (countEl) {
            countEl.innerText = cartCountFromServer ?? cart.items.reduce((s, i) => s + i.quantity, 0);
        }

        if (subtotalEl) subtotalEl.innerText = '$' + subtotal.toFixed(2);
        if (totalBeforeEl) totalBeforeEl.innerText = '$' + totalBefore.toFixed(2);
        if (finalEl) finalEl.innerText = '$' + finalTotal.toFixed(2);
    }
</script>

<script>
    function applyCouponCheckout() {
        const code = document.getElementById('coupon-code').value;

        fetch('/apply-coupon', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ code })
        })
        .then(res => res.json())
        .then(data => {

            if (!data.status) {

                Swal.fire({
                    icon: 'warning',
                    title: window.i18n.couponError,
                    text: data.message,
                    confirmButtonText: window.i18n.ok
                });

                return;
            }

            Swal.fire({
                icon: 'success',
                title: window.i18n.couponApplied,
                text: window.i18n.couponAppliedSuccess,
            });

            document.getElementById('discount-value').innerText =
                '-$' + Number(data.discount).toFixed(2);

            document.getElementById('final-total').innerText =
                '$' + Number(data.final_total).toFixed(2);
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: window.i18n.serverError,
                text: window.i18n.somethingWentWrong
            });
        });
    }
</script>


<script>
    const favoriteState = window.favoriteIds || [];
    document.addEventListener('click', async function (e) {

        const btn = e.target.closest('.toggle-favorite');
        if (!btn) return;

        const productId = parseInt(btn.dataset.id);

        //  CHECK LOGIN FIRST
        if (!window.isLoggedIn) {

        Swal.fire({
            icon: 'warning',
            title: window.i18n.loginRequired,
            text: window.i18n.loginRequiredForFavorites,
            confirmButtonText: window.i18n.login
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = "{{ route('store.login') }}";
            }

        });

        return;
    }

        const response = await fetch(`/favorites/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (!data.status) return;

        const isFav = data.data.is_favorite;

        if (isFav) {
            if (!window.favoriteIds.includes(productId)) {
                window.favoriteIds.push(productId);
            }
        } else {
            window.favoriteIds = window.favoriteIds.filter(id => id !== productId);
        }

        syncFavoriteUI(productId, isFav);

        await updateFavoritesCount();

        if (isFav) {
            showToast(window.i18n.addedToFavorites);
        } else {
            showToast(window.i18n.removedFromFavorites);
        }
    });
</script>

<script>
    async function updateFavoritesCount() {

        const res = await fetch('/favorites');
        const data = await res.json();

        if (!data.status) return;

        const count = data.favorites.length;

        document.getElementById('header-fav-count').innerText = count;

        const icon = document.getElementById('header-heart-icon');

        if (count > 0) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = 'red';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            icon.style.color = '';
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        updateFavoritesCount();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.toggle-favorite').forEach(btn => {

            const productId = parseInt(btn.dataset.id);
            const icon = btn.querySelector('i');

            if (window.favoriteIds.includes(productId)) {
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-danger');
            }
        });

    });
</script>

<script>
    function syncFavoriteUI(productId, isFavorite) {

        const icons = document.querySelectorAll(
            `.toggle-favorite[data-id="${productId}"] i`
        );

        icons.forEach(icon => {
            if (isFavorite) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.style.color = 'red';

                
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.style.color = '';
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        //  سكربت خاص بصفحة المفضلة فقط
        const favoritePageHandler = document;

        favoritePageHandler.addEventListener('click', async function (e) {

            const btn = e.target.closest('.remove-favorite');
            if (!btn) return;

            const productId = btn.dataset.id;

            try {
                const response = await fetch(`/favorites/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.status) {

                    // حذف العنصر من الصفحة بدون reload
                    const item = btn.closest('.col-lg-3');
                    if (item) item.remove();

                    showToast(window.i18n.removedFromFavorites);

                    // تحديث العداد في الهيدر
                    updateFavoritesCount();
                }

            } catch (err) {
                console.log(err);
                showToast(window.i18n.errorRemovingFavorite);
            }
        });

    });
</script>

<script>
    window.favoriteIds = @json($favoriteIds ?? []);
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const favoriteIds = window.favoriteIds || [];

        document.querySelectorAll('.toggle-favorite').forEach(btn => {

            const productId = parseInt(btn.dataset.id);
            const icon = btn.querySelector('i');

            if (favoriteIds.includes(productId)) {
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-danger');
            }

        });

    });
</script>

<script>
    const input = document.getElementById('search-input');
    const resultsBox = document.getElementById('search-results');

    let timer = null;

    input.addEventListener('input', function () {

        clearTimeout(timer);

        const query = this.value.trim();

        if (query.length < 2) {
            resultsBox.style.display = 'none';
            resultsBox.innerHTML = '';
            return;
        }

        timer = setTimeout(() => {
            fetch(`/search?q=${query}`)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    // المنتجات
                    if (data.products.length) {
                        html += `<div class="p-2 text-muted">${window.i18n.products}</div>`;
                        data.products.forEach(p => {
                            html += `
                                <a href="/product/${p.id}"
                                class="d-block p-2 border-bottom text-dark text-decoration-none">
                                    🛒 ${p.name}
                                </a>
                            `;
                        });
                    }

                    // الأقسام
                    if (data.categories.length) {
                        html += `<div class="p-2 text-muted">${window.i18n.categories}</div>`;
                        data.categories.forEach(c => {
                            html += `
                                <a href="/category/${c.id}"
                                class="d-block p-2 border-bottom text-dark text-decoration-none">
                                    📁 ${c.name}
                                </a>
                            `;
                        });
                    }

                    if (!data.products.length && !data.categories.length) {
                        html = `<div class="p-2 text-muted">${window.i18n.noResultsFound}</div>`;
                    }

                    resultsBox.innerHTML = html;
                    resultsBox.style.display = 'block';
                });

        }, 300);
    });

    // إخفاء عند الضغط خارج
    document.addEventListener('click', function(e){
        if (!document.getElementById('search-form').contains(e.target)) {
            resultsBox.style.display = 'none';
        }
    });
</script>