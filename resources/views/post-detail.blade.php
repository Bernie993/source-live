@extends('layouts.app')

@section('title', $post->title . ' - U888')

@section('content')
<style>
    .post-detail-container {
        margin: 40px auto;
        padding: 0 20px;
    }

    .post-detail-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .post-detail-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #fff;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .post-detail-meta {
        color: #ccc;
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .post-detail-meta i {
        margin-right: 5px;
    }

    .post-detail-meta span {
        margin: 0 15px;
    }

    .post-detail-featured-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .post-detail-content {
        background: rgba(255, 255, 255, 0.95);
        padding: 40px;
        border-radius: 12px;
        color: #333;
        line-height: 1.8;
        font-size: 1.1rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .post-detail-content h1,
    .post-detail-content h2,
    .post-detail-content h3 {
        color: #FF4500;
        margin-top: 30px;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .post-detail-content p {
        margin-bottom: 20px;
    }

    .post-detail-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }

    .post-detail-content a {
        color: #FF4500;
        text-decoration: underline;
    }


    .post-detail-back {
        display: inline-block;
        margin: 30px 0;
        padding: 12px 30px;
        background: linear-gradient(135deg, #FF4500 0%, #FF6347 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 69, 0, 0.4);
    }


    @media (max-width: 768px) {
        .post-detail-title {
            font-size: 1.8rem;
        }

        .post-detail-content {
            padding: 25px;
            font-size: 1rem;
        }
    }
</style>

<div class="post-detail-container">
    <a href="{{ route('homepage') }}" class="post-detail-back">
        <i class="fas fa-arrow-left"></i> Quay lại Trang chủ
    </a>

    <article class="post-detail">
        <div class="post-detail-header">
            <h1 class="post-detail-title">{{ $post->title }}</h1>
            <div class="post-detail-meta">
                <span>
                    <i class="far fa-calendar"></i>
                    {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : $post->created_at->format('d/m/Y H:i') }}
                </span>
                @if($post->author)
                <span>
                    <i class="far fa-user"></i>
                    {{ $post->author->name }}
                </span>
                @endif
            </div>
        </div>

        @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" 
             alt="{{ $post->title }}" 
             class="post-detail-featured-image">
        @endif

        @if($post->short_description)
        <div class="post-detail-content">
            <p><strong><em>{{ $post->short_description }}</em></strong></p>
            <hr>
            {!! nl2br(e($post->content)) !!}
        </div>
        @else
        <div class="post-detail-content">
            {!! nl2br(e($post->content)) !!}
        </div>
        @endif
    </article>

    <a href="{{ route('homepage') }}" class="post-detail-back">
        <i class="fas fa-arrow-left"></i> Quay lại Trang chủ
    </a>
</div>
@endsection


