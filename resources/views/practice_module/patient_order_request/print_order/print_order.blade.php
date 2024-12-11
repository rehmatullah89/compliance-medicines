<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<script type="text/javascript">

$(document).ready(function () {
setTimeout(function(){  window.print(); }, 5000);
   
});

</script>



<style>

/*Base styles*/ html { box-sizing: border-box; font-family: sans-serif; line-height: 24px; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -ms-overflow-style: scrollbar; -webkit-tap-highlight-color: transparent; scroll-behavior: smooth; }
body { background-color: #fff; font-family: 'Roboto Condensed', sans-serif; font-size: 14px; font-weight: 300; color: #3c3c3c; -webkit-text-size-adjust: 100%; margin: 0; overflow-x: hidden; box-sizing: border-box; min-height: 100%; display: grid; grid-template-rows: auto 1fr auto; grid-template-columns: 100%; }
*, *::before, *::after { box-sizing: inherit; }
* { vertical-align: top; box-sizing: border-box; font-family: 'Roboto Condensed', sans-serif; font-size: 14px; line-height: 1.2em;}
@-ms-viewport { width: device-width; }
/*Add the correct display in IE 9-.*/ article, aside, dialog, figcaption, figure, footer, header, hgroup, main, nav, section { display: block; }
dl, ol, ul { margin: 0px; padding: 0px; list-style: none; }
img { border: 0; }
a, a:hover, a:visited, a:visited:hover { text-decoration: none; outline: none; }
p, h2, h3 { orphans: 3; widows: 3; }
p { margin: 0px; }
img { width: 100%; height: auto; }
a { transition: all 0.3s ease-in-out; }
/*Show the overflow in IE.*/
button { overflow: visible; }
/*Show the overflow in Edge.*/
input { overflow: visible; }
/** * 1. Add the correct box sizing in IE 10-. * 2. Remove the padding in IE 10-. */
[type="checkbox"], [type="radio"] { box-sizing: border-box; padding: 0; }
/** * Remove the inheritance of text transform in Edge, Firefox, and IE. * 1. Remove the inheritance of text transform in Firefox. */
button, select { text-transform: none; }
/** * 1. Prevent a WebKit bug where (2) destroys native `audio` and `video` *    controls in Android 4. * 2. Correct the inability to style clickable types in iOS and Safari. */
button, html [type="button"], [type="reset"], [type="submit"] { -webkit-appearance: button; }
button::-moz-focus-inner, [type="button"]::-moz-focus-inner, [type="reset"]::-moz-focus-inner, [type="submit"]::-moz-focus-inner { border-style: none; padding: 0; }
button:-moz-focusring, [type="button"]:-moz-focusring, [type="reset"]:-moz-focusring, [type="submit"]:-moz-focusring { outline: 1px dotted ButtonText; }
/*Correct the cursor style of increment and decrement buttons in Chrome.*/
[type="number"]::-webkit-inner-spin-button, [type="number"]::-webkit-outer-spin-button { height: auto; }
/** * 1. Correct the odd appearance in Chrome and Safari. * 2. Correct the outline style in Safari. */
[type="search"] { -webkit-appearance: textfield; outline-offset: -2px; outline: 0px !important; }
[type="search"]::-webkit-search-cancel-button, [type="search"]::-webkit-search-decoration { -webkit-appearance: none; outline: 0px !important; }
/** * 1. Correct the inability to style clickable types in iOS and Safari. * 2. Change font properties to `inherit` in Safari. */
::-webkit-file-upload-button { -webkit-appearance: button; font: inherit; }
table { width: 100%; border-collapse: collapse; background-color: #fff; }
table { border-collapse: collapse; }
caption { padding-top: 0.75rem; padding-bottom: 0.75rem; color: #868e96; text-align: left; caption-side: bottom; }
th { text-align: left; }
label { display: inline-block; margin-bottom: .5rem; }
/** * Correct the padding in Firefox. */
fieldset { padding: 0.35rem 0.75rem 0.625rem; }
/** * 1. Correct the text wrapping in Edge and IE.
* 2. Correct the color inheritance from `fieldset` elements in IE.
* 3. Remove the padding so developers are not caught out when they zero out
* `fieldset` elements in all browsers. */
legend { box-sizing: border-box; display: table; max-width: 100%; padding: 0px; color: inherit; white-space: normal; }
/** * 1. Add the correct display in IE 9-. * 2. Add the correct vertical alignment in Chrome, Firefox, and Opera. */
progress { display: inline-block; vertical-align: baseline; }
/*Remove the default vertical scrollbar in IE.*/ textarea { overflow: auto; }
/*Typography*/ h1, h2, h3, h4, h5, h6 { font-family: 'Roboto Condensed', sans-serif; font-size: 100%; margin-bottom: 0.4em; margin-top: 0px; }
/*-----------------General styles ---------*/
* { vertical-align: top; box-sizing: border-box; font-family: 'Roboto Condensed', sans-serif; font-size: 14px; }
* { transition: all linear 0.17s; }
.main-wrapper { min-width: 100%; padding: 0px; margin: 0px; }
button, button:hover, button:focus, button:active { outline: none !important; outline: 0px !important; }
a, a:hover, a:focus, a:active { outline: none !important; outline: 0px !important; box-shadow: none !important; }
a:focus, a:hover { color: #014c8c !important; }
input, input:hover, input:focus, input:active { outline: none !important; outline: 0px !important; }
select, select:hover, select:focus, select:active { outline: none !important; outline: 0px !important; }
textarea, textarea:hover, textarea:focus, textarea:active { outline: none !important; outline: 0px !important; }
button, a, select { transition: all linear 0.24s; }
button { box-shadow: none !important; }
button:not([data-dismiss="modal"]):hover { border: solid 1px #3b82cd !important; color: #3b82cd; background-color: transparent; }
button:not([data-dismiss="modal"]):active { border: solid 1px #3b82cd !important; color: #3b82cd !important; background-color: transparent !important; }
input.error { margin-bottom: 4px !important; }
select.error { margin-bottom: 4px !important; }
textrea.error { margin-bottom: 4px !important; }

header .navbar { padding: 0px !important; }
::-webkit-scrollbar-track { background-color: #3b82cd; border-left: 1px solid #3b82cd; }
::-webkit-scrollbar { width: 9px; background-color: #7bc70d; max-height: 9px; }
::-webkit-scrollbar-thumb { background: #7bc70d; border-radius: 6px; }
.trow_ { display: inline-block; width: 100%; }
.c-dib_ > * { display: inline-block; }
.d-ib_ { display: inline-block; }
.child-center { text-align: center; }
.child-center>* { display: inline-block; }
.mw-1000 { max-width: 1000px; }
.cnt-left { text-align: left; }
.cnt-right { text-align: right; }
.cnt-center { text-align: center; }
.cnt-left-force { text-align: left !important; }
.cnt-right-force { text-align: right !important; }
.cnt-center-force { text-align: center !important; }
.elm-left { float: left; }
.elm-right { float: right; }
.elm-center { margin: 0px auto; }
.elm-left-cl { float: left; clear: both; }

.height_full { min-height: 100%; display: grid; grid-template-rows: auto 1fr auto; grid-template-columns: 100%; }
.height_fullp { min-height: 100%; height: 100% !important;}


.flx-justify-start { display: flex; justify-content: flex-start; }
.flx-justify-end { display: flex; justify-content: flex-end; }
.flx-justify-center { display: flex; justify-content: center; }
.f-wrap { flex-wrap: wrap; }
.flex-v-center { align-items: center; }
.flex-hr-center { justify-content: center; }
.flex-vr-start { align-items: flex-start; }
.flex-vr-center { align-items: center; }
.flex-vr-end { align-items: flex-end; }



.pos-rel_ { position: relative; }
.pos-abs_ { position: absolute; }
.pos-abs-tr_ { position: absolute; top: 0px; right: 0px; }
.pos-abs-tl_ { position: absolute; top: 0px; left: 0px; }
.pos-fxd_ { position: fixed; }

.elm-center { margin: 0px auto;}
.cnt-center { text-align: center;}

.v-al-top { vertical-align: top; }
h2 { font-size: 20.42px; color: #3b7ec4; font-weight: 600; }
.ma-0_ { margin: 0px; }
.mr-1vw { margin-right: 1vw; }
.ml-1vw { margin-left: 1vw; }
.mt-1_ { margin-top: 1px; }
.mt-2_ { margin-top: 2px; }
.mt-3_ { margin-top: 3px; }
.mt-4_ { margin-top: 4px; }
.mt-7_ { margin-top: 7px; }
.mt-10_ { margin-top: 10px; }
.mt-12_ { margin-top: 12px; }
.mt-14_ { margin-top: 14px; }
.mt-17_ { margin-top: 17px; }
.mt-20_ { margin-top: 20px; }
.mt-24_ { margin-top: 24px; }
.mt-24m_ { margin-top: -24px; }
.mt-32_ { margin-top: 32px; }
.mt-36_ { margin-top: 36px; }
.mt-40_ { margin-top: 40px; }
.mt-50_ { margin-top: 50px; }
.mt-60_ { margin-top: 60px; }
.mt-70_ { margin-top: 70px; }
.mt-80_ { margin-top: 80px; }
.mt-100_ { margin-top: 100px; }
.mb-0_ { margin-bottom: 0px !important; }
.mb-1_ { margin-bottom: 1px; }
.mb-2_ { margin-bottom: 2px; }
.mb-3_ { margin-bottom: 3px; }
.mb-4_ { margin-bottom: 4px; }
.mb-7_ { margin-bottom: 7px; }
.mb-10_ { margin-bottom: 10px; }
.mb-11_ { margin-bottom: 11px; }
.mb-12_ { margin-bottom: 10px; }
.mb-14_ { margin-bottom: 14px; }
.mb-17_ { margin-bottom: 17px; }
.mb-20_ { margin-bottom: 20px; }
.mb-24_ { margin-bottom: 24px; }
.mb-32_ { margin-bottom: 32px; }
.mb-36_ { margin-bottom: 36px; }
.mb-40_ { margin-bottom: 40px; }
.mb-50_ { margin-top: 50px; }
.mb-60_ { margin-top: 60px; }
.mb-70_ { margin-top: 70px; }
.mb-80_ { margin-top: 80px; }
.mb-100_ { margin-top: 100px; }

.mt-m8_ { margin-top: -8px; }
.ml-force-0_ { margin-left: 0px !important; }
.mlf-0_  { margin-left: 0px !important; }
.ml-1_ { margin-left: 1px; }
.ml-2_ { margin-left: 2px; }
.ml-4_ { margin-left: 4px; }
.mr-4_ { margin-right: 4px; }
.ml-7_ { margin-left: 7px; }
.mr-7_ { margin-right: 7px; }
.mr-6_ { margin-right: 6px; }
.ml-3_ { margin-left: 3px; }
.mr-3_ { margin-right: 3px; }
.ml-14_ { margin-left: 14px; }
.mr-14_ { margin-right: 14px; }

.ml-auto_ { margin-left: auto; }
.mr-auto_  { margin-right: auto; }

.mr-1p { margin-right: 1%;}
.mr-1p_ { margin-right: 1%;}
.mr-2p { margin-right: 2%;}
.mr-2p_ { margin-right: 2%;}
.c-mb-14_ > * { margin-bottom: 14px;}
.c-mr-14_ > * { margin-right: 14px;}
.c-mr-4_>* { margin-right: 4px;}
.c-mr-7_>* { margin-right: 7px;}
.pa-0_ { padding: 0px;}
.pa-force-0_ { padding: 0px !important;}
.pl-2_ { padding-left: 2px;}
.pl-3_ { padding-left: 3px;}
.pl-4_ { padding-left: 4px;}
.pl-5_ { padding-left: 5px;}
.pl-6_ { padding-left: 6px;}
.pl-7_ { padding-left: 7px;}
.pl-8_ { padding-left: 8px;}
.pl-9_ { padding-left: 9px;}
.pl-10_ { padding-left: 10px;}
.pl-11_ { padding-left: 11px;}
.pl-12_ { padding-left: 12px;}
.pl-13_ { padding-left: 13px;}
.pl-14_ { padding-left: 14px;}
.pl-15_ { padding-left: 15px;}
.pl-16_ { padding-left: 16px;}
.pl-17_ { padding-left: 17px;}
.pl-18_ { padding-left: 18px;}
.pl-19_ { padding-left: 19px;}
.pl-20_ { padding-left: 20px;}
.pl-21_ { padding-left: 21px;}
.pl-22_ { padding-left: 22px;}
.pl-23_ { padding-left: 23px;}
.pl-24_ { padding-left: 24px;}
.pa-4_ { padding: 4px;}
.pa-4f_ { padding: 4px !important;}
.pa-5_ { padding: 5px;}
.pa-6_ { padding: 6px;}
.pa-7_ { padding: 7px;}
.pa-8_ { padding: 8px;}
.pa1-8_ { padding: 1px 8px;}
.p4-8_{ padding: 4px 8px;}
.p4-12_{ padding: 4px 12px;}
.p6-12_{ padding: 6px 12px;}
.p8-12_{ padding: 8px 12px;}
.pa-14_ { padding: 14px;}
.pt-2_ { padding-top: 2px;}
.pt-3_ { padding-top: 3px;}
.pt-4_ { padding-top: 4px;}
.pt-6_ { padding-top: 6px;}
.pt-7_ { padding-top: 7px;}
.pad-top-7_ { padding-top: 7px;}
.pt-8_ { padding-top: 8px;}
.pt-14_ { padding-top: 14px;}
.pr-14_ { padding-right: 14px;}
.pb-7_ { padding-bottom: 7px;}
.pb-14_ { padding-bottom: 14px;}
.pl-14_ { padding-left: 14px;}
.pa-c-14-0_ > * { padding: 0px 14px; }
.pt-17_ { padding-top: 17px;}
.pr-24_ { padding-right: 24px;}
.pt-24_ { padding-top: 24px;}
.pb-24_ { padding-bottom: 24px;}
.pt-40_ { padding-top: 40px;}
.pb-3_ { padding-bottom: 4px;}
.pb-4_ { padding-bottom: 4px;}
.pr-3_ { padding-right: 3px; }
.p36-87em_ { padding: 0.36em 0.87em;}
.pr-200_ { padding-right: 200px; }
.fs-zero { font-size: 0px !important; }
.fs-z-to-13 { font-size: 0px; }
.fs-z-to-13>* { font-size: 13px; line-height: 1.24em; }
.fs-z-to-14 { font-size: 0px; }
.fs-z-to-14>* { font-size: 14px; line-height: 1.24em; }
.fs-z-to-14-66 { font-size: 0px; }
.fs-z-to-14-66>* { font-size: 14.66px; }
.fs-40_ { font-size: 40px; }
.fs-36_ { font-size: 36px; }
.fs-32_ { font-size: 32px; }
.fs-30_ { font-size: 30px; }
.fs-26_ { font-size: 26px; }
.fs-24_ { font-size: 24px; }
.fs-23_ { font-size: 23px; }
.fs-22_ { font-size: 22px; }
.fs-21_ { font-size: 21px; }
.fs-20_ { font-size: 20px; }
.fs-19_ { font-size: 19px; }
.fs-17-force-child_ { font-size: 17px; }
.fs-17-force-child_ * { font-size: 17px !important; }
.fs-18_ { font-size: 18px; }
.fs-18-force_ { font-size: 18px !important; }
.fs-17_ { font-size: 17px; }
.fs-16_ { font-size: 16px; }
.fs-15_ { font-size: 15px; }
.fs-14_ { font-size: 14px; }
.fs-13_ { font-size: 13px; }
.fs-12_ { font-size: 12px; }
.fs-11_ { font-size: 11px; }
.fs-10_ { font-size: 10px; }
.fs-f10_ { font-size: 10px !important; }
.fs9-lh11_ { font-size: 9px; line-height: 11px; }
.fs-9_ { font-size: 9px; }
.fs-f9_ { font-size: 9px !important; }
.fs-8_ { font-size: 8px; }
.fs-7_ { font-size: 7px; }
.fs-6_ { font-size: 6px; }
.fs-z_ { font-size: 0px; }
.fnt-sz-7 { font-size: 7px; }


.z-ind-100 { z-index: 100; }
.z-ind-200 { z-index: 200; }
.z-ind-300 { z-index: 300; }
.z-ind-400 { z-index: 400; }
.z-ind-500 { z-index: 500; }
.z-ind-600 { z-index: 600; }
.z-ind-700 { z-index: 700; }
.z-ind-800 { z-index: 800; }
.z-ind-900 { z-index: 900; }
.z-ind-1000 { z-index: 1000; }

.txt-red { color: #ec1717 !important; }
.txt-red-dk { color: #a90909; }
.txt-blue { color: #3b7ec4; }
.txt-blue-force { color: #3b7ec4 !important; }
.txt-blue_sh { color: #1b9be5; }
.txt-blue_sh-force { color: #1b9be5 !important; }
.txt-grn-lt { color: #9bc90d !important; }
.txt-grn-dk { color: #559928 !important; }
.txt-grn-dk-force-childs { color: #559928 !important; }
.txt-grn-dk-force-childs * { color: #559928 !important; }
.txt-gray-6 { color:#666; }
.txt-gray-57 { color: #575757; }
.txt-gray-7e { color: #7e7e7e; }
.txt-gray-9 { color: #999; }
.txt-gray-9a { color: #9a9a9a; }
.txt-gray-9a-force-child { color: #9a9a9a !important; }
.txt-gray-9a-force-child > * { color: #9a9a9a !important; }
.txt-black { color: #000; }
.txt-black-14 { color: #141414; }
.txt-black-24 { color: #242424; }
.txt-wht { color: #fff !important; }
.txt-wht-child * { color: #fff; }
.txt-blue-force { color: #0e7ef2 !important; }
.txt-black-force { color: #242424; }

.txt-orange { color: #d69812; }
.txt-orange-force { color: #d69812 !important; }
.txt-orange2 { color: #e19c06; }
.txt-orange3 { color: #df9300; }

.txt-purple { color: #7964b9; }


.txt-orange_red {  color: #FF5722; }
.txt-orange_red-force {  color: #FF5722 !important; }

.txt-hover-black_24:hover { color: #242424 !important; }
.txt-hover-blue:hover { color: #3e7bc4; }

.txt-black-childs * { color: #242424; }

.txt-grn-md { color: #26bb31; }
.txt-grn-lt2 {  color:#e2f1df }
.txt-dark-blue {  color:#2d26bb; }
.txt-purple-lt2 {color: #d4d2f7; }
.txt-orange-md { color: #f47353;}
.txt-pnk-lt {color: #fee5df; }

.bg-grn-md { background-color: #26bb31; }
.bg-grn-lt2 { background-color:#e2f1df }
.bg-dark-blue { background-color:#2d26bb; }
.bg-blue-lt2 { background-color: #d4d2f7; }
.bg-orange-md { background-color: #f47353;}
.bg-pnk-lt {background-color: #fee5df; }




.bg-white { background-color: #fff; }
.bg-tb-wht-shade  { background-color: #fcfafd; }
.bg-tb-wht-shade2 { background-color: #fcfafc; }
.bg-tb-pink  { background-color: #f3d1d0; }
.bg-tb-pink2 { background-color: #f2d1d1; }
.bg-tb-pink-lt { background-color: #fdfafd; }
.bg-tb-grn-lt  { background-color: #e5ead3; }
.bg-tb-grn-lt2  { background-color: #7dbc6e; }
.bg-grn-lt3 { background-color: #e2f1df; }
.bg-tb-blue-lt  { background-color: #dce8f6; }
.bg-tb-blue-lt2 { background-color: #dce8f5; }
.bg-tb-cyan { background-color: #49c0c7; }
.bg-cyan-lt { background-color: #dfeeef; }
.bg-gr-bl-dk { background-color: #44546a; }
.bg-gr_bl  { background-color: #acb3bb; }
.bg-orage { background-color: #e2a623; }
.bg-tb-orange-lt  { background-color: #fff6e1; }
.bg-gray-ed { background-color: #ededed; }
.bg-gray-ce { background-color: #cecece; }
.bg-gray-e { background-color: #eeeeee; }
.bg-gray-e3  { background-color: #e3e3e3; }
.bg-gray-f2 { background-color: #f2f2f2; }
.bg-gray-1  { background-color: #b1adac; }
.bg-gray-2  { background-color: #ebe9ea; }
.bg-gray-80 { background-color: #808080; }
.bg-gray-d9 { background-color: #d9d9d9; }
.bg-blue    { background-color: #3b7ec4; }
.bg-grn-lk  { background-color: #afd13f; }
.bg-grn-dk  { background-color: #559928; }
.bg-gray-57 { background-color: #575757; }
.bg-red     { background-color: #ec1717 !important; }
.bg-red2 { background-color: #d12727; }
.bg-red-dk  { background-color: #a90909; }
.bg-purple { background-color: #7964b9; }
.bg-purple2 { background-color: #e0dbed; }
.bg-purple-lt {background-color: #ba95be; }
.bg-purple-lt2 { background-color: #f2e3f4; }
.bg-yellow { background-color: #e0c907; }
.bg-yellow-lt { background-color: #fff6e1; }
.bg-transparent { background-color: transparent !important; }
.bg-ededed { background-color: #ededed !important; }
.bg-d9d9d9 { background-color: #d9d9d9 !important; }
.bg-f2f2f2 { background-color: #f2f2f2 !important; }
.bg-fff { background-color: #fff !important; }

.tt_cc_ { text-transform: capitalize; }
.tt_uc_ { text-transform: uppercase; }
.tt_lc_ { text-transform: lowercase; }
.tt_nc_ { text-transform: none;}
.td_u_ { text-decoration: underline; }
.td_u_force { text-decoration: underline !important; }
.txt-sline { white-space: nowrap; }

.no-wrap-text { white-space:nowrap; }
.text-sline { white-space:nowrap; }

.weight_400 { font-weight: 400 !important; }
.weight_500 { font-weight: 500 !important; }
.weight_600 { font-weight: 600 !important; }
.weight_700 { font-weight: 700 !important; }
.weight_800 { font-weight: 800 !important; }
.weight_900 { font-weight: 900 !important; }
.weight_400-force { font-weight: 400 !important; }
.weight_500-force { font-weight: 500 !important; }
.weight_600-force { font-weight: 600 !important; }
.weight_700-force { font-weight: 700 !important; }
.weight_800-force { font-weight: 800 !important; }
.weight_900-force { font-weight: 900 !important; }
.weight_400-force-childs > * { font-weight: 400 !important; }
.weight_500-force-childs > * { font-weight: 500 !important; }
.weight_600-force-childs > * { font-weight: 600 !important; }
.weight_700-force-childs > * { font-weight: 700 !important; }
.weight_800-force-childs > * { font-weight: 800 !important; }
.weight_900-force-childs > * { font-weight: 900 !important; }







.bg-wht-txt-red { background-color: #fff; color: #ec1717; border: solid 1px #ec1717; transition: all linear 0.24s; }
.bg-wht-txt-red:hover { background-color: #ec1717; color: #fff !important; border: solid 1px #ec1717 !important;}

.bg-wht-txt-grnd { background-color: #fff; color: #559928; border: solid 1px #559928; transition: all linear 0.24s; }
.bg-wht-txt-grnd:hover { background-color: #559928; color: #fff !important; border: solid 1px #559928 !important;}


.bg-blue-txt-wht { background-color: #3b7ec4; color: #fff; transition: all linear 0.24s; }
.bg-blue-txt-wht:hover { background-color: #fff; color: #3b7ec4; border: solid 1px #3b7ec4;}


.bg-wht-txt-blue { background-color: #fff; color: #3b7ec4; border: solid 1px #3b7ec4; transition: all linear 0.24s; }
.bg-wht-txt-blue:hover { background-color: #3b7ec4 !important; color: #fff !important; border: solid 1px #3b7ec4;}

.bg-red-txt-wht { background-color: #ec1717; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
.bg-red-txt-wht:hover { background-color: #fff !important; color: #ec1717 !important; border: solid 1px #ec1717 !important;}

.bg-dk-grn-txt-wht { background-color: #559928; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
.bg-dk-grn-txt-wht:hover { background-color: #fff !important; color: #559928 !important; border: solid 1px #559928 !important;}


.bg-lt-grn-txt-wht { background-color: #559928; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
.bg-lt-grn-txt-wht:hover { background-color: #fff !important; color: #9dcd00 !important; border: solid 1px #9dcd00 !important;}


.bg-orange-txt-wht { background-color: #f08a06; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
.bg-orange-txt-wht:hover { background-color: #fff !important; color: #f08a06 !important; border: solid 1px #f08a06 !important;}


.bg-orange_red-txt-wht { background-color: #ff5722; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
.bg-orange_red-txt-wht:hover { background-color: #fff !important; color: #ff5722 !important; border: solid 1px #ff5722 !important;}





button.bg-wht-txt-red { background-color: #fff; color: #ec1717; border: solid 1px #ec1717; transition: all linear 0.24s; }
button.bg-wht-txt-red:hover { background-color: #ec1717; color: #fff !important; border: solid 1px #ec1717 !important;}

button.bg-wht-txt-grnd { background-color: #fff; color: #559928; border: solid 1px #559928; transition: all linear 0.24s; }
button.bg-wht-txt-grnd:hover { background-color: #559928; color: #fff !important; border: solid 1px #559928 !important;}


button.bg-blue-txt-wht { background-color: #3b7ec4; color: #fff; transition: all linear 0.24s; }
button.bg-blue-txt-wht:hover { background-color: #fff; color: #3b7ec4; border: solid 1px #3b7ec4;}

button.bg-red-txt-wht { background-color: #ec1717; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
button.bg-red-txt-wht:hover { background-color: #fff !important; color: #ec1717 !important; border: solid 1px #ec1717 !important;}

button.bg-dk-grn-txt-wht { background-color: #559928; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s;}
button.bg-dk-grn-txt-wht:hover { background-color: #fff !important; color: #559928 !important; border: solid 1px #559928 !important;}

button.bg-lt-grn-txt-wht { background-color: #9dcd00; color: #fff; border: solid 1px transparent !important;transition: all linear 0.24s;}
button.bg-lt-grn-txt-wht:hover { background-color: #fff !important; color: #9dcd00 !important; border: solid 1px #9dcd00 !important;}


button.bg-orange-txt-wht { background-color: #f08a06; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
button.bg-orange-txt-wht:hover { background-color: #fff !important; color: #f08a06 !important; border: solid 1px #f08a06 !important;}

button.bg-orange_red-txt-wht { background-color: #ff5722; color: #fff; border: solid 1px transparent !important; transition: all linear 0.24s; }
button.bg-orange_red-txt-wht:hover { background-color: #fff !important; color: #ff5722 !important; border: solid 1px #ff5722 !important;}


button.clean_ { border: 0px; background-color: transparent; color: inherit; border-color: transparent;transition: all linear 0.24s;}
button.clean_:hover { border: 0px !important; background-color: transparent !important; color: #242424; border-color: transparent;}
button.clean_:hover * { color: #242424; }






.mr-14_ { margin-right: 14px;}
.mb-0_ { margin-bottom: 0px; }

.p2-4_ { padding: 2px 4px; }
.pa-0_ { padding: 0px;}
.pa-14_ { padding: 14px; }


.wd-1p{width:1%;}.wd-2p{width:2%;}.wd-3p{width:3%;}.wd-4p{width:4%;}.wd-5p{width:5%;}.wd-6p{width:6%;}.wd-7p{width:7%;}
.wd-8p{width:8%;}.wd-9p{width:9%;}.wd-10p{width:10%;}.wd-11p{width:11%;}.wd-12p{width:12%;}.wd-13p{width:13%;}.wd-14p{width:14%;}
.wd-15p{width:15%;}.wd-16p{width:16%;}.wd-17p{width:17%;}.wd-18p{width:18%;}.wd-19p{width:19%;}.wd-20p{width:20%;}.wd-21p{width:21%;}
.wd-22p{width:22%;}.wd-23p{width:23%;}.wd-24p{width:24%;}.wd-25p{width:25%;}.wd-26p{width:26%;}.wd-27p{width:27%;}.wd-28p{width:28%;}
.wd-29p{width:29%;}.wd-30p{width:30%;}.wd-31p{width:31%;}.wd-32p{width:32%;}.wd-33p{width:33%;}.wd-34p{width:34%;}.wd-35p{width:35%;}
.wd-36p{width:36%;}.wd-37p{width:37%;}.wd-38p{width:38%;}.wd-39p{width:39%;}.wd-40p{width:40%;}.wd-41p{width:41%;}.wd-42p{width:42%;}
.wd-43p{width:43%;}.wd-44p{width:44%;}.wd-45p{width:45%;}.wd-46p{width:46%;}.wd-47p{width:47%;}.wd-48p{width:48%;}.wd-49p{width:49%;}
.wd-50p{width:50%;}.wd-51p{width:51%;}.wd-52p{width:52%;}.wd-53p{width:53%;}.wd-54p{width:54%;}.wd-55p{width:55%;}.wd-56p{width:56%;}
.wd-57p{width:57%;}.wd-58p{width:58%;}.wd-59p{width:59%;}.wd-60p{width:60%;}.wd-61p{width:61%;}.wd-62p{width:62%;}.wd-63p{width:63%;}
.wd-64p{width:64%;}.wd-65p{width:65%;}.wd-66p{width:66%;}.wd-67p{width:67%;}.wd-68p{width:68%;}.wd-69p{width:69%;}.wd-70p{width:70%;}
.wd-71p{width:71%;}.wd-72p{width:72%;}.wd-73p{width:73%;}.wd-74p{width:74%;}.wd-75p{width:75%;}.wd-76p{width:76%;}.wd-77p{width:77%;}
.wd-78p{width:78%;}.wd-79p{width:79%;}.wd-80p{width:80%;}.wd-81p{width:81%;}.wd-82p{width:82%;}.wd-83p{width:83%;}.wd-84p{width:84%;}
.wd-85p{width:85%;}.wd-86p{width:86%;}.wd-87p{width:87%;}.wd-88p{width:88%;}.wd-89p{width:89%;}.wd-90p{width:90%;}.wd-91p{width:91%;}
.wd-92p{width:92%;}.wd-93p{width:93%;}.wd-94p{width:94%;}.wd-95p{width:95%;}.wd-96p{width:96%;}.wd-97p{width:97%;}.wd-98p{width:98%;}
.wd-99p{width:99%;}.wd-100p{width:100%;}

.br-rds-1 { border-radius: 1px; }
.br-rds-2 { border-radius: 2px; }
.br-rds-3 { border-radius: 3px; }
.br-rds-4 { border-radius: 4px; }
.br-rds-5 { border-radius: 5px; }
.br-rds-6 { border-radius: 6px; }
.br-rds-7 { border-radius: 7px; }
.br-rds-8 { border-radius: 8px; }
.br-rds-9 { border-radius: 9px; }
.br-rds-10 { border-radius: 10px; }
.br-rds-11 { border-radius: 11px; }
.br-rds-12 { border-radius: 12px; }
.br-rds-13 { border-radius: 13px; }
.br-rds-24 { border-radius: 24px; }
.br-rds-50p { border-radius: 50%; }


.content-header { display: -ms-flexbox; display: flex; -ms-flex-align: start; align-items: flex-start;
    -ms-flex-pack: justify; justify-content: space-between; border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(.3rem - 1px); border-top-right-radius: calc(.3rem - 1px);
        background-color: #3b7ec4; color: #fff; padding: 0.3rem 1rem; font-size: 20px;
}
.content-body { position: relative; -ms-flex: 1 1 auto; flex: 1 1 auto; }


/*===============================================WEBSITE FORM STYLES STARTs=============================================================*/

.compliance-form_ {  }
.compliance-form_ label { margin-bottom: 4px; }
.compliance-form_ input { border: solid 1px #3b7ec4; border-radius: 6px; font-size: 14px; padding: 6px;height: 31px;}
.compliance-form_ select { border: solid 1px #3b7ec4; border-radius: 6px; font-size: 14px; padding: 6px; padding: 4.5px 6px; height: 31px; line-height: 30px;}
.compliance-form_ textarea { border: solid 1px #3b7ec4; border-radius: 6px; font-size: 14px; padding: 6px;}

.compliance-form_ select.custom-select-arrow {border: solid 1px #3b7ec4; border-radius: 6px;font-size: 14px;padding: 6px;padding: 4.5px 6px;height: 31px;line-height: 30px;padding-right: 27px;-webkit-appearance: textfield;-webkit-appearance: unset;padding: 0px;padding-right: 18px;margin-bottom: 7px;padding-left: 4px; position: relative; z-index: 40; background-color: transparent;}
.compliance-form_ select.custom-select-arrow + .fa { position: absolute;top: 29px;right: 6px; z-index:20;}
.compliance-form_ select.custom-select-arrow[disp=yes] + .fa { display: inline-block !important; z-index:20;}

.compliance-form_ select.custom-select-arrow[disp=yes] + .fa { display: inline-block !important; z-index:20;}
.compliance-form_ select.custom-select-arrow[disp=yes] + select#number_of_days + .fa { display: inline-block !important; z-index:20;}
.compliance-form_ input[type="file"] {height: 30px; padding: 3px; }

.compliance-form_ .form-control,
.compliance-form_ .form-control:focus { background-color: #fff !important; border-color: #3e7bc4;}

.compliance-form_ input[disabled],
.compliance-form_ select[disabled],
.compliance-form_ textarea[disabled] { background-color: rgb(235, 235, 228) !important; }

.compliance-drug-form_ {  }
.compliance-drug-form_ label { margin-bottom: 0px; }
.compliance-drug-form_ .field label { text-align: center; margin-bottom: 0px; display: flex; justify-content: center; align-items: center; vertical-align: middle; font-size: 12px; font-size: 11px; }
.compliance-drug-form_ input:not([type="radio"]) { border: 0px; border-radius: 0px; font-size: 14px; padding: 3px 4px;line-height: 1.3em; height: 24px;font-weight:bold;}
.compliance-drug-form_ select { border: 0px; border-radius: 0px; font-size: 14px; padding: 3px 4px; line-height: 1.3em; height: 24px;}
.compliance-drug-form_ .field  input:not([type="radio"]) { border: solid 1px #999; }
.compliance-drug-form_ .field  select { border: solid 1px #999; }
.compliance-drug-form_ .field  textarea { border: solid 1px #999; }
.compliance-drug-form_ .field-nb { border: 0px; }


.compliance-drug-form_ .radio-field { /*display: flex; justify-content: flex-end; flex-wrap: wrap;*/ }
.compliance-drug-form_ .radio-field .radio-field-option { text-align: right; min-width:100%;}
.compliance-drug-form_ .radio-field .radio-field-option label {  }
.compliance-drug-form_ .radio-field .radio-field-option label input[type="radio"] { float: right; margin-left: 4px; margin-top: 3px;}
.compliance-drug-form_ .radio-field .radio-field-option label span { line-height: 1.47em; font-weight: 600;}

.flds-qt-ds-rr-ric-pop-pp-pi-aa .field > label { height: 40px; height: 3em; }

.compliance-drug-form_ button.drg-cln-adv { padding: 4px 14px; border: solid 1px #999; border-radius: 3px; background-color: #fff; }
.compliance-drug-form_ button.patient-message { padding: 4px 14px; border: solid 1px #999; border-radius: 3px; background-color: #fff;}
.compliance-drug-form_ button.drg-cln-adv:hover { border: solid 1px #ec1717 !important; }
.compliance-drug-form_ button.patient-message:hover { border: solid 1px #9bc90d !important; }
.compliance-drug-form_ button.clear-form { padding: 4px 14px; border-radius: 24px; }
.compliance-drug-form_ button.submit-form { padding: 6px 14px; border-radius: 24px; }


.compliance-drug-form_ {  }
.compliance-drug-form_ label { text-align: left !important; }
.compliance-drug-form_ .flds-rs_sl-rs_prf .fld-rx_sell input { border: 0px !important; }
.compliance-drug-form_ .flds-rs_sl-rs_prf .fld-rx_profit input { border: 0px !important; }


.compliance-drug-form_ .flds-str-df-br {  }
.compliance-drug-form_ .flds-str-df-br .fld-brand_ref {  }
.compliance-drug-form_ .flds-str-df-br .fld-brand_ref label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500; }
.compliance-drug-form_ .flds-str-df-br .fld-brand_ref input { bordeR: 0px; }

.compliance-drug-form_ .fld-brand_ref label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500; }
.compliance-drug-form_ .fld-brand_ref input { border: 0px !important; }

.compliance-drug-form_ .fld-rx_sell label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500; }
.compliance-drug-form_ .fld-rx_sell input { border: 0px !important; }

.compliance-drug-form_ .fld-rx_profit label { color: #242424 !important;background-color: transparent;text-align: left !important;justify-content: flex-start;font-weight: 500;     color: #9bc90d !important}
.compliance-drug-form_ .fld-rx_profit input { border: 0px !important;  }

.compliance-drug-form_ .fld-rx-ingr-cost label { color: #ec1717 !important; border: solid 1px #ec1717 !important;  background-color: transparent !important; }
.compliance-drug-form_ .fld-rx-ingr-cost input { border: solid 1px #ec1717 !important; color: #ec1717 !important; border-top: 0px !important;}

.compliance-drug-form_ .fld-thrd-party-pay label { color: #242424 !important;border: solid 1px #999 !important;  background-color: transparent !important;}
.compliance-drug-form_ .fld-thrd-party-pay input { border-top: 0px !important; }


.compliance-drug-form_ .fld-patient-out-pocket label { color: #242424 !important;border: solid 1px #999 !important; background-color: transparent !important;}
.compliance-drug-form_ .fld-patient-out-pocket input { border-top: 0px !important;  }

.compliance-drug-form_ .flds-qt-ds-rr-ric-3pp-pc-rx_sl-rx_pr label { text-align: center !important; justify-content: center !important; }

/*===============================================WEBSITE FORM STYLES ENDs=============================================================*/
* { -webkit-print-color-adjust: exact; }

</style>








<div class="elm-center cnt-center wd-87p " style="max-width: 700px;" >
      
  
        <!-- Content Header -->
        <div class="content-header pos-rel_">
  
          <div class="trow c-dib_ "><h4 class="content-title fs-16 p2-4_ mr-14_ mb-0_">Order Status Update</h4>
          <span class="mt-2_" id="orderstatusname" style="
              background-color: #559928;
              padding: 2px 4px;
              border-radius: 24px;
              min-width: 60px;
              text-align: center;
              padding-top: 3px;
          ">{{$order->Status_Name}}</span></div>
        </div>
  
        <!-- Modal body -->
        <div class="content-body cnt-left pa-0_">
          <div class="row mr-0 ml-0">
            <div class="col-sm-12 pl-0 pr-0 compliance-drug-form_">
                
            <div class="trow_ pa-14_ c-dib_ bg-yellow-lt cnt-left">
                <div class="txt-black-24 weight_600 mr-4_ tt_uc_">{{$order->FirstName.' '.$order->LastName}}</div>
                <div class="gender txt-blue weight_600">({{$order->Gender}})</div>
                <div class="gender txt-blue weight_600">-</div>
                <div class="gender txt-blue weight_600">DOB: {{$order->BirthDate}}</div>
                <div class="gender txt-blue weight_600">-</div>
                <div class="gender txt-blue weight_600">Ph: {{preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', 
                    '($1) $2-$3'." \n", $order->MobileNumber)}}</div>
            </div>
            
            <form class="pa-14_ bg-gray-e compliance-drug-form_ mb-0_" id="orderUpdateData" autocomplete="off" novalidate="novalidate">
                    <div class="flx-justify-start flds_rxn-orxd-ph_txt-ndb mb-14_">
                        <div class="field fld-rx_number mr-1p" style="width: 130px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 cnt-left mb-0_">Rx No.</label>
                        <input class="wd-100p tt_uc_ cnt-right" id="rx_no" autocomplete="off" onkeypress="return blockSpecialChar(event)" type="text" name="RxNumber" value="{{$order->RxNumber}}" placeholder="-" minlength="5" maxlength="15" required="" disabled="" >
                        </div>
                        <div class="field fld-original_rx mr-1p pos-rel_" style="background-color: #fff; width:130px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">ORIGINAL Rx DATE</label>
                            <input class="wd-100p" id="datetimepicker" data-type="rem-dis" name="RxOrigDate" type="text" placeholder="MM/DD/YYYY" maxlength="10" mask="99/99/9999" value="{{Carbon\Carbon::parse($order->RxOrigDate)->format('m-d-Y')}}" onblur="window.pharmacyNotification.calculateNextRefillDate(this.value);" required="" autocomplete="off" style="padding-right: 27px; background-color: transparent; position: relative; z-index:100;" disabled>
                            <span class="fa fa-calendar" style="position: absolute;top: 25px;right: 9px;z-index:40;"></span>
                        </div>
                        <div class="flds-ph_name-add_button pos-rel_" style="display:flex;align-items: center;">
                            <span class="wd-100p olympus_phar-txt fs-16 weight_600 cnt-right tt_uc_" id="pharmacy-txt">{{$order->practice_name}}</span>
                        </div>
                        <div style="display: flex; align-items: center">
                            <button class="btn bg-blue-txt-wht field fld-add_drug tt_uc_" type="button" id="drug_button" style="margin-left: 14px;border-radius: 24px;padding: 2px 10px; width: 120px; height: 30px; display:none;" onclick="showDrug()">add new drug</button>
                        </div>
                         <div style="display: flex; justify-content: flex-start; align-items: center; margin-left: auto;">
                            <div class="ml-14_" id="print_button" style="display: none;">
                                <button class="weight_500 tt_uc_ mr-4_ br-rds-13 bg-wht-txt-grnd status-btn pa1-8_" type="button" style="width: 80px;padding: 4px 8px;">Print</button>
                            </div>
                            <div class="ml-14_ reporter_prescription" id="cancel_button" style="display: none;">
                                <button class="weight_500 tt_uc_ mr-4_ br-rds-13 bg-wht-txt-red status-btn pa1-8_" dis-status="[1,27]" type="button" onclick="validateCancelRequest();" style="width: 80px;padding: 4px 8px;">Cancel</button>
                             </div>
                        </div>
                    </div>
  
                    <div class="flx-justify-start flds-rxl_ndc-mrkt mb-14_">
                        <div class="wd-49p field fld-rx_label_ndc mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">Rx LABEL NAME OR NDC #</label>
                            <input class="wd-100p" id="drug" placeholder="Please Search Medicine" type="text" autocomplete="foo" onkeypress="return blockSpecialChar(event)" name="DrugName" value="{{$order->rx_label_name}}" required="" disabled="" disabled>
                                             </div>
                        <div class="wd-50p field fld-marketer" id="select_product_marketer">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">PRODUCT MANUFACTURER</label>
                                                 <!--  <select class="wd-100p" placeholder="-" id="product_marketer" name="marketer" value="" required="">
      
                            </select> -->
                            <input class="wd-100p" type="text" name="marketer" value="{{$order->marketer}}" id="product_marketer" disabled="" disabled>
                                              </div>
                    </div>
      
      
                    <div class="flx-justify-start flds-str-df-br mb-14_">
                        <div class="wd-33p field fld-strength mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">STRENGTH</label>
                            
                                                  <div id="strengthFieldId">
                                                  	<input type="text" name="Strength" id="Strength" class="form-control" value="{{$order->Strength}}" placeholder="-" disabled></div>
                                              </div>
                        <div class="wd-32p field fld-dosage_from mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 fs-f10_ cnt-left mb-0_">DOSAGE FORM</label>
                            <input class="wd-100p" type="text" name="DrugType" readonly="" id="PackingDescr" value="{{$order->DrugType}}" placeholder="-" disabled>
                        </div>
                        <div class="wd-33p field fld-brand_ref">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ cnt-left mb-0_">Brand Reference</label>
                            <input class="wd-100p txt-red" type="text" name="BrandReference" readonly="" id="brandReference" value="{{$order->BrandReference}}" placeholder="-" disabled>
                        </div>
                    </div>
      
      
                    <div class="flx-justify-start flds-qt-ds-rr-ric-pop-pp-pi-aa flds-qt-ds-rr-ric-3pp-pc-rx_sl-rx_pr mb-14_">
                        <div class="field fld-qty mr-1p" style="width:76px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">QTY</label>
                            <input class="wd-100p cnt-right" type="text" data-type="rem-dis" name="Quantity" minlength="1" onkeypress="return numericOnly(event,8)" value="{{$order->Quantity}}" placeholder="-" id="quantity" required="" disabled>
                        </div>
                        <div class="wd-10p field fld-days-supply mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">Days Supply</label>
                            <input class="wd-100p cnt-right" min="1" data-type="rem-dis" name="DaysSupply" value="{{$order->DaysSupply}}" placeholder="-" onkeypress="return numericOnly(event,3)" id="daysSupplyFld" maxlength="3" minlength="1" onkeyup="window.pharmacyNotification.calculateNextRefillDate($('#datetimepicker').val());" required="" disabled>
                        </div>
                        <div class="wd-12p field fld-refills-remain mr-1p" style="width: 60px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">REFILLS REMAIN</label>
                            <input class="wd-100p cnt-right" type="text" onkeypress="return IsDigit(event)" maxlength="2" minlength="1" name="RefillsRemaining" value="{{$order->RefillsRemaining}}" placeholder="-" required="" disabled>
                        </div>
                        <div class="wd-13p field fld-rx-ingr-cost  mr-1p highlight-red " style="box-shadow: -3px 1px 13px 3px #ffeb3b;width: 76px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">Rx INGR COST</label>
      
                            <input class="wd-100p cnt-right" name="RxIngredientPrice" data-type="currency" onkeypress="return IsDigit(event)" type="text" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" value="${{$order->RxIngredientPrice}}" placeholder="$0.00" id="drugPrice" required="" maxlength="10" disabled>
                        </div>
                        <div class="wd-16p field fld-thrd-party-pay mr-1p" style="box-shadow: -3px 1px 13px 3px #ffeb3b;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ fs-f10_ mb-0_">3<sup class="fs-f11_">rd</sup>&nbsp;PARTY PAID</label>
                            <input class="wd-100p cnt-right" data-type="currency" type="text" id="thirdPartyPaid" name="RxThirdPartyPay" placeholder="$0.00" value="${{$order->RxThirdPartyPay}}" onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" required="" maxlength="10" disabled>
                        </div>
                        <div class="wd-14p field fld-patient-out-pocket mr-1p" style="box-shadow: -3px 1px 13px 3px #ffeb3b;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">PATIENT OUT OF POCKET</label>
                            <input class="wd-100p cnt-right" type="text" data-type="currency" name="RxPatientOutOfPocket" placeholder="$0.00" value="${{$order->RxPatientOutOfPocket}}" id="pocketOut" onkeypress="return IsDigit(event)" onblur="window.pharmacyNotification.calculateRxProfitability(this.value);" required="" maxlength="10" disabled>
                        </div>
      
                        <input type="hidden" name="InsuranceType" value="Cash">
                        
                        <div class="wd-13p field fld-assist-auth mr-1p" style="box-shadow: 0px 1px 13px 3px #ffeb3b;width: 90px;">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ fs-f10_ mb-0_">ASSISTANCE AUTHORIZED</label>
                            <input class="wd-100p cnt-right" data-type="currency" name="asistantAuth" minlength="1" type="text" value="${{$order->asistantAuth}}" placeholder="$0.00" maxlength="10" onblur="window.pharmacyNotification.calculateRxProfitability($('#pocketOut').val());" disabled>
                        </div>
                        
                       <!--  <div class="wd-14p field fld-rx_sell mr-1p">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ mb-0_">Rx Selling </label>
                            <input class="wd-100p cnt-right" type="text" name="RxSelling" id="RxSelling" value="" onblur="window.pharmacyNotification.calculateProfitabilityWithSelling(this.value);" placeholder="-" maxlength="11">
                        </div>
                        <div class="wd-14p field fld-rx_profit">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_nc_ mb-0_">Rx Profitability </label>
                            <input class="wd-100p cnt-right txt-red" type="text" name="RxProfitability" readonly="" id="rxProfitability" value="" placeholder="-" maxlength="13">
                        </div> -->
                        
                    </div>
      
                    
      
      
      
                    <div class="flx-justify-start mb-14_ prescriber_buttons">
                        <div class="wd-33p field fld-pres_name">
                            <label class="wd-100p pa-4_ txt-wht bg-gray-57 tt_uc_ cnt-left mb-0_">Prescriber Name </label>
                            <input type="hidden" name="prescriber_id" value="243">
                            <input class="wd-100p" type="text" id="basicAutoSelect" disabled data-type="rem-dis" name="PrescriberName" placeholder="Search Prescriber" value="{{$order->prescriber??''}}" autocomplete="off" required="">
                        </div>
                        
                        <div id="barcode" style="margin-left: auto; max-height: 46px; margin-right: 5px;align-self: center;">
                        	{!!$barCode!!}
</div>
                        <div id="barcode1" style="margin-bottom: 10px; max-height: 46px;">
                {!!$barCode1!!}
</div>
                        
                    </div>
      
                    
                  
                    
             
                      <input type="hidden" id="pat_mobile" value="1234500000">
      
                </form><div class="trow_ pa-14_ cnt-center c-dib_ bg-tb-pink">
    <div class="txt-red tt_uc_ weight_600 mr-4_">commercial insurance ({{$order->InsuranceType == 'Cash'?'SELF PAY':'PRIVATE PAY'}})</div>
</div><div class="trow_ pa-14_ cnt-center c-dib_ bg-gray-e">
    <div class="txt-red tt_uc_ weight_600 mr-4_">assistance authorized:</div><div class="txt-red fs-10_ weight_600" style="
">$</div>
<div class="txt-red tt_uc_ weight_600 mr-4_">{{$order->asistantAuth}}</div>
</div>
            </div>
          </div>
        </div>
  
        <!-- Content footer -->
        
  
      
    </div>



