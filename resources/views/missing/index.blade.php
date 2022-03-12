@extends('layout.default')

@section('title')
	<title>Missing Media</title>
@endsection

@section('breadcrumb')
	<li>
		<a href="{{ route('missing.index') }}" itemprop="url" class="l-breadcrumb-item-link">
			<span itemprop="title" class="l-breadcrumb-item-link-title">Missing Media</span>
		</a>
	</li>
@endsection

@section('content')
	<style>
        td {
            vertical-align: middle !important;
        }
	</style>
	@livewire('missing-media-search')
@endsection