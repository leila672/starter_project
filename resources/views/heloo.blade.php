<!DOCTYPE html>
<head>


</head>
<body>

<h1> {{__('messeg.hello')}} </h1>

{{-- <p>{{$obj -> name}} -- {{$obj -> id}} </p> --}}

@if($name == 'leila')
    <p> yes i am </p>
@else
    <p> no </p>
@endif 

</body>