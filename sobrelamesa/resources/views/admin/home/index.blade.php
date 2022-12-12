@extends('admin.template.main')
@section('title','Sobre La Mesa | Admin')
@section('css')
<style>
</style>
@endsection
@section('modal')

@endsection
@section('content')

<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <!--<a href="../../index2.html"><b>Admin</b>LTE</a>-->
    <a href="{{route('inicio.index')}}">
        <img src="{{asset('images/icons/icono_logo.jpeg')}}" class="img-thumbnail rounded" alt="logo" width="
        200">
        <span class="brand-text font-weight-light"></span>
      </a>
  </div>
  <!-- User name -->
  <!--<div class="lockscreen-name">John Doe</div>-->
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2021 <b><a href="https://bigtech.com.mx/" class="text-black">BigTech</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->


@endsection
@section('js')
<script type="text/javascript">
	$('#menu_panel').attr('class','nav-link active');
	$( document ).ready(function() {
		
	});
</script>
@endsection