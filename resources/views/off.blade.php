@php
  $style = $attributes->get('style', 'width:100%;min-height:400px;display:flex;justify-content: center;align-items: center;font-size: calc(1rem + 1vmin);color: #ccc;font-style: italic;');
  $content = $slot;
  if ($content->isEmpty()) {
    $content = !empty($message)
    ? $message
    : 'Metabase is disabled on local\'s environment';
  }
@endphp
<div {{ $attributes->except(['style']) }} style="{{ $style }}">
  {{ $content }}
</div>
