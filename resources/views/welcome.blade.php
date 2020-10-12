<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trekksoft</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
</head>
<body class="text-center">
    <form action="{{ route('send.command') }}" method="post" class="col-10">
        @csrf

        <div class="form-group text-left">
          <h3>Backend Interview Challenge</h3>
            <small>
                <p>
                    ## The challenge<br>
                    A squad of robotic discovery rovers are to be landed by SpaceX on an specific area on Mars. This area, which is curiously rectangular, must be navigated by the rovers so that their on-board webcams and detectors can get a complete view of the surrounding terrain.<br>
                    A rover’s position and location is represented by a combination of x and y coordinates and a letter representing one of the four cardinal compass points. The area is divided up into a grid to simplify the navigation. An example position might be 0, 0, N, which means the rover is in the bottom left corner and facing North.<br>
                    In order to control a rover, SpaceX sends a simple string of letters as a message. The possible letters are ‘R’, ‘L’ and ‘M’. ‘R’ and ‘L’ make the rover spin 90 degrees left or right respectively, without moving from its current spot. ‘M’ means move forward one grid point, and maintain the same heading.
                </p>
                <p>
                    ## INPUT:<br>
                    The first line of input is the upper-right coordinates of the area, the lower-left coordinates are assumed to be 0,0. The rest of the input is information pertaining to the rovers that have been deployed. Each rover has two lines of input.The first line gives the rover’s position, and the second line is a series of instructions telling the rover how to explore the area. The position is made up of two integers and a letter separated by spaces, corresponding to the x and y co-ordinates and the rover’s orientation. Each rover will be finished sequentially, which means that the second rover won’t start to move until the first one has finished moving.<br><br>                ## OUTPUT<br>
                    The output for each rover should be its final co-ordinates and heading.
                </p>
                <p>
                    # Test Input:<br>
                    5 5<br>
                    1 2 N<br>
                    LMLMLMLMM<br>
                    3 3 E<br>
                    MMRMMRMRRM<br><br>

                    # Expected Output:<br>
                    1 3 N<br>
                    5 1 E
                </p>
            </small>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
            </div>
        @endif
        @isset($position)
            <div class="alert alert-success">
                {!! $position !!}
            </div>
        @endisset

        <div class="form-group">
          <label for="instructions">Rover Instructions</label>
          <textarea class="form-control" id="instructions" name="commands" cols="30" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-default">Send</button>
    </form>
</body>
</html>
