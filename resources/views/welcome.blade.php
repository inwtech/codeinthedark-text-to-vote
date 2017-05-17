<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
    <title>Code in the Dark</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" src="./js/protovis-r3.3.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/css/main.css" media="screen">
</head>
<body>
<div id="container">
    <h1>Text seat number to <strong>{{ config('app.phone_number') }}</strong></h1>
    <div id="results">
        <script type="text/javascript+protovis">
            var data = {!! $data !!};

            /* Protovis wizardy by Will Light (http://williamlight.net) */

            /* Sizing and scales. */
            var w = 700,
                h = 400,
                x = pv.Scale.linear(0, (pv.max(data) == 0 ? 1 : pv.max(data))).range(0, w),
                y = pv.Scale.ordinal(pv.range(data.length)).splitBanded(0, h, 4/5);

            /* The root panel. */
            var vis = new pv.Panel()
                .width(w)
                .height(h)
                .bottom(20)
                .left(90)
                .right(40)
                .top(5);

            /* The bars. */
            var bar = vis.add(pv.Bar)
                .data(function() data)
                .top(function() y(this.index))
                .height(y.range().band)
                .left(60)
                .width(x);

            /* Y-axis label */
            vis.add(pv.Label)
                .data(["Seat Number"])
                .left(-63)
                .bottom(h/2)
                .font("30px Helvetica")
                .textAlign("center")
                .textAngle(-Math.PI/2);

            /* The variable label. */
            var what = bar.anchor("left")
                .add(pv.Bar)
                .width(function() this.root.left())
                .height(y.range().band)
                .top(function() y(this.index))
                .fillStyle("rgba(0, 0, 0, 0)");

            bar.anchor("left").add(pv.Label)
                .textMargin(5)
                .left(55)
                .textAlign("right")
                .font("bold 30px Helvetica")
                .text(function() this.index + 1);

            vis.render();
            getData();

            function getData() {
                $.getJSON ("/get-votes", function (d) {
                    if (data.length != d.length) {
                        window.location = window.location;

                        return;
                    }

                    data = d;
                    x = pv.Scale.linear(0, (pv.max(data) == 0 ? 1 : pv.max(data))).range(0, w);
                    bar.width(x);

                    vis.transition()
                        .duration(500)
                        .ease("elastic-out")
                        .start();
                });
            }

            setInterval(function() { getData(); }, 2000);
        </script>
    </div>
</div>
</body>
</html>
