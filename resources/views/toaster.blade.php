<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<!-- Toastr -->
<script>
    var notyf = new Notyf();

    // success message popup notification
    @if(session()->has('success'))
    notyf.success("{{ session()->get('success') }}");
    @endif

    // info message popup notification
    @if(session()->has('info'))
    notyf.info("{{ session()->get('info') }}");
    @endif

    // warning message popup notification
    @if(session()->has('warning'))
    notyf.warning("{{ session()->get('warning') }}");
    @endif

    // error message popup notification
    @if(session()->has('error'))
    notyf.error("{{ session()->get('error') }}");
    @endif
</script>
