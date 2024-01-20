<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Message</title>
    <link rel="icon" type="image/x-icon" href="{{url('Frontend/assets/images/favicon.png')}}">

    <style>
        html,
        body {
            font-family: sans-serif;
            height: 100%;
            /* width: 100%; */
            background: rgba(200, 200, 200, 0.2);
            overflow-y: hidden;
        }

        .container-720 {
            max-width: 720px;
            margin: auto;
            background: #fff;
        }

        @supports (animation: grow 0.5s cubic-bezier(0.25, 0.25, 0.25, 1) forwards) {
            .tick {
                stroke-opacity: 0;
                stroke-dasharray: 29px;
                stroke-dashoffset: 29px;
                animation: draw 0.5s cubic-bezier(0.25, 0.25, 0.25, 1) forwards;
                animation-delay: 0.6s;
            }

            .circle {
                fill-opacity: 0;
                stroke: #219a00;
                stroke-width: 16px;
                transform-origin: center;
                transform: scale(0);
                animation: grow 1s cubic-bezier(0.25, 0.25, 0.25, 1.25) forwards;
            }
        }

        @keyframes grow {
            60% {
                transform: scale(0.8);
                stroke-width: 4px;
                fill-opacity: 0;
            }

            100% {
                transform: scale(0.9);
                stroke-width: 8px;
                fill-opacity: 1;
                fill: #219a00;
            }
        }

        @keyframes draw {

            0%,
            100% {
                stroke-opacity: 1;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }


        :root {
            --theme-color: var(--color-purple);
        }

        .svg-container {
            display: flex;
            align-content: space-around;
            justify-content: space-around;
            margin: 20px 0px;
        }
        img{
            height: 40px;
        }
        .goLogin{
            font-size: 25px;
            color: #1c7430;
        }
    </style>
</head>

<body>
<div class="container-720">
    <div class="heading"
         style="background: #1e931e;display:flex; align-items: center;justify-content: space-between;margin-left:-20px;margin-right: -20px;box-shadow: 0 5px 10px -5px green;padding-left: 30px;padding-right:30px;">
        <h1 style="line-height: 50px;padding-left: 10px;color:white">Verification Successfull</h1>
    </div>

    <div class="svg-container">
        <svg class="ft-green-tick" xmlns="http://www.w3.org/2000/svg" height="100" width="100" viewBox="0 0 48 48"
             aria-hidden="true">
            <circle class="circle" fill="#5bb543" cx="24" cy="24" r="22" />
            <path class="tick" fill="none" stroke="#FFF" stroke-width="6" stroke-linecap="round"
                  stroke-linejoin="round" stroke-miterlimit="10" d="M14 27l5.917 4.917L34 17" />
        </svg>
    </div>
    <main style="padding: 30px 60px;">
        <p style="text-align: center;">
            You have successfully <b>Verified!</b>
        </p>
        <!-- Kindly note that your registration is not yet complete.
                To confirm your seat during Workshop, you need to do the payment of the workshop.
                We urge you to pay as soon as possbile as payment (hence workshop registraion) will close after the
                seats are filled. -->

        <p>
            Please check your verified &ldquo;<strong>email</strong>&rdquo; to get your username and password to logged in your panel. Don't share your credentials to other
        </p>

    </main>
    <!-- border-top:2px double #1f3f1f; -->
    <footer style="padding:20px 10px 20px 10px;font-size: 0.9em; text-align: center;">
        <p>
            Thank you for your response. Stay with us.
        </p>
        <a href="{{config('app.base_url')}}" class="logo">
            <span class="goLogin">Go to your login</span>
        </a>
    </footer>
</div>
</body>

</html>
