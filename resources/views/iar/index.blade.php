@extends('interface.main')

@section('page')
    @includeWhen(Cookie::get('role') == 'End User',"iar.enduser.$module")
    @includeWhen(Cookie::get('role') == 'Logistics Officer', "iar.logisticsOfficer.$module")
@endsection

