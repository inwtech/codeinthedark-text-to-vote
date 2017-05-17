<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Begin page content -->
<div class="container">
    <form method="POST">
        <h2>Current Round Breakdown</h2>
        {{ json_encode(\App\Round::active_vote_breakdown(true)) }}

        <h2>Create new Round</h2>

        <div class="form-group">
            <label for="exampleInputEmail1">Number of seats for new round</label>
            <select name="seats" class="form-control">
                <option value="" selected="selected">--Select One--</option>
                @for ($i = 2; $i < 15; $i++)
                    <option value="{{ $i }}">{{ $i }} Seats</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="btn btn-info">Create New Round</button>

        <div class="form-group">
            <label for="exampleInputEmail1">Active Round:</label>
            <select name="active_round" class="form-control">
                <option value="" selected="selected">--Select One--</option>
                @foreach (\App\Round::all() as $round)
                    <option value="{{ $round->getKey() }}">Round #{{ $round->getKey() }}; total votes - {{ $round->vote_count() }}; seats: {{ $round->seats }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-info">Update Active Round</button>

        {{ csrf_field() }}
    </form>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>