<style type="text/css">
#header { background-image:url(__IMG__/bg.png);background-repeat:repeat-x;height:264px; }
#header div img{ width:80%;margin-left:150px;}

#main{ margin-top:-180px }

#main_m{background-color:#FFFFBE;padding:10px; width:75%; height:540px;border:2px solid #dedede;-moz-border-radius: 15px;-webkit-border-radius: 15px;border-radius:15px;  }

#main_m1{ background-image:url(__IMG__/wood.png);border:2px solid;-moz-border-radius:6px;-webkit-border-radius: 6px;border-radius:6px;margin-top:60px;height:405px; }
.title{
    font-family : 方正舒体;
    font-weight: bold;
    font-size : 4em;
    color : #FFFF00;
    padding-top: 1em;
}
.title2{
    font-family : 方正舒体;
    font-weight: bold;
    font-size : 2em;
    color : #FFFF00;
}
.game{
    margin-top: 10px;
}
.word{
    background-color: #FFFFF0;
    border: 1px solid #D2B48C;
    height: 75px;
    padding-top: 30px;
}

    .xc {
    color: #fff;
    padding: 0px;
    border: 1px solid #26DFBE;
    background: #C1F4D8;
    border-radius: 25px;
}
.xc1 {
    color: #fff;
    padding: 0px;
    padding-right: 30px;
    border: 1px solid #26DFBE;
    background: #C1F4D8;
    border-radius: 25px;
}
.tiaozheng {
    margin-top: 15px;
}
.tiaozheng1 {
    margin-top: 8px;
}

/**
 * 图片翻转的css
 */
/* entire container, keeps perspective */
.flip-container {
    perspective: 1000;
}
/* flip the pane when hovered */
.flip-container:hover .flipper .back {
    background-image:url(__IMG__/background.png);
}
.reversal{
transform: rotateY(180deg);
}

.flip-container{
    width: 112%;
    height: 75px;
}

/* flip speed goes here */
.flipper {
    transition: 0.6s;
    transform-style: preserve-3d;

    position: relative;
}

/* hide back of pane during swap */
.front, .back {
    backface-visibility: hidden;

    position: absolute;
    top: 0;
    left: 0;
    
    width: 112%;
    height: 75px;
}
.front{
    left:-15px;
}

/* front pane, placed above back */
.front {
    z-index: 2;
}

/* back, initially hidden pane */
.back {
    transform: rotateY(180deg);
}

.col{
    background-color: #D98022;
}

.load{
    transition: all linear 0.3s;
    z-index: 1040;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
        }

.ng-hide {
   top:-200px;
}

.loader {
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -60px; /* -1 * image width / 2 */
    margin-top: -100px;  /* -1 * image height / 2 */
    display: block;
}

#main_main{background:url(__IMG__/wood.png);border:2px solid;-moz-border-radius:6px;-webkit-border-radius: 6px;border-radius:6px;margin-top:60px;width:600px;height:405px;margin-left:0px;}

#main_main_header{margin-left:-20px;background-color:#FFFFBE;padding:10px; width:75%; height:540px;
 border:2px solid #dedede;-moz-border-radius: 15px;-webkit-border-radius: 15px;border-radius:15px; }
 </style>