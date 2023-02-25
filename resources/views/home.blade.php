@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row justify-content-center text-center">
		<div class="
		@can('isEditor')
		col-md-5
		@else
		col-md-3
		@endcan
		">
			<p>
				<h1>Home</h1>
			</p>
			<div class="card bg-transparent">
				<div class="card-body">
					<div class="d-flex justify-content-between">
						<button type="button" class='btn btn-lg btn-outline-secondary' onClick='location.href="{{ route('shift.calendar.edit') }}"'>
							シフト提出
						</button>
						
						<button type="button" class='btn btn-lg btn-outline-secondary' onClick='location.href="{{ route('shift.check') }}"'>
							シフト確認
						</button>
						
						@can('isEditor')
						<button type="button" class='btn btn-lg btn-outline-secondary' onClick='location.href="{{ route('shift.confirm.get') }}"'>
							シフト作成
						</button>
						
						<button type="button" class='btn btn-lg btn-outline-secondary' onClick='location.href="{{ route('user.home') }}"'>
							従業員管理
						</button>
						@endcan
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.row::before, .row::after {
		display: none;
	}
</style>
@endsection
