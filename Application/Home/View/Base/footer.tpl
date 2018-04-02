<hr>
<div id="footer" style="clear:both;display:block">
    <div class="container-fluid footer">
        <div class="row">
            <div class="col-md-12 text-center">
                &copy2016 -
                <script>
                    document.write(new Date().getFullYear());
                </script>&nbsp;一鑫教育咨询有限公司
                <br/>
                <small><span style="color:#888">技术支持：梦云智</span></small>
            </div>
        </div>
    </div>
    <block name="footer">
        <script src="__BOW__/bootstrap/dist/js/bootstrap.min.js"></script>
        <!--uploadify-->
        <js href="__ROOT__/lib/uploadify/jquery.uploadify.min.js" />
        <!--yunzhijs-->
        <js href="__ROOT__/yunzhi.php/javascript/js.html" />
        <!-- datetimepicker -->
        <js href="__BOW__/datatimepicker/bootstrap-datetimepicker.js" />
        <js href="__BOW__/datatimepicker/bootstrap-datetimepicker.zh-CN.js" />
        <link href="__BOW__/datatimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />

        <!--nganimate https://github.com/Augus/ngAnimate-->
        <link href="__ROOT__/lib/ngAnimate-master/css/ng-animation.css" rel="stylesheet" />

        <block name="footJs">
        </block>
    </block>
    <script type="text/javascript">
    if (typeof(app) == 'object')
    {
        // 定制由星级数显示星星的fliter
        app.filter("starFormat", function($sce) {
            return function(input) {
                var html = "";
                for (i = 0; i < 5; i++) {
                    if (i > input) {
                        html += '<i class="fa fa-star-o"></i>';
                    } else {
                        html += '<i class="fa fa-star"></i>';
                    }
                }
                return $sce.trustAsHtml(html);
            };
        });
    }
    </script>
</div>
