<!DOCTYPE html>
<html lang="zh-cn">
<head>
<title>{{ Config::get('cloudsystem.site_name') }}</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css-v=3.3.5.css') }}" />
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css-v=4.4.0.css') }}" />
<link rel="stylesheet" href="{{ asset('css/animate.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.min.css-v=4.0.0.css') }}" />
<link rel="stylesheet" href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" />
<link rel="stylesheet" href="{{ asset('css/public.css') }}" />

@section('head')

@show
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
</head>
<body class="fixed-sidebar full-height-layout gray-bg  pace-done">
<div id="wrapper">