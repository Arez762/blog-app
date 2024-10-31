<x-app-layout>


@section('content')
<div class="container">
    <h1>{{ $news->title }}</h1>
    <p>Category: {{ $news->category->name }}</p>
    <p>Author: {{ $news->user->name }}</p>


    <div class="my-4">
        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="Thumbnail" class="img-fluid">
    </div>

    <div class="content">
        <p>{!! nl2br(e($news->content)) !!}</p>
    </div>

    @if($news->addImage)
        <div class="gallery mt-4">
            <h4>Additional Images</h4>
            <div class="row">
                @foreach($news->addImage as $image)
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('storage/' . $image) }}" alt="Additional Image" class="img-fluid">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <a href="{{ route('news.index') }}" class="btn btn-secondary mt-4">Back to News</a>
</div>


</x-app-layout>