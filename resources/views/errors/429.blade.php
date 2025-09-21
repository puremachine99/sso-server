@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Terlalu banyak permintaan. Silakan coba lagi nanti.'))
