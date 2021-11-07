@extends('interface.main')

@section('page')
    @includeWhen(Cookie::get('role') == 'End User',"enduser.$module")
    @includeWhen(Cookie::get('role') == 'Logistics Officer', "logisticsofficer.$module")
@endsection

