<?php
/**
 * DM-FRAMEWORK 2020-2020
 * Version: 1.0.0.0
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
class Alerts {

    public function __construct() {}
    // Responsible function in assembling an error build.
    public function errorBild($type, $msg=null) {

        if($type == 404) {

            return '
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <link rel="apple-touch-icon" type="image/png" href="https://static.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
            <meta name="apple-mobile-web-app-title" content="CodePen">
            <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />
            <link rel="mask-icon" type="" href="https://static.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111" />
            <title>404 Not Found</title>
            <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
            <style>
            html,
            body {
            height: 100%;
            }
            body {
            display: grid;
            width: 100%;
            font-family: Inconsolata, monospace;
            }
            body div#error {
            position: relative;
            margin: auto;
            padding: 20px;
            z-index: 2;
            }
            body div#error div#box {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 1px solid #000;
            }
            body div#error div#box:before,
            body div#error div#box:after {
            content: \'\';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: inset 0px 0px 0px 1px #000;
            mix-blend-mode: multiply;
            animation: dance 2s infinite steps(1);
            }
            body div#error div#box:before {
            clip-path: polygon(0 0, 65% 0, 35% 100%, 0 100%);
            box-shadow: inset 0px 0px 0px 1px currentColor;
            color: #f0f;
            }
            body div#error div#box:after {
            clip-path: polygon(65% 0, 100% 0, 100% 100%, 35% 100%);
            animation-duration: 0.5s;
            animation-direction: alternate;
            box-shadow: inset 0px 0px 0px 1px currentColor;
            color: #0ff;
            }
            body div#error h3 {
            position: relative;
            font-size: 5vw;
            font-weight: 700;
            text-transform: uppercase;
            animation: blink 1.3s infinite steps(1);
            }
            body div#error h3:before,
            body div#error h3:after {
            content: \'ERROR 404\';
            position: absolute;
            top: -1px;
            left: 0;
            mix-blend-mode: soft-light;
            animation: dance 2s infinite steps(2);
            }
            body div#error h3:before {
            clip-path: polygon(0 0, 100% 0, 100% 50%, 0 50%);
            color: #f0f;
            animation: shiftright 2s steps(2) infinite;
            }
            body div#error h3:after {
            clip-path: polygon(0 100%, 100% 100%, 100% 50%, 0 50%);
            color: #0ff;
            animation: shiftleft 2s steps(2) infinite;
            }
            body div#error p {
            position: relative;
            margin-bottom: 8px;
            }
            body div#error p span {
            position: relative;
            display: inline-block;
            font-weight: bold;
            color: #000;
            animation: blink 3s steps(1) infinite;
            }
            body div#error p span:before,
            body div#error p span:after {
            content: \'unstable\';
            position: absolute;
            top: -1px;
            left: 0;
            mix-blend-mode: multiply;
            }
            body div#error p span:before {
            clip-path: polygon(0 0, 100% 0, 100% 50%, 0 50%);
            color: #f0f;
            animation: shiftright 1.5s steps(2) infinite;
            }
            body div#error p span:after {
            clip-path: polygon(0 100%, 100% 100%, 100% 50%, 0 50%);
            color: #0ff;
            animation: shiftleft 1.7s steps(2) infinite;
            }
            @-moz-keyframes dance {
            0%, 84%, 94% {
                transform: skew(0deg);
            }
            85% {
                transform: skew(5deg);
            }
            90% {
                transform: skew(-5deg);
            }
            98% {
                transform: skew(3deg);
            }
            }
            @-webkit-keyframes dance {
            0%, 84%, 94% {
                transform: skew(0deg);
            }
            85% {
                transform: skew(5deg);
            }
            90% {
                transform: skew(-5deg);
            }
            98% {
                transform: skew(3deg);
            }
            }
            @-o-keyframes dance {
            0%, 84%, 94% {
                transform: skew(0deg);
            }
            85% {
                transform: skew(5deg);
            }
            90% {
                transform: skew(-5deg);
            }
            98% {
                transform: skew(3deg);
            }
            }
            @keyframes dance {
            0%, 84%, 94% {
                transform: skew(0deg);
            }
            85% {
                transform: skew(5deg);
            }
            90% {
                transform: skew(-5deg);
            }
            98% {
                transform: skew(3deg);
            }
            }
            @-moz-keyframes shiftleft {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(-8px, 0) skew(20deg);
            }
            }
            @-webkit-keyframes shiftleft {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(-8px, 0) skew(20deg);
            }
            }
            @-o-keyframes shiftleft {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(-8px, 0) skew(20deg);
            }
            }
            @keyframes shiftleft {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(-8px, 0) skew(20deg);
            }
            }
            @-moz-keyframes shiftright {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(8px, 0) skew(20deg);
            }
            }
            @-webkit-keyframes shiftright {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(8px, 0) skew(20deg);
            }
            }
            @-o-keyframes shiftright {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(8px, 0) skew(20deg);
            }
            }
            @keyframes shiftright {
            0%, 87%, 100% {
                transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
                transform: translate(8px, 0) skew(20deg);
            }
            }
            @-moz-keyframes blink {
            0%, 50%, 85%, 100% {
                color: #000;
            }
            87%, 95% {
                color: transparent;
            }
            }
            @-webkit-keyframes blink {
            0%, 50%, 85%, 100% {
                color: #000;
            }
            87%, 95% {
                color: transparent;
            }
            }
            @-o-keyframes blink {
            0%, 50%, 85%, 100% {
                color: #000;
            }
            87%, 95% {
                color: transparent;
            }
            }
            @keyframes blink {
            0%, 50%, 85%, 100% {
                color: #000;
            }
            87%, 95% {
                color: transparent;
            }
            }
            </style>
            <script>
            window.console = window.console || function(t) {};

            if (document.location.search.match(/type=embed/gi)) {
                window.parent.postMessage("resize", "*");
            }
            </script>
            </head>
            <body translate="no" >
            <div id="error">
            <div id="box"></div>
            <h3>ERROR 404</h3>
            <p style="text-align: center"><b>Not Found</b> <br><br> '.$msg.'</p>
            </div>
            </body>
            </html>
            ';

        } else if($type == 500) {

          return '
          <!DOCTYPE html>
          <html lang="en">
          <head>
          <meta charset="UTF-8">
          <link rel="apple-touch-icon" type="image/png" href="https://static.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
          <meta name="apple-mobile-web-app-title" content="CodePen">
          <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />
          <link rel="mask-icon" type="" href="https://static.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111" />
          <title>404 Not Found</title>
          <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
          <style>
          html,
          body {
            height: 100%;
          }
          body {
            display: grid;
            width: 100%;
            font-family: Inconsolata, monospace;
          }
          body div#error {
            position: relative;
            margin: auto;
            padding: 20px;
            z-index: 2;
          }
          body div#error div#box {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 1px solid #000;
          }
          body div#error div#box:before,
          body div#error div#box:after {
            content: \'\';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: inset 0px 0px 0px 1px #000;
            mix-blend-mode: multiply;
            animation: dance 2s infinite steps(1);
          }
          body div#error div#box:before {
            clip-path: polygon(0 0, 65% 0, 35% 100%, 0 100%);
            box-shadow: inset 0px 0px 0px 1px currentColor;
            color: #f0f;
          }
          body div#error div#box:after {
            clip-path: polygon(65% 0, 100% 0, 100% 100%, 35% 100%);
            animation-duration: 0.5s;
            animation-direction: alternate;
            box-shadow: inset 0px 0px 0px 1px currentColor;
            color: #0ff;
          }
          body div#error h3 {
            position: relative;
            font-size: 5vw;
            font-weight: 700;
            text-transform: uppercase;
            animation: blink 1.3s infinite steps(1);
          }
          body div#error h3:before,
          body div#error h3:after {
            content: \'ERROR 500\';
            position: absolute;
            top: -1px;
            left: 0;
            mix-blend-mode: soft-light;
            animation: dance 2s infinite steps(2);
          }
          body div#error h3:before {
            clip-path: polygon(0 0, 100% 0, 100% 50%, 0 50%);
            color: #f0f;
            animation: shiftright 2s steps(2) infinite;
          }
          body div#error h3:after {
            clip-path: polygon(0 100%, 100% 100%, 100% 50%, 0 50%);
            color: #0ff;
            animation: shiftleft 2s steps(2) infinite;
          }
          body div#error p {
            position: relative;
            margin-bottom: 8px;
          }
          body div#error p span {
            position: relative;
            display: inline-block;
            font-weight: bold;
            color: #000;
            animation: blink 3s steps(1) infinite;
          }
          body div#error p span:before,
          body div#error p span:after {
            content: \'unstable\';
            position: absolute;
            top: -1px;
            left: 0;
            mix-blend-mode: multiply;
          }
          body div#error p span:before {
            clip-path: polygon(0 0, 100% 0, 100% 50%, 0 50%);
            color: #f0f;
            animation: shiftright 1.5s steps(2) infinite;
          }
          body div#error p span:after {
            clip-path: polygon(0 100%, 100% 100%, 100% 50%, 0 50%);
            color: #0ff;
            animation: shiftleft 1.7s steps(2) infinite;
          }
          @-moz-keyframes dance {
            0%, 84%, 94% {
              transform: skew(0deg);
            }
            85% {
              transform: skew(5deg);
            }
            90% {
              transform: skew(-5deg);
            }
            98% {
              transform: skew(3deg);
            }
          }
          @-webkit-keyframes dance {
            0%, 84%, 94% {
              transform: skew(0deg);
            }
            85% {
              transform: skew(5deg);
            }
            90% {
              transform: skew(-5deg);
            }
            98% {
              transform: skew(3deg);
            }
          }
          @-o-keyframes dance {
            0%, 84%, 94% {
              transform: skew(0deg);
            }
            85% {
              transform: skew(5deg);
            }
            90% {
              transform: skew(-5deg);
            }
            98% {
              transform: skew(3deg);
            }
          }
          @keyframes dance {
            0%, 84%, 94% {
              transform: skew(0deg);
            }
            85% {
              transform: skew(5deg);
            }
            90% {
              transform: skew(-5deg);
            }
            98% {
              transform: skew(3deg);
            }
          }
          @-moz-keyframes shiftleft {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(-8px, 0) skew(20deg);
            }
          }
          @-webkit-keyframes shiftleft {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(-8px, 0) skew(20deg);
            }
          }
          @-o-keyframes shiftleft {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(-8px, 0) skew(20deg);
            }
          }
          @keyframes shiftleft {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(-8px, 0) skew(20deg);
            }
          }
          @-moz-keyframes shiftright {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(8px, 0) skew(20deg);
            }
          }
          @-webkit-keyframes shiftright {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(8px, 0) skew(20deg);
            }
          }
          @-o-keyframes shiftright {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(8px, 0) skew(20deg);
            }
          }
          @keyframes shiftright {
            0%, 87%, 100% {
              transform: translate(0, 0) skew(0deg);
            }
            84%, 90% {
              transform: translate(8px, 0) skew(20deg);
            }
          }
          @-moz-keyframes blink {
            0%, 50%, 85%, 100% {
              color: #000;
            }
            87%, 95% {
              color: transparent;
            }
          }
          @-webkit-keyframes blink {
            0%, 50%, 85%, 100% {
              color: #000;
            }
            87%, 95% {
              color: transparent;
            }
          }
          @-o-keyframes blink {
            0%, 50%, 85%, 100% {
              color: #000;
            }
            87%, 95% {
              color: transparent;
            }
          }
          @keyframes blink {
            0%, 50%, 85%, 100% {
              color: #000;
            }
            87%, 95% {
              color: transparent;
            }
          }
          </style>
          <script>
            window.console = window.console || function(t) {};
          
            if (document.location.search.match(/type=embed/gi)) {
              window.parent.postMessage("resize", "*");
            }
          </script>
          </head>
          <body translate="no" >
            <div id="error">
            <div id="box"></div>
            <h3>ERROR 500</h3> 
            <p style="text-align: center"><b>Internal Server Error</b> <br><br>'.$msg.'</p>
          </div>
          </body>
          </html>
          ';
        } else {
          return false;
        }
    }
}