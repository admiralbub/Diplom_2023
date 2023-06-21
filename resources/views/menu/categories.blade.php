<ul class="nav flex-column">
  @foreach($categories as $category)
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="/categories/{{$category->id}}">{{$category->name_categories}}</a>
    </li>
  @endforeach
</ul>