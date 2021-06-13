@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')

<?php use \App\Tweet; ?>
 @foreach($favorite_tweets as $favorite_tweet)
    <a href="https://twitter.com/{{ $favorite_tweet->user_screen_name }}/status/{{ $favorite_tweet->tweet_id }}">{{ $favorite_tweet->tweet_id }}<a><br>
    
    @php
    $exists = Tweet::where('oembed_url', "https://twitter.com/{{ $favorite_tweet->user_screen_name }}/status/{{ $favorite_tweet->tweet_id }}")->exists();
        if(!$exists) {
        $oembed = \Twitter::get('statuses/oembed', ['url' => "https://twitter.com/$favorite_tweet->user_screen_name/status/$favorite_tweet->tweet_id"])->html;
        Tweet::where('tweet_id', $favorite_tweet->tweet_id)->update(['oembed_url' => $oembed]);
        }
    
    @endphp
    
    {!! Tweet::where('tweet_id', $favorite_tweet->tweet_id)->value('oembed_url'); !!}
 @endforeach

@endsection