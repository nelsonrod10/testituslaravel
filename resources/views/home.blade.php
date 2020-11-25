@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="w-full md:px-2 md:mx-auto">
            <div class="flex flex-col break-words bg-white border-2 rounded shadow-md">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                    {{__('Dashboard')}}
                </div>

                <div class="w-full p-6">
                    <resource-index></resource-index>  
                </div>
            </div>
        </div>
    </div>
@endsection

