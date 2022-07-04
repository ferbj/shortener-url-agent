@extends('layouts.app')
@section('content')
  @if(Session::has('notice'))
    <div class="card-panel notice green white-text">{{Session::get('notice')}}</div>
  @endif
  <div class="row">
    <div class="col m12">
      {{Form::model($url, array('route' => 'urls.store'))}}
      <div class="card">
        <div class="card-content">
          <div class="row">
            <div class="col m8 offset-m2 center-align">
              <span class="card-title">Create a new short URL</span>
            </div>
          </div>
          <div class="row">
            <div class="col m6 offset-m2">
              {{ Form::text('original_url', "", array(
                'class' => 'validate form-control',
                'placeholder' => 'Your original URL here')
              )
            }}
          </div>
          <div class="col m2">
            <button type="submit" class="waves-effect waves-light btn">Shorten URL</button>
          </div>
        </div>
        <div class="row">
            <div class="col m5 offset-m2">
            @if($errors->any())
                <p class="red-text">{{$errors->first()}}</p>
            @endif
            </div>
        </div>
      </div>
    </div>
    {{ Form::close()}}
  </div>
</div>
<table class="table highlight responsive-table">
  <thead>
    <tr>
      <th scope="col">Short URL</th>
      <th scope="col">Original URL</th>
      <th scope="col">Created</th>
      <th scope="col">Clicks Count</th>
      <th scope="col">Stats</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($urls as $url)
      <tr>
        <th scope="row"><a href="{{ url($url->short_url) }}" target="_blank">{{ url($url->short_url) }}</a></th>
        <td><a href="{{ $url->original_url }}" target="__blank">{{ $url->original_url }}</a></td>
        <td>{{  $url->created_at->format('M d, Y') }}</td>
        <td>{{ $url->clicks_count }}</td>
        <td>
          <a href="{{ route('urls.show',$url->short_url) }}">
            <svg class="octicon octicon-graph" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true">
              <path fill-rule="evenodd" d="M16 14v1H0V0h1v14h15zM5 13H3V8h2v5zm4 0H7V3h2v10zm4 0h-2V6h2v7z"></path>
            </svg>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
{{$urls->links()}}
@endsection
