<nav>
  @foreach(Navigation::make()->tree() as $item)
    <a href="{{ $item->url }}" @class(['active' => $item->active])>
      {{ $item->title }}
    </a>
  @endforeach
</nav>
