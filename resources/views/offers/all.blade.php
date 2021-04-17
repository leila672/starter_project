<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="nav-item active">
                    <a class="nav-link" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $properties['native'] }} <span class="sr-only">(current)</span></a>
                </li>
            @endforeach



        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

@if(Session::has('success'))
    <div class="alert alert-success">
            {{Session::get('success')}}
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger">
        {{Session::get('error')}}
    </div>
@endif
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">{{__('messeg.Offer Name')}}</th>
        <th scope="col">{{__('messeg.Offer Price')}}</th>
        <th scope="col">{{__('messeg.Offer details')}}</th>
        <th scope="col">{{__('messeg.picture')}}</th>
        <th scope="col">{{__('messeg.operation')}}</th>



    </tr>
    </thead>
    <tbody>
    @foreach($offers as $offer)
    <tr>
        <th scope="row">{{$offer -> id}}</th>
        <td>{{$offer -> name}}</td>
        <td>{{$offer -> price}}</td>
        <td>{{$offer -> details}}
        <td><img style="" src="{{asset('storage/app/public/Users/'.$offer->photo)}}"></td>

        <td><a href="{{url('offers/edit/'.$offer -> id)}}" class="btn btn-success">{{__('messeg.update')}}</a></td>
        <td><a href="{{route('offers.delete', $offer -> id)}}" class="btn btn-danger">{{__('messeg.delete')}}</a></td>

    </tr>
    @endforeach
    </tbody>
</table>
</body>
