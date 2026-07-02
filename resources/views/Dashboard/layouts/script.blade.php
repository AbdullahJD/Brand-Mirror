<!--begin::Javascript-->
	<script>var hostUrl = "{{ URL::asset('assets/') }}";</script>
	<!--begin::Global Javascript Bundle(used by all pages)-->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<script src="{{ URL::asset('assets/plugins/global/plugins.bundle.js') }}"></script>
	<script src="{{ URL::asset('assets/js/scripts.bundle.js') }}"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Vendors Javascript(used by this page)-->
	<script src="{{ URL::asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
	<script src="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
	<!--end::Page Vendors Javascript-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<script src="{{ URL::asset('assets/js/widgets.bundle.js') }}"></script>
	<script src="{{ URL::asset('assets/js/custom/widgets.js') }}"></script>
	<script src="{{ URL::asset('assets/js/custom/apps/chat/chat.js') }}"></script>
	<script src="{{ URL::asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
	<script src="{{ URL::asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
	<script src="{{ URL::asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
	<!--end::Page Custom Javascript-->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<script src="{{ URL::asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
	<script src="{{ URL::asset('assets/js/custom/apps/ecommerce/catalog/products.js') }}"></script>

	{{-- <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
	<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> --}}
	{{-- <script>
		window.Pusher = Pusher;

		window.Echo = new Echo({
			broadcaster: 'reverb',
			key: '{{ env("REVERB_APP_KEY") }}',
			wsHost: window.location.hostname,
			wsPort: 8080,
			forceTLS: false,
			disableStats: true,
		});

		window.Echo.private('admin.orders')
			.listen('.order.created', (e) => {
				console.log('NEW ORDER:', e);
				alert("New Order: " + e.order_number);
			});
	</script> --}}

	<script>
		toastr.options = {
			"closeButton": true,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"timeOut": "3000"
		};
	</script>

	@if(session('success'))
		<script>
			toastr.success("{{ session('success') }}");
		</script>
	@endif

	@if(session('updated'))
		<script>
			toastr.info("{{ session('updated') }}"); // 🔵 تعديل
		</script>
	@endif

	@if(session('deleted'))
		<script>
			toastr.error("{{ session('deleted') }}"); // 🔴 حذف
		</script>
	@endif

	@if(session('error'))
		<script>
			toastr.error("{{ session('error') }}");
		</script>
	@endif

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	@stack('scripts')

<!--end::Javascript-->

<script>
const adminMessages = {
    infoKeyPlaceholder: @json(__('messages.info_key_placeholder')),
    infoValuePlaceholder: @json(__('messages.info_value_placeholder')),
    removeShort: @json(__('messages.remove_short')),
    submitting: @json(__('messages.submitting')),
};

function buildInfoRow(keyName, valueName) {
    return `
        <div class="row mb-2">
            <div class="col-md-5">
                <input type="text"
                       name="${keyName}"
                       class="form-control"
                       placeholder="${adminMessages.infoKeyPlaceholder}">
            </div>

            <div class="col-md-5">
                <input type="text"
                       name="${valueName}"
                       class="form-control"
                       placeholder="${adminMessages.infoValuePlaceholder}">
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger remove-info">
                    ${adminMessages.removeShort}
                </button>
            </div>
        </div>
    `;
}

document.addEventListener('click', function(e){
    const addButton = e.target.closest('[data-add-info]');

    if (addButton) {
        const wrapper = document.getElementById(addButton.dataset.addInfo);

        if (! wrapper) {
            return;
        }

        wrapper.insertAdjacentHTML(
            'beforeend',
            buildInfoRow(addButton.dataset.infoKeyName, addButton.dataset.infoValueName)
        );

        return;
    }

    if(e.target.classList.contains('remove-info')){
        e.target.closest('.row').remove();
    }
});
</script>


<script>
document.addEventListener("submit", function (e) {
    const form = e.target;

    if (form.tagName === "FORM") {
        const btn = form.querySelector("button[type='submit']");

        if (btn) {
            btn.disabled = true;
            btn.innerText = adminMessages.submitting;
        }
    }
});
</script>
