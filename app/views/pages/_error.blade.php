@extends('layouts._error')
@section('title',$exception->getMessage())
@section('content')
<section class="row flexbox-container mx-0">
    <div class="col-xl-7 cl-md-8 col-12 d-flex justify-content-center ">
        <div class="card-content">
            <div class="card-body text-center">
                <img src="/assets/images/pages/404.png" class="img-fluid align-self-center" alt="branding logo">
                <h1 class="font-large-2 my-1">{{$exception->getCode()}} - {{$exception->getMessage() }}</h1>
                <p class="p-2">
                    We're sorry, the page you requeste could not be found. PLease go back to homepage or contact us at
                    <a href="mailto:<?= $_ENV["EMAIL"] ?? "example@example.com" ?>"><?= $_ENV["EMAIL"] ?? "example@example.com" ?></a>
                </p>
                <a class="btn btn-primary btn-lg mt-2 waves-effect waves-light" href="/">Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection
