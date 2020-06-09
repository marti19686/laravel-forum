@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="panel-body p-3">
                        <form  method="POST" action="/threads">
                            @csrf

                            <div class="form-group">
                                <label for="chanel_id">Choose a channel:</label>
                                <select name="chanel_id" id="chanel_id" class="form-control" required>
                                    <option value="">Choose One...</option>

                                    @foreach($chanels as $chanel)
                                        <option value="{{ $chanel->id }}" {{ old('chanel_id')  == $chanel->id ? 'selected':''}}>{{ $chanel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea name="body" id="body" class="form-control" rows="8" required>{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </form>

                        @if (count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
