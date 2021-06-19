@extends('layouts.app')

@section('content')
<h1>Sales Graphs</h1>

<div style="width: 50%">
    {!! $usersChart->container() !!}
</div>
@endsection
