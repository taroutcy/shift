@extends('layouts.app')

@section('content')

<div class="container">
	 <!--<div class="row justify-content-center">-->
	 <!--   <div class="col-md-6">-->
	 <!--       <div class="card-columns text-center">-->
	 <!--           <div class="card">-->
	 <!--               <div class="card-body">-->
	 <!--                   <div class="card-title center-block">{{ __('Register') }}</div>-->
	 <!--               </div>-->
	 <!--           </div>-->
	 <!--           <div class="card">-->
	 <!--               <div class="card-body">-->
	 <!--                   <div class="card-title center-block">{{ __('Register') }}</div>-->
	 <!--               </div>-->
	 <!--           </div>-->
	 <!--       </div>-->
	 <!--   </div>-->
	 <!--</div>-->
			
			<div class="row justify-content-center text-center">
			   <div class="col-md-8">
					<div class="row row-cols-1 row-cols-md-2">
						<div class="col mb-5 rounded-4">
							<div class="card">
								<div class="card-body">
									<h5><a href={{ route('shift.post') }}>シフト提出</a></h5>
								</div>
							</div>
						</div>
						<div class="col mb-5">
							<div class="card">
								<div class="card-body">
									<h5>シフト作成</h5>
								</div>
							</div>
						</div>
						<div class="col mb-5">
							<div class="card">
								<div class="card-body">
									<h5>シフト確認</h5>
								</div>
							</div>
						</div>
						<div class="col mb-5">
							<div class="card">
								<div class="card-body">
									<h5><a href={{ route('user.home') }}>従業員管理</h5>
								</div>
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
