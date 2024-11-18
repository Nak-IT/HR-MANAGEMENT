@extends('layout.layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/ModalDetail2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">
<style>
    
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/PrintReport.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/printThis.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{ asset('lib/choices.js/js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">
@endpush

@section('content')
<div class="container mt-5" style="border: 2px dashed #87ceeb; border-radius: 15px; padding: 15px; background-color: #e6f3ff;">
    <h2 class="custom-font007" style="border: 3px solid #ff69b4; border-radius: 25px; padding: 25px; background-color: #fff0f5; box-shadow: 0 6px 12px rgba(255,105,180,0.2), 0 8px 16px rgba(255,20,147,0.2); transition: all 0.4s ease; text-align: center; margin-bottom: 30px; color: #ff1493; text-shadow: 2px 2px 4px rgba(255,105,180,0.3);">
        <span style="font-size: 1.2em;">📊</span> របាយការណ៍ <span style="font-size: 1.2em;">📈</span>
    </h2>
    <br><br><br><br>
    <div class="list-group1">
        <div class="form-group row justify-content-center">
            <div class="col-sm-8">
                <a href="{{ route('EmployedReport.detail') }}" class="custom-list-item1 clickable3"style="border: 3px solid #ff69b4; border-radius: 25px; padding: 25px; background-color: #fff0f5; box-shadow: 0 6px 12px rgba(255,105,180,0.2); transition: all 0.4s ease;">
                    <span class="custom-font006">🟧 របាយការណ៏បែបទី១   🟦<i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                </a>
            </div>
        </div><br><br><br><br>
        <div class="form-group row justify-content-center">
            <div class="col-sm-8">
                <a href="{{ route('EmployedReport.detail_second') }}" class="custom-list-item1 clickable3" style="border: 3px solid #ff69b4; border-radius: 25px; padding: 25px; background-color: #fff0f5; box-shadow: 0 6px 12px rgba(255,105,180,0.2); transition: all 0.4s ease;">
                    <span class="custom-font006">🟨 របាយការណ៏បែបទី២   🟩<i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                </a>
            </div>
        </div><br><br><br><br>
    </div>
</div>

@endsection
