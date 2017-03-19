<!DOCTYPE html>
<html>
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('js/cube.js') }}"></script>
	</head>
	<body>
			{{ Form::open(array('id' => 'cubeForm', null, 'onsubmit' => 'validate(); return false;')) }}
			{{ Form::label('inputTextLabel', 'Input text:') }}
			{{ Form::textarea('inputText', null, ['size' => '30x15']) }}
			{{ Form::submit('Submit') }}
			{{ Form::close() }}
			<p id="errorMessage"></p>
			{{ Form::open() }}
			{{ Form::label('outputTextLabel', 'Output:') }}
			{{ Form::textarea('outputText', null, ['size' => '30x15']) }}
			{{ Form::close() }}
	</body>
</html>