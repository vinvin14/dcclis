@extends('layout.app-sbamin')
@section('content')
    
    <div class="container d-flex justify-content-center" style="margin-top:20vh">
        <div class="card w-50 shadow-sm">
            <div class="card-body text-center">
                <h4 class="text-center">Verify Account</h4>
                <p class="font-italic">The system has detected that you have been granted multiple roles, for us to proceed please choose your primary role</p>
                <form action="{{route('account.role.confirm')}}" method="get">
                    <div class="px-5">
                        @foreach ($roles as $role)
                        <div class="form-check align-items-start">
                            <input class="form-check-input" type="radio" name="role" id="flexRadioDefault1" value="{{ $role->id }}">
                            <label class="form-check-label" for="flexRadioDefault1">
                                  {{$role->name}}
                            </label>
                        </div>
                    @endforeach
                    </div>
                    <button type="type" class="btn btn-block btn-primary mt-3">Confirm</button>
                </form>
            </div>
        </div>
    </div>
    {{-- {{ dd($roles) }} --}}
    {{-- {{ Session::get('haha')}} --}}
@endsection