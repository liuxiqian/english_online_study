<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>reorder</title>
</head>
<body>
<form action="" method="get">
    <php>$courseId = I('get.courseId'); </php>
    课程：
    <select name="courseId">
        <foreach name="allCourses" item="course">
        <option value="{$course->getId()}" <eq name="course:getId()" value="$courseId">selected="selected"</eq>>
            {$course->getTitle()}
        </option>
        </foreach>
    </select>
    <button>开始整理</button>
</form>

</body>
</html>