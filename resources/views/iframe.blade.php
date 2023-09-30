@php
  $defaultAttrs = [
    'width' => '100%',
    'height' => '400px',
    'style' => 'border:0',
    'onload' => 'iFrameResize({}, this)'
  ];
@endphp
<iframe src="{{ $iframeUrl }}" {{ $attributes->merge($defaultAttrs) }} allowtransparency></iframe>

@pushonce('js')
  <script src="{{ metabaseAsset('app/iframeResizer.js') }}"></script>
@endpushonce
