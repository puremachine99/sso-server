@extends('errors.minimal')

@section('title', 'Link reset tidak valid')
@section('code', '410') {{-- 410 Gone: link sudah tidak berlaku --}}
@section('heading', 'Halaman ini tampaknya tidak ada.')
@section('description', 'Tautan reset password tidak valid, telah kedaluwarsa, atau sudah digunakan.')

@section('actions')
    <a href="{{ route('login') }}"
       class="inline-flex items-center gap-2 rounded-md bg-indigo-500 px-4 py-2 text-white
              hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ml-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                  d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4A1 1 0 018 6v2h7a1 1 0 011 1v2a1 1 0 01-1 1H8v2a1 1 0 01-.293.707z"
                  clip-rule="evenodd" />
        </svg>
        Kembali Ke Halaman Login
    </a>
@endsection
