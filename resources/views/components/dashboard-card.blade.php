@props(['href', 'icon', 'title', 'color' => 'gray', 'count' => null])

<a href="{{ $href }}" class="block p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-center">
  <i class="fas fa-{{ $icon }} text-{{ $color }}-600 text-4xl"></i>
  <h3 class="mt-2 text-lg font-semibold text-{{ $color }}-800">{{ $title }}</h3>
  @isset($count)
    <p class="mt-1 text-2xl font-bold">{{ $count }}</p>
  @endisset
</a>
