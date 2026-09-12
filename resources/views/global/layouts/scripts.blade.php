<script>
    const baseUrl = "{{ url('/') }}";
    const csrfToken = "{{ csrf_token() }}";
    const toastText = `{{ session('toast') }}`;
</script>

<script src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastify/toastify-js.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('assets/js/main.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>

@stack('scripts')
