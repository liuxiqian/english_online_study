<style>
    .studyInfo {
        height:100px;
        line-height:100px;
    }
/*Main style*/
.list-quotes {
    cursor: pointer;
    height: auto;
    margin-bottom: 30px;
    overflow: hidden;
    position: relative;
    display: block;
}
.list-quotes img,
.list-quotes h1 {
    -webkit-transition: -webkit-transform 0.35s;
    transition: transform 0.35s;
}
.list-quotes img {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
}
.list-quotes h1{
    background: rgba(20,31,44,0.8);
    bottom: 30px;
    float: right;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    padding: 15px;
    position: absolute;
    margin: 0;
}

.list-quotes p {
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    margin: 0;
    padding: 10px;
    opacity: 0;
    -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
    transition: opacity 0.35s, transform 0.35s;
    -webkit-transform: translate3d(0,50px,0);
    transform: translate3d(0,50px,0);
    font-size: 15px;
    font-weight: normal;
    background: rgba(51,153,153,0.8);
    width: 100%;
    color: #fff;
}
.list-quotes:hover img {
    -webkit-transform: translate3d(0,-80px,0);
    transform: scale(1.2);
    transition: all 250ms ease;
}
.list-quotes:hover{
    box-shadow: 0 0 5px 2px rgba(51,153,153, 0.5);
}
.list-quotes:hover h1 {
    -webkit-transform: translate3d(0,-100px,0);
    transform: translate3d(0,-100px,0);
    text-shadow: 0px 0 15px #fff;
    transition: all 250ms ease;
}
.list-quotes:hover p {
    opacity: 1;
    -webkit-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
}
.quotes span{
    color:#222;
    font-weight: bold;
    text-transform: capitalize;
    color: #fff;
}
</style>