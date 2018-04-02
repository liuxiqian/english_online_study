<?php
    // 增加随机显示效果:https://github.com/Augus/ngAnimate
    $cssArray = array(
        "toggle",
        "spin-toggle",
        "slide-left",
        "slide-right",
        "slide-top",
        "slide-down",
        "bouncy-slide-left",
        "bouncy-slide-right",
        "bouncy-slide-top",
        "bouncy-slide-down",
        "scale-fade",
        "scale-fade-in",
        "bouncy-scale-in",
        "flip-in",
        "rotate-in"
    );
    
    $cssIndex = array_rand($cssArray);
    $animateCss = $cssArray[$cssIndex];
?>
<div ng-show="relationPicture" class="relationPicture check-element {$animateCss}">
    <ul>
        <li ng-repeat="extend in word.extends">
            <h4>{{extend.WordNature.title}}</h4>
            <ul>
                <li ng-repeat="wordWordNature in extend.WordWordNatures">
                    <p uib-popover="{{wordWordNature.explain}}" popover-placement="left" popover-trigger="mouseenter">{{wordWordNature.title}}</p>
                </li>
            </ul>
        </li>
    </ul>
</div>
