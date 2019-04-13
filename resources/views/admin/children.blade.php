@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card">
						@auth
							<div class="card-header">
								<h5 style="float: left; margin-top: 10px;">Dzieciaki</h5>
									<form action="{{ route('birthdays') }}" method="get">
										<button type="submit" class="btn btn-outline-primary" style="float: right; margin-right: 10px; margin-top: 3px;">Powrót</button>
									</form>
								@if(Auth::user()->isAdmin())
									<form action="{{ route('showRegisterChildren') }}" method="get">
										<button id="addUser" type="submit" class="btn btn-outline-success" style="float: right; margin-top: 3px;">Dodaj dzieciaka</button>
									</form>
								@endif
							</div>
							<div class="card-body inner-users">

								@include('flash-messages')
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Imię</th>
											<th scope="col">Urodziny</th>
											<th scope="col">Akcje</th>

										</tr>
									</thead>
									<tbody>
										@foreach($children as $key => $user)
											<tr>
												<td>
													{{ $user->name }}
												</td>
												<td>
													<span class="oldBirthday">{{ $user->birthday }}</span>
													<form class="editUserForm" id="{{ $user->id }}" action="{{ route('saveEditUserBirthday', ['id' => $user->id]) }}" method="get">
														<div class="form-group row">
															<label for="birthday" ></label>
															<div class="col-md-10">
																<input type="date" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }} birthday" value="{{ $errors->has('birthday') ? old('birthday') : $user->birthday }}"  name="birthday">
																<input type="hidden" value="{{ $user->id }}" name="userId">
															</div>

															<button type="submit" class="saveEditUser btn" >
																<i class="fas fa-save"></i>
															</button>

														</div>
													</form>
												</td>
												<td>
													<span class="cancelEdit">
														<b>A n u l u j</b>
													</span>
													<span class="editUser">
														<i class="fas fa-edit"></i>
													</span>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<a onclick="return confirm('Czy napewno chcesz usunąć tego dzieciaka?')"
													   href="{{ route('deleteChildren', ['id' => $user->id]) }}" class="deleteUser">
														<i class="fas fa-times"></i>
													</a>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@endauth
					</div>
				</div>
			</div>
		</div>
	</main>
<script>


    $( document ).ready(function() {
        $('.editUser').click(function () {
            var $this = $(this);
            var oldBirthday = $this.parent().parent().find('.oldBirthday');
			var form = $this.parent().parent().find('.editUserForm');
			var cancel = $this.parent().parent().find('.cancelEdit');
			cancel.show();
            form.show();
            oldBirthday.hide();
            $('.editUser').hide();
            $('.deleteUser').hide();
        });

        $('.cancelEdit').click(function () {
            var $this = $(this);
            var oldBirthday = $this.parent().parent().find('.oldBirthday');
            var form = $this.parent().parent().find('.editUserForm');
            $('.cancelEdit').hide();
            form.hide();
            oldBirthday.show();
            $('.editUser').show();
            $('.deleteUser').show();
        });

        @if($errors->has('birthday'))
			var form = $('#{{ old('userId') }}');
        	form.show();
        	var oldBirthday = form.parent().find('.oldBirthday');
        	var birthday = '{{ old('birthday') }}';
        	oldBirthday.hide();
			$('.editUser').hide();
			$('.deleteUser').hide();
			$('#alert-{{ old('userId') }}').show();
		@endif
    });

</script>
@endsection

