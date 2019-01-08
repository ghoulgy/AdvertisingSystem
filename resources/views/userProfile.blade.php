@extends('layouts.user')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-3 col-md-offset-2" align="center">
			<img src="/uploads/avatars/{{ $user->avatar }}"
				style="width:150px;height:150px;border-radius:50%;margin-right:20px" alt="{{ $user->name }}'s profile picture"> 
			<h2>{{ $user->name }}'s profile</h2>
			<form enctype="multipart/form-data" action="{{ url('/profile') }}" method="POST">
				<input type="file" name="avatar">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="submit" class="pull-right btn btn-sm btn-primary">
			</form>
		</div>
	</div>
	<div class="row">
		{{-- <div class="col-md-9 col-lg-9">  --}}
			<table class="table table-user-information">
		        <tbody>
		      		<tr>
			            <td>Department:</td>
			            <td>Programming</td>
		      		</tr>
		          	<tr>
			            <td>Hire date:</td>
			            <td>06/23/2013</td>
		          	</tr>
		          	<tr>
		            	<td>Date of Birth</td>
		            	<td>01/24/1988</td>
		          	</tr>
		         	<tr>
		                <td>Gender</td>
		                <td>Female</td>
		          	</tr>
		            <tr>
			            <td>Home Address</td>
			            <td>Kathmandu,Nepal</td>
		      		</tr>
					<tr>
						<td>Email</td>
						<td><a href="mailto:info@support.com">info@support.com</a></td>
					</tr>
					<tr>
		                <td>Phone Number</td>
		                <td>123-4567-890(Landline)<br><br>555-4567-890(Mobile)
		                </td>
					</tr>
		        </tbody>
		  	</table>
		{{-- </div> --}}
	</div>
</div>
@endsection