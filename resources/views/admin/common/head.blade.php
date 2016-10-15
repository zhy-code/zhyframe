<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<title>@yield('web_title')</title>
	<meta name="keywords" content=@yield('web_keywords')>
	<meta name="description" content="@yield('web_description')">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css?v=3.3.6') }}" />
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css?v=4.4.0') }}" />
	<link rel="stylesheet" href="{{ asset('css/animate.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/style.min.css?v=4.1.0') }}" />
	<link rel="stylesheet" href="{{ asset('css/z-self.css') }}" />
	@section('head')

	@show
</head>