@extends('layouts.app')

@section('content')
    <nav class="chips">
        <a href="{{ route('courses.index') }}"
           class="chip {{ $selectedCategoryId === null ? 'chip-active' : '' }}">All</a>

        @foreach ($categories as $category)
            <a href="{{ route('courses.index', ['category' => $category->id]) }}"
               class="chip {{ $selectedCategoryId === $category->id ? 'chip-active' : '' }}">{{ $category->name }}</a>
        @endforeach
    </nav>

    <div class="course-list">
        @forelse ($courses as $course)
            @include('courses.partials.course-card', ['course' => $course])
        @empty
            <p class="empty-message">No courses found</p>
        @endforelse
    </div>
@endsection
