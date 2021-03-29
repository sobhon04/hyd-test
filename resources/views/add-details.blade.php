@extends('layouts.app')

@section('content')
<style type="text/css">
#map { height: 100%; }
#stepInfo{ background-color: #fff; font-family: Roboto; font-size: 15px;
    font-weight: 300; margin-left: 10px; margin-top: 10px;
    text-overflow: ellipsis; width: 300px; position: absolute; top: 7px;
}
.routesegment {
    background: #141414 none repeat scroll 0 0;  border-radius: 5px 5px 0 0; color: #fff;
    display: inline-block;  font-size: 15px; font-weight: bold; height: 23px;
    padding: 6px; width: 290px;
}
.routeinfo { height: 400px; overflow: auto; padding: 5px; font-size: 13px; }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Add  Details') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('add-post-details') }}">
                        @csrf

                        <div id="stepInfo" style="display: none;"></div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">{{ __('Name') }}</label>
                            <div class="">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="col-form-label">{{ __('Mobile') }}</label>
                            <div class="">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" autocomplete="new-mobile">
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">{{ __('Route Details') }}</label>
                            <div class="row">
                                <div class="col">
                                    <input id="source" type="text" class="form-control @error('source') is-invalid @enderror" name="source" placeholder="Source" autocomplete="new-source" value="{{ old('source') }}" required>
                                    @error('source')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input id="destination" type="text" class="form-control @error('destination') is-invalid @enderror" placeholder="Destination" name="destination" value="{{ old('destination') }}" autocomplete="new-destination" required>
                                    @error('destination')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-auto">
                                    <div id="icon"><input type="button" name="search" class="btn btn-primary mb-2" value="search" id="directionclick"/></div>
                                </div>
                            </div>

                            <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                            <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger btn-block">
                                    {{ __('Save Data') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('js/gmap.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initiatlizemap"
         async defer>
  </script>

  @endsection

