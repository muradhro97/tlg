<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Id Card</title>

    <style>

        body {
            background-color: #d7d6d3;
            font-family:'verdana';
        }
        .id-card-holder {
            width: 225px;
            padding: 4px;
            margin: 0 auto;
            background-color: #1f1f1f;
            border-radius: 5px;
            position: relative;
        }
        .id-card-holder:after {
            content: '';
            width: 7px;
            display: block;
            background-color: #0a0a0a;
            height: 100px;
            position: absolute;
            top: 105px;
            border-radius: 0 5px 5px 0;
        }
        .id-card-holder:before {
            content: '';
            width: 7px;
            display: block;
            background-color: #0a0a0a;
            height: 100px;
            position: absolute;
            top: 105px;
            left: 222px;
            border-radius: 5px 0 0 5px;
        }
        .id-card {

            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 1.5px 0px #b9b9b9;
        }
        .id-card img {
            margin: 0 auto;
        }
        .header img {
            width: 100px;
            margin-top: 15px;
        }
        .photo img {
            width: 80px;
            margin-top: 15px;
        }
        h2 {
            font-size: 15px;
            margin: 5px 0;
        }
        h3 {
            font-size: 12px;
            margin: 2.5px 0;
            font-weight: 300;
        }
        .qr-code img {
            width: 50px;
        }
        p {
            font-size: 5px;
            margin: 2px;
        }
        .id-card-hook {
            background-color: #000;
            width: 70px;
            margin: 0 auto;
            height: 15px;
            border-radius: 5px 5px 0 0;
        }
        .id-card-hook:after {
            content: '';
            background-color: #d7d6d3;
            width: 47px;
            height: 6px;
            display: block;
            margin: 0 auto;
            position: relative;
            top: 6px;
            border-radius: 4px;
        }
        .id-card-tag-strip {
            width: 45px;
            height: 40px;
            background-color: #0950ef;
            margin: 0 auto;
            border-radius: 5px;
            position: relative;
            top: 9px;
            z-index: 1;
            border: 1px solid #0041ad;
        }
        .id-card-tag-strip:after {
            content: '';
            display: block;
            width: 100%;
            height: 1px;
            background-color: #c1c1c1;
            position: relative;
            top: 10px;
        }
        .id-card-tag {
            width: 0;
            height: 0;
            border-left: 100px solid transparent;
            border-right: 100px solid transparent;
            border-top: 100px solid #0958db;
            margin: -10px auto -30px auto;
        }
        .id-card-tag:after {
            content: '';
            display: block;
            width: 0;
            height: 0;
            border-left: 50px solid transparent;
            border-right: 50px solid transparent;
            border-top: 100px solid #d7d6d3;
            margin: -10px auto -30px auto;
            position: relative;
            top: -130px;
            left: -50px;
        }
    </style>
</head>

<body>
{{--<div class="id-card-tag"></div>--}}
{{--<div class="id-card-tag-strip"></div>--}}
<div class="id-card-hook"></div>
<div class="id-card-holder">
    <div class="id-card">
        <div class="header">

            <img src="{{url($settings->image)}}">
        </div>
        <div class="photo">
            <img src="{{url($row->image_thumb ?? 'assets/admin/img/broken.png')}}" class="img-circle circle-border m-b-md" alt="profile">
        </div>
        <h3>{{$row->unique_no}}</h3>
        <h2>{{$row->name}}</h2>
        <h3>{{$row->job->name ?? '...'}}</h3>
        <h3>{{$row->organization->name ?? '...'}}</h3>
        <h3>{{$row->project->name ?? '...'}}</h3>
        <div class="qr-code">
            {!! QrCode::size(100)->generate("tlgegypt.com/admin/worker/".$row->id); !!}
        </div>
        <h3>www.tlgegypt.com</h3>
        <hr>
        <p><strong>{{$settings->name}} </strong>{{$settings->address}}
        <p>{{$settings->email}}</p>
        <p>{{$settings->phone}}</p>
        <p>
        {{--<p>Near PMG Junction, Thiruvananthapuram Kerala, India <strong>695033</strong></p>--}}
        {{--<p>Ph: 9446062493 | E-ail: info@onetikk.info</p>--}}
    </div>
</div>
<script>
    window.print();
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome == false) window.close();
</script>
</body>
</html>
