
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Oops!</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="/favicon.ico">

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,700" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">


        <style>

            /* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
            */

            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            b, u, i, center,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td,
            article, aside, canvas, details, embed,
            figure, figcaption, footer, header, hgroup,
            menu, nav, output, ruby, section, summary,
            time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                font-size: 100%;
                font: inherit;
                vertical-align: baseline;
                text-decoration:none;
            }
            /* HTML5 display-role reset for older browsers */
            article, aside, details, figcaption, figure,
            footer, header, hgroup, menu, nav, section {
                display: block;
            }
            /*body {
                    line-height: 1;
            }*/
            ol, ul {
                list-style: none;
            }
            blockquote, q {
                quotes: none;
            }
            blockquote::before, blockquote::after,
            q::before, q::after {
                content: '';
                content: none;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
            article, aside, figure, footer, header, hgroup, menu, nav, section {
                display:block;
            }

            /* ******************************************** */
            /** GENERIC: SCREEN
            /* ******************************************** */

            /* BODY */

            html{
                font-size: 62.5%;
            }
            html:not(.disable-smooth-scroll){
                scroll-behavior: smooth;
                /* TODO Confirmar que sea esta variable cuando esté armado el header */
                scroll-padding-top: var(--header);
            }
            *, *::before, *::after {
                box-sizing: border-box;
            }
            body{
                font-size: 100%;
            }
            body, input, textarea, select, button{
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                -webkit-text-size-adjust: none;
                font-family: var(--font);
                font-weight: 400;
                color: var(--color-neutral-700);
            }
            p{
                text-rendering: optimizeLegibility;
            }
            strong{
                font-weight: 700;
            }
            em{
                font-style: italic;
            }
            input, textarea, select, button{
                border: none;
                outline: none;
                resize: none;
                border-radius: 0;
                background-color: transparent;
                padding: 0;
                margin: 0;
            }
            input:not([type="checkbox"]):not([type="radio"]), textarea, select, button{
                -webkit-appearance: none;
            }

            button{
                overflow: visible;
                font-size: inherit;
            }

            a, button{
                color: var(--color-secondary-400);
                -webkit-tap-highlight-color: hsl( var(--color-secondary-400-hsl) / 5%);
                cursor: pointer;
            }

            img{
                display: block;
                max-width: 100%;
            }

            /* ******************************************** */
            /** OBJECTS: STRUCTURE
            /* ******************************************** */

            /* STRUCTURE */

            .o-viewport{
                min-height: 100vh;
            }

            .o-wrapper{
                width: 100%;
                max-width: var(--wrapper);
                margin-left: auto;
                margin-right: auto;
                padding-left: var(--wrapper-x);
                padding-right: var(--wrapper-x);
            }

            /* ******************************************** */
            /** SETTINGS: VARIABLES
            /* ******************************************** */

            :root{
                --font: 'Roboto', sans-serif;
                --font-alt: 'Plus Jakarta Sans', sans-serif;
                --num-fz: 10rem;
                --text-fz: 1.4rem;

                /* Sizes */
                --space-x: 1.6rem;
                --space-y: 3.2rem; /* ? */

                --wrapper: 168rem;
                --tap-size: 4.8rem;

                --wrapper-x: var(--space-x);
                --wrapper-x-n: calc(var(--wrapper-x) * -1);

                --color-neutral-100: #FFF;
                --color-neutral-600: #525866;
                --color-primary-200: #2D59F5;
                --color-primary-100-hsl: 220 86% 57%;
                --color-secondary-400: #00A76F;
            }


            /* ********************** SHORT MOBILE ********************** */

            @media (max-width: 22.4375rem) { /* 359px */

                :root{

                    --num-fz: 9rem;
                    --text-fz: 1.4rem;
                }
            }


            /* ********************** de Mobile a TABLET ********************** */

            @media (min-width: 48rem) { /* 768px */

                :root{

                    --num-fz: 14rem;
                }
            }


            /* ********************** de Tablet a DESKTOP ********************** */

            @media (min-width: 61.25rem) { /* 980px */

                :root{
                    --num-fz: 16rem;
                    --wrapper-x: max(6.4rem, 6.25vw);
                    --text-fz: 1.6rem;
                }

            }


            /* ********************** de Desktop a DESKTOP 2 ********************** */

            @media (min-width: 75rem) { /* 1200px */

                :root{
                    --num-fz: 18rem;
                    --text-fz: 1.7rem;
                }
            }



            /* ********************** de Desktop 2 a HD ********************** */

            @media (min-width: 87.5rem) { /* 1400px */

                :root{
                    --num-fz: 13.2vw;
                    --text-fz: 2rem;
                }

            }


            @media (min-width: 105rem) { /* ! Wrapper break: 1680px */

                :root{
                    --wrapper-x: 10.4rem;
                }

            }

            /* TAP SIZE */

            .u-tap-size{
                position: relative;
            }


            .u-text{
                --_color-link: var(--color-secondary-400);
                --_lh: 1.6;
                --_margin-top: 2em;

                font-size: var(--text-fz);
                font-weight: 400;
                line-height: var(--_lh);
                color: var(--color-neutral-600);
            }

            .c-btn{
                --arrow-size: 0.875em;
                --_main-color: var(--color-secondary-400);

                display: inline-block;
                vertical-align: middle;
                position: relative;
                font-size: var(--btn-fz, var(--fz-100));
                font-weight: var(--btn-fw, 500);
                line-height: 1.2;
                color: var(--btn-main-color, var(--_main-color));
            }

            .c-btn{
                --_padding-x: 1.333em;
                --_padding-y: 0.75em;
                --_br: 0.8rem;
                --_bw: 0.1rem;

                padding: var(--btn-padding-y, var(--_padding-y)) var(--btn-padding-x, var(--_padding-x)) calc(var(--btn-padding-y, var(--_padding-y)) * 1.1);
                border-radius: var(--_br);
                border: var(--_bw) solid currentColor;
            }


            :root .c-btn--fill{
                --_text-color: var(--color-neutral-100);

                color: var(--btn-text-color, var(--_text-color));
                background-color: var(--btn-main-color, var(--_main-color));
                border-color: var(--btn-main-color, var(--_main-color));
            }

            /* TOUCH */

            @media (hover: none) {

                .c-btn::before,
                .c-link::before{
                    content: "";
                    display: block;
                    width: 100%;
                    min-width: var(--tap-size);
                    height: var(--tap-size);
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                }

            }

            /* NO TOUCH */

            @media (hover: hover) {

                /* BTN */

                .c-btn{
                    --_hover-color: var(--color-primary-200);
                }

                .c-btn--fill:hover{
                    background-color: var(--btn-hover-color, var(--_hover-color));
                    border-color: var(--btn-hover-color, var(--_hover-color));
                }

                /* Shadow effect */

                .c-btn{
                    --shadow-size: 1em;
                    --shadow-color: var(--btn-hover-color, var(--_hover-color));

                    transform: translate3d(0,0,0);
                    transition:
                        border-color 200ms ease-out,
                        color 200ms ease-out,
                        background-color 200ms ease-out,
                        opacity 200ms ease-out,
                        transform 300ms ease-out;
                }
                .c-btn::after{
                    content: "";
                    position: absolute;
                    inset: calc( var(--_bw) * -1 );
                    z-index: -1;
                    border-radius: inherit;
                    box-shadow: 0 0.5em var(--shadow-size) -0.375em var(--shadow-color);
                    opacity: 0;
                    transition: opacity 200ms ease-out;
                }

                .c-btn--fill:hover::after{
                    opacity: 0.8;
                }

            }



            .c-warning{
                --_warning-num-color: var(--color-primary-200);
                --_warning-num-fz: var(--num-fz);
                --_warning-num-fw: 700;

                display: flex;
                justify-content: center;
                align-items: flex-start;
                width: 100%;
                height: 100vh;
            }

            .c-warning__content{
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                gap: var(--space-y);
                margin-top: calc(var(--space-y)*2);
                margin-bottom: calc(var(--space-y)*2);
            }

            .c-warning__logo{
                width: 10vw;
                min-width: 10rem;
                margin-bottom: 4rem;
            }

            .c-warning__num{
                font-size: var(--_warning-num-fz);
                font-weight: var(--_warning-num-fw);
                color: var(--_warning-num-color);
                font-family: var(--font-alt);
                line-height: 1;
            }

            .c-warning__text{
                font-family: var(--font);
                max-width: 30em;
                text-align: center;
            }

            /* Deco */

            .c-warning__deco{
                --height: var(--width);

                width: var(--width);
                height: var(--height);
                position: absolute;
                bottom: var(--bottom);
                top: var(--top);
                z-index: -1;
            }
            .c-warning__deco--1{
                --left: -57vw;
                --width: 100vw;
                --bottom: 50vh;
                --opacity: 0.2;

                left: var(--left);
                opacity: var(--opacity);
            }
            .c-warning__deco--2{
                --height: auto;
                --width: 50%;
                --right: -5.8%;
                --bottom: 0;

                right: var(--right);
                border-radius: 50%;
                background: linear-gradient( -120deg, hsl( var(--color-primary-100-hsl) / 30%), hsl( var(--color-primary-100-hsl) / 0%) );
                opacity: 0.6;
            }

            .c-warning__deco--2::before{
                content: "";
                display: block;
                width: 100%;
                padding-bottom: 100%;
                border-radius: 50%;
                transform: translate(18%, 23.4%);
                border: 0.1rem solid hsl( var(--color-primary-100-hsl) / 80%);
                opacity: 0.5;
            }

            .c-warning__btn{
                margin-top: .9em;
            }


            /* ********************** de Mobile a TABLET ********************** */

            @media (min-width: 48rem) { /* 768px */

                /* Deco */

                .c-warning__deco--1{
                    --width: 80vw;
                    --top: 2%;
                    --bottom: auto;
                }
                .c-warning__deco--2{
                    --width: 40%;
                    --bottom: -2.2%;
                }

                .c-warning{
                    align-items: center;
                }

            }


            /* ********************** de Tablet a DESKTOP ********************** */

            @media (min-width: 61.25rem) { /* 980px */

                /* Deco */

                .c-warning__deco--1{
                    --width: 45vw;
                    --top: 15%;
                    --left: -28vw;

                    mix-blend-mode: overlay;
                }
                .c-warning__deco--2{
                    --width: 23%;
                    --right: -5.8%;
                    --bottom: 20%;
                }

                [class*="c-btn"]{
                    font-size: calc( var(--btn-fz, var(--text-fz)) - 0.1rem );
                }

            }

            /* ********************** de Desktop 2 a HD ********************** */

            @media (min-width: 87.5rem) { /* 1400px */

                /* Deco */

                .c-warning__deco--1{
                    --width: 38vw;
                    --left: -22.7vw;
                }

            }

            @media (min-width: 105rem) { /* ! Wrapper break: 1680px */

                /* Deco */

                .c-warning__deco--1{
                    --width: 64rem;
                    --left: 50%;

                    margin-left: calc( var(--wrapper) * -0.727 )
                }

            }



        </style>


    </head>
    <body>

        <div class="c-warning o-wrapper">
            <img src="/assets/images/static/heros/deco-ring.svg"
                 width="560"
                 height="560"
                 alt=""
                 class="c-warning__deco c-warning__deco--1">

            <div class="c-warning__deco c-warning__deco--2"></div>
            <div class="c-warning__content">
                <svg class="c-warning__logo" enable-background="new 0 0 135 32" height="32" viewBox="0 0 135 32" width="135" xmlns="http://www.w3.org/2000/svg"><g class="c-logo__text"><path d="m94.2 24.2c-.8 1.4-2.2 2.1-3.8 2.1-2.5 0-5.1-1.9-5.1-5.6 0-3.6 2.6-5.4 5.1-5.5 1.5 0 3 .7 3.8 2v-.1l4-3.5c-1.9-2.4-4.9-3.7-7.9-3.7-5.2 0-10.6 3.6-10.6 10.6s5.3 10.8 10.6 10.6c3.1 0 6-1.3 7.9-3.7z"></path><path d="m130.7 23.4v-22.9h-5.7v22.9c0 7.3 3.7 8.7 9.9 7.6l-.2-4.4c-2.8.5-4-.1-4-3.2z"></path><path d="m119.5 25.2v-7c0-5.8-4.3-7.9-9.5-7.9-2.7 0-5.9.6-8.4 2l2 3.8c1.3-.7 3.3-1.3 5.7-1.3 2 0 4.6.6 4.6 3v1.2c-1.5-1-3.5-1.3-5.3-1.3-4.4 0-7.9 2.4-7.7 7.3.1 3.9 3.5 6.3 7.2 6.3 2.6 0 5.7-1 6.9-3.5 0 3.6 3.3 3.7 6.3 3.1v-3.2c-1.9.2-1.8-.9-1.8-2.5zm-5.7-1.3c-.2 2.1-2.6 3.1-4.5 3.1-1.3 0-2.6-.7-2.7-2.1-.2-1.9 1.3-3 3.1-3.1 1.4 0 3 .4 4.1 1.2z"></path><path d="m65.9 10.4c-5.2 0-10.4 3.6-10.4 10.5 0 7 5.3 10.5 10.6 10.5 5.2 0 10.5-3.5 10.5-10.5.1-7-5.3-10.6-10.7-10.5zm.1 16c-2.4 0-4.7-1.8-4.7-5.5 0-3.6 2.5-5.4 4.9-5.4 2.5 0 4.7 1.8 4.7 5.4 0 3.7-2.5 5.5-4.9 5.5z"></path><path d="m49.5 23.4v-22.9h-5.7v22.9c0 7.3 3.7 8.7 9.9 7.6l-.2-4.4c-2.9.5-4-.1-4-3.2z"></path><path d="m19.9 24.3v-23.8h-5.8v11.1c-7-3.4-14.1 1.4-14.1 9.4 0 5.6 3.2 10.6 9.2 10.5 2.6 0 4.9-1.4 6-3.8v.6c.1 3.5 3.7 3.6 6.6 2.9v-3.8c-1.8-.1-1.9-1.1-1.9-3.1zm-5.7-2.6c0 2.5-1.7 4.5-4.1 4.5-3.1 0-4.4-2.5-4.4-5.4 0-5 4.4-6.8 8.5-4.4z"></path></g><path d="m35 16.6h-5.8v5.8h5.8z" class="c-logo__dot"></path></svg>
                <span class="c-warning__num">404</span>
                <p class="c-warning__text u-text">
                    Something went wrong, please reload the page or try again later, if the problem continues, you can also go back to the home page by clicking the button below.
                </p>
                <a href="/" class="c-warning__btn c-btn c-btn--fill">Go back to Home</a>
            </div>
        </div>

    </body>
</html>