@extends('interface.main')

@section('page')
    @includeWhen(Cookie::get('role') == 'End User',"ris.enduser.$module")
    @includeWhen(Cookie::get('role') == 'Logistics Officer', "ris.logisticsofficer.$module")
@endsection

