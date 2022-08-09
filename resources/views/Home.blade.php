@extends('Layouts.app')
@section('title','Home')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-3 p-2">
			<div class="card">
				<div class="card-body">
					<h3 class="count-card-title">{{$total}}</h3>
					<h3 class="count-card-text">Total Visitor</h3>
				</div>
			</div>
		</div>
        <div class="col-md-3 p-2">
			<div class="card">
				<div class="card-body">
					<h3 class="count-card-title">{{$service}}</h3>
					<h3 class="count-card-text">Total Service</h3>
				</div>
			</div>
		</div>
        <div class="col-md-3 p-2">
			<div class="card">
				<div class="card-body">
					<h3 class="count-card-title">{{$project}}</h3>
					<h3 class="count-card-text">Total project</h3>
				</div>
			</div>
		</div>
    </div>
	<div class="row justify-content-center">
        <div class="col-md-3 p-2">
			<div class="card">
				<div class="card-body">
					<h3 class="count-card-title">{{$course}}</h3>
					<h3 class="count-card-text">Total course</h3>
				</div>
			</div>
		</div>
        <div class="col-md-3 p-2">
			<div class="card">
				<div class="card-body">
					<h3 class="count-card-title">{{$contact}}</h3>
					<h3 class="count-card-text">Total contact</h3>
				</div>
			</div>
		</div>
        <div class="col-md-3 p-2">
			<div class="card">
				<div class="card-body">
					<h3 class="count-card-title">Add New</h3>
					<h3 class="count-card-text">Coming Soon</h3>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection