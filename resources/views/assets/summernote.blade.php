@push('assetCss')
    <link href="{{ asset('assets/admin-lte/plugins/summernote/summernote.min.css') }}" rel="stylesheet"/>
@endpush

@push('assetJs')
    <script src="{{ asset('assets/admin-lte/plugins/summernote/summernote.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        $('#summernote').summernote();
      });
    </script>
@endpush
