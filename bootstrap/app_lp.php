<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

      <style>

          .jumbotron {

              background-image: url(background.jpg);
              text-align: center;
              margin-top: 50px;
          }

          #email {

              width: 300px;

          }

          #appSummary {

              text-align: center;
              margin-top:50px;
              margin-bottom: 50px;

          }

          .card-img-top {

              width: 100%;

          }

          #appStoreIcon {

              width: 200px;

          }

          #footer {

              background-color: aqua;
              padding-top: 150px;
              margin-top: 50px;
              text-align: center;
              padding-bottom: 150px;
          }

          body {

              position: relative;

          }

      </style>

  </head>

  <body data-spy="scroll" data-target="#navbar" data-offset="150">

        <nav class="navbar navbar-light bg-faded navbar-fixed-top" id="navbar">
          <a class="navbar-brand" href="#">MyApp</a>
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#jumbotron">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#footer">Download The App</a>
            </li>
          </ul>
          <form class="form-inline pull-xs-right">
            <input class="form-control" type="email" placeholder="Email">
              <input class="form-control" type="password" placeholder="Password">
            <button class="btn btn-success" type="submit">Login</button>
          </form>
        </nav>

        <div class="jumbotron" id="jumbotron">
          <h1 class="display-3">My Awesome App!</h1>
          <p class="lead">This is why YOU should download this fantastic app!</p>
          <hr class="m-y-2">
          <p>Want to know more? Join our mailing list!</p>

        <form class="form-inline">
          <div class="form-group">
            <label class="sr-only" for="email">Email address</label>
            <div class="input-group">
              <div class="input-group-addon">@</div>
              <input type="email" class="form-control" id="email" placeholder="Your email">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Sign up</button>
        </form>
        </div>

      <div class="container">

        <div class="row" id="appSummary">

            <h1>Why This App Is Awesome</h1>
            <p class="lead">Summary, once again, of your app's awesomeness</p>

          </div>

      </div>

      <div class="container" id="about">
      <div class="card-deck-wrapper">
  <div class="card-deck">
    <div class="card">
      <img class="card-img-top" src="fatherandson.jpg" alt="Card image cap">
      <div class="card-block">
        <h4 class="card-title"><i class="fa fa-anchor"></i> Card title</h4>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>

      </div>
    </div>
    <div class="card">
      <img class="card-img-top" src="fatherandson.jpg" alt="Card image cap">
      <div class="card-block">
        <h4 class="card-title"><i class="fa fa-bicycle"></i> Card title</h4>
        <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>

      </div>
    </div>
    <div class="card">
      <img class="card-img-top" src="fatherandson.jpg" alt="Card image cap">
      <div class="card-block">
        <h4 class="card-title"><i class="fa fa-birthday-cake"></i> Card title</h4>
        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>

      </div>
    </div>
  </div>
</div>
          </div>

      <div id="footer">

        <div class="row">

                <h2>Download the app!</h2>

            <p class="lead">Really, why should I download this app??</p>

            <p><a href=""><img id="appStoreIcon" src="App-Store-Icon.png"></a></p>



          </div>

      </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>

  </body>


