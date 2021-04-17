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

<h1>{{__('messeg.add your offer')}}</h1>
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{Session::get('success')}}
</div>
@endif
<br>
<form method="POST" action="{{route('offers.store')}}" enctype="multipart/form-data">
    @csrf
{{-- <input name="_token" value="{{csrf_token()}}">--}}

    <div class="form-group">
        <label for="exampleInputEmail1">choose photo</label>
        <input type="file" class="form-control" name="photo" aria-describedby="emailHelp" >
        @error('photo')
        <small class="form-text text-danger" >{{$message}}</small>
        @enderror
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">{{__('messeg.Offer Name ar')}}</label>
      <input type="text" class="form-control" name="name_ar" aria-describedby="emailHelp" placeholder="Enter email">
        @error('name_ar')
        <small class="form-text text-danger" >{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">{{__('messeg.Offer Name en')}}</label>
        <input type="text" class="form-control" name="name_en" aria-describedby="emailHelp" placeholder="Enter email">
        @error('name_en')
        <small class="form-text text-danger" >{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">{{__('messeg.Offer Price')}}</label>
      <input type="text" class="form-control" name="price" placeholder="price">
        @error('price')
        <small class="form-text text-danger" >{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
          <label for="exampleInputPassword1">{{__('messeg.Offer details ar')}}</label>
          <input type="text" class="form-control" name="details_ar" placeholder="details">
        @error('details_ar')
        <small class="form-text text-danger" >{{$message}}</small>
        @enderror
        </div>
    <div class="form-group">
        <label for="exampleInputPassword1">{{__('messeg.Offer details en')}}</label>
        <input type="text" class="form-control" name="details_en" placeholder="details">
        @error('details_en')
        <small class="form-text text-danger" >{{$message}}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">save</button>
</form>
</body>
