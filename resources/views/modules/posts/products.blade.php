@section('meta_title', 'Products')
@section('meta_description', 'Products')
@section('page_title', 'Products')

@foreach($products as $product)
    {!! $product->title !!}
    {!! $product->body !!}
@endforeach
