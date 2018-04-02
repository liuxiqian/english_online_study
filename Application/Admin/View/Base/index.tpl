<!DOCTYPE html>
<html>

<head>
    <include file="Base/head" />
</head>

<body>
    <block name="main">
        <div id="main">
            {$YZ_TEMPLATE_NAV}
            <include file="Base/body" />
            <div id="footer" style="clear:both;display:block">
                <block name="footer">
                    <p>
                        <span style="text-align:left;float:left">&nbsp;一鑫教育信息咨询有限公司版权所有&nbsp;©&nbsp;2016-
                    <script>
                    document.write(new Date().getFullYear());
                    </script>
                    </p>
                </block>
            </div>
        </div>
        <!--/#wrapper-->
        <include file="Base/footer" />
    </block>
</body>

</html>
